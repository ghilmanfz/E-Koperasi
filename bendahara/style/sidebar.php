<?php
$cur = basename($_SERVER['PHP_SELF']);
function sk_nav($href, $icon, $label, $cur) {
    $active = ($cur === $href) ? ' active' : '';
    return '<a href="'.$href.'" class="sk-nav-item'.$active.'"><i class="fa '.$icon.'"></i> <span>'.$label.'</span></a>';
}
?>
<?php
include ("../config/koneksi.php");
session_start();
if ($_SESSION['level'] != 'bendahara') {
    header('Location: ../index.php');
    exit;
}
// Notifikasi
$notif_pinjaman = mysqli_fetch_row(mysqli_query($konek,"SELECT COUNT(*) FROM tbl_pinjaman WHERE jumlah_pinjaman > 0"))[0] ?? 0;
$notif_pending  = mysqli_fetch_row(mysqli_query($konek,"SELECT COUNT(*) FROM tbl_anggota WHERE keterangan='Pending'"))[0] ?? 0;
$notif_keuangan = mysqli_fetch_row(mysqli_query($konek,"SELECT COUNT(*) FROM tbl_pengambilan WHERE MONTH(tgl_pengambilan)=MONTH(NOW()) AND YEAR(tgl_pengambilan)=YEAR(NOW())"))[0] ?? 0;
$_bd_seen      = $_SESSION['bd_notif_seen'] ?? [];
$show_pinjaman = $notif_pinjaman > ($_bd_seen['pinjaman'] ?? -1);
$show_pending  = $notif_pending  > ($_bd_seen['pending']  ?? -1);
$show_keuangan = $notif_keuangan > ($_bd_seen['keuangan'] ?? -1);
$notif_count   = ($show_pinjaman ? 1 : 0) + ($show_pending ? 1 : 0) + ($show_keuangan ? 1 : 0);
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
<body class="sk-body">
<div class="sk-wrap">

  <!-- ===== SIDEBAR ===== -->
  <aside class="sk-sidebar">
    <div class="sk-sidebar-logo">
      <?php if (!empty($sk_settings['logo_path'])): ?>
      <img src="../<?php echo htmlspecialchars($sk_settings['logo_path']); ?>" alt="Logo" class="sk-sidebar-logo-img">
      <?php else: ?>
      <div class="sk-logo-icon">
        <svg viewBox="0 0 24 24"><path d="M12 2L2 7v10l10 5 10-5V7L12 2zm0 2.18L20 8v8l-8 4-8-4V8l8-3.82z"/></svg>
      </div>
      <?php endif; ?>
      <span class="sk-logo-text"><?php echo htmlspecialchars($sk_settings['nama_koperasi'] ?? 'Karya Sejahtera'); ?></span>
    </div>

    <nav class="sk-nav">
      <?php echo sk_nav('index.php','fa-home','Dashboard',$cur); ?>

      <div class="sk-nav-section">Laporan</div>
      <?php echo sk_nav('laporanpinjaman.php','fa-credit-card','Laporan Pinjaman',$cur); ?>
      <?php echo sk_nav('laporanpengambilan.php','fa-money','Laporan Pengambilan',$cur); ?>
      <?php echo sk_nav('laporankeuangan.php','fa-bar-chart','Laporan Keuangan',$cur); ?>
    </nav>

    <div class="sk-sidebar-bottom">
      <a href="../logout.php" class="sk-nav-item sk-logout"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
    </div>
  </aside>

  <!-- ===== MAIN ===== -->
  <div class="sk-main">

    <!-- Topbar -->
    <header class="sk-topbar">
      <div class="sk-topbar-search" id="searchWrap">
        <i class="fa fa-search"></i>
        <input type="text" placeholder="Search data..." id="searchInput" autocomplete="off">
        <div class="sk-search-dropdown" id="searchDropdown"></div>
      </div>
      <div class="sk-topbar-actions">
        <div class="sk-notif-wrap">
          <button class="sk-btn-icon" id="notifBtn">
            <i class="fa fa-bell-o"></i>
            <?php if ($notif_count > 0): ?>
            <span class="sk-notif-badge"><?php echo $notif_count; ?></span>
            <?php endif; ?>
          </button>
          <div class="sk-notif-panel" id="notifPanel">
            <div class="sk-notif-header"><i class="fa fa-bell"></i> Notifikasi</div>
            <div class="sk-notif-list">
              <?php if ($show_pinjaman): ?>
              <a href="dismiss_notif.php?type=pinjaman" class="sk-notif-item sk-notif-orange">
                <div class="sk-notif-icon"><i class="fa fa-credit-card"></i></div>
                <div class="sk-notif-text">
                  <strong><?php echo $notif_pinjaman; ?> pinjaman</strong> masih aktif
                  <span>Perlu dipantau</span>
                </div>
              </a>
              <?php endif; ?>
              <?php if ($show_pending): ?>
              <a href="dismiss_notif.php?type=pending" class="sk-notif-item sk-notif-warn">
                <div class="sk-notif-icon"><i class="fa fa-user-plus"></i></div>
                <div class="sk-notif-text">
                  <strong><?php echo $notif_pending; ?> anggota</strong> menunggu konfirmasi
                  <span>Status: Pending</span>
                </div>
              </a>
              <?php endif; ?>
              <?php if ($show_keuangan): ?>
              <a href="dismiss_notif.php?type=keuangan" class="sk-notif-item sk-notif-info">
                <div class="sk-notif-icon"><i class="fa fa-money"></i></div>
                <div class="sk-notif-text">
                  <strong><?php echo $notif_keuangan; ?> pengambilan</strong> bulan ini
                  <span>Lihat laporan pengambilan</span>
                </div>
              </a>
              <?php endif; ?>
              <?php if ($notif_count === 0): ?>
              <div class="sk-notif-empty"><i class="fa fa-check-circle"></i> Tidak ada notifikasi</div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="sk-user">
          <div class="sk-user-info">
            <span class="sk-user-name"><?php echo htmlspecialchars($_SESSION['username'] ?? $_SESSION['nama'] ?? 'Bendahara'); ?></span>
            <span class="sk-user-role">Bendahara</span>
          </div>
          <img src="../assets/dist/img/his.jpg" alt="Avatar" class="sk-avatar">
        </div>
      </div>
    </header>

    <!-- Page Content -->
    <div class="sk-content">
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
// ===== Search =====
var menuItems=[
  {label:'Dashboard',url:'index.php',icon:'fa-home'},
  {label:'Laporan Pinjaman',url:'laporanpinjaman.php',icon:'fa-credit-card'},
  {label:'Laporan Pengambilan',url:'laporanpengambilan.php',icon:'fa-money'},
  {label:'Laporan Keuangan',url:'laporankeuangan.php',icon:'fa-bar-chart'}
];
var si=document.getElementById('searchInput'),sd=document.getElementById('searchDropdown'),ai=-1;
function renderSearch(v){
  v=v.trim().toLowerCase();
  if(!v){sd.style.display='none';return;}
  var m=menuItems.filter(function(x){return x.label.toLowerCase().indexOf(v)>=0;});
  if(!m.length){sd.innerHTML='<div class="sk-search-empty">Tidak ditemukan</div>';sd.style.display='block';return;}
  sd.innerHTML=m.map(function(x){return'<a href="'+x.url+'" class="sk-search-item"><i class="fa '+x.icon+'"></i> '+x.label+'</a>';}).join('');
  sd.style.display='block';ai=-1;
}
si.addEventListener('input',function(){renderSearch(this.value);});
si.addEventListener('keydown',function(e){
  var items=sd.querySelectorAll('.sk-search-item');
  if(e.key==='ArrowDown'){ai=Math.min(ai+1,items.length-1);items.forEach(function(el,i){el.classList.toggle('active',i===ai);});e.preventDefault();}
  else if(e.key==='ArrowUp'){ai=Math.max(ai-1,0);items.forEach(function(el,i){el.classList.toggle('active',i===ai);});e.preventDefault();}
  else if(e.key==='Enter'){if(ai>=0&&items[ai]){window.location.href=items[ai].href;}else if(items.length>0){window.location.href=items[0].href;}}
  else if(e.key==='Escape'){sd.style.display='none';si.blur();}
});
document.addEventListener('click',function(e){if(!document.getElementById('searchWrap').contains(e.target)){sd.style.display='none';}});
// ===== Notifications =====
document.getElementById('notifBtn').addEventListener('click',function(e){
  e.stopPropagation();
  var p=document.getElementById('notifPanel');
  p.style.display=p.style.display==='block'?'none':'block';
});
document.addEventListener('click',function(e){
  var w=document.querySelector('.sk-notif-wrap');
  if(w&&!w.contains(e.target)){var p=document.getElementById('notifPanel');if(p)p.style.display='none';}
});
</script>