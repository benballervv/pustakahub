<?php

namespace App\Models;

use CodeIgniter\Model;

class EksemplarModel extends Model
{
    protected $table            = 'book_copies';
    protected $primaryKey       = 'id_eksemplar';
    protected $allowedFields    = ['id_buku', 'kode_eksemplar', 'kondisi', 'lokasi_rak', 'status_tersedia'];

    public function getEksemplarReady()
    {
        return $this->select('book_copies.*, books.judul')
                    ->join('books', 'books.id_buku = book_copies.id_buku')
                    ->where('status_tersedia', 'tersedia')
                    ->where('kondisi', 'bagus')
                    ->findAll();
    }
}