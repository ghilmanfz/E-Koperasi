<?php
session_start();
include ("../config/koneksi.php");
$id_simpanan = $_GET['kd'];
$delete = mysqli_query($konek, "DELETE FROM tbl_simpanan WHERE id_simpanan = '$id_simpanan'");

if ($delete) {
    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Berhasil Menghapus Simpanan!'];
} else {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Gagal Menghapus Simpanan!'];
}
header('Location: datasimpanan.php');
exit;
?>