<?php

namespace App\Controllers;

use App\Services\BookingService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BookingController
{
    private BookingService $service;

    public function __construct()
    {
        $this->service = new BookingService();
    }

    public function index(Request $request, Response $response, $args)
    {
        $response->getBody()->write("Welcome to the Booking System!");
        return $response;
    }

    public function list(Request $request, Response $response, $args)
    {
        $bookings = $this->service->listBookings();
        ob_start();
        include __DIR__ . '/../../views/bookings.php';
        $response->getBody()->write(ob_get_clean());
        return $response;
    }

    public function create(Request $request, Response $response, $args)
    {
        $name = $request->getQueryParams()['name'] ?? 'Unnamed';
        $booking = $this->service->addBooking($name);
        $response->getBody()->write("Created booking: {$booking->id} - {$booking->name}");
        return $response;
    }
}
