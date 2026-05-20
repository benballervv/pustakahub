<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel; // 👈 Panggil nama model yang baru di sini

class Anggota extends BaseController
{
    public function index()
    {
        // Pengaman session login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        // Instansiasi model baru
        $anggotaModel = new AnggotaModel(); 
        
        // Mengambil semua data user (Admin, Pustakawan, Member)
        $data['daftar_anggota'] = $anggotaModel->findAll(); 
        
        // Catatan: Jika ingin menampilkan ROLE MEMBER SAJA di tabel, 
        // hapus baris diatas dan gunakan fungsi custom ini:
        // $data['daftar_anggota'] = $anggotaModel->getHanyaMember();

        // Kirim data ke view
        return view('v_anggota', $data);
    }
}