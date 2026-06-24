<<<<<<< HEAD
<?= $this->extend('layout') ?> 
<?= $this->section('content') ?>

<div class="d-flex flex-column gap-4 w-100">

    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1 text-dark">➕ Input Transaksi Baru</h4>
            <p class="text-muted small mb-0">Silakan isi formulir di bawah ini untuk mencatat peminjaman buku</p>
        </div>
        <div>
            <a href="<?= base_url('peminjaman') ?>" class="btn btn-light rounded-pill px-4 py-2 border shadow-sm" style="font-size: 14px; font-weight: 600;">
                ⬅️ Kembali ke Log
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 w-100 p-4 p-md-5 bg-white">
        <form action="<?= base_url('peminjaman/simpan') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark mb-2" style="font-size: 14px;">Nama Anggota Perpustakaan</label>
                <select name="id_user" class="form-select rounded-3 bg-light border-0 px-3 py-2" style="font-size: 14px;" required>
                    <option value="">-- Pilih Member --</option>
                    <?php foreach ($anggota as $a) : ?>
                        <option value="<?= $a['id_user'] ?>"><?= esc($a['nama']) ?> (<?= esc($a['email']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-dark mb-2" style="font-size: 14px;">Buku Eksemplar Siap Pinjam (Stok Ready)</label>
                <select name="id_eksemplar" class="form-select rounded-3 bg-light border-0 px-3 py-2" style="font-size: 14px;" required>
                    <option value="">-- Pilih Buku & Barcode --</option>
                    
                    <?php 
                        // Cek apakah ada parameter id_eksemplar dari URL (dari fitur search)
                        $id_dari_katalog = isset($_GET['id_eksemplar']) ? $_GET['id_eksemplar'] : ''; 
                    ?>
                    
                    <?php foreach ($eksemplar as $e) : ?>
                        <option value="<?= $e['id_eksemplar'] ?>" <?= ($id_dari_katalog == $e['id_eksemplar']) ? 'selected' : '' ?>>
                            <?= esc($e['judul']) ?> [<?= esc($e['kode_eksemplar']) ?>] - Rak: <?= esc($e['lokasi_rak']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label fw-bold text-dark mb-2" style="font-size: 14px;">Tanggal Mulai Pinjam</label>
                    <input type="date" name="tgl_pinjam" class="form-control rounded-3 bg-light border-0 px-3 py-2" style="font-size: 14px;" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark mb-2" style="font-size: 14px;">Tanggal Jatuh Tempo (Batas Kembali)</label>
                    <input type="date" name="tgl_jatuh_tempo" class="form-control rounded-3 bg-light border-0 px-3 py-2" style="font-size: 14px;" value="<?= date('Y-m-d', strtotime('+7 days')) ?>" required>
                </div>
            </div>

            <div class="mt-5 d-flex gap-3">
                <button type="submit" class="btn border-0 text-white fw-semibold rounded-pill px-4 py-2" style="background: linear-gradient(135deg, #a663f4, #c97af9); box-shadow: 0 4px 15px rgba(166, 99, 244, 0.3);">
                    Simpan Peminjaman
                </button>
                <a href="<?= base_url('peminjaman') ?>" class="btn btn-light px-4 rounded-pill py-2 border fw-semibold" style="font-size: 14px;">
                    Batal
                </a>
            </div>
        </form>
    </div>

=======
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
    color:#2d3436;
    background:
        radial-gradient(circle at top left, rgba(108,99,255,0.18), transparent 25%),
        radial-gradient(circle at bottom right, rgba(224,86,253,0.18), transparent 25%),
        #f6f4ff;
}

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

.sidebar{
    background: linear-gradient(180deg, rgba(108,99,255,0.04), rgba(224,86,253,0.02));
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
}

.logo span{ color:#6C63FF; }

.menu-links{ display:flex; flex-direction:column; gap:10px; }

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

.menu-active{
    background:linear-gradient(135deg,#6C63FF,#E056FD);
    color:white !important;
    box-shadow:0 10px 25px rgba(108,99,255,0.25);
}

.main-content{
    padding:35px 40px;
    background:#fafaff;
    min-height:100%;
}

.form-card {
    background: white;
    border-radius: 24px;
    padding: 35px;
    border: 1px solid #f5f5f7;
    box-shadow: 0 4px 20px rgba(0,0,0,0.02);
}

.form-label {
    font-weight: 600;
    font-size: 14px;
    color: #2d3436;
    margin-bottom: 8px;
}

.form-control, .form-select {
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 14px;
    border: 1px solid #ececec;
}

.form-control:focus, .form-select:focus {
    border-color: #6C63FF;
    box-shadow: 0 0 0 4px rgba(108,99,255,0.1);
}

.btn-primary-custom {
    background: linear-gradient(135deg,#6C63FF,#E056FD);
    border: none;
    color: white;
    font-weight: 600;
    padding: 12px 30px;
    border-radius: 14px;
    box-shadow: 0 10px 20px rgba(108,99,255,0.2);
    transition: 0.3s;
}

.btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 25px rgba(108,99,255,0.3);
}
</style>

<div class="dashboard-wrapper">
    <div class="dashboard-card">
        <div class="row g-0">

            <div class="col-md-3 col-lg-2">
                <div class="sidebar">
                    <div>
                        <div class="logo">📚 <span>Pustaka</span>Hub</div>
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
                    
                    <h5 class="fw-bold mb-4" style="font-size: 20px;">➕ Input Transaksi Baru</h5>

                    <div class="form-card">
                        <form action="<?= base_url('peminjaman/simpan') ?>" method="POST">
                            <?= csrf_field() ?>

                            <div class="mb-4">
                                <label class="form-label">Nama Anggota Perpustakaan</label>
                                <select name="id_user" class="form-select" required>
                                    <option value="">-- Pilih Member --</option>
                                    <?php foreach ($anggota as $a) : ?>
                                        <option value="<?= $a['id_user'] ?>"><?= esc($a['nama']) ?> (<?= esc($a['email']) ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Buku Eksemplar Siap Pinjam (Stok Ready)</label>
                                <select name="id_eksemplar" class="form-select" required>
                                    <option value="">-- Pilih Buku & Barcode --</option>
                                    <?php foreach ($eksemplar as $e) : ?>
                                        <option value="<?= $e['id_eksemplar'] ?>"><?= esc($e['judul']) ?> [<?= esc($e['kode_eksemplar']) ?>] - Rak: <?= esc($e['lokasi_rak']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label">Tanggal Mulai Pinjam</label>
                                    <input type="date" name="tgl_pinjam" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Jatuh Tempo (Batas Kembali)</label>
                                    <input type="date" name="tgl_jatuh_tempo" class="form-control" value="<?= date('Y-m-d', strtotime('+7 days')) ?>" required>
                                </div>
                            </div>

                            <div class="mt-5 d-flex gap-2">
                                <button type="submit" class="btn-primary-custom">Simpan Peminjaman</button>
                                <a href="<?= base_url('peminjaman') ?>" class="btn btn-light px-4 rounded-pill d-flex align-items-center" style="font-size:14px; font-weight:600; border: 1px solid #ececec;">Batal</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
>>>>>>> 0f21e88c791778d4e216ced9030c6be9a5f53926
</div>

<?= $this->endSection() ?>