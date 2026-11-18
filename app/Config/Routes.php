<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->group('buku', static function ($routes) {
    $routes->get('/', 'Buku::index');
    $routes->get('tambah', 'Buku::tambah');
    $routes->post('simpan', 'Buku::simpan');
    $routes->get('edit/(:num)', 'Buku::edit/$1');
    $routes->post('update/(:num)', 'Buku::update/$1');
    $routes->post('hapus/(:num)', 'Buku::hapus/$1');
});

// ===== Soal latihan: Bengkel Maju Jaya =====
$routes->group('suku-cadang', static function ($routes) {
    $routes->get('/', 'SukuCadang::index');
    $routes->get('tambah', 'SukuCadang::tambah');
    $routes->post('simpan', 'SukuCadang::simpan');
    $routes->get('edit/(:num)', 'SukuCadang::edit/$1');
    $routes->post('update/(:num)', 'SukuCadang::update/$1');
    $routes->post('hapus/(:num)', 'SukuCadang::hapus/$1');
});