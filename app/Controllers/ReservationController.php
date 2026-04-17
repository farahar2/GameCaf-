<?php

namespace App\Controllers;

use App\Models\Reservation;
use App\Models\Game;
use App\Models\Table;

class ReservationController
{
    private Reservation $reservationModel;
    private Game $gameModel;
    private Table $tableModel;

    public function __construct()
    {
        $this->reservationModel = new Reservation();
        $this->gameModel        = new Game();
        $this->tableModel       = new Table();
    }

    //Admin - see ALL reservations
    public function index(): void
    {
        $reservations = $this->reservationModel->getAll();
        $pageTitle    = "Toutes les Réservations";
        include __DIR__ . '/../views/reservations/index.php';
    }

    //Admin - see today's reservations
    public function dashboard(): void
    {
        $reservations = $this->reservationModel->getToday();
        $pageTitle    = "Réservations du Jour";
        include __DIR__ . '/../views/reservations/dashboard.php';
    }

    // Client - see MY reservations
    public function myReservations(): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $userId       = $_SESSION['user_id'];
        $reservations = $this->reservationModel->getByUser($userId);
        $pageTitle    = "My Reservations";
        include __DIR__ . '/../views/reservations/my.php';
    }

    //Show booking form
    public function create(): void
    {
        $games     = $this->gameModel->getAll();
        $tables    = $this->tableModel->getAll();
        $pageTitle = "Book a Table";
        include __DIR__ . '/../views/reservations/create.php';
    }

    //Process the booking form
    public function store(): void
    {
        $data = [
            'user_id'          => $_SESSION['user_id'],
            'game_id'          => !empty($_POST['game_id']) ? $_POST['game_id'] : null,
            'table_id'         => $_POST['table_id']         ?? null,
            'reservation_date' => $_POST['reservation_date'] ?? null,
            'reservation_time' => $_POST['reservation_time'] ?? null,
            'end_time'         => $_POST['end_time']         ?? null,
            'number_of_guests' => $_POST['number_of_guests'] ?? null,
            'status'           => 'pending',
        ];

        $errors = [];

        if (empty($data['table_id'])) {
            $errors[] = "Please select a table.";
        }

        if (empty($data['reservation_date'])) {
            $errors[] = "Please select a date.";
        } elseif ($data['reservation_date'] < date('Y-m-d')) {
            $errors[] = "Reservation date cannot be in the past.";
        }

        if (empty($data['reservation_time'])) {
            $errors[] = "Please select a time.";
        }

        if (empty($data['number_of_guests']) || $data['number_of_guests'] < 1) {
            $errors[] = "Number of guests must be at least 1.";
        }

        // Check table availability 
        if (empty($errors) && $data['table_id'] && $data['reservation_date'] && $data['reservation_time']) {
            $isAvailable = $this->reservationModel->isTableAvailable(
                $data['table_id'],
                $data['reservation_date'],
                $data['reservation_time']
            );

            if (!$isAvailable) {
                $errors[] = "Sorry! This table is already booked for that date and time.";
            }
        }

        if (!empty($errors)) {
            $games     = $this->gameModel->getAll();
            $tables    = $this->tableModel->getAll();
            $pageTitle = "Book a Table";
            include __DIR__ . '/../views/reservations/create.php';
            return;
        }

        if ($this->reservationModel->create($data)) {
            header('Location: ' . BASE_URL . '/reservations/my');
            exit; 
        }

        $errors[]  = "Something went wrong. Please try again.";
        $games     = $this->gameModel->getAll();
        $tables    = $this->tableModel->getAll();
        $pageTitle = "Book a Table";
        include __DIR__ . '/../views/reservations/create.php';
    }
     // Show ONE reservation detail
    public function show(string $id): void
    {
        $reservation = $this->reservationModel->getById((int) $id);

        if (!$reservation) {
            http_response_code(404);
            echo "Reservation not found.";
            return;
        }

        $pageTitle = "Reservation #" . $id;
        include __DIR__ . '/../views/reservations/show.php';
    }

    //Admin changes reservation status
    public function updateStatus(string $id): void
    {
        $newStatus       = $_POST['status'] ?? null;
        $allowedStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];

        // Security check: reject invalid status values
        if (!$newStatus || !in_array($newStatus, $allowedStatuses)) {
            http_response_code(400);
            echo "Invalid status.";
            return;
        }

        $this->reservationModel->updateStatus((int) $id, $newStatus);

        // Redirect back to today's reservations
        header('Location: ' . BASE_URL . '/reservations');
        exit;
    }
    }