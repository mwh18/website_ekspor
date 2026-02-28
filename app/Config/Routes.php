<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('AuthController');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Rute Publik (Tidak Perlu Login)
$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');
$routes->post('login/process', 'AuthController::processLogin');
$routes->get('register', 'AuthController::register');
$routes->post('register/process', 'AuthController::processRegister');
$routes->get('logout', 'AuthController::logout');

// Rute Terproteksi (Wajib Login)
$routes->group('', ['filter' => 'auth'], function ($routes) {

    $routes->get('dashboard', 'Dashboard::index');

    // Rute Data Historis
    $routes->get('data-historis', 'DataHistoris::index');
    $routes->get('data-historis/new', 'DataHistoris::create');
    $routes->post('data-historis/store', 'DataHistoris::store');
    $routes->get('data-historis/delete/(:num)', 'DataHistoris::delete/$1');
    $routes->get('data-historis/edit/(:num)', 'DataHistoris::edit/$1');
    $routes->post('data-historis/update/(:num)', 'DataHistoris::update/$1');

    // Rute Peramalan
    $routes->get('peramalan', 'Peramalan::index');
    $routes->post('peramalan/proses', 'Peramalan::proses');
    
    // Rute Hasil Peramalan
    $routes->get('hasil', 'HasilController::index');
    $routes->get('hasil-peramalan', 'HasilController::index');

    // Rute Kelola Pengguna
    $routes->get('users', 'UserController::index');
    $routes->get('users/new', 'UserController::create');
    $routes->post('users/store', 'UserController::store');
    $routes->get('users/delete/(:num)', 'UserController::delete/$1');

    $routes->get('tentang', 'Tentang::index');
});