<?php

namespace App\Controllers;

use App\Models\DendaModel;
use Midtrans\Snap;
use Midtrans\Notification;

class Payment extends BaseController
{
    protected $dendaModel;

    public function __construct()
    {
        $this->dendaModel = new DendaModel();

        // Inisialisasi Midtrans
        \Config\Midtrans::init();
    }

    public function index($id)
    {
        $denda = $this->dendaModel->getDendaWithUser($id);

        if (!$denda) {
            return redirect()->to('/denda')
                ->with('error', 'Data denda tidak ditemukan.');
        }

        return view('payment/index', [
            'denda' => $denda
        ]);
    }

    public function token()
    {
        $id = $this->request->getPost('id');

        $denda = $this->dendaModel->find($id);

        if (!$denda) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data denda tidak ditemukan'
            ]);
        }

        try {
            $orderId = 'DENDA-' . $denda['id_bayar'] . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $denda['jumlah_bayar']
                ]
            ];

            $snapToken = Snap::getSnapToken($params);

            // Simpan Snap Token dan Order ID ke database
            $this->dendaModel->update($id, [
                'order_id' => $orderId,
                'snap_token' => $snapToken
            ]);

            return $this->response->setJSON([
                'status' => true,
                'snapToken' => $snapToken
            ]);

        } catch (\Exception $e) {

            return $this->response->setJSON([
                'status' => false,
                'message' => $e->getMessage()
            ]);

        }
    }

    public function callback()
{
    \Config\Midtrans::init();

    $notification = new Notification();

    $transactionStatus = $notification->transaction_status;
    $orderId = $notification->order_id;

    // Contoh order_id:
    // DENDA-4-172839293

    $explode = explode('-', $orderId);

    $idBayar = $explode[1];

    if (
        $transactionStatus == 'settlement' ||
        $transactionStatus == 'capture'
    ) {

        $this->dendaModel->update($idBayar, [

            'status_pembayaran' => 'paid'

        ]);
        $denda = $this->dendaModel->getDendaWithUser($idBayar);

        if ($denda) {
            $this->kirimEmail(
                $denda['email'],
                $denda['nama'],
                $denda['jumlah_bayar']
            );

            // Kirim WA
            if (!empty($denda['no_telp'])) {
                $notifService = new \App\Libraries\NotificationService();
                $pesan = "Halo {$denda['nama']},\n\nTerima kasih, pembayaran denda Anda sebesar Rp " . number_format($denda['jumlah_bayar'], 0, ',', '.') . " telah **BERHASIL**.\n\nStatus denda Anda sekarang adalah LUNAS.\n\nPustakaHub";
                $notifService->sendWhatsAppMessage($denda['no_telp'], $pesan);
            }
        }
    }

    return $this->response->setStatusCode(200);
}

    public function simulate($idBayar)
    {
        // Ambil data denda beserta user
        $denda = $this->dendaModel->getDendaWithUser($idBayar);

        if (!$denda) {
            return redirect()->back()->with('error', 'Data denda tidak ditemukan.');
        }

        if (empty($denda['order_id'])) {
            return redirect()->back()->with('error', 'Belum ada transaksi Midtrans. Silakan klik Bayar Sekarang terlebih dahulu.');
        }

        try {
            \Config\Midtrans::init();
            // Cek status aslinya dari Midtrans API
            $statusResponse = \Midtrans\Transaction::status($denda['order_id']);

            if ($statusResponse->transaction_status == 'settlement' || $statusResponse->transaction_status == 'capture') {
                
                // Update status pembayaran jika BENAR-BENAR lunas di Midtrans
                $this->dendaModel->update($idBayar, [
                    'status_pembayaran' => 'paid'
                ]);

                // Kirim email
                $this->kirimEmail(
                    $denda['email'],
                    $denda['nama'],
                    $denda['jumlah_bayar']
                );

                // Kirim WA
                if (!empty($denda['no_telp'])) {
                    $notifService = new \App\Libraries\NotificationService();
                    $pesan = "Halo {$denda['nama']},\n\nTerima kasih, pembayaran denda Anda sebesar Rp " . number_format($denda['jumlah_bayar'], 0, ',', '.') . " telah **BERHASIL**.\n\nStatus denda Anda sekarang adalah LUNAS.\n\nPustakaHub";
                    $notifService->sendWhatsAppMessage($denda['no_telp'], $pesan);
                }

                return redirect()->to('/denda')->with('success', 'Sinkronisasi berhasil! Pembayaran terkonfirmasi.');
            } else {
                return redirect()->back()->with('error', 'Status di Midtrans masih: ' . $statusResponse->transaction_status . '. Harap selesaikan pembayaran terlebih dahulu.');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal cek Midtrans: ' . $e->getMessage());
        }
    }
private function kirimEmail($emailTujuan, $nama, $jumlah)
{
    $email = \Config\Services::email();

    $email->setTo($emailTujuan);
    $email->setSubject('Pembayaran Denda Berhasil - PustakaHub');

    $pesan = "
        <h2>Pembayaran Berhasil</h2>

        <p>Halo <b>$nama</b>,</p>

        <p>Pembayaran denda perpustakaan Anda telah berhasil.</p>

        <table border='1' cellpadding='8'>
            <tr>
                <td>Nama</td>
                <td>$nama</td>
            </tr>

            <tr>
                <td>Jumlah Denda</td>
                <td>Rp ".number_format($jumlah,0,',','.')."</td>
            </tr>

            <tr>
                <td>Status</td>
                <td><b>LUNAS</b></td>
            </tr>
        </table>

        <br>

        Terima kasih telah menggunakan
        <b>PustakaHub</b>.
    ";

    $email->setMessage($pesan);

    return $email->send();
}
}