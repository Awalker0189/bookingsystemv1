<?php
// Define a global PDO variable
$host = 'localhost';
$dbname = 'booking';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    echo "DB connection failed: " . $e->getMessage();
    exit;
}