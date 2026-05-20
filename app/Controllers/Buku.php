<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Buku extends BaseController
{
    protected $bukuModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
    }

    public function index()
    {
        $data['daftar_buku'] = $this->bukuModel->findAll();
        return view('v_buku', $data);
    }

    // 1. FUNGSI SIMPAN (TAMBAH BUKU)
    public function simpan()
    {
        $this->bukuModel->save([
            'isbn'         => $this->request->getPost('isbn'),
            'judul'        => $this->request->getPost('judul'),
            'penulis'      => $this->request->getPost('penulis'),
            'penerbit'     => $this->request->getPost('penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'cover_url'    => $this->request->getPost('cover_url')
        ]);

        return redirect()->to(base_url('buku'))->with('success', 'Buku berhasil ditambahkan!');
    }

    public function update()
    {
        // Memanggil model Buku
        $model = new \App\Models\BukuModel();

        // Ambil ID buku yang mau di-update dari input hidden form
        $id_buku = $this->request->getPost('id_buku'); 

        // Ambil data baru dari form modal
        $data = [
            'isbn'         => $this->request->getPost('isbn'),
            'judul'        => $this->request->getPost('judul'),
            'penulis'      => $this->request->getPost('penulis'),
            'penerbit'     => $this->request->getPost('penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'cover_url'    => $this->request->getPost('cover_url'),
        ];

        // Proses update ke database
        $model->update($id_buku, $data);

        // Kembalikan ke halaman buku dengan pesan sukses
        return redirect()->to(base_url('buku'))->with('success', 'Data buku berhasil diperbarui!');
    }

    // 3. FUNGSI HAPUS
    public function hapus($id)
    {
        $this->bukuModel->delete($id);
        return redirect()->to(base_url('buku'))->with('success', 'Buku berhasil dihapus!');
    }
}