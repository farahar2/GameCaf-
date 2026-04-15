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
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    
    public function showRegister() {
        $error = null;
        require_once __DIR__ . '/../Views/auth/register.php';
    }

   
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = $_POST['name'] ?? '';
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';
            $phone    = $_POST['phone'] ?? null;

            if (empty($name) || empty($email) || empty($password)) {
                $error = "Tous les champs obligatoires ne sont pas remplis.";
            } elseif ($password !== $confirm) {
                $error = "Les deux mots de passe sont différents.";
            } elseif ($this->userModel->findByEmail($email)) {
                $error = "Cet email est déjà utilisé.";
            } else {
                $success = $this->userModel->register($name, $email, $password, $phone);
                
                if ($success) {
                    header('Location: index.php?action=login&msg=account_created');
                    exit();
                } else {
                    $error = "Une erreur est survenue lors de l'enregistrement.";
                }
            }
          
            require_once __DIR__ . '/../Views/auth/register.php';
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

                header('Location: index.php?action=home');
                exit();
            } else {
                $error = "Email ou mot de passe incorrect.";
                require_once __DIR__ . '/../Views/auth/login.php';
            }
        }
    }

    
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header('Location: index.php?action=login');
        exit();
    }
}