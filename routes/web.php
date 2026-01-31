<?php

use Slim\App;
use App\Controllers\BookingController;
use App\Controllers\UserController;

// bring $pdo into this scope
require __DIR__ . '/../src/Services/conn.php';

return function (App $app, PDO $pdo) {
    $bookingController = new BookingController($pdo);
    $usersController = new UserController($pdo);

    $app->get('/', [$bookingController, 'index']);
    $app->get('/bookings', [$bookingController, 'list']);
    $app->get('/bookings/create', [$bookingController, 'create']);
    $app->get('/users', [$usersController, 'list']);
};