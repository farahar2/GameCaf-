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

    public function index(): void
    {
        $categories = $this->categoryModel->getAll();
        require_once __DIR__ . '/../../views/categories/index.php';
    }

    public function show(): void
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Category ID is required.";
            return;
        }

        $category = $this->categoryModel->getById((int) $id);

        if (!$category) {
            http_response_code(404);
            echo "Category not found.";
            return;
        }

        require_once __DIR__ . '/../../views/categories/show.php';
    }

    public function create(): void
    {
        require_once __DIR__ . '/../../views/categories/create.php';
    }

    public function store(): void
    {
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? '')
        ];

        if (empty($data['name'])) {
            echo "Category name is required.";
            return;
        }

        $this->categoryModel->create($data);

        header('Location: /categories');
        exit;
    }

    public function edit(): void
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Category ID is required.";
            return;
        }

        $category = $this->categoryModel->getById((int) $id);

        if (!$category) {
            http_response_code(404);
            echo "Category not found.";
            return;
        }

        require_once __DIR__ . '/../../views/categories/edit.php';
    }

    public function update(): void
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo "Category ID is required.";
            return;
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? '')
        ];

        if (empty($data['name'])) {
            echo "Category name is required.";
            return;
        }

        $this->categoryModel->update((int) $id, $data);

        header('Location: /categories');
        exit;
    }

    public function delete(): void
    {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo "Category ID is required.";
            return;
        }

        $this->categoryModel->delete((int) $id);

        header('Location: /categories');
        exit;
    }
}