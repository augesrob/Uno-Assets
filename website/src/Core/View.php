<?php
namespace App\Core;

class View {
  private App $app;
  public function __construct(App $app){$this->app=$app;}
  public function render(string $template, array $data=[]){
    extract($data);
    $app = $this->app;
    include $this->app->basePath . '/views/_layout.php';
  }
}
