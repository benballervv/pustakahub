<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login/process', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// Daftarkan route untuk halaman anggota
$routes->get('anggota', 'Anggota::index');
// --- Routes untuk fitur Buku ---
$routes->get('buku', 'Buku::index'); // Halaman utama buku (Bisa dilihat siapa saja yang lolos filter global)

// FITUR KHUSUS ADMIN / PUSTAKAWAN (Hanya Admin & Pustakawan yang bisa Simpan, Update, Hapus)
$routes->post('buku/simpan', 'Buku::simpan', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->post('buku/update', 'Buku::update', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->get('buku/hapus/(:num)', 'Buku::hapus/$1', ['filter' => 'cek_role:Admin,Pustakawan']);

// Menu Kelola Anggota & Laporan hanya untuk Admin
$routes->get('anggota', 'Anggota::index', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->get('laporan', 'Laporan::index', ['filter' => 'cek_role:Admin']);

// rute peminjaman, pengembalian, denda
$routes->get('peminjaman', 'Peminjaman::index', ['filter' => 'auth']);
$routes->get('peminjaman/tambah', 'Peminjaman::tambah', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->post('peminjaman/simpan', 'Peminjaman::simpan', ['filter' => 'cek_role:Admin,Pustakawan']);
$routes->get('peminjaman/kembali/(:num)', 'Peminjaman::kembali/$1', ['filter' => 'cek_role:Admin,Pustakawan']);