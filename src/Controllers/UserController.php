<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\UserService;
use PDO;

class UserController
{
    private UserService $userService;
    private string $bodyid;

    public function __construct(PDO $pdo)
    {
        $this->userService = new UserService($pdo);
        $this->bodyid = 'users';
    }

    public function list(Request $request, Response $response, $args)
    {
        $users = $this->userService->listUsers();
        $response->getBody()->write(
            View::render('cms/users', ['users' => $users, 'bodyid' => $this->bodyid], true)
        );
        return $response;
    }
    public function login(Request $request, Response $response, $args)
    {
        $post = $request->getParsedBody();
        if(!isset($post['username']) || empty($post['username'])){
            include __DIR__ . '/../../views/cms/login.php';
            $html = ob_get_clean();
            $response->getBody()->write($html);
            return $response;
        } else {
            if($this->userService->loginUser($post)){
                return $response->withStatus(302)->withHeader('Location', '/cms/');
            } else{
                include __DIR__ . '/../../views/cms/login.php';
                $html = ob_get_clean();
                $response->getBody()->write($html);
                return $response;
            }
//
        }
    }

    public function logout(Request $request, Response $response)
    {
        unset($_SESSION['userid']);
        unset($_SESSION['fname']);
        unset($_SESSION['lname']);
        unset($_SESSION['email']);
        unset($_SESSION['role']);
        return $response->withHeader('Location', '/login')->withStatus(302);

    }

    public function register(Request $request, Response $response, $args)
    {
        $post = $request->getParsedBody();
        $required = ['username', 'password'];
        foreach($required as $field){
            if(!isset($post[$field]) || empty($post[$field])){
                $response->getBody()->write("You have missed required fields.");
            }
        }
        if(!isset($post['username']) || empty($post['username'])){
            $response->getBody()->write(
                View::render('/register', ['bodyid' => $this->bodyid])
            );
            return $response;
        } else {
            if($this->userService->createUser($post)){
                return $response->withStatus(302)->withHeader('Location', '/login');
            } else{
                return $response->withHeader('Location', '/register')->withStatus(302);
            }
//
        }
    }

    public function view(Request $request, Response $response, $args)
    {
        if(!isset($args['id']) || empty($args['id'])){
            return $response->withHeader('Location', '/users')->withStatus(302);
        } else {
            $userData = $this->userService->getUser($args['id']);
            $response->getBody()->write(
                View::render('cms/usered', ['user' => $userData['user'],'dates' => $userData['dates'], 'bodyid' => $this->bodyid], true)
            );
            return $response;
        }
    }

    public function updateUser(Request $request, Response $response, $args)
    {
        if (!isset($args['id']) || empty($args['id'])) {
            // Redirect if no ID
            return $response->withHeader('Location', '/users')->withStatus(302);
        }

        if ($this->userService->updateUser($request->getParsedBody(), $args['id'])) {
            return $this->view($request, $response, ['id' => $args['id']]);
        } else {
            $response->getBody()->write("There was an issue updating this user");
            return $response->withStatus(500);
        }
    }
}