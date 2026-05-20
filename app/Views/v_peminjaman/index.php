<?= $this->extend('layout_clear') ?>
<?= $this->section('content') ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    overflow-x:hidden;
    color:#2d3436;
    background:
        radial-gradient(circle at top left, rgba(108,99,255,0.18), transparent 25%),
        radial-gradient(circle at bottom right, rgba(224,86,253,0.18), transparent 25%),
        #f6f4ff;
}

/* WRAPPER */
.dashboard-wrapper{
    min-height:100vh;
    padding:30px;
    display:flex;
    justify-content:center;
    align-items:center;
}

.dashboard-card{
    width:100%;
    max-width:1450px;
    background:rgba(255,255,255,0.92);
    backdrop-filter:blur(10px);
    border-radius:32px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.5);
    box-shadow:
        0 25px 60px rgba(108,99,255,0.15),
        0 10px 25px rgba(224,86,253,0.08);
}

/* SIDEBAR */
.sidebar{
    background:
        linear-gradient(
            180deg,
            rgba(108,99,255,0.04),
            rgba(224,86,253,0.02)
        );
    min-height:100%;
    padding:35px 24px;
    border-right:1px solid #f1f1f1;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.logo{
    font-size: 1.1rem;
    font-weight:700;
    color:#2d3436;
    margin-bottom:40px;
    display:flex;
    align-items:center;
    gap:10px;
    white-space: nowrap;
    overflow: visible;
}

.logo span{
    color:#6C63FF;
}

