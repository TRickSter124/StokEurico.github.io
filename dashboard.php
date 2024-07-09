<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}
require_once('helper/koneksi-db.php');
// hitung jumlah barang masuk
$queryambilmasuk = mysqli_query($conn, "SELECT * FROM masuk");
$jumlahbrgmasuk = mysqli_num_rows($queryambilmasuk);
// hitung jumlah barang keluar
$queryambilkeluar = mysqli_query($conn, "SELECT * FROM keluar");
$jumlahbrgkeluar = mysqli_num_rows($queryambilkeluar);
// hitung jumlah barang
$queryambilbrg = mysqli_query($conn, "SELECT * FROM barang");
$jumlahbrg = mysqli_num_rows($queryambilbrg);
?>
<!-- load css -->
<?php require_once('components/css-login.php') ?>

<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>

<!-- load paket -->
<?php
require_once('components/navbar.php');
require_once('components/header.php');
?>

<div class="pc-container">
    <div class="pc-content">
        <div class="row">
            <h6>Informasi Inventaris Stok Barang</h6>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            Jumlah Barang Masuk : <span class="badge bg-light-primary rounded-pill f-12"><?= $jumlahbrgmasuk ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            Jumlah Barang Keluar : <span class="badge bg-light-primary rounded-pill f-12"><?= $jumlahbrgkeluar ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            Jumlah Barang : <span class="badge bg-light-primary rounded-pill f-12"><?= $jumlahbrg ?></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- load footer -->
<?php require_once('components/footer.php') ?>

<!-- load javascript -->
<?php require_once('components/script-login.php') ?>