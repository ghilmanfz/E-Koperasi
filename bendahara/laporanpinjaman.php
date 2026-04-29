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

$yr           = (int)date('Y');
$rows         = [];
$total_jumlah = 0;
$total_bunga  = 0;
$bulan_val    = '';
$tahun_val    = '';
$dari_val     = date('Y-m-01');
$sampai_val   = date('Y-m-d');

$bulan_list = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April',
               '5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus',
               '9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];

$mode = (isset($_POST['filter_mode']) && $_POST['filter_mode']==='rentang') ? 'rentang' : 'bulanan';

if(isset($_POST['cari'])){
    if($mode === 'rentang'){
        $dari_val   = date('Y-m-d', strtotime($_POST['tgl_dari'] ?? $dari_val));
        $sampai_val = date('Y-m-d', strtotime($_POST['tgl_sampai'] ?? $sampai_val));
        $where = "tgl_pinjaman BETWEEN '$dari_val' AND '$sampai_val'";
        $label = tgl_indo($dari_val).' s/d '.tgl_indo($sampai_val);
    } else {
        $bulan_val = $_POST['bulan'];
        $tahun_val = $_POST['tahun'];
        $where = "month(a.tgl_pinjaman)='$bulan_val' AND year(a.tgl_pinjaman)='$tahun_val'";
        $bname = $bulan_val ? ($bulan_list[$bulan_val] ?? '') : '';
        $label = trim("$bname $tahun_val");
    }
    $sql = mysqli_query($konek,
        "SELECT * FROM tbl_pinjaman a
         LEFT JOIN tbl_anggota b ON a.id_anggota=b.id_anggota
         WHERE $where");
    while($d = mysqli_fetch_assoc($sql)){
        $total_jumlah += $d['jumlah_pinjaman'];
        $total_bunga  += $d['jumlah_pinjaman'] * $d['bunga_perbulan'] / 100;
        $rows[] = $d;
    }
    // chart data by month
    if($mode==='rentang'){
        $cq_sql = "SELECT DATE_FORMAT(tgl_pinjaman,'%Y-%m') as ym,SUM(jumlah_pinjaman) as tot FROM tbl_pinjaman WHERE tgl_pinjaman BETWEEN '$dari_val' AND '$sampai_val' GROUP BY ym ORDER BY ym";
    } else {
        $cq_sql = "SELECT MONTH(tgl_pinjaman) as m,SUM(jumlah_pinjaman) as tot FROM tbl_pinjaman WHERE YEAR(tgl_pinjaman)=$tahun_val GROUP BY m ORDER BY m";
    }
    $nm=['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $cl=[]; $cd=[];
    if($mode==='rentang'){
        $cq=mysqli_query($konek,$cq_sql);
        while($cr=mysqli_fetch_assoc($cq)){$cl[]=$cr['ym'];$cd[]=(int)$cr['tot'];}
    } else {
        $cl=array_slice($nm,1); $cd=array_fill(0,12,0);
        $cq=mysqli_query($konek,$cq_sql);
        while($cr=mysqli_fetch_assoc($cq)){$cd[(int)$cr['m']-1]=(int)$cr['tot'];}
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
    <p class="sk-page-subtitle">Kelola dan pantau seluruh data pinjaman anggota koperasi.</p>
  </div>
  <div class="sk-page-actions">
    <?php if($bulan_val || $mode==='rentang'&&isset($_POST['cari'])): ?>
    <a href="cetakpinjaman.php?bulan=<?php echo $bulan_val; ?>&tahun=<?php echo $tahun_val; ?>" target="_blank" class="sk-btn sk-btn-outline"><i class="fa fa-print"></i> Cetak</a>
    <?php endif; ?>
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
    </div>
  </form>
</div>

<?php if(isset($_POST['cari'])): ?>

<!-- Chart -->
<div class="sk-card" style="margin-bottom:20px;">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-bar-chart" style="color:#7C3AED"></i>&nbsp; Grafik Pinjaman &mdash; <?php echo htmlspecialchars($label);?></h5>
  </div>
  <div style="padding:16px 24px 24px;">
    <canvas id="chartPinjaman" height="100"></canvas>
  </div>
</div>

<!-- Data Table -->
<div class="sk-card">
  <div class="sk-card-header">
    <div>
      <h5 class="sk-card-title"><i class="fa fa-filter" style="color:#2563EB"></i>&nbsp; Data Pinjaman Anggota</h5>
      <p style="font-size:0.78rem;color:#94A3B8;margin:3px 0 0 0;">Periode: <?php echo htmlspecialchars($label);?></p>
    </div>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead>
        <tr>
          <th>No</th><th>ID Pinjaman</th><th>Tanggal</th><th>ID Anggota</th><th>Nama Anggota</th>
          <th>Bunga / Bln</th><th>Tenor</th><th>Jumlah Pinjaman</th><th>Angsuran / Bln</th><th>Status</th>
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
      <div class="sk-stat-sub">Periode: <?php echo htmlspecialchars($label);?></div>
    </div>
    <div class="sk-stat-icon purple"><i class="fa fa-credit-card"></i></div>
  </div>
  <div class="sk-stat-card">
    <div>
      <div class="sk-stat-label">Total Pencairan</div>
      <div class="sk-stat-value">Rp <?php echo number_format($total_jumlah,0,',','.'); ?></div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function(){
  new Chart(document.getElementById('chartPinjaman'),{
    type:'bar',
    data:{
      labels:<?php echo json_encode(array_values($cl));?>,
      datasets:[{label:'Jumlah Pinjaman',data:<?php echo json_encode(array_values($cd));?>,backgroundColor:'rgba(124,58,237,0.75)',borderRadius:5}]
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