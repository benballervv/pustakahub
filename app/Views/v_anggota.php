<?= $this->extend('layout') ?> 
<?= $this->section('content') ?>

<?php 
    // Ambil session role dan jadikan huruf kecil agar pengecekan lebih aman
    $sessionRole = strtolower((string) session()->get('role')); 
?>

<div class="d-flex flex-column gap-4 w-100">
    
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Kelola Data Anggota</h4>
            <p class="text-muted small mb-0">Manajemen data pengguna dan hak akses</p>
        </div>
        
        <div class="d-flex align-items-center gap-3 mt-3 mt-md-0">
            <span class="badge rounded-pill" style="background-color: #f0e6ff; color: #a663f4; padding: 10px 20px; font-size: 14px; font-weight: 600;">
                👥 Total: <?= !empty($daftar_anggota) ? count($daftar_anggota) : 0 ?> Orang
            </span>

            <?php if (in_array($sessionRole, ['admin', 'pustakawan'])): ?>
                <button class="btn border-0 text-white fw-semibold rounded-pill px-4 py-2" style="background: linear-gradient(135deg, #a663f4, #c97af9); box-shadow: 0 4px 15px rgba(166, 99, 244, 0.3);">
                    + Tambah Anggota
                </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 w-100 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="px-4 py-4 border-0">No</th>
                            <th class="py-4 border-0">Nama Pengguna</th>
                            <th class="py-4 border-0">Email</th>
                            <th class="py-4 border-0 text-center">Role / Hak Akses</th>
                            <th class="px-4 py-4 border-0">Tanggal Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($daftar_anggota)) : ?>
                            <?php $no = 1; foreach ($daftar_anggota as $user) : ?>
                                <tr>
                                    <td class="px-4 py-3 text-muted fw-medium"><?= $no++ ?></td>
                                    <td class="py-3">
                                        <div class="fw-bold text-dark" style="font-size: 15px;"><?= esc($user['nama']) ?></div>
                                    </td>
                                    <td class="py-3 text-muted"><?= esc($user['email']) ?></td>
                                    <td class="py-3 text-center">
                                        <?php 
                                            // Pengecekan warna badge yang kebal huruf besar/kecil
                                            $userRole = strtolower($user['role']);
                                            $badgeBg = 'bg-secondary';
                                            $badgeText = 'text-white';
                                            
                                            if ($userRole == 'admin') {
                                                $badgeBg = 'bg-danger bg-opacity-10';
                                                $badgeText = 'text-danger';
                                            } elseif ($userRole == 'pustakawan') {
                                                $badgeBg = 'bg-primary bg-opacity-10';
                                                $badgeText = 'text-primary';
                                            } elseif ($userRole == 'member') {
                                                $badgeBg = 'bg-success bg-opacity-10';
                                                $badgeText = 'text-success';
                                            }
                                        ?>
                                        <span class="badge rounded-pill <?= $badgeBg ?> <?= $badgeText ?> px-3 py-2 fw-semibold" style="letter-spacing: 0.5px;">
                                            <?= esc(ucwords($user['role'])) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-muted">
                                        <?= date('d M Y', strtotime($user['created_at'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">Belum ada data anggota</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>