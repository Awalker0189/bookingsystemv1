<?php

namespace App\Services;
use PDO;
use App\Models\User;
class UserService
{
    protected PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo; // assign PDO passed from controller
    }

    public function listUsers(): array
    {
        $stmt = $this->db->query("SELECT * FROM users");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($rows as $row) {
            $users[] = new User($row['userid'], $row['firstname'], $row['created']?? '');
        }
        return $users;
    }
}