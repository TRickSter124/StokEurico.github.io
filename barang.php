<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?>
<?php require_once('helper/koneksi-db.php'); ?>
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
            <div class="col-sm-12">
                <div class="card table-card">
                    <div class="card-header">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="ti ti-plus"></i> Data Barang</button>

                        <!-- tambahkan link/ tombol yang mengacu pada file exportbarang.php di sini untuk mendapatkan hasil cetak stok barang -->

                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah data barang</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="funcs/crudbarang.php" method="post">
                                        <div class="modal-body">
                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label">Nama Barang</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="nama_barang" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label">Stok</label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="stok" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label">Deskripsi</label>
                                                <div class="col-sm-8">
                                                    <textarea name="deskripsi" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="addbarang" class="btn btn-primary">Add Barang</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="pc-dt-simple">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Nama Barang</th>
                                        <th>Stok</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $querySelect = "SELECT * FROM barang";
                                    $result = $conn->query($querySelect);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row['nama_barang'] ?></td>
                                                <td><span class="badge bg-light-primary rounded-pill f-12"><?= $row['stok'] ?></span></td>
                                                <td><?= $row['deskripsi'] ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-icon btn-link-secondary" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id_barang'] ?>">
                                                        <i class="ti ti-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-link-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $row['id_barang'] ?>">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- tampil modal edit -->
                                            <div class="modal fade" id="edit<?= $row['id_barang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah data barang</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="funcs/crudbarang.php" method="post">
                                                            <div class="modal-body">
                                                                <div class="mb-3 row">
                                                                    <label class="col-sm-4 col-form-label">Nama Barang</label>
                                                                    <div class="col-sm-8">
                                                                        <!-- ambil id barang pada bagian edit data -->
                                                                        <input type="hidden" name="id_barang" value="<?= $row['id_barang'] ?>">
                                                                        <!-- akhir -->
                                                                        <input type="text" name="nama_barang" class="form-control" value="<?= $row['nama_barang'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label class="col-sm-4 col-form-label">Stok</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="number" name="stok" class="form-control" value="<?= $row['stok'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label class="col-sm-4 col-form-label">Deskripsi</label>
                                                                    <div class="col-sm-8">
                                                                        <textarea name="deskripsi" class="form-control"><?= $row['deskripsi'] ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="updatebarang" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- akhir modal -->

                                            <!-- tampil modal hapus -->
                                            <div class="modal fade" id="delete<?= $row['id_barang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Data</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="funcs/crudbarang.php" method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_barang" value="<?= $row['id_barang'] ?>">
                                                                Apakah anda yakin ingin menghapus data ?
                                                                Data barang yang ingin anda hapus adalah <b><?= $row['nama_barang'] ?></b>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="deletebarang" class="btn btn-primary">Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- akhir modal -->
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $process = isset($_GET['process']) ? $_GET['process'] : false; ?>
<!-- Panggil fungsi notifikasi sweetalert menggunakan parameter GET process untuk tambah data -->
<?php
if ($process == 'success') {
    echo '
          <script>
            Swal.fire({
                icon: "success",
                title: "Berhasil menambah data",
                showConfirmButton: true,
                }).then(function() {
                    window.location.href = "barang.php";
                    });
          </script>';
}
?>

<!-- edit data pada baris berikutnya -->
<?php
if ($process == 'successup') {
    echo '
          <script>
            Swal.fire({
                icon: "success",
                title: "Berhasil mengubah data",
                showConfirmButton: true,
                }).then(function() {
                    window.location.href = "barang.php";
                    });
          </script>';
}
?>

<!-- dan hapus data pada baris berikutnya -->
<?php
if ($process == 'successdel') {
    echo '
          <script>
            Swal.fire({
                icon: "success",
                title: "Berhasil menghapus data",
                showConfirmButton: true,
                }).then(function() {
                    window.location.href = "barang.php";
                    });
          </script>';
}
?>

<!-- load footer -->
<?php require_once('components/footer.php') ?>

<!-- load javascript -->
<?php require_once('components/script-login.php') ?>
