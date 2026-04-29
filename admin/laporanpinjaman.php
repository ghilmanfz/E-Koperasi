<?php 
	include ("style/header.php");
	include ("style/sidebar.php");
	include ("../config/koneksi.php");
	function tgl_indo($tanggal){
		$bulan = array(
			1 => 'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember',);
		$pecahkan = explode('-', $tanggal);
		return $pecahkan[2] . '-' . $bulan[(int)$pecahkan[1]] . '-' . $pecahkan[0];
	}
?>

<div class="sk-header-row">
  <div>
    <h1 class="sk-page-title">Laporan Pinjaman</h1>
    <p class="sk-page-subtitle">Rekap peminjaman anggota per bulan</p>
  </div>
</div>

<!-- Filter Card -->
<div class="sk-filter-card">
  <form action="" method="post">
    <div class="sk-filter-group">
      <label class="sk-filter-label">Bulan</label>
      <select name="bulan" class="sk-filter-select">
        <option value="">Pilih Bulan</option>
        <option value="1">Januari</option>
        <option value="2">Februari</option>
        <option value="3">Maret</option>
        <option value="4">April</option>
        <option value="5">Mei</option>
        <option value="6">Juni</option>
        <option value="7">Juli</option>
        <option value="8">Agustus</option>
        <option value="9">September</option>
        <option value="10">Oktober</option>
        <option value="11">November</option>
        <option value="12">Desember</option>
      </select>
      <label class="sk-filter-label">Tahun</label>
      <select name="tahun" class="sk-filter-select">
        <option value="">Pilih Tahun</option>
        <option value="2018">2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
        <option value="2022">2022</option>
      </select>
      <button type="submit" name="cari" class="sk-btn sk-btn-primary"><i class="fa fa-search"></i> Cek Data</button>
    </div>
  </form>
</div>

<?php
$no = 1;
if(isset($_POST['cari'])){
  $bulan = $_POST['bulan'];
  $tahun = $_POST['tahun'];
?>

<div class="sk-card">
  <div class="sk-card-header" style="display:flex;align-items:center;justify-content:space-between;">
    <h5 class="sk-card-title"><i class="fa fa-credit-card" style="color:#2563EB"></i>&nbsp; Data Pinjaman Periode Ini</h5>
    <a href="cetakpinjaman.php?bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun ?>" target="_blank" class="sk-btn sk-btn-outline sk-btn-sm"><i class="fa fa-print"></i> Cetak</a>
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
          <th>Bunga/Bln</th>
          <th>Tenor</th>
          <th>Jumlah Pinjaman</th>
          <th>Angsuran/Bln</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no = 1;
        include ("../config/koneksi.php");
        $sql = mysqli_query($konek, "SELECT * FROM tbl_pinjaman a LEFT JOIN tbl_anggota b ON a.id_anggota=b.id_anggota WHERE month(a.tgl_pinjaman) = '$bulan' AND year(a.tgl_pinjaman) = '$tahun'");
        while ($data = mysqli_fetch_array($sql)){
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><span class="sk-id-link"><?php echo $data['id_pinjaman']; ?></span></td>
          <td><?php echo tgl_indo($data['tgl_pinjaman']); ?></td>
          <td><?php echo $data['id_anggota']; ?></td>
          <td><?php echo htmlspecialchars($data['nama_anggota']); ?></td>
          <td><?php echo $data['bunga_perbulan']; ?>%</td>
          <td><?php echo $data['lama_cicilan']; ?> Bulan</td>
          <td><?php echo 'Rp '.number_format($data['jumlah_pinjaman'],0,',','.'); ?></td>
          <td class="amt-blue"><?php echo 'Rp '.number_format($data['angsuran'],0,',','.'); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php } ?>

<?php include ("style/footer.php"); ?>
				<div class="select-group">
					<select name="bulan" class="form-control" style="width: 15%; margin-bottom: 5px;">
						<option value="">Pilih Bulan</option>
						<option value="1">Januari</option>
						<option value="2">Februari</option>
						<option value="3">Maret</option>
						<option value="4">April</option>
						<option value="5">Mei</option>
						<option value="6">Juni</option>
						<option value="7">Juli</option>
						<option value="8">Agustus</option>
						<option value="9">September</option>
						<option value="10">Oktober</option>
						<option value="11">November</option>
						<option value="12">Desember</option>
					</select>
				</div>
				<div class="select-group">
					<select name="tahun" class="form-control" style="width: 15%; margin-bottom: 5px;">
						<option value="">Pilih Tahun</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
						<option value="2020">2020</option>
						<option value="2021">2021</option>
						<option value="2022">2022</option>
					</select>
					<span class="select-group-btn">
						<button type="submit" class="btn btn-success btn-flat" name="cari">Check</button>
					</span>
				</div>
			</form>
			<br>
			<?php
			$no = 1;
			if(isset($_POST['cari'])){
				$bulan 	= $_POST['bulan'];
				$tahun 	= $_POST['tahun'];
			?>
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th style="text-align: center;">No</th>
							<th style="text-align: center;">ID Pinjaman</th>
							<th style="text-align: center;">Tanggal Pinjaman</th>
							<th style="text-align: center;">ID Anggota</th>
							<th style="text-align: center;">Nama Anggota</th>
							<th style="text-align: center;">Bunga Per-Bulan</th>
							<th style="text-align: center;">Lama Cicilan</th>
							<th style="text-align: center;">Jumlah Pinjaman</th>
							<th style="text-align: center;">Angsuran Per-Bulan</th>
						</tr>
					</thead>
					<?php 
					$no = 1;
					include ("../config/koneksi.php");
					$sql = mysqli_query($konek, "SELECT * FROM tbl_pinjaman a LEFT JOIN tbl_anggota b ON a.id_anggota=b.id_anggota WHERE month(a.tgl_pinjaman) = '$bulan' AND year(a.tgl_pinjaman) = '$tahun'");
					?>
					<div class="btn-group" style="margin-bottom: 5px;">
					<a href="cetakpinjaman.php?bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun ?>" target="_blank();" class="btn btn-primary btn-flat"><i class="fa fa-print"></i></a>
					</div>
					<?php
					while ($data = mysqli_fetch_array($sql)){
					?>
					<tbody>
						<tr>
							<td><?php echo $no++; ?></td>
							<td><?php echo $data['id_pinjaman']; ?></td>
							<td><?php echo tgl_indo($data['tgl_pinjaman']); ?></td>
							<td><?php echo $data['id_anggota']; ?></td>
							<td><?php echo $data['nama_anggota']; ?></td>
							<td><?php echo $data['bunga_perbulan']; ?></td>
							<td><?php echo $data['lama_cicilan']; ?> <?php echo "Bulan" ?></td>
							<td><?php echo "Rp ".number_format($data['jumlah_pinjaman'],0,',','.');?></td>
							<td><?php echo "Rp ".number_format($data['angsuran'],0,',','.'); ?></td>
						</tr>
					</tbody>
					<?php 
					}
					?>
				</table>
			</div>
			<?php 
			}
			?>
		</div>
    </div>
<?php 
	include ("style/footer.php");
?>