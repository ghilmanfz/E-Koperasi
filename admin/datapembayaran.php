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
    <h1 class="sk-page-title">Pembayaran Angsuran</h1>
    <p class="sk-page-subtitle">Rekap pembayaran cicilan pinjaman anggota</p>
  </div>
  <div class="sk-page-actions">
    <a href="tambahpembayaran.php" class="sk-btn sk-btn-primary"><i class="fa fa-plus"></i> Tambah Pembayaran</a>
  </div>
</div>

<div class="sk-card">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-calendar-check-o" style="color:#2563EB"></i>&nbsp; Daftar Pembayaran Angsuran</h5>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead>
        <tr>
          <th>No</th>
          <th>ID Angsuran</th>
          <th>ID Pinjaman</th>
          <th>Cicilan Ke-</th>
          <th>Jumlah Bayar</th>
          <th>Tanggal Bayar</th>
          <th style="text-align:center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no = 1;
        include ("../config/koneksi.php");
        $sql = mysqli_query($konek, "SELECT * FROM tbl_pembayaran");
        while ($data = mysqli_fetch_array($sql)){
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><span class="sk-id-link"><?php echo $data['id_angsuran']; ?></span></td>
          <td><?php echo $data['id_pinjaman']; ?></td>
          <td style="text-align:center;"><span class="sk-badge wajib">#<?php echo $data['cicilan']; ?></span></td>
          <td class="amt-blue"><?php echo 'Rp '.number_format($data['jml_bayar'],0,',','.'); ?></td>
          <td><?php echo tgl_indo($data['tgl_bayar']); ?></td>
          <td style="text-align:center;white-space:nowrap;">
            <a href="editpembayaran.php?kd=<?php echo $data['id_angsuran']; ?>" class="sk-btn-icon-act" title="Edit"><i class="fa fa-edit"></i></a>
            <a href="hapuspembayaran.php?kd=<?php echo $data['id_angsuran']; ?>" class="sk-btn-icon-act danger" title="Hapus" onclick="return confirm('Yakin hapus data pembayaran ini?')"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include ("style/footer.php"); ?>