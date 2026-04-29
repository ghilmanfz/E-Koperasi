<?php
session_start();
include ("../config/koneksi.php");
$id_angsuran = $_GET['kd'];
$delete = mysqli_query($konek, "DELETE FROM tbl_pembayaran WHERE id_angsuran = '$id_angsuran'");

if ($delete) {
    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Berhasil Menghapus Pembayaran!'];
} else {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Gagal Menghapus Pembayaran!'];
}
header('Location: datapembayaran.php');
exit;
?>