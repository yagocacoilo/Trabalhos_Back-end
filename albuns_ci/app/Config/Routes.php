<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Página inicial -> login
$routes->get('/', 'AuthController::login');

// Auth
$routes->get('/login',     'AuthController::login');
$routes->post('/login',    'AuthController::doLogin');
$routes->get('/register',  'AuthController::register');
$routes->post('/register', 'AuthController::doRegister');
$routes->get('/logout',    'AuthController::logout');

// CRUD de Álbuns (protegido pelo filtro "auth" - ver app/Config/Filters.php)
$routes->get('/albuns',              'AlbumController::index');
$routes->get('/albuns/novo',         'AlbumController::new');
$routes->post('/albuns',             'AlbumController::create');
$routes->get('/albuns/(:num)',       'AlbumController::show/$1');
$routes->get('/albuns/(:num)/editar','AlbumController::edit/$1');
$routes->post('/albuns/(:num)',      'AlbumController::update/$1');
$routes->post('/albuns/(:num)/excluir', 'AlbumController::delete/$1');
