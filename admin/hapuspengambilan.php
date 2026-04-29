<?php
session_start();
include ("../config/koneksi.php");
$id_pengambilan = $_GET['kd'];
$delete = mysqli_query($konek, "DELETE FROM tbl_pengambilan WHERE id_pengambilan = '$id_pengambilan'");

if ($delete) {
    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Berhasil Menghapus Pengambilan!'];
} else {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Gagal Menghapus Pengambilan!'];
}
header('Location: datapengambilan.php');
exit;
?>