<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\BukuModel;

class BukuApi extends BaseController
{
    protected $bukuModel;
    protected $apiKey = 'PUSTAKAHUB123';

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
    }

    private function cekApiKey()
    {
        $key = $this->request->getHeaderLine('X-API-KEY');

        if ($key !== $this->apiKey) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'API Key tidak valid'
                ]);
        }

        return null;
    }

    public function index()
    {
        if ($cek = $this->cekApiKey()) return $cek;

        return $this->response->setJSON([
            'status' => true,
            'data' => $this->bukuModel->findAll()
        ]);
    }

    public function show($id)
    {
        if ($cek = $this->cekApiKey()) return $cek;

        $buku = $this->bukuModel->find($id);

        if (!$buku) {
            return $this->response->setStatusCode(404)
                ->setJSON([
                    'status' => false,
                    'message' => 'Buku tidak ditemukan'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data' => $buku
        ]);
    }

    public function create()
    {
        if ($cek = $this->cekApiKey()) return $cek;

        $data = $this->request->getJSON(true);

        $this->bukuModel->insert($data);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Buku berhasil ditambahkan'
        ]);
    }

    public function update($id)
    {
        if ($cek = $this->cekApiKey()) return $cek;

        $data = $this->request->getJSON(true);

        $this->bukuModel->update($id, $data);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Buku berhasil diperbarui'
        ]);
    }

    public function delete($id)
    {
        if ($cek = $this->cekApiKey()) return $cek;

        $this->bukuModel->delete($id);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Buku berhasil dihapus'
        ]);
    }

    public function show_by_isbn($isbn)
    {
        if ($cek = $this->cekApiKey()) return $cek;

        $buku = $this->bukuModel->where('isbn', $isbn)->first();

        if (!$buku) {
            return $this->response->setStatusCode(404)
                ->setJSON([
                    'status' => false,
                    'message' => 'Buku dengan ISBN tersebut tidak ditemukan'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data' => $buku
        ]);
    }

    public function availability($id)
    {
        if ($cek = $this->cekApiKey()) return $cek;

        $eksemplarModel = new \App\Models\EksemplarModel();
        
        $tersedia = $eksemplarModel->where('id_buku', $id)
                                   ->where('status_tersedia', 'tersedia')
                                   ->countAllResults();

        $total = $eksemplarModel->where('id_buku', $id)
                                ->countAllResults();

        return $this->response->setJSON([
            'status' => true,
            'data' => [
                'id_buku' => $id,
                'total_eksemplar' => $total,
                'tersedia' => $tersedia,
                'status' => ($tersedia > 0) ? 'Available' : 'Out of Stock'
            ]
        ]);
    }
}