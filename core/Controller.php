<?php
namespace Core;

class Controller {
    protected function view(string $view, array $data = []): void {
        extract($data);
        require __DIR__ . "/../app/Views/{$view}.php";
    }
    
    protected function json(array $data): void {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}