<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="content-center">

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            🎉 <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            ⚠️ <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="section-title-container" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <h5 class="section-title" style="margin-bottom: 0;">Kelola Data Buku</h5>
            <span class="badge-custom">
                📊 Total: <?= !empty($daftar_buku) ? count($daftar_buku) : 0 ?> Buku
            </span>
        </div>
        <button class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalTambahBuku">+ Tambah Buku</button>
    </div>

    <div class="table-card">
        <table class="table align-middle m-0">
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
                                <div class="fw-semibold" style="color: #2b2b2b;"><?= esc($buku['judul']) ?></div>
                                <small class="text-muted">ISBN: <?= esc($buku['isbn']) ?></small>
                            </td>
                            <td style="color: #555;"><?= esc($buku['penulis']) ?></td>
                            <td style="color: #555;"><?= esc($buku['penerbit']) ?></td>
                            <td><span class="badge-custom"><?= esc($buku['tahun_terbit']) ?></span></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-light btn-edit" 
                                        data-id="<?= $buku['id_buku'] ?>"
                                        data-isbn="<?= $buku['isbn'] ?>"
                                        data-judul="<?= $buku['judul'] ?>"
                                        data-penulis="<?= $buku['penulis'] ?>"
                                        data-penerbit="<?= $buku['penerbit'] ?>"
                                        data-tahun="<?= $buku['tahun_terbit'] ?>"
                                        data-cover="<?= $buku['cover_url'] ?>" style="border-radius: 8px;">✏️</button>
                                
                                <a href="<?= base_url('buku/hapus/' . $buku['id_buku']) ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');" style="border-radius: 8px;">🗑️</a>
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

<div class="modal fade" id="modalTambahBuku" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid #f0f0f0;">
                <h5 class="modal-title fw-bold">➕ Tambah Buku Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('buku/simpan') ?>" method="POST" id="formTambahBuku" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    
                    <div class="p-3 mb-4 rounded" style="background-color: #f8f9fa; border: 1px dashed #6f42c1;">
                        <label class="form-label fw-bold" style="color: #6f42c1;">🔍 Cari Data Buku Otomatis</label>
                        <div class="input-group mb-2">
                            <input type="text" id="api_query" class="form-control" placeholder="Cari ISBN atau Judul..." style="border-radius: 10px 0 0 10px;">
                            <button class="btn btn-primary" type="button" onclick="cariDiOpenLibrary()" style="border-radius: 0 10px 10px 0; background-color: #6f42c1; border-color: #6f42c1;">Cari</button>
                        </div>
                        <div id="api_status" class="small fw-semibold text-muted"></div>
                    </div>
                    
                    <div class="mb-3"><label class="form-label fw-semibold">ISBN</label><input type="text" name="isbn" id="tbh_isbn" class="form-control" style="border-radius: 10px;" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Judul Buku</label><input type="text" name="judul" id="tbh_judul" class="form-control" style="border-radius: 10px;" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Penulis</label><input type="text" name="penulis" id="tbh_penulis" class="form-control" style="border-radius: 10px;" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Penerbit</label><input type="text" name="penerbit" id="tbh_penerbit" class="form-control" style="border-radius: 10px;" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Tahun Terbit</label><input type="number" name="tahun_terbit" id="tbh_tahun" class="form-control" style="border-radius: 10px;" required></div>
                    
                    <hr>
                    <label class="form-label fw-semibold text-primary">Opsi Gambar Cover</label>
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 0.9em;">URL Cover (Dari Internet/API)</label>
                        <input type="url" name="cover_url" id="tbh_cover" class="form-control" style="border-radius: 10px;" placeholder="https://example.com/cover.jpg">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 0.9em;">Atau Upload File Cover</label>
                        <input type="file" name="cover_file" class="form-control" style="border-radius: 10px;" accept="image/png, image/jpeg, image/jpg">
                        <small class="text-muted">Max ukuran file: 2MB. Format: JPG, PNG. (Prioritas lebih tinggi dari URL)</small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" class="btn-custom">Simpan Buku</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditBuku" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
