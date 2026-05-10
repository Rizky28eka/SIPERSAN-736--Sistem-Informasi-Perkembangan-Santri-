<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ─── PUBLIC ROUTES ────────────────────────────────────────────────────────────
$routes->get('/', 'Auth::index');
$routes->group('auth', function ($routes) {
    $routes->get('/',                          'Auth::index');
    $routes->post('login',                     'Auth::login');
    $routes->get('logout',                     'Auth::logout');
    $routes->get('forgot-password',            'Auth::forgotPassword');
    $routes->post('forgot-password/send',      'Auth::sendResetLink');
    $routes->get('reset-password/(:segment)',  'Auth::resetPassword/$1');
    $routes->post('reset-password/process',    'Auth::processReset');
});

// ─── API ROUTES (AJAX / Notifikasi) ──────────────────────────────────────────
$routes->group('api', function ($routes) {
    $routes->get('notifications/count',        'Api\Notifications::count');
    $routes->post('notifications/mark-read',   'Api\Notifications::markAllRead');
    $routes->post('pusher/auth',               'Api\Notifications::pusherAuth');
});

// ─── PENGUMUMAN PUBLIK (LOGIN) ────────────────────────────────────────────────
$routes->get('announcements', 'Announcements::index');

// ─── KEPALA / ADMIN ROUTES ────────────────────────────────────────────────────
$routes->group('kepala', ['filter' => 'auth:kepala'], function ($routes) {
    $routes->get('dashboard', 'Kepala\Dashboard::index');

    // Guru Management
    $routes->get('guru',                    'Kepala\Guru::index');
    $routes->get('guru/detail/(:num)',      'Kepala\Guru::show/$1');
    $routes->get('guru/create',             'Kepala\Guru::create');
    $routes->post('guru/store',             'Kepala\Guru::store');
    $routes->get('guru/edit/(:num)',        'Kepala\Guru::edit/$1');
    $routes->post('guru/update/(:num)',     'Kepala\Guru::update/$1');
    $routes->post('guru/delete/(:num)',     'Kepala\Guru::delete/$1');

    // Wali Management
    $routes->get('wali',                    'Kepala\Wali::index');
    $routes->get('wali/detail/(:num)',      'Kepala\Wali::show/$1');
    $routes->get('wali/create',             'Kepala\Wali::create');
    $routes->post('wali/store',             'Kepala\Wali::store');
    $routes->get('wali/edit/(:num)',        'Kepala\Wali::edit/$1');
    $routes->post('wali/update/(:num)',     'Kepala\Wali::update/$1');
    $routes->post('wali/delete/(:num)',     'Kepala\Wali::delete/$1');

    // Kelas Management
    $routes->get('kelas',                   'Kepala\Kelas::index');
    $routes->get('kelas/detail/(:num)',     'Kepala\Kelas::show/$1');
    $routes->get('kelas/create',            'Kepala\Kelas::create');
    $routes->post('kelas/store',            'Kepala\Kelas::store');
    $routes->get('kelas/edit/(:num)',       'Kepala\Kelas::edit/$1');
    $routes->post('kelas/update/(:num)',    'Kepala\Kelas::update/$1');
    $routes->post('kelas/delete/(:num)',    'Kepala\Kelas::delete/$1');

    // Santri Management
    $routes->get('santri',                  'Kepala\Santri::index');
    $routes->get('santri/detail/(:num)',    'Kepala\Santri::show/$1');
    $routes->get('santri/print/(:num)',     'Kepala\Santri::print/$1');
    $routes->get('santri/export',           'Kepala\Santri::export');
    $routes->get('santri/create',           'Kepala\Santri::create');
    $routes->post('santri/store',           'Kepala\Santri::store');
    $routes->get('santri/edit/(:num)',      'Kepala\Santri::edit/$1');
    $routes->post('santri/update/(:num)',   'Kepala\Santri::update/$1');
    $routes->post('santri/delete/(:num)',   'Kepala\Santri::delete/$1');

    // Academic Year Management
    $routes->get('academic-year',                   'Kepala\AcademicYear::index');
    $routes->get('academic-year/create',            'Kepala\AcademicYear::create');
    $routes->post('academic-year/store',            'Kepala\AcademicYear::store');
    $routes->get('academic-year/activate/(:num)',   'Kepala\AcademicYear::activate/$1');
    $routes->post('academic-year/delete/(:num)',    'Kepala\AcademicYear::delete/$1');

    // Announcement Management
    $routes->get('announcements',                   'Kepala\Announcements::index');
    $routes->get('announcements/create',            'Kepala\Announcements::create');
    $routes->post('announcements/store',            'Kepala\Announcements::store');
    $routes->get('announcements/edit/(:num)',       'Kepala\Announcements::edit/$1');
    $routes->post('announcements/update/(:num)',    'Kepala\Announcements::update/$1');
    $routes->post('announcements/delete/(:num)',    'Kepala\Announcements::delete/$1');

    // Laporan
    $routes->get('nilai',       'Kepala\Nilai::index');
    $routes->get('spp',         'Kepala\Spp::index');
    $routes->get('master-spp',  'Kepala\MasterSpp::index');
    $routes->post('master-spp/update', 'Kepala\MasterSpp::update');
});

