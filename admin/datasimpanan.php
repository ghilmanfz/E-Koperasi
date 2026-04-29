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
    <h1 class="sk-page-title">Data Simpanan</h1>
    <p class="sk-page-subtitle">Kelola transaksi simpanan anggota koperasi</p>
  </div>
  <div class="sk-page-actions">
    <a href="tambahsimpanan.php" class="sk-btn sk-btn-primary"><i class="fa fa-plus"></i> Tambah Simpanan</a>
  </div>
</div>

<div class="sk-card">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-folder-open" style="color:#2563EB"></i>&nbsp; Daftar Transaksi Simpanan</h5>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead>
        <tr>
          <th>No</th>
          <th>ID Simpanan</th>
          <th>Tanggal</th>
          <th>ID Anggota</th>
          <th>Jenis Simpanan</th>
          <th>Jumlah</th>
          <th style="text-align:center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no = 1;
        include ("../config/koneksi.php");
        $sql = mysqli_query($konek, "SELECT * FROM tbl_simpanan");
        while ($data = mysqli_fetch_array($sql)){
          $jenis = strtolower($data['jenis_simpanan']);
          if (strpos($jenis,'pokok') !== false) $cls = 'pokok';
          elseif (strpos($jenis,'wajib') !== false) $cls = 'wajib';
          else $cls = 'sukarela';
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><span class="sk-id-link"><?php echo $data['id_simpanan']; ?></span></td>
          <td><?php echo tgl_indo($data['tgl_simpanan']); ?></td>
          <td><?php echo $data['id_anggota']; ?></td>
          <td><span class="sk-badge <?php echo $cls; ?>"><?php echo htmlspecialchars($data['jenis_simpanan']); ?></span></td>
          <td class="amt-blue"><?php echo 'Rp '.number_format($data['jumlah_simpanan'],0,',','.'); ?></td>
          <td style="text-align:center;white-space:nowrap;">
            <a href="editsimpanan.php?kd=<?php echo $data['id_simpanan']; ?>" class="sk-btn-icon-act" title="Edit"><i class="fa fa-edit"></i></a>
            <a href="hapussimpanan.php?kd=<?php echo $data['id_simpanan']; ?>" class="sk-btn-icon-act danger" title="Hapus" onclick="return confirm('Yakin hapus simpanan ini?')"><i class="fa fa-trash"></i></a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include ("style/footer.php"); ?>