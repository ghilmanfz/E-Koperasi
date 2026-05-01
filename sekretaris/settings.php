<?php ob_start(); ?>
<?php
include ("style/header.php");
include ("style/sidebar.php");
include ("../config/koneksi.php");
// $sk_settings loaded by sidebar.php

$s = $sk_settings; // alias

$upload_dir = '../assets/uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

$syarat_anggota_lines  = array_filter(array_map('trim', explode("\n", $s['syarat_anggota'])));
$syarat_pinjaman_lines = array_filter(array_map('trim', explode("\n", $s['syarat_pinjaman'])));
?>

<!-- Page Header -->
<div class="sk-header-row">
  <div>
    <h2 class="sk-page-title">Settings</h2>
    <p class="sk-page-subtitle">Kelola identitas koperasi dan konten landing page</p>
  </div>
</div>

<form method="POST" enctype="multipart/form-data" id="settingsForm">
  <input type="hidden" name="action" value="save_settings">

  <!-- ===== Identitas Koperasi ===== -->
  <div class="sk-card sk-settings-card">
    <div class="sk-settings-card-header">
      <i class="fa fa-building"></i> Identitas Koperasi
    </div>
    <div class="sk-settings-card-body">
      <div class="sk-settings-row">
        <div class="sk-settings-field">
          <label class="sk-settings-label">Nama Koperasi</label>
          <input type="text" name="nama_koperasi" class="sk-settings-input" value="<?php echo htmlspecialchars($s['nama_koperasi']); ?>" required>
        </div>
        <div class="sk-settings-field">
          <label class="sk-settings-label">Alamat</label>
          <input type="text" name="alamat" class="sk-settings-input" value="<?php echo htmlspecialchars($s['alamat']); ?>">
        </div>
      </div>
      <div class="sk-settings-row">
        <div class="sk-settings-field">
          <label class="sk-settings-label">Telepon</label>
          <input type="text" name="telepon" class="sk-settings-input" value="<?php echo htmlspecialchars($s['telepon']); ?>">
        </div>
        <div class="sk-settings-field">
          <label class="sk-settings-label">Email</label>
          <input type="email" name="email" class="sk-settings-input" value="<?php echo htmlspecialchars($s['email']); ?>">
        </div>
      </div>
      <div class="sk-settings-field sk-settings-full">
        <label class="sk-settings-label">Deskripsi / Tagline</label>
        <textarea name="deskripsi" class="sk-settings-input sk-settings-textarea" rows="3"><?php echo htmlspecialchars($s['deskripsi']); ?></textarea>
      </div>
    </div>
  </div>

  <!-- ===== Logo & Foto ===== -->
  <div class="sk-card sk-settings-card">
    <div class="sk-settings-card-header">
      <i class="fa fa-image"></i> Logo &amp; Foto
    </div>
    <div class="sk-settings-card-body">
      <div class="sk-settings-row">

        <!-- Logo -->
        <div class="sk-settings-field">
          <label class="sk-settings-label">Logo Koperasi <span class="sk-settings-hint">(ditampilkan di sidebar)</span></label>
          <?php if (!empty($s['logo_path'])): ?>
          <div class="sk-settings-media-preview">
            <img src="../<?php echo htmlspecialchars($s['logo_path']); ?>" alt="Logo" class="sk-settings-logo-thumb">
            <label class="sk-settings-del-label">
              <input type="checkbox" name="hapus_logo" value="1"> Hapus logo
            </label>
          </div>
          <?php else: ?>
          <div class="sk-settings-media-placeholder">
            <i class="fa fa-image"></i>
            <span>Belum ada logo</span>
          </div>
          <?php endif; ?>
          <input type="file" name="logo_file" class="sk-settings-file" accept="image/png,image/jpeg,image/jpg,image/svg+xml,image/gif">
          <span class="sk-settings-hint">Format: PNG, JPG, SVG, GIF &bull; Maks. 2MB</span>
        </div>

        <!-- Foto Hero -->
        <div class="sk-settings-field">
          <label class="sk-settings-label">Foto Hero / Banner <span class="sk-settings-hint">(ditampilkan di halaman utama)</span></label>
          <?php if (!empty($s['foto_hero'])): ?>
          <div class="sk-settings-media-preview">
            <img src="../<?php echo htmlspecialchars($s['foto_hero']); ?>" alt="Foto Hero" class="sk-settings-hero-thumb">
            <label class="sk-settings-del-label">
              <input type="checkbox" name="hapus_foto_hero" value="1"> Hapus foto
            </label>
          </div>
          <?php else: ?>
          <div class="sk-settings-media-placeholder">
            <i class="fa fa-picture-o"></i>
            <span>Belum ada foto hero</span>
          </div>
          <?php endif; ?>
          <input type="file" name="foto_hero_file" class="sk-settings-file" accept="image/png,image/jpeg,image/jpg,image/gif,image/webp">
          <span class="sk-settings-hint">Format: PNG, JPG, GIF, WEBP &bull; Maks. 5MB</span>
        </div>

      </div>
    </div>
  </div>

  <!-- ===== Kontak Person ===== -->
  <div class="sk-card sk-settings-card">
    <div class="sk-settings-card-header">
      <i class="fa fa-user-circle"></i> Kontak Person Utama
    </div>
    <div class="sk-settings-card-body">
      <div class="sk-settings-row">
        <div class="sk-settings-field">
          <label class="sk-settings-label">Nama Pengurus</label>
          <input type="text" name="nama_pengurus" class="sk-settings-input" value="<?php echo htmlspecialchars($s['nama_pengurus'] ?? ''); ?>">
        </div>
        <div class="sk-settings-field">
          <label class="sk-settings-label">No. WhatsApp <span class="sk-settings-hint">(angka saja, misal: 089981788858)</span></label>
          <input type="text" name="wa_pengurus" class="sk-settings-input" value="<?php echo htmlspecialchars($s['wa_pengurus'] ?? ''); ?>" placeholder="089981788858">
        </div>
      </div>
      <div class="sk-settings-field sk-settings-full">
        <label class="sk-settings-label">Kutipan / Quote</label>
        <textarea name="quote_pengurus" class="sk-settings-input sk-settings-textarea" rows="3"><?php echo htmlspecialchars($s['quote_pengurus'] ?? ''); ?></textarea>
      </div>
      <div class="sk-settings-field sk-settings-full">
        <label class="sk-settings-label">Foto Pengurus <span class="sk-settings-hint">(ditampilkan di halaman Kontak)</span></label>
        <?php if (!empty($s['foto_pengurus'])): ?>
        <div class="sk-settings-media-preview">
          <img src="../<?php echo htmlspecialchars($s['foto_pengurus']); ?>" alt="Foto Pengurus" class="sk-settings-hero-thumb">
          <label class="sk-settings-del-label">
            <input type="checkbox" name="hapus_foto_pengurus" value="1"> Hapus foto
          </label>
        </div>
        <?php else: ?>
        <div class="sk-settings-media-placeholder">
          <i class="fa fa-user-circle-o"></i>
          <span>Belum ada foto pengurus</span>
        </div>
        <?php endif; ?>
        <input type="file" name="foto_pengurus_file" class="sk-settings-file" accept="image/png,image/jpeg,image/jpg,image/gif,image/webp">
        <span class="sk-settings-hint">Format: PNG, JPG, GIF, WEBP &bull; Maks. 5MB &bull; Disarankan foto persegi (1:1)</span>
      </div>
    </div>
  </div>

  <!-- ===== Syarat & Ketentuan ===== -->
  <div class="sk-card sk-settings-card">
    <div class="sk-settings-card-header">
      <i class="fa fa-list-ul"></i> Syarat &amp; Ketentuan
      <span class="sk-settings-card-header-hint">Tulis satu syarat per baris</span>
    </div>
    <div class="sk-settings-card-body">
      <div class="sk-settings-row">
        <div class="sk-settings-field">
          <label class="sk-settings-label">Syarat Menjadi Anggota</label>
          <div class="sk-settings-preview-list">
            <?php foreach ($syarat_anggota_lines as $item): ?>
            <div class="sk-settings-preview-item"><i class="fa fa-check"></i> <?php echo htmlspecialchars($item); ?></div>
            <?php endforeach; ?>
          </div>
          <textarea name="syarat_anggota" class="sk-settings-input sk-settings-textarea" rows="7"><?php echo htmlspecialchars($s['syarat_anggota']); ?></textarea>
        </div>
        <div class="sk-settings-field">
          <label class="sk-settings-label">Syarat Mengajukan Pinjaman</label>
          <div class="sk-settings-preview-list">
            <?php foreach ($syarat_pinjaman_lines as $item): ?>
            <div class="sk-settings-preview-item"><i class="fa fa-check"></i> <?php echo htmlspecialchars($item); ?></div>
            <?php endforeach; ?>
          </div>
          <textarea name="syarat_pinjaman" class="sk-settings-input sk-settings-textarea" rows="7"><?php echo htmlspecialchars($s['syarat_pinjaman']); ?></textarea>
        </div>
      </div>
    </div>
  </div>

  <!-- ===== CTA ===== -->
  <div class="sk-card sk-settings-card">
    <div class="sk-settings-card-header">
      <i class="fa fa-bullhorn"></i> Tombol Aksi (CTA)
    </div>
    <div class="sk-settings-card-body">
      <div class="sk-settings-row">
        <div class="sk-settings-field">
          <label class="sk-settings-label">Judul CTA</label>
          <input type="text" name="cta_judul" class="sk-settings-input" value="<?php echo htmlspecialchars($s['cta_judul']); ?>">
        </div>
        <div class="sk-settings-field">
          <label class="sk-settings-label">Deskripsi CTA</label>
          <input type="text" name="cta_deskripsi" class="sk-settings-input" value="<?php echo htmlspecialchars($s['cta_deskripsi']); ?>">
        </div>
      </div>
    </div>
  </div>

  <!-- Save Button -->
  <div class="sk-settings-actions">
    <button type="submit" class="sk-btn sk-btn-primary"><i class="fa fa-save"></i> Simpan Pengaturan</button>
  </div>

