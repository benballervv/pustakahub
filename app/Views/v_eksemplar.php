<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="content-center">
    
    <div class="mb-4">
        <a href="<?= base_url('buku') ?>" class="text-decoration-none text-muted fw-semibold">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Buku
        </a>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div class="d-flex gap-3 align-items-center">
            <img src="<?= esc($buku['cover_url']) ?>" alt="Cover" style="width: 60px; height: 85px; object-fit: cover; border-radius: 8px;">
            <div>
                <h4 class="fw-bold mb-1 text-dark">Kelola Eksemplar: <?= esc($buku['judul']) ?></h4>
                <p class="text-muted small mb-0">ISBN: <?= esc($buku['isbn']) ?> | Penulis: <?= esc($buku['penulis']) ?></p>
            </div>
        </div>
        
        <button class="btn text-white fw-semibold px-4 rounded-pill mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#modalTambahEksemplar" style="background-color: #6f42c1;">
            + Tambah Eksemplar
        </button>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 w-100 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-hover">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="px-4 py-4 border-0">Kode Eksemplar</th>
                            <th class="py-4 border-0">Kondisi</th>
                            <th class="py-4 border-0">Lokasi Rak</th>
                            <th class="py-4 border-0 text-center">Status Tersedia</th>
                            <th class="px-4 py-4 border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($eksemplar)) : ?>
                            <?php foreach ($eksemplar as $eks) : ?>
                                <tr>
                                    <td class="px-4 py-3 fw-bold text-dark"><?= esc($eks['kode_eksemplar']) ?></td>
                                    <td class="py-3 text-muted"><?= esc(ucfirst($eks['kondisi'])) ?></td>
                                    <td class="py-3 text-muted"><?= esc($eks['lokasi_rak']) ?></td>
                                    <td class="py-3 text-center">
                                        <?php if($eks['status_tersedia'] == 'tersedia'): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">Tersedia</span>
                                        <?php elseif($eks['status_tersedia'] == 'dipinjam'): ?>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">Dipinjam</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">Tidak Tersedia</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button class="btn btn-sm btn-light btn-edit-eks" 
                                            data-id="<?= $eks['id_eksemplar'] ?>"
                                            data-kode="<?= esc($eks['kode_eksemplar']) ?>"
                                            data-kondisi="<?= esc($eks['kondisi']) ?>"
                                            data-rak="<?= esc($eks['lokasi_rak']) ?>"
                                            data-status="<?= esc($eks['status_tersedia']) ?>" style="border-radius: 8px;">✏️</button>
                                        
                                        <a href="<?= base_url('buku/hapus_eksemplar/' . $eks['id_eksemplar'] . '/' . $buku['id_buku']) ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Hapus eksemplar ini?');" style="border-radius: 8px;">🗑️</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">Belum ada eksemplar untuk buku ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahEksemplar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Eksemplar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('buku/simpan_eksemplar') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_buku" value="<?= $buku['id_buku'] ?>">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Eksemplar</label>
                        <input type="text" name="kode_eksemplar" class="form-control rounded-3" placeholder="Contoh: EKS-001" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kondisi</label>
                        <select name="kondisi" class="form-select rounded-3">
                            <option value="bagus">Bagus</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Lokasi Rak</label>
                        <input type="text" name="lokasi_rak" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status_tersedia" class="form-select rounded-3">
                            <option value="tersedia">Tersedia</option>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="tidak tersedia">Tidak Tersedia</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn text-white px-4 rounded-pill" style="background-color: #6f42c1;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEditEksemplar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Eksemplar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('buku/update_eksemplar') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_buku" value="<?= $buku['id_buku'] ?>">
                    <input type="hidden" name="id_eksemplar" id="edit_id_eksemplar">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Eksemplar</label>
                        <input type="text" name="kode_eksemplar" id="edit_kode" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kondisi</label>
                        <select name="kondisi" id="edit_kondisi" class="form-select rounded-3">
                            <option value="bagus">Bagus</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Lokasi Rak</label>
                        <input type="text" name="lokasi_rak" id="edit_rak" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status_tersedia" id="edit_status" class="form-select rounded-3">
                            <option value="tersedia">Tersedia</option>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="tidak tersedia">Tidak Tersedia</option>
                        </select>
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
    const editModal = new bootstrap.Modal(document.getElementById('modalEditEksemplar'));
    
    document.querySelectorAll('.btn-edit-eks').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('edit_id_eksemplar').value = this.getAttribute('data-id');
            document.getElementById('edit_kode').value = this.getAttribute('data-kode');
            document.getElementById('edit_kondisi').value = this.getAttribute('data-kondisi');
            document.getElementById('edit_rak').value = this.getAttribute('data-rak');
            document.getElementById('edit_status').value = this.getAttribute('data-status');
            
            editModal.show();
        });
    });

    // Auto-update Status Dropdown based on Kondisi Dropdown for both Add and Edit modals
    const kondisis = document.querySelectorAll('select[name="kondisi"]');
    kondisis.forEach(kondisiSelect => {
        kondisiSelect.addEventListener('change', function() {
            // Find the closest form, then find the status dropdown inside it
            const form = this.closest('form');
            const statusSelect = form.querySelector('select[name="status_tersedia"]');
            
            if (this.value === 'rusak' || this.value === 'hilang') {
                statusSelect.value = 'tidak tersedia';
            } else if (this.value === 'bagus' && statusSelect.value === 'tidak tersedia') {
                statusSelect.value = 'tersedia';
            }
        });
    });
});
</script>

<?= $this->endSection() ?>
