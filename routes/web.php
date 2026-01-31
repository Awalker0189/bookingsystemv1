<?php

use Slim\App;
use App\Controllers\BookingController;

return function (App $app) {
    $app->get('/', [BookingController::class, 'index']);
    $app->get('/bookings', [BookingController::class, 'list']);
    $app->get('/bookings/create', [BookingController::class, 'create']);
};