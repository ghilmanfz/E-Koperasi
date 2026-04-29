<?php 
	include ("style/header.php");
	include ("style/sidebar.php");

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

<!-- Page Header -->
<div class="sk-header-row">
  <div>
    <h1 class="sk-page-title">Data Anggota</h1>
    <p class="sk-page-subtitle">Daftar seluruh anggota koperasi yang terdaftar</p>
  </div>
  <div class="sk-page-actions">
    <a href="tambahanggota.php" class="sk-btn sk-btn-primary"><i class="fa fa-plus"></i> Tambah Anggota</a>
  </div>
</div>

<!-- Table Card -->
<div class="sk-card">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-users" style="color:#2563EB"></i>&nbsp; Daftar Anggota</h5>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead>
        <tr>
          <th>No</th>
          <th>NIK</th>
          <th>Nama Anggota</th>
          <th>Tempat / Tgl Lahir</th>
          <th>Gender</th>
          <th>Alamat</th>
          <th>Pekerjaan</th>
          <th>Status</th>
          <th>Tgl Masuk</th>
          <th>Keterangan</th>
          <th style="text-align:center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no = 1;
        include ("../config/koneksi.php");
        $sql = mysqli_query($konek, "SELECT * FROM tbl_anggota");
        while ($data = mysqli_fetch_array($sql)){
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><span class="sk-badge pokok"><?php echo $data['nik']; ?></span></td>
          <td>
            <div class="sk-member-name"><?php echo htmlspecialchars($data['nama_anggota']); ?></div>
          </td>
          <td><?php echo htmlspecialchars($data['tempat_lahir']); ?> / <?php echo tgl_indo($data['tanggal_lahir']); ?></td>
          <td><?php echo htmlspecialchars($data['gender']); ?></td>
          <td style="max-width:180px;"><?php echo htmlspecialchars($data['alamat']); ?></td>
          <td><?php echo htmlspecialchars($data['pekerjaan']); ?></td>
          <td>
            <?php
            $st = strtolower($data['status']);
            $cls = ($st==='aktif') ? 'aktif' : 'non-aktif';
            echo '<span class="sk-badge '.$cls.'">'.htmlspecialchars($data['status']).'</span>';
            ?>
          </td>
          <td><?php echo tgl_indo($data['tanggal_masuk']); ?></td>
          <td><?php echo htmlspecialchars($data['keterangan']); ?></td>
          <td style="text-align:center;white-space:nowrap;">
            <a href="editanggota.php?kd=<?php echo $data['id_anggota']; ?>" class="sk-btn-icon-act" title="Edit"><i class="fa fa-edit"></i></a>
            <a href="hapusanggota.php?kd=<?php echo $data['id_anggota']; ?>" class="sk-btn-icon-act danger" title="Hapus" onclick="return confirm('Yakin hapus anggota ini?')"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include ("style/footer.php"); ?>