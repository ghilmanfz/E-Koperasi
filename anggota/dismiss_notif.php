<?php
session_start();
include ("../config/koneksi.php");
if (($_SESSION['level'] ?? '') !== 'anggota') {
    header('Location: ../index.php');
    exit;
}

$type = $_GET['type'] ?? '';

// Predefined destinations — no open redirect possible
$destinations = [
    'pinjaman' => 'riwayatpinjaman.php',
];

// Query current count for this member so we can detect future increases
$sid = mysqli_real_escape_string($konek, $_SESSION['id'] ?? '');
$counts = [
    'pinjaman' => (int)(mysqli_fetch_row(mysqli_query($konek,
        "SELECT COUNT(*) FROM tbl_pinjaman a
         LEFT JOIN tbl_login b ON a.id_anggota = b.id_anggota
         WHERE b.id = '$sid' AND a.jumlah_pinjaman > 0"))[0] ?? 0),
];

if (array_key_exists($type, $counts)) {
    if (!isset($_SESSION['ag_notif_seen'])) {
        $_SESSION['ag_notif_seen'] = [];
    }
    $_SESSION['ag_notif_seen'][$type] = $counts[$type];
}

$redirect = $destinations[$type] ?? 'index.php';
header('Location: ' . $redirect);
exit;
