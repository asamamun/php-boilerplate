<?php
namespace App\Models;

use Core\Database;

class User {
    public function all(): array {
        return Database::query("SELECT * FROM users")->fetchAll();
    }
    
    public function find(int $id): ?array {
        return Database::query("SELECT * FROM users WHERE id = ?", [$id])->fetch() ?: null;
    }
}