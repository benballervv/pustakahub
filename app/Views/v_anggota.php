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
                <button class="btn border-0 text-white fw-semibold rounded-pill px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahAnggota" style="background: linear-gradient(135deg, #a663f4, #c97af9); box-shadow: 0 4px 15px rgba(166, 99, 244, 0.3);">
                    + Tambah Anggota
                </button>
            <?php endif; ?>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 w-100 overflow-hidden mt-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="px-4 py-4 border-0">No</th>
                            <th class="py-4 border-0">Nama Pengguna</th>
                            <th class="py-4 border-0">Kontak</th>
                            <th class="py-4 border-0 text-center">Role / Hak Akses</th>
                            <?php if (in_array($sessionRole, ['admin', 'pustakawan'])): ?>
                            <th class="px-4 py-4 border-0 text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($daftar_anggota)) : ?>
                            <?php $no = 1; foreach ($daftar_anggota as $user) : ?>
                                <tr>
                                    <td class="px-4 py-3 text-muted fw-medium"><?= $no++ ?></td>
                                    <td class="py-3">
                                        <div class="fw-bold text-dark" style="font-size: 15px;"><?= esc($user['nama']) ?></div>
                                        <small class="text-muted">Terdaftar: <?= date('d M Y', strtotime($user['created_at'])) ?></small>
                                    </td>
                                    <td class="py-3 text-muted">
                                        <div><i class="bi bi-envelope"></i> <?= esc($user['email']) ?></div>
                                        <div><i class="bi bi-telephone"></i> <?= esc($user['no_telp'] ?? '-') ?></div>
                                    </td>
                                    <td class="py-3 text-center">
                                        <?php 
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
                                    <?php if (in_array($sessionRole, ['admin', 'pustakawan'])): ?>
                                    <td class="px-4 py-3 text-center">
                                        <button class="btn btn-sm btn-light btn-edit-anggota" 
                                            data-id="<?= $user['id_user'] ?>"
                                            data-nama="<?= esc($user['nama']) ?>"
                                            data-email="<?= esc($user['email']) ?>"
                                            data-notelp="<?= esc($user['no_telp'] ?? '') ?>"
                                            data-role="<?= esc($user['role']) ?>" style="border-radius: 8px;">✏️</button>
                                        
                                        <a href="<?= base_url('anggota/cetak_kartu/' . $user['id_user']) ?>" class="btn btn-sm btn-light text-primary" target="_blank" style="border-radius: 8px;" title="Cetak Kartu">🖨️</a>

                                        <?php if($user['id_user'] !== session()->get('id_user')): ?>
                                        <a href="<?= base_url('anggota/hapus/' . $user['id_user']) ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?');" style="border-radius: 8px;" title="Hapus">🗑️</a>
                                        <?php endif; ?>
                                    </td>
                                    <?php endif; ?>
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

<!-- Modal Tambah Anggota -->
<div class="modal fade" id="modalTambahAnggota" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('anggota/simpan') ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. Telepon (WA)</label>
                        <input type="text" name="no_telp" class="form-control rounded-3" placeholder="Contoh: 628123456789">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <select name="role" class="form-select rounded-3">
                            <option value="Member">Member</option>
                            <option value="Pustakawan">Pustakawan</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Default</label>
                        <input type="password" name="password" class="form-control rounded-3" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn text-white px-4 rounded-pill" style="background-color: #6f42c1;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Anggota -->
<div class="modal fade" id="modalEditAnggota" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('anggota/update') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_user" id="edit_id_user">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama" id="edit_nama" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. Telepon (WA)</label>
                        <input type="text" name="no_telp" id="edit_no_telp" class="form-control rounded-3">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <select name="role" id="edit_role" class="form-select rounded-3">
                            <option value="Member">Member</option>
                            <option value="Pustakawan">Pustakawan</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ganti Password (Opsional)</label>
                        <input type="password" name="password" class="form-control rounded-3" placeholder="Biarkan kosong jika tidak diganti">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn text-white px-4 rounded-pill" style="background-color: #6f42c1;">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editModal = new bootstrap.Modal(document.getElementById('modalEditAnggota'));
    
    document.querySelectorAll('.btn-edit-anggota').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('edit_id_user').value = this.getAttribute('data-id');
            document.getElementById('edit_nama').value = this.getAttribute('data-nama');
            document.getElementById('edit_email').value = this.getAttribute('data-email');
            document.getElementById('edit_no_telp').value = this.getAttribute('data-notelp');
            
            // Set select option correctly based on case-insensitive match
            const role = this.getAttribute('data-role').toLowerCase();
            const select = document.getElementById('edit_role');
            for(let i=0; i<select.options.length; i++) {
                if(select.options[i].value.toLowerCase() === role) {
                    select.selectedIndex = i;
                    break;
                }
            }
            
            editModal.show();
        });
    });
});
</script>

</div>

<?= $this->endSection() ?>