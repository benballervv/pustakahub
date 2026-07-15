<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;

class Anggota extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $anggotaModel = new AnggotaModel(); 
        $data['daftar_anggota'] = $anggotaModel->findAll(); 
        
        return view('v_anggota', $data);
    }

    public function simpan()
    {
        $anggotaModel = new AnggotaModel();

        $rules = [
            'email' => 'required|is_unique[users.email]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Email sudah digunakan!');
        }

        $anggotaModel->save([
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'no_telp' => $this->request->getPost('no_telp'),
            'role' => $this->request->getPost('role')
        ]);

        return redirect()->to(base_url('anggota'))->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function update()
    {
        $anggotaModel = new AnggotaModel();
        $id_user = $this->request->getPost('id_user');

        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'no_telp' => $this->request->getPost('no_telp'),
            'role' => $this->request->getPost('role')
        ];

        if (!empty($this->request->getPost('password'))) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }

        $anggotaModel->update($id_user, $data);

        return redirect()->to(base_url('anggota'))->with('success', 'Anggota berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $anggotaModel = new AnggotaModel();
        $anggotaModel->delete($id);
        return redirect()->to(base_url('anggota'))->with('success', 'Anggota berhasil dihapus!');
    }

    public function cetak_kartu($id)
    {
        $anggotaModel = new AnggotaModel();
        $anggota = $anggotaModel->find($id);

        if (!$anggota) {
            return redirect()->back()->with('error', 'Anggota tidak ditemukan.');
        }

        $html = view('v_anggota_pdf', ['anggota' => $anggota]);

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper([0, 0, 270.10, 170.07], 'portrait');
        $dompdf->render();
        
        $dompdf->stream('Kartu_Anggota_' . $anggota['nama'] . '.pdf', ['Attachment' => 0]);
    }
}