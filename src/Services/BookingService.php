<?php

namespace App\Services;

use App\Models\Booking;

class BookingService
{
    private array $bookings = [];

    public function __construct()
    {
        // Add a default booking
        $this->bookings[] = new Booking(1, 'Test Booking');
    }

    public function listBookings(): array
    {
        return $this->bookings;
    }

    public function addBooking(string $name): Booking
    {
        $id = count($this->bookings) + 1;
        $booking = new Booking($id, $name);
        $this->bookings[] = $booking;
        return $booking;
    }
}
