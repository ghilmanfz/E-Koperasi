<?php 
    session_start();
    include ("config/koneksi.php");

// Load site settings for logo display
$pub_settings = ['nama_koperasi' => 'Koperasi HIS', 'logo_path' => ''];
$_ps = @mysqli_query($konek, "SELECT setting_key,setting_value FROM tbl_settings");
if ($_ps) { while ($_psr=mysqli_fetch_assoc($_ps)){$pub_settings[$_psr['setting_key']]=$_psr['setting_value'];} }
    $reg_error = '';
    if (isset($_POST['tambah'])) {
        $nama_anggota       = $_POST['nama_anggota'];
        $tempat_lahir       = $_POST['tempat_lahir'];
        $tanggal_lahir      = $_POST['tanggal_lahir'];
        $gender             = $_POST['gender'];
        $alamat             = $_POST['alamat'];
        $pekerjaan          = $_POST['pekerjaan'];
        $status             = $_POST['status'];
        $tanggal_masuk      = date("Y-m-d");

        $nik                = $_POST['nik'];
        $password           = $_POST['password'];
        $level              = "anggota";

        $cekdulu = mysqli_query($konek, "SELECT * FROM tbl_anggota a LEFT JOIN tbl_login b ON a.id_anggota=b.id_anggota WHERE a.nik = '$nik'");
        if (mysqli_num_rows($cekdulu)) {
            $reg_error = 'NIK Sudah Digunakan! Gunakan NIK lain.';
        } else {

            $sql = mysqli_query($konek,"SELECT * FROM tbl_anggota ORDER BY id_anggota DESC");
            $data = mysqli_fetch_assoc($sql);
            $jml = mysqli_num_rows($sql);
            if($jml==0){
                $id_anggota='AGT001';
            }else{
                $subid = substr($data['id_anggota'],3);
                if($subid>0 && $subid<=8){
                    $sub = $subid+1;
                    $id_anggota='AGT00'.$sub;
                }elseif($subid>=9 && $subid<=100){
                    $sub = $subid+1;
                    $id_anggota='AGT0'.$sub;
                }elseif($subid>=99 && $subid<=1000){
                    $sub = $subid+1;
                    $id_anggota='AGT'.$sub;
                }
            }

            $sql2 = mysqli_query($konek,"SELECT * FROM tbl_tabungan ORDER BY id_tabungan DESC");
            $data2 = mysqli_fetch_assoc($sql2);
            $jml2 = mysqli_num_rows($sql2);
            if($jml2==0){
                $id_tabungan='TBN001';
            }else{
                $subid2 = substr($data2['id_tabungan'],3);
                if($subid2>0 && $subid2<=8){
                    $sub2 = $subid2+1;
                    $id_tabungan='TBN00'.$sub2;
                }elseif($subid2>=9 && $subid2<=100){
                    $sub2 = $subid2+1;
                    $id_tabungan='TBN0'.$sub2;
                }elseif($subid2>=99 && $subid2<=1000){
                    $sub2 = $subid2+1;
                    $id_tabungan='TBN'.$sub2;
                }
            }       

            $save = mysqli_query($konek, "INSERT INTO tbl_anggota VALUES('$id_anggota','$nik','$nama_anggota','$tempat_lahir','$tanggal_lahir','$gender','$alamat','$pekerjaan','$status','$tanggal_masuk','Pending')");
            $save2 = mysqli_query($konek, "INSERT INTO tbl_login VALUES('','$id_anggota','$nik','$password','$level')");
            $save3 = mysqli_query($konek, "INSERT INTO tbl_tabungan VALUES('$id_tabungan','$id_anggota','0','0')");

            if ($save) {
                $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Pendaftaran Berhasil! Silakan tunggu konfirmasi Admin.'];
                header('Location: login.php');
                exit;
            } else {
                $reg_error = 'Pendaftaran Gagal! Coba lagi.';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Daftar Anggota - Koperasi PKK Karya Sejahtera</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
	<style>
		html { font-size: 16px; }
		body.auth-page {
			font-family: 'Plus Jakarta Sans', sans-serif;
			background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
			background-attachment: fixed;
			margin: 0;
			font-size: 16px;
			color: #333;
			min-height: 100vh;
			display: flex;
			flex-direction: column;
		}

		/* Navbar */
		.auth-navbar {
			background: white;
			box-shadow: 0 2px 10px rgba(0,0,0,0.05);
			padding: 15px 0;
			position: sticky;
			top: 0;
			z-index: 100;
		}
		.auth-navbar-inner {
			max-width: 1200px;
			margin: 0 auto;
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 0 20px;
		}
		.auth-brand {
			display: flex;
			align-items: center;
			text-decoration: none;
			color: #2b5cff;
			font-size: 1.25rem;
		}
		.auth-brand img {
			width: 32px;
			height: 32px;
			border-radius: 8px;
			margin-right: 10px;
		}
		.auth-back-link {
			color: #666;
			text-decoration: none;
			font-size: 0.9rem;
			font-weight: 500;
			display: flex;
			align-items: center;
			gap: 8px;
			transition: color 0.2s;
		}
		.auth-back-link:hover {
			color: #2b5cff;
			text-decoration: none;
		}

		/* Main Layout */
		.reg-main {
			flex: 1;
			max-width: 1100px;
			margin: 40px auto;
			padding: 0 20px;
			display: grid;
			grid-template-columns: 1.8fr 1fr;
			gap: 30px;
			align-items: start;
		}
		
		/* Card Styles */
		.auth-card {
			background: white;
			border-radius: 16px;
			box-shadow: 0 10px 40px rgba(0,0,0,0.08);
			padding: 40px;
		}
		.reg-info-panel {
			display: flex;
			flex-direction: column;
			gap: 20px;
		}
		.info-box {
			background: #f8fbff;
			border-radius: 12px;
			padding: 25px;
			border: 1px solid #e1e8f2;
		}
		.info-box.dashed {
			background: white;
			border: 2px dashed #d0d7e5;
		}
		
		/* Form Header */
		.auth-card-header {
			text-align: center;
			margin-bottom: 30px;
		}
		.auth-card-header h1 {
			color: #2b5cff;
			font-size: 2rem;
			font-weight: 700;
			margin: 0 0 10px 0;
		}
		.auth-card-header p {
			color: #666;
			margin: 0;
			font-size: 1.05rem;
		}

		/* Form Fields */
		.form-section {
			margin-bottom: 25px;
		}
		.form-section-title {
			font-size: 1.05rem;
			font-weight: 700;
			color: #333;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			margin-bottom: 15px;
			display: flex;
			align-items: center;
			gap: 8px;
			padding-bottom: 10px;
			border-bottom: 1px solid #eee;
		}
		.form-section-title i {
			color: #2b5cff;
			font-size: 1.2rem;
		}

		.form-row {
			display: flex;
			gap: 20px;
			margin-bottom: 15px;
		}
		.form-group-custom {
			flex: 1;
			margin-bottom: 15px;
		}
		.form-group-custom label {
			display: block;
			font-weight: 600;
			font-size: 1.05rem;
			color: #444;
			margin-bottom: 8px;
		}
		.auth-input-wrap {
			position: relative;
		}
		.auth-input-wrap i.input-icon {
			position: absolute;
			left: 14px;
			top: 50%;
			transform: translateY(-50%);
			color: #999;
			font-size: 1.15rem;
		}
		.auth-input-wrap input,
		.auth-input-wrap select,
		.auth-input-wrap textarea {
			width: 100%;
			padding: 13px 15px 13px 44px;
			border: 1px solid #ddd;
			border-radius: 8px;
			font-size: 1.05rem;
			font-family: inherit;
			color: #333;
			transition: all 0.2s;
			background: #fafafa;
		}
		.auth-input-wrap input.no-icon,
		.auth-input-wrap select.no-icon,
		.auth-input-wrap textarea.no-icon {
			padding-left: 15px;
		}
		.auth-input-wrap textarea {
			resize: vertical;
			min-height: 80px;
		}
		.auth-input-wrap input:focus,
		.auth-input-wrap select:focus,
		.auth-input-wrap textarea:focus {
			border-color: #2b5cff;
			background: white;
			outline: none;
			box-shadow: 0 0 0 4px rgba(43,92,255,0.1);
		}
		
		.help-text {
			font-size: 0.85rem;
			color: #888;
			margin-top: 5px;
			display: block;
			font-style: italic;
		}

		.auth-btn-primary {
			width: 100%;
			background: #2b5cff;
			color: white;
			border: none;
			padding: 15px;
			border-radius: 8px;
			font-size: 1.15rem;
			font-weight: 600;
			cursor: pointer;
			transition: all 0.2s;
			margin-top: 10px;
		}
		.auth-btn-primary:hover {
			background: #1d46d8;
			transform: translateY(-1px);
			box-shadow: 0 4px 15px rgba(43,92,255,0.3);
		}
		.login-link {
			display: block;
			text-align: center;
			margin-top: 20px;
			font-size: 1.05rem;
			color: #666;
		}
		.login-link a {
			color: #2b5cff;
			font-weight: 600;
			text-decoration: none;
		}
		.login-link a:hover {
			text-decoration: underline;
		}

		/* Info Box Styling */
		.info-box h3 {
			font-size: 1.15rem;
			font-weight: 700;
			color: #2b5cff;
			margin: 0 0 15px 0;
			display: flex;
			align-items: center;
			gap: 8px;
		}
		.info-box ul {
			list-style: none;
			padding: 0;
			margin: 0 0 15px 0;
		}
		.info-box ul li {
			position: relative;
			padding-left: 25px;
			margin-bottom: 12px;
			font-size: 1rem;
			color: #444;
			line-height: 1.4;
		}
		.info-box ul li i {
			position: absolute;
			left: 0;
			top: 3px;
			color: #2b5cff;
			font-size: 1.1rem;
		}
		.info-box p {
			font-size: 0.95rem;
			color: #666;
			line-height: 1.5;
			margin: 0;
		}
		.info-box .contact-item {
			font-weight: 600;
			color: #333;
			font-size: 1rem;
			margin-top: 8px;
		}

		/* Footer */
		.auth-footer {
			background: #f8f9fb;
			padding: 50px 20px 20px;
			border-top: 1px solid #eee;
			margin-top: auto;
		}
		.auth-footer-inner {
			max-width: 1200px;
			margin: 0 auto;
			display: grid;
			grid-template-columns: 2fr 1fr 1fr;
			gap: 40px;
			margin-bottom: 40px;
		}
		.auth-footer-brand p {
			color: #666;
			font-size: 0.9rem;
			line-height: 1.6;
			max-width: 400px;
			margin-top: 15px;
		}
		.auth-footer-logo {
			display: flex;
			align-items: center;
			color: #2b5cff;
			font-size: 1.2rem;
		}
		.auth-footer-logo img {
			width: 32px;
			height: 32px;
			border-radius: 8px;
			margin-right: 10px;
		}
		.auth-footer h4 {
			font-size: 1rem;
			font-weight: 700;
			color: #333;
			margin-bottom: 20px;
		}
		.auth-footer ul {
			list-style: none;
			padding: 0;
			margin: 0;
		}
		.auth-footer ul li {
			margin-bottom: 12px;
			font-size: 0.9rem;
			color: #666;
			display: flex;
			align-items: center;
			gap: 10px;
		}
		.auth-footer ul li a {
			color: #666;
			text-decoration: none;
			transition: color 0.2s;
		}
		.auth-footer ul li a:hover {
			color: #2b5cff;
		}
		.auth-footer ul li i {
			color: #2b5cff;
		}
		.auth-footer-bottom {
			max-width: 1200px;
			margin: 0 auto;
			padding-top: 20px;
			border-top: 1px solid #ddd;
			display: flex;
			justify-content: space-between;
			color: #888;
			font-size: 0.85rem;
		}

		/* Responsive */
		@media (max-width: 900px) {
			.reg-main {
				grid-template-columns: 1fr;
			}
			.auth-footer-inner {
				grid-template-columns: 1fr;
				gap: 30px;
			}
		}
		@media (max-width: 600px) {
			.form-row {
				flex-direction: column;
				gap: 0;
			}
			.auth-card {
				padding: 25px;
			}
			.auth-footer-bottom {
				flex-direction: column;
				text-align: center;
				gap: 10px;
			}
		}
	</style>
</head>
<body class="auth-page">

	<!-- Top Navbar -->
	<header class="auth-navbar">
		<div class="auth-navbar-inner">
			<a href="index.php" class="auth-brand">
				<?php if(!empty($pub_settings['logo_path'])): ?>
				<img src="<?php echo htmlspecialchars($pub_settings['logo_path']); ?>" alt="Logo Koperasi" style="height:36px;width:auto;max-width:100px;object-fit:contain;border-radius:6px;">
				<?php else: ?>
				<span style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;background:linear-gradient(135deg,#2563eb,#3b82f6);border-radius:8px;color:#fff;font-weight:800;font-size:15px;flex-shrink:0;">K</span>
				<?php endif; ?>
				<span><strong><?php echo htmlspecialchars($pub_settings['nama_koperasi'] ?? 'Koperasi PKK'); ?> Karya Sejahtera</strong></span>
			</a>
			<a href="index.php" class="auth-back-link"><i class="fa fa-chevron-left"></i> Kembali ke Beranda</a>
		</div>
	</header>

	<!-- Main Content -->
	<main class="reg-main">
		<!-- Left: Form Card -->
		<div class="auth-card">
			<div class="auth-card-header">
				<h1>Pendaftaran Anggota Baru</h1>
				<p>Lengkapi data diri Anda untuk bergabung menjadi bagian dari keluarga besar Koperasi PKK.</p>
			</div>

			<?php if ($reg_error): ?>
			<div class="auth-alert auth-alert-error" style="margin-bottom:20px;">
				<i class="fa fa-exclamation-circle"></i>
				<?php echo htmlspecialchars($reg_error); ?>
			</div>
			<?php endif; ?>
			<form class="auth-form" method="post" action="">
				
				<!-- Section 1 -->
				<div class="form-section">
					<div class="form-section-title">
						<i class="fa fa-user-o"></i> INFORMASI IDENTITAS
					</div>
					<div class="form-row">
						<div class="form-group-custom">
							<label>Nama Lengkap Sesuai KTP</label>
							<div class="auth-input-wrap">
								<i class="fa fa-user input-icon"></i>
								<input type="text" name="nama_anggota" placeholder="Contoh: Siti Nurhaliza" required>
							</div>
						</div>
						<div class="form-group-custom">
							<label>Nomor Induk Kependudukan (NIK)</label>
							<div class="auth-input-wrap">
								<i class="fa fa-id-card-o input-icon"></i>
								<input type="text" name="nik" placeholder="16 Digit NIK Anda" required maxlength="16">
							</div>
						</div>
					</div>
				</div>

				<!-- Section 2 -->
				<div class="form-section">
					<div class="form-section-title">
						<i class="fa fa-calendar-check-o"></i> KELAHIRAN & JENIS KELAMIN
					</div>
					<div class="form-row">
						<div class="form-group-custom">
							<label>Tempat Lahir</label>
							<div class="auth-input-wrap">
								<input type="text" class="no-icon" name="tempat_lahir" placeholder="Kota Lahir" required>
							</div>
						</div>
						<div class="form-group-custom">
							<label>Tanggal Lahir</label>
							<div class="auth-input-wrap">
								<input type="date" class="no-icon" name="tanggal_lahir" required>
							</div>
						</div>
						<div class="form-group-custom">
							<label>Jenis Kelamin</label>
							<div class="auth-input-wrap">
								<select name="gender" class="no-icon" required>
									<option value="" disabled selected>Pilih Gender</option>
									<option value="Laki-laki">Laki-laki</option>
									<option value="Perempuan">Perempuan</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<!-- Section 3 -->
				<div class="form-section">
					<div class="form-section-title">
						<i class="fa fa-map-marker"></i> DOMISILI & STATUS
					</div>
					<div class="form-group-custom">
						<label>Alamat Lengkap</label>
						<div class="auth-input-wrap">
							<i class="fa fa-map-marker input-icon" style="top: 25px;"></i>
							<textarea name="alamat" placeholder="Jl. Nama Jalan, No, RT/RW, Kelurahan, Kecamatan" required></textarea>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group-custom">
							<label>Pekerjaan</label>
							<div class="auth-input-wrap">
								<i class="fa fa-briefcase input-icon"></i>
								<input type="text" name="pekerjaan" placeholder="Contoh: Karyawan Swasta" required>
							</div>
						</div>
						<div class="form-group-custom">
							<label>Status Pernikahan</label>
							<div class="auth-input-wrap">
								<i class="fa fa-heart-o input-icon"></i>
								<select name="status" required>
									<option value="" disabled selected>Pilih Status</option>
									<option value="Belum Menikah">Belum Menikah</option>
									<option value="Menikah">Menikah</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<!-- Section 4 -->
				<div class="form-section">
					<div class="form-section-title">
						<i class="fa fa-lock"></i> KEAMANAN AKUN
					</div>
					<div class="form-group-custom">
						<label>Kata Sandi Akun</label>
						<div class="auth-input-wrap">
							<i class="fa fa-lock input-icon"></i>
							<input type="password" name="password" placeholder="Buat sandi yang kuat" required>
						</div>
						<span class="help-text">Gunakan minimal 8 karakter dengan kombinasi huruf dan angka.</span>
					</div>
				</div>

				<button class="auth-btn-primary" name="tambah" type="submit">
					Daftar Sekarang
				</button>

				<div class="login-link">
					Sudah punya akun? <a href="login.php">Masuk di sini</a>
				</div>
			</form>
		</div>

		<!-- Right: Info Panels -->
		<div class="reg-info-panel">
			<div class="info-box">
				<h3><i class="fa fa-info-circle"></i> Syarat & Ketentuan</h3>
				<ul>
					<li><i class="fa fa-check-circle-o"></i> Kewarganegaraan INDONESIA.</li>
					<li><i class="fa fa-check-circle-o"></i> Keanggotaan bersifat perorangan.</li>
					<li><i class="fa fa-check-circle-o"></i> Bersedia membayar Simpanan Pokok & Wajib.</li>
					<li><i class="fa fa-check-circle-o"></i> Menyetujui Anggaran Dasar & Rumah Tangga.</li>
				</ul>
				<hr style="border-color: #d0d7e5; margin: 15px 0;">
				<p>Dengan mendaftar, Anda menyatakan bahwa data yang diisi adalah benar dan bersedia mengikuti segala ketentuan Koperasi PKK Karya Sejahtera.</p>
			</div>

			<div class="info-box dashed">
				<h3><i class="fa fa-question-circle-o"></i> Butuh Bantuan?</h3>
				<p style="margin-bottom: 10px;">Jika Anda mengalami kesulitan saat melakukan pendaftaran online, silakan hubungi pengurus kami melalui:</p>
				<div class="contact-item">WhatsApp: 08998178858</div>
				<div class="contact-item">Email: Nurhsnh148@Gmail.com</div>
			</div>
		</div>

	</main>

	<!-- Footer -->
	<footer class="auth-footer">
		<div class="auth-footer-inner">
			<div class="auth-footer-brand">
				<div class="auth-footer-logo">
					<?php if(!empty($pub_settings['logo_path'])): ?>
					<img src="<?php echo htmlspecialchars($pub_settings['logo_path']); ?>" alt="Logo" style="height:36px;width:auto;max-width:100px;object-fit:contain;border-radius:6px;">
					<?php else: ?>
					<span style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;background:linear-gradient(135deg,#2563eb,#3b82f6);border-radius:8px;color:#fff;font-weight:800;font-size:15px;flex-shrink:0;">K</span>
					<?php endif; ?>
					<span><strong><?php echo htmlspecialchars($pub_settings['nama_koperasi'] ?? 'Koperasi PKK'); ?> Karya Sejahtera</strong></span>
				</div>
				<p>Membangun kesejahteraan bersama anggota melalui layanan koperasi yang modern, transparan, dan terpercaya.</p>
			</div>
			<div class="auth-footer-contact">
				<h4>Hubungi Kami</h4>
				<ul>
					<li><i class="fa fa-map-marker"></i> Jl. H. Sa'alan Koang Jaya</li>
					<li><i class="fa fa-phone"></i> 08998178858</li>
					<li><i class="fa fa-envelope"></i> Nurhsnh148@Gmail.com</li>
				</ul>
			</div>
			<div class="auth-footer-menu">
				<h4>Menu Cepat</h4>
				<ul>
					<li><a href="login.php">Masuk ke Akun</a></li>
					<li><a href="daftar.php">Pendaftaran Anggota</a></li>
					<li><a href="#syarat">Syarat & Ketentuan</a></li>
				</ul>
			</div>
		</div>
		<div class="auth-footer-bottom">
			<p>&copy; <?php echo date('Y'); ?> Koperasi PKK Karya Sejahtera. All rights reserved.</p>
			<p>Ketua: Nurhasanah</p>
		</div>
	</footer>

<?php if (!empty($_SESSION['flash'])): $f = $_SESSION['flash']; unset($_SESSION['flash']); ?>
<div id="flashToast" class="flash-toast flash-<?php echo htmlspecialchars($f['type']); ?>">
  <i class="flash-icon fa fa-<?php echo $f['type']==='success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
  <div class="flash-body">
    <span class="flash-title"><?php echo $f['type']==='success' ? 'Berhasil' : 'Gagal'; ?></span>
    <span class="flash-msg"><?php echo htmlspecialchars($f['msg']); ?></span>
  </div>
  <button class="flash-close" onclick="document.getElementById('flashToast').remove()">&times;</button>
  <div class="flash-progress"></div>
</div>
<script>setTimeout(function(){var t=document.getElementById('flashToast');if(t){t.style.opacity='0';t.style.transform='translateX(110%)';t.style.transition='opacity 0.4s,transform 0.4s';setTimeout(function(){if(t)t.remove();},400);}},3000);</script>
<?php endif; ?>
</body>
</html>
