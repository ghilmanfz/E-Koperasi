<?php
/**
 * Generator: rewrites all laporan pages with:
 * - Dynamic year dropdown (current year down to 2018)
 * - Date range filter toggle
 * - Chart.js charts
 */
$base = __DIR__;

// ═══════════════════════════════════════════════════════════
// 1) LAPORAN SIMPANAN  (admin + sekretaris — identical code)
// ═══════════════════════════════════════════════════════════
$laporan_simpanan = <<<'EOT'
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
    <h1 class="sk-page-title">Laporan Simpanan</h1>
    <p class="sk-page-subtitle">Rekap simpanan pokok &amp; wajib per periode</p>
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
    $wp="tgl_simpanan BETWEEN '$dari' AND '$sampai' AND jenis_simpanan='Simpanan Pokok'";
    $ww="tgl_simpanan BETWEEN '$dari' AND '$sampai' AND jenis_simpanan='Simpanan Wajib'";
    $label=tgl_indo($dari).' s/d '.tgl_indo($sampai);
    $cq_sql="SELECT DATE_FORMAT(tgl_simpanan,'%Y-%m') as ym,jenis_simpanan,SUM(jumlah_simpanan) as tot FROM tbl_simpanan WHERE tgl_simpanan BETWEEN '$dari' AND '$sampai' GROUP BY ym,jenis_simpanan ORDER BY ym";
  } else {
    $wp="month(tgl_simpanan)=$bv AND year(tgl_simpanan)=$tv AND jenis_simpanan='Simpanan Pokok'";
    $ww="month(tgl_simpanan)=$bv AND year(tgl_simpanan)=$tv AND jenis_simpanan='Simpanan Wajib'";
    $label=($bv?$nm[$bv]:'Semua Bulan').' '.$tv;
    $cq_sql="SELECT MONTH(tgl_simpanan) as m,jenis_simpanan,SUM(jumlah_simpanan) as tot FROM tbl_simpanan WHERE YEAR(tgl_simpanan)=$tv GROUP BY m,jenis_simpanan ORDER BY m";
  }
  $cl=[];$cp=[];$cw=[];
  if($mode==='rentang'){
    $tmp=[];
    $cq=mysqli_query($konek,$cq_sql);
    while($cr=mysqli_fetch_assoc($cq)){$k=$cr['ym'];if(!isset($tmp[$k]))$tmp[$k]=['p'=>0,'w'=>0];if($cr['jenis_simpanan']==='Simpanan Pokok')$tmp[$k]['p']=(int)$cr['tot'];else $tmp[$k]['w']=(int)$cr['tot'];}
    foreach($tmp as $ym=>$v){$cl[]=$ym;$cp[]=$v['p'];$cw[]=$v['w'];}
    $ctitle='Grafik Simpanan — '.htmlspecialchars($dari).' s/d '.htmlspecialchars($sampai);
  } else {
    $cl=array_slice($nm,1);$cp=array_fill(0,12,0);$cw=array_fill(0,12,0);
    $cq=mysqli_query($konek,$cq_sql);
    while($cr=mysqli_fetch_assoc($cq)){$i=(int)$cr['m']-1;if($cr['jenis_simpanan']==='Simpanan Pokok')$cp[$i]=(int)$cr['tot'];else $cw[$i]=(int)$cr['tot'];}
    $ctitle='Grafik Simpanan Tahun '.$tv;
  }
?>

<div class="sk-card" style="margin-bottom:24px;">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-bar-chart" style="color:#2563EB"></i>&nbsp; <?php echo $ctitle;?></h5>
  </div>
  <div style="padding:16px 24px 24px;">
    <canvas id="chartSimpanan" height="100"></canvas>
  </div>
</div>

