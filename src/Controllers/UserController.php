<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\UserService;
use PDO;

class UserController
{
    private UserService $userService;

    public function __construct(PDO $pdo)
    {
        $this->userService = new UserService($pdo);
    }
    public function list(Request $request, Response $response, $args)
    {
        $users = $this->userService->listUsers();
        $response->getBody()->write(
            View::render('users', ['users' => $users])
        );
        return $response;
    }
}