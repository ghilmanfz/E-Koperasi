<?php
include ("style/header.php");
include ("style/sidebar.php");
include ("../config/koneksi.php");
// $sk_settings loaded by sidebar.php
$s = $sk_settings;

// Get member info
$sql_member = mysqli_query($konek, "SELECT a.*, b.username FROM tbl_anggota a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE b.id = '{$_SESSION['id']}'");
$member = mysqli_fetch_array($sql_member);

// Stat counts
$res_tabungan = mysqli_query($konek, "SELECT saldo, saldo_wajib FROM tbl_tabungan a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE b.id = '{$_SESSION['id']}'");
$tab = mysqli_fetch_array($res_tabungan);
$saldo_pokok = $tab ? $tab['saldo'] : 0;
$saldo_wajib = $tab ? $tab['saldo_wajib'] : 0;

$res_pinjaman = mysqli_query($konek, "SELECT COUNT(*) as cnt, SUM(jumlah_pinjaman) as total FROM tbl_pinjaman a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE b.id = '{$_SESSION['id']}' AND a.jumlah_pinjaman > 0");
$pinjaman = mysqli_fetch_array($res_pinjaman);
$total_pinjaman = $pinjaman ? (int)$pinjaman['total'] : 0;

$res_pengambilan = mysqli_query($konek, "SELECT COUNT(*) as cnt FROM tbl_pengambilan a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE b.id = '{$_SESSION['id']}'");
$pengambilan = mysqli_fetch_array($res_pengambilan);
$cnt_pengambilan = $pengambilan ? (int)$pengambilan['cnt'] : 0;
?>

<!-- Hero Banner -->
<div class="ag-hero"<?php if (!empty($s['foto_hero'])): ?> style="background-image: linear-gradient(135deg, rgba(30,64,175,0.88) 0%, rgba(99,102,241,0.80) 100%), url('../<?php echo htmlspecialchars($s['foto_hero']); ?>'); background-size: cover; background-position: center;"<?php endif; ?>>
  <div class="ag-hero-tag"><i class="fa fa-diamond"></i> Panel Anggota</div>
  <h1>Selamat Datang, <?php echo htmlspecialchars($member['nama_anggota'] ?? $_SESSION['username'] ?? 'Anggota'); ?>!</h1>
  <p>Kelola informasi keanggotaan, pantau simpanan, dan lihat riwayat transaksi Anda di <?php echo htmlspecialchars($s['nama_koperasi']); ?>.</p>
</div>

<!-- Stat Grid -->
<div class="ag-stat-grid-2" style="grid-template-columns: repeat(2, 1fr);">
  <div class="ag-stat-card blue-light">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Saldo Simpanan Pokok</div>
      <div class="ag-stat-icon"><i class="fa fa-bank"></i></div>
    </div>
    <div class="ag-stat-value">Rp <?php echo number_format($saldo_pokok, 0, ',', '.'); ?></div>
    <div class="ag-stat-sub">Simpanan wajib saat pertama bergabung</div>
  </div>
  <div class="ag-stat-card blue-dark">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Saldo Simpanan Wajib</div>
      <div class="ag-stat-icon"><i class="fa fa-calendar"></i></div>
    </div>
    <div class="ag-stat-value">Rp <?php echo number_format($saldo_wajib, 0, ',', '.'); ?></div>
    <div class="ag-stat-sub">Akumulasi simpanan bulanan rutin Anda</div>
  </div>
</div>

<div class="ag-stat-grid-2" style="grid-template-columns: repeat(2, 1fr); margin-top: -4px;">
  <div class="ag-stat-card">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Total Pinjaman Aktif</div>
      <div class="ag-stat-icon"><i class="fa fa-money"></i></div>
    </div>
    <div class="ag-stat-value"><?php echo $total_pinjaman > 0 ? 'Rp ' . number_format($total_pinjaman, 0, ',', '.') : 'Tidak Ada'; ?></div>
    <div class="ag-stat-sub">Pinjaman yang sedang berjalan</div>
  </div>
  <div class="ag-stat-card">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Jumlah Pengambilan</div>
      <div class="ag-stat-icon"><i class="fa fa-arrow-circle-down"></i></div>
    </div>
    <div class="ag-stat-value"><?php echo $cnt_pengambilan; ?> Kali</div>
    <div class="ag-stat-sub">Total penarikan dana yang tercatat</div>
  </div>
</div>

<!-- Quick Access -->
<div class="ag-action-grid-3">
  <div class="ag-action-card">
    <div class="ag-action-icon blue"><i class="fa fa-user"></i></div>
    <div class="ag-action-card-title">Profil Saya</div>
    <div class="ag-action-card-text">Lihat dan kelola informasi data pribadi keanggotaan Anda.</div>
    <a href="dataanggota.php" class="ag-action-card-link blue">Lihat Profil &rarr;</a>
  </div>
  <div class="ag-action-card">
    <div class="ag-action-icon green"><i class="fa fa-credit-card"></i></div>
    <div class="ag-action-card-title">Tabungan Saya</div>
    <div class="ag-action-card-text">Pantau total simpanan pokok dan wajib beserta riwayat setoran.</div>
    <a href="datatabungan.php" class="ag-action-card-link green">Lihat Tabungan &rarr;</a>
  </div>
  <div class="ag-action-card">
    <div class="ag-action-icon gray"><i class="fa fa-history"></i></div>
    <div class="ag-action-card-title">Riwayat Transaksi</div>
    <div class="ag-action-card-text">Lihat seluruh riwayat simpanan, pinjaman, angsuran, dan pengambilan.</div>
    <a href="riwayatsimpanan.php" class="ag-action-card-link gray">Lihat Riwayat &rarr;</a>
  </div>
</div>

<!-- CTA -->
<div class="ag-cta">
  <div class="ag-cta-text">
    <h4>Butuh bantuan atau ada pertanyaan?</h4>
    <p>Tim administrasi kami siap membantu Anda setiap hari kerja. Hubungi kami melalui informasi kontak di bawah.</p>
  </div>
  <a href="dataanggota.php" class="ag-btn ag-btn-outline">Hubungi Admin Koperasi</a>
</div>

<?php include ("style/footer.php"); ?>
