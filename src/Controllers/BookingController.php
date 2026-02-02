<?php

namespace App\Controllers;

use App\Services\BookingService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDO;

class BookingController
{
    private BookingService $service;

    // Inject PDO here
    public function __construct(PDO $pdo)
    {
        $this->service = new BookingService($pdo);
    }

    public function index(Request $request, Response $response, $args)
    {
        $response->getBody()->write(
            view::render('home', ['bodyid' => 'home'])
        );
        return $response;
    }

    public function list(Request $request, Response $response, $args)
    {
        $bookings = $this->service->listBookings();
        $response->getBody()->write(
            View::render('cms/bookings', ['bookings' => $bookings, 'bodyid' => 'booking'])
        );
        return $response;
    }
    public function view(Request $request, Response $response, $args)
    {
        $booking = $this->service->listBookings();
        $response->getBody()->write(
            View::render('cms/bookings', ['bookings' => $bookings, 'bodyid' => 'booking'])
        );
        return $response;
    }

    public function create(Request $request, Response $response, $args)
    {
        $name = $request->getQueryParams()['name'] ?? 'Unnamed';
        $booking = $this->service->addBooking($name);
        $response->getBody()->write("Created booking: {$booking->id} - {$booking->name}");
        return $response;
    }
    public function updateWorkingDays(Request $request, Response $response, $args){
        echo '<pre>';
        print_r($request);
        echo '</pre>'; die();
    }
}
