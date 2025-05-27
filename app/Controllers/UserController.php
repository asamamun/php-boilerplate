<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\User;

class UserController extends Controller {
    public function index(): void {
        $users = (new User())->all();
        $this->view('users', ['users' => $users]);
    }
}