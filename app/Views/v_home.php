<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    
    <div class="col-12 col-xl-8">
        
        <div class="welcome-banner p-4 rounded-4 mb-4 bg-gradient-purple">
            <div class="d-flex justify-content-between align-items-center">
                <div class="welcome-text">
                    <h3 class="fw-bold mb-2">Good Morning, <?= session()->get('nama') ?? 'Destian' ?> 👋</h3>
                    <p class="mb-0 text-opacity-90">Welcome back to PustakaHub dashboard. Manage books and members easily today.</p>
                </div>
                <div class="banner-illustration banner-icon">👩‍💻</div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Quick Stats</h5>
            <a href="#" class="text-decoration-none fw-semibold text-purple">View All</a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm p-3 h-100 rounded-4">
                    <div class="mb-2 fs-4">📚</div>
                    <h6 class="fw-bold mb-1">Total Buku</h6>
                    <small class="text-muted"><?= number_format($total_buku ?? 10) ?> Buku</small>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm p-3 h-100 rounded-4">
                    <div class="mb-2 fs-4">👤</div>
                    <h6 class="fw-bold mb-1">Anggota</h6>
                    <small class="text-muted"><?= number_format($total_anggota ?? 4) ?> Member</small>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="<?= base_url('peminjaman') ?>" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm p-3 h-100 rounded-4">
                        <div class="mb-2 fs-4">📖</div>
                        <h6 class="fw-bold mb-1">Peminjaman</h6>
                        <small class="text-muted"><?= number_format($peminjaman_aktif ?? 0) ?> Aktif</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="<?= base_url('denda') ?>" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm p-3 h-100 rounded-4">
                        <div class="mb-2 fs-4">💳</div>
                        <h6 class="fw-bold mb-1">Tagihan Denda</h6>
                        <small class="text-muted"><?= number_format($denda_belum_dibayar ?? 0) ?> Belum Lunas</small>
                    </div>
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Recent Activity</h5>
            <a href="<?= base_url('peminjaman') ?>" class="text-decoration-none fw-semibold text-purple">View All</a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <table class="table align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="px-4 py-3 border-0">Nama</th>
                            <th class="py-3 border-0">Buku</th>
                            <th class="px-4 py-3 border-0">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($recent_activity)): ?>
                            <?php foreach($recent_activity as $activity): ?>
                                <tr>
                                    <td class="px-4 py-3 fw-semibold"><?= esc($activity['nama_anggota']) ?></td>
                                    <td class="py-3"><?= esc($activity['judul']) ?></td>
                                    <td class="px-4 py-3">
                                        <?php if($activity['status_pinjam'] == 'dipinjam'): ?>
                                            <span class="badge rounded-pill badge-purple">Dipinjam</span>
                                        <?php elseif($activity['status_pinjam'] == 'kembali'): ?>
                                            <span class="badge rounded-pill bg-light text-success">Dikembalikan</span>
                                        <?php elseif($activity['status_pinjam'] == 'terlambat'): ?>
                                            <span class="badge rounded-pill bg-danger">Terlambat</span>
                                        <?php else: ?>
                                            <span class="badge rounded-pill bg-secondary"><?= ucfirst($activity['status_pinjam']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-center text-muted">Belum ada aktivitas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="col-12 col-xl-4">
        <?= $this->include('components/right_panel') ?>
    </div>
</div>

<?= $this->endSection() ?>