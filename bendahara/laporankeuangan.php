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

$yr             = (int)date('Y');
$transactions   = [];
$simpan_total   = 0;
$ambil_total    = 0;
$pinjaman_rows  = [];
$pinjaman_total = 0;
$bulan_val      = '';
$tahun_val      = '';
$dari_val       = date('Y-m-01');
$sampai_val     = date('Y-m-d');

$bulan_list = ['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April',
               '5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus',
               '9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];

$mode = (isset($_POST['filter_mode']) && $_POST['filter_mode']==='rentang') ? 'rentang' : 'bulanan';
$cl=[]; $cs=[]; $ca=[];

if(isset($_POST['cari'])){
    if($mode === 'rentang'){
        $dari_val   = date('Y-m-d', strtotime($_POST['tgl_dari'] ?? $dari_val));
        $sampai_val = date('Y-m-d', strtotime($_POST['tgl_sampai'] ?? $sampai_val));
        $ws = "tgl_simpanan BETWEEN '$dari_val' AND '$sampai_val'";
        $wa = "tgl_pengambilan BETWEEN '$dari_val' AND '$sampai_val'";
        $wp = "tgl_pinjaman BETWEEN '$dari_val' AND '$sampai_val'";
        $label = tgl_indo($dari_val).' s/d '.tgl_indo($sampai_val);
    } else {
        $bulan_val  = $_POST['bulan'];
        $tahun_val  = $_POST['tahun'];
        $ws = "month(tgl_simpanan)='$bulan_val' AND year(tgl_simpanan)='$tahun_val'";
        $wa = "month(tgl_pengambilan)='$bulan_val' AND year(tgl_pengambilan)='$tahun_val'";
        $wp = "month(a.tgl_pinjaman)='$bulan_val' AND year(a.tgl_pinjaman)='$tahun_val'";
        $bname = $bulan_val ? ($bulan_list[$bulan_val] ?? '') : '';
        $label = trim("$bname $tahun_val");
    }

    $sql = mysqli_query($konek,"SELECT * FROM tbl_simpanan WHERE $ws GROUP BY id_simpanan");
    while($d = mysqli_fetch_assoc($sql)){
        $simpan_total += $d['jumlah_simpanan'];
        $transactions[] = ['tanggal'=>$d['tgl_simpanan'],'kode'=>$d['id_simpanan'],'ket'=>'Simpanan Anggota','masuk'=>$d['jumlah_simpanan'],'keluar'=>0];
    }

    $sql2 = mysqli_query($konek,"SELECT * FROM tbl_pengambilan WHERE $wa GROUP BY id_pengambilan");
    while($d = mysqli_fetch_assoc($sql2)){
        $ambil_total += $d['jumlah_pengambilan'];
        $transactions[] = ['tanggal'=>$d['tgl_pengambilan'],'kode'=>$d['id_pengambilan'],'ket'=>'Pengambilan Simpanan','masuk'=>0,'keluar'=>$d['jumlah_pengambilan']];
    }

    usort($transactions, function($a,$b){ return strcmp($a['tanggal'],$b['tanggal']); });

    $sql3 = mysqli_query($konek,
        "SELECT a.*, b.nama_anggota FROM tbl_pinjaman a
         LEFT JOIN tbl_anggota b ON a.id_anggota=b.id_anggota
         WHERE $wp GROUP BY a.id_pinjaman");
    while($d = mysqli_fetch_assoc($sql3)){
        $pinjaman_total += $d['jumlah_pinjaman'];
        $pinjaman_rows[] = $d;
    }

    // Chart data
    $nm=['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    if($mode==='rentang'){
        $tmp_s=[]; $tmp_a=[];
        $r=mysqli_query($konek,"SELECT DATE_FORMAT(tgl_simpanan,'%Y-%m') as ym,SUM(jumlah_simpanan) as tot FROM tbl_simpanan WHERE $ws GROUP BY ym ORDER BY ym");
        while($x=mysqli_fetch_assoc($r)){$tmp_s[$x['ym']]=(int)$x['tot'];}
        $r=mysqli_query($konek,"SELECT DATE_FORMAT(tgl_pengambilan,'%Y-%m') as ym,SUM(jumlah_pengambilan) as tot FROM tbl_pengambilan WHERE $wa GROUP BY ym ORDER BY ym");
        while($x=mysqli_fetch_assoc($r)){$tmp_a[$x['ym']]=(int)$x['tot'];}
        $cl=array_unique(array_merge(array_keys($tmp_s),array_keys($tmp_a))); sort($cl);
        foreach($cl as $k){$cs[]=$tmp_s[$k]??0; $ca[]=$tmp_a[$k]??0;}
    } else {
        $cl=array_slice($nm,1); $cs=array_fill(0,12,0); $ca=array_fill(0,12,0);
        $r=mysqli_query($konek,"SELECT MONTH(tgl_simpanan) as m,SUM(jumlah_simpanan) as tot FROM tbl_simpanan WHERE YEAR(tgl_simpanan)=$tahun_val GROUP BY m");
        while($x=mysqli_fetch_assoc($r)){$cs[(int)$x['m']-1]=(int)$x['tot'];}
        $r=mysqli_query($konek,"SELECT MONTH(tgl_pengambilan) as m,SUM(jumlah_pengambilan) as tot FROM tbl_pengambilan WHERE YEAR(tgl_pengambilan)=$tahun_val GROUP BY m");
        while($x=mysqli_fetch_assoc($r)){$ca[(int)$x['m']-1]=(int)$x['tot'];}
    }
}
$saldo_akhir = $simpan_total - $ambil_total;
$nama_bulan  = $bulan_val ? ($bulan_list[$bulan_val] ?? '') : '';
?>

<!-- Page Header -->
<div class="sk-header-row">
  <div>
    <h1 class="sk-page-title">Laporan Keuangan</h1>
    <p class="sk-page-subtitle">Ringkasan arus kas dan buku besar transaksi koperasi per periode.</p>
  </div>
  <div class="sk-page-actions">
    <?php if(isset($_POST['cari'])): ?>
    <a href="cetakkeuangan.php?bulan=<?php echo $bulan_val; ?>&tahun=<?php echo $tahun_val; ?>" target="_blank" class="sk-btn sk-btn-outline"><i class="fa fa-print"></i> Cetak</a>
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

<!-- Summary Cards -->
<div class="sk-stat-grid" style="grid-template-columns:repeat(3,1fr);margin-bottom:20px;">
  <div class="sk-stat-card">
    <div>
      <div class="sk-stat-label">Saldo Akhir</div>
      <div class="sk-stat-value" style="font-size:1.2rem;"><?php echo ($saldo_akhir>=0?'Rp ':'Rp -').number_format(abs($saldo_akhir),0,',','.'); ?></div>
      <div class="sk-stat-sub"><i class="fa fa-calendar"></i> Periode: <?php echo htmlspecialchars($label);?></div>
    </div>
    <div class="sk-stat-icon blue"><i class="fa fa-university"></i></div>
  </div>
  <div class="sk-stat-card">
    <div>
      <div class="sk-stat-label">Total Pemasukan</div>
      <div class="sk-stat-value amt-blue" style="font-size:1.2rem;">Rp <?php echo number_format($simpan_total,0,',','.'); ?></div>
      <div class="sk-stat-sub"><i class="fa fa-arrow-up" style="color:#2563EB;"></i> Akumulasi periode</div>
    </div>
    <div class="sk-stat-icon green"><i class="fa fa-arrow-circle-up"></i></div>
  </div>
  <div class="sk-stat-card">
    <div>
      <div class="sk-stat-label">Total Pengeluaran</div>
      <div class="sk-stat-value amt-red" style="font-size:1.2rem;">Rp <?php echo number_format($ambil_total,0,',','.'); ?></div>
      <div class="sk-stat-sub"><i class="fa fa-arrow-down" style="color:#DC2626;"></i> Akumulasi periode</div>
    </div>
    <div class="sk-stat-icon red"><i class="fa fa-arrow-circle-down"></i></div>
  </div>
</div>

<!-- Chart -->
<div class="sk-card" style="margin-bottom:20px;">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-line-chart" style="color:#2563EB"></i>&nbsp; Grafik Arus Kas &mdash; <?php echo htmlspecialchars($label);?></h5>
  </div>
  <div style="padding:16px 24px 24px;">
    <canvas id="chartKeuangan" height="100"></canvas>
  </div>
</div>

<!-- Buku Besar -->
<div class="sk-card" style="margin-bottom:20px;">
  <div class="sk-card-header">
    <div style="display:flex;align-items:center;gap:8px;">
      <i class="fa fa-filter" style="color:#2563EB;"></i>
      <h5 class="sk-card-title">Buku Besar Transaksi</h5>
    </div>
    <span style="font-size:0.78rem;color:#94A3B8;">Menampilkan <?php echo count($transactions); ?> data transaksi</span>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead>
        <tr><th>Tanggal</th><th>Kode</th><th>Keterangan Transaksi</th><th>Masuk (Rp)</th><th>Keluar (Rp)</th><th>Saldo Akhir (Rp)</th></tr>
      </thead>
      <tbody>
        <?php $running=0; foreach($transactions as $t): $running+=$t['masuk']-$t['keluar']; ?>
        <tr>
          <td><?php echo tgl_indo($t['tanggal']); ?></td>
          <td><span style="display:inline-block;background:#EFF6FF;color:#2563EB;font-size:0.7rem;font-weight:700;border-radius:4px;padding:2px 8px;"><?php echo htmlspecialchars($t['kode']); ?></span></td>
          <td><?php echo htmlspecialchars($t['ket']); ?></td>
          <td class="<?php echo $t['masuk']>0?'amt-blue':''; ?>"><?php echo $t['masuk']>0?'Rp '.number_format($t['masuk'],0,',','.'):'<span style="color:#CBD5E1">Rp 0</span>'; ?></td>
          <td class="<?php echo $t['keluar']>0?'amt-red':''; ?>"><?php echo $t['keluar']>0?'(Rp '.number_format($t['keluar'],0,',','.').')':'<span style="color:#CBD5E1">Rp 0</span>'; ?></td>
          <td class="<?php echo $running>=0?'amt-blue':'amt-red'; ?> amt-bold"><?php echo ($running>=0?'Rp ':'- Rp ').number_format(abs($running),0,',','.'); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Pinjaman -->
<div class="sk-card" style="margin-bottom:20px;">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-credit-card" style="color:#7C3AED;"></i>&nbsp; Data Pinjaman Periode Ini</h5>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead><tr><th>No</th><th>Tanggal Pinjaman</th><th>Nama Anggota</th><th>Jumlah Pinjaman</th></tr></thead>
      <tbody>
        <?php $no=1; foreach($pinjaman_rows as $data): ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><?php echo tgl_indo($data['tgl_pinjaman']); ?></td>
          <td class="sk-member-name"><?php echo htmlspecialchars($data['nama_anggota']); ?></td>
          <td><?php echo 'Rp '.number_format($data['jumlah_pinjaman'],0,',','.'); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr class="sk-total-row"><td colspan="3" style="text-align:right;font-weight:700;">Total Pinjaman</td><td class="amt-bold">Rp <?php echo number_format($pinjaman_total,0,',','.'); ?></td></tr>
      </tbody>
    </table>
  </div>
</div>

<div class="sk-notice" style="margin-bottom:20px;">
  <i class="fa fa-search" style="color:#2563EB;font-size:1rem;flex-shrink:0;margin-top:1px;"></i>
  <div>
    <strong style="color:#1E293B;font-size:0.85rem;">Informasi Pelaporan</strong>
    <p style="margin:3px 0 0 0;font-size:0.83rem;color:#64748B;">Laporan ini bersifat real-time berdasarkan transaksi yang divalidasi oleh administrator.</p>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function(){
  new Chart(document.getElementById('chartKeuangan'),{
    type:'bar',
    data:{
      labels:<?php echo json_encode(array_values($cl));?>,
      datasets:[
        {label:'Simpanan Masuk',data:<?php echo json_encode(array_values($cs));?>,backgroundColor:'rgba(37,99,235,0.75)',borderRadius:5},
        {label:'Pengambilan Keluar',data:<?php echo json_encode(array_values($ca));?>,backgroundColor:'rgba(220,38,38,0.75)',borderRadius:5}
      ]
    },
    options:{responsive:true,plugins:{legend:{position:'top'},tooltip:{callbacks:{label:function(c){return c.dataset.label+': Rp '+c.raw.toLocaleString('id-ID');}}}},
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