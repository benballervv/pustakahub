<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            font-size: 12px; 
            color: #333;
            margin: 20px;
        }
        
        .header { 
            text-align: center; 
            margin-bottom: 40px; 
            padding-bottom: 20px;
            border-bottom: 2px solid #a855f7;
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: -0.5px;
        }
        
        .logo span:first-child { color: #333; }
        .logo span:last-child { color: #a855f7; }
        
        .header p { 
            margin: 5px 0 0 0; 
            color: #6b7280;
            font-size: 14px;
        }
        
        table { 
            width: 100%; 
            border-collapse: separate; 
            border-spacing: 0;
            margin-top: 20px; 
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        
        th, td { 
            padding: 12px 15px; 
            text-align: left; 
            border-bottom: 1px solid #e5e7eb;
        }
        
        th { 
            background-color: #f3f4f6; 
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
        }
        
        tr:last-child td { border-bottom: none; }
        tr:nth-child(even) { background-color: #fafafa; }
        
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-kembali { background-color: #dcfce7; color: #166534; }
        .status-dipinjam { background-color: #fef08a; color: #854d0e; }
        .status-terlambat { background-color: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo"><span>📚 Pustaka</span><span>Hub</span></div>
        <p>Laporan Peminjaman Resmi</p>
        <p style="font-size: 12px; margin-top: 8px;">Periode: <strong><?= date('F', mktime(0, 0, 0, $bulan, 1)) ?> <?= $tahun ?></strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pinjam</th>
                <th>Nama Anggota</th>
                <th>Buku (Eksemplar)</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($laporan)): ?>
                <tr><td colspan="6" style="text-align: center;">Tidak ada data peminjaman di bulan ini.</td></tr>
            <?php else: ?>
                <?php $no = 1; foreach($laporan as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($row['tgl_pinjam']) ?></td>
                        <td><?= esc($row['nama_anggota']) ?></td>
                        <td><?= esc($row['judul']) ?> (<?= esc($row['kode_eksemplar']) ?>)</td>
                        <td><?= esc($row['tgl_jatuh_tempo']) ?></td>
                        <td>
                            <?php if($row['status_pinjam'] == 'kembali'): ?>
                                <span class="status-badge status-kembali">Dikembalikan</span>
                            <?php elseif($row['status_pinjam'] == 'terlambat'): ?>
                                <span class="status-badge status-terlambat">Terlambat</span>
                            <?php else: ?>
                                <span class="status-badge status-dipinjam"><?= ucfirst($row['status_pinjam']) ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