<div class="sk-card" style="margin-bottom:24px;">
  <div class="sk-card-header" style="display:flex;align-items:center;justify-content:space-between;">
    <h5 class="sk-card-title"><i class="fa fa-folder" style="color:#2563EB"></i>&nbsp; Simpanan Pokok &mdash; <?php echo $label;?></h5>
    <a href="cetaksimpananpokok.php?bulan=<?php echo $bv;?>&tahun=<?php echo $tv;?>" target="_blank" class="sk-btn sk-btn-outline sk-btn-sm"><i class="fa fa-print"></i> Cetak</a>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead><tr><th>No</th><th>ID Simpanan</th><th>Tanggal</th><th>ID Anggota</th><th>Nama Anggota</th><th>Jenis</th><th>Jumlah</th></tr></thead>
      <tbody>
        <?php $no=1;$simpan=0;
        $sql=mysqli_query($konek,"SELECT * FROM tbl_simpanan a LEFT JOIN tbl_anggota b ON a.id_anggota=b.id_anggota WHERE $wp");
        while($data=mysqli_fetch_array($sql)){$simpan+=$data['jumlah_simpanan'];?>
        <tr>
          <td><?php echo $no++;?></td>
          <td><span class="sk-id-link"><?php echo $data['id_simpanan'];?></span></td>
          <td><?php echo tgl_indo($data['tgl_simpanan']);?></td>
          <td><?php echo $data['id_anggota'];?></td>
          <td><?php echo htmlspecialchars($data['nama_anggota']);?></td>
          <td><span class="sk-badge pokok"><?php echo htmlspecialchars($data['jenis_simpanan']);?></span></td>
          <td class="amt-blue"><?php echo 'Rp '.number_format($data['jumlah_simpanan'],0,',','.');?></td>
        </tr>
        <?php }?>
        <tr class="sk-total-row"><th colspan="6">Total Simpanan Pokok</th><th><?php echo 'Rp '.number_format($simpan,0,',','.');?></th></tr>
      </tbody>
    </table>
  </div>
</div>

