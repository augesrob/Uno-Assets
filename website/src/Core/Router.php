<?php
namespace App\Core;

class Router {
  private array $routes = [];
  private string $groupPrefix = '';

  public function get(string $path, $handler) { $this->add('GET', $path, $handler); }
  public function post(string $path, $handler) { $this->add('POST', $path, $handler); }

  public function group(string $prefix, callable $cb) {
    $prev = $this->groupPrefix;
    $this->groupPrefix .= rtrim($prefix, '/');
    $cb($this);
    $this->groupPrefix = $prev;
  }

  private function add(string $method, string $path, $handler) {
    // Fix for root path "/"
    $path = $this->groupPrefix . ($path === '/' ? '/' : rtrim($path, '/'));
    $regex = '#^' . preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $path) . '$#';
    $this->routes[] = compact('method','regex','handler');
  }

  public function dispatch(App $app) {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = rtrim($uri, '/') ?: '/';
    $method = $_SERVER['REQUEST_METHOD'];

    echo "DEBUG URI: $uri<br>";

    foreach ($this->routes as $route) {
      if ($route['method'] === $method && preg_match($route['regex'], $uri, $m)) {
        $params = array_filter($m, 'is_string', ARRAY_FILTER_USE_KEY);
        [$class,$func] = $route['handler'];
        $controller = new $class($app);
        return call_user_func_array([$controller, $func], $params);
      }
    }

    http_response_code(404);
    echo "404 Not Found";
  }
}
