<?php
session_start();
include ("config/koneksi.php");

// Load site settings for logo display
$pub_settings = ['nama_koperasi' => 'Koperasi HIS', 'logo_path' => ''];
$_ps = @mysqli_query($konek, "SELECT setting_key,setting_value FROM tbl_settings");
if ($_ps) { while ($_psr=mysqli_fetch_assoc($_ps)){$pub_settings[$_psr['setting_key']]=$_psr['setting_value'];} }

$login_error = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($konek, "SELECT * FROM tbl_login WHERE username='$username' AND password='$password'");
    $row   = mysqli_num_rows($query);

    if ($row > 0) {
        $data = mysqli_fetch_assoc($query);
        if ($data['level'] == 'sekretaris') {
            $_SESSION['id']       = $data['id'];
            $_SESSION['username'] = $username;
            $_SESSION['level']    = 'sekretaris';
            $_SESSION['flash']    = ['type' => 'success', 'msg' => 'Selamat Datang, ' . htmlspecialchars($username) . '!'];
            header('Location: sekretaris/index.php');
            exit;
        } elseif ($data['level'] == 'anggota') {
            $_SESSION['id']       = $data['id'];
            $_SESSION['username'] = $username;
            $_SESSION['level']    = 'anggota';
            $_SESSION['flash']    = ['type' => 'success', 'msg' => 'Selamat Datang, ' . htmlspecialchars($username) . '!'];
            header('Location: anggota/index.php');
            exit;
        } elseif ($data['level'] == 'bendahara') {
            $_SESSION['id']       = $data['id'];
            $_SESSION['username'] = $username;
            $_SESSION['level']    = 'bendahara';
            $_SESSION['flash']    = ['type' => 'success', 'msg' => 'Selamat Datang, ' . htmlspecialchars($username) . '!'];
            header('Location: bendahara/index.php');
            exit;
        } elseif ($data['level'] == 'admin') {
            $_SESSION['id']       = $data['id'];
            $_SESSION['username'] = $username;
            $_SESSION['level']    = 'admin';
            $_SESSION['flash']    = ['type' => 'success', 'msg' => 'Selamat Datang, ' . htmlspecialchars($username) . '!'];
            header('Location: admin/index.php');
            exit;
        } else {
            $login_error = 'Username atau password salah!';
        }
    } else {
        $login_error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login - Koperasi PKK Karya Sejahtera</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/auth-pages.css">
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
				<span><strong><?php echo htmlspecialchars($pub_settings['nama_koperasi'] ?? 'Koperasi PKK'); ?></strong></span>
			</a>
			<a href="index.php" class="auth-back-link"><i class="fa fa-chevron-left"></i> Kembali ke Beranda</a>
		</div>
	</header>

	<!-- Main Content -->
	<main class="auth-main">
		<div class="auth-card">
			<div class="auth-card-header">
				<div class="auth-avatar">
					<?php if(!empty($pub_settings['logo_path'])): ?>
					<img src="<?php echo htmlspecialchars($pub_settings['logo_path']); ?>" alt="Logo" style="width:100%;height:100%;object-fit:contain;border-radius:50%;">
					<?php else: ?>
					<span style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;background:linear-gradient(135deg,#2563eb,#3b82f6);border-radius:50%;color:#fff;font-weight:800;font-size:28px;">K</span>
					<?php endif; ?>
				</div>
				<h1>Selamat Datang Kembali</h1>
				<p>Silakan masuk ke akun Koperasi Anda</p>
			</div>

			<?php if ($login_error): ?>
			<div class="auth-alert auth-alert-error">
				<i class="fa fa-exclamation-circle"></i>
				<?php echo htmlspecialchars($login_error); ?>
			</div>
			<?php endif; ?>
			<form class="auth-form" method="post" action="">
				<div class="auth-field">
					<label for="username">Username atau Email</label>
					<div class="auth-input-wrap">
						<i class="fa fa-user-o"></i>
						<input type="text" id="username" name="username" placeholder="Masukkan username Anda" required autofocus>
					</div>
				</div>

				<div class="auth-field">
					<div class="auth-field-header">
						<label for="password">Kata Sandi</label>
						<a href="#" class="auth-forgot-link">Lupa kata sandi?</a>
					</div>
					<div class="auth-input-wrap">
						<i class="fa fa-lock"></i>
						<input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
						<button type="button" class="auth-toggle-pw" onclick="togglePassword()"><i class="fa fa-eye" id="eyeIcon"></i></button>
					</div>
				</div>

				<!-- <div class="auth-field">
					<label for="level">Pilih Level Akses</label>
					<div class="auth-input-wrap auth-select-wrap">
						<i class="fa fa-shield"></i>
						<select name="level" id="level" required>
							<option value="anggota">Anggota Koperasi</option>
							<option value="bendahara">Bendahara</option>
							<option value="sekretaris">Sekretaris</option>
						</select>
					</div>
				</div> -->

				<button class="auth-btn-primary" name="login" type="submit">
					<i class="fa fa-sign-in"></i> Masuk Sekarang
				</button>
			</form>

			<div class="auth-divider">
				<span>BARU DI KOPERASI?</span>
			</div>

			<a href="daftar.php" class="auth-btn-outline">
				Daftar Jadi Anggota <i class="fa fa-arrow-right"></i>
			</a>
		</div>

		<p class="auth-help-text">Butuh bantuan akses? Hubungi pengurus di kantor atau melalui kontak yang tersedia di bagian bawah halaman.</p>
	</main>

	<!-- Footer -->
	<footer class="auth-footer">
		<div class="auth-footer-inner">
			<div class="auth-footer-brand">
				<div class="auth-footer-logo">
					<img src="assets/dist/img/PKK.jpg" alt="Logo">
					<span><strong>Koperasi PKK Karya Sejahtera</strong></span>
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

	<script>
	function togglePassword() {
		var pw = document.getElementById('password');
		var icon = document.getElementById('eyeIcon');
		if (pw.type === 'password') {
			pw.type = 'text';
			icon.className = 'fa fa-eye-slash';
		} else {
			pw.type = 'password';
			icon.className = 'fa fa-eye';
		}
	}
	</script>

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