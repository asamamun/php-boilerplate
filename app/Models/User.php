<?php
/* namespace App\Models;

use Core\Database;

class User {
    public function all(): array {
        return Database::query("SELECT * FROM users")->fetchAll();
    }
    
    public function find(int $id): ?array {
        return Database::query("SELECT * FROM users WHERE id = ?", [$id])->fetch() ?: null;
    }
} */

namespace App\Models;

use Core\Database;

class User {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get all users
    public function getAll() {
/*         $all = $this->db->query("SELECT id, name, email,phone, active, role, created FROM users");
        return $this->db->resultSet($all); */
        $all = $this->db->select('users', 'id, name, email,phone, active, role, created', 'active = :status', 'name ASC', 10)
             ->bind(':status', '1')
             ->fetchAll();
        return $all;
    }

    // Get single user by ID
    public function getById($id) {
        $this->db->query("SELECT id, name, email,phone, active, role, created FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->fetch(); 
    }

    // Create new user
    public function create($data) {
        $this->db->query("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        
        // Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));

        // Execute
        return $this->db->execute();
    }

    // Update user
    public function update($id, $data) {
        $this->db->query("UPDATE users SET username = :username, email = :email WHERE id = :id");
        
        // Bind values
        $this->db->bind(':id', $id);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);

        // Execute
        return $this->db->execute();
    }

    // Delete user
    public function delete($id) {
        $this->db->query("DELETE FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // Find user by email
    public function findByEmail($email) {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);
        return $this->db->single();
    }
}