<?= $this->extend('layout') ?> 
<?= $this->section('content') ?>

<?php 
    // Ambil session role dan jadikan huruf kecil untuk pengecekan
    $sessionRole = strtolower((string) (session()->get('role') ?? '')); 
?>

<div class="d-flex flex-column gap-4 w-100">
    
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-0" role="alert">
            🎉 <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Kelola Data Peminjaman</h4>
            <p class="text-muted small mb-0">Log Transaksi Peminjaman Buku</p>
        </div>
        
        <div class="d-flex align-items-center gap-3 mt-3 mt-md-0">
            <span class="badge rounded-pill" style="background-color: #f0e6ff; color: #a663f4; padding: 10px 20px; font-size: 14px; font-weight: 600;">
                📖 Total: <?= !empty($transaksi) ? count($transaksi) : 0 ?> Sesi
            </span>

            <?php if (in_array($sessionRole, ['admin', 'pustakawan'])): ?>
                <a href="<?= base_url('peminjaman/tambah') ?>" class="btn border-0 text-white fw-semibold rounded-pill px-4 py-2" style="background: linear-gradient(135deg, #a663f4, #c97af9); box-shadow: 0 4px 15px rgba(166, 99, 244, 0.3); text-decoration: none;">
                    + Tambah Pinjaman
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 w-100 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4">
            <input type="text" class="form-control rounded-pill bg-light border-0 px-4 py-2" placeholder="Cari data peminjaman..." style="max-width: 350px; font-size: 14px;">
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="px-4 py-4 border-0">Peminjam</th>
                            <th class="py-4 border-0">Judul Buku / Kode</th>
                            <th class="py-4 border-0">Tgl Pinjam</th>
                            <th class="py-4 border-0">Jatuh Tempo</th>
                            <th class="py-4 border-0">Tgl Kembali</th>
                            <th class="py-4 border-0 text-center">Status</th>
                            <?php if (in_array($sessionRole, ['admin', 'pustakawan'])): ?>
                                <th class="px-4 py-4 border-0 text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($transaksi)) : ?>
                            <?php foreach ($transaksi as $row) : ?>
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="fw-bold text-dark" style="font-size: 15px;"><?= esc($row['nama_anggota']) ?></div>
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-semibold text-primary" style="font-size: 14px;"><?= esc($row['judul']) ?></div>
                                        <small class="text-muted">Kode: <?= esc($row['kode_eksemplar']) ?></small>
                                    </td>
                                    <td class="py-3 text-muted"><?= date('d M Y', strtotime($row['tgl_pinjam'])) ?></td>
                                    <td class="py-3 text-muted"><?= date('d M Y', strtotime($row['tgl_jatuh_tempo'])) ?></td>
                                    <td class="py-3 text-muted">
                                        <?= $row['tgl_kembali'] ? date('d M Y', strtotime($row['tgl_kembali'])) : '<span class="text-muted">-</span>' ?>
                                    </td>
                                    <td class="py-3 text-center">
                                        <?php if ($row['status_pinjam'] == 'dipinjam') : ?>
                                            <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning px-3 py-2 fw-semibold" style="letter-spacing: 0.5px;">Dipinjam</span>
                                        <?php elseif ($row['status_pinjam'] == 'terlambat') : ?>
                                            <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 py-2 fw-semibold" style="letter-spacing: 0.5px;">Terlambat</span>
                                        <?php else : ?>
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 fw-semibold" style="letter-spacing: 0.5px;">Kembali</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <?php if (in_array($sessionRole, ['admin', 'pustakawan'])): ?>
                                        <td class="px-4 py-3 text-center">
                                            <?php if ($row['status_pinjam'] == 'dipinjam') : ?>
                                                <a href="<?= base_url('peminjaman/kembali/' . $row['id_pinjam']) ?>" class="btn btn-sm btn-success rounded-pill px-3 py-1 shadow-sm" onclick="return confirm('Apakah buku ini dikembalikan hari ini?');" style="font-size: 12px; font-weight:600;">
                                                    Kembalikan
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted fw-medium" style="font-size: 13px;">✅ Selesai</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">Belum ada data transaksi peminjaman</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>