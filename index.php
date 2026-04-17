<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_URL', '/GameCafé');

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

    case 'reservations':
        (new ReservationController())->index();
        break;

    case 'reservations/dashboard':
        (new ReservationController())->dashboard();
        break;

    case 'reservations/my':
        (new ReservationController())->myReservations();
        break;

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
    case 'dashboard/admin':
        (new DashboardController())->admin();
        break;

    case 'dashboard/client':
        (new DashboardController())->client();
        break;

    default:
        // Handle dynamic routes: tables/{id} and tables/{id}/availability
        if (preg_match('#^tables/(\d+)/availability$#', $url, $matches)) {
            if ($method === 'POST') {
                (new TableController())->updateAvailability($matches[1]);
            }
        } elseif (preg_match('#^tables/(\d+)$#', $url, $matches)) {
            (new TableController())->show($matches[1]);
        }
        // Handle dynamic routes: reservations/{id} and reservations/{id}/status
        elseif (preg_match('#^reservations/(\d+)/status$#', $url, $matches)) {
            if ($method === 'POST') {
                (new ReservationController())->updateStatus($matches[1]);
            }
        } elseif (preg_match('#^reservations/(\d+)$#', $url, $matches)) {
            (new ReservationController())->show($matches[1]);
        }
        // Handle dynamic routes: sessions/{id}/stop
        elseif (preg_match('#^sessions/(\d+)/stop$#', $url, $matches)) {
            (new SessionController())->stop((int) $matches[1]);
        }
        // Handle dynamic routes: games
        elseif (preg_match('#^games/(\d+)/edit$#', $url, $matches)) {
            (new GameController())->edit($matches[1]);
        } elseif (preg_match('#^games/(\d+)/update$#', $url, $matches)) {
            if ($method === 'POST') {
                (new GameController())->update($matches[1]);
            }
        } elseif (preg_match('#^games/(\d+)/delete$#', $url, $matches)) {
            if ($method === 'POST') {
                (new GameController())->delete($matches[1]);
            }
        } elseif (preg_match('#^games/(\d+)$#', $url, $matches)) {
            (new GameController())->show($matches[1]);
        }
        // Handle dynamic routes: categories
        elseif (preg_match('#^categories/(\d+)/edit$#', $url, $matches)) {
            (new CategoryController())->edit($matches[1]);
        } elseif (preg_match('#^categories/(\d+)/update$#', $url, $matches)) {
            if ($method === 'POST') {
                (new CategoryController())->update($matches[1]);
            }
        } elseif (preg_match('#^categories/(\d+)/delete$#', $url, $matches)) {
            if ($method === 'POST') {
                (new CategoryController())->destroy($matches[1]);
            }
        } else {
            http_response_code(404);
            echo "Page not found.";
        }
        break;
}