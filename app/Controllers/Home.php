<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\BukuModel; // 👈 Pastikan kamu sudah membuat BukuModel sebelumnya

class Home extends BaseController
{
    public function index()
    {
        // Instansiasi Model
        $anggotaModel = new AnggotaModel();
        $bukuModel = new BukuModel(); 

        // Menghitung jumlah total data
        $data = [
            // Menghitung semua data di tabel buku
            'total_buku' => $bukuModel->countAll(), 
            
            // Menghitung khusus user dengan role 'Member' (Opsional, jika ingin hitung semua gunakan countAll() saja)
            'total_anggota' => $anggotaModel->where('role', 'Member')->countAllResults() 
        ];

        // Kirim variabel $data ke view dashboard kamu
        return view('v_home', $data); // Sesuaikan nama view dashboard-mu
    }
}