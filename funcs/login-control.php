<?php
// Memulai sesi untuk menyimpan informasi pengguna yang berhasil login.
session_start();

// Menyertakan file koneksi database untuk menghubungkan ke database.
include '../helper/koneksi-db.php';

// Memeriksa apakah form telah dikirim dengan metode POST dan tombol submit telah ditekan.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sublogin'])) {
    // Mengambil nilai email dan password dari permintaan POST pada tabel login.
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Menyiapkan pernyataan SQL dengan placeholder untuk mencegah serangan SQL injection.
    $stmt = $conn->prepare('SELECT id, email, password FROM login WHERE email = ?');
    // Mengikat parameter input (email) ke pernyataan yang telah disiapkan.
    $stmt->bind_param('s', $email);
    // Menjalankan pernyataan SQL.
    $stmt->execute();
    // Menyimpan hasil dari pernyataan SQL.
    $stmt->store_result();

    // Memeriksa apakah ada pengguna dengan email yang diberikan.
    if ($stmt->num_rows > 0) {
        // Mengikat variabel hasil dari pernyataan SQL.
        $stmt->bind_result($id, $email, $stored_password);
        // Mengambil hasil dari pernyataan SQL.
        $stmt->fetch();

        // Memverifikasi password yang diberikan dengan password yang disimpan di database.
        if ($password === $stored_password) {
            // Jika password benar, set variabel sesi dan alihkan ke halaman yang dituju.
            $_SESSION['id'] = $id;
            $_SESSION['email'] = $email;
            // header("Location: ../login.php?process=success");
            
            header("Location: ../index.php?process=success"); //*perbaikan
            exit();
        } else {
            // Jika password salah, tampilkan pesan kesalahan pada halaman login.
            header("Location: ../login.php?process=error");
        }
    } else {
        // Jika tidak ada pengguna dengan email yang diberikan, tampilkan pesan kesalahan.
        header("Location: ../login.php?process=error");
    }

    // Menutup pernyataan SQL.
    $stmt->close();
}

// Menutup koneksi database.
$conn->close();
