<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Admin Routes with Pimpinan/Kaprodi shared access
$routes->group('admin', ['filter' => 'role:admin,pimpinan,kaprodi'], function ($routes) {
    $routes->get('/', 'Admin::index');
    
    // Reports (Pimpinan/Kaprodi Only - Admin Restricted)
    $routes->get('laporan', 'Laporan::index', ['filter' => 'role:pimpinan,kaprodi']);
    $routes->get('laporan/result', 'Laporan::result', ['filter' => 'role:pimpinan,kaprodi']);
    
    // User Management (Strict Admin)
    $routes->group('', ['filter' => 'role:admin'], function($routes) {
        $routes->get('users', 'Admin::users');
        $routes->get('users/create', 'Admin::createUser');
        $routes->post('users/store', 'Admin::storeUser');
        $routes->get('users/edit/(:num)', 'Admin::editUser/$1');
        $routes->post('users/update/(:num)', 'Admin::updateUser/$1');
        $routes->post('users/delete/(:num)', 'Admin::deleteUser/$1');

        // Fakultas Management
        $routes->get('fakultas', 'Fakultas::index');
        $routes->get('fakultas/create', 'Fakultas::create');
        $routes->post('fakultas/store', 'Fakultas::store');
        $routes->get('fakultas/edit/(:num)', 'Fakultas::edit/$1');
        $routes->post('fakultas/update/(:num)', 'Fakultas::update/$1');
        $routes->get('fakultas/delete/(:num)', 'Fakultas::delete/$1');

        // Jurusan Management
        $routes->get('jurusan', 'Jurusan::index');
        $routes->get('jurusan/create', 'Jurusan::create');
        $routes->post('jurusan/store', 'Jurusan::store');
        $routes->get('jurusan/edit/(:num)', 'Jurusan::edit/$1');
        $routes->post('jurusan/update/(:num)', 'Jurusan::update/$1');
        // Prodi Management
        $routes->get('prodi', 'Prodi::index');
        $routes->get('prodi/create', 'Prodi::create');
        $routes->post('prodi/store', 'Prodi::store');
        $routes->get('prodi/edit/(:num)', 'Prodi::edit/$1');
        $routes->post('prodi/update/(:num)', 'Prodi::update/$1');
        // Mahasiswa Management
        $routes->get('mahasiswa', 'Mahasiswa::index');
        $routes->get('mahasiswa/create', 'Mahasiswa::create');
        $routes->post('mahasiswa/store', 'Mahasiswa::store');
        $routes->get('mahasiswa/edit/(:any)', 'Mahasiswa::edit/$1');
        $routes->post('mahasiswa/update/(:any)', 'Mahasiswa::update/$1');
        $routes->get('mahasiswa/delete/(:any)', 'Mahasiswa::delete/$1');

    });

    // Questionnaire Management (Kaprodi Only)
    $routes->group('', ['filter' => 'role:kaprodi'], function($routes) {
        // Periode Management
        $routes->get('periode', 'Periode::index');
        $routes->get('periode/create', 'Periode::create');
        $routes->post('periode/store', 'Periode::store');
        $routes->get('periode/edit/(:num)', 'Periode::edit/$1');
        $routes->post('periode/update/(:num)', 'Periode::update/$1');
        $routes->get('periode/delete/(:num)', 'Periode::delete/$1');

        // Pertanyaan Management
        $routes->get('pertanyaan', 'Pertanyaan::index');
        $routes->get('pertanyaan/create', 'Pertanyaan::create');
        $routes->post('pertanyaan/store', 'Pertanyaan::store');
        $routes->get('pertanyaan/edit/(:num)', 'Pertanyaan::edit/$1');
        $routes->post('pertanyaan/update/(:num)', 'Pertanyaan::update/$1');
        $routes->get('pertanyaan/delete/(:num)', 'Pertanyaan::delete/$1');

        // Atur Kuesioner (Assign Questions to Period)
        $routes->get('atur-kuesioner', 'AturKuesioner::index');
        $routes->get('atur-kuesioner/edit/(:num)', 'AturKuesioner::edit/$1');
        $routes->post('atur-kuesioner/save/(:num)', 'AturKuesioner::save/$1');
    });
    // System Fix - Temporary (Moved out)
});

$routes->get('system-fix', 'SystemFix::index');
$routes->get('debug-auth', 'Debug::index');

// Student Routes
$routes->group('student', ['filter' => 'role:mahasiswa'], function($routes) {
    $routes->get('/', 'Student::index');
    $routes->get('profile', 'Student::profile');
    $routes->get('kuesioner', 'Student::kuesioner');
    $routes->post('submit', 'Student::submit');
    $routes->get('debug', 'Student::debug');
});

// Custom Auth Routes
$routes->post('login', 'Auth::loginAction');
$routes->get('admin-logout', 'Home::logout');
$routes->get('auth-debug', 'AuthDebug::index');

// Debug route
$routes->get('debug/submission', 'DebugStudent::checkSubmission');
