<?php

namespace App\Models;

use CodeIgniter\Model;

class DendaModel extends Model
{
    protected $table = 'fines';
    protected $primaryKey = 'id_bayar';

    protected $allowedFields = [
        'id_pinjam',
        'jumlah_bayar',
        'order_id',
        'snap_token',
        'status_pembayaran',
        'created_at'
    ];
    public function getDendaWithUser($idBayar)
{
    return $this->select('
        fines.*,
        users.nama,
        users.email,
        loans.id_user
    ')
    ->join('loans', 'loans.id_pinjam = fines.id_pinjam')
    ->join('users', 'users.id_user = loans.id_user')
    ->where('fines.id_bayar', $idBayar)
    ->first();
}

    // Tambahkan function ini
    public function getSemuaDenda()
    {
        return $this->select('
                fines.*,
                users.nama,
                books.judul
            ')
            ->join('loans', 'loans.id_pinjam = fines.id_pinjam')
            ->join('users', 'users.id_user = loans.id_user')
            ->join('book_copies', 'book_copies.id_eksemplar = loans.id_eksemplar')
            ->join('books', 'books.id_buku = book_copies.id_buku')
            ->orderBy('fines.id_bayar', 'DESC')
            ->findAll();
    }
}