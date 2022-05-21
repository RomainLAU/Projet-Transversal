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
$router->get('/admin/associations', 'Mvc\Controller\AdminController@listJourneys');
$router->get('/admin/donations', 'Mvc\Controller\AdminController@listJourneys');
$router->get('/admin/users', 'Mvc\Controller\AdminController@listJourneys');


$router->run();

?>