<?php
namespace App\Core;

class Session {
  public function __construct(string $secret) {
    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start([
        'cookie_httponly' => true,
        'cookie_secure' => true,
        'cookie_samesite' => 'Lax',
        'name' => 'uno_session'
      ]);
    }
  }
  public function get($key, $default=null){return $_SESSION[$key]??$default;}
  public function set($key,$val){$_SESSION[$key]=$val;}
  public function forget($key){unset($_SESSION[$key]);}
}
