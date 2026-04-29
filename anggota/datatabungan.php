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

// Riwayat simpanan
$rows = [];
$res_simpanan = mysqli_query($konek, "SELECT a.* FROM tbl_simpanan a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE b.id = '{$_SESSION['id']}' ORDER BY a.tgl_simpanan DESC");
while ($r = mysqli_fetch_array($res_simpanan)) { $rows[] = $r; }
$cnt = count($rows);
?>

<!-- Page Header -->
<div class="ag-page-header">
  <div class="ag-page-header-row">
    <div>
      <div class="ag-page-title">Tabungan Saya</div>
      <div class="ag-page-subtitle">Kelola dan pantau seluruh simpanan Anda di Koperasi PKK Karya Sejahtera.</div>
    </div>
    <div class="ag-page-actions">
      <a href="#" class="ag-btn ag-btn-light"><i class="fa fa-filter"></i> Filter</a>
      <a href="#" class="ag-btn ag-btn-primary"><i class="fa fa-print"></i> Cetak Laporan</a>
    </div>
  </div>
</div>

<!-- Stat Cards: Saldo Pokok + Wajib -->
<div class="ag-stat-grid-2">
  <div class="ag-stat-card blue-light">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Total Simpanan Pokok</div>
      <div class="ag-stat-icon"><i class="fa fa-bank"></i></div>
    </div>
    <div class="ag-stat-value">Rp <?php echo number_format($saldo_pokok, 0, ',', '.'); ?></div>
    <div class="ag-stat-sub">Simpanan wajib saat pertama bergabung.</div>
  </div>
  <div class="ag-stat-card blue-dark">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Total Simpanan Wajib</div>
      <div class="ag-stat-icon"><i class="fa fa-calendar"></i></div>
    </div>
    <div class="ag-stat-value">Rp <?php echo number_format($saldo_wajib, 0, ',', '.'); ?></div>
    <div class="ag-stat-sub">Akumulasi simpanan bulanan rutin Anda.</div>
  </div>
</div>

<!-- Riwayat Simpanan Table -->
<div class="ag-card">
  <div class="ag-card-header">
    <div class="ag-card-header-left">
      <div class="ag-card-title">Riwayat Simpanan</div>
      <div class="ag-card-subtitle">Daftar lengkap setoran simpanan yang telah tercatat.</div>
    </div>
    <a href="riwayatsimpanan.php" style="font-size:13px; color:#2563eb; font-weight:600; text-decoration:none;">Lihat Semua</a>
  </div>
  <div class="ag-card-body" style="padding-bottom:0;">
    <div class="ag-table-wrap">
      <table class="ag-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal Transaksi</th>
            <th>Jenis Simpanan</th>
            <th>Jumlah Setoran</th>
            <th>Status</th>
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
            <td><i class="fa fa-calendar-o" style="color:#94a3b8; margin-right:5px;"></i><?php echo tgl_indo($row['tgl_simpanan']); ?></td>
            <td>
              <?php
              $jenis = strtolower($row['jenis_simpanan']);
              if (strpos($jenis, 'wajib') !== false) echo '<span class="ag-badge ag-badge-wajib">Simpanan Wajib</span>';
              elseif (strpos($jenis, 'pokok') !== false) echo '<span class="ag-badge ag-badge-pokok">Simpanan Pokok</span>';
              elseif (strpos($jenis, 'sukarela') !== false) echo '<span class="ag-badge ag-badge-sukarela">Sukarela</span>';
              else echo htmlspecialchars($row['jenis_simpanan']);
              ?>
            </td>
            <td class="amt-blue">Rp <?php echo number_format($row['jumlah_simpanan'], 0, ',', '.'); ?></td>
            <td><span class="ag-badge ag-badge-aktif"><i class="fa fa-check-circle"></i> Berhasil</span></td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
    <?php if ($cnt > 0): ?>
    <div class="ag-table-footer">
      <span>Menampilkan <?php echo $cnt; ?> transaksi</span>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- Bottom Action Cards -->
<div class="ag-action-grid-3">
  <div class="ag-action-card">
    <div class="ag-action-icon blue"><i class="fa fa-download"></i></div>
    <div class="ag-action-card-title">Unduh Rekap Tahunan</div>
    <div class="ag-action-card-text">Dapatkan dokumen PDF rekap simpanan tahun ini.</div>
    <a href="#" class="ag-action-card-link blue">Unduh PDF</a>
  </div>
  <div class="ag-action-card">
    <div class="ag-action-icon green"><i class="fa fa-line-chart"></i></div>
    <div class="ag-action-card-title">Detail Simpanan</div>
    <div class="ag-action-card-text">Lihat rincian lengkap seluruh transaksi simpanan Anda.</div>
    <a href="riwayatsimpanan.php" class="ag-action-card-link green">Lihat Detail</a>
  </div>
  <div class="ag-action-card">
    <div class="ag-action-icon gray"><i class="fa fa-info-circle"></i></div>
    <div class="ag-action-card-title">Butuh Bantuan?</div>
    <div class="ag-action-card-text">Hubungi pengurus jika ada ketidaksesuaian data simpanan.</div>
    <a href="#" class="ag-action-card-link gray">Hubungi Admin</a>
  </div>
</div>

<?php include ("style/footer.php"); ?>
