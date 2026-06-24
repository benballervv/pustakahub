<?= $this->extend('layout') ?> 
<?= $this->section('content') ?>

<div class="d-flex flex-column gap-4 w-100">

    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1 text-dark">🔍 Katalog Buku Siap Pinjam</h4>
            <p class="text-muted small mb-0">Cari buku dan klik pinjam untuk langsung masuk ke form transaksi</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 w-100 p-4 p-md-5" style="background-color: #f8f9fa;">
        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control rounded-3 border-0 px-4 py-3 shadow-sm" placeholder="Ketik judul buku atau kode eksemplar untuk mencari..." style="font-size: 14px;">
        </div>

        <div class="row g-3" id="bookContainer">
            <?php if (!empty($buku_ready)) : ?>
                <?php foreach ($buku_ready as $b) : ?>
                    <div class="col-6 col-md-4 col-lg-3 mb-3 book-item">
                        <div class="card h-100 border-0 shadow-sm rounded-4 transition-hover" style="background-color: #ffffff;">
                            
                            <div class="position-relative p-2">
                                <span class="badge position-absolute top-0 start-0 m-3 rounded-pill bg-light text-primary border shadow-sm" style="font-size: 0.65rem; z-index: 2;">
                                    Rak <?= esc($b['lokasi_rak']) ?>
                                </span>
                                
                                <?php 
                                    $cover_image = !empty($b['cover_url']) ? esc($b['cover_url']) : 'https://placehold.co/220x330/e9ecef/495057?text=No+Cover'; 
                                ?>
                                <img src="<?= $cover_image ?>" class="card-img-top rounded-3 p-2" alt="<?= esc($b['judul']) ?>" style="height: 280px; object-fit: contain; background-color: #fdfdfd;" onerror="this.src='https://placehold.co/220x330/e9ecef/495057?text=No+Cover';">
                            </div>
                            
                            <div class="card-body p-3 d-flex flex-column">
                                <small class="text-muted mb-1" style="font-size: 0.75rem;">
                                    Kode: <?= esc($b['kode_eksemplar']) ?>
                                </small>
                                
                                <h6 class="card-title fw-semibold text-dark mb-3" style="font-size: 0.9rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?= esc($b['judul']) ?>
                                </h6>
                                
                                <div class="mt-auto">
                                    <a href="<?= base_url('peminjaman/tambah?id_eksemplar=' . $b['id_eksemplar']) ?>" class="btn w-100 rounded-pill fw-bold btn-pinjam" style="font-size: 0.85rem; background-color: #f0e6ff; color: #a663f4; transition: 0.2s;">
                                        Pinjam
                                    </a>
                                </div>
                            </div>
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

<style>
    .transition-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
    .btn-pinjam:hover {
        background-color: #a663f4 !important;
        color: #ffffff !important;
    }
</style>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let bookItems = document.querySelectorAll('.book-item');

    bookItems.forEach(function(item) {
        let text = item.innerText.toLowerCase();
        item.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>

<?= $this->endSection() ?>