<body class="hold-transition skin-blue-light sidebar-mini<?php echo !empty($isLanding) ? ' landing-page' : ''; ?>">
  <div class="wrapper">

    <?php if (!empty($isLanding)) { ?>
    <header class="landing-navbar-wrap">
      <div class="landing-navbar-inner">
        <a href="index.php" class="landing-brand">
          <img src="assets/dist/img/PKK.jpg" alt="Logo Koperasi">
          <span><strong>Koperasi PKK</strong><em>Karya Sejahtera</em></span>
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