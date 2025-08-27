<?php
namespace App\Http\Controllers;

class AdminController extends Controller {
  public function dashboard(){
    $this->app->auth->requireRole('owner');
    $stats = $this->app->db->query('SELECT COUNT(*) users, (SELECT COUNT(*) FROM lobbies) lobbies FROM users')->fetch();
    return $this->view('admin/dashboard.php', compact('stats'));
  }
  public function users(){
    $this->app->auth->requireRole('admin');
    $users = $this->app->db->query('SELECT id, username, email, wins, losses, level, xp FROM users ORDER BY id DESC LIMIT 200')->fetchAll();
    return $this->view('admin/users.php', compact('users'));
  }
  public function updateUser(int $id){
    $this->app->auth->requireRole('admin');
    $wins = (int)($_POST['wins'] ?? 0);
    $losses = (int)($_POST['losses'] ?? 0);
    $this->app->db->query('UPDATE users SET wins=?, losses=? WHERE id=?', [$wins,$losses,$id]);
    header('Location: /admin/users'); exit;
  }
  public function roles(){
    $this->app->auth->requireRole('owner');
    $roles = $this->app->db->query('SELECT * FROM roles')->fetchAll();
    $perms = $this->app->db->query('SELECT * FROM permissions')->fetchAll();
    return $this->view('admin/roles.php', compact('roles','perms'));
  }
  public function saveRole(){
    $this->app->auth->requireRole('owner');
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    if($id){
      $this->app->db->query('UPDATE roles SET name=?, slug=? WHERE id=?', [$name,$slug,$id]);
    } else {
      $this->app->db->query('INSERT INTO roles (name,slug) VALUES (?,?)', [$name,$slug]);
    }
    header('Location: /admin/roles'); exit;
  }
  public function settings(){
    $this->app->auth->requireRole('owner');
    $settings = $this->app->db->query('SELECT `key`,`value` FROM settings')->fetchAll();
    return $this->view('admin/settings.php', compact('settings'));
  }
  public function saveSettings(){
    $this->app->auth->requireRole('owner');
    foreach($_POST as $k=>$v){
      $this->app->db->query('INSERT INTO settings(`key`,`value`) VALUES(?,?) ON DUPLICATE KEY UPDATE `value`=VALUES(`value`)', [$k,$v]);
    }
    header('Location: /admin/settings'); exit;
  }
  public function pages(){
    $this->app->auth->requireRole('admin');
    $pages = $this->app->db->query('SELECT * FROM pages')->fetchAll();
    return $this->view('admin/pages.php', compact('pages'));
  }
  public function savePage(){
    $this->app->auth->requireRole('admin');
    $slug = $_POST['slug'] ?? '';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $this->app->db->query('INSERT INTO pages(slug,title,content) VALUES(?,?,?) ON DUPLICATE KEY UPDATE title=VALUES(title), content=VALUES(content)', [$slug,$title,$content]);
    header('Location: /admin/pages'); exit;
  }
}
