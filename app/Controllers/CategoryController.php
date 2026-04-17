<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController
{
    private Category $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    // List all categories
    public function index(): void
    {
        $this->guardAdmin();

        $categories = $this->categoryModel->getAllWithCount();
        $pageTitle  = "Catégories";
        include __DIR__ . '/../Views/categories/index.php';
    }

    // Show create form
    public function create(): void
    {
        $this->guardAdmin();

        $pageTitle = "Nouvelle Catégorie";
        include __DIR__ . '/../Views/categories/create.php';
    }

    // Store new category
    public function store(): void
    {
        $this->guardAdmin();

        $errors = [];

        if (empty(trim($_POST['name'] ?? ''))) {
            $errors[] = "Le nom de la catégorie est obligatoire.";
        }

        if (!empty($errors)) {
            $pageTitle = "Nouvelle Catégorie";
            include __DIR__ . '/../Views/categories/create.php';
            return;
        }

        $this->categoryModel->create([
            'name'        => trim($_POST['name']),
            'description' => trim($_POST['description'] ?? ''),
        ]);

        header('Location: /categories?success=created');
        exit;
    }

    // Show edit form
    public function edit(string $id): void
    {
        $this->guardAdmin();

        $category = $this->categoryModel->getByIdWithCount((int) $id);

        if (!$category) {
            http_response_code(404);
            echo "Catégorie introuvable.";
            return;
        }

        $pageTitle = "Modifier: " . htmlspecialchars($category['name']);
        include __DIR__ . '/../Views/categories/create.php'; // Reuse create view!
    }

    // Update category
    public function update(string $id): void
    {
        $this->guardAdmin();

        $errors = [];

        if (empty(trim($_POST['name'] ?? ''))) {
            $errors[] = "Le nom est obligatoire.";
        }

        if (!empty($errors)) {
            $category  = $this->categoryModel->getByIdWithCount((int) $id);
            $pageTitle = "Modifier Catégorie";
            include __DIR__ . '/../Views/categories/create.php';
            return;
        }

        $this->categoryModel->update((int) $id, [
            'name'        => trim($_POST['name']),
            'description' => trim($_POST['description'] ?? ''),
        ]);

        header('Location: /categories?success=updated');
        exit;
    }

    // Delete category
    public function destroy(string $id): void
    {
        $this->guardAdmin();

        $deleted = $this->categoryModel->delete((int) $id);

        if ($deleted) {
            header('Location: /categories?success=deleted');
        } else {
            header('Location: /categories?error=has_games');
        }
        exit;
    }

    // Admin guard
    private function guardAdmin(): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /');
            exit;
        }
    }
}