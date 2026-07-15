<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel; // Pastikan Model User dipanggil di sini

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        helper('form');
        // Inisialisasi UserModel agar bisa dipakai di seluruh fungsi dalam controller ini
        $this->userModel = new UserModel(); 
    }

    // --- 1. FUNGSI LOGIN ---
    public function login()
    {
        if ($this->request->getPost()) {
            // Asumsi: input name di v_login.php menggunakan 'username' untuk mengisi email
            $email = $this->request->getVar('username'); 
            $password = $this->request->getVar('password');

            // 1. Cari user di database berdasarkan email (Menggunakan Model)
            $user = $this->userModel->where('email', $email)->first();

            if ($user) {
                // 2. Cek password menggunakan password_verify
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
                    // Tambahan: withInput() agar email yang diketik tidak hilang saat gagal
                    return redirect()->back()->withInput(); 
                }
            } else {
                session()->setFlashdata('failed', 'Email Tidak Terdaftar');
                return redirect()->back()->withInput();
            }
        } else {
            return view('v_login');
        }
    }

    // --- 2. FUNGSI TAMPILAN REGISTER ---
    public function register()
    {
        // Tampilkan halaman view register
        return view('v_register');
    }

    // --- 3. FUNGSI PROSES SIMPAN REGISTER ---
    public function process_register()
    {
        // 1. Validasi Input
        $rules = [
            'nama'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'no_telp'  => 'required|numeric|min_length[10]',
            'password' => 'required|min_length[6]'
        ];

        $messages = [
            'email' => [
                'is_unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau Login.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            // Jika validasi gagal, kembalikan ke halaman register beserta errornya
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Siapkan data dari form
        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'no_telp'  => $this->request->getPost('no_telp'),
            // WAJIB: Hash password demi keamanan (Ini akan dicocokkan oleh password_verify di fungsi login)
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'member' // Default role
        ];

        // 3. Simpan ke database
        $this->userModel->save($data);

        // 4. Redirect ke halaman login dengan pesan sukses
        return redirect()->to(base_url('login'))->with('success', 'Pendaftaran berhasil! Silakan Login.');
    }

    // --- 4. FUNGSI LOGOUT ---
    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}