<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Core\App;
use App\Core\Router;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ApiController;

// Initialize App
$app = new App(__DIR__ . '/..');

// Initialize Router
$router = new Router();

// ==========================
// Public Routes
// ==========================
$router->get('/', [HomeController::class, 'index']);
$router->get('/rules', [HomeController::class, 'rules']);
$router->get('/assets', [HomeController::class, 'assets']);

// ==========================
// Auth Routes
// ==========================
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

// OAuth
$router->get('/oauth/{provider}', [AuthController::class, 'oauthRedirect']);
$router->get('/oauth/{provider}/callback', [AuthController::class, 'oauthCallback']);

// Profile
$router->get('/me', [HomeController::class, 'profile']);
$router->post('/me', [HomeController::class, 'updateProfile']);

// Game / Lobby
$router->get('/lobbies', [GameController::class, 'lobbies']);
$router->post('/lobbies', [GameController::class, 'createLobby']);
$router->get('/lobbies/{id}', [GameController::class, 'viewLobby']);
$router->post('/lobbies/{id}/join', [GameController::class, 'joinLobby']);
$router->post('/lobbies/{id}/start', [GameController::class, 'startGame']);
$router->get('/lobbies/{id}/spectate', [GameController::class, 'spectate']);

// Admin
$router->group('/admin', function($r) {
    $r->get('', [AdminController::class, 'dashboard']);
    $r->get('/users', [AdminController::class, 'users']);
    $r->post('/users/{id}', [AdminController::class, 'updateUser']);
    $r->get('/roles', [AdminController::class, 'roles']);
    $r->post('/roles', [AdminController::class, 'saveRole']);
    $r->get('/settings', [AdminController::class, 'settings']);
    $r->post('/settings', [AdminController::class, 'saveSettings']);
    $r->get('/pages', [AdminController::class, 'pages']);
    $r->post('/pages', [AdminController::class, 'savePage']);
});

// API Routes
$router->get('/api/chat/{lobbyId}/stream', [ApiController::class, 'chatStream']);
$router->post('/api/chat/{lobbyId}', [ApiController::class, 'sendChat']);
$router->get('/api/game/{lobbyId}/state', [ApiController::class, 'gameState']);
$router->post('/api/game/{lobbyId}/action', [ApiController::class, 'gameAction']);
$router->get('/api/leaderboard', [ApiController::class, 'leaderboard']);

// Dispatch the request
$router->dispatch($app);
