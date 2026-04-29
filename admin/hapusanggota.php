<?php
session_start();
include ("../config/koneksi.php");
$id_anggota = $_GET['kd'];
$delete  = mysqli_query($konek, "DELETE FROM tbl_anggota  WHERE id_anggota = '$id_anggota'");
$delete3 = mysqli_query($konek, "DELETE FROM tbl_tabungan WHERE id_anggota = '$id_anggota'");
$delete2 = mysqli_query($konek, "DELETE FROM tbl_login   WHERE id_anggota = '$id_anggota'");

if ($delete) {
    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Berhasil Menghapus Anggota!'];
} else {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Gagal Menghapus Anggota!'];
}
header('Location: dataanggota.php');
exit;
?>