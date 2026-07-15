<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\EksemplarModel; // Tetap di-use jika Anda butuh untuk fungsi lain ke depannya

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
        // --- A. VALIDASI ISBN ---
        $rules = [
            'isbn' => [
                'rules'  => 'required|is_unique[books.isbn]', // Disamakan menjadi 'books'
                'errors' => [
                    'required'  => 'ISBN wajib diisi.',
                    'is_unique' => 'Gagal! Buku dengan ISBN ini sudah terdaftar di sistem.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getError('isbn'));
        }

        // --- B. LOGIKA UPLOAD COVER ---
        $coverSistem = $this->request->getPost('cover_url'); 
        $fileCover   = $this->request->getFile('cover_file'); 

        if ($fileCover && $fileCover->isValid() && !$fileCover->hasMoved()) {
            $namaGambar = $fileCover->getRandomName();
            $fileCover->move('uploads/cover', $namaGambar);
            $coverSistem = base_url('uploads/cover/' . $namaGambar);
        }

        // --- C. SIMPAN DATA ---
        $this->bukuModel->save([
            'isbn'         => $this->request->getPost('isbn'),
            'judul'        => $this->request->getPost('judul'),
            'penulis'      => $this->request->getPost('penulis'),
            'penerbit'     => $this->request->getPost('penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'cover_url'    => $coverSistem 
        ]);

        return redirect()->to(base_url('buku'))->with('success', 'Buku berhasil ditambahkan!');
    }

    // 2. FUNGSI UPDATE
    public function update()
    {
        $id_buku = $this->request->getPost('id_buku'); 

        // --- A. VALIDASI ISBN UNTUK UPDATE ---
        $rules = [
            'isbn' => [
                // Disamakan menjadi 'books' agar tidak error saat update
                'rules'  => "required|is_unique[books.isbn,id_buku,{$id_buku}]", 
                'errors' => [
                    'is_unique' => 'Gagal! ISBN sudah digunakan oleh data buku lain.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getError('isbn'));
        }

        // --- B. LOGIKA UPLOAD COVER ---
        $coverSistem = $this->request->getPost('cover_url'); 
        $fileCover   = $this->request->getFile('cover_file');

        if ($fileCover && $fileCover->isValid() && !$fileCover->hasMoved()) {
            $namaGambar = $fileCover->getRandomName();
            $fileCover->move('uploads/cover', $namaGambar);
            $coverSistem = base_url('uploads/cover/' . $namaGambar);
        }

        // --- C. UPDATE DATA ---
        $data = [
            'isbn'         => $this->request->getPost('isbn'),
            'judul'        => $this->request->getPost('judul'),
            'penulis'      => $this->request->getPost('penulis'),
            'penerbit'     => $this->request->getPost('penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'cover_url'    => $coverSistem,
        ];

        $this->bukuModel->update($id_buku, $data);

        return redirect()->to(base_url('buku'))->with('success', 'Data buku berhasil diperbarui!');
    }

    // 3. FUNGSI HAPUS
    public function hapus($id)
    {
        $this->bukuModel->delete($id);
        return redirect()->to(base_url('buku'))->with('success', 'Buku berhasil dihapus!');
    }
    
    // 4. FUNGSI KATALOG (SEARCH BOOK)
    public function katalog()
    {
        // Tangkap input 'keyword' dari Header Form GET
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            // Pencarian langsung ke tabel books (berdasarkan Judul atau ISBN)
            // Menggunakan groupStart() agar kondisi OR LIKE dibungkus dengan aman
            $data['katalog_buku'] = $this->bukuModel->groupStart()
                                                    ->like('judul', $keyword)
                                                    ->orLike('isbn', $keyword)
                                                    ->groupEnd()
                                                    ->findAll();
        } else {
            // Jika tidak ada keyword pencarian, tampilkan semua buku
            $data['katalog_buku'] = $this->bukuModel->findAll();
        }
        
        // Simpan keyword ke data untuk ditampilkan kembali di input pencarian View
        $data['keyword'] = $keyword;

        // Lempar ke file v_katalog.php (Variabel yang dilempar sekarang adalah $katalog_buku)
        return view('v_katalog', $data);
    }
}