<<<<<<< HEAD
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid #f0f0f0;">
                <h5 class="modal-title fw-bold">✏️ Edit Data Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('buku/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="id_buku" id="edit_id">
                    <div class="mb-3"><label class="form-label fw-semibold">ISBN</label><input type="text" name="isbn" id="edit_isbn" class="form-control" style="border-radius: 10px;" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Judul Buku</label><input type="text" name="judul" id="edit_judul" class="form-control" style="border-radius: 10px;" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Penulis</label><input type="text" name="penulis" id="edit_penulis" class="form-control" style="border-radius: 10px;" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Penerbit</label><input type="text" name="penerbit" id="edit_penerbit" class="form-control" style="border-radius: 10px;" required></div>
                    <div class="mb-3"><label class="form-label fw-semibold">Tahun Terbit</label><input type="text" name="tahun_terbit" id="edit_tahun_terbit" class="form-control" style="border-radius: 10px;" required></div>
                    
                    <hr>
                    <label class="form-label fw-semibold text-primary">Opsi Gambar Cover</label>
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 0.9em;">URL Cover Saat Ini</label>
                        <input type="text" name="cover_url" id="edit_cover_url" class="form-control" style="border-radius: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-size: 0.9em;">Ganti dengan File Baru</label>
                        <input type="file" name="cover_file" class="form-control" style="border-radius: 10px;" accept="image/png, image/jpeg, image/jpg">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" class="btn-custom">Perbarui</button>
=======
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
>>>>>>> 0f21e88c791778d4e216ced9030c6be9a5f53926
                </div>
            </form>
        </div>
    </div>
</div>

<script>
<<<<<<< HEAD
document.addEventListener('DOMContentLoaded', function () {
    const editModal = new bootstrap.Modal(document.getElementById('modalEditBuku'));
    
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('edit_id').value = this.getAttribute('data-id');
            document.getElementById('edit_isbn').value = this.getAttribute('data-isbn');
            document.getElementById('edit_judul').value = this.getAttribute('data-judul');
            document.getElementById('edit_penulis').value = this.getAttribute('data-penulis');
            document.getElementById('edit_penerbit').value = this.getAttribute('data-penerbit');
            document.getElementById('edit_tahun_terbit').value = this.getAttribute('data-tahun');
            document.getElementById('edit_cover_url').value = this.getAttribute('data-cover');
            editModal.show();
        });
    });

    // Reset Form & Hapus Readonly saat Modal Tambah ditutup
    const modalTambah = document.getElementById('modalTambahBuku');
    modalTambah.addEventListener('hidden.bs.modal', function () {
        document.getElementById('formTambahBuku').reset();
        document.getElementById('api_status').innerHTML = '';
        document.getElementById('api_query').value = '';
        
        const inputFields = ['tbh_isbn', 'tbh_judul', 'tbh_penulis', 'tbh_penerbit', 'tbh_tahun', 'tbh_cover'];
        inputFields.forEach(id => {
            document.getElementById(id).removeAttribute('readonly');
            // Menghapus efek visual terkunci jika ada
            document.getElementById(id).style.backgroundColor = ''; 
        });
    });
});

// LOGIKA API OPEN LIBRARY
async function cariDiOpenLibrary() {
    const query = document.getElementById('api_query').value.trim();
    const statusText = document.getElementById('api_status');
    
    if (!query) {
        statusText.innerHTML = '<span class="text-danger">Masukkan judul atau ISBN terlebih dahulu.</span>';
        return;
    }

    statusText.innerHTML = '<span class="text-primary">Mencari buku...</span>';

    // Caching
    const cacheKey = 'openlib_' + query.toLowerCase().replace(/[^a-z0-9]/g, '');
    const cachedData = localStorage.getItem(cacheKey);

    if (cachedData) {
        statusText.innerHTML = '<span class="text-success">Data dimuat dari Cache!</span>';
        isiFormOtomatis(JSON.parse(cachedData));
        return; 
    }

    // Konsumsi API & Error Handling
    try {
        const response = await fetch(`https://openlibrary.org/search.json?q=${encodeURIComponent(query)}&limit=1`);
        
        if (!response.ok) throw new Error('Gagal terhubung ke server.');

        const data = await response.json();
        
        if (!data.docs || data.docs.length === 0) {
            statusText.innerHTML = '<span class="text-warning">Buku tidak ditemukan di database.</span>';
            return;
        }

        const buku = data.docs[0];
        const hasilBuku = {
            isbn: buku.isbn ? buku.isbn[0] : query,
            judul: buku.title || '',
            penulis: buku.author_name ? buku.author_name.join(', ') : 'Unknown',
            penerbit: buku.publisher ? buku.publisher[0] : 'Unknown',
            tahun: buku.first_publish_year || '',
            cover: buku.cover_i ? `https://covers.openlibrary.org/b/id/${buku.cover_i}-M.jpg` : ''
        };

        localStorage.setItem(cacheKey, JSON.stringify(hasilBuku));
        statusText.innerHTML = '<span class="text-success">Buku ditemukan! Form otomatis terkunci.</span>';
        isiFormOtomatis(hasilBuku);

    } catch (error) {
        statusText.innerHTML = `<span class="text-danger">Error: ${error.message}</span>`;
    }
}

function isiFormOtomatis(data) {
    const fields = [
        { id: 'tbh_isbn', value: data.isbn },
        { id: 'tbh_judul', value: data.judul },
        { id: 'tbh_penulis', value: data.penulis },
        { id: 'tbh_penerbit', value: data.penerbit },
        { id: 'tbh_tahun', value: data.tahun },
        { id: 'tbh_cover', value: data.cover }
    ];

    fields.forEach(field => {
        const element = document.getElementById(field.id);
        element.value = field.value;
        element.setAttribute('readonly', true); // Kunci input
        element.style.backgroundColor = '#e9ecef'; // Beri warna abu-abu agar terlihat terkunci (opsional)
    }); 
}
=======
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
>>>>>>> 0f21e88c791778d4e216ced9030c6be9a5f53926
</script>

<?= $this->endSection() ?>