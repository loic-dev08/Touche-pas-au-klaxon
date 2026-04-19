<?php

/** @var \Buki\Router\Router $router */

// Home
$router->get('/', 'HomeController@index');

// Auth
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->post('/logout', 'AuthController@logout');

// Trips (utilisateur connecté)
$router->group('/trips', function () use ($router) {
    $router->get('/create', 'TripController@createForm');
    $router->post('/create', 'TripController@store');
    $router->get('/edit/:id', 'TripController@editForm');
    $router->post('/edit/:id', 'TripController@update');
    $router->post('/delete/:id', 'TripController@delete');
}, ['before' => 'AuthMiddleware@handle']);
