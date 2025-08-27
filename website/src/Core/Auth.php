<?php
namespace App\Core;
use App\Models\User;

class Auth {
  private App $app;
  public function __construct(App $app){$this->app=$app;}
  public function user(): ?array {
    $id = $this->app->session->get('uid');
    if(!$id) return null;
    return User::find($this->app, (int)$id);
  }
  public function checkRole(string $role): bool {
    $user = $this->user();
    if(!$user) return false;
    return in_array($role, User::roles($this->app, $user['id']));
  }
  public function requireRole(string $role){
    if(!$this->checkRole($role)){ http_response_code(403); exit('Forbidden'); }
  }
}
