<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\PeminjamanModel;
use App\Libraries\NotificationService;

class SendReminder extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'App';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'app:send_reminder';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi WA H-1 jatuh tempo';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'app:send_reminder';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        CLI::write('Mengecek data peminjaman H-1...', 'yellow');

        $peminjamanModel = new PeminjamanModel();
        $notifService = new NotificationService();

        // Cari yang jatuh tempo BESOK (H-1)
        $besok = date('Y-m-d', strtotime('+1 day'));

        $loans = $peminjamanModel->select('loans.*, users.nama as nama_anggota, users.no_telp, books.judul')
            ->join('users', 'users.id_user = loans.id_user')
            ->join('book_copies', 'book_copies.id_eksemplar = loans.id_eksemplar')
            ->join('books', 'books.id_buku = book_copies.id_buku')
            ->where('loans.status_pinjam', 'dipinjam')
            ->where('loans.tgl_jatuh_tempo', $besok)
            ->findAll();

        $count = 0;
        foreach ($loans as $loan) {
            if (!empty($loan['no_telp'])) {
                $pesan = "Halo {$loan['nama_anggota']},\n\n"
                       . "Mengingatkan bahwa buku *{$loan['judul']}* yang Anda pinjam akan **JATUH TEMPO BESOK** ({$loan['tgl_jatuh_tempo']}).\n\n"
                       . "Harap segera dikembalikan untuk menghindari denda keterlambatan (Rp 2.000/hari).\n\n"
                       . "Terima kasih,\nPustakaHub";

                $notifService->sendWhatsAppMessage($loan['no_telp'], $pesan);
                $count++;
            }
        }

        CLI::write("Berhasil mengirim $count notifikasi pengingat.", 'green');
    }
}
