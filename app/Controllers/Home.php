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

        
        $data = [
            'total_buku' => $bukuModel->countAll(), 
            
            'total_anggota' => $anggotaModel->where('role', 'Member')->countAllResults() 
        ];
        return view('v_home', $data);
    }
}