<?php
include("style/header.php");
include("style/sidebar.php");
include("../config/koneksi.php");
function tgl_indo($t){$b=[1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];$p=explode('-',$t);return $p[2].'-'.$b[(int)$p[1]].'-'.$p[0];}
$yr=(int)date('Y');
$nm=['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$mode=(isset($_POST['filter_mode'])&&$_POST['filter_mode']==='rentang')?'rentang':'bulanan';
$bv=isset($_POST['bulan'])?(int)$_POST['bulan']:0;
$tv=isset($_POST['tahun'])?(int)$_POST['tahun']:$yr;
$dari=(isset($_POST['tgl_dari'])&&$_POST['tgl_dari'])?$_POST['tgl_dari']:date('Y-m-01');
$sampai=(isset($_POST['tgl_sampai'])&&$_POST['tgl_sampai'])?$_POST['tgl_sampai']:date('Y-m-d');
$dari=date('Y-m-d',strtotime($dari));$sampai=date('Y-m-d',strtotime($sampai));
?>

<div class="sk-header-row">
  <div>
    <h1 class="sk-page-title">Laporan Pengambilan</h1>
    <p class="sk-page-subtitle">Rekap penarikan tabungan anggota per periode</p>
  </div>
</div>

<div class="sk-filter-card">
  <form action="" method="post" id="lap-form">
    <input type="hidden" name="filter_mode" id="fmode" value="<?php echo $mode;?>">
    <div style="display:flex;gap:6px;margin-bottom:14px;">
      <button type="button" id="tab-b" onclick="swMode('bulanan')" class="sk-btn sk-btn-sm <?php echo $mode==='bulanan'?'sk-btn-primary':'sk-btn-outline';?>"><i class="fa fa-calendar"></i> Bulan &amp; Tahun</button>
      <button type="button" id="tab-r" onclick="swMode('rentang')" class="sk-btn sk-btn-sm <?php echo $mode==='rentang'?'sk-btn-primary':'sk-btn-outline';?>"><i class="fa fa-calendar-o"></i> Rentang Tanggal</button>
    </div>
    <div class="sk-filter-group" id="gb" <?php echo $mode==='rentang'?'style="display:none"':'';?>>
      <label class="sk-filter-label">Bulan</label>
      <select name="bulan" class="sk-filter-select">
        <option value="">Pilih Bulan</option>
        <?php for($b=1;$b<=12;$b++): ?>
        <option value="<?php echo $b;?>" <?php echo $bv===$b?'selected':'';?>><?php echo $nm[$b];?></option>
        <?php endfor;?>
      </select>
      <label class="sk-filter-label">Tahun</label>
      <select name="tahun" class="sk-filter-select">
        <option value="">Pilih Tahun</option>
        <?php for($y=$yr;$y>=2018;$y--): ?>
        <option value="<?php echo $y;?>" <?php echo $tv===$y?'selected':'';?>><?php echo $y;?></option>
        <?php endfor;?>
      </select>
    </div>
    <div class="sk-filter-group" id="gr" <?php echo $mode==='bulanan'?'style="display:none"':'';?>>
      <label class="sk-filter-label">Dari</label>
      <input type="date" name="tgl_dari" class="sk-filter-select" value="<?php echo htmlspecialchars($dari);?>">
      <label class="sk-filter-label">Sampai</label>
      <input type="date" name="tgl_sampai" class="sk-filter-select" value="<?php echo htmlspecialchars($sampai);?>">
    </div>
    <button type="submit" name="cari" class="sk-btn sk-btn-primary"><i class="fa fa-search"></i> Cek Data</button>
  </form>
</div>

<?php if(isset($_POST['cari'])):
  if($mode==='rentang'){
    $where="tgl_pengambilan BETWEEN '$dari' AND '$sampai'";
    $label=tgl_indo($dari).' s/d '.tgl_indo($sampai);
    $cq_sql="SELECT DATE_FORMAT(tgl_pengambilan,'%Y-%m') as ym,SUM(jumlah_pengambilan) as tot FROM tbl_pengambilan WHERE tgl_pengambilan BETWEEN '$dari' AND '$sampai' GROUP BY ym ORDER BY ym";
    $ctitle='Grafik Pengambilan — '.htmlspecialchars($dari).' s/d '.htmlspecialchars($sampai);
  } else {
    $where="month(tgl_pengambilan)=$bv AND year(tgl_pengambilan)=$tv";
    $label=($bv?$nm[$bv]:'Semua Bulan').' '.$tv;
    $cq_sql="SELECT MONTH(tgl_pengambilan) as m,SUM(jumlah_pengambilan) as tot FROM tbl_pengambilan WHERE YEAR(tgl_pengambilan)=$tv GROUP BY m ORDER BY m";
    $ctitle='Grafik Pengambilan Tahun '.$tv;
  }
  $cl=[];$cd=[];
  if($mode==='rentang'){
    $cq=mysqli_query($konek,$cq_sql);
    while($cr=mysqli_fetch_assoc($cq)){$cl[]=$cr['ym'];$cd[]=(int)$cr['tot'];}
  } else {
    $cl=array_slice($nm,1);$cd=array_fill(0,12,0);
    $cq=mysqli_query($konek,$cq_sql);
    while($cr=mysqli_fetch_assoc($cq)){$cd[(int)$cr['m']-1]=(int)$cr['tot'];}
  }
?>

<div class="sk-card" style="margin-bottom:24px;">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-bar-chart" style="color:#DC2626"></i>&nbsp; <?php echo $ctitle;?></h5>
  </div>
  <div style="padding:16px 24px 24px;">
    <canvas id="chartPengambilan" height="100"></canvas>
  </div>
</div>

<div class="sk-card">
  <div class="sk-card-header" style="display:flex;align-items:center;justify-content:space-between;">
    <h5 class="sk-card-title"><i class="fa fa-money" style="color:#DC2626"></i>&nbsp; Data Pengambilan &mdash; <?php echo $label;?></h5>
    <a href="cetakpengambilan.php?bulan=<?php echo $bv;?>&tahun=<?php echo $tv;?>" target="_blank" class="sk-btn sk-btn-outline sk-btn-sm"><i class="fa fa-print"></i> Cetak</a>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead>
        <tr><th>No</th><th>ID Pengambilan</th><th>Tanggal</th><th>ID Anggota</th><th>Nama Anggota</th><th>Jumlah Pengambilan</th></tr>
      </thead>
      <tbody>
        <?php $no=1;$total_ambil=0;
        $sql=mysqli_query($konek,"SELECT * FROM tbl_pengambilan a LEFT JOIN tbl_anggota b ON a.id_anggota=b.id_anggota WHERE $where");
        while($data=mysqli_fetch_array($sql)){$total_ambil+=$data['jumlah_pengambilan'];?>
        <tr>
          <td><?php echo $no++;?></td>
          <td><span class="sk-id-link"><?php echo $data['id_pengambilan'];?></span></td>
          <td><?php echo tgl_indo($data['tgl_pengambilan']);?></td>
          <td><?php echo $data['id_anggota'];?></td>
          <td><?php echo htmlspecialchars($data['nama_anggota']);?></td>
          <td class="amt-red"><?php echo 'Rp '.number_format($data['jumlah_pengambilan'],0,',','.');?></td>
        </tr>
        <?php }?>
        <tr class="sk-total-row"><th colspan="5">Total Pengambilan</th><th><?php echo 'Rp '.number_format($total_ambil,0,',','.');?></th></tr>
      </tbody>
    </table>
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

<?php endif;?>

<script>
function swMode(m){
  document.getElementById('fmode').value=m;
  document.getElementById('gb').style.display=m==='bulanan'?'':'none';
  document.getElementById('gr').style.display=m==='rentang'?'':'none';
  document.getElementById('tab-b').className='sk-btn sk-btn-sm '+(m==='bulanan'?'sk-btn-primary':'sk-btn-outline');
  document.getElementById('tab-r').className='sk-btn sk-btn-sm '+(m==='rentang'?'sk-btn-primary':'sk-btn-outline');
}
</script>

<?php include("style/footer.php");?>