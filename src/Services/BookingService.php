<?php

namespace App\Services;

use App\Models\Booking;
use PDO;

class BookingService
{
    protected PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo; // assign PDO passed from controller
        $this->createTableIfNotExists();
    }

    protected function createTableIfNotExists()
    {
        $sql = "CREATE TABLE IF NOT EXISTS bookings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL
        )";
        $this->db->exec($sql);
    }

    public function listBookings(): array
    {
        $stmt = $this->db->query("SELECT * FROM bookings");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $bookings = [];
        foreach ($rows as $row) {
            $bookings[] = new Booking($row['id'], $row['name']);
        }
        return $bookings;
    }

    public function getBooking($id = 0){
        $sql = $this->db->query("SELECT * FROM bookings WHERE id = :id");
        $restult = $sql->fetch(PDO::FETCH_ASSOC);
        $booking = new Booking($restult['id'], $restult['name']);
        return $booking;
    }

    public function addBooking(string $name): Booking
    {
        $stmt = $this->db->prepare("INSERT INTO bookings (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);
        $id = $this->db->lastInsertId();
        return new Booking((int)$id, $name);
    }
}
