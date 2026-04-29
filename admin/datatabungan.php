<?php 
	include ("style/header.php");
	include ("style/sidebar.php");
?>

<div class="sk-header-row">
  <div>
    <h1 class="sk-page-title">Data Tabungan Anggota</h1>
    <p class="sk-page-subtitle">Saldo simpanan pokok dan wajib setiap anggota</p>
  </div>
</div>

<div class="sk-card">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-bank" style="color:#2563EB"></i>&nbsp; Daftar Tabungan</h5>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead>
        <tr>
          <th>No</th>
          <th>ID Tabungan</th>
          <th>Nama Anggota</th>
          <th>Simpanan Pokok</th>
          <th>Simpanan Wajib</th>
          <th>Total Saldo</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no = 1;
        include ("../config/koneksi.php");
        $sql = mysqli_query($konek, "SELECT * FROM tbl_tabungan a LEFT JOIN tbl_anggota b ON a.id_anggota=b.id_anggota");
        while ($data = mysqli_fetch_array($sql)){
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><span class="sk-badge pokok"><?php echo $data['id_tabungan']; ?></span></td>
          <td><div class="sk-member-name"><?php echo htmlspecialchars($data['nama_anggota']); ?></div></td>
          <td><?php echo 'Rp '.number_format($data['saldo'],0,',','.'); ?></td>
          <td><?php echo 'Rp '.number_format($data['saldo_wajib'],0,',','.'); ?></td>
          <td class="amt-blue"><?php echo 'Rp '.number_format($data['saldo']+$data['saldo_wajib'],0,',','.'); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include ("style/footer.php"); ?>