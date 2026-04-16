<?php

namespace App\Controllers;

use App\Models\Session;
use App\Models\Reservation;
use App\Models\CafTable;
use App\Models\Game;

class DashboardController
{
    private Session $sessionModel;
    private Reservation $reservationModel;
    private Table $tableModel;
    private Game $gameModel;

    public function __construct()
    {
        $this->sessionModel     = new Session();
        $this->reservationModel = new Reservation();
        $this->tableModel       = new Table();
        $this->gameModel        = new Game();
    }

    // Admin Dashboard
    public function index(): void
    {
        if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /');
            exit;
        }

        //Get active sessions 
        $activeSessions = $this->sessionModel->getActiveSessions();

        //Get today's reservations
        $todayReservations = $this->reservationModel->getToday();

        //Get table status
        $allTables       = $this->tableModel->getAll();
        $availableTables = $this->tableModel->getAvailable();

        //Get stats
        $pendingCount  = $this->reservationModel->countByStatus('pending');
        $confirmedCount = $this->reservationModel->countByStatus('confirmed');
        $availableGames = $this->gameModel->countAvailable();

        //Pass to view
        $pageTitle = "Admin Dashboard";
        include __DIR__ . '/../Views/dashboard/index.php';
    }
}