<div class="sk-card">
  <div class="sk-card-header" style="display:flex;align-items:center;justify-content:space-between;">
    <h5 class="sk-card-title"><i class="fa fa-folder-open" style="color:#059669"></i>&nbsp; Simpanan Wajib &mdash; <?php echo $label;?></h5>
    <a href="cetaksimpananwajib.php?bulan=<?php echo $bv;?>&tahun=<?php echo $tv;?>" target="_blank" class="sk-btn sk-btn-outline sk-btn-sm"><i class="fa fa-print"></i> Cetak</a>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead><tr><th>No</th><th>ID Simpanan</th><th>Tanggal</th><th>ID Anggota</th><th>Nama Anggota</th><th>Jenis</th><th>Jumlah</th></tr></thead>
      <tbody>
        <?php $no=1;$simpan2=0;
        $sql=mysqli_query($konek,"SELECT * FROM tbl_simpanan a LEFT JOIN tbl_anggota b ON a.id_anggota=b.id_anggota WHERE $ww");
        while($data=mysqli_fetch_array($sql)){$simpan2+=$data['jumlah_simpanan'];?>
        <tr>
          <td><?php echo $no++;?></td>
          <td><span class="sk-id-link"><?php echo $data['id_simpanan'];?></span></td>
          <td><?php echo tgl_indo($data['tgl_simpanan']);?></td>
          <td><?php echo $data['id_anggota'];?></td>
          <td><?php echo htmlspecialchars($data['nama_anggota']);?></td>
          <td><span class="sk-badge wajib"><?php echo htmlspecialchars($data['jenis_simpanan']);?></span></td>
          <td class="amt-blue"><?php echo 'Rp '.number_format($data['jumlah_simpanan'],0,',','.');?></td>
        </tr>
        <?php }?>
        <tr class="sk-total-row"><th colspan="6">Total Simpanan Wajib</th><th><?php echo 'Rp '.number_format($simpan2,0,',','.');?></th></tr>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function(){
  new Chart(document.getElementById('chartSimpanan'),{
    type:'bar',
    data:{
      labels:<?php echo json_encode(array_values($cl));?>,
      datasets:[
        {label:'Simpanan Pokok',data:<?php echo json_encode(array_values($cp));?>,backgroundColor:'rgba(37,99,235,0.75)',borderRadius:5},
        {label:'Simpanan Wajib', data:<?php echo json_encode(array_values($cw));?>,backgroundColor:'rgba(5,150,105,0.75)',borderRadius:5}
      ]
    },
    options:{responsive:true,plugins:{legend:{position:'top'},tooltip:{callbacks:{label:function(c){return c.dataset.label+': Rp '+c.raw.toLocaleString('id-ID');}}}},
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
EOT;

// ═══════════════════════════════════════════════════════════
// 2) LAPORAN PINJAMAN  (admin + sekretaris)
// ═══════════════════════════════════════════════════════════
$laporan_pinjaman = <<<'EOT'
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
    <h1 class="sk-page-title">Laporan Pinjaman</h1>
    <p class="sk-page-subtitle">Rekap peminjaman anggota per periode</p>
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
    $where="tgl_pinjaman BETWEEN '$dari' AND '$sampai'";
    $label=tgl_indo($dari).' s/d '.tgl_indo($sampai);
    $cq_sql="SELECT DATE_FORMAT(tgl_pinjaman,'%Y-%m') as ym,SUM(jumlah_pinjaman) as tot FROM tbl_pinjaman WHERE tgl_pinjaman BETWEEN '$dari' AND '$sampai' GROUP BY ym ORDER BY ym";
    $ctitle='Grafik Pinjaman — '.htmlspecialchars($dari).' s/d '.htmlspecialchars($sampai);
  } else {
    $where="month(tgl_pinjaman)=$bv AND year(tgl_pinjaman)=$tv";
    $label=($bv?$nm[$bv]:'Semua Bulan').' '.$tv;
    $cq_sql="SELECT MONTH(tgl_pinjaman) as m,SUM(jumlah_pinjaman) as tot FROM tbl_pinjaman WHERE YEAR(tgl_pinjaman)=$tv GROUP BY m ORDER BY m";
    $ctitle='Grafik Pinjaman Tahun '.$tv;
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
    <h5 class="sk-card-title"><i class="fa fa-bar-chart" style="color:#7C3AED"></i>&nbsp; <?php echo $ctitle;?></h5>
  </div>
  <div style="padding:16px 24px 24px;">
    <canvas id="chartPinjaman" height="100"></canvas>
  </div>
</div>

<div class="sk-card">
  <div class="sk-card-header" style="display:flex;align-items:center;justify-content:space-between;">
    <h5 class="sk-card-title"><i class="fa fa-credit-card" style="color:#2563EB"></i>&nbsp; Data Pinjaman &mdash; <?php echo $label;?></h5>
    <a href="cetakpinjaman.php?bulan=<?php echo $bv;?>&tahun=<?php echo $tv;?>" target="_blank" class="sk-btn sk-btn-outline sk-btn-sm"><i class="fa fa-print"></i> Cetak</a>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead>
        <tr><th>No</th><th>ID Pinjaman</th><th>Tanggal</th><th>ID Anggota</th><th>Nama Anggota</th><th>Bunga/Bln</th><th>Tenor</th><th>Jumlah Pinjaman</th><th>Angsuran/Bln</th></tr>
      </thead>
      <tbody>
        <?php $no=1;$total_pinjaman=0;
        $sql=mysqli_query($konek,"SELECT * FROM tbl_pinjaman a LEFT JOIN tbl_anggota b ON a.id_anggota=b.id_anggota WHERE $where");
        while($data=mysqli_fetch_array($sql)){$total_pinjaman+=$data['jumlah_pinjaman'];?>
        <tr>
          <td><?php echo $no++;?></td>
          <td><span class="sk-id-link"><?php echo $data['id_pinjaman'];?></span></td>
          <td><?php echo tgl_indo($data['tgl_pinjaman']);?></td>
          <td><?php echo $data['id_anggota'];?></td>
          <td><?php echo htmlspecialchars($data['nama_anggota']);?></td>
          <td><?php echo $data['bunga_perbulan'];?>%</td>
          <td><?php echo $data['lama_cicilan'];?> Bulan</td>
          <td><?php echo 'Rp '.number_format($data['jumlah_pinjaman'],0,',','.');?></td>
          <td class="amt-blue"><?php echo 'Rp '.number_format($data['angsuran'],0,',','.');?></td>
        </tr>
        <?php }?>
        <tr class="sk-total-row"><th colspan="7">Total Pinjaman</th><th colspan="2"><?php echo 'Rp '.number_format($total_pinjaman,0,',','.');?></th></tr>
      </tbody>
    </table>
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
EOT;

// ═══════════════════════════════════════════════════════════
// 3) LAPORAN PENGAMBILAN  (admin + sekretaris)
// ═══════════════════════════════════════════════════════════
$laporan_pengambilan = <<<'EOT'
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
EOT;

// ═══════════════════════════════════════════════════════════
// 4) LAPORAN KEUANGAN  (admin + sekretaris)
// ═══════════════════════════════════════════════════════════
$laporan_keuangan = <<<'EOT'
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
    <h1 class="sk-page-title">Laporan Keuangan</h1>
    <p class="sk-page-subtitle">Ringkasan arus kas dan saldo koperasi per periode</p>
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
    $ws="tgl_simpanan BETWEEN '$dari' AND '$sampai'";
    $wa="tgl_pengambilan BETWEEN '$dari' AND '$sampai'";
    $wp="tgl_pinjaman BETWEEN '$dari' AND '$sampai'";
    $label=tgl_indo($dari).' s/d '.tgl_indo($sampai);
    $cq_s="SELECT DATE_FORMAT(tgl_simpanan,'%Y-%m') as ym,SUM(jumlah_simpanan) as tot FROM tbl_simpanan WHERE tgl_simpanan BETWEEN '$dari' AND '$sampai' GROUP BY ym ORDER BY ym";
    $cq_a="SELECT DATE_FORMAT(tgl_pengambilan,'%Y-%m') as ym,SUM(jumlah_pengambilan) as tot FROM tbl_pengambilan WHERE tgl_pengambilan BETWEEN '$dari' AND '$sampai' GROUP BY ym ORDER BY ym";
    $ctitle='Grafik Arus Kas — '.htmlspecialchars($dari).' s/d '.htmlspecialchars($sampai);
  } else {
    $ws="month(tgl_simpanan)=$bv AND year(tgl_simpanan)=$tv";
    $wa="month(tgl_pengambilan)=$bv AND year(tgl_pengambilan)=$tv";
    $wp="month(tgl_pinjaman)=$bv AND year(tgl_pinjaman)=$tv";
    $label=($bv?$nm[$bv]:'Semua Bulan').' '.$tv;
    $cq_s="SELECT MONTH(tgl_simpanan) as m,SUM(jumlah_simpanan) as tot FROM tbl_simpanan WHERE YEAR(tgl_simpanan)=$tv GROUP BY m ORDER BY m";
    $cq_a="SELECT MONTH(tgl_pengambilan) as m,SUM(jumlah_pengambilan) as tot FROM tbl_pengambilan WHERE YEAR(tgl_pengambilan)=$tv GROUP BY m ORDER BY m";
    $ctitle='Grafik Arus Kas Tahun '.$tv;
  }
  // chart data
  if($mode==='rentang'){
    $tmp_s=[];$tmp_a=[];
    $r=mysqli_query($konek,$cq_s); while($x=mysqli_fetch_assoc($r)){$tmp_s[$x['ym']]=(int)$x['tot'];}
    $r=mysqli_query($konek,$cq_a); while($x=mysqli_fetch_assoc($r)){$tmp_a[$x['ym']]=(int)$x['tot'];}
    $cl=array_unique(array_merge(array_keys($tmp_s),array_keys($tmp_a))); sort($cl);
    $cs=[]; $ca=[];
    foreach($cl as $k){$cs[]=$tmp_s[$k]??0;$ca[]=$tmp_a[$k]??0;}
  } else {
    $cl=array_slice($nm,1);$cs=array_fill(0,12,0);$ca=array_fill(0,12,0);
    $r=mysqli_query($konek,$cq_s); while($x=mysqli_fetch_assoc($r)){$cs[(int)$x['m']-1]=(int)$x['tot'];}
    $r=mysqli_query($konek,$cq_a); while($x=mysqli_fetch_assoc($r)){$ca[(int)$x['m']-1]=(int)$x['tot'];}
  }
?>

<div class="sk-card" style="margin-bottom:24px;">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-line-chart" style="color:#2563EB"></i>&nbsp; <?php echo $ctitle;?></h5>
  </div>
  <div style="padding:16px 24px 24px;">
    <canvas id="chartKeuangan" height="100"></canvas>
  </div>
</div>

<!-- Buku Besar -->
<div class="sk-card" style="margin-bottom:24px;">
  <div class="sk-card-header" style="display:flex;align-items:center;justify-content:space-between;">
    <h5 class="sk-card-title"><i class="fa fa-book" style="color:#2563EB"></i>&nbsp; Buku Besar &mdash; <?php echo $label;?></h5>
    <a href="cetakkeuangan.php?bulan=<?php echo $bv;?>&tahun=<?php echo $tv;?>" target="_blank" class="sk-btn sk-btn-outline sk-btn-sm"><i class="fa fa-print"></i> Cetak</a>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead><tr><th>No</th><th>Tanggal</th><th>Kode Transaksi</th><th>Jumlah</th></tr></thead>
      <tbody>
        <?php $no=1;$simpan=0;$ambil=0;
        $sql=mysqli_query($konek,"SELECT * FROM tbl_simpanan WHERE $ws GROUP BY id_simpanan");
        while($data=mysqli_fetch_array($sql)){$simpan+=$data['jumlah_simpanan'];?>
        <tr>
          <td><?php echo $no++;?></td>
          <td><?php echo tgl_indo($data['tgl_simpanan']);?></td>
          <td><?php echo $data['id_simpanan'];?></td>
          <td class="amt-blue"><?php echo 'Rp '.number_format($data['jumlah_simpanan'],0,',','.');?></td>
        </tr>
        <?php }
        $sql2=mysqli_query($konek,"SELECT * FROM tbl_pengambilan WHERE $wa GROUP BY id_pengambilan");
        while($data2=mysqli_fetch_array($sql2)){$ambil+=$data2['jumlah_pengambilan'];?>
        <tr>
          <td><?php echo $no++;?></td>
          <td><?php echo tgl_indo($data2['tgl_pengambilan']);?></td>
          <td><?php echo $data2['id_pengambilan'];?></td>
          <td class="amt-red"><?php echo 'Rp -'.number_format($data2['jumlah_pengambilan'],0,',','.');?></td>
        </tr>
        <?php }$total=$simpan-$ambil;?>
        <tr class="sk-total-row"><th colspan="3">Saldo Bersih</th><th><?php echo 'Rp '.number_format($total,0,',','.');?></th></tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Pinjaman Periode -->
<div class="sk-card">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-credit-card" style="color:#7C3AED"></i>&nbsp; Data Pinjaman &mdash; <?php echo $label;?></h5>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead><tr><th>No</th><th>Tanggal</th><th>Nama Anggota</th><th>Jumlah Pinjaman</th></tr></thead>
      <tbody>
        <?php $no3=1;$total2=0;
        $sql3=mysqli_query($konek,"SELECT * FROM tbl_pinjaman a LEFT JOIN tbl_anggota b ON a.id_anggota=b.id_anggota WHERE $wp GROUP BY id_pinjaman");
        while($data3=mysqli_fetch_array($sql3)){$total2+=$data3['jumlah_pinjaman'];?>
        <tr>
          <td><?php echo $no3++;?></td>
          <td><?php echo tgl_indo($data3['tgl_pinjaman']);?></td>
          <td><?php echo htmlspecialchars($data3['nama_anggota']);?></td>
          <td><?php echo 'Rp '.number_format($data3['jumlah_pinjaman'],0,',','.');?></td>
        </tr>
        <?php }?>
        <tr class="sk-total-row"><th colspan="3">Total Pinjaman</th><th><?php echo 'Rp '.number_format($total2,0,',','.');?></th></tr>
      </tbody>
    </table>
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
EOT;

// ═══════════════════════════════════════════════════════════
// WRITE FILES
// ═══════════════════════════════════════════════════════════
$files = [
    'admin/laporansimpanan.php'     => $laporan_simpanan,
    'sekretaris/laporansimpanan.php'=> $laporan_simpanan,
    'admin/laporanpinjaman.php'     => $laporan_pinjaman,
    'sekretaris/laporanpinjaman.php'=> $laporan_pinjaman,
    'admin/laporanpengambilan.php'  => $laporan_pengambilan,
    'sekretaris/laporanpengambilan.php' => $laporan_pengambilan,
    'admin/laporankeuangan.php'     => $laporan_keuangan,
    'sekretaris/laporankeuangan.php'=> $laporan_keuangan,
];

foreach($files as $path => $content){
    $full = __DIR__.'/'.$path;
    if(file_put_contents($full, $content) !== false){
        echo "OK: $path\n";
    } else {
        echo "FAIL: $path\n";
    }
}
echo "Done.\n";
