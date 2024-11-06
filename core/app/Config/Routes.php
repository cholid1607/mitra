<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


//Routes Block Aset
// $routes->get('/mitra', 'Mitra::index', ['filter' => 'role:superuser']);
// $routes->get('/mitra/index', 'Mitra::index', ['filter' => 'role:superuser']);
// $routes->get('/mitra/tambah', 'Mitra::tambah', ['filter' => 'role:superuser']);
// $routes->get('/mitra/simpan', 'Mitra::simpan', ['filter' => 'role:superuser']);
// $routes->get('/mitra/edit', 'Mitra::edit', ['filter' => 'role:superuser']);
// $routes->get('/mitra/detail', 'Mitra::detail', ['filter' => 'role:superuser']);
// $routes->get('/mitra/update', 'Mitra::update', ['filter' => 'role:superuser']);
// $routes->get('/mitra/hapus', 'Mitra::hapus', ['filter' => 'role:superuser']);
