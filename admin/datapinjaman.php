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

<div class="sk-header-row">
  <div>
    <h1 class="sk-page-title">Data Pinjaman</h1>
    <p class="sk-page-subtitle">Kelola data peminjaman anggota koperasi</p>
  </div>
  <div class="sk-page-actions">
    <a href="tambahpinjaman.php" class="sk-btn sk-btn-primary"><i class="fa fa-plus"></i> Tambah Pinjaman</a>
  </div>
</div>

<div class="sk-card">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-credit-card" style="color:#2563EB"></i>&nbsp; Daftar Pinjaman Anggota</h5>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead>
        <tr>
          <th>No</th>
          <th>ID Pinjaman</th>
          <th>Tanggal</th>
          <th>ID Anggota</th>
          <th>Bunga/Bln</th>
          <th>Tenor</th>
          <th>Jumlah Pinjaman</th>
          <th>Angsuran/Bln</th>
          <th style="text-align:center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no = 1;
        include ("../config/koneksi.php");
        $sql = mysqli_query($konek, "SELECT * FROM tbl_pinjaman");
        while ($data = mysqli_fetch_array($sql)){
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><span class="sk-id-link"><?php echo $data['id_pinjaman']; ?></span></td>
          <td><?php echo tgl_indo($data['tgl_pinjaman']); ?></td>
          <td><?php echo $data['id_anggota']; ?></td>
          <td><?php echo $data['bunga_perbulan']; ?>%</td>
          <td><?php echo $data['lama_cicilan']; ?> Bln</td>
          <td><?php echo 'Rp '.number_format($data['jumlah_pinjaman'],0,',','.'); ?></td>
          <td class="amt-blue"><?php echo 'Rp '.number_format($data['angsuran'],0,',','.'); ?></td>
          <td style="text-align:center;white-space:nowrap;">
            <a href="editpinjaman.php?kd=<?php echo $data['id_pinjaman']; ?>" class="sk-btn-icon-act" title="Edit"><i class="fa fa-edit"></i></a>
            <a href="hapuspinjaman.php?kd=<?php echo $data['id_pinjaman']; ?>" class="sk-btn-icon-act danger" title="Hapus" onclick="return confirm('Yakin hapus pinjaman ini?')"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include ("style/footer.php"); ?>