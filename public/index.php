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

$router->before('GET', '/account', function() {
    if (!isset($_SESSION['user'])) {
        header('location: /login');
        exit();
    }
});

$router->before('GET', '/associations', function() {
    if (!isset($_SESSION['user'])) {
        header('location: /login');
        exit();
    }
});

$router->before('POST', '/associations', function() {
    if (!isset($_SESSION['user'])) {
        header('location: /login');
        exit();
    } else if (isset($_SESSION['user']) && strlen($_POST['globalSearch']) == 0) {
        header('location: /associations');
        exit();
    }
});

$router->before('GET', '/association/(\d+)', function() {
    if (!isset($_SESSION['user'])) {
        header('location: /login');
        exit();
    }
});

$router->before('GET', '/association/unfav/(\d+)', function() {
    if (!isset($_SESSION['user'])) {
        header('location: /login');
        exit();
    }
});

$router->before('GET', '/association/favorite/(\d+)', function() {
    if (!isset($_SESSION['user'])) {
        header('location: /login');
        exit();
    }
});

$router->before('GET', '/journey', function() {
    if (!isset($_SESSION['user'])) {
        header('location: /login');
        exit();
    }
});

$router->before('POST', '/journey', function() {
    if (!isset($_SESSION['user'])) {
        header('location: /login');
        exit();
    }
});

$router->before('GET', '/journey/favorite/(\d+)', function() {
    if (!isset($_SESSION['user'])) {
        header('location: /login');
        exit();
    }
});

$router->before('GET', '/journey/unfav/(\d+)', function() {
    if (!isset($_SESSION['user'])) {
        header('location: /login');
        exit();
    }
});

$router->before('POST', '/journey/search', function() {
    if (!isset($_SESSION['user'])) {
        header('location: /login');
        exit();
    }
});

$router->before('GET', '/journey/join/(\d+)', function() {
    if (!isset($_SESSION['user'])) {
        header('location: /login');
        exit();
    }
});

$router->before('GET', '/journey', function() {
    if (!isset($_SESSION['user'])) {
        header('location: /login');
        exit();
    }
});

$router->before('GET', '/admin', function() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('location: /login');
        exit();
    }
});

$router->before('GET', '/admin/journey', function() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('location: /login');
        exit();
    }
});

$router->before('GET', '/admin/associations', function() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('location: /login');
        exit();
    }
});

$router->before('GET', '/admin/donations', function() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('location: /login');
        exit();
    }
});

$router->before('GET', '/admin/users', function() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header('location: /login');
        exit();
    }
});

$router->get('/', 'Mvc\Controller\AccueilController@displayAccueil');

$router->get('/journey', 'Mvc\Controller\JourneyController@listJourneys');
$router->post('/journey', 'Mvc\Controller\JourneyController@listJourneys');

$router->get('/journey/favorite/(\d+)', 'Mvc\Controller\JourneyController@addJourneyToFavorites');

$router->get('/journey/unfav/(\d+)', 'Mvc\Controller\JourneyController@deleteFromFavorites');

$router->post('/journey/search', 'Mvc\Controller\JourneyController@filterJourneys');

$router->get('/journey/join/(\d+)', 'Mvc\Controller\JourneyController@joinJourney');


$router->get('/associations', 'Mvc\Controller\AssociationController@listAssociations');

$router->get('/association/(\d+)', 'Mvc\Controller\AssociationController@showAssociationById');

$router->post('/association/(\d+)', 'Mvc\Controller\DonationController@donateToAssociation');

$router->get('/association/favorite/(\d+)', 'Mvc\Controller\AssociationController@addAssociationToFavorites');

$router->get('/association/unfav/(\d+)', 'Mvc\Controller\AssociationController@deleteFromFavorites');

$router->post('/associations', 'Mvc\Controller\AssociationController@filterAssociations');

$router->get('/account', 'Mvc\Controller\AccountController@displayAccount');

$router->get('/register', 'Mvc\Controller\UserController@register');
$router->post('/register', 'Mvc\Controller\UserController@register');

$router->get('/login', 'Mvc\Controller\UserController@login');
$router->post('/login', 'Mvc\Controller\UserController@login');

$router->get('/deconnection', function() {
    session_destroy();
    header('location: /');
});

$router->get('/admin', 'Mvc\Controller\AdminController@displayAdmin');
$router->get('/admin/journey', 'Mvc\Controller\AdminController@listJourneys');
$router->get('/admin/associations', 'Mvc\Controller\AdminController@listAssociations');
$router->get('/admin/donations', 'Mvc\Controller\AdminController@listDonations');
$router->get('/admin/users', 'Mvc\Controller\AdminController@listUsers');


$router->run();

?>