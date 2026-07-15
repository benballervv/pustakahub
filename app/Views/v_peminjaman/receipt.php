<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima Peminjaman - PustakaHub</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; background: #fff; padding: 20px; color: #000; }
        .receipt-container { max-width: 400px; margin: 0 auto; border: 1px dashed #333; padding: 20px; }
        h3 { text-align: center; margin-top: 0; }
        .divider { border-bottom: 1px dashed #333; margin: 15px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 5px 0; font-size: 14px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        .footer-note { font-size: 12px; text-align: center; margin-top: 20px; }
        @media print {
            body { padding: 0; }
            .receipt-container { border: none; max-width: 100%; }
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <h3>📖 PUSTAKAHUB</h3>
    <div class="text-center" style="font-size: 12px; margin-top: -10px;">
        Tanda Terima Peminjaman Buku<br>
        Jl. Kampus Merdeka No. 123
    </div>

    <div class="divider"></div>

    <table>
        <tr>
            <td>No. Transaksi</td>
            <td class="text-right">#<?= str_pad($transaksi['id_pinjam'], 5, '0', STR_PAD_LEFT) ?></td>
        </tr>
        <tr>
            <td>Tanggal Cetak</td>
            <td class="text-right"><?= date('d M Y H:i') ?></td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td class="bold" colspan="2">Peminjam:</td>
        </tr>
        <tr>
            <td colspan="2"><?= esc($transaksi['nama_anggota']) ?> (<?= esc($transaksi['email']) ?>)</td>
        </tr>
        <tr><td colspan="2" style="height: 10px;"></td></tr>
        
        <tr>
            <td class="bold" colspan="2">Buku yang Dipinjam:</td>
        </tr>
        <tr>
            <td colspan="2"><?= esc($transaksi['judul']) ?></td>
        </tr>
        <tr>
            <td>Kode Eksemplar</td>
            <td class="text-right"><?= esc($transaksi['kode_eksemplar']) ?></td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td>Tgl Pinjam</td>
            <td class="text-right bold"><?= date('d M Y', strtotime($transaksi['tgl_pinjam'])) ?></td>
        </tr>
        <tr>
            <td>Jatuh Tempo</td>
            <td class="text-right bold"><?= date('d M Y', strtotime($transaksi['tgl_jatuh_tempo'])) ?></td>
        </tr>
        <tr>
            <td>Status Saat Ini</td>
            <td class="text-right">
                <?= strtoupper($transaksi['status_pinjam']) ?>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="footer-note">
        Simpan struk ini sebagai bukti peminjaman.<br>
        Denda keterlambatan Rp2.000/hari.<br><br>
        <strong>Terima kasih telah menggunakan PustakaHub!</strong>
    </div>
</div>

</body>
</html>
