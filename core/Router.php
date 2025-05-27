<?php
namespace Core;
use Dotenv\Dotenv;
class Router {
    private array $routes = [];
    
    public function get(string $path, string $handler): void {
        $this->routes[] = ['GET', $path, $handler];
    }
    
    public function post(string $path, string $handler): void {
        $this->routes[] = ['POST', $path, $handler];
    }
    
    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // echo $uri;
        // Strip the base path
        $basePath = '/ROUND64/PHP/new-skeleton/php-boilerplate/';
        $uri = str_replace($basePath, '', $uri);
        if ($uri === '') {
            $uri = '/';
        }
        echo $uri;
        
        foreach ($this->routes as [$routeMethod, $routePath, $handler]) {
            if ($method === $routeMethod && $uri === $routePath) {
                [$class, $method] = explode('@', $handler);
                $controller = new $class();
                $controller->$method();
                return;
            }
        }
        
        http_response_code(404);
        echo "404 Not Found";
    }
}