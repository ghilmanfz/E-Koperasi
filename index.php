<?php 
	$isLanding = true;
	include("style/header.php");
	include("style/sidebar.php");
?>
	<section id="tentang" class="landing-hero-v2">
		<div class="landing-hero-grid">
			<div class="landing-hero-copy">
				<span class="landing-chip">Koperasi Konsumen Terpercaya</span>
				<h1>Membangun Kesejahteraan Bersama <span>Koperasi PKK</span></h1>
				<p>Koperasi PKK Karya Sejahtera hadir untuk memberdayakan ekonomi keluarga melalui layanan simpan pinjam yang aman, transparan, dan terpercaya.</p>
				<div class="landing-actions">
					<a href="daftar.php" class="btn btn-primary btn-lg">Daftar Menjadi Anggota</a>
					<a href="#pinjaman" class="btn btn-outline-primary btn-lg">Ajukan Pinjaman</a>
				</div>
				<div class="landing-address-card">
					<i class="fa fa-map-marker"></i>
					<div>
						<strong>Kantor Pusat</strong>
						<p>Jl. H. Salian Koang Jaya</p>
					</div>
				</div>
			</div>
			<div class="landing-hero-visual" aria-hidden="true">
				<div class="landing-hero-illustration">
					<svg viewBox="0 0 220 160" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect width="220" height="160" rx="12" fill="#dce8f9"/>
						<circle cx="155" cy="42" r="22" fill="#b8d0f5"/>
						<polygon points="20,140 80,60 140,140" fill="#9dbfe8"/>
						<polygon points="90,140 155,80 220,140" fill="#c0d7f5"/>
					</svg>
				</div>
				<div class="landing-hero-member">
					<div class="member-dots">
						<span></span><span></span><span></span>
					</div>
					<p>Terbuka untuk <strong>1000+</strong> Anggota PKK</p>
				</div>
			</div>
		</div>
	</section>

	<section id="syarat" class="landing-section light">
		<div class="section-heading">
			<h2>Ketentuan & Persyaratan</h2>
			<p>Kami menjunjung tinggi prinsip keterbukaan. Pastikan Anda memenuhi syarat-syarat berikut untuk bergabung atau mengajukan pembiayaan.</p>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="landing-panel-card">
					<div class="landing-panel-card-head">
						<div class="landing-panel-icon"><i class="fa fa-user-o"></i></div>
						<div>
							<h3>Syarat Menjadi Anggota</h3>
							<p class="landing-panel-subtitle">Keanggotaan Koperasi PKK Karya Sejahtera</p>
						</div>
					</div>
					<ul>
						<li>Kewarganegaraan <strong>INDONESIA</strong>.</li>
						<li>Keanggotaan bersifat perorangan dan bukan dalam bentuk badan hukum.</li>
						<li>Bersedia membayar Simpanan Pokok dan Simpanan Wajib sesuai ketentuan.</li>
						<li>Menyetujui Anggaran Dasar (AD) dan Anggaran Rumah Tangga (ART).</li>
						<li>Mematuhi segala ketentuan yang berlaku dalam Koperasi.</li>
					</ul>
					<a href="daftar.php" class="btn btn-primary btn-block">Gabung Sekarang</a>
				</div>
			</div>
			<div class="col-md-6">
				<div id="pinjaman" class="landing-panel-card">
					<div class="landing-panel-card-head">
						<div class="landing-panel-icon"><i class="fa fa-credit-card"></i></div>
						<div>
							<h3>Syarat Pinjaman</h3>
							<p class="landing-panel-subtitle">Dokumen pengajuan pembiayaan</p>
						</div>
					</div>
					<ul>
						<li>Berstatus sebagai <strong>Anggota PKK</strong> aktif.</li>
						<li>Mengisi Formulir Pengajuan Pinjaman dengan lengkap.</li>
						<li>Menyerahkan Fotocopy KTP (Suami & Istri jika sudah menikah).</li>
						<li>Menyerahkan Fotocopy Kartu Keluarga (KK).</li>
						<li>Menyerahkan Fotocopy Rekening Listrik terbaru.</li>
						<li>Menyerahkan Slip Gaji (jika ada) dan Agunan yang sah.</li>
					</ul>
					<a href="login.php" class="btn btn-outline-download btn-block">Download Formulir</a>
				</div>
			</div>
		</div>
	</section>

	<section id="alur" class="landing-section">
		<span class="landing-chip">Alur Kerja</span>
		<div class="section-heading left">
			<h2>Prosedur Pengajuan Pinjaman</h2>
			<p>Proses pengajuan yang cepat dan transparan demi mendukung kebutuhan finansial anggota kami.</p>
		</div>
		<div class="row steps-row">
			<div class="col-md-3 col-sm-6">
				<div class="landing-step-card">
					<div class="step-badge">01</div>
					<h4>Konsultasi & Berkas</h4>
					<p>Anggota berkonsultasi mengenai rencana pinjaman dan menyerahkan dokumen persyaratan lengkap.</p>
				</div>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="landing-step-card">
					<div class="step-badge">02</div>
					<h4>Verifikasi Data</h4>
					<p>Tim Koperasi melakukan pengecekan keabsahan dokumen dan status keaktifan anggota PKK.</p>
				</div>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="landing-step-card">
					<div class="step-badge">03</div>
					<h4>Persetujuan</h4>
					<p>Rapat pengurus menentukan limit pinjaman dan jangka waktu berdasarkan kemampuan bayar.</p>
				</div>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="landing-step-card">
					<div class="step-badge">04</div>
					<h4>Pencairan Dana</h4>
					<p>Setelah disetujui, dana akan segera cair dan dapat diambil di kantor atau ditransfer.</p>
				</div>
			</div>
		</div>
		<div class="landing-cta-band">
			<div>
				<h3>Butuh bantuan pengajuan?</h3>
				<p>Tim kami siap memandu Anda melalui setiap langkah proses.</p>
			</div>
			<a href="#kontak" class="btn btn-default btn-lg">Hubungi Sekarang</a>
		</div>
	</section>

	<section id="kontak" class="landing-section light">
		<div class="row">
			<div class="col-md-4">
				<div class="section-heading left compact">
					<h2>Kontak Kami</h2>
					<p>Kami melayani pertanyaan seputar keanggotaan dan pinjaman selama jam kerja operasional.</p>
				</div>
				<div class="landing-contact-box">
					<i class="fa fa-phone"></i>
					<div>
						<span>Telepon / WhatsApp</span>
						<strong>0899 8178 858</strong>
					</div>
				</div>
				<div class="landing-contact-box">
					<i class="fa fa-envelope-o"></i>
					<div>
						<span>Email Resmi</span>
						<strong>nurhshn148@gmail.com</strong>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="landing-profile-card">
					<div class="landing-profile-avatar">
						<img src="assets/dist/img/PKK.jpg" alt="Profil Pengurus">
					</div>
					<div class="landing-profile-content">
						<span>Kontak Person Utama</span>
						<h3>Ibu Nurhasanah</h3>
						<p>"Kepuasan anggota adalah prioritas utama kami dalam melayani pemberdayaan ekonomi PKK."</p>
						<div class="landing-profile-actions">
							<a class="btn btn-success" href="#">Chat WhatsApp</a>
							<a class="btn btn-default" href="#kontak">Profil Pengurus</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="landing-footer-note">
		<div class="landing-footer-grid">
			<div>
				<h4>Koperasi PKK</h4>
				<p>Koperasi PKK Karya Sejahtera adalah mitra terpercaya pemberdayaan ekonomi keluarga melalui semangat gotong royong dan kebersamaan.</p>
				<div class="landing-footer-socials">
					<a href="#" title="Facebook"><i class="fa fa-facebook"></i></a>
					<a href="#" title="Instagram"><i class="fa fa-instagram"></i></a>
					<a href="#" title="YouTube"><i class="fa fa-youtube-play"></i></a>
				</div>
			</div>
			<div>
				<h5>Navigasi Cepat</h5>
				<nav class="landing-footer-nav">
					<a href="#tentang">Tentang Kami</a>
					<a href="#syarat">Layanan Simpanan</a>
					<a href="#alur">Pengajuan Pinjaman</a>
					<a href="#kontak">Berita Kegiatan</a>
				</nav>
			</div>
			<div>
				<h5>Bantuan & Legal</h5>
				<nav class="landing-footer-nav">
					<a href="#syarat">Syarat & Ketentuan</a>
					<a href="#">Kebijakan Privasi</a>
					<a href="#">Anggaran Dasar</a>
					<a href="#">FAQ</a>
				</nav>
			</div>
			<div>
				<h5>Lokasi Kantor</h5>
				<p><i class="fa fa-map-marker" style="color:#2f6be2;margin-right:5px;"></i>Jl. H. Salian Koang Jaya, Tangerang, Banten, Indonesia</p>
			</div>
		</div>
		<div class="landing-footer-bottom">
			<p>© <?php echo date('Y'); ?> Koperasi PKK Karya Sejahtera. Hak Cipta Dilindungi Undang-Undang.</p>
			<div class="landing-footer-badges">
				<span class="landing-footer-badge"><i class="fa fa-check-circle"></i> Terdaftar di Kemenkop UKM</span>
				<span class="landing-footer-badge"><i class="fa fa-building"></i> Badan Hukum Koperasi</span>
			</div>
		</div>
	</section>
<?php 
	include("style/footer.php");
?>