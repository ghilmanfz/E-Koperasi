<?php
include ("style/header.php");
include ("style/sidebar.php");
include ("../config/koneksi.php");

function tgl_indo($tanggal) {
    $bulan = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $p = explode('-', $tanggal);
    return $p[2] . ' ' . $bulan[(int)$p[1]] . ' ' . $p[0];
}

// Stats: total terbayar
$res_total = mysqli_query($konek, "SELECT SUM(a.jml_bayar) as total, COUNT(*) as cnt FROM tbl_pembayaran a LEFT JOIN tbl_pinjaman b ON a.id_pinjaman=b.id_pinjaman LEFT JOIN tbl_login c ON b.id_anggota=c.id_anggota WHERE c.id = '{$_SESSION['id']}'");
$stat_total = mysqli_fetch_array($res_total);
$total_terbayar = $stat_total ? (int)$stat_total['total'] : 0;
$cnt_angsuran   = $stat_total ? (int)$stat_total['cnt'] : 0;

// Active loan
$res_loan = mysqli_query($konek, "SELECT a.id_pinjaman, a.lama_cicilan FROM tbl_pinjaman a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE b.id = '{$_SESSION['id']}' AND a.jumlah_pinjaman > 0 ORDER BY a.tgl_pinjaman DESC LIMIT 1");
$active_loan = mysqli_fetch_array($res_loan);

// Count paid installments for active loan
$sisa_angsuran = '-';
$id_pinjaman_aktif = '-';
if ($active_loan) {
    $id_pinjaman_aktif = $active_loan['id_pinjaman'];
    $res_paid = mysqli_query($konek, "SELECT COUNT(*) as cnt FROM tbl_pembayaran WHERE id_pinjaman = '" . mysqli_real_escape_string($konek, $id_pinjaman_aktif) . "'");
    $paid = mysqli_fetch_array($res_paid);
    $sudah_bayar = $paid ? (int)$paid['cnt'] : 0;
    $sisa = (int)$active_loan['lama_cicilan'] - $sudah_bayar;
    $sisa_angsuran = max(0, $sisa) . ' Bulan';
}

// All installment rows
$rows = [];
$res = mysqli_query($konek, "SELECT a.*, b.id_pinjaman as pinjaman_id FROM tbl_pembayaran a LEFT JOIN tbl_pinjaman b ON a.id_pinjaman=b.id_pinjaman LEFT JOIN tbl_login c ON b.id_anggota=c.id_anggota WHERE c.id = '{$_SESSION['id']}' ORDER BY a.tgl_bayar DESC");
while ($r = mysqli_fetch_array($res)) { $rows[] = $r; }
$cnt = count($rows);
?>

<!-- Page Header -->
<div class="ag-page-header">
  <div class="ag-page-title">Riwayat Pembayaran Angsuran</div>
  <div class="ag-page-subtitle"><i class="fa fa-calendar" style="color:#94a3b8;"></i> Laporan aktivitas pembayaran angsuran pinjaman Anda.</div>
</div>

<!-- Security Notice -->
<div class="ag-notice">
  <i class="fa fa-shield"></i>
  <div>
    <div class="ag-notice-title">Keamanan Data Terjamin</div>
    <div class="ag-notice-text">Menampilkan data untuk Anda saja. Informasi ini bersifat pribadi dan rahasia.</div>
  </div>
</div>

<!-- Stat Cards -->
<div class="ag-stat-grid-3">
  <div class="ag-stat-card">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Total Terbayar</div>
      <div class="ag-stat-icon"><i class="fa fa-check-circle"></i></div>
    </div>
    <div class="ag-stat-value">Rp <?php echo number_format($total_terbayar, 0, ',', '.'); ?></div>
    <div class="ag-stat-sub">Total dari <?php echo $cnt_angsuran; ?> angsuran terakhir</div>
  </div>
  <div class="ag-stat-card">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Pinjaman Aktif</div>
      <div class="ag-stat-icon"><i class="fa fa-credit-card"></i></div>
    </div>
    <div class="ag-stat-value" style="font-size:18px;"><?php echo htmlspecialchars($id_pinjaman_aktif); ?></div>
    <div class="ag-stat-sub">ID Pinjaman yang sedang berjalan</div>
  </div>
  <div class="ag-stat-card">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Sisa Angsuran</div>
      <div class="ag-stat-icon"><i class="fa fa-calendar"></i></div>
    </div>
    <div class="ag-stat-value"><?php echo $sisa_angsuran; ?></div>
    <div class="ag-stat-sub">Estimasi waktu pelunasan</div>
  </div>
</div>

<!-- Table -->
<div class="ag-card">
  <div class="ag-card-header">
    <div class="ag-card-header-left">
      <div class="ag-card-title"><i class="fa fa-list-alt" style="color:#2563eb;"></i> Data Angsuran</div>
    </div>
    <span class="ag-record-badge"><?php echo $cnt; ?> Records Found</span>
  </div>
  <div class="ag-card-body" style="padding-bottom:0;">
    <div class="ag-table-wrap">
      <table class="ag-table">
        <thead>
          <tr>
            <th>No</th>
            <th>ID Angsuran</th>
            <th>ID Pinjaman</th>
            <th>Angsuran Ke-</th>
            <th>Jumlah Pembayaran</th>
            <th>Tanggal</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($rows)): ?>
          <tr>
            <td colspan="7" style="text-align:center; padding:24px; color:#94a3b8;">
              <i class="fa fa-inbox" style="font-size:24px; display:block; margin-bottom:8px;"></i>
              Belum ada data angsuran
            </td>
          </tr>
          <?php else: $no = 1; foreach ($rows as $row): ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><span class="ag-id-link"><?php echo htmlspecialchars($row['id_angsuran']); ?></span></td>
            <td><?php echo htmlspecialchars($row['id_pinjaman']); ?></td>
            <td><?php echo htmlspecialchars($row['cicilan']); ?></td>
            <td class="amt-bold">Rp <?php echo number_format($row['jml_bayar'], 0, ',', '.'); ?></td>
            <td><?php echo tgl_indo($row['tgl_bayar']); ?></td>
            <td><span class="ag-badge ag-badge-lunas">Lunas</span></td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Informasi Penting -->
<div class="ag-card">
  <div class="ag-card-body">
    <div class="ag-info-section-title" style="margin-bottom:12px;"><i class="fa fa-info-circle"></i> Informasi Penting</div>
    <ul class="ag-info-list">
      <li>Pastikan Anda membayar angsuran tepat waktu sesuai tanggal jatuh tempo untuk menghindari denda administratif.</li>
      <li>Bukti pembayaran resmi dapat dicetak melalui menu detail angsuran (Klik pada ID Angsuran).</li>
      <li>Jika terdapat perbedaan data, silakan hubungi pengurus Koperasi PKK Karya Sejahtera melalui nomor telepon di footer.</li>
    </ul>
  </div>
</div>

<?php include ("style/footer.php"); ?>
