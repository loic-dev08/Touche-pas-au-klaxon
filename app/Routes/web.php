<?php
declare(strict_types=1);

use Buki\Router\Router;

/** @var Router $router */

// Home
$router->get('/','HomeController@index');

//Auth
$router->get('/login','AuthController@showLogin');
$router->post('/login','AuthController@login');
$router->post('/logout','AuthController@logout');

//Trips (utilisateur connecté)
$router->group('/trips',function () use($router) {
    $router->get('/create','TripController@createForm');
    $router->post('/create','TripController@store');  // écriture->flash + redirect
    $router->get('/edit/:id','TripController@editForm');
    $router->post('/edit/:id','TripController@update'); // écriture->flash + redirect
    $router->post('delete/:id','TripController@delete'); // écriture->flash + redirect

},['before' =>'AuthMiddleware@handle']);

// Admin
$router->group('/admin',function() use ($router) {
    $router->get('/','Admin.DashboardController@index');
    $router->get('/users','Admin.UserController@index');

    $router->get('/agencies','Admin.AgencyController@index');
    $router->get('/agencies/create','Admin.AgencyController@createForm');
    $router->post('/agencies/create','Admin.AgencyController@store');
    $router->get('/agencies/edit/:id','Admin.AgencyController@editForm');
    $router->post('/agencies/edit/:id','Admin.AgencyController@update');
    $router->post('/agencies/delete/:id','Admin.AgencyController@delete');

    $router->get('/trips','Admin.TRipAdminController@index');
    $router->post('/trips/delete/:id','Admin.TripController@delete');

},['before' =>'AdminMiddleware@handle']);


