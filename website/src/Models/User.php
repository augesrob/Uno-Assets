<?php
namespace App\Models;
use App\Core\App;

class User {
  public static function find(App $app, int $id){
    return $app->db->query('SELECT * FROM users WHERE id=?', [$id])->fetch();
  }
  public static function findByEmail(App $app, string $email){
    return $app->db->query('SELECT * FROM users WHERE email=?', [$email])->fetch();
  }
  public static function create(App $app, array $data){
    $app->db->query('INSERT INTO users (email,password,username,avatar_url) VALUES (?,?,?,?)', [
      $data['email'], password_hash($data['password'], PASSWORD_DEFAULT), $data['username'], $data['avatar_url'] ?? null
    ]);
    return (int)$app->db->pdo->lastInsertId();
  }
  public static function roles(App $app, int $uid): array{
    $rows = $app->db->query('SELECT r.slug FROM roles r JOIN user_roles ur ON ur.role_id=r.id WHERE ur.user_id=?', [$uid])->fetchAll();
    return array_map(fn($r)=>$r['slug'], $rows);
  }
}
