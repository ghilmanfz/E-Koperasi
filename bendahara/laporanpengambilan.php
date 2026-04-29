<?php
include ("style/header.php");
include ("style/sidebar.php");
include ("../config/koneksi.php");

function tgl_indo($tanggal){
    $bulan = array(
        1=>'Januari','Februari','Maret','April','Mei','Juni',
        'Juli','Agustus','September','Oktober','November','Desember');
    $p = explode('-', $tanggal);
    return $p[2].' '.$bulan[(int)$p[1]].' '.$p[0];
}

$rows             = [];
$total_pengambilan = 0;
$bulan_val        = '';
$tahun_val        = '';

$bulan_list = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April',
               '5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus',
               '9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];

if(isset($_POST['cari'])){
    $bulan_val = $_POST['bulan'];
    $tahun_val = $_POST['tahun'];
    $sql = mysqli_query($konek,
        "SELECT * FROM tbl_pengambilan a
         LEFT JOIN tbl_anggota b ON a.id_anggota=b.id_anggota
         WHERE month(a.tgl_pengambilan)='$bulan_val' AND year(a.tgl_pengambilan)='$tahun_val'");
    while($d = mysqli_fetch_assoc($sql)){
        $total_pengambilan += $d['jumlah_pengambilan'];
        $rows[] = $d;
    }
}
$count_transaksi = count($rows);
$nama_bulan = $bulan_val ? ($bulan_list[$bulan_val] ?? '') : '';
?>

<!-- Page Header -->
<div class="sk-header-row" style="align-items:flex-start;">
  <div style="display:flex;align-items:center;gap:14px;">
    <div style="width:44px;height:44px;background:#FEF2F2;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
      <i class="fa fa-money" style="color:#DC2626;font-size:1.1rem;"></i>
    </div>
    <div>
      <h1 class="sk-page-title" style="margin-bottom:4px;">Laporan Pengambilan Simpanan</h1>
      <p class="sk-page-subtitle">Halaman ini menampilkan log transaksi penarikan dana oleh anggota koperasi. Pantau arus kas keluar dan verifikasi transaksi dengan mudah.</p>
    </div>
  </div>
</div>

<?php if($bulan_val): ?>
<!-- Summary Stats -->
<div class="sk-stat-grid" style="grid-template-columns:repeat(3,1fr);margin-bottom:18px;">
  <div class="sk-stat-card">
    <div>
      <div class="sk-stat-label">Total Pengambilan</div>
      <div class="sk-stat-value amt-red" style="font-size:1.25rem;">Rp <?php echo number_format($total_pengambilan,0,',','.'); ?></div>
      <div class="sk-stat-sub"><i class="fa fa-arrow-down" style="color:#DC2626;"></i> Total dana keluar bulan ini</div>
    </div>
    <div class="sk-stat-icon red"><i class="fa fa-arrow-circle-down"></i></div>
  </div>
  <div class="sk-stat-card">
    <div>
      <div class="sk-stat-label">Jumlah Transaksi</div>
      <div class="sk-stat-value"><?php echo $count_transaksi; ?> Transaksi</div>
      <div class="sk-stat-sub"><i class="fa fa-calendar" style="color:#94A3B8;"></i> Periode: <?php echo $nama_bulan.' '.$tahun_val; ?></div>
    </div>
    <div class="sk-stat-icon teal"><i class="fa fa-calendar"></i></div>
  </div>
  <div class="sk-stat-card" style="background:#F8FAFC;">
    <div>
      <div class="sk-stat-label" style="font-size:0.65rem;letter-spacing:0.1em;">MODUL PENARIKAN DANA KOPERASI</div>
      <div class="sk-stat-value" style="font-size:0.95rem;color:#64748B;font-weight:600;">Terverifikasi</div>
    </div>
    <div class="sk-stat-icon blue"><i class="fa fa-shield"></i></div>
  </div>
</div>
<?php endif; ?>

<!-- Filter Card -->
<div class="sk-filter-card">
  <form action="" method="post" style="width:100%;">
    <div style="display:flex;gap:20px;align-items:flex-end;flex-wrap:wrap;">
      <div style="display:flex;flex-direction:column;gap:5px;">
        <label class="sk-filter-label">PILIH BULAN</label>
        <select name="bulan" class="sk-filter-select">
          <option value="">Pilih Bulan</option>
          <?php foreach($bulan_list as $v=>$n): ?>
          <option value="<?php echo $v; ?>" <?php echo ($bulan_val==$v)?'selected':''; ?>><?php echo $n; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div style="display:flex;flex-direction:column;gap:5px;">
        <label class="sk-filter-label">PILIH TAHUN</label>
        <select name="tahun" class="sk-filter-select">
          <option value="">Pilih Tahun</option>
          <?php for($y=2018;$y<=2026;$y++): ?>
          <option value="<?php echo $y; ?>" <?php echo ($tahun_val==$y)?'selected':''; ?>><?php echo $y; ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <button type="submit" name="cari" class="sk-btn sk-btn-primary"><i class="fa fa-search"></i> Check Laporan</button>
      <?php if($bulan_val): ?>
      <a href="cetakpengambilan.php?bulan=<?php echo $bulan_val; ?>&tahun=<?php echo $tahun_val; ?>" target="_blank" class="sk-btn sk-btn-outline"><i class="fa fa-print"></i> Cetak</a>
      <?php endif; ?>
    </div>
  </form>
</div>

<?php if(isset($_POST['cari'])): ?>

<!-- Table Card -->
<div class="sk-card">
  <div class="sk-card-header">
    <div style="display:flex;align-items:center;gap:10px;">
      <i class="fa fa-list" style="color:#2563EB;font-size:0.9rem;"></i>
      <h5 class="sk-card-title" style="text-transform:uppercase;letter-spacing:0.05em;font-size:0.82rem;">Daftar Transaksi Penarikan</h5>
    </div>
    <span style="background:#2563EB;color:white;font-size:0.68rem;font-weight:700;border-radius:6px;padding:3px 10px;letter-spacing:0.08em;">
      <?php echo strtoupper($nama_bulan).' '.$tahun_val; ?>
    </span>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead>
        <tr>
          <th>No</th>
          <th>ID Pengambilan</th>
          <th>Tanggal</th>
          <th>ID Anggota</th>
          <th>Nama Anggota</th>
          <th>Jumlah (Rp)</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach($rows as $data): ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><span class="sk-id-link"><?php echo htmlspecialchars($data['id_pengambilan']); ?></span></td>
          <td><?php echo tgl_indo($data['tgl_pengambilan']); ?></td>
          <td><?php echo htmlspecialchars($data['id_anggota']); ?></td>
          <td class="sk-member-name"><?php echo htmlspecialchars($data['nama_anggota']); ?></td>
          <td class="amt-red" style="font-weight:700;"><?php echo number_format($data['jumlah_pengambilan'],0,',','.'); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr class="sk-total-row">
          <td colspan="5" style="text-align:right;font-weight:700;font-size:0.875rem;">Total Pengambilan Bulan Ini</td>
          <td class="amt-red" style="font-weight:800;font-size:1rem;">Rp <?php echo number_format($total_pengambilan,0,',','.'); ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Info Notice -->
<div class="sk-notice" style="margin-bottom:20px;">
  <i class="fa fa-info-circle" style="color:#2563EB;font-size:1rem;flex-shrink:0;margin-top:1px;"></i>
  <div>
    <strong style="color:#1E293B;font-size:0.85rem;">Informasi Laporan</strong>
    <p style="margin:3px 0 0 0;font-size:0.83rem;color:#64748B;">Laporan ini dihasilkan secara otomatis oleh sistem. Jika terdapat ketidaksesuaian data fisik dengan data digital, silakan hubungi administrator koperasi.</p>
  </div>
</div>

<?php endif; ?>

<?php include ("style/footer.php"); ?>
