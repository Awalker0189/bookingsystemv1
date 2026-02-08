<?php

namespace App\Services;
use PDO;
use App\Models\Customer;
class CustomerService
{
    protected PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo; // assign PDO passed from controller
    }

    public function listCustomers($request): array
    {
        $post = $request->getParsedBody();
        $keywordsql = '';
        if($post['keyword'] != ''){
            $keywordsql = 'AND (firstname LIKE :keyword OR lastname LIKE :keyword OR email = :keyword)';
        }
        $sql = "SELECT * FROM customer_accounts WHERE 1=1 $keywordsql";
        $stmt = $this->db->prepare($sql);
        $keyword = '%'.$post['keyword'].'%';
        if(isset($post['keyword']) && !empty($post['keyword']) != ''){
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        }
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($rows as $row) {
            $users[] = new Customer($row['customerid'], $row['firstname'] ?? '', $row['lastname'] ?? '', $row['created'] ?? '', $row['active'] ?? '', $row['lastupdated'] ?? '');
        }
        return $users;
//        $stmt = $this->db->query("SELECT * FROM customer_accounts WHERE 1=1 $keywordsql");
    }

    public function createCustomer(array $post){
        $hashedPassword = password_hash($post['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO customer_accounts (username, password, firstname, lastname, created, email)
        VALUES (:username, :password, :firstname, :lastname, NOW(), :email)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':username', $post['username'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $post['fname'], PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $post['lastname'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $post['email'], PDO::PARAM_STR);

        $stmt->execute();
    }

    public function getCustomer($id = 0){
        $stmt = $this->db->prepare("SELECT * FROM users WHERE userid = :userid");
        $stmt->bindParam(':userid', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $user = new Customer(
            $result['userid'],
            $result['firstname'],
            $result['lastname'],
            $result['created'] ?? '',
            $result['role'] ?? '',
            $result['lastupdated'] ?? date('d/m/y H:i'),
            $result['username'] ?? '');

//        if($user->role == 'barber'){
        $dates = '';
//        }
        return ['user' => $user,
            'dates' => $dates];
    }
    public function updateCustomer($post, $id = 0){

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

    public function loginCustomer($post){

        $hash = password_hash($post['password'], PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("SELECT * FROM customer_accounts WHERE username = :username");
        $stmt->bindParam(':username', $post['username'], PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($post['password'], $user['password'])) {
            $_SESSION['customerid'] = $user['userid'];
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