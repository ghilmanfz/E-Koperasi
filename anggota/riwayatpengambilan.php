<?php
include ("style/header.php");
include ("style/sidebar.php");
include ("../config/koneksi.php");

function tgl_indo($tanggal) {
    $bulan = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $p = explode('-', $tanggal);
    return $p[2] . ' ' . $bulan[(int)$p[1]] . ' ' . $p[0];
}

// Stats
$res_stats = mysqli_query($konek, "SELECT SUM(a.jumlah_pengambilan) as total, MAX(a.tgl_pengambilan) as last_date, COUNT(*) as cnt FROM tbl_pengambilan a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE b.id = '{$_SESSION['id']}'");
$stats = mysqli_fetch_array($res_stats);
$total_pengambilan = $stats ? (int)$stats['total'] : 0;
$last_date         = ($stats && $stats['last_date']) ? $stats['last_date'] : null;
$frekuensi         = $stats ? (int)$stats['cnt'] : 0;

// All rows
$rows = [];
$res = mysqli_query($konek, "SELECT * FROM tbl_pengambilan a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE b.id = '{$_SESSION['id']}' ORDER BY a.tgl_pengambilan DESC");
while ($r = mysqli_fetch_array($res)) { $rows[] = $r; }
$cnt = count($rows);
?>

<!-- Page Header -->
<div class="ag-page-header">
  <div class="ag-page-header-row">
    <div>
      <div class="ag-page-title">Riwayat Pengambilan</div>
      <div class="ag-page-subtitle">Laporan riwayat transaksi penarikan dana simpanan Anda.</div>
    </div>
    <div>
      <div style="position:relative; display:inline-block;">
        <i class="fa fa-search" style="position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px;"></i>
        <input type="text" placeholder="Cari ID pengambilan..." style="border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 12px 8px 32px; font-size:13px; color:#374151; outline:none; width:220px; font-family:inherit;" disabled>
      </div>
    </div>
  </div>
</div>

<!-- Security Notice -->
<div class="ag-notice">
  <i class="fa fa-lock"></i>
  <div>
    <div class="ag-notice-title">Informasi Keamanan</div>
    <div class="ag-notice-text">Menampilkan data untuk Anda saja. Seluruh data transaksi Anda bersifat rahasia dan terlindungi.</div>
  </div>
</div>

<!-- Stat Cards -->
<div class="ag-stat-grid-3">
  <div class="ag-stat-card blue-light">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Total Pengambilan</div>
      <div class="ag-stat-icon"><i class="fa fa-arrow-circle-down"></i></div>
    </div>
    <div class="ag-stat-value">Rp <?php echo number_format($total_pengambilan, 0, ',', '.'); ?></div>
    <div class="ag-stat-sub">Akumulasi seluruh penarikan dana</div>
  </div>
  <div class="ag-stat-card blue-dark">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Transaksi Terakhir</div>
      <div class="ag-stat-icon"><i class="fa fa-calendar"></i></div>
    </div>
    <div class="ag-stat-value" style="font-size:17px;">
      <?php echo $last_date ? tgl_indo($last_date) : '-'; ?>
    </div>
    <div class="ag-stat-sub">Tanggal terakhir pengambilan dana</div>
  </div>
  <div class="ag-stat-card">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Frekuensi</div>
      <div class="ag-stat-icon"><i class="fa fa-repeat"></i></div>
    </div>
    <div class="ag-stat-value"><?php echo $frekuensi; ?> Kali</div>
    <div class="ag-stat-sub">Total penarikan yang pernah dilakukan</div>
  </div>
</div>

<!-- Table -->
<div class="ag-card">
  <div class="ag-card-header">
    <div class="ag-card-header-left">
      <div class="ag-card-title">Daftar Transaksi</div>
    </div>
    <span class="ag-record-badge"><?php echo $cnt; ?> Records Found</span>
  </div>
  <div class="ag-card-body" style="padding-bottom:0;">
    <div class="ag-table-wrap">
      <table class="ag-table">
        <thead>
          <tr>
            <th>No</th>
            <th>ID Pengambilan</th>
            <th>Tanggal Pengambilan</th>
            <th>Jumlah Pengambilan</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($rows)): ?>
          <tr>
            <td colspan="4" style="text-align:center; padding:24px; color:#94a3b8;">
              <i class="fa fa-inbox" style="font-size:24px; display:block; margin-bottom:8px;"></i>
              Belum ada data pengambilan
            </td>
          </tr>
          <?php else: $no = 1; foreach ($rows as $row): ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><span class="ag-id-link"><?php echo htmlspecialchars($row['id_pengambilan']); ?></span></td>
            <td><?php echo tgl_indo($row['tgl_pengambilan']); ?></td>
            <td class="amt-bold">Rp <?php echo number_format($row['jumlah_pengambilan'], 0, ',', '.'); ?></td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Perlu Bantuan -->
<div class="ag-cta">
  <div class="ag-cta-text">
    <h4>Perlu Bantuan?</h4>
    <p>Jika ada ketidaksesuaian data pengambilan atau Anda memerlukan klarifikasi transaksi, segera hubungi kami.</p>
  </div>
  <a href="#" class="ag-btn ag-btn-outline">Hubungi Admin Koperasi</a>
</div>

<?php include ("style/footer.php"); ?>
