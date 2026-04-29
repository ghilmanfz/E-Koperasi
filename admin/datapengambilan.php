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
    <h1 class="sk-page-title">Data Pengambilan</h1>
    <p class="sk-page-subtitle">Riwayat penarikan tabungan anggota koperasi</p>
  </div>
  <div class="sk-page-actions">
    <a href="tambahpengambilan.php" class="sk-btn sk-btn-primary"><i class="fa fa-plus"></i> Tambah Pengambilan</a>
  </div>
</div>

<div class="sk-card">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-money" style="color:#2563EB"></i>&nbsp; Riwayat Transaksi Pengambilan</h5>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead>
        <tr>
          <th>No</th>
          <th>ID Pengambilan</th>
          <th>Tanggal</th>
          <th>ID Anggota</th>
          <th>Jumlah Pengambilan</th>
          <th style="text-align:center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no = 1;
        include ("../config/koneksi.php");
        $sql = mysqli_query($konek, "SELECT * FROM tbl_pengambilan a LEFT JOIN tbl_tabungan b ON a.id_anggota=b.id_anggota");
        while ($data = mysqli_fetch_array($sql)){
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><span class="sk-id-link"><?php echo $data['id_pengambilan']; ?></span></td>
          <td><?php echo tgl_indo($data['tgl_pengambilan']); ?></td>
          <td><?php echo $data['id_anggota']; ?></td>
          <td class="amt-red"><?php echo 'Rp '.number_format($data['jumlah_pengambilan'],0,',','.'); ?></td>
          <td style="text-align:center;white-space:nowrap;">
            <a href="editpengambilan.php?kd=<?php echo $data['id_pengambilan']; ?>" class="sk-btn-icon-act" title="Edit"><i class="fa fa-edit"></i></a>
            <a href="hapuspengambilan.php?kd=<?php echo $data['id_pengambilan']; ?>" class="sk-btn-icon-act danger" title="Hapus" onclick="return confirm('Yakin hapus data pengambilan ini?')"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include ("style/footer.php"); ?>