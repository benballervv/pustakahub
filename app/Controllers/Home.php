<?php
namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\BukuModel;

class Home extends BaseController
{
    public function index()
    {
        $anggotaModel = new AnggotaModel();
        $bukuModel = new BukuModel(); 
        $peminjamanModel = new \App\Models\PeminjamanModel();
        $dendaModel = new \App\Models\DendaModel();

        // Ambil 5 aktivitas terbaru (peminjaman atau pengembalian)
        $recent_activity = $peminjamanModel->select('loans.*, users.nama as nama_anggota, books.judul')
            ->join('users', 'users.id_user = loans.id_user')
            ->join('book_copies', 'book_copies.id_eksemplar = loans.id_eksemplar')
            ->join('books', 'books.id_buku = book_copies.id_buku')
            ->orderBy('loans.updated_at', 'DESC')
            ->limit(5)
            ->findAll();

        $data = [
            'total_buku' => $bukuModel->countAll(), 
            'total_anggota' => $anggotaModel->where('role', 'Member')->countAllResults(),
            'peminjaman_aktif' => $peminjamanModel->where('status_pinjam', 'dipinjam')->countAllResults(),
            'denda_belum_dibayar' => $dendaModel->where('status_pembayaran', 'pending')->countAllResults(),
            'recent_activity' => $recent_activity
        ];
        return view('v_home', $data);
    }
}

