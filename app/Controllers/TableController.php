<?php

namespace App\Controllers;

use App\Models\Table;

class TableController
{
    private Table $tableModel;

    public function __construct()
    {
        $this->tableModel = new Table();
    }

    // Show ALL tables with their status
    public function index(): void
    {
        $tables    = $this->tableModel->getAll();
        $pageTitle = "All Tables";
        include __DIR__ . '/../views/tables/index.php';
    }

    // Show ONE table details
    public function show(string $id): void
    {
        $table = $this->tableModel->getById((int) $id);

        if (!$table) {
            http_response_code(404);
            echo "Table not found.";
            return;
        }

        $pageTitle = "Table " . $table['table_number'];
        include __DIR__ . '/../views/tables/show.php';
    }

    // Toggle table availability
    public function updateAvailability(string $id): void
    {
        $table = $this->tableModel->getById((int) $id);

        if (!$table) {
            http_response_code(404);
            echo "Table not found.";
            return;
        }

        // Toggle: available → occupied, occupied → available
        $newStatus = !$table['is_available'];

        if ($this->tableModel->updateAvailability((int) $id, $newStatus)) {
            header("Location: /tables");
            exit;
        }
        echo "Failed to update table status.";
    }
}