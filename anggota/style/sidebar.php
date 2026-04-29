<?php
include ("../config/koneksi.php");
session_start();
if ($_SESSION['level'] != 'anggota') {
    header('Location: ../index.php');
    exit;
}
$current_page = basename($_SERVER['PHP_SELF']);
// Notifikasi anggota (berdasarkan akun login)
$ag_pinjaman = mysqli_fetch_row(mysqli_query($konek, "SELECT COUNT(*) FROM tbl_pinjaman a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE b.id='{$_SESSION['id']}' AND a.jumlah_pinjaman > 0"))[0] ?? 0;
$_ag_seen         = $_SESSION['ag_notif_seen'] ?? [];
$show_ag_pinjaman = $ag_pinjaman > ($_ag_seen['pinjaman'] ?? -1);
$ag_notif_count   = ($show_ag_pinjaman ? 1 : 0);
// Load tbl_settings
mysqli_query($konek, "CREATE TABLE IF NOT EXISTS tbl_settings (setting_key VARCHAR(50) NOT NULL PRIMARY KEY, setting_value TEXT) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
$_sk_def = ['nama_koperasi'=>'Koperasi HIS','alamat'=>'Jl. HR. Rasuna Said','telepon'=>'0851-7201-4471','email'=>'mahisduhan2003@gmail.com','deskripsi'=>'Sistem Informasi Manajemen Koperasi yang Modern, Transparan, dan Akuntabel. Kelola data anggota dan keuangan dengan lebih efisien.','logo_path'=>'','foto_hero'=>'','syarat_anggota'=>"Kewarganegaraan INDONESIA asli.\nKeanggotaan bersifat perorangan dan bukan dalam bentuk badan hukum.\nBersedia membayar Simpanan Pokok dan Simpanan Wajib sesuai ketentuan yang ditetapkan.\nMenyetujui Anggaran Dasar, Anggaran Rumah Tangga dan ketentuan yang berlaku dalam Koperasi.",'syarat_pinjaman'=>"Berstatus aktif sebagai Anggota Koperasi.\nMengisi Formulir Pinjaman secara lengkap.\nMenyerahkan Fotocopy KTP (Suami & Istri bagi yang sudah menikah).\nMenyerahkan Fotocopy KK, Rekening Listrik, Slip Gaji, dan dokumen Agunan.\nMelengkapi Pengajuan Pinjaman dengan Proposal Tujuan Penggunaan Dana.",'cta_judul'=>'Butuh Bantuan Administrasi?','cta_deskripsi'=>'Silakan hubungi tim manajemen koperasi atau buka modul data anggota untuk pengelolaan lebih lanjut.'];
foreach ($_sk_def as $_k => $_v) {
    mysqli_query($konek, "INSERT IGNORE INTO tbl_settings (setting_key, setting_value) VALUES ('".mysqli_real_escape_string($konek, $_k)."', '".mysqli_real_escape_string($konek, $_v)."')");
}
$sk_settings = $_sk_def;
$_res = mysqli_query($konek, "SELECT setting_key, setting_value FROM tbl_settings");
if ($_res) { while ($_r = mysqli_fetch_assoc($_res)) { $sk_settings[$_r['setting_key']] = $_r['setting_value']; } }
?>
<body class="ag-body">
<div class="ag-wrap">

  <!-- Sidebar -->
  <aside class="ag-sidebar">
    <div class="ag-logo-area">
      <?php if (!empty($sk_settings['logo_path'])): ?>
      <img src="../<?php echo htmlspecialchars($sk_settings['logo_path']); ?>" alt="Logo" class="ag-sidebar-logo-img" style="height:36px;max-height:36px;width:auto;max-width:100px;object-fit:contain;border-radius:6px;flex-shrink:0;">
      <?php else: ?>
      <div class="ag-logo-icon"><i class="fa fa-diamond"></i></div>
      <?php endif; ?>
      <span class="ag-logo-text"><?php echo htmlspecialchars($sk_settings['nama_koperasi'] ?? 'Karya Sejahtera'); ?></span>
    </div>
    <nav class="ag-nav">
      <div class="ag-nav-group">Menu Utama</div>
      <a href="index.php" class="ag-nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
        <i class="fa fa-home"></i> Home
      </a>
      <a href="dataanggota.php" class="ag-nav-link <?php echo ($current_page == 'dataanggota.php') ? 'active' : ''; ?>">
        <i class="fa fa-user"></i> Profil Saya
      </a>
      <a href="datatabungan.php" class="ag-nav-link <?php echo ($current_page == 'datatabungan.php') ? 'active' : ''; ?>">
        <i class="fa fa-credit-card"></i> Tabungan Saya
      </a>
      <div class="ag-nav-group" style="margin-top:8px;">Riwayat Transaksi</div>
      <a href="riwayatsimpanan.php" class="ag-nav-link <?php echo ($current_page == 'riwayatsimpanan.php') ? 'active' : ''; ?>">
        <i class="fa fa-database"></i> Riwayat Simpanan
      </a>
      <a href="riwayatpinjaman.php" class="ag-nav-link <?php echo ($current_page == 'riwayatpinjaman.php') ? 'active' : ''; ?>">
        <i class="fa fa-money"></i> Riwayat Pinjaman
      </a>
      <a href="riwayatangsuran.php" class="ag-nav-link <?php echo ($current_page == 'riwayatangsuran.php') ? 'active' : ''; ?>">
        <i class="fa fa-calendar-check-o"></i> Riwayat Angsuran
      </a>
      <a href="riwayatpengambilan.php" class="ag-nav-link <?php echo ($current_page == 'riwayatpengambilan.php') ? 'active' : ''; ?>">
        <i class="fa fa-arrow-circle-down"></i> Riwayat Pengambilan
      </a>
    </nav>
    <div class="ag-nav-logout">
      <a href="../logout.php"><i class="fa fa-sign-out"></i> Keluar</a>
    </div>
  </aside>

  <!-- Main area -->
  <div class="ag-main">
    <!-- Topbar -->
    <header class="ag-topbar">
      <div class="ag-topbar-brand">
        <span class="ag-topbar-brand-text"><?php echo htmlspecialchars($sk_settings['nama_koperasi'] ?? 'Karya Sejahtera'); ?></span>
      </div>
      <div class="ag-topbar-right">
        <div class="ag-notif-wrap">
          <div class="ag-notif-btn" id="agNotifBtn">
            <i class="fa fa-bell-o"></i>
            <?php if ($ag_notif_count > 0): ?>
            <span class="ag-notif-badge"><?php echo $ag_notif_count; ?></span>
            <?php endif; ?>
          </div>
          <div class="ag-notif-panel" id="agNotifPanel">
            <div class="ag-notif-header"><i class="fa fa-bell"></i> Notifikasi</div>
            <div class="ag-notif-list">
              <?php if ($show_ag_pinjaman): ?>
              <a href="dismiss_notif.php?type=pinjaman" class="ag-notif-item">
                <div class="ag-notif-icon ag-notif-orange"><i class="fa fa-credit-card"></i></div>
                <div class="ag-notif-text">
                  <strong><?php echo $ag_pinjaman; ?> pinjaman</strong> masih aktif
                  <span>Lihat riwayat pinjaman</span>
                </div>
              </a>
              <?php endif; ?>
              <?php if ($ag_notif_count === 0): ?>
              <div class="ag-notif-empty"><i class="fa fa-check-circle"></i> Tidak ada notifikasi</div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="ag-user-block">
          <div class="ag-user-name"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Anggota'); ?></div>
          <div class="ag-user-role">Anggota</div>
        </div>
        <div class="ag-user-avatar-wrap">
          <img src="../assets/dist/img/his.jpg" alt="Avatar" class="ag-user-avatar">
          <span class="ag-user-online"></span>
        </div>
      </div>
    </header>

    <!-- Content -->
    <div class="ag-content">
<?php if (!empty($_SESSION['flash'])): $f = $_SESSION['flash']; unset($_SESSION['flash']); ?>
<div id="flashToast" class="flash-toast flash-<?php echo htmlspecialchars($f['type']); ?>">
  <i class="flash-icon fa fa-<?php echo $f['type']==='success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
  <div class="flash-body">
    <span class="flash-title"><?php echo $f['type']==='success' ? 'Berhasil' : 'Gagal'; ?></span>
    <span class="flash-msg"><?php echo htmlspecialchars($f['msg']); ?></span>
  </div>
  <button class="flash-close" onclick="document.getElementById('flashToast').remove()">&times;</button>
  <div class="flash-progress"></div>
</div>
<script>setTimeout(function(){var t=document.getElementById('flashToast');if(t){t.style.opacity='0';t.style.transform='translateX(110%)';t.style.transition='opacity 0.4s,transform 0.4s';setTimeout(function(){if(t)t.remove();},400);}},3000);</script>
<?php endif; ?>
<script>
// ===== Notifications =====
document.getElementById('agNotifBtn').addEventListener('click',function(e){
  e.stopPropagation();
  var p=document.getElementById('agNotifPanel');
  p.style.display=p.style.display==='block'?'none':'block';
});
document.addEventListener('click',function(e){
  var w=document.querySelector('.ag-notif-wrap');
  if(w&&!w.contains(e.target)){var p=document.getElementById('agNotifPanel');if(p)p.style.display='none';}
});
</script>
