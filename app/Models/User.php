<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class User {
    private $db;
    private $id;
    private $name;
    private $email;
    private $phone;
    private $role;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

   
    public function register($name, $email, $password, $phone = null) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, 'client')";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            htmlspecialchars($name),
            filter_var($email, FILTER_SANITIZE_EMAIL),
            $hash,
            htmlspecialchars($phone)
        ]);
    }

    public function login($email, $password) {

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        $userData = $stmt->fetch();

        if ($userData && password_verify($password, $userData['password'])) {
            
            $this->id = $userData['id'];
            $this->name = $userData['name'];
            $this->email = $userData['email'];
            $this->phone = $userData['phone'];
            $this->role = $userData['role'];

            return true; 
        }

        return false; 
    }

    

    public function findByEmail(string $email): array|false {
        $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRole() {
        return $this->role;
    }
}