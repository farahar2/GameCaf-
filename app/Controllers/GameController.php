<?php

namespace App\Controllers;

use App\Models\Game;
use App\Models\Category;

class GameController
{
    private Game $gameModel;
    private Category $categoryModel;

    public function __construct()
    {
        $this->gameModel = new Game();
        $this->categoryModel = new Category();
    }

      public function index(): void
    {
        $categoryId = $_GET['category_id'] ?? null;
        $keyword    = trim($_GET['search'] ?? '');

        if (!empty($keyword)) {
            $games = $this->gameModel->search($keyword);
        } elseif (!empty($categoryId)) {
            $games = $this->gameModel->getByCategory((int) $categoryId);
        } else {
            $games = $this->gameModel->getAll();
        }

        // Categories needed for filter chips in view
        $categories = $this->categoryModel->getAll();
        $pageTitle  = "Catalogue de Jeux";

        include __DIR__ . '/../views/games/index.php';
    }

    public function show(string $id): void
    {
        if (!$id) {
            echo "Game ID is required.";
            return;
        }

        $game = $this->gameModel->getById((int) $id);

        if (!$game) {
            http_response_code(404);
            echo "Game not found.";
            return;
        }

        require_once __DIR__ . '/../views/games/show.php';
    }

    public function create(): void
    {
        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../views/games/create.php';
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

        if (
            empty($data['category_id']) ||
            empty($data['name']) ||
            empty($data['min_players']) ||
            empty($data['max_players']) ||
            empty($data['duration'])
        ) {
            echo "Please fill in all required fields.";
            return;
        }

        $this->gameModel->create($data);

        header('Location: ' . BASE_URL . '/games');
        exit;
    }

    public function edit(string $id): void
    {
        if (!$id) {
            echo "Game ID is required.";
            return;
        }

        $game = $this->gameModel->getById((int) $id);
        $categories = $this->categoryModel->getAll();

        if (!$game) {
            echo "Game not found.";
            return;
        }

        require_once __DIR__ . '/../views/games/edit.php';
    }

    public function update(string $id): void
    {
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

        if (
            empty($data['category_id']) ||
            empty($data['name']) ||
            empty($data['min_players']) ||
            empty($data['max_players']) ||
            empty($data['duration'])
        ) {
            echo "Please fill in all required fields.";
            return;
        }

        $this->gameModel->update((int) $id, $data);

        header('Location: ' . BASE_URL . '/games');
        exit;
    }

    public function delete(string $id): void
    {
        if (!$id) {
            echo "Game ID is required.";
            return;
        }

        $this->gameModel->delete((int) $id);

        header('Location: ' . BASE_URL . '/games');
        exit;
    }
}