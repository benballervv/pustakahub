<?= $this->extend('layout_clear') ?>
<?= $this->section('content') ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    overflow-x:hidden;
    color:#2d3436;
    background:
        radial-gradient(circle at top left, rgba(108,99,255,0.18), transparent 25%),
        radial-gradient(circle at bottom right, rgba(224,86,253,0.18), transparent 25%),
        #f6f4ff;
}

/* WRAPPER */
.dashboard-wrapper{
    min-height:100vh;
    padding:30px;
    display:flex;
    justify-content:center;
    align-items:center;
}

.dashboard-card{
    width:100%;
    max-width:1450px;
    background:rgba(255,255,255,0.92);
    backdrop-filter:blur(10px);
    border-radius:32px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.5);
    box-shadow:
        0 25px 60px rgba(108,99,255,0.15),
        0 10px 25px rgba(224,86,253,0.08);
}

/* SIDEBAR */
.sidebar{
    background:
        linear-gradient(
            180deg,
            rgba(108,99,255,0.04),
            rgba(224,86,253,0.02)
        );
    min-height:100%;
    padding:35px 24px;
    border-right:1px solid #f1f1f1;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.logo{
    font-size: 1.1rem;
    font-weight:700;
    color:#2d3436;
    margin-bottom:40px;
    display:flex;
    align-items:center;
    gap:10px;
    white-space: nowrap;
    overflow: visible;
}

.logo span{
    color:#6C63FF;
}

