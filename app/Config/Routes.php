<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login/process', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// Halaman Register
// Halaman Form Register
$routes->get('/register', 'AuthController::register');

// Proses Submit Register
$routes->post('/auth/process_register', 'AuthController::process_register');
// $routes->get('/login', 'Auth::login');

// Kunci halaman utama buku HANYA untuk Admin dan Pustakawan
$routes->get('buku', 'Buku::index', ['filter' => 'cek_role:Admin,Pustakawan']);

// FITUR KHUSUS ADMIN / PUSTAKAWAN (Hanya Admin & Pustakawan yang bisa Simpan, Update, Hapus)
$routes->post('buku/simpan', 'Buku::simpan', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->post('buku/update', 'Buku::update', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->get('buku/hapus/(:num)', 'Buku::hapus/$1', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->get('buku/eksemplar/(:num)', 'Buku::eksemplar/$1', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->post('buku/simpan_eksemplar', 'Buku::simpan_eksemplar', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->post('buku/update_eksemplar', 'Buku::update_eksemplar', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->get('buku/hapus_eksemplar/(:num)/(:num)', 'Buku::hapus_eksemplar/$1/$2', ['filter' => 'cek_role:Admin,Pustakawan']);

// Menu Kelola Anggota & Laporan hanya untuk Admin
$routes->get('anggota', 'Anggota::index', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->post('anggota/simpan', 'Anggota::simpan', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->post('anggota/update', 'Anggota::update', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->get('anggota/hapus/(:num)', 'Anggota::hapus/$1', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->get('anggota/cetak_kartu/(:num)', 'Anggota::cetak_kartu/$1', ['filter' => 'cek_role:Admin,Pustakawan']);

// rute peminjaman, pengembalian, denda
$routes->get('peminjaman', 'Peminjaman::index', ['filter' => 'auth']);
$routes->get('peminjaman/tambah', 'Peminjaman::tambah', ['filter' => 'cek_role:Admin,Pustakawan,Member']);
$routes->post('peminjaman/simpan', 'Peminjaman::simpan', ['filter' => 'cek_role:Admin,Pustakawan,Member']);
$routes->get('peminjaman/kembali/(:num)', 'Peminjaman::kembali/$1', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->get('peminjaman/setujui/(:num)', 'Peminjaman::setujui/$1', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->get('peminjaman/tolak/(:num)', 'Peminjaman::tolak/$1', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->get('peminjaman/cetak_receipt/(:num)', 'Peminjaman::cetak_receipt/$1', ['filter' => 'auth']);

// Laporan routes
$routes->get('laporan', 'Laporan::index', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->get('laporan/export_pdf', 'Laporan::export_pdf', ['filter' => 'cek_role:Admin,Pustakawan']);

$routes->group('api', function($routes){
    $routes->get('buku', 'Api\BukuApi::index');
    $routes->get('buku/(:num)', 'Api\BukuApi::show/$1');
    $routes->post('buku', 'Api\BukuApi::create');
    $routes->put('buku/(:num)', 'Api\BukuApi::update/$1');
    $routes->delete('buku/(:num)', 'Api\BukuApi::delete/$1');

    // Rute API Publik untuk Mobile/Layanan Eksternal
    $routes->get('books', 'Api\BukuApi::index');
    $routes->get('books/(:any)', 'Api\BukuApi::show_by_isbn/$1');
    $routes->get('availability/(:num)', 'Api\BukuApi::availability/$1');
});

$routes->get('buku/katalog', 'Buku::katalog');
$routes->post('payment/callback', 'Payment::callback');
$routes->get('test-email', 'TestEmail::index');

/*
|--------------------------------------------------------------------------
| PAYMENT MIDTRANS
|--------------------------------------------------------------------------
*/

// Menampilkan halaman pembayaran denda
$routes->get(
    'payment/(:num)',
    'Payment::index/$1',
    ['filter' => 'auth']
);

// Membuat Snap Token Midtrans
$routes->post(
    'payment/token',
    'Payment::token',
    ['filter' => 'auth']
);

/*
|--------------------------------------------------------------------------
| DENDA
|--------------------------------------------------------------------------
*/

$routes->get(
    'denda',
    'Denda::index',
    ['filter' => 'auth']
);

$routes->get(
    'denda/lunas_manual/(:num)',
    'Denda::lunas_manual/$1',
    ['filter' => 'cek_role:Admin,Pustakawan']
);

// Simulasi pembayaran (khusus development/presentasi)
$routes->get(
    'payment/simulate/(:num)',
    'Payment::simulate/$1',
    ['filter' => 'auth']
);