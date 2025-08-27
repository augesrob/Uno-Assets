<?php
namespace App\Http\Controllers;

class HomeController extends Controller {
    public function index() {
        $user = $this->app->auth->user(); // optional for now
        return $this->view('home.php', compact('user'));
    }

    public function rules() {
        return $this->view('rules.php');
    }

    public function assets() {
        $assetsUrl = 'https://github.com/augesrob/Uno-Assets/tree/main';
        return $this->view('assets.php', compact('assetsUrl'));
    }

    public function profile() {
        $user = $this->app->auth->user();
        if(!$user) return $this->redirect('/login');
        return $this->view('profile.php', compact('user'));
    }

    public function updateProfile() {
        $user = $this->app->auth->user();
        if(!$user) return $this->redirect('/login');

        $avatar = $_POST['avatar_url'] ?? null;
        $display = $_POST['display_name'] ?? null;
        $this->app->db->query(
            'UPDATE users SET avatar_url=?, display_name=? WHERE id=?',
            [$avatar, $display, $user['id']]
        );
        return $this->redirect('/me');
    }
}
