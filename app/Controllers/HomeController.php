<?php

namespace App\Controllers;

use App\Models\Game;
use App\Models\CafTable;

class HomeController
{
    private Game $gameModel;
    private CafTable $tableModel;

    public function __construct()
    {
        $this->gameModel  = new Game();
        $this->tableModel = new CafTable();
    }

    public function index(): void
    {
        // Featured games for the homepage grid
        $featuredGames = $this->gameModel->getAll();

        // Tables for the booking form
        $tables = $this->tableModel->getAvailable();

        // Games for the booking form dropdown
        $games = $this->gameModel->getAll();

        $pageTitle = "Aji L3bo Café - Casablanca's Board Game Café";
        include __DIR__ . '/../Views/home/index.php';
    }
}