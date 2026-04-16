<?php

namespace App\Controllers;

use App\Models\Session;

class SessionController {
    private Session $sessionModel;

    public function __construct() {
        $this->sessionModel = new Session();

        // Sécurité obligatoire pour l'Admin
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit();
        }
    }

    //Affiche le Dashboard
    public function dashboard(): void {
        $activeSessions = $this->sessionModel->getActiveSessions();
        $pageTitle = "Dashboard - Sessions Actives";
       require_once __DIR__ . '/../views/sessions/dashboard.php';
    }

    //Traite le lancement d'une session
    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resId   = (int)$_POST['reservation_id'];
            $gameId  = (int)$_POST['game_id'];
            $tableId = (int)$_POST['table_id'];
            $adminId = (int)$_SESSION['user_id'];

            if ($this->sessionModel->start($resId, $gameId, $tableId, $adminId)) {
                header('Location: /admin/sessions?msg=started');
            } else {
                header('Location: /admin/sessions?error=1');
            }
            exit();
        }
    }

    //Clôture la session
    public function stop(int $id): void {
        if ($this->sessionModel->finish($id)) {
            header('Location: /admin/sessions?msg=finished');
        } else {
            header('Location: /admin/sessions?error=stop_failed');
        }
        exit();
    }

    //Affiche l'historique
    public function history(): void {
        $sessions = $this->sessionModel->getHistory();
        $pageTitle = "Historique des Sessions";
        require_once __DIR__ . '/../views/sessions/history.php';
    }
}