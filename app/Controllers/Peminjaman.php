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
        
        $role = strtolower((string) session()->get('role'));
        $id_user = ($role === 'member') ? session()->get('id_user') : null;

        $data['transaksi'] = $peminjamanModel->getSemuaTransaksi($id_user);
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
        
        $role = strtolower((string) session()->get('role'));
        
        // Keamanan: Jika Member, paksa id_user dari session
        $id_user = ($role === 'member') ? session()->get('id_user') : $this->request->getPost('id_user');
        
        // Status awal: diajukan untuk Member, langsung dipinjam untuk Admin
        $status_pinjam = ($role === 'member') ? 'diajukan' : 'dipinjam';
        
        $id_eksemplar = $this->request->getPost('id_eksemplar');

        $peminjamanModel->save([
            'id_user'         => $id_user,
            'id_eksemplar'    => $id_eksemplar,
            'tgl_pinjam'      => $this->request->getPost('tgl_pinjam'),
            'tgl_jatuh_tempo' => $this->request->getPost('tgl_jatuh_tempo'),
            'status_pinjam'   => $status_pinjam
        ]);

        // Tetap ubah status eksemplar jadi dipinjam agar tidak dipinjam orang lain saat menunggu persetujuan
        $eksemplarModel->update($id_eksemplar, ['status_tersedia' => 'dipinjam']);

        $pesanSukses = ($role === 'member') ? 'Pengajuan peminjaman berhasil dikirim! Menunggu persetujuan Pustakawan.' : 'Transaksi peminjaman berhasil dicatat! Stok eksemplar otomatis berkurang.';
        
        return redirect()->to(base_url('peminjaman'))->with('success', $pesanSukses);
    }

    // 4. SETUJUI PEMINJAMAN
    public function setujui($id_pinjam)
    {
        $peminjamanModel = new PeminjamanModel();
        
        $peminjamanModel->update($id_pinjam, [
            'status_pinjam' => 'dipinjam'
        ]);

        // Panggil WA API notifikasi
        $pinjam = $peminjamanModel->select('loans.*, users.nama as nama_anggota, users.no_telp, books.judul')
            ->join('users', 'users.id_user = loans.id_user')
            ->join('book_copies', 'book_copies.id_eksemplar = loans.id_eksemplar')
            ->join('books', 'books.id_buku = book_copies.id_buku')
            ->where('loans.id_pinjam', $id_pinjam)
            ->first();

        if ($pinjam && !empty($pinjam['no_telp'])) {
            $notifService = new \App\Libraries\NotificationService();
            $pesan = "Halo {$pinjam['nama_anggota']},\n\nPengajuan peminjaman buku *{$pinjam['judul']}* telah **DISETUJUI**.\n\nHarap kembalikan buku paling lambat tanggal {$pinjam['tgl_jatuh_tempo']}.\n\nTerima kasih,\nPustakaHub";
            $notifService->sendWhatsAppMessage($pinjam['no_telp'], $pesan);
        }

        return redirect()->to(base_url('peminjaman'))->with('success', 'Peminjaman berhasil disetujui!');
    }

    // 5. TOLAK PEMINJAMAN
    public function tolak($id_pinjam)
    {
        $peminjamanModel = new PeminjamanModel();
        $eksemplarModel  = new EksemplarModel();

        $pinjam = $peminjamanModel->find($id_pinjam);
        if ($pinjam) {
            // Kembalikan status eksemplar ke tersedia
            $eksemplarModel->update($pinjam['id_eksemplar'], ['status_tersedia' => 'tersedia']);
            // Hapus data peminjaman yang diajukan
            $peminjamanModel->delete($id_pinjam);
        }

        return redirect()->to(base_url('peminjaman'))->with('success', 'Pengajuan peminjaman ditolak dan dibatalkan.');
    }

    // 6. CETAK RECEIPT (TANDA TERIMA)
    public function cetak_receipt($id_pinjam)
    {
        $peminjamanModel = new PeminjamanModel();
        
        // Query manual / bisa dibuat function di model. 
        // Menggunakan join agar data buku dan anggota lengkap.
        $data['transaksi'] = $peminjamanModel->select('loans.*, users.nama as nama_anggota, users.email, book_copies.kode_eksemplar, books.judul')
            ->join('users', 'users.id_user = loans.id_user')
            ->join('book_copies', 'book_copies.id_eksemplar = loans.id_eksemplar')
            ->join('books', 'books.id_buku = book_copies.id_buku')
            ->where('loans.id_pinjam', $id_pinjam)
            ->first();

        if (!$data['transaksi']) {
            return redirect()->to(base_url('peminjaman'))->with('error', 'Transaksi tidak ditemukan!');
        }

        $html = view('v_peminjaman/receipt', $data);

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $dompdf->stream('Tanda_Terima_Peminjaman_' . $id_pinjam . '.pdf', ['Attachment' => 0]);
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

    // 8. KIRIM NOTIFIKASI MANUAL (WA)
    public function kirim_notif_manual($id_pinjam)
    {
        $peminjamanModel = new PeminjamanModel();
        
        $pinjam = $peminjamanModel->select('loans.*, users.nama as nama_anggota, users.no_telp, books.judul')
            ->join('users', 'users.id_user = loans.id_user')
            ->join('book_copies', 'book_copies.id_eksemplar = loans.id_eksemplar')
            ->join('books', 'books.id_buku = book_copies.id_buku')
            ->where('loans.id_pinjam', $id_pinjam)
            ->first();

        if ($pinjam && !empty($pinjam['no_telp'])) {
            $notifService = new \App\Libraries\NotificationService();
            $pesan = "Halo {$pinjam['nama_anggota']},\n\nIni adalah pesan pengingat dari PustakaHub.\nMohon segera periksa status peminjaman buku *{$pinjam['judul']}* Anda yang berstatus: *{$pinjam['status_pinjam']}*.\n\nJatuh tempo: {$pinjam['tgl_jatuh_tempo']}\n\nTerima kasih.";
            
            $notifService->sendWhatsAppMessage($pinjam['no_telp'], $pesan);
            
            return redirect()->to(base_url('peminjaman'))->with('success', 'Notifikasi manual via WhatsApp berhasil dikirim ke anggota!');
        }

        return redirect()->to(base_url('peminjaman'))->with('error', 'Gagal mengirim notifikasi. Pastikan data peminjaman valid dan nomor telepon anggota tersedia.');
    }
}