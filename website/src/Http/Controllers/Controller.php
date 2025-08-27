<?php
namespace App\Http\Controllers;

use App\Core\App;

class Controller {
    protected App $app;
    public function __construct(App $app){ $this->app = $app; }
    protected function view(string $tpl, array $data = []) { $this->app->view->render($tpl, $data); }
    protected function redirect(string $to) { header('Location: '.$to); exit; }
}
