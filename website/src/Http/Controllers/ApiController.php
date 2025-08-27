<?php
namespace App\Http\Controllers;

class ApiController extends Controller {
  public function leaderboard(){
    $rows = $this->app->db->query('SELECT username, wins, losses, level, xp FROM users ORDER BY wins DESC, xp DESC LIMIT 100')->fetchAll();
    header('Content-Type: application/json');
    echo json_encode($rows);
  }

  public function chatStream(int $lobbyId){
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');
    @ini_set('output_buffering', 'off');
    @ini_set('zlib.output_compression', '0');
    while(true){
      $msgs = $this->app->db->query('SELECT * FROM chat_messages WHERE lobby_id=? AND created_at > NOW() - INTERVAL 10 SECOND ORDER BY id DESC LIMIT 50', [$lobbyId])->fetchAll();
      echo "event: tick\n";
      echo "data: " . json_encode($msgs) . "\n\n";
      @ob_flush(); flush();
      sleep(2);
      if(connection_aborted()) break;
    }
  }

  public function sendChat(int $lobbyId){
    $user = $this->app->auth->user();
    $role = $user ? implode(',', $this->app->db->query('SELECT r.slug FROM roles r JOIN user_roles ur ON ur.role_id=r.id WHERE ur.user_id=?', [$user['id']])->fetchAll(PDO::FETCH_COLUMN)) : 'spectator';
    $username = $user['username'] ?? 'guest';
    $text = trim($_POST['text'] ?? '');
    if($text){
      $this->app->db->query('INSERT INTO chat_messages (lobby_id,user_id,role,username,message,created_at) VALUES (?,?,?,?,?,NOW())',
        [$lobbyId, $user['id'] ?? null, $role, $username, $text]);
    }
    header('Content-Type: application/json');
    echo json_encode(['ok'=>true]);
  }

  public function gameState(int $lobbyId){
    $state = $this->app->db->query('SELECT state_json FROM games WHERE lobby_id=? ORDER BY id DESC LIMIT 1', [$lobbyId])->fetchColumn() ?: '{}';
    header('Content-Type: application/json');
    echo $state;
  }

  public function gameAction(int $lobbyId){
    // Placeholder for playing a card, drawing, etc.
    header('Content-Type: application/json');
    echo json_encode(['ok'=>true]);
  }
}