// ─── GURU ROUTES ──────────────────────────────────────────────────────────────
$routes->group('guru', ['filter' => 'auth:guru'], function ($routes) {
    $routes->get('dashboard', 'Guru\Dashboard::index');

    // Absensi
    $routes->get('absensi',                 'Guru\Absensi::index');
    $routes->get('absensi/input/(:num)',    'Guru\Absensi::input/$1');
    $routes->post('absensi/store',          'Guru\Absensi::store');
    $routes->get('absensi/rekap/(:num)',    'Guru\Absensi::rekap/$1');

    // Nilai / Evaluasi Raport
    $routes->get('nilai',                   'Guru\Nilai::index');
    $routes->get('input-nilai',             'Guru\Nilai::index');
    $routes->get('nilai/input/(:num)',      'Guru\Nilai::input/$1');
    $routes->get('nilai/evaluasi/(:num)',   'Guru\Nilai::evaluasi/$1');
    $routes->post('nilai/store-evaluasi',   'Guru\Nilai::storeEvaluasi');

    // Tahfidz - Master Data
    $routes->get('tahfidz',                 'Guru\Tahfidz::index');
    $routes->get('tahfidz/create',          'Guru\Tahfidz::create');
    $routes->post('tahfidz/store',          'Guru\Tahfidz::store');
    $routes->get('tahfidz/edit/(:num)',     'Guru\Tahfidz::edit/$1');
    $routes->post('tahfidz/update/(:num)', 'Guru\Tahfidz::update/$1');
    $routes->post('tahfidz/delete/(:num)', 'Guru\Tahfidz::delete/$1');

    // Tahfidz - Input Hafalan Per Santri
    $routes->get('tahfidz/input',           'Guru\Tahfidz::inputIndex');
    $routes->get('tahfidz/input/(:num)',    'Guru\Tahfidz::input/$1');
    $routes->post('tahfidz/input/store',   'Guru\Tahfidz::storeInput');

    // Catatan Perkembangan Santri
    $routes->get('perkembangan',                    'Guru\Perkembangan::index');
    $routes->get('perkembangan/form/(:num)',        'Guru\Perkembangan::form/$1');
    $routes->post('perkembangan/save',              'Guru\Perkembangan::save');
    $routes->post('perkembangan/delete/(:num)',     'Guru\Perkembangan::delete/$1');
});

// ─── WALI ROUTES ──────────────────────────────────────────────────────────────
$routes->group('wali', ['filter' => 'auth:wali'], function ($routes) {
    $routes->get('dashboard',               'Wali\Dashboard::index');
    $routes->get('raport',                  'Wali\Raport::index');
    $routes->get('raport/detail/(:num)',    'Wali\Raport::detail/$1');
    $routes->get('spp',                     'Wali\Spp::index');
    $routes->get('spp/history',             'Wali\Spp::history');
    $routes->post('spp/pay',               'Wali\Spp::pay');
});
