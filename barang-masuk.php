<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
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
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <i class="ti ti-plus"></i> Data Barang Masuk</button>
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah data barang masuk</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="funcs/crudbarang-masuk.php" method="post">
                                        <div class="modal-body">
                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label">Nama Barang</label>
                                                <div class="col-sm-8">
                                                    <select name="id_barang" class="form-control" required>
                                                        <option selected disabled>Pilih.......</option>
                                                        <?php
                                                        $queryambilbarang = mysqli_query($conn, "SELECT * FROM barang");
                                                        while ($rows = mysqli_fetch_array($queryambilbarang)) { ?>
                                                            <option value="<?= $rows['id_barang'] ?>"><?= $rows['nama_barang'] ?></option>
                                                        <?php }  ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label">Jumlah Barang Masuk</label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="jumlah" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label">Keterangan</label>
                                                <div class="col-sm-8">
                                                    <textarea name="keterangan" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="addbarangmasuk" class="btn btn-primary">Add Barang</button>
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
                                        <th>Tanggal Barang Masuk</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $querySelect = "SELECT * FROM masuk m, barang b WHERE b.id_barang=m.id_barang";
                                    $result = $conn->query($querySelect);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row['nama_barang'] ?></td>
                                                <td><?= $row['tanggal'] ?></td>
                                                <td><span class="badge bg-light-primary rounded-pill f-12"><?= $row['jumlah'] ?></span></td>
                                                <td><?= $row['keterangan'] ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-icon btn-link-secondary" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id_masuk'] ?>">
                                                        <i class="ti ti-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-link-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $row['id_masuk'] ?>">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- tampil modal edit -->
                                            <div class="modal fade" id="edit<?= $row['id_masuk'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah data barang</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="funcs/crudbarang-masuk.php" method="post">
                                                            <div class="modal-body">
                                                                <div class="mb-3 row">
                                                                    <label class="col-sm-4 col-form-label">Nama Barang</label>
                                                                    <div class="col-sm-8">
                                                                        <!-- ambil id masuk pada bagian edit data -->
                                                                        <input type="hidden" name="id_masuk" value="<?= $row['id_masuk'] ?>">
                                                                        <!-- akhir -->
                                                                        <?php
                                                                        // Mendapatkan id_barang yang sedang diedit
                                                                        $id_barang_edit = $row['id_barang']; // Inisialisasi variabel untuk menyimpan id_barang yang sedang diedit
                                                                        if (isset($_GET['id_barang'])) {
                                                                            $id_barang_edit = $_GET['id_barang'];
                                                                        }

                                                                        // Mengambil daftar barang dari database
                                                                        $queryambilbarang = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang = '$id_barang_edit'");
                                                                        $barang = mysqli_fetch_assoc($queryambilbarang);
                                                                        ?>
                                                                        <select name="id_barang" class="form-control" required>
                                                                            <?php if ($barang) { ?>
                                                                                <option value="<?= $barang['id_barang'] ?>"><?= $barang['nama_barang'] ?></option>
                                                                            <?php } else { ?>
                                                                                <option disabled selected>Pilih.......</option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label class="col-sm-4 col-form-label">Jumlah Barang Masuk</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="number" name="jumlah" class="form-control" required value="<?= $row['jumlah'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label class="col-sm-4 col-form-label">Keterangan</label>
                                                                    <div class="col-sm-8">
                                                                        <textarea name="keterangan" class="form-control" required><?= $row['keterangan'] ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="editbarangmasuk" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- akhir modal -->

                                            <!-- tampil modal hapus -->
                                            <div class="modal fade" id="delete<?= $row['id_masuk'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Data</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="funcs/crudbarang-masuk.php" method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_masuk" value="<?= $row['id_masuk'] ?>">
                                                                Apakah anda yakin ingin menghapus data ?
                                                                Data barang masuk yang ingin anda hapus adalah <b><?= $row['nama_barang'] ?></b>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="deletemasuk" class="btn btn-primary">Delete</button>
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

<!-- panggil fungsi sweetalert di sini -->

<!-- tambahkan notifikasi tambah data di sini -->
<?php $process = isset($_GET['process']) ? ($_GET['process']) : false; ?>
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
                window.location.href = "barang-masuk.php";
                });
        </script>';
}
?>
<!-- akhir fungsi notifikasi -->

<!-- edit data pada baris berikutnya -->
<!-- Panggil fungsi notifikasi sweetalert menggunakan parameter GET process untuk update data -->
<?php
if ($process == 'successup') {
    echo '
        <script>
        Swal.fire({
            icon: "success",
            title: "Berhasil mengubah data",
            showConfirmButton: true,
            }).then(function() {
               window.location.href = "barang-masuk.php";
                });
        </script>';
}
?>

<!-- dan hapus data pada baris berikutnya -->
<!-- Panggil fungsi notifikasi sweetalert menggunakan parameter GET process untuk delete data -->
<?php
if ($process == 'successdel') {  
    echo '
        <script>
        Swal.fire({
            icon: "success",
            title: "Berhasil mengahapus data",
            showConfirmButton: true,
            }).then(function() {
                window.location.href = "barang-masuk.php";
                });
        </script>';
}
?>
<!-- akhir fungsi notifikasi -->


<!-- load footer -->
<?php require_once('components/footer.php') ?>

<!-- load javascript -->
<?php require_once('components/script-login.php') ?>