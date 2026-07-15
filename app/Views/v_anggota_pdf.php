<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Anggota</title>
    <style>
        @page { margin: 0px; }
        body { font-family: sans-serif; font-size: 10px; margin: 0; padding: 0; }
        .card { width: 220pt; height: 135pt; margin: 5pt auto; padding: 10px; box-sizing: border-box; border: 4px solid #6f42c1; border-radius: 8px; }
        .header { text-align: center; margin-bottom: 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .header h3 { margin: 0; color: #6f42c1; font-size: 14px; }
        .header p { margin: 0; font-size: 8px; color: #555; }
        .content table { width: 100%; }
        .content td { padding: 2px 0; font-size: 9px; }
        .content td:first-child { width: 30%; font-weight: bold; }
        .footer { margin-top: 5px; text-align: right; font-size: 8px; font-style: italic; color: #888; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h3>PUSTAKA HUB</h3>
            <p>Kartu Tanda Anggota Perpustakaan Digital</p>
        </div>
        <div class="content">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>: <?= esc($anggota['nama']) ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>: <?= esc($anggota['email']) ?></td>
                </tr>
                <tr>
                    <td>No. Telp</td>
                    <td>: <?= esc($anggota['no_telp'] ?? '-') ?></td>
                </tr>
                <tr>
                    <td>Role</td>
                    <td>: <?= esc(ucfirst($anggota['role'])) ?></td>
                </tr>
            </table>
        </div>
        <div class="footer">
            Berlaku Selamanya
        </div>
    </div>
</body>
</html>
