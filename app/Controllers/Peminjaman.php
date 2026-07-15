<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\EksemplarModel;
use App\Models\DendaModel;
use App\Models\AnggotaModel;

class Peminjaman extends BaseController
{
    // 1. TAMPILKAN DAFTAR TRANSAKSI
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $peminjamanModel = new PeminjamanModel();
        
        $data['transaksi'] = $peminjamanModel->getSemuaTransaksi();
        return view('v_peminjaman/index', $data);
    }

    // 2. TAMPILKAN FORM TAMBAH PINJAMAN
    public function tambah()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $eksemplarModel = new EksemplarModel();
        $anggotaModel   = new AnggotaModel();

        $data['eksemplar'] = $eksemplarModel->getEksemplarReady();
        $data['anggota']   = $anggotaModel->getHanyaMember();
        
        return view('v_peminjaman/tambah', $data);
    }

    // 3. PROSES SIMPAN TRANSAKSI & PENGURANGAN STOK
    public function simpan()
    {
        $peminjamanModel = new PeminjamanModel();
        $eksemplarModel  = new EksemplarModel();
        $id_eksemplar    = $this->request->getPost('id_eksemplar');

        $peminjamanModel->save([
            'id_user'         => $this->request->getPost('id_user'),
            'id_eksemplar'    => $id_eksemplar,
            'tgl_pinjam'      => $this->request->getPost('tgl_pinjam'),
            'tgl_jatuh_tempo' => $this->request->getPost('tgl_jatuh_tempo'),
            'status_pinjam'   => 'dipinjam'
        ]);

        $eksemplarModel->update($id_eksemplar, ['status_tersedia' => 'dipinjam']);

        return redirect()->to(base_url('peminjaman'))->with('success', 'Transaksi peminjaman berhasil dicatat! Stok eksemplar otomatis berkurang.');
    }

    public function kembali($id_pinjam)
    {
        $peminjamanModel = new PeminjamanModel();
        $eksemplarModel  = new EksemplarModel();
        $dendaModel      = new DendaModel();

        $pinjam = $peminjamanModel->find($id_pinjam);
        
        if (!$pinjam) {
            return redirect()->to(base_url('peminjaman'))->with('success', 'Error: Data peminjaman dengan ID ' . esc($id_pinjam) . ' tidak ditemukan di database!');
        }

        $tgl_kembali = date('Y-m-d');
        
        $jatuh_tempo   = strtotime($pinjam['tgl_jatuh_tempo']);
        $hari_kembali  = strtotime($tgl_kembali);
        $status_pinjam = 'kembali';
        
        if ($hari_kembali > $jatuh_tempo) {
            $status_pinjam = 'terlambat';
            $selisih_detik = $hari_kembali - $jatuh_tempo;
            $jumlah_hari   = floor($selisih_detik / (60 * 60 * 24));
            
            $total_denda = $jumlah_hari * 2000; 

            $dendaModel->save([
                'id_pinjam'         => $id_pinjam,
                'jumlah_bayar'      => $total_denda,
                'status_pembayaran' => 'pending',
                'created_at'        => date('Y-m-d H:i:s')
            ]);
        }

        $peminjamanModel->update($id_pinjam, [
            'tgl_kembali'   => $tgl_kembali,
            'status_pinjam' => $status_pinjam
        ]);

        $eksemplarModel->update($pinjam['id_eksemplar'], ['status_tersedia' => 'tersedia']);

        if ($status_pinjam == 'terlambat') {
            return redirect()->to(base_url('peminjaman'))->with('success', 'Buku berhasil dikembalikan. Anggota terlambat ' . $jumlah_hari . ' hari, denda sebesar Rp ' . number_format($total_denda) . ' otomatis ditambahkan!');
        }

        return redirect()->to(base_url('peminjaman'))->with('success', 'Buku dikembalikan tepat waktu! Status eksemplar ready kembali.');
    }
}