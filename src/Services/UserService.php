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
            $users[] = new User($row['userid'], $row['firstname'] ?? '', $row['lastname'] ?? '', $row['created'] ?? '', $row['role'] ?? '', $row['lastupdated'] ?? '');
        }
        return $users;
    }

    public function createUser(array $post){
        $hashedPassword = password_hash($post['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, firstname, lastname, role, created, email)
        VALUES (:username, :password, :firstname, :lastname, 'staff', NOW(), :email)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':username', $post['username'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $post['fname'], PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $post['lastname'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $post['email'], PDO::PARAM_STR);

        $stmt->execute();
    }

    public function getUser($id = 0){
        $stmt = $this->db->prepare("SELECT * FROM users WHERE userid = :userid");
        $stmt->bindParam(':userid', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $user = new User(
                    $result['userid'],
                    $result['firstname'],
                    $result['lastname'],
                    $result['created'] ?? '',
                    $result['role'] ?? '',
                    $result['lastupdated'] ?? date('d/m/y H:i'),
                    $result['username'] ?? '');

        if($user->role == 'barber'){
            $dates = '';
        }
        return ['user' => $user,
                'dates' => $dates];
    }
    public function updateUser($post, $id = 0){

        // Use prepared statements instead of escape_string
        $sql = "UPDATE users 
            SET firstname = :firstname, 
                lastname = :lastname, 
                role = :role, 
                username = :username, 
                lastupdated = NOW() 
            WHERE userid = :userid";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':firstname', $post['firstname'], PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $post['lastname'], PDO::PARAM_STR);
        $stmt->bindParam(':role', $post['role'], PDO::PARAM_STR);
        $stmt->bindParam(':username', $post['username'], PDO::PARAM_STR);
        $stmt->bindParam(':userid', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function loginUser($post){

        $hash = password_hash($post['password'], PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $post['username'], PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($post['password'], $user['password'])) {
            $_SESSION['userid'] = $user['userid'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            return true;
        } else {
            return false;
        }

    }
}