</form>

<?php include ("style/footer.php"); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save_settings') {
    ob_end_clean();

    // Text fields
    $text_fields = ['nama_koperasi','alamat','telepon','email','deskripsi','nama_pengurus','quote_pengurus','wa_pengurus','syarat_anggota','syarat_pinjaman','cta_judul','cta_deskripsi'];
    foreach ($text_fields as $f) {
        $val = mysqli_real_escape_string($konek, trim($_POST[$f] ?? ''));
        $key = mysqli_real_escape_string($konek, $f);
        mysqli_query($konek, "INSERT INTO tbl_settings (setting_key,setting_value) VALUES ('$key','$val') ON DUPLICATE KEY UPDATE setting_value='$val'");
    }

    // Logo upload
    if (!empty($_FILES['logo_file']['name']) && $_FILES['logo_file']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['logo_file']['name'], PATHINFO_EXTENSION));
        $allowed = ['png','jpg','jpeg','gif','svg'];
        if (in_array($ext, $allowed) && $_FILES['logo_file']['size'] <= 2 * 1024 * 1024) {
            $fname = 'logo_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['logo_file']['tmp_name'], $upload_dir . $fname)) {
                $path = mysqli_real_escape_string($konek, 'assets/uploads/' . $fname);
                mysqli_query($konek, "INSERT INTO tbl_settings (setting_key,setting_value) VALUES ('logo_path','$path') ON DUPLICATE KEY UPDATE setting_value='$path'");
            }
        }
    } elseif (!empty($_POST['hapus_logo'])) {
        mysqli_query($konek, "UPDATE tbl_settings SET setting_value='' WHERE setting_key='logo_path'");
    }

    // Foto hero upload
    if (!empty($_FILES['foto_hero_file']['name']) && $_FILES['foto_hero_file']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['foto_hero_file']['name'], PATHINFO_EXTENSION));
        $allowed = ['png','jpg','jpeg','gif','webp'];
        if (in_array($ext, $allowed) && $_FILES['foto_hero_file']['size'] <= 5 * 1024 * 1024) {
            $fname = 'hero_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['foto_hero_file']['tmp_name'], $upload_dir . $fname)) {
                $path = mysqli_real_escape_string($konek, 'assets/uploads/' . $fname);
                mysqli_query($konek, "INSERT INTO tbl_settings (setting_key,setting_value) VALUES ('foto_hero','$path') ON DUPLICATE KEY UPDATE setting_value='$path'");
            }
        }
    } elseif (!empty($_POST['hapus_foto_hero'])) {
        mysqli_query($konek, "UPDATE tbl_settings SET setting_value='' WHERE setting_key='foto_hero'");
    }

    // Foto pengurus upload
    if (!empty($_FILES['foto_pengurus_file']['name']) && $_FILES['foto_pengurus_file']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['foto_pengurus_file']['name'], PATHINFO_EXTENSION));
        $allowed = ['png','jpg','jpeg','gif','webp'];
        if (in_array($ext, $allowed) && $_FILES['foto_pengurus_file']['size'] <= 5 * 1024 * 1024) {
            $fname = 'pengurus_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['foto_pengurus_file']['tmp_name'], $upload_dir . $fname)) {
                $path = mysqli_real_escape_string($konek, 'assets/uploads/' . $fname);
                mysqli_query($konek, "INSERT INTO tbl_settings (setting_key,setting_value) VALUES ('foto_pengurus','$path') ON DUPLICATE KEY UPDATE setting_value='$path'");
            }
        }
    } elseif (!empty($_POST['hapus_foto_pengurus'])) {
        mysqli_query($konek, "UPDATE tbl_settings SET setting_value='' WHERE setting_key='foto_pengurus'");
    }

    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Pengaturan berhasil disimpan.'];
    header('Location: settings.php');
    exit;
}
ob_end_flush();
?>
