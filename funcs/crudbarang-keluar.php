<?php
require_once('../helper/koneksi-db.php');

// tambah barang keluar
if (isset($_POST['addbarangkeluar'])) {

    $id_barang = $_POST['id_barang'];
    $jumlah_keluar = $_POST['jumlah_keluar'];
    $penerima = $_POST['penerima'];

    $conn->begin_transaction();

    $queryInsert = "INSERT INTO keluar (id_barang, tanggal_keluar, jumlah_keluar, penerima) 
                    VALUES (?, NOW(), ?, ?)";
    $stmtInsert = $conn->prepare($queryInsert);
    $stmtInsert->bind_param("sss", $id_barang, $jumlah_keluar, $penerima);

    if ($stmtInsert->execute()) {
        $stmtInsert->close();

        $queryUpdate = "UPDATE barang SET stok = stok - ? WHERE id_barang = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param("is", $jumlah_keluar, $id_barang);

        if ($stmtUpdate->execute()) {
            $stmtUpdate->close();

            $conn->commit();
            header("Location: ../barang-keluar.php?process=success");
            exit();
        } else {
            $conn->rollback();
            echo "Error: " . $stmtUpdate->error;
        }
    } else {
        $stmtInsert->close();
        $conn->rollback();
        echo "Error: " . $stmtInsert->error;
    }
}
// akhir tambah


// ubah barang keluar
elseif (isset($_POST['editbarangkeluar'])) {

    $id_keluar = $_POST['id_keluar'];
    $id_barang = $_POST['id_barang'];
    $jumlah_baru_keluar = $_POST['jumlah_keluar'];
    $penerima = $_POST['penerima'];

    $querySelect = "SELECT jumlah_keluar FROM keluar WHERE id_keluar = ?";
    $stmtSelect = $conn->prepare($querySelect);
    $stmtSelect->bind_param("i", $id_keluar);
    $stmtSelect->execute();
    $stmtSelect->bind_result($jumlah_lama);
    $stmtSelect->fetch();
    $stmtSelect->close();

    $selisih_jumlah = $jumlah_baru_keluar - $jumlah_lama;

    $conn->begin_transaction();

    $queryUpdateKeluar = "UPDATE keluar SET jumlah_keluar = ?, penerima = ? WHERE id_keluar = ?";
    $stmtUpdateKeluar = $conn->prepare($queryUpdateKeluar);
    $stmtUpdateKeluar->bind_param("iss", $jumlah_baru_keluar, $penerima, $id_keluar);

    if ($stmtUpdateKeluar->execute()) {
        $stmtUpdateKeluar->close();

        $queryUpdateBarang = "UPDATE barang SET stok = stok - ? WHERE id_barang = ?";
        $stmtUpdateBarang = $conn->prepare($queryUpdateBarang);
        $stmtUpdateBarang->bind_param("is", $selisih_jumlah, $id_barang);

        if ($stmtUpdateBarang->execute()) {
            $stmtUpdateBarang->close();

            $conn->commit();
            header("Location: ../barang-keluar.php?process=successup");
            exit();
        } else {
            $conn->rollback();
            echo "Error: " . $stmtUpdateBarang->error;
        }
    } else {
        $stmtUpdateKeluar->close();
        $conn->rollback();
        echo "Error: " . $stmtUpdateKeluar->error;
    }
}
// akhir ubah

// hapus barang keluar
elseif (isset($_POST['deletekeluar'])) {

    $id_keluar = $_POST['id_keluar'];

    $querySelect = "SELECT jumlah_keluar, id_barang FROM keluar WHERE id_keluar = ?";
    $stmtSelect = $conn->prepare($querySelect);
    $stmtSelect->bind_param("i", $id_keluar);
    $stmtSelect->execute();
    $stmtSelect->bind_result($jumlah_hapus, $id_barang);
    $stmtSelect->fetch();
    $stmtSelect->close();

    $conn->begin_transaction();

    $queryUpdate = "UPDATE barang SET stok = stok + ? WHERE id_barang = ?";
    $stmtUpdate = $conn->prepare($queryUpdate);
    $stmtUpdate->bind_param("is", $jumlah_hapus, $id_barang);

    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();

        $queryDelete = "DELETE FROM keluar WHERE id_keluar = ?";
        $stmtdel = $conn->prepare($queryDelete);
        $stmtdel->bind_param("i", $id_keluar);

        if ($stmtdel->execute()) {
            $stmtdel->close();

            $conn->commit();
            header("Location: ../barang-keluar.php?process=successdel");
            exit();
        } else {
            $conn->rollback();
            echo "Error executing statement: " . $stmtdel->error;
        }
    } else {
        $stmtUpdate->close();
        $conn->rollback();
        echo "Error executing statement: " . $stmtUpdate->error;
    }
}
// akhir hapus
