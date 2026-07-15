<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Data Denda</h3>
            <p class="text-muted">Daftar denda keterlambatan pengembalian buku</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Judul Buku</th>
                        <th>Jumlah Denda</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php if(!empty($denda)): ?>

                    <?php
                    $no = 1;
                    foreach($denda as $row):
                    ?>

                    <tr>

                        <td><?= $no++ ?></td>

                        <td><?= esc($row['nama']) ?></td>

                        <td><?= esc($row['judul']) ?></td>

                        <td>
                            Rp <?= number_format($row['jumlah_bayar'],0,',','.') ?>
                        </td>

                        <td>

                            <?php if($row['status_pembayaran']=='pending'): ?>

                                <span class="badge bg-warning">
                                    Pending
                                </span>

                            <?php else: ?>

                                <span class="badge bg-success">
                                    Lunas
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <?php if($row['status_pembayaran']=='pending'): ?>

                                <a href="<?= base_url('payment/'.$row['id_bayar']) ?>"
                                   class="btn btn-primary btn-sm">
                                    Bayar
                                </a>

                                <?php $role = strtolower((string) session()->get('role')); ?>
                                <?php if($role === 'admin' || $role === 'pustakawan'): ?>
                                    <a href="<?= base_url('denda/lunas_manual/'.$row['id_bayar']) ?>"
                                       class="btn btn-success btn-sm ms-1"
                                       onclick="return confirm('Tandai denda ini sebagai Lunas secara manual?')">
                                        Tandai Lunas
                                    </a>
                                <?php endif; ?>

                            <?php else: ?>

                                <button class="btn btn-success btn-sm" disabled>

                                    Sudah Lunas

                                </button>

                            <?php endif; ?>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="6" class="text-center">

                            Tidak ada data denda

                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>
    </div>

</div>

<?= $this->endSection() ?>