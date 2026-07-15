<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users'; // Sesuaikan jika nama tabel Anda berbeda
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    
    // Kolom yang boleh diisi berdasarkan gambar struktur tabel Anda
    protected $allowedFields    = ['nama', 'email', 'password', 'no_telp', 'role'];

    // Mengaktifkan otomatisasi created_at dan updated_at
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
}