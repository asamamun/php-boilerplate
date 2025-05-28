<?php
/*
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
        echo "<hr>404 Not Found";
    }
}
    */
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
        // Strip the base path
        $basePath = '/ROUND64/PHP/new-skeleton/php-boilerplate/';
        $uri = str_replace($basePath, '', $uri);
        $uri = trim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }
        // Debug: Log the URI
        // error_log("Processed URI: $uri");
        
        foreach ($this->routes as [$routeMethod, $routePath, $handler]) {
            if ($method !== $routeMethod) {
                continue;
            }

            // Convert route path to regex (e.g., users/{id} -> users/([0-9]+))
            $pattern = preg_replace('#\{[a-zA-Z0-9_]+\}#', '([0-9]+)', $routePath);
            $pattern = '#^' . str_replace('/', '\/', $pattern) . '/?$#'; // Allow optional trailing slash

            if (preg_match($pattern, $uri, $matches)) {
                // Extract parameters (remove full match)
                array_shift($matches);
                
                // Parse handler (e.g., App\Controllers\UserController@show)
                [$class, $method] = explode('@', $handler);
                
                // Instantiate controller
                if (!class_exists($class)) {
                    throw new \Exception("Controller $class not found");
                }
                $controller = new $class();
                
                // Call method with parameters
                call_user_func_array([$controller, $method], $matches);
                return;
            }
        }
        
        http_response_code(404);
        echo "<hr>404 Not Found";
    }
}