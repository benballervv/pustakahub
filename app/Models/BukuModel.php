<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table            = 'books'; // Nama tabel di database Anda
    protected $primaryKey       = 'id_buku'; // Primary key asli sesuai gambar
    protected $allowedFields    = ['isbn', 'judul', 'penulis', 'penerbit', 'tahun_terbit', 'cover_url'];
}