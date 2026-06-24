<div class="sidebar-wrapper">
    <div>
        <h4 class="fw-bold mb-4" style="color: #2b2b2b; padding-left: 15px; white-space: nowrap;">
            📚 <span>Pustaka</span>Hub
        </h4>

        <ul class="sidebar-menu" id="sidebar-nav">
            <?php $role = strtolower((string) session()->get('role')); ?>

            <li>
                <a href="<?= base_url('/') ?>" class="<?= (uri_string() == '/' || uri_string() == '') ? 'active' : '' ?>">
                    <i class="bi bi-grid-fill"></i> Home
                </a>
            </li>
            
            <?php if ($role === 'admin') : ?>
                <li>
                    <a href="<?= base_url('buku') ?>" class="<?= (uri_string() == 'buku') ? 'active' : '' ?>">
                        <i class="bi bi-book-fill"></i> Buku
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('anggota') ?>" class="<?= (uri_string() == 'anggota') ? 'active' : '' ?>">
                        <i class="bi bi-people-fill"></i> Anggota
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('laporan') ?>" class="<?= (uri_string() == 'laporan') ? 'active' : '' ?>">
                        <i class="bi bi-bar-chart-fill"></i> Laporan
                    </a>
                </li>
            <?php endif; ?>

            <li>
                <a href="<?= base_url('peminjaman') ?>" class="<?= (uri_string() == 'peminjaman') ? 'active' : '' ?>">
                    <i class="bi bi-journal-arrow-up"></i> Peminjaman
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-footer">
        <ul class="sidebar-menu" style="margin-top: 0;">
            <li>
                <a href="<?= base_url('logout') ?>" style="color: #dc3545;">
                    <i class="bi bi-door-open-fill"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</div>