.menu-links{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.menu-item{
    text-decoration:none;
    color:#8c8c8c;
    font-size:14px;
    font-weight:500;
    padding:14px 18px;
    border-radius:16px;
    transition:0.3s;
    display:flex;
    align-items:center;
    gap:14px;
}

.menu-item:hover{
    transform:translateX(5px);
    background:
        linear-gradient(
            90deg,
            rgba(108,99,255,0.08),
            rgba(224,86,253,0.06)
        );
    color:#6C63FF;
}

.menu-active{
    background:linear-gradient(135deg,#6C63FF,#E056FD);
    color:white !important;
    box-shadow:0 10px 25px rgba(108,99,255,0.25);
}

.logout-btn{
    margin-top:40px;
    padding-top:20px;
    border-top:1px solid #f1f1f1;
}

/* MAIN CONTENT */
.main-content{
    padding:35px 40px;
    background:#fafaff;
    min-height:100%;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.search-box{
    width:380px;
    padding:14px 20px;
    border-radius:16px;
    border:1px solid #ececec;
    background:white;
    font-size:14px;
    outline:none;
    transition:0.3s;
    box-shadow:0 4px 14px rgba(0,0,0,0.03);
}

.search-box:focus{
    border-color:#6C63FF;
    box-shadow:0 0 0 4px rgba(108,99,255,0.1);
}

.btn-custom{
    border:none;
    padding:12px 24px;
    border-radius:16px;
    color:white;
    font-size:14px;
    font-weight:600;
    background:linear-gradient(135deg,#6C63FF,#E056FD);
    box-shadow:0 10px 20px rgba(108,99,255,0.2);
    transition:0.3s;
}

.btn-custom:hover{
    transform:translateY(-2px);
    box-shadow:0 15px 25px rgba(108,99,255,0.3);
}

/* SECTION */
.section-title-container{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:35px;
    margin-bottom:20px;
}

.section-title{
    font-size:18px;
    font-weight:700;
    color:#2d3436;
}

/* TABLE */
.table-card{
    background:white;
    border-radius:24px;
    padding:25px;
    border:1px solid #f5f5f7;
    box-shadow:0 4px 20px rgba(0,0,0,0.02);
}

.table{
    margin-bottom:0;
}

.table th{
    border-bottom:1px solid #f5f5f7 !important;
    color:#b5b5c3;
    font-size:12px;
    text-transform:uppercase;
    padding:16px 10px;
}

.table td{
    padding:18px 10px;
    vertical-align:middle;
    border-bottom:1px solid #f8f8fa;
}

.table tbody tr{
    transition:0.3s;
}

.table tbody tr:hover{
    background:rgba(108,99,255,0.04);
}

.badge-custom{
    display:inline-block;
    padding:7px 15px;
    border-radius:14px;
    font-size:12px;
    font-weight:600;
    color:#6C63FF;
    background:
        linear-gradient(
            135deg,
            rgba(108,99,255,0.18),
            rgba(108,99,255,0.08)
        );
}

/* SCROLLBAR */
::-webkit-scrollbar{
    width:8px;
}

::-webkit-scrollbar-thumb{
    background:linear-gradient(#6C63FF,#E056FD);
    border-radius:10px;
}
</style>

<div class="dashboard-wrapper">
    <div class="dashboard-card">
        <div class="row g-0">

            <div class="col-md-3 col-lg-2">
                <div class="sidebar">
                    <div>
                        <div class="logo" style="white-space: nowrap;">📚 <span>Pustaka</span>Hub</div>
                        <div class="menu-links">
                            <a href="<?= base_url('/') ?>" class="menu-item">🏠 Dashboard</a>
                            <a href="<?= base_url('buku') ?>" class="menu-item menu-active">📚 Buku</a>
                            <a href="<?= base_url('anggota') ?>" class="menu-item">👤 Anggota</a>
                            <a href="<?= base_url('peminjaman') ?>" class="menu-item">📖 Peminjaman</a>
                            <a href="#" class="menu-item">📊 Laporan</a>
                        </div>
                    </div>
                    <div class="logout-btn">
                        <a href="<?= base_url('logout') ?>" class="menu-item text-danger">🚪 Logout</a>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    
                    <div class="topbar">
                        <input type="text" class="search-box" placeholder="Cari judul atau kategori buku...">
                        <button class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambahBuku">+ Tambah Buku</button>
                    </div>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                            🎉 <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="section-title-container" style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                        <h5 class="section-title" style="margin-bottom: 0;">Kelola Data Buku</h5>
                        <span class="badge-custom" style="padding: 6px 14px; font-size: 13px; font-weight: 700; border-radius: 12px;">
                            📊 Total: <?= !empty($daftar_buku) ? count($daftar_buku) : 0 ?> Buku
                        </span>
                    </div>

                    <div class="table-card">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Judul Buku / ISBN</th>
                                    <th>Penulis</th>
                                    <th>Penerbit</th>
                                    <th>Tahun</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($daftar_buku)) : ?>
                                    <?php foreach ($daftar_buku as $buku) : ?>
                                        <tr>
                                            <td>
                                                <img src="<?= esc($buku['cover_url']) ?>" alt="Cover" style="width: 50px; height: 68px; object-fit: cover; border-radius: 8px;" onerror="this.src='https://placehold.co/50x68?text=📚';">
                                            </td>
                                            <td>
                                                <div class="fw-semibold"><?= esc($buku['judul']) ?></div>
                                                <small class="text-muted">ISBN: <?= esc($buku['isbn']) ?></small>
                                            </td>
                                            <td><?= esc($buku['penulis']) ?></td>
                                            <td><?= esc($buku['penerbit']) ?></td>
                                            <td><span class="badge-custom"><?= esc($buku['tahun_terbit']) ?></span></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-light btn-edit" 
                                                        data-id="<?= $buku['id_buku'] ?>"
                                                        data-isbn="<?= $buku['isbn'] ?>"
                                                        data-judul="<?= $buku['judul'] ?>"
                                                        data-penulis="<?= $buku['penulis'] ?>"
                                                        data-penerbit="<?= $buku['penerbit'] ?>"
                                                        data-tahun="<?= $buku['tahun_terbit'] ?>"
                                                        data-cover="<?= $buku['cover_url'] ?>">✏️</button>
                                                
                                                <a href="<?= base_url('buku/hapus/' . $buku['id_buku']) ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">🗑️</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Belum ada data buku</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahBuku" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">➕ Tambah Buku Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('buku/simpan') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label fw-semibold">ISBN</label><input type="text" name="isbn" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Judul Buku</label><input type="text" name="judul" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Penulis</label><input type="text" name="penulis" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Penerbit</label><input type="text" name="penerbit" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Tahun Terbit</label><input type="number" name="tahun_terbit" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">URL Cover Gambar</label><input type="url" name="cover_url" class="form-control" placeholder="https://example.com/cover.jpg"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background: #6C63FF; border: none;">Simpan Buku</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditBuku" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">✏️ Edit Data Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('buku/update') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="id_buku" id="edit_id">
                    <div class="mb-3"><label class="form-label fw-semibold">ISBN</label><input type="text" name="isbn" id="edit_isbn" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Judul Buku</label><input type="text" name="judul" id="edit_judul" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Penulis</label><input type="text" name="penulis" id="edit_penulis" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Penerbit</label><input type="text" name="penerbit" id="edit_penerbit" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Tahun Terbit</label><input type="text" name="tahun_terbit" id="edit_tahun_terbit" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">URL Cover Gambar</label><input type="text" name="cover_url" id="edit_cover_url" class="form-control"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background: #6C63FF; border: none;">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.btn-edit').on('click', function() {
        const id = $(this).data('id');
        const isbn = $(this).data('isbn');
        const judul = $(this).data('judul');
        const penulis = $(this).data('penulis');
        const penerbit = $(this).data('penerbit');
        const tahun = $(this).data('tahun');
        const cover = $(this).data('cover');

        $('#edit_id').val(id);
        $('#edit_isbn').val(isbn);
        $('#edit_judul').val(judul);
        $('#edit_penulis').val(penulis);
        $('#edit_penerbit').val(penerbit);
        $('#edit_tahun_terbit').val(tahun); 
        $('#edit_cover_url').val(cover); 

        $('#modalEditBuku').modal('show');
    });
});
</script>

<?= $this->endSection() ?>