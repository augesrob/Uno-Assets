<?php
namespace App\Core;
use PDO;

class Database {
  public PDO $pdo;
  public function __construct(string $host, int $port, string $db, string $user, string $pass) {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $this->pdo = new PDO($dsn, $user, $pass, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
  }
  public function query(string $sql, array $params = []) {
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
  }
}
