<?php
namespace App\Models;

use CodeIgniter\Model;

class DendaModel extends Model
{
    protected $table            = 'fines';
    protected $primaryKey       = 'id_bayar';
    protected $allowedFields    = ['id_pinjam', 'jumlah_bayar', 'snap_token', 'status_pembayaran', 'created_at'];
}