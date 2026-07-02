<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Página inicial -> login
$routes->get('/', 'AuthController::login');

// Auth
$routes->get('/login','AuthController::login');
$routes->post('/login','AuthController::doLogin');
$routes->get('/register','AuthController::register');
$routes->post('/register','AuthController::doRegister');
$routes->get('/logout','AuthController::logout');

// Dashboard (protegido)
$routes->get('/dashboard','DashboardController::index');

// Extrato
$routes->get('/extrato','ExtratoController::index');

// Pagamentos
$routes->get('/pagamentos','PagamentosController::index');
$routes->post('/pagamentos/realizar','PagamentosController::realizar');

// Transferências
$routes->get('/transferencias','TransferenciasController::index');
$routes->post('/transferencias/realizar','TransferenciasController::realizar');
