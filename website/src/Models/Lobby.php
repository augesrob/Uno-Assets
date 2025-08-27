<?php
namespace App\Models;
use App\Core\App;

class Lobby {
  public static function create(App $app, int $ownerId, string $name, int $maxPlayers=4, bool $allowSpectators=true){
    $app->db->query('INSERT INTO lobbies (owner_id,name,max_players,allow_spectators,status,created_at) VALUES (?,?,?,?,?,NOW())',[
      $ownerId,$name,$maxPlayers,(int)$allowSpectators,'waiting'
    ]);
    return (int)$app->db->pdo->lastInsertId();
  }
  public static function list(App $app){
    return $app->db->query('SELECT * FROM lobbies ORDER BY created_at DESC')->fetchAll();
  }
  public static function get(App $app, int $id){
    return $app->db->query('SELECT * FROM lobbies WHERE id=?', [$id])->fetch();
  }
}
