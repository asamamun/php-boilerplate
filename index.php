<?php
require_once __DIR__ . '/vendor/autoload.php';

use Core\Router;
use Core\Database;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

Database::init();

$router = new Router();
$router->get('/', 'App\Controllers\HomeController@index');
$router->get('/users', 'App\Controllers\UserController@index');
$router->dispatch();