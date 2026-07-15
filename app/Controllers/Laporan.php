<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Laporan extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn') || !in_array(strtolower(session()->get('role')), ['admin', 'pustakawan'])) {
            return redirect()->to(base_url('login'));
        }

        $peminjamanModel = new PeminjamanModel();

        // 1. Peminjaman Aktif (Status = dipinjam)
        $aktif = $peminjamanModel->select('loans.*, users.nama as nama_anggota, books.judul, book_copies.kode_eksemplar')
            ->join('users', 'users.id_user = loans.id_user')
            ->join('book_copies', 'book_copies.id_eksemplar = loans.id_eksemplar')
            ->join('books', 'books.id_buku = book_copies.id_buku')
            ->where('status_pinjam', 'dipinjam')
            ->findAll();

        // 2. Buku Terlambat (Status = dipinjam, tgl_jatuh_tempo < hari ini)
        $terlambat = [];
        $hari_ini = date('Y-m-d');
        foreach ($aktif as $loan) {
            if ($loan['tgl_jatuh_tempo'] < $hari_ini) {
                $terlambat[] = $loan;
            }
        }

        // 3. Statistik Bulanan (Berdasarkan tgl_pinjam untuk tahun ini)
        $tahun_ini = date('Y');
        $statistik = $peminjamanModel->select('MONTH(tgl_pinjam) as bulan, COUNT(id_pinjam) as total')
            ->where('YEAR(tgl_pinjam)', $tahun_ini)
            ->groupBy('MONTH(tgl_pinjam)')
            ->findAll();

        $data = [
            'aktif' => $aktif,
            'terlambat' => $terlambat,
            'statistik' => $statistik,
            'tahun' => $tahun_ini
        ];

        return view('v_laporan/index', $data);
    }

    public function export_pdf()
    {
        if (!session()->get('isLoggedIn') || !in_array(strtolower(session()->get('role')), ['admin', 'pustakawan'])) {
            return redirect()->to(base_url('login'));
        }

        $peminjamanModel = new PeminjamanModel();

        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $laporan = $peminjamanModel->select('loans.*, users.nama as nama_anggota, books.judul, book_copies.kode_eksemplar')
            ->join('users', 'users.id_user = loans.id_user')
            ->join('book_copies', 'book_copies.id_eksemplar = loans.id_eksemplar')
            ->join('books', 'books.id_buku = book_copies.id_buku')
            ->where('MONTH(tgl_pinjam)', $bulan)
            ->where('YEAR(tgl_pinjam)', $tahun)
            ->findAll();

        $data = [
            'laporan' => $laporan,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];

        $html = view('v_laporan/pdf', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('Laporan_Peminjaman_' . $bulan . '_' . $tahun . '.pdf', ['Attachment' => 1]);
    }
}