.menu-links{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.menu-item{
    text-decoration:none;
    color:#8c8c8c;
    font-size:14px;
    font-weight:500;
    padding:14px 18px;
    border-radius:16px;
    transition:0.3s;
    display:flex;
    align-items:center;
    gap:14px;
}

.menu-item:hover{
    transform:translateX(5px);
    background:
        linear-gradient(
            90deg,
            rgba(108,99,255,0.08),
            rgba(224,86,253,0.06)
        );
    color:#6C63FF;
}

.menu-active{
    background:linear-gradient(135deg,#6C63FF,#E056FD);
    color:white !important;
    box-shadow:0 10px 25px rgba(108,99,255,0.25);
}

.logout-btn{
    margin-top:40px;
    padding-top:20px;
    border-top:1px solid #f1f1f1;
}

/* MAIN CONTENT */
.main-content{
    padding:35px 40px;
    background:#fafaff;
    min-height:100%;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.search-box{
    width:380px;
    padding:14px 20px;
    border-radius:16px;
    border:1px solid #ececec;
    background:white;
    font-size:14px;
    outline:none;
    transition:0.3s;
    box-shadow:0 4px 14px rgba(0,0,0,0.03);
}

.search-box:focus{
    border-color:#6C63FF;
    box-shadow:0 0 0 4px rgba(108,99,255,0.1);
}

.btn-custom{
    border:none;
    padding:12px 24px;
    border-radius:16px;
    color:white;
    font-size:14px;
    font-weight:600;
    background:linear-gradient(135deg,#6C63FF,#E056FD);
    box-shadow:0 10px 20px rgba(108,99,255,0.2);
    transition:0.3s;
    text-decoration: none;
    display: inline-block;
}

.btn-custom:hover{
    transform:translateY(-2px);
    box-shadow:0 15px 25px rgba(108,99,255,0.3);
    color: white;
}

/* SECTION */
.section-title-container{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:35px;
    margin-bottom:20px;
}

.section-title{
    font-size:18px;
    font-weight:700;
    color:#2d3436;
}

/* TABLE */
.table-card{
    background:white;
    border-radius:24px;
    padding:25px;
    border:1px solid #f5f5f7;
    box-shadow:0 4px 20px rgba(0,0,0,0.02);
}

.table{
    margin-bottom:0;
}

.table th{
    border-bottom:1px solid #f5f5f7 !important;
    color:#b5b5c3;
    font-size:12px;
    text-transform:uppercase;
    padding:16px 10px;
}

.table td{
    padding:18px 10px;
    vertical-align:middle;
    border-bottom:1px solid #f8f8fa;
}

.table tbody tr{
    transition:0.3s;
}

.table tbody tr:hover{
    background:rgba(108,99,255,0.04);
}

.badge-custom{
    display:inline-block;
    padding:7px 15px;
    border-radius:14px;
    font-size:12px;
    font-weight:600;
    color:#6C63FF;
    background:
        linear-gradient(
            135deg,
            rgba(108,99,255,0.18),
            rgba(108,99,255,0.08)
        );
}

.badge-danger-custom{
    color:#ff7675;
    background: rgba(255, 118, 117, 0.15);
    padding: 6px 12px;
    border-radius: 12px;
    font-weight: 600;
}

.badge-success-custom{
    color:#2ecc71;
    background: rgba(46, 204, 113, 0.15);
    padding: 6px 12px;
    border-radius: 12px;
    font-weight: 600;
}

.badge-warning-custom{
    color:#f1c40f;
    background: rgba(241, 196, 15, 0.15);
    padding: 6px 12px;
    border-radius: 12px;
    font-weight: 600;
}

/* SCROLLBAR */
::-webkit-scrollbar{
    width:8px;
}

::-webkit-scrollbar-thumb{
    background:linear-gradient(#6C63FF,#E056FD);
    border-radius:10px;
}
</style>

<div class="dashboard-wrapper">
    <div class="dashboard-card">
        <div class="row g-0">

            <div class="col-md-3 col-lg-2">
                <div class="sidebar">
                    <div>
                        <div class="logo" style="white-space: nowrap;">📚 <span>Pustaka</span>Hub</div>
                        <div class="menu-links">
                            <a href="<?= base_url('/') ?>" class="menu-item">🏠 Dashboard</a>
                            <a href="<?= base_url('buku') ?>" class="menu-item">📚 Buku</a>
                            <a href="<?= base_url('anggota') ?>" class="menu-item">👤 Anggota</a>
                            <a href="<?= base_url('peminjaman') ?>" class="menu-item menu-active">📖 Peminjaman</a>
                            <a href="#" class="menu-item">📊 Laporan</a>
                        </div>
                    </div>
                    <div class="logout-btn">
                        <a href="<?= base_url('logout') ?>" class="menu-item text-danger">🚪 Logout</a>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    
                    <div class="topbar">
                        <input type="text" class="search-box" placeholder="Cari data peminjaman...">
                        <?php if (in_array(session()->get('role'), ['Admin', 'admin', 'Pustakawan', 'pustakawan'])): ?>
                            <a href="<?= base_url('peminjaman/tambah') ?>" class="btn-custom">+ Tambah Pinjaman</a>
                        <?php endif; ?>
                    </div>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                            🎉 <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="section-title-container" style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                        <h5 class="section-title" style="margin-bottom: 0;">Log Transaksi Peminjaman</h5>
                        <span class="badge-custom" style="padding: 6px 14px; font-size: 13px; font-weight: 700; border-radius: 12px;">
                            📖 Total: <?= !empty($transaksi) ? count($transaksi) : 0 ?> Sesi
                        </span>
                    </div>

                    <div class="table-card">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Judul Buku / Kode</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Tgl Kembali</th>
                                    <th>Status</th>
                                    <?php if (in_array(session()->get('role'), ['Admin', 'admin', 'Pustakawan', 'pustakawan'])): ?>
                                        <th class="text-center">Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($transaksi)) : ?>
                                    <?php foreach ($transaksi as $row) : ?>
                                        <tr>
                                            <td class="fw-semibold text-dark"><?= esc($row['nama_anggota']) ?></td>
                                            <td>
                                                <div class="fw-semibold text-primary"><?= esc($row['judul']) ?></div>
                                                <small class="text-muted">Code: <?= esc($row['kode_eksemplar']) ?></small>
                                            </td>
                                            <td><?= date('d M Y', strtotime($row['tgl_pinjam'])) ?></td>
                                            <td><?= date('d M Y', strtotime($row['tgl_jatuh_tempo'])) ?></td>
                                            <td>
                                                <?= $row['tgl_kembali'] ? date('d M Y', strtotime($row['tgl_kembali'])) : '<span class="text-muted">-</span>' ?>
                                            </td>
                                            <td>
                                                <?php if ($row['status_pinjam'] == 'dipinjam') : ?>
                                                    <span class="badge-warning-custom">Dipinjam</span>
                                                <?php elseif ($row['status_pinjam'] == 'terlambat') : ?>
                                                    <span class="badge-danger-custom">Terlambat</span>
                                                <?php else : ?>
                                                    <span class="badge-success-custom">Kembali</span>
                                                <?php endif; ?>
                                            </td>
                                            <?php if (in_array(session()->get('role'), ['Admin', 'admin', 'Pustakawan', 'pustakawan'])): ?>
                                                <td class="text-center">
                                                    <?php if ($row['status_pinjam'] == 'dipinjam') : ?>
                                                        <a href="<?= base_url('peminjaman/kembali/' . $row['id_pinjam']) ?>" class="btn btn-sm btn-success rounded-pill px-3" onclick="return confirm('Apakah buku ini dikembalikan hari ini?');" style="font-size: 12px; font-weight:600;">Kembalikan</a>
                                                    <?php else: ?>
                                                        <span class="text-muted" style="font-size: 13px;">✅ Selesai</span>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">Belum ada data transaksi peminjaman</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>