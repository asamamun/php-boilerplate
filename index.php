<?php
require_once __DIR__ . '/vendor/autoload.php';

use Core\Router;
use Core\Database;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
// Load helper functions
// require_once __DIR__ . '/core/Helpers.php';

// Database::init();

$router = new Router();
$router->get('/', 'App\Controllers\HomeController@index');
// $router->get('users', 'App\Controllers\UserController@index');
$router->get('users', 'App\Controllers\UserController@index');
$router->get('users/create', 'App\Controllers\UserController@create');
$router->post('users/store', 'App\Controllers\UserController@store');
$router->get('users/{id}', 'App\Controllers\UserController@show');
$router->get('users/{id}/edit', 'App\Controllers\UserController@edit');
$router->post('users/{id}/update', 'App\Controllers\UserController@update');
$router->post('users/{id}/delete', 'App\Controllers\UserController@destroy');
$router->dispatch();