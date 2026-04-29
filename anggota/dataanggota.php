<?php
include ("style/header.php");
include ("style/sidebar.php");
include ("../config/koneksi.php");

function tgl_indo($tanggal) {
    $bulan = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $p = explode('-', $tanggal);
    return $p[2] . ' ' . $bulan[(int)$p[1]] . ' ' . $p[0];
}

$sql = mysqli_query($konek, "SELECT a.*, b.username FROM tbl_anggota a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE b.id = '{$_SESSION['id']}'");
$data = mysqli_fetch_array($sql);
?>

<!-- Profile Hero -->
<div class="ag-profile-hero">
  <div class="ag-avatar-wrap">
    <img src="../assets/dist/img/his.jpg" alt="Avatar" class="ag-avatar-img">
    <span class="ag-avatar-online"></span>
  </div>
  <div class="ag-profile-details">
    <div style="display:flex; align-items:center; gap:10px; margin-bottom:6px;">
      <div class="ag-profile-name"><?php echo htmlspecialchars($data['nama_anggota'] ?? '-'); ?></div>
      <span class="ag-badge ag-badge-aktif"><i class="fa fa-check-circle"></i> Anggota Aktif</span>
    </div>
    <div class="ag-profile-meta">
      <i class="fa fa-id-card"></i>
      NIK: <?php echo htmlspecialchars($data['nik'] ?? '-'); ?>
    </div>
    <div class="ag-profile-actions">
      <a href="editanggota.php?kd=<?php echo htmlspecialchars($data['id_anggota'] ?? ''); ?>" class="ag-btn ag-btn-primary">
        <i class="fa fa-pencil"></i> Ajukan Perubahan Data
      </a>
      <a href="riwayatsimpanan.php" class="ag-btn ag-btn-light">
        <i class="fa fa-history"></i> Riwayat Keanggotaan
      </a>
    </div>
  </div>
</div>

<!-- Info Grid -->
<div class="ag-info-grid-2">
  <!-- Informasi Pribadi -->
  <div>
    <div class="ag-card">
      <div class="ag-card-body">
        <div class="ag-info-section-title"><i class="fa fa-user"></i> Informasi Pribadi</div>
        <div class="ag-info-section-sub">Detail identitas resmi sesuai KTP</div>
        <div class="ag-field-grid-2">
          <div class="ag-field-group">
            <div class="ag-field-label"><i class="fa fa-map-marker"></i> Tempat Lahir</div>
            <div class="ag-field-value"><?php echo htmlspecialchars($data['tempat_lahir'] ?? '-'); ?></div>
          </div>
          <div class="ag-field-group">
            <div class="ag-field-label"><i class="fa fa-calendar"></i> Tanggal Lahir</div>
            <div class="ag-field-value"><?php echo $data['tanggal_lahir'] ? tgl_indo($data['tanggal_lahir']) : '-'; ?></div>
          </div>
          <div class="ag-field-group">
            <div class="ag-field-label"><i class="fa fa-venus-mars"></i> Jenis Kelamin</div>
            <div class="ag-field-value"><?php echo htmlspecialchars($data['gender'] ?? '-'); ?></div>
          </div>
          <div class="ag-field-group">
            <div class="ag-field-label"><i class="fa fa-briefcase"></i> Pekerjaan</div>
            <div class="ag-field-value"><?php echo htmlspecialchars($data['pekerjaan'] ?? '-'); ?></div>
          </div>
          <div class="ag-field-group ag-field-wide">
            <div class="ag-field-label"><i class="fa fa-home"></i> Alamat Lengkap</div>
            <div class="ag-field-value"><?php echo htmlspecialchars($data['alamat'] ?? '-'); ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Right Column -->
  <div>
    <!-- Detail Keanggotaan -->
    <div class="ag-card">
      <div class="ag-card-body">
        <div class="ag-info-section-title"><i class="fa fa-shield"></i> Detail Keanggotaan</div>
        <div style="height:8px;"></div>
        <div class="ag-membership-cols">
          <div>
            <div class="ag-field-label">Status</div>
            <div class="ag-field-value"><?php echo htmlspecialchars($data['status'] ?? '-'); ?></div>
          </div>
          <div>
            <div class="ag-field-label">Tanggal Bergabung</div>
            <div class="ag-field-value"><?php echo $data['tanggal_masuk'] ? tgl_indo($data['tanggal_masuk']) : '-'; ?></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Informasi Kontak -->
    <div class="ag-card">
      <div class="ag-card-body">
        <div class="ag-info-section-title"><i class="fa fa-envelope"></i> Informasi Kontak</div>
        <div style="height:10px;"></div>
        <div class="ag-field-label">Username / ID Masuk</div>
        <div class="ag-field-value" style="margin-bottom:10px;"><?php echo htmlspecialchars($data['username'] ?? '-'); ?></div>
        <div class="ag-notice" style="margin-bottom:0;">
          <i class="fa fa-info-circle"></i>
          <div class="ag-notice-text">Username ini digunakan untuk masuk ke sistem. Hubungi admin untuk perubahan.</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CTA -->
<div class="ag-cta">
  <div class="ag-cta-text">
    <h4>Butuh bantuan terkait data Anda?</h4>
    <p>Tim administrasi kami siap membantu validasi data Anda setiap hari kerja.</p>
  </div>
  <span class="ag-btn ag-btn-outline">Hubungi Admin Koperasi</span>
</div>

<?php include ("style/footer.php"); ?>
