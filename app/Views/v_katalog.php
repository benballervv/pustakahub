<?= $this->extend('layout') ?> 
<?= $this->section('content') ?>

<div class="py-2">
    <div class="row mb-4 align-items-center">
        <div class="col-12">
            <h3 class="section-title mb-1 d-flex align-items-center">
                Eksplorasi Katalog Buku 
                
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="28" height="28" class="ms-2" fill="#a66cf8" style="margin-top: -4px;">
                    <path d="M249.6 471.5c10.8 3.8 22.4-4.1 22.4-15.5V78.6c0-4.2-1.6-8.4-5-11C247.4 52 202.4 32 136 32 78 32 22.1 49.2 3.1 59.1C1.2 60.1 0 62 0 64.1l0 380c0 4.1 2.9 7.7 6.9 8.3 46 7 96.9 8.2 143.5-3.3 38.3-9.5 76.5-27.1 99.2-39.7zM256 78.6V456c0 11.4 11.6 19.3 22.4 15.5 22.7-8 60.9-25.6 99.2-39.7C424.2 420.3 475.1 419.1 521.1 412.1c4-.6 6.9-4.2 6.9-8.3V64.1c0-2.1-1.2-4-3.1-5C505.9 49.2 450 32 392 32c-66.4 0-111.4 20-131 35.6-3.4 2.7-5 6.8-5 11z"/>
                </svg>
            </h3>
            <p class="text-muted mb-0">Temukan dan pinjam buku favorit Anda dari koleksi PustakaHub.</p>
            
            <?php if (!empty($keyword)) : ?>
                <div class="mt-3 d-inline-flex align-items-center bg-white rounded-pill px-3 py-1" style="border-left: 4px solid #a66cf8; box-shadow: 0 5px 20px rgba(0,0,0,0.02);">
                    <span class="text-muted small me-2">Hasil untuk:</span>
                    <strong style="color: #a66cf8; font-size: 0.9rem;">"<?= esc($keyword) ?>"</strong>
                    <a href="<?= base_url('buku/katalog') ?>" class="ms-3 text-muted text-decoration-none small hover-danger transition-hover" title="Hapus Pencarian">
                        <span aria-hidden="true" class="fw-bold fs-6">✕</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row g-4" id="bookContainer">
        <?php if (!empty($katalog_buku)) : ?>
            <?php foreach ($katalog_buku as $b) : ?>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 book-item">
                    <div class="card h-100 border-0 overflow-hidden card-buku-custom">
                        
                        <?php $cover_image = !empty($b['cover_url']) ? esc($b['cover_url']) : 'https://placehold.co/300x450/f8f9fa/a66cf8?text=No+Cover'; ?>
                        <div class="cover-wrapper text-center p-3" style="background: linear-gradient(145deg, #fdfdfe 0%, #f4effc 100%); height: 200px;">
                            <img src="<?= $cover_image ?>" class="img-fluid h-100 rounded-3 shadow-sm object-fit-contain transition-hover cover-img" alt="<?= esc($b['judul']) ?>" onerror="this.src='https://placehold.co/300x450/f8f9fa/a66cf8?text=No+Cover';">
                        </div>

                        <div class="card-body d-flex flex-column p-3 text-center">
                            
                            <h6 class="card-title section-title mb-1 text-truncate-2" title="<?= esc($b['judul']) ?>" style="font-size: 0.95rem; line-height: 1.3;">
                                <?= esc($b['judul']) ?>
                            </h6>
                            
                            <p class="text-muted mb-3 text-truncate" title="<?= esc($b['penulis'] ?? 'Unknown') ?>" style="font-size: 0.8rem;">
                                <?= esc($b['penulis'] ?? 'Unknown') ?>
                            </p>
                            
                            <div class="mt-auto">
                                <a href="<?= base_url('peminjaman/tambah?id_buku=' . ($b['id_buku'] ?? '')) ?>" class="btn w-100 btn-custom" style="padding: 8px; font-size: 0.85rem; border-radius: 12px;">
                                    Detail / Pinjam
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12">
                <div class="text-center p-5 bg-white shadow-sm border-0 mt-2 py-5" style="border-radius: 20px;">
                    <div class="mb-3">
                        <span style="font-size: 3rem;">📭</span>
                    </div>
                    <h5 class="section-title mb-2">Buku Tidak Ditemukan</h5>
                    <p class="text-muted mb-4 small">Maaf, kami tidak dapat menemukan buku dengan kata kunci <strong style="color: #a66cf8;">"<?= esc($keyword ?? '') ?>"</strong>.</p>
                    
                    <a href="<?= base_url('buku/katalog') ?>" class="btn btn-custom px-4">
                        Tampilkan Semua Buku
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Transisi Umum */
    .transition-hover {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    
    /* Animasi Kartu Buku disesuaikan dengan shadow dari CSS Anda */
    .card-buku-custom {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
    }
    .card-buku-custom:hover {
        transform: translateY(-5px);
        /* Warna shadow hover diambil dari gradient warna CSS Anda (#a66cf8) */
        box-shadow: 0 10px 25px rgba(166, 108, 248, 0.15); 
    }
    .card-buku-custom:hover .cover-img {
        transform: scale(1.05);
    }

    /* Styling Tombol X Pencarian */
    .hover-danger:hover {
        color: #dc3545 !important;
        transform: scale(1.1);
    }

    /* Utilitas */
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .object-fit-contain {
        object-fit: contain;
    }
</style>

<?= $this->endSection() ?>