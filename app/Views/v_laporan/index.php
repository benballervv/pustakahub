<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="content-center">
    <div class="section-title-container mb-4">
        <h5 class="section-title mb-0">Laporan & Statistik</h5>
        <p class="text-muted small">Ringkasan Peminjaman dan Ekspor Laporan</p>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #a663f4, #c97af9);">
                <div class="card-body text-white">
                    <h6 class="fw-bold mb-3">Peminjaman Aktif</h6>
                    <h2 class="display-5 fw-bold mb-0"><?= count($aktif) ?></h2>
                    <p class="mb-0 mt-2 opacity-75">Sesi sedang berjalan</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-danger text-white">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Buku Terlambat</h6>
                    <h2 class="display-5 fw-bold mb-0"><?= count($terlambat) ?></h2>
                    <p class="mb-0 mt-2 opacity-75">Melewati batas waktu pengembalian</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Export PDF Form -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3 text-dark">Cetak Laporan Bulanan (PDF)</h6>
            <form action="<?= base_url('laporan/export_pdf') ?>" method="GET" class="row g-3 align-items-center">
                <div class="col-auto">
                    <select name="bulan" class="form-select" style="border-radius: 10px;">
                        <?php for($m=1; $m<=12; ++$m): ?>
                            <option value="<?= $m ?>" <?= date('m') == $m ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $m, 1)) ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <input type="number" name="tahun" class="form-control" value="<?= $tahun ?>" style="border-radius: 10px; width: 120px;">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn text-white fw-bold px-4" style="background-color: #6f42c1; border-radius: 10px;">📄 Cetak PDF</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Detail Buku Terlambat -->
    <?php if(count($terlambat) > 0): ?>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h6 class="fw-bold text-danger mb-3">Detail Buku Terlambat</h6>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Anggota</th>
                            <th>Judul Buku</th>
                            <th>Jatuh Tempo</th>
                            <th>Keterlambatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($terlambat as $row): 
                            $date1 = new DateTime($row['tgl_jatuh_tempo']);
                            $date2 = new DateTime(date('Y-m-d'));
                            $interval = $date1->diff($date2);
                        ?>
                        <tr>
                            <td class="fw-semibold text-dark"><?= esc($row['nama_anggota']) ?></td>
                            <td><?= esc($row['judul']) ?></td>
                            <td class="text-danger fw-semibold"><?= esc($row['tgl_jatuh_tempo']) ?></td>
                            <td><span class="badge bg-danger rounded-pill"><?= $interval->days ?> Hari</span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>
