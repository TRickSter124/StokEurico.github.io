<?php
require_once('../helper/koneksi-db.php');

// tambah barang masuk
if (isset($_POST['addbarangmasuk'])) {

    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    $conn->begin_transaction();

    $queryInsert = "INSERT INTO masuk (id_barang, tanggal, jumlah, keterangan) 
                    VALUES (?, NOW(), ?, ?)";
    $stmtInsert = $conn->prepare($queryInsert);
    $stmtInsert->bind_param("sss", $id_barang, $jumlah, $keterangan);

    if ($stmtInsert->execute()) {
        $stmtInsert->close();

        $queryUpdate = "UPDATE barang SET stok = stok + ? WHERE id_barang = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param("is", $jumlah, $id_barang);

        if ($stmtUpdate->execute()) {
            $stmtUpdate->close();

            $conn->commit();
            header("Location: ../barang-masuk.php?process=success");
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


// ubah barang masuk
elseif (isset($_POST['editbarangmasuk'])) {

    $id_masuk = $_POST['id_masuk'];
    $id_barang = $_POST['id_barang'];
    $jumlah_baru = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    $querySelect = "SELECT jumlah FROM masuk WHERE id_masuk = ?";
    $stmtSelect = $conn->prepare($querySelect);
    $stmtSelect->bind_param("i", $id_masuk);
    $stmtSelect->execute();
    $stmtSelect->bind_result($jumlah_lama);
    $stmtSelect->fetch();
    $stmtSelect->close();

    $conn->begin_transaction();

    $queryUpdateMasuk = "UPDATE masuk SET jumlah = ?, keterangan = ? WHERE id_masuk = ?";
    $stmtUpdateMasuk = $conn->prepare($queryUpdateMasuk);
    $stmtUpdateMasuk->bind_param("ssi", $jumlah_baru, $keterangan, $id_masuk);

    if ($stmtUpdateMasuk->execute()) {
        $stmtUpdateMasuk->close();

        if ($jumlah_baru != $jumlah_lama) {
            $selisih_jumlah = $jumlah_baru - $jumlah_lama;

            $queryUpdateBarang = "UPDATE barang SET stok = stok + ? WHERE id_barang = ?";
            $stmtUpdateBarang = $conn->prepare($queryUpdateBarang);
            $stmtUpdateBarang->bind_param("is", $selisih_jumlah, $id_barang);

            if ($stmtUpdateBarang->execute()) {
                $stmtUpdateBarang->close();

                $conn->commit();
                header("Location: ../barang-masuk.php?process=successup");
                exit();
            } else {
                $conn->rollback();
                echo "Error: " . $stmtUpdateBarang->error;
            }
        } else {
            $conn->commit();
            header("Location: ../barang-masuk.php?process=successup");
            exit();
        }
    } else {
        $stmtUpdateMasuk->close();
        $conn->rollback();
        echo "Error: " . $stmtUpdateMasuk->error;
    }
}

// akhir ubah

// hapus barang masuk
elseif (isset($_POST['deletemasuk'])) {

    $id_masuk = $_POST['id_masuk'];

    $querySelect = "SELECT jumlah, id_barang FROM masuk WHERE id_masuk = ?";
    $stmtSelect = $conn->prepare($querySelect);
    $stmtSelect->bind_param("i", $id_masuk);
    $stmtSelect->execute();
    $stmtSelect->bind_result($jumlah_hapus, $id_barang);
    $stmtSelect->fetch();
    $stmtSelect->close();

    $conn->begin_transaction();

    $queryUpdate = "UPDATE barang SET stok = stok - ? WHERE id_barang = ?";
    $stmtUpdate = $conn->prepare($queryUpdate);
    $stmtUpdate->bind_param("is", $jumlah_hapus, $id_barang);

    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();

        $queryDelete = "DELETE FROM masuk WHERE id_masuk = ?";
        $stmtdel = $conn->prepare($queryDelete);
        $stmtdel->bind_param("i", $id_masuk);

        if ($stmtdel->execute()) {
            $stmtdel->close();

            $conn->commit();
            header("Location: ../barang-masuk.php?process=successdel");
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
