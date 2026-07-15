<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="card shadow">

        <div class="card-header">
            <h3>Pembayaran Denda</h3>
        </div>

        <div class="card-body">

            <table class="table">

                <tr>
                    <th>ID Denda</th>
                    <td><?= $denda['id_bayar'] ?></td>
                </tr>

                <tr>
                    <th>Jumlah Denda</th>
                    <td>
                        Rp <?= number_format($denda['jumlah_bayar'], 0, ',', '.') ?>
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        <?= ucfirst($denda['status_pembayaran']) ?>
                    </td>
                </tr>

            </table>

            <hr>

            <button
                id="pay-button"
                class="btn btn-primary">

                Bayar Sekarang

            </button>

            <!-- Tombol khusus untuk mengatasi webhook localhost -->
            <a href="<?= base_url('payment/simulate/' . $denda['id_bayar']) ?>" class="btn btn-warning ms-2" title="Gunakan ini setelah bayar di Midtrans karena Webhook tidak bisa masuk ke localhost">
                <i class="bi bi-arrow-repeat"></i> Simulasi Webhook (Localhost)
            </a>

            <a href="<?= base_url('denda') ?>"
               class="btn btn-secondary ms-2">

                Kembali

            </a>

        </div>

    </div>

</div>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Midtrans Snap -->
<script
src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="<?= env('MIDTRANS_CLIENT_KEY') ?>">
</script>

<script>

$(document).ready(function(){

    $("#pay-button").click(function(){

        $.ajax({

            url: "<?= base_url('payment/token') ?>",

            type: "POST",

            data: {
                id: <?= $denda['id_bayar'] ?>
            },

            dataType: "json",

            success: function(response){

                if(response.status){

                    snap.pay(response.snapToken, {

                        onSuccess: function(result){

                            alert("Pembayaran Midtrans Berhasil!");

                            // Karena kita di localhost dan tidak pakai Ngrok, 
                            // kita trigger endpoint simulate untuk update DB & WA.
                            window.location.href = "<?= base_url('payment/simulate/' . $denda['id_bayar']) ?>";

                        },

                        onPending: function(result){

                            alert("Pembayaran Pending");

                            console.log(result);

                        },

                        onError: function(result){

                            alert("Pembayaran Gagal");

                            console.log(result);

                        },

                        onClose: function(){

                            alert("Popup pembayaran ditutup.");

                        }

                    });

                }else{

                    alert(response.message);

                }

            },

            error: function(xhr){

                console.log(xhr.responseText);

                alert("Terjadi kesalahan pada server.");

            }

        });

    });

});

</script>

<?= $this->endSection() ?>