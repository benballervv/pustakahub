<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Pastikan user sudah login (DIUBAH KE isLoggedIn AGAR SESUAI DENGAN AUTHCONTROLLER)
        if (!session()->get('isLoggedIn')) { 
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Ambil role user saat ini dari session
        $userRole = session()->get('role'); // Isinya bisa 'Admin', 'Pustakawan', atau 'Member'

        // 3. Cek parameter argumen yang dikirim dari Routes
        if (!empty($arguments)) {
            // Mengubah semua argumen dari rute menjadi huruf kecil
            $allowedRoles = array_map('strtolower', $arguments);
            
            // Mengubah role user menjadi huruf kecil dan mencocokkannya
            if (!in_array(strtolower($userRole), $allowedRoles)) {
                // Tampilkan pesan error atau lempar ke halaman dashboard utama
                return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki hak akses untuk fitur tersebut.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu diisi untuk proteksi sebelum request
    }
}