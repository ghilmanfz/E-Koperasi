<?php
session_start();
include ("../config/koneksi.php");
$id_pinjaman = $_GET['kd'];
$delete = mysqli_query($konek, "DELETE FROM tbl_pinjaman WHERE id_pinjaman = '$id_pinjaman'");

if ($delete) {
    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Berhasil Menghapus Pinjaman!'];
} else {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Gagal Menghapus Pinjaman!'];
}
header('Location: datapinjaman.php');
exit;
?>