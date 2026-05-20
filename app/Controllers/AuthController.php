<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    function __construct()
    {
        helper('form');
    }

  public function login()
{
    if ($this->request->getPost()) {
        $email = $this->request->getVar('username'); 
        $password = $this->request->getVar('password');

        // 1. Cari user di database berdasarkan email
        $db = \Config\Database::connect();
        $user = $db->table('users')->getWhere(['email' => $email])->getRowArray();

        if ($user) {
            // 2. Cek password menggunakan password_verify (pasangan password_hash di seeder)
            if (password_verify($password, $user['password'])) {
                session()->set([
                    'id_user'    => $user['id_user'],
                    'nama'       => $user['nama'],
                    'role'       => $user['role'],
                    'isLoggedIn' => TRUE
                ]);

                return redirect()->to(base_url('/'));
            } else {
                session()->setFlashdata('failed', 'Password Salah');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('failed', 'Email Tidak Terdaftar');
            return redirect()->back();
        }
    } else {
        return view('v_login');
    }
}

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}
