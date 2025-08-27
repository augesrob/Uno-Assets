<?php
namespace App\Http\Controllers;

use App\Models\User;

class AuthController extends Controller {
  public function showLogin(){ return $this->view('auth/login.php'); }
  public function showRegister(){ return $this->view('auth/register.php'); }

  public function login(){
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $user = User::findByEmail($this->app, $email);
    if($user && password_verify($pass, $user['password'])){
      $this->app->session->set('uid', $user['id']);
      return $this->redirect('/');
    }
    return $this->view('auth/login.php', ['error'=>'Invalid credentials']);
  }

  public function register(){
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';
    $id = User::create($this->app, ['email'=>$email,'username'=>$username,'password'=>$pass]);
    $this->app->db->query('INSERT INTO user_roles(user_id,role_id) SELECT ?, id FROM roles WHERE slug="member"', [$id]);
    $this->app->session->set('uid', $id);
    return $this->redirect('/');
  }

  public function logout(){
    $this->app->session->forget('uid');
    return $this->redirect('/');
  }

  public function oauthRedirect(string $provider){
    // Placeholder: In production, use league/oauth2-client providers
    $_SESSION['oauth_provider'] = $provider;
    header('Location: /login?oauth=' . urlencode($provider));
    exit;
  }

  public function oauthCallback(string $provider){
    // Placeholder: handle OAuth response, map to users table
    return $this->redirect('/');
  }
}
