<?php
session_start();
include ("../config/koneksi.php");
if (($_SESSION['level'] ?? '') !== 'admin') {
    header('Location: ../index.php'); exit;
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'ID akun tidak valid.'];
    header('Location: manajemenakun.php'); exit;
}

// Prevent deleting own account
$current_user = $_SESSION['username'] ?? '';
$row = mysqli_fetch_assoc(mysqli_query($konek, "SELECT username FROM tbl_login WHERE id=$id"));
if (!$row) {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Akun tidak ditemukan.'];
    header('Location: manajemenakun.php'); exit;
}
if ($row['username'] === $current_user) {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Tidak diizinkan menghapus akun sendiri.'];
    header('Location: manajemenakun.php'); exit;
}

$del = mysqli_query($konek, "DELETE FROM tbl_login WHERE id=$id");
if ($del) {
    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Akun berhasil dihapus!'];
} else {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Gagal menghapus akun: ' . mysqli_error($konek)];
}
header('Location: manajemenakun.php'); exit;
?>
