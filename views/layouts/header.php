<?php
// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameCafe Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional custom styles -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>

<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">

        <a class="navbar-brand" href="/games">
            🎲 GameCafe
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/games">
                        Games
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/categories">
                        Categories
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/reservations">
                        Reservations
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/sessions">
                        Sessions
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/tables">
                        Tables
                    </a>
                </li>

            </ul>

            <!-- Right side -->
            <ul class="navbar-nav">

                <?php if (!empty($_SESSION['user'])): ?>

                    <li class="nav-item">
                        <span class="navbar-text me-3">
                            Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?>
                        </span>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="/logout">
                            Logout
                        </a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm me-2" href="/login">
                            Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-warning btn-sm" href="/register">
                            Register
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>
</nav>

<!-- Main page container -->
<div class="container mt-4"></div>