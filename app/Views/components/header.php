<div class="header-wrapper">
    <form action="<?= base_url('buku/katalog') ?>" method="GET" class="d-flex gap-2 align-items-center">
        <div class="position-relative d-flex align-items-center">
            <i class="bi bi-search position-absolute ms-3 text-muted" style="font-size: 1.1rem;"></i>
            
            <input type="text" 
                   name="keyword" 
                   class="search-bar-custom ps-5" 
                   placeholder="Cari buku untuk dipinjam..." 
                   value="<?= esc($keyword ?? '') ?>">
        </div>
        
        <button type="submit" class="btn btn-custom px-4">Cari</button>
    </form>

    <div class="d-flex align-items-center mb-5">
    <div class="avatar-purple me-3">
        <?= strtoupper(substr(session()->get('nama') ?? 'D', 0, 1)) ?>
    </div>
    <div>
        <h6 class="mb-0 fw-bold"><?= session()->get('nama') ?? 'Destian' ?></h6>
        <small class="text-muted text-capitalize"><?= session()->get('role') ?? 'admin' ?></small>
    </div>
</div>
</div>