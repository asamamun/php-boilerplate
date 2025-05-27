<?php
/* namespace App\Controllers;

use Core\Controller;
use App\Models\User;

class UserController extends Controller {
    public function index(): void {
        $users = (new User())->all();
        $this->view('users', ['users' => $users]);
    }
} */
namespace App\Controllers;
use Core\Controller;
use App\Models\User;

class UserController extends Controller {
    protected $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // Display all users
    public function index() {
        $users = $this->userModel->getAll();
        // var_dump($users);
        $this->view('users/index', ['users' => $users]);
    }

    // Display single user
    public function show($id) {
        $user = $this->userModel->getById($id);
        
        if (!$user) {
            $this->view('errors/404');
        }

        $this->view('users/show', ['user' => $user]);
    }

    // Show create form
    public function create() {
        $this->view('users/create');
    }

    // Store new user
    public function store() {
        // Validate input
        $errors = $this->validate($_POST);
        
        if (!empty($errors)) {
            $this->view('users/create', ['errors' => $errors, 'old' => $_POST]);
        }

        // Check if email exists
        if ($this->userModel->findByEmail($_POST['email'])) {
            $errors['email'] = 'Email already in use';
            $this->view('users/create', ['errors' => $errors, 'old' => $_POST]);
        }

        // Create user
        $this->userModel->create($_POST);
        
        // Redirect to users list

        redirect('/users');
    }

    // Show edit form
    public function edit($id) {
        $user = $this->userModel->getById($id);
        
        if (!$user) {
            return view('errors/404');
        }

        return view('users/edit', ['user' => $user]);
    }

    // Update user
    public function update($id) {
        // Validate input
        $errors = $this->validate($_POST, false);
        
        if (!empty($errors)) {
            return view('users/edit', ['errors' => $errors, 'user' => array_merge(['id' => $id], $_POST)]);
        }

        // Update user
        $this->userModel->update($id, $_POST);
        
        // Redirect to user details
        redirect('/users/' . $id);
    }

    // Delete user
    public function destroy($id) {
        $this->userModel->delete($id);
        redirect('/users');
    }

    // Validation helper
    protected function validate($data, $requirePassword = true) {
        $errors = [];

        if (empty($data['username'])) {
            $errors['username'] = 'Username is required';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }

        if ($requirePassword) {
            if (empty($data['password'])) {
                $errors['password'] = 'Password is required';
            } elseif (strlen($data['password']) < 6) {
                $errors['password'] = 'Password must be at least 6 characters';
            }
        }

        return $errors;
    }
}