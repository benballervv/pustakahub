<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    
    <div class="col-12 col-xl-8">
        
        <div class="welcome-banner p-4 rounded-4 mb-4" style="background: linear-gradient(135deg, #a663f4, #c97af9); color: white;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="welcome-text">
                    <h3 class="fw-bold mb-2">Good Morning, <?= session()->get('nama') ?? 'Destian' ?> 👋</h3>
                    <p class="mb-0" style="opacity: 0.9;">Welcome back to PustakaHub dashboard. Manage books and members easily today.</p>
                </div>
                <div class="banner-illustration" style="font-size: 3.5rem;">👩‍💻</div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Quick Stats</h5>
            <a href="#" class="text-decoration-none fw-semibold" style="color: #a663f4;">View All</a>
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
                        <div class="mb-2 fs-4">☐</div>
                        <h6 class="fw-bold mb-1">Peminjaman</h6>
                        <small class="text-muted">120 Aktif</small>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm p-3 h-100 rounded-4">
                    <div class="mb-2 fs-4">📊</div>
                    <h6 class="fw-bold mb-1">Laporan</h6>
                    <small class="text-muted">20 Bulan Ini</small>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <a href="<?= base_url('buku/katalog') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm p-4 rounded-4 d-flex flex-row align-items-center justify-content-between" style="background: linear-gradient(90deg, #ffffff, #f8f7ff); border-left: 5px solid #a663f4;">
                        <div class="d-flex align-items-center">
                            <div class="fs-2 me-4">🔍</div>
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">Pinjam Buku Baru</h6>
                                <small class="text-muted">Jelajahi katalog buku dan buat transaksi peminjaman dengan cepat.</small>
                            </div>
                        </div>
                        <div class="btn text-white rounded-pill px-4" style="background-color: #a663f4;">Cari Buku</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Recent Activity</h5>
            <a href="#" class="text-decoration-none fw-semibold" style="color: #a663f4;">View All</a>
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
                        <tr>
                            <td class="px-4 py-3 fw-semibold">Destian</td>
                            <td class="py-3">Algoritma & Pemrograman</td>
                            <td class="px-4 py-3"><span class="badge rounded-pill" style="background-color: #f0e6ff; color: #a663f4;">Dipinjam</span></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 fw-semibold">Fahruul</td>
                            <td class="py-3">Basis Data</td>
                            <td class="px-4 py-3"><span class="badge rounded-pill bg-light text-success">Dikembalikan</span></td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 fw-semibold">Raka</td>
                            <td class="py-3">Machine Learning</td>
                            <td class="px-4 py-3"><span class="badge rounded-pill" style="background-color: #f0e6ff; color: #a663f4;">Dipinjam</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="col-12 col-xl-4">
        <div class="d-flex align-items-center mb-4">
            <div class="rounded-circle text-white d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px; background-color: #a663f4; font-weight: bold; font-size: 1.2rem;">
                <?= strtoupper(substr(session()->get('nama') ?? 'D', 0, 1)) ?>
            </div>
            <div>
                <h6 class="mb-0 fw-bold"><?= session()->get('nama') ?? 'Destian' ?></h6>
                <small class="text-muted"><?= session()->get('role') ?? 'admin' ?></small>
            </div>
        </div>

        <?php
            date_default_timezone_set('Asia/Jakarta');
            $month_name = date('F');
            $start_date = strtotime('monday this week');
        ?>
        
        <h6 class="fw-bold mb-1">Schedule Calendar</h6>
        <p class="text-muted small mb-3"><?= $month_name ?></p>
        
        <div class="d-flex justify-content-between mb-4">
            <?php
            for ($i = 0; $i < 5; $i++) {
                $current_time = strtotime("+$i days", $start_date);
                $day_name = date('D', $current_time);
                $day_num = date('d', $current_time);
                $is_today = (date('Y-m-d', $current_time) == date('Y-m-d')) ? 'bg-primary text-white shadow-sm' : 'bg-light text-dark';
            ?>
                <div class="text-center rounded-3 p-2 <?= $is_today ?>" style="width: 50px; <?= (date('Y-m-d', $current_time) == date('Y-m-d')) ? 'background-color: #a663f4 !important;' : '' ?>">
                    <small class="d-block <?= (date('Y-m-d', $current_time) == date('Y-m-d')) ? 'text-white-50' : 'text-muted' ?>"><?= $day_name ?></small>
                    <span class="fw-bold"><?= $day_num ?></span>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>