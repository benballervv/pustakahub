<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table            = 'loans';
    protected $primaryKey       = 'id_pinjam';
    protected $allowedFields    = ['id_user', 'id_eksemplar', 'tgl_pinjam', 'tgl_jatuh_tempo', 'tgl_kembali', 'status_pinjam'];

    public function getSemuaTransaksi()
    {
        return $this->select('loans.*, users.nama as nama_anggota, book_copies.kode_eksemplar, books.judul')
                    ->join('users', 'users.id_user = loans.id_user')
                    ->join('book_copies', 'book_copies.id_eksemplar = loans.id_eksemplar')
                    ->join('books', 'books.id_buku = book_copies.id_buku')
                    ->orderBy('loans.id_pinjam', 'DESC')
                    ->findAll();
    }
}