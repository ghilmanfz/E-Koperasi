<?php
include ("style/header.php");
include ("style/sidebar.php");
include ("../config/koneksi.php");
// $sk_settings loaded by sidebar.php
$s = $sk_settings;

$syarat_anggota_items  = array_filter(array_map('trim', explode("\n", $s['syarat_anggota'])));
$syarat_pinjaman_items = array_filter(array_map('trim', explode("\n", $s['syarat_pinjaman'])));

$total_anggota  = mysqli_fetch_row(mysqli_query($konek,"SELECT COUNT(*) FROM tbl_anggota"))[0] ?? 0;
$total_tabungan = mysqli_fetch_row(mysqli_query($konek,"SELECT COALESCE(SUM(saldo+saldo_wajib),0) FROM tbl_tabungan"))[0] ?? 0;
$total_simpanan = mysqli_fetch_row(mysqli_query($konek,"SELECT COALESCE(SUM(jumlah_simpanan),0) FROM tbl_simpanan"))[0] ?? 0;
$total_pinjaman = mysqli_fetch_row(mysqli_query($konek,"SELECT COUNT(*) FROM tbl_pinjaman"))[0] ?? 0;
?>

<!-- Hero Banner -->
<div class="sk-hero"<?php if (!empty($s['foto_hero'])): ?> style="background-image: linear-gradient(135deg, rgba(30,64,175,0.88) 0%, rgba(99,102,241,0.80) 100%), url('../<?php echo htmlspecialchars($s['foto_hero']); ?>'); background-size: cover; background-position: center;"<?php endif; ?>>
  <div class="sk-hero-tag">Selamat Datang, Bendahara</div>
  <h1><?php echo htmlspecialchars($s['nama_koperasi']); ?></h1>
  <p><?php echo nl2br(htmlspecialchars($s['deskripsi'])); ?></p>
  <div class="sk-hero-badges">
    <?php if (!empty($s['alamat'])): ?>
    <span class="sk-hero-badge"><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($s['alamat']); ?></span>
    <?php endif; ?>
    <?php if (!empty($s['telepon'])): ?>
    <span class="sk-hero-badge"><i class="fa fa-phone"></i> <?php echo htmlspecialchars($s['telepon']); ?></span>
    <?php endif; ?>
    <?php if (!empty($s['email'])): ?>
    <span class="sk-hero-badge"><i class="fa fa-envelope"></i> <?php echo htmlspecialchars($s['email']); ?></span>
    <?php endif; ?>
  </div>
</div>

<!-- Stat Cards -->
<div class="sk-stat-grid">
  <div class="sk-stat-card">
    <div>
      <div class="sk-stat-label">Total Anggota</div>
      <div class="sk-stat-value"><?php echo number_format($total_anggota); ?></div>
      <div class="sk-stat-sub">Terdaftar aktif</div>
    </div>
    <div class="sk-stat-icon blue"><i class="fa fa-users"></i></div>
  </div>
  <div class="sk-stat-card">
    <div>
      <div class="sk-stat-label">Total Tabungan</div>
      <div class="sk-stat-value">Rp <?php echo number_format($total_tabungan/1000000,1); ?>M</div>
      <div class="sk-stat-sub">Saldo akumulasi</div>
    </div>
    <div class="sk-stat-icon green"><i class="fa fa-bank"></i></div>
  </div>
  <div class="sk-stat-card">
    <div>
      <div class="sk-stat-label">Total Simpanan</div>
      <div class="sk-stat-value">Rp <?php echo number_format($total_simpanan/1000000,1); ?>M</div>
      <div class="sk-stat-sub">Pokok &amp; Wajib</div>
    </div>
    <div class="sk-stat-icon purple"><i class="fa fa-folder-open"></i></div>
  </div>
  <div class="sk-stat-card">
    <div>
      <div class="sk-stat-label">Data Pinjaman</div>
      <div class="sk-stat-value"><?php echo number_format($total_pinjaman); ?></div>
      <div class="sk-stat-sub">Total transaksi</div>
    </div>
    <div class="sk-stat-icon orange"><i class="fa fa-credit-card"></i></div>
  </div>
</div>

<!-- Info Cards -->
<div class="sk-info-grid">
  <div class="sk-info-card">
    <h5 class="sk-info-card-title"><i class="fa fa-check-circle"></i> Syarat &amp; Ketentuan Menjadi Anggota</h5>
    <ul>
      <?php foreach ($syarat_anggota_items as $item): ?>
      <li><?php echo htmlspecialchars($item); ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="sk-info-card">
    <h5 class="sk-info-card-title"><i class="fa fa-check-circle"></i> Syarat-Syarat Mengajukan Pinjaman</h5>
    <ul>
      <?php foreach ($syarat_pinjaman_items as $item): ?>
      <li><?php echo htmlspecialchars($item); ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<!-- CTA -->
<div class="sk-cta">
  <div class="sk-cta-text">
    <h4>Butuh Ringkasan Keuangan?</h4>
    <p>Gunakan menu Laporan Keuangan untuk melihat arus kas dan saldo koperasi secara detail.</p>
  </div>
  <a href="laporankeuangan.php" class="sk-btn sk-btn-primary"><i class="fa fa-bar-chart"></i> Laporan Keuangan</a>
</div>

<?php include ("style/footer.php"); ?>
