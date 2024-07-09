<?php
require_once ('../helper/koneksi-db.php');

// tambah barang
if (isset($_POST['addbarang'])) {

    $nama_barang = $_POST['nama_barang'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    // Proses upload gambar 
    $imagesname = $_FILES['gambar_barang']['name']; // mendapatkan nama gambar dari form
    $imagestmpname = $_FILES['gambar_barang']['tmp_name']; //mendapatkan lokasi sementara file gambar

    // enkripsi nama file gambar
    $imageFileType = pathinfo($imagesname, PATHINFO_EXTENSION); // Mendapatakan ekstensi file
    $encryptedName = md5(uniqid($imagesname, true)) . '.' . $imageFileType; // menghasilkan nama file yang unik

    // memindahkan file ke direktori tujuan
    move_uploaded_file($imagestmpname, '../docs/' . $encryptedName);

    // insert ke database
    $queryInsert = "INSERT INTO barang (gambar_barang, nama_barang, stok, deskripsi) 
                    VALUES (?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($queryInsert);
    $stmtInsert->bind_param("ssss", $encryptedName, $nama_barang, $stok, $deskripsi);

    if ($stmtInsert->execute()) {
        // header("Location: ../barang.php?process=success");
        header("Location: ../index.php?process=success"); /////====perbaikan
        exit();
    }

    $stmtInsert->close();
}
// akhir tambah

// ubah barang
elseif (isset($_POST['updatebarang'])) {

    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];
    $gambar_barang_baru = $_FILES['gambar_barang']['name'];
    $gambar_barang_lama = $_POST['gambar_barang_lama'];

    if (!empty($gambar_barang_baru)) {
        // proses upload gambar baru
        $imagestmpname = $_FILES['gambar_barang']['tmp_name'];
        $imageFileType = pathinfo($gambar_barang_baru, PATHINFO_EXTENSION);
        $encryptedName = md5(uniqid($gambar_barang_baru, true)) . '.' . $imageFileType;
        // hapus gambar lama
        if (file_exists('../docs/' . $gambar_barang_lama)) {
            unlink('../docs/' . $gambar_barang_lama);
        }
        // memindahkan file ke direktori tujuan
        move_uploaded_file($imagestmpname, '../docs/' . $encryptedName);
        //upload ke database dengan gambar baru
        $queryUpdate = "UPDATE barang SET nama_barang = ?, stok = ?, deskripsi = ?, gambar_barang = ? WHERE id_barang = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param("sissi", $nama_barang, $stok, $deskripsi, $encryptedName, $id_barang);
    } else {
        // update ke database tanpa mengubah gambar
        $queryUpdate = "UPDATE barang SET nama_barang = ?, stok = ?, deskripsi = ? WHERE id_barang = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param("sisi", $nama_barang, $stok, $deskripsi, $id_barang);
    }


    if ($stmtUpdate->execute()) {
        // header("Location: ../barang.php?process=successup");
        header("Location: ../index.php?process=successup"); /////=====perbaikan
        exit();
    } else {
        die('Error executing statement: ' . $stmtUpdate->error);
    }

    $stmtUpdate->close();
}
// akhir ubah

// hapus barang
elseif (isset($_POST['deletebarang'])) {

    $id_barang = $_POST['id_barang'];

    $queryDelete = "DELETE FROM barang WHERE id_barang = ?";
    $stmtdel = $conn->prepare($queryDelete);

    $stmtdel->bind_param("s", $id_barang);

    if ($stmtdel->execute()) {
        // header("Location: ../barang.php?process=successdel");
        header("Location: ../index.php?process=successdel"); /////====perbaikan
        exit();
    } else {
        die('Error executing statement: ' . $stmtdel->error);
    }

    $stmtdel->close();
}
// akhir hapus