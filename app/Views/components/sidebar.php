<div class="sidebar-wrapper">
    <div>
        <div class="d-flex align-items-center gap-2 px-3 py-2 mb-3">
            <span class="fs-4" style="letter-spacing: -0.5px; white-space: nowrap;">
                <span class="fw-bold text-dark">📚 Pustaka</span><span class="fw-bold text-purple">Hub</span>
            </span>
        </div>

        <ul class="sidebar-menu" id="sidebar-nav">
            <?php $role = strtolower((string) session()->get('role')); ?>

            <li>
                <a href="<?= base_url('/') ?>" class="<?= (url_is('') || url_is('/')) ? 'active' : '' ?>">
                    <i class="bi bi-grid-fill"></i> Home
                </a>
            </li>
            
            <?php if ($role === 'admin' || $role === 'pustakawan') : ?>
                <li>
                    <a href="<?= base_url('buku') ?>" class="<?= url_is('buku*') ? 'active' : '' ?>">
                        <i class="bi bi-book-fill"></i> Buku
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('anggota') ?>" class="<?= url_is('anggota*') ? 'active' : '' ?>">
                        <i class="bi bi-people-fill"></i> Anggota
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('laporan') ?>" class="<?= url_is('laporan*') ? 'active' : '' ?>">
                        <i class="bi bi-bar-chart-fill"></i> Laporan
                    </a>
                </li>
            <?php endif; ?>

            <li>
                <a href="<?= base_url('peminjaman') ?>" class="<?= url_is('peminjaman*') ? 'active' : '' ?>">
                    <i class="bi bi-journal-arrow-up"></i> Peminjaman
                </a>
            </li>
            <li>
                <a href="<?= base_url('denda') ?>" class="<?= url_is('denda*') || url_is('payment*') ? 'active' : '' ?>">
                    <i class="bi bi-wallet2"></i> Denda & Tagihan
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-footer">
        <ul class="sidebar-menu m-0">
            <li>
                <a href="<?= base_url('logout') ?>" class="text-danger fw-bold">
                    <i class="bi bi-door-open-fill"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</div>