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

$rows        = [];
$total_jumlah = 0;
$total_bunga  = 0;
$bulan_val   = '';
$tahun_val   = '';

$bulan_list = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April',
               '5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus',
               '9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];

if(isset($_POST['cari'])){
    $bulan_val = $_POST['bulan'];
    $tahun_val = $_POST['tahun'];
    $sql = mysqli_query($konek,
        "SELECT * FROM tbl_pinjaman a
         LEFT JOIN tbl_anggota b ON a.id_anggota=b.id_anggota
         WHERE month(a.tgl_pinjaman)='$bulan_val' AND year(a.tgl_pinjaman)='$tahun_val'");
    while($d = mysqli_fetch_assoc($sql)){
        $total_jumlah += $d['jumlah_pinjaman'];
        $total_bunga  += $d['jumlah_pinjaman'] * $d['bunga_perbulan'] / 100;
        $rows[] = $d;
    }
}
$count_pinjaman = count($rows);
$nama_bulan = $bulan_val ? ($bulan_list[$bulan_val] ?? '') : '';
?>

<!-- Page Header -->
<div class="sk-header-row">
  <div>
    <div style="margin-bottom:8px;">
      <span style="display:inline-block;background:#EFF6FF;color:#2563EB;font-size:0.75rem;font-weight:700;padding:3px 12px;border-radius:20px;letter-spacing:0.02em;">Laporan Keuangan</span>
    </div>
    <h1 class="sk-page-title">Laporan Pinjaman</h1>
    <p class="sk-page-subtitle">Kelola dan pantau seluruh data pinjaman anggota koperasi. Gunakan filter untuk melihat data spesifik periode bulanan.</p>
  </div>
  <div class="sk-page-actions">
    <?php if($bulan_val): ?>
    <a href="cetakpinjaman.php?bulan=<?php echo $bulan_val; ?>&tahun=<?php echo $tahun_val; ?>" target="_blank" class="sk-btn sk-btn-outline"><i class="fa fa-print"></i> Cetak</a>
    <?php endif; ?>
  </div>
</div>

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
      <button type="submit" name="cari" class="sk-btn sk-btn-primary"><i class="fa fa-search"></i> Cek Laporan</button>
    </div>
  </form>
</div>

<?php if(isset($_POST['cari'])): ?>

<!-- Data Table -->
<div class="sk-card">
  <div class="sk-card-header">
    <div>
      <h5 class="sk-card-title"><i class="fa fa-filter" style="color:#2563EB"></i>&nbsp; Data Pinjaman Anggota</h5>
      <p style="font-size:0.78rem;color:#94A3B8;margin:3px 0 0 0;">Menampilkan daftar pinjaman aktif periode berjalan</p>
    </div>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead>
        <tr>
          <th>No</th>
          <th>ID Pinjaman</th>
          <th>Tanggal</th>
          <th>ID Anggota</th>
          <th>Nama Anggota</th>
          <th>Bunga / Bln</th>
          <th>Tenor</th>
          <th>Jumlah Pinjaman</th>
          <th>Angsuran / Bln</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; foreach($rows as $data): ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><span class="sk-id-link"><?php echo htmlspecialchars($data['id_pinjaman']); ?></span></td>
          <td><?php echo tgl_indo($data['tgl_pinjaman']); ?></td>
          <td><?php echo htmlspecialchars($data['id_anggota']); ?></td>
          <td class="sk-member-name"><?php echo htmlspecialchars($data['nama_anggota']); ?></td>
          <td class="amt-blue"><?php echo $data['bunga_perbulan']; ?>%</td>
          <td><?php echo $data['lama_cicilan']; ?> Bulan</td>
          <td><?php echo 'Rp '.number_format($data['jumlah_pinjaman'],0,',','.'); ?></td>
          <td class="amt-blue"><?php echo 'Rp '.number_format($data['angsuran'],0,',','.'); ?></td>
          <td><span class="sk-badge aktif">Aktif</span></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Summary Cards -->
<div class="sk-stat-grid" style="grid-template-columns:repeat(3,1fr);margin-top:18px;">
  <div class="sk-stat-card">
    <div>
      <div class="sk-stat-label">Total Pinjaman Aktif</div>
      <div class="sk-stat-value"><?php echo $count_pinjaman; ?> Akun</div>
      <div class="sk-stat-sub">Periode ini</div>
    </div>
    <div class="sk-stat-icon purple"><i class="fa fa-credit-card"></i></div>
  </div>
  <div class="sk-stat-card">
    <div>
      <div class="sk-stat-label">Pencairan Bulan Ini</div>
      <div class="sk-stat-value"><?php echo $count_pinjaman; ?> Baru</div>
      <div class="sk-stat-sub">Rp <?php echo number_format($total_jumlah,0,',','.'); ?></div>
    </div>
    <div class="sk-stat-icon green"><i class="fa fa-money"></i></div>
  </div>
  <div class="sk-stat-card" style="background:linear-gradient(135deg,#EFF6FF,#DBEAFE);border-color:#BFDBFE;">
    <div>
      <div class="sk-stat-label">Estimasi Pendapatan Bunga</div>
      <div class="sk-stat-value amt-blue">Rp <?php echo number_format($total_bunga,0,',','.'); ?></div>
      <div class="sk-stat-sub">Per bulan</div>
    </div>
    <div class="sk-stat-icon blue"><i class="fa fa-line-chart"></i></div>
  </div>
</div>

<?php endif; ?>

<?php include ("style/footer.php"); ?>
