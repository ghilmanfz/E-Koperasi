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

$yr               = (int)date('Y');
$rows             = [];
$total_pengambilan = 0;
$bulan_val        = '';
$tahun_val        = '';
$dari_val         = date('Y-m-01');
$sampai_val       = date('Y-m-d');

$bulan_list = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April',
               '5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus',
               '9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];

$mode = (isset($_POST['filter_mode']) && $_POST['filter_mode']==='rentang') ? 'rentang' : 'bulanan';

if(isset($_POST['cari'])){
    if($mode === 'rentang'){
        $dari_val   = date('Y-m-d', strtotime($_POST['tgl_dari'] ?? $dari_val));
        $sampai_val = date('Y-m-d', strtotime($_POST['tgl_sampai'] ?? $sampai_val));
        $where = "tgl_pengambilan BETWEEN '$dari_val' AND '$sampai_val'";
        $label = tgl_indo($dari_val).' s/d '.tgl_indo($sampai_val);
    } else {
        $bulan_val  = $_POST['bulan'];
        $tahun_val  = $_POST['tahun'];
        $where = "month(a.tgl_pengambilan)='$bulan_val' AND year(a.tgl_pengambilan)='$tahun_val'";
        $bname = $bulan_val ? ($bulan_list[$bulan_val] ?? '') : '';
        $label = trim("$bname $tahun_val");
    }
    $sql = mysqli_query($konek,
        "SELECT * FROM tbl_pengambilan a
         LEFT JOIN tbl_anggota b ON a.id_anggota=b.id_anggota
         WHERE $where");
    while($d = mysqli_fetch_assoc($sql)){
        $total_pengambilan += $d['jumlah_pengambilan'];
        $rows[] = $d;
    }
    $nm=['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $cl=[]; $cd=[];
    if($mode==='rentang'){
        $cq_sql = "SELECT DATE_FORMAT(tgl_pengambilan,'%Y-%m') as ym,SUM(jumlah_pengambilan) as tot FROM tbl_pengambilan WHERE tgl_pengambilan BETWEEN '$dari_val' AND '$sampai_val' GROUP BY ym ORDER BY ym";
        $cq=mysqli_query($konek,$cq_sql);
        while($cr=mysqli_fetch_assoc($cq)){$cl[]=$cr['ym'];$cd[]=(int)$cr['tot'];}
    } else {
        $cl=array_slice($nm,1); $cd=array_fill(0,12,0);
        $cq_sql = "SELECT MONTH(tgl_pengambilan) as m,SUM(jumlah_pengambilan) as tot FROM tbl_pengambilan WHERE YEAR(tgl_pengambilan)=$tahun_val GROUP BY m ORDER BY m";
        $cq=mysqli_query($konek,$cq_sql);
        while($cr=mysqli_fetch_assoc($cq)){$cd[(int)$cr['m']-1]=(int)$cr['tot'];}
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
      <p class="sk-page-subtitle">Pantau arus kas keluar dan verifikasi transaksi penarikan dengan mudah.</p>
    </div>
  </div>
</div>

<!-- Filter Card -->
<div class="sk-filter-card">
  <form action="" method="post" style="width:100%;" id="lap-form">
    <input type="hidden" name="filter_mode" id="fmode" value="<?php echo $mode;?>">
    <div style="display:flex;gap:6px;margin-bottom:14px;">
      <button type="button" id="tab-b" onclick="swMode('bulanan')" class="sk-btn sk-btn-sm <?php echo $mode==='bulanan'?'sk-btn-primary':'sk-btn-outline';?>"><i class="fa fa-calendar"></i> Bulan &amp; Tahun</button>
      <button type="button" id="tab-r" onclick="swMode('rentang')" class="sk-btn sk-btn-sm <?php echo $mode==='rentang'?'sk-btn-primary':'sk-btn-outline';?>"><i class="fa fa-calendar-o"></i> Rentang Tanggal</button>
    </div>
    <div style="display:flex;gap:20px;align-items:flex-end;flex-wrap:wrap;">
      <div id="gb" <?php echo $mode==='rentang'?'style="display:none"':'';?> style="display:flex;gap:20px;align-items:flex-end;">
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
            <?php for($y=$yr;$y>=2018;$y--): ?>
            <option value="<?php echo $y; ?>" <?php echo ($tahun_val==$y)?'selected':''; ?>><?php echo $y; ?></option>
            <?php endfor; ?>
          </select>
        </div>
      </div>
      <div id="gr" <?php echo $mode==='bulanan'?'style="display:none"':'';?> style="display:flex;gap:20px;align-items:flex-end;">
        <div style="display:flex;flex-direction:column;gap:5px;">
          <label class="sk-filter-label">DARI</label>
          <input type="date" name="tgl_dari" class="sk-filter-select" value="<?php echo htmlspecialchars($dari_val);?>">
        </div>
        <div style="display:flex;flex-direction:column;gap:5px;">
          <label class="sk-filter-label">SAMPAI</label>
          <input type="date" name="tgl_sampai" class="sk-filter-select" value="<?php echo htmlspecialchars($sampai_val);?>">
        </div>
      </div>
      <button type="submit" name="cari" class="sk-btn sk-btn-primary"><i class="fa fa-search"></i> Cek Laporan</button>
      <?php if(isset($_POST['cari'])): ?>
      <a href="cetakpengambilan.php?bulan=<?php echo $bulan_val; ?>&tahun=<?php echo $tahun_val; ?>" target="_blank" class="sk-btn sk-btn-outline"><i class="fa fa-print"></i> Cetak</a>
      <?php endif; ?>
    </div>
  </form>
</div>

<?php if(isset($_POST['cari'])): ?>

<!-- Stat Cards -->
<div class="sk-stat-grid" style="grid-template-columns:repeat(3,1fr);margin-bottom:18px;">
  <div class="sk-stat-card">
    <div>
      <div class="sk-stat-label">Total Pengambilan</div>
      <div class="sk-stat-value amt-red" style="font-size:1.25rem;">Rp <?php echo number_format($total_pengambilan,0,',','.'); ?></div>
      <div class="sk-stat-sub"><i class="fa fa-arrow-down" style="color:#DC2626;"></i> Periode: <?php echo htmlspecialchars($label);?></div>
    </div>
    <div class="sk-stat-icon red"><i class="fa fa-arrow-circle-down"></i></div>
  </div>
  <div class="sk-stat-card">
    <div>
      <div class="sk-stat-label">Jumlah Transaksi</div>
      <div class="sk-stat-value"><?php echo $count_transaksi; ?> Transaksi</div>
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

<!-- Chart -->
<div class="sk-card" style="margin-bottom:20px;">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-bar-chart" style="color:#DC2626"></i>&nbsp; Grafik Pengambilan &mdash; <?php echo htmlspecialchars($label);?></h5>
  </div>
  <div style="padding:16px 24px 24px;">
    <canvas id="chartPengambilan" height="100"></canvas>
  </div>
</div>

<!-- Table Card -->
<div class="sk-card">
  <div class="sk-card-header">
    <div style="display:flex;align-items:center;gap:10px;">
      <i class="fa fa-list" style="color:#2563EB;font-size:0.9rem;"></i>
      <h5 class="sk-card-title" style="text-transform:uppercase;letter-spacing:0.05em;font-size:0.82rem;">Daftar Transaksi Penarikan</h5>
    </div>
    <span style="background:#2563EB;color:white;font-size:0.68rem;font-weight:700;border-radius:6px;padding:3px 10px;"><?php echo htmlspecialchars($label);?></span>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead>
        <tr><th>No</th><th>ID Pengambilan</th><th>Tanggal</th><th>ID Anggota</th><th>Nama Anggota</th><th>Jumlah (Rp)</th></tr>
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
          <td colspan="5" style="text-align:right;font-weight:700;font-size:0.875rem;">Total Pengambilan</td>
          <td class="amt-red" style="font-weight:800;font-size:1rem;">Rp <?php echo number_format($total_pengambilan,0,',','.'); ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="sk-notice" style="margin:20px 0;">
  <i class="fa fa-info-circle" style="color:#2563EB;font-size:1rem;flex-shrink:0;margin-top:1px;"></i>
  <div>
    <strong style="color:#1E293B;font-size:0.85rem;">Informasi Laporan</strong>
    <p style="margin:3px 0 0 0;font-size:0.83rem;color:#64748B;">Laporan ini dihasilkan secara otomatis oleh sistem berdasarkan data transaksi yang telah divalidasi.</p>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function(){
  new Chart(document.getElementById('chartPengambilan'),{
    type:'bar',
    data:{
      labels:<?php echo json_encode(array_values($cl));?>,
      datasets:[{label:'Jumlah Pengambilan',data:<?php echo json_encode(array_values($cd));?>,backgroundColor:'rgba(220,38,38,0.75)',borderRadius:5}]
    },
    options:{responsive:true,plugins:{legend:{position:'top'},tooltip:{callbacks:{label:function(c){return 'Rp '+c.raw.toLocaleString('id-ID');}}}},
      scales:{y:{beginAtZero:true,ticks:{callback:function(v){return 'Rp '+v.toLocaleString('id-ID');}}}}}
  });
})();
</script>

<?php endif; ?>

<script>
function swMode(m){
  document.getElementById('fmode').value=m;
  document.getElementById('gb').style.display=m==='bulanan'?'flex':'none';
  document.getElementById('gr').style.display=m==='rentang'?'flex':'none';
  document.getElementById('tab-b').className='sk-btn sk-btn-sm '+(m==='bulanan'?'sk-btn-primary':'sk-btn-outline');
  document.getElementById('tab-r').className='sk-btn sk-btn-sm '+(m==='rentang'?'sk-btn-primary':'sk-btn-outline');
}
</script>

<?php include ("style/footer.php"); ?>