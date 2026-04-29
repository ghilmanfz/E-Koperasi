<?php
session_start();
include ("../config/koneksi.php");
if (($_SESSION['level'] ?? '') !== 'bendahara') {
    header('Location: ../index.php');
    exit;
}

$type = $_GET['type'] ?? '';

// Predefined destinations — no open redirect possible
$destinations = [
    'pinjaman' => 'laporanpinjaman.php',
    'pending'  => 'index.php',
    'keuangan' => 'laporanpengambilan.php',
];

// Query current counts so we can detect future increases
$counts = [
    'pinjaman' => (int)(mysqli_fetch_row(mysqli_query($konek, "SELECT COUNT(*) FROM tbl_pinjaman WHERE jumlah_pinjaman > 0"))[0] ?? 0),
    'pending'  => (int)(mysqli_fetch_row(mysqli_query($konek, "SELECT COUNT(*) FROM tbl_anggota WHERE keterangan='Pending'"))[0] ?? 0),
    'keuangan' => (int)(mysqli_fetch_row(mysqli_query($konek, "SELECT COUNT(*) FROM tbl_pengambilan WHERE MONTH(tgl_pengambilan)=MONTH(NOW()) AND YEAR(tgl_pengambilan)=YEAR(NOW())"))[0] ?? 0),
];

if (array_key_exists($type, $counts)) {
    if (!isset($_SESSION['bd_notif_seen'])) {
        $_SESSION['bd_notif_seen'] = [];
    }
    $_SESSION['bd_notif_seen'][$type] = $counts[$type];
}

$redirect = $destinations[$type] ?? 'index.php';
header('Location: ' . $redirect);
exit;
