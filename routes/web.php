<?php

use Slim\App;
use App\Controllers\BookingController;
use App\Controllers\UserController;
use App\Controllers\CustomerController;
use Slim\Psr7\Response;

// bring $pdo into this scope
require __DIR__ . '/../src/Services/conn.php';



return function (App $app, PDO $pdo) {

    $authMiddleware = function($request, $handler) {
        if(!isset($_SESSION['userid'])) {
          $response = new Response();
          return $response->withStatus(302)->withHeader('Location', '/cms/login');
        }
        return $handler->handle($request);
    };

    $bookingController = new BookingController($pdo);
    $usersController = new UserController($pdo);
    $customerController = new CustomerController($pdo);
    $app->group('/cms', function ($cms) use ($app, $bookingController, $usersController, $customerController) {
        $cms->get('/', [$bookingController, 'cmsindex']);
        $cms->get('', [$bookingController, 'cmsindex']);
        $cms->get('/bookings', [$bookingController, 'list']);
        $cms->get('/bookings/create', [$bookingController, 'create']);
        $cms->get('/users', [$usersController, 'list']);
        $cms->get('/usered/{id}', [$usersController, 'view']);
        $cms->post('/usered/{id}', [$usersController, 'updateUser']);
        $cms->post('/ajax/workingdays', [$bookingController, 'updateWorkingDays']);
        $cms->post('/ajax/monthselect', [$bookingController, 'updateCalendar']);
        $cms->get('/customers', [$customerController, 'list']);
        $cms->post('/customers', [$customerController, 'list']);
        $cms->get('/logout', [$usersController, 'logout']);
    })->add($authMiddleware);

    $app->group('/cms', function () use ($app, $bookingController, $usersController) {
        $app->get('/cms/login', [$usersController, 'login']);
        $app->post('/cms/login', [$usersController, 'login']);
    });

    $app->group('/', function () use ($app, $bookingController, $customerController) {
        $app->get('/', [$bookingController, 'index']);
        $app->get('/appointments', [$bookingController, 'viewAppointments']);
        $app->get('/register', [$customerController, 'register']);
        $app->post('/register', [$customerController, 'register']);
        $app->get('/login', [$customerController, 'login']);
        $app->post('/login', [$customerController, 'login']);
        $app->get('/logout', [$customerController, 'logout']);
    });


};