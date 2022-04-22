<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$router = new \Bramus\Router\Router();

$router->before('GET', '/register', function() {
    if (isset($_SESSION['user'])) {
        header('location: /');
        exit();
    }
});

$router->before('GET', '/login', function() {
    if (isset($_SESSION['user'])) {
        header('location: /');
        exit();
    }
});

$router->before('GET', '/profile', function() {
    if (!isset($_SESSION['user'])) {
        header('location: /login');
        exit();
    }
});

$router->get('/profile', 'Mvc\Controller\ProfileController@displayProfile');

$router->get('/', 'Mvc\Controller\AccueilController@displayAccueil');

$router->get('/register', 'Mvc\Controller\UserController@register');
$router->post('/register', 'Mvc\Controller\UserController@register');

$router->get('/login', 'Mvc\Controller\UserController@login');
$router->post('/login', 'Mvc\Controller\UserController@login');

$router->get('/deconnection', function() {
    session_destroy();
    header('location: /');
});

$router->run();

?>