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

</div>

<?= $this->endSection() ?>