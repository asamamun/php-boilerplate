<?php
namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller {
    public function index(): void {
        $this->view('home', ['title' => 'Welcome to PHP MySQL Project']);
    }
}