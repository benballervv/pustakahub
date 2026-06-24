<?= $this->extend('layout') ?> 
<?= $this->section('content') ?>

<div class="d-flex flex-column gap-4 w-100">

    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1 text-dark">🔍 Katalog Buku Siap Pinjam</h4>
            <p class="text-muted small mb-0">Cari buku dan klik pinjam untuk langsung masuk ke form transaksi</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 w-100 p-4 p-md-5 bg-white">
        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control rounded-3 bg-light border-0 px-4 py-3" placeholder="Ketik judul buku atau kode eksemplar untuk mencari..." style="font-size: 14px;">
        </div>

        <div class="row" id="bookContainer">
            <?php if (!empty($buku_ready)) : ?>
                <?php foreach ($buku_ready as $b) : ?>
                    <div class="col-md-4 mb-4 book-item">
                        <div class="card h-100 border-1 rounded-4 shadow-sm p-3">
                            <div class="fw-bold text-dark mb-2" style="font-size: 16px; line-height: 1.4;">
                                <?= esc($b['judul']) ?>
                            </div>
                            <div class="text-muted small mb-4 flex-grow-1">
                                <div>Kode: <strong class="text-dark"><?= esc($b['kode_eksemplar']) ?></strong></div>
                                <div>Lokasi: <strong class="text-dark">Rak <?= esc($b['lokasi_rak']) ?></strong></div>
                            </div>
                            <a href="<?= base_url('peminjaman/tambah?id_eksemplar=' . $b['id_eksemplar']) ?>" class="btn w-100 border-0 text-white fw-semibold rounded-3 py-2" style="background: linear-gradient(135deg, #a663f4, #c97af9); box-shadow: 0 4px 15px rgba(166, 99, 244, 0.2); font-size: 13px;">
                                Pinjam Buku Ini
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12 text-center text-muted py-5">
                    Belum ada buku yang tersedia untuk dipinjam saat ini.
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let bookItems = document.querySelectorAll('.book-item');

    bookItems.forEach(function(item) {
        let text = item.innerText.toLowerCase();
        // sembunyikan card jka teks tidak cocok sama yang diketik
        item.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>

<?= $this->endSection() ?>