<?php

namespace App\Controllers;

use App\Models\Game;

class GameController
{
    private Game $gameModel;

    public function __construct()
    {
        $this->gameModel = new Game();
    }

    public function index(): void
    {
        $games = $this->gameModel->getAll();
        require_once __DIR__ . '/../../views/games/index.php';
    }

    public function show(): void
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Game ID is required.";
            return;
        }

        $game = $this->gameModel->getById((int)$id);

        if (!$game) {
            http_response_code(404);
            echo "Game not found.";
            return;
        }

        require_once __DIR__ . '/../../views/games/show.php';
    }

    public function create(): void
    {
        require_once __DIR__ . '/../../views/games/create.php';
    }

    public function store(): void
    {
        $data = [
            'category_id'  => $_POST['category_id'] ?? null,
            'name'         => trim($_POST['name'] ?? ''),
            'description'  => trim($_POST['description'] ?? ''),
            'min_players'  => $_POST['min_players'] ?? null,
            'max_players'  => $_POST['max_players'] ?? null,
            'duration'     => $_POST['duration'] ?? null,
            'difficulty'   => $_POST['difficulty'] ?? 'medium',
            'stock'        => $_POST['stock'] ?? 1,
            'image_url'    => trim($_POST['image_url'] ?? ''),
            'is_available' => isset($_POST['is_available']) ? 1 : 0,
        ];

        if (empty($data['category_id']) || empty($data['name']) || empty($data['min_players']) || empty($data['max_players']) || empty($data['duration'])) {
            echo "Please fill in all required fields.";
            return;
        }

        $this->gameModel->create($data);

        header('Location: /games');
        exit;
    }

    public function edit(): void
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Game ID is required.";
            return;
        }

        $game = $this->gameModel->getById((int)$id);

        if (!$game) {
            echo "Game not found.";
            return;
        }

        require_once __DIR__ . '/../../views/games/edit.php';
    }

    public function update(): void
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo "Game ID is required.";
            return;
        }

        $data = [
            'category_id'  => $_POST['category_id'] ?? null,
            'name'         => trim($_POST['name'] ?? ''),
            'description'  => trim($_POST['description'] ?? ''),
            'min_players'  => $_POST['min_players'] ?? null,
            'max_players'  => $_POST['max_players'] ?? null,
            'duration'     => $_POST['duration'] ?? null,
            'difficulty'   => $_POST['difficulty'] ?? 'medium',
            'stock'        => $_POST['stock'] ?? 1,
            'image_url'    => trim($_POST['image_url'] ?? ''),
            'is_available' => isset($_POST['is_available']) ? 1 : 0,
        ];

        $this->gameModel->update((int)$id, $data);

        header('Location: /games');
        exit;
    }

    public function delete(): void
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo "Game ID is required.";
            return;
        }

        $this->gameModel->delete((int)$id);

        header('Location: /games');
        exit;
    }
}