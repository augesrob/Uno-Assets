<?php
namespace App\Core;

use Dotenv\Dotenv;

class App {
    public string $basePath;
    public array $config;
    public Database $db;
    public Session $session;
    public View $view;
    public Auth $auth;

    public function __construct(string $basePath) {
        $this->basePath = $basePath;

        // Load .env if it exists
        if (file_exists($basePath.'/.env')) {
            $dotenv = Dotenv::createImmutable($basePath);
            $dotenv->load();
        }

        // Basic config
        $this->config = [
            'app_url' => $_ENV['APP_URL'] ?? 'http://localhost',
            'debug'   => ($_ENV['APP_DEBUG'] ?? 'false') === 'true',
        ];

        // Initialize services
        $this->db      = new Database(
            $_ENV['DB_HOST'] ?? 'localhost',
            (int)($_ENV['DB_PORT'] ?? 3306),
            $_ENV['DB_DATABASE'] ?? 'uno',
            $_ENV['DB_USERNAME'] ?? 'root',
            $_ENV['DB_PASSWORD'] ?? ''
        );

        $this->session = new Session($_ENV['SESSION_SECRET'] ?? 'changeme');
        $this->view    = new View($this);
        $this->auth    = new Auth($this);
    }
}

// ======= STUB DEPENDENCIES =======
class Database {
    public function __construct(string $host, int $port, string $db, string $user, string $pass) {}
}

class Session {
    public function __construct(string $secret) {}
}

class View {
    protected App $app;
    public function __construct(App $app) {
        $this->app = $app;
    }
    public function render(string $view, array $data = []) {}
}

class Auth {
    protected App $app;
    public function __construct(App $app) {
        $this->app = $app;
    }
    public function check() { return false; }
    public function user() { return null; }
}
