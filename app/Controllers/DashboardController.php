<?php

namespace App\Controllers;

use App\Models\Session;
use App\Models\Reservation;
use App\Models\CafTable;
use App\Models\Game;

class DashboardController
{
    private Session     $sessionModel;
    private Reservation $reservationModel;
    private Table    $tableModel;
    private Game        $gameModel;

    public function __construct()
    {
        $this->sessionModel     = new Session();
        $this->reservationModel = new Reservation();
        $this->tableModel       = new Table();
        $this->gameModel        = new Game();
    }

    // ============================================================
    // Auto-redirect based on role
    // Route: GET /dashboard
    // ============================================================
    public function index(): void
    {
        // Not logged in → go to login
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Redirect based on role
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            header('Location: /dashboard/admin');
        } else {
            header('Location: /dashboard/client');
        }
        exit;
    }

    // ============================================================
    // ADMIN Dashboard
    // Route: GET /dashboard/admin
    // ============================================================
    public function admin(): void
    {
        // Guard: admin only
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /dashboard/client');
            exit;
        }

        try {
            // Active sessions with full details (US10)
            $activeSessions = $this->sessionModel->getActive();

            // Today's reservations (US8)
            $todayReservations = $this->reservationModel->getToday();

            // Tables data
            $allTables       = $this->tableModel->getAll();
            $availableTables = $this->tableModel->getAvailable();

            // Games stats
            $totalGames     = $this->gameModel->countAvailable();
            $availableGames = $this->gameModel->countAvailable();

            // Sessions stats
            $activeCount = $this->sessionModel->countActive();

            // Reservation stats
            $pendingCount   = $this->reservationModel->countByStatus('pending');
            $confirmedCount = $this->reservationModel->countByStatus('confirmed');

        } catch (\Exception $e) {
            // If any query fails, use empty defaults
            error_log("DashboardController::admin() error: " . $e->getMessage());

            $activeSessions    = [];
            $todayReservations = [];
            $allTables         = [];
            $availableTables   = [];
            $totalGames        = 0;
            $availableGames    = 0;
            $activeCount       = 0;
            $pendingCount      = 0;
            $confirmedCount    = 0;
        }

        $pageTitle = "Admin Dashboard — Aji L3bo";
        include __DIR__ . '/../Views/dashboard/admin.php';
    }

    // ============================================================
    // CLIENT Dashboard
    // Route: GET /dashboard/client
    // ============================================================
    public function client(): void
    {
        // Guard: must be logged in
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Admin should not use client dashboard
        if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            header('Location: /dashboard/admin');
            exit;
        }

        try {
            $userId = (int) $_SESSION['user_id'];

            // Client's own reservations (US7)
            $myReservations = $this->reservationModel->getByUser($userId);

            // Available tables for quick info
            $availableTables = $this->tableModel->getAvailable();

            // Total available games
            $totalGames = $this->gameModel->countAvailable();

            // Suggested games (random selection from catalog)
            $allGames       = $this->gameModel->getAll();
            $suggestedGames = array_slice($allGames, 0, 5);

        } catch (\Exception $e) {
            error_log("DashboardController::client() error: " . $e->getMessage());

            $myReservations  = [];
            $availableTables = [];
            $totalGames      = 0;
            $suggestedGames  = [];
        }

        $pageTitle = "Mon Dashboard — Aji L3bo";
        include __DIR__ . '/../Views/dashboard/client.php';
    }
}