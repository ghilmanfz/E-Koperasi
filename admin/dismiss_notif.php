<?php
session_start();
include ("../config/koneksi.php");
if (($_SESSION['level'] ?? '') !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$type = $_GET['type'] ?? '';

// Predefined destinations — no open redirect possible
$destinations = [
    'pending'  => 'dataanggota.php',
    'baru'     => 'dataanggota.php',
    'pinjaman' => 'datapinjaman.php',
];

// Query current counts so we can detect future increases
$counts = [
    'pending'  => (int)(mysqli_fetch_row(mysqli_query($konek, "SELECT COUNT(*) FROM tbl_anggota WHERE keterangan='Pending'"))[0] ?? 0),
    'baru'     => (int)(mysqli_fetch_row(mysqli_query($konek, "SELECT COUNT(*) FROM tbl_anggota WHERE MONTH(tanggal_masuk)=MONTH(NOW()) AND YEAR(tanggal_masuk)=YEAR(NOW())"))[0] ?? 0),
    'pinjaman' => (int)(mysqli_fetch_row(mysqli_query($konek, "SELECT COUNT(*) FROM tbl_pinjaman WHERE jumlah_pinjaman > 0"))[0] ?? 0),
];

if (array_key_exists($type, $counts)) {
    if (!isset($_SESSION['ad_notif_seen'])) {
        $_SESSION['ad_notif_seen'] = [];
    }
    $_SESSION['ad_notif_seen'][$type] = $counts[$type];
}

$redirect = $destinations[$type] ?? 'index.php';
header('Location: ' . $redirect);
exit;
