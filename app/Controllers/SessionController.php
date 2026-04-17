<?php

namespace App\Controllers;

use App\Models\Session;
use App\Models\Game;
use App\Models\Table;
use App\Models\Reservation;

class SessionController {
    private Session $sessionModel;

    public function __construct() {
        $this->sessionModel = new Session();

        // Sécurité obligatoire pour l'Admin
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: ' . BASE_URL . '/login');
            exit();
        }
    }

    public function dashboard(): void {
        $gameModel        = new Game();
        $tableModel       = new Table();
        $reservationModel = new Reservation();

        $activeSessions   = $this->sessionModel->getActiveSessions();
        $activeCount      = $this->sessionModel->countActive();
        
        $totalGames       = count($gameModel->getAll());
        $allTables        = $tableModel->getAll();
        $availableTables  = $tableModel->getAvailable();
        
        $todayReservations = $reservationModel->getToday();
        $reservationCount  = count($todayReservations);

        $pageTitle = "Dashboard - Sessions Actives";
        require_once __DIR__ . '/../views/sessions/dashboard.php';
    }

    //Affiche le formulaire pour démarrer une session
    public function start(): void {
        $gameModel        = new Game();
        $tableModel       = new Table();
        $reservationModel = new Reservation();

        $games        = $gameModel->getAll();
        $tables       = $tableModel->getAvailable();
        $reservations = $reservationModel->getToday();

        $pageTitle = "Démarrer une Session";
        $errors = [];
        
        if (isset($_GET['error'])) {
            $errors[] = "Erreur lors du lancement de la session.";
        }

        require_once __DIR__ . '/../views/sessions/start.php';
    }

    //Traite le lancement d'une session
    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resId   = (int)$_POST['reservation_id'];
            $gameId  = (int)$_POST['game_id'];
            $tableId = (int)$_POST['table_id'];
            $adminId = (int)$_SESSION['user_id'];

            if ($this->sessionModel->start($resId, $gameId, $tableId, $adminId)) {
                header('Location: ' . BASE_URL . '/sessions?msg=started');
            } else {
                header('Location: ' . BASE_URL . '/sessions?error=1');
            }
            exit();
        }
    }

    //Clôture la session
    public function stop(int $id): void {
        if ($this->sessionModel->finish($id)) {
            header('Location: ' . BASE_URL . '/sessions?msg=finished');
        } else {
            header('Location: ' . BASE_URL . '/sessions?error=stop_failed');
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