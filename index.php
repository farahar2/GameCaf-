<?php

require __DIR__ . '/vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\GameController;
use App\Controllers\CategoryController;
use App\Controllers\ReservationController;
use App\Controllers\SessionController;
use App\Controllers\TableController;
use App\Controllers\DashboardController;

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$method = $_SERVER['REQUEST_METHOD'];

switch ($url) {
    /*
    |--------------------------------------------------------------------------
    | Auth Routes
    |--------------------------------------------------------------------------
    */
    case '':
        (new DashboardController())->admin();
        break;

    case 'login':
        if ($method === 'GET') {
            (new AuthController())->showLogin();
        } elseif ($method === 'POST') {
            (new AuthController())->authenticate();
        }
        break;

    case 'register':
        if ($method === 'GET') {
            (new AuthController())->showRegister();
        } elseif ($method === 'POST') {
            (new AuthController())->store();
        }
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    /*
    |--------------------------------------------------------------------------
    | Games Routes
    |--------------------------------------------------------------------------
    */
    case 'games':
        (new GameController())->index();
        break;

    case 'games/show':
        (new GameController())->show();
        break;

    case 'games/create':
        (new GameController())->create();
        break;

    case 'games/store':
        if ($method === 'POST') {
            (new GameController())->store();
        }
        break;

    case 'games/edit':
        (new GameController())->edit();
        break;

    case 'games/update':
        if ($method === 'POST') {
            (new GameController())->update();
        }
        break;

    case 'games/delete':
        if ($method === 'POST') {
            (new GameController())->delete();
        }
        break;

    /*
    |--------------------------------------------------------------------------
    | Categories Routes
    |--------------------------------------------------------------------------
    */
    case 'categories':
        (new CategoryController())->index();
        break;

    case 'categories/show':
        (new CategoryController())->show();
        break;

    case 'categories/create':
        (new CategoryController())->create();
        break;

    case 'categories/store':
        if ($method === 'POST') {
            (new CategoryController())->store();
        }
        break;

    case 'categories/edit':
        (new CategoryController())->edit();
        break;

    case 'categories/update':
        if ($method === 'POST') {
            (new CategoryController())->update();
        }
        break;

    case 'categories/delete':
        if ($method === 'POST') {
            (new CategoryController())->delete();
        }
        break;

    /*
    |--------------------------------------------------------------------------
    | Reservations Routes
    |--------------------------------------------------------------------------
    */
    case 'reservations':
        (new ReservationController())->index();
        break;

    case 'reservations/create':
        (new ReservationController())->create();
        break;

    case 'reservations/store':
        if ($method === 'POST') {
            (new ReservationController())->store();
        }
        break;

    case 'reservations/dashboard':
        (new ReservationController())->dashboard();
        break;

    /*
    |--------------------------------------------------------------------------
    | Sessions Routes
    |--------------------------------------------------------------------------
    */
    case 'sessions':
        (new SessionController())->dashboard();
        break;

    case 'sessions/dashboard':
        (new SessionController())->dashboard();
        break;

    case 'sessions/history':
        (new SessionController())->history();
        break;

    case 'sessions/start':
        (new SessionController())->start();
        break;

    case 'sessions/store':
        if ($method === 'POST') {
            (new SessionController())->store();
        }
        break;

    /*
    |--------------------------------------------------------------------------
    | Tables Routes
    |--------------------------------------------------------------------------
    */
    case 'tables':
        (new TableController())->index();
        break;

    case 'tables/availability':
        (new TableController())->availability();
        break;

    /*
    |--------------------------------------------------------------------------
    | Dashboard Routes
    |--------------------------------------------------------------------------
    */
    case 'admin/dashboard':
        (new DashboardController())->admin();
        break;

    case 'client/dashboard':
        (new DashboardController())->client();
        break;

    default:
        http_response_code(404);
        echo "Page not found.";
        break;
}