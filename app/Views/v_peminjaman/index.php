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

            <?php if (in_array($sessionRole, ['admin', 'pustakawan', 'member'])): ?>
                <a href="<?= base_url('peminjaman/tambah') ?>" class="btn border-0 text-white fw-semibold rounded-pill px-4 py-2" style="background: linear-gradient(135deg, #a663f4, #c97af9); box-shadow: 0 4px 15px rgba(166, 99, 244, 0.3); text-decoration: none;">
                    <?= ($sessionRole === 'member') ? '+ Ajukan Peminjaman' : '+ Tambah Pinjaman' ?>
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
                            <th class="px-4 py-4 border-0 text-center">Aksi</th>
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
                                        <?php if ($row['status_pinjam'] == 'diajukan') : ?>
                                            <span class="badge rounded-pill bg-info bg-opacity-10 text-info px-3 py-2 fw-semibold" style="letter-spacing: 0.5px;">Menunggu Persetujuan</span>
                                        <?php elseif ($row['status_pinjam'] == 'dipinjam') : ?>
                                            <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning px-3 py-2 fw-semibold" style="letter-spacing: 0.5px;">Dipinjam</span>
                                        <?php elseif ($row['status_pinjam'] == 'terlambat') : ?>
                                            <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 py-2 fw-semibold" style="letter-spacing: 0.5px;">Kembali (Terlambat)</span>
                                        <?php else : ?>
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 fw-semibold" style="letter-spacing: 0.5px;">Kembali</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <?php if (in_array($sessionRole, ['admin', 'pustakawan'])): ?>
                                            <?php if ($row['status_pinjam'] == 'diajukan') : ?>
                                                <a href="<?= base_url('peminjaman/setujui/' . $row['id_pinjam']) ?>" class="btn btn-sm btn-primary rounded-pill px-3 py-1 shadow-sm mb-1" onclick="return confirm('Setujui peminjaman ini?');" style="font-size: 12px; font-weight:600;">
                                                    Setujui
                                                </a>
                                                <a href="<?= base_url('peminjaman/tolak/' . $row['id_pinjam']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 shadow-sm mb-1" onclick="return confirm('Tolak pengajuan ini?');" style="font-size: 12px; font-weight:600;">
                                                    Tolak
                                                </a>
                                            <?php elseif ($row['status_pinjam'] == 'dipinjam') : ?>
                                                <a href="<?= base_url('peminjaman/kembali/' . $row['id_pinjam']) ?>" class="btn btn-sm btn-success rounded-pill px-3 py-1 shadow-sm mb-1" onclick="return confirm('Apakah buku ini dikembalikan hari ini?');" style="font-size: 12px; font-weight:600;">
                                                    Kembalikan
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if (in_array($row['status_pinjam'], ['dipinjam', 'kembali', 'terlambat'])) : ?>
                                            <a href="<?= base_url('peminjaman/cetak_receipt/' . $row['id_pinjam']) ?>" target="_blank" class="btn btn-sm btn-light rounded-pill px-3 py-1 shadow-sm border mb-1" style="font-size: 12px; font-weight:600;">
                                                🖨️ Cetak Struk
                                            </a>
                                        <?php elseif (!in_array($sessionRole, ['admin', 'pustakawan']) && $row['status_pinjam'] == 'diajukan'): ?>
                                            <span class="text-muted fw-medium" style="font-size: 13px;">⏳ Diproses</span>
                                        <?php endif; ?>
                                    </td>
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