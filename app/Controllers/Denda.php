<?php

namespace App\Controllers;

use App\Models\DendaModel;

class Denda extends BaseController
{
    public function index()
    {
        $dendaModel = new DendaModel();

        $data['denda'] = $dendaModel->getSemuaDenda();

        return view('v_denda/index', $data);
    }

    public function lunas_manual($id)
    {
        if (!session()->get('isLoggedIn') || !in_array(strtolower(session()->get('role')), ['admin', 'pustakawan'])) {
            return redirect()->to(base_url('login'));
        }

        $dendaModel = new DendaModel();
        
        $dendaModel->update($id, [
            'status_pembayaran' => 'paid'
        ]);

        return redirect()->back()->with('success', 'Status denda berhasil ditandai Lunas secara manual.');
    }
}