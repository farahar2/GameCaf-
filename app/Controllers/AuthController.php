<?php

namespace App\Controllers;

use App\Models\User;

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function showLogin() {
        $error = null;
        require_once __DIR__ . '/../views/auth/login.php';
    }

    // Alias for router
    public function authenticate() {
        $this->login();
    }

    // Alias for router
    public function store() {
        $this->register();
    }

    public function showRegister() {
        $error = null;
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = $_POST['name'] ?? '';
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';
            $phone    = $_POST['phone'] ?? null;

            if (empty($name) || empty($email) || empty($password)) {
                $error = "All required fields must be filled.";
            } elseif ($password !== $confirm) {
                $error = "Passwords do not match.";
            } elseif ($this->userModel->findByEmail($email)) {
                $error = "This email is already in use.";
            } else {
                $success = $this->userModel->register($name, $email, $password, $phone);
                
                if ($success) {
                    // Success message code for the URL
                    header('Location: ' . BASE_URL . '/login?msg=account_created');
                    exit();
                } else {
                    $error = "An error occurred during registration.";
                }
            }
          
            require_once __DIR__ . '/../views/auth/register.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->userModel->login($email, $password)) {
                
                if (session_status() === PHP_SESSION_NONE) session_start();

                $_SESSION['user_id']   = $this->userModel->getId();
                $_SESSION['user_name'] = $this->userModel->getName();
                $_SESSION['user_role'] = $this->userModel->getRole();

                header('Location: ' . BASE_URL . '/');
                exit();
            } else {
                $error = "Invalid email or password.";
                require_once __DIR__ . '/../views/auth/login.php';
            }
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit();
    }
}