<?php
include ("style/header.php");
include ("style/sidebar.php");
include ("../config/koneksi.php");

function tgl_indo($tanggal) {
    $bulan = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $p = explode('-', $tanggal);
    return $p[2] . ' ' . $bulan[(int)$p[1]] . ' ' . $p[0];
}

// All pinjaman rows
$rows = [];
$res = mysqli_query($konek, "SELECT a.* FROM tbl_pinjaman a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE b.id = '{$_SESSION['id']}' ORDER BY a.tgl_pinjaman DESC");
while ($r = mysqli_fetch_array($res)) { $rows[] = $r; }
$cnt = count($rows);

// Stats: total pinjaman aktif, tenor, bunga
$total_aktif = 0;
$max_tenor    = 0;
$bunga_aktif  = '-';
foreach ($rows as $r) {
    if ((int)$r['jumlah_pinjaman'] > 0) {
        $total_aktif += (int)$r['jumlah_pinjaman'];
        if ((int)$r['lama_cicilan'] > $max_tenor) $max_tenor = (int)$r['lama_cicilan'];
        if ($bunga_aktif === '-') $bunga_aktif = $r['bunga_perbulan'];
    }
}
?>

<!-- Page Header -->
<div class="ag-page-header">
  <div class="ag-page-header-row">
    <div>
      <div class="ag-page-title">Riwayat Pinjaman Saya</div>
      <div class="ag-page-subtitle">
        <span style="display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; color:#2563eb; background:#eff6ff; border:1px solid #bfdbfe; border-radius:20px; padding:3px 10px;">
          <i class="fa fa-info-circle"></i> Menampilkan pinjaman Anda saja
        </span>
      </div>
    </div>
  </div>
</div>

<!-- Stat Cards -->
<div class="ag-stat-grid-3">
  <div class="ag-stat-card blue-light">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Total Pinjaman Aktif</div>
      <div class="ag-stat-icon"><i class="fa fa-money"></i></div>
    </div>
    <div class="ag-stat-value">
      <?php echo $total_aktif > 0 ? 'Rp ' . number_format($total_aktif, 0, ',', '.') : 'Tidak Ada'; ?>
    </div>
    <div class="ag-stat-sub">Sisa pokok pinjaman yang belum dilunasi</div>
  </div>
  <div class="ag-stat-card blue-dark">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Tenor Berjalan</div>
      <div class="ag-stat-icon"><i class="fa fa-calendar"></i></div>
    </div>
    <div class="ag-stat-value"><?php echo $max_tenor > 0 ? $max_tenor . ' Bulan' : '-'; ?></div>
    <div class="ag-stat-sub">Durasi cicilan pinjaman aktif</div>
  </div>
  <div class="ag-stat-card">
    <div class="ag-stat-head">
      <div class="ag-stat-label">Suku Bunga</div>
      <div class="ag-stat-icon"><i class="fa fa-percent"></i></div>
    </div>
    <div class="ag-stat-value"><?php echo ($bunga_aktif !== '-') ? $bunga_aktif . '% / Bulan' : '-'; ?></div>
    <div class="ag-stat-sub">Bunga pinjaman aktif saat ini</div>
  </div>
</div>

<!-- Table -->
<div class="ag-card">
  <div class="ag-card-header">
    <div class="ag-card-header-left">
      <div class="ag-card-title">Daftar Pinjaman</div>
    </div>
    <span class="ag-record-badge"><?php echo $cnt; ?> Records Found</span>
  </div>
  <div class="ag-card-body" style="padding-bottom:0;">
    <div class="ag-table-wrap">
      <table class="ag-table">
        <thead>
          <tr>
            <th>No</th>
            <th>ID Pinjaman</th>
            <th>Tanggal Pinjaman</th>
            <th>Bunga/Bln (%)</th>
            <th>Lama Cicilan</th>
            <th>Jumlah Pinjaman</th>
            <th>Angsuran/Bln</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($rows)): ?>
          <tr>
            <td colspan="8" style="text-align:center; padding:24px; color:#94a3b8;">
              <i class="fa fa-inbox" style="font-size:24px; display:block; margin-bottom:8px;"></i>
              Belum ada data pinjaman
            </td>
          </tr>
          <?php else: $no = 1; foreach ($rows as $row): ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><span class="ag-id-link"><?php echo htmlspecialchars($row['id_pinjaman']); ?></span></td>
            <td><?php echo tgl_indo($row['tgl_pinjaman']); ?></td>
            <td><?php echo htmlspecialchars($row['bunga_perbulan']); ?>%</td>
            <td><?php echo htmlspecialchars($row['lama_cicilan']); ?> Bulan</td>
            <td class="amt-bold">Rp <?php echo number_format($row['jumlah_pinjaman'], 0, ',', '.'); ?></td>
            <td>Rp <?php echo number_format($row['angsuran'], 0, ',', '.'); ?></td>
            <td>
              <?php if ((int)$row['jumlah_pinjaman'] <= 0): ?>
                <span class="ag-badge ag-badge-lunas">Lunas</span>
              <?php else: ?>
                <span class="ag-badge ag-badge-aktif-loan">Aktif</span>
              <?php endif; ?>
            </td>
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
    <div class="ag-info-section-title" style="margin-bottom:12px;"><i class="fa fa-info-circle"></i> Informasi Penting Pinjaman</div>
    <ul class="ag-info-list">
      <li>Setiap pinjaman dikenakan bunga flat sesuai persentase yang tertera pada tabel. Silakan konfirmasi detail ke bendahara.</li>
      <li>Pelunasan pinjaman sebelum jatuh tempo dapat dilakukan langsung ke kas Koperasi PKK Karya Sejahtera.</li>
      <li>Untuk mengajukan pinjaman baru, hubungi sekretaris atau bendahara koperasi pada jam kerja.</li>
    </ul>
  </div>
</div>

<?php include ("style/footer.php"); ?>
