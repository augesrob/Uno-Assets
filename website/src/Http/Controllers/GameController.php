<?php
namespace App\Http\Controllers;
use App\Models\Lobby;

class GameController extends Controller {
  public function lobbies(){
    $lobbies = Lobby::list($this->app);
    return $this->view('game/lobbies.php', compact('lobbies'));
  }
  public function createLobby(){
    $user = $this->app->auth->user();
    if(!$user) return $this->redirect('/login');
    $name = $_POST['name'] ?? ('Lobby '.rand(100,999));
    $id = Lobby::create($this->app, $user['id'], $name);
    return $this->redirect('/lobbies/'.$id);
  }
  public function viewLobby(int $id){
    $lobby = Lobby::get($this->app, $id);
    if(!$lobby){ http_response_code(404); echo 'Lobby not found'; return; }
    return $this->view('game/lobby.php', compact('lobby'));
  }
  public function joinLobby(int $id){ /* TODO: add player to lobby */ return $this->redirect('/lobbies/'.$id); }
  public function startGame(int $id){ /* TODO: start game, deal cards */ return $this->redirect('/lobbies/'.$id); }
  public function spectate(int $id){ return $this->view('game/spectate.php', ['lobbyId'=>$id]); }
}
