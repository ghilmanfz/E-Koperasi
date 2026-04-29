<?php
include ("style/header.php");
include ("style/sidebar.php");
include ("../config/koneksi.php");

function tgl_indo($tanggal) {
    $bulan = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $p = explode('-', $tanggal);
    return $p[2] . ' ' . $bulan[(int)$p[1]] . ' ' . $p[0];
}

// Tabungan stats
$res_tab = mysqli_query($konek, "SELECT a.saldo, a.saldo_wajib FROM tbl_tabungan a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE b.id = '{$_SESSION['id']}'");
$tab = mysqli_fetch_array($res_tab);
$saldo_pokok = $tab ? (int)$tab['saldo'] : 0;
$saldo_wajib = $tab ? (int)$tab['saldo_wajib'] : 0;
$total_akumulasi = $saldo_pokok + $saldo_wajib;

// Member status
$res_member = mysqli_query($konek, "SELECT a.status, a.nama_anggota FROM tbl_anggota a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE b.id = '{$_SESSION['id']}'");
$member = mysqli_fetch_array($res_member);

// Simpanan rows
$rows = [];
$res = mysqli_query($konek, "SELECT * FROM tbl_simpanan a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE b.id = '{$_SESSION['id']}' ORDER BY a.tgl_simpanan DESC");
while ($r = mysqli_fetch_array($res)) { $rows[] = $r; }
$cnt = count($rows);
?>

<!-- Page Header -->
<div class="ag-page-header">
  <div class="ag-page-header-row">
    <div>
      <div style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:6px;">Panel Anggota</div>
      <div class="ag-page-title">Riwayat Simpanan</div>
      <div class="ag-page-subtitle">Kelola dan pantau seluruh transaksi tabungan Anda di Koperasi PKK Karya Sejahtera.</div>
    </div>
    <div>
      <span class="ag-page-badge"><i class="fa fa-shield"></i> Status Keanggotaan: Aktif &amp; Terverifikasi</span>
    </div>
  </div>
</div>

<!-- Security Notice -->
<div class="ag-notice">
  <i class="fa fa-lock"></i>
  <div>
    <div class="ag-notice-title">Keamanan Data Terjamin</div>
    <div class="ag-notice-text">Menampilkan data untuk Anda saja. Informasi finansial Anda bersifat rahasia dan terlindungi.</div>
  </div>
</div>

<!-- Stat Cards -->
<div class="ag-stat-grid-3">
  <div class="ag-stat-card blue-light">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Saldo Pokok</div>
      <div class="ag-stat-icon"><i class="fa fa-bank"></i></div>
    </div>
    <div class="ag-stat-value">Rp <?php echo number_format($saldo_pokok, 0, ',', '.'); ?></div>
    <div class="ag-stat-sub">Simpanan wajib awal anggota</div>
  </div>
  <div class="ag-stat-card blue-dark">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Saldo Wajib</div>
      <div class="ag-stat-icon"><i class="fa fa-plus-circle"></i></div>
    </div>
    <div class="ag-stat-value">Rp <?php echo number_format($saldo_wajib, 0, ',', '.'); ?></div>
    <div class="ag-stat-sub">Iuran bulanan rutin Anda</div>
  </div>
  <div class="ag-stat-card">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Total Akumulasi</div>
      <div class="ag-stat-icon"><i class="fa fa-calculator"></i></div>
    </div>
    <div class="ag-stat-value">Rp <?php echo number_format($total_akumulasi, 0, ',', '.'); ?></div>
    <div class="ag-stat-sub">Pembaruan terakhir hari ini &nbsp;<a href="#" style="color:#2563eb; font-size:11.5px; font-weight:600; text-decoration:none;">Detail Aset &rsaquo;</a></div>
  </div>
</div>

<!-- Table Section -->
<div style="font-size:16px; font-weight:700; color:#1a2332; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
  <span style="width:4px; height:18px; background:#2563eb; border-radius:2px; display:inline-block;"></span>
  Data Transaksi Terkini
</div>

<div class="ag-card">
  <div class="ag-card-header">
    <div class="ag-card-header-left">
      <div class="ag-card-title">Daftar Transaksi Simpanan</div>
    </div>
    <span class="ag-record-badge"><?php echo $cnt; ?> Transaksi Terdaftar</span>
  </div>
  <div class="ag-card-body" style="padding-bottom:0;">
    <div class="ag-table-wrap">
      <table class="ag-table">
        <thead>
          <tr>
            <th>No</th>
            <th>ID Simpanan</th>
            <th>Tanggal Simpanan</th>
            <th>Jenis Simpanan</th>
            <th>Jumlah Simpanan</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($rows)): ?>
          <tr>
            <td colspan="5" style="text-align:center; padding:24px; color:#94a3b8;">
              <i class="fa fa-inbox" style="font-size:24px; display:block; margin-bottom:8px;"></i>
              Belum ada data simpanan
            </td>
          </tr>
          <?php else: $no = 1; foreach ($rows as $row): ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><span class="ag-id-link"><?php echo htmlspecialchars($row['id_simpanan']); ?></span></td>
            <td><?php echo tgl_indo($row['tgl_simpanan']); ?></td>
            <td>
              <?php
              $jenis = strtolower($row['jenis_simpanan']);
              if (strpos($jenis, 'wajib') !== false) echo '<span class="ag-badge ag-badge-wajib">Wajib</span>';
              elseif (strpos($jenis, 'pokok') !== false) echo '<span class="ag-badge ag-badge-pokok">Pokok</span>';
              elseif (strpos($jenis, 'sukarela') !== false) echo '<span class="ag-badge ag-badge-sukarela">Sukarela</span>';
              else echo htmlspecialchars($row['jenis_simpanan']);
              ?>
            </td>
            <td class="amt-bold">Rp <?php echo number_format($row['jumlah_simpanan'], 0, ',', '.'); ?></td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Bottom Info Grid -->
<div class="ag-bottom-info-grid">
  <div class="ag-card" style="margin-bottom:0;">
    <div class="ag-card-body">
      <div class="ag-info-section-title" style="margin-bottom:10px;"><i class="fa fa-info-circle"></i> Informasi Penting</div>
      <ul class="ag-info-list">
        <li>Simpanan Pokok tidak dapat diambil selama masih menjadi anggota aktif.</li>
        <li>Simpanan Wajib dibayarkan setiap bulan sesuai ketentuan Rapat Anggota Tahunan.</li>
        <li>Setoran Simpanan Sukarela dapat dilakukan kapan saja melalui bendahara koperasi.</li>
      </ul>
    </div>
  </div>
  <div class="ag-card" style="margin-bottom:0;">
    <div class="ag-card-body" style="text-align:center;">
      <div class="ag-info-section-title" style="justify-content:center; margin-bottom:8px;"><i class="fa fa-headphones"></i> Butuh Bantuan?</div>
      <p style="font-size:13px; color:#64748b; margin-bottom:16px;">Jika terdapat ketidaksesuaian data transaksi, silakan hubungi pengurus atau admin koperasi melalui tombol di bawah ini.</p>
      <a href="#" class="ag-btn ag-btn-primary" style="width:100%; justify-content:center;">Hubungi Admin</a>
    </div>
  </div>
</div>

<?php include ("style/footer.php"); ?>
