<?php
include_once "config/koneksi.php";
if (!isset($pub_settings)) {
    $pub_settings = ['nama_koperasi'=>'Koperasi HIS','alamat'=>'Jl. HR. Rasuna Said','telepon'=>'0851-7201-4471','email'=>'mahisduhan2003@gmail.com','deskripsi'=>'Koperasi simpan pinjam yang melayani anggota dengan transparan dan terpercaya.','logo_path'=>'','foto_hero'=>'','syarat_anggota'=>"Warga Negara Indonesia\nBersedia membayar simpanan pokok dan wajib\nMenyetujui Anggaran Dasar dan ART\nMematuhi ketentuan koperasi",'syarat_pinjaman'=>"Anggota aktif koperasi\nMengisi formulir pengajuan\nMenyerahkan fotocopy KTP\nMenyerahkan fotocopy KK",'cta_judul'=>'Butuh Bantuan Administrasi?','cta_deskripsi'=>'Tim kami siap membantu Anda'];
    mysqli_query($konek, "CREATE TABLE IF NOT EXISTS tbl_settings (setting_key VARCHAR(50) NOT NULL PRIMARY KEY, setting_value TEXT NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $_ps = mysqli_query($konek, "SELECT setting_key,setting_value FROM tbl_settings");
    if ($_ps) { while ($_psr=mysqli_fetch_assoc($_ps)){$pub_settings[$_psr['setting_key']]=$_psr['setting_value'];} }
}
?>
<body class="hold-transition skin-blue-light sidebar-mini<?php echo !empty($isLanding) ? ' landing-page' : ''; ?>">
  <div class="wrapper">

    <?php if (!empty($isLanding)) { ?>
    <header class="landing-navbar-wrap">
      <div class="landing-navbar-inner">
        <a href="index.php" class="landing-brand">
          <?php if(!empty($pub_settings['logo_path'])): ?>
          <img src="<?php echo htmlspecialchars($pub_settings['logo_path']); ?>" alt="Logo" style="height:36px;width:auto;max-width:100px;object-fit:contain;border-radius:6px;">
          <?php else: ?>
          <span style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;background:linear-gradient(135deg,#2563eb,#3b82f6);border-radius:8px;color:#fff;font-weight:800;font-size:15px;flex-shrink:0;">K</span>
          <?php endif; ?>
          <span><strong><?php echo htmlspecialchars($pub_settings['nama_koperasi'] ?? 'Koperasi PKK'); ?></strong><em>Karya Sejahtera</em></span>
        </a>
        <nav class="landing-main-nav">
          <a href="#tentang">Home</a>
          <a href="#tentang">Tentang</a>
          <a href="#syarat">Syarat & Ketentuan</a>
          <a href="#pinjaman">Ajukan Pinjaman</a>
          <a href="#kontak">Kontak</a>
        </nav>
        <div class="landing-nav-actions">
          <a href="login.php" class="btn btn-default btn-sm">Masuk</a>
          <a href="daftar.php" class="btn btn-primary btn-sm">Daftar</a>
        </div>
      </div>
    </header>
    <?php } else { ?>

    <!-- Main Header -->
    <header class="main-header">

      <!-- Logo -->
      <a href="index.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>K</b>PKK</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Koperasi</b></span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
      </nav>
    </header>
    <?php } ?>

    <?php if (empty($isLanding)) { ?>
    <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="assets/dist/img/PKK.jpg" class="img-circle" alt="image">
          </div>
          <div class="pull-left info">
            <p>KOPERASI PKK</p>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">Dashboard</li>
          <!-- Optionally, you can add icons to the links -->
          <li class="active"><a href="index.php"><i class="fa fa-home"></i> <span>Home</span></a></li>
          <li><a href="daftar.php"><i class="fa fa-registered"></i> <span>Daftar</span></a></li>
          <li><a href="login.php"><i class="fa fa-sign-in"></i> <span>Login</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
    <?php } ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper<?php echo !empty($isLanding) ? ' landing-content-wrapper' : ''; ?>">
    <!-- Main content -->
    <section class="content container-fluid<?php echo !empty($isLanding) ? ' landing-content' : ''; ?>">