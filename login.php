<!-- load css -->
<?php require_once('components/css-login.php') ?>

<!-- isi dari form login -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<div class="auth-main">
    <div class="auth-wrapper v3">
        <div class="auth-form">
            <div class="card my-5">
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <div class="auth-header">
                                <h2 class="text-secondary mt-5"><b>Hi, Welcome Back</b></h2>
                                <p class="f-12 mt-2">Silahkan Login Untuk Melanjutkan</p>
                            </div>
                        </div>
                    </div>
                    <form action="funcs/login-control.php" method="post">
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email address">
                            <label for="floatingInput"> Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <label for="floatingInput1">Password</label>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" name="sublogin" class="btn btn-secondary btn-lg">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- akhir isi form login -->


<!-- pesan benar dan salah untuk akses login -->
<?php $process = isset($_GET['process']) ? ($_GET['process']) : false; ?>
<?php
if ($process == 'success') {
    echo '
            <script>
            Swal.fire({
                icon: "success",
                title: "Terimakasih Anda Berhasil Masuk",
                showConfirmButton: true,
                }).then(function() {
                    window.location.href = "dashboard.php";
                    });
            </script>';
}
?>
<?php
if ($process == 'error') {
    echo '
            <script>
            Swal.fire({
                icon: "error",
                title: "Mohon Maaf, Login Anda Gagal! Harap Masukan Data Dengan Benar",
                showConfirmButton: true,
                }).then(function() {
                    window.location.href = "login.php";
                    });
            </script>';
}
?>

<!-- load javascript -->
<?php require_once('components/script-login.php') ?>