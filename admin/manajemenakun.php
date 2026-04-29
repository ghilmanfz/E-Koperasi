<?php
include ("style/header.php");
include ("style/sidebar.php");
include ("../config/koneksi.php");
?>

<!-- Page Header -->
<div class="sk-header-row">
  <div>
    <h1 class="sk-page-title">Manajemen Akun</h1>
    <p class="sk-page-subtitle">Kelola akun login seluruh pengguna sistem koperasi</p>
  </div>
  <div class="sk-page-actions">
    <button class="sk-btn sk-btn-primary" data-toggle-modal="modalTambah"><i class="fa fa-plus"></i> Tambah Akun</button>
  </div>
</div>

<!-- Table Card -->
<div class="sk-card">
  <div class="sk-card-header">
    <h5 class="sk-card-title"><i class="fa fa-users" style="color:#2563EB"></i>&nbsp; Daftar Akun Pengguna</h5>
  </div>
  <div class="sk-table-wrap">
    <table class="sk-table">
      <thead>
        <tr>
          <th>No</th>
          <th>Username</th>
          <th>Level</th>
          <th>ID Anggota</th>
          <th style="text-align:center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $current_user = $_SESSION['username'] ?? '';
        $sql = mysqli_query($konek, "SELECT * FROM tbl_login ORDER BY id ASC");
        while ($data = mysqli_fetch_assoc($sql)):
          $level_badge = '';
          switch ($data['level']) {
            case 'admin':      $level_badge = 'aktif';     break;
            case 'sekretaris': $level_badge = 'pokok';     break;
            case 'bendahara':  $level_badge = 'wajib';     break;
            case 'anggota':    $level_badge = 'non-aktif'; break;
            default:           $level_badge = 'non-aktif'; break;
          }
          $is_self = ($data['username'] === $current_user);
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td>
            <div class="sk-member-name">
              <?php echo htmlspecialchars($data['username']); ?>
              <?php if ($is_self): ?>
              <span class="sk-badge aktif" style="font-size:10px;margin-left:6px;">Anda</span>
              <?php endif; ?>
            </div>
          </td>
          <td><span class="sk-badge <?php echo $level_badge; ?>"><?php echo htmlspecialchars($data['level']); ?></span></td>
          <td><?php echo htmlspecialchars($data['id_anggota'] ?: '—'); ?></td>
          <td style="text-align:center;">
            <button class="sk-btn sk-btn-sm sk-btn-warning btn-edit-akun"
              data-id="<?php echo $data['id']; ?>"
              data-username="<?php echo htmlspecialchars($data['username'], ENT_QUOTES); ?>"
              data-level="<?php echo htmlspecialchars($data['level'], ENT_QUOTES); ?>"
              data-id-anggota="<?php echo htmlspecialchars($data['id_anggota'], ENT_QUOTES); ?>">
              <i class="fa fa-pencil"></i> Edit
            </button>
            <?php if (!$is_self): ?>
            <a href="hapusakun.php?id=<?php echo $data['id']; ?>"
               class="sk-btn sk-btn-sm sk-btn-danger"
               onclick="return confirm('Hapus akun <?php echo htmlspecialchars(addslashes($data['username'])); ?>? Tindakan ini tidak dapat dibatalkan.')">
              <i class="fa fa-trash"></i> Hapus
            </a>
            <?php else: ?>
            <button class="sk-btn sk-btn-sm sk-btn-danger" disabled title="Tidak bisa menghapus akun sendiri">
              <i class="fa fa-trash"></i> Hapus
            </button>
            <?php endif; ?>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ===== MODAL TAMBAH AKUN ===== -->
<div id="modalTambah" class="sk-modal-overlay" style="display:none;">
  <div class="sk-modal">
    <div class="sk-modal-header">
      <h4 class="sk-modal-title"><i class="fa fa-user-plus"></i> Tambah Akun Baru</h4>
      <button class="sk-modal-close" onclick="closeModal('modalTambah')">&times;</button>
    </div>
    <form method="POST" action="">
      <input type="hidden" name="action" value="tambah">
      <div class="sk-modal-body">
        <div class="form-group">
          <label class="sk-settings-label">Username</label>
          <input type="text" name="username" class="sk-settings-input" placeholder="Masukan username" required autocomplete="off">
        </div>
        <div class="form-group">
          <label class="sk-settings-label">Password</label>
          <input type="password" name="password" class="sk-settings-input" placeholder="Masukan password" required autocomplete="new-password">
        </div>
        <div class="form-group">
          <label class="sk-settings-label">Level</label>
          <select name="level" class="sk-settings-input">
            <option value="admin">admin</option>
            <option value="sekretaris">sekretaris</option>
            <option value="bendahara">bendahara</option>
            <option value="anggota" selected>anggota</option>
          </select>
        </div>
        <div class="form-group">
          <label class="sk-settings-label">ID Anggota <span style="color:#9ca3af;font-weight:400;">(opsional, untuk level anggota)</span></label>
          <input type="text" name="id_anggota" class="sk-settings-input" placeholder="Kosongkan jika bukan anggota">
        </div>
      </div>
      <div class="sk-modal-footer">
        <button type="button" class="sk-btn sk-btn-secondary" onclick="closeModal('modalTambah')">Batal</button>
        <button type="submit" class="sk-btn sk-btn-primary"><i class="fa fa-save"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- ===== MODAL EDIT AKUN ===== -->
<div id="modalEdit" class="sk-modal-overlay" style="display:none;">
  <div class="sk-modal">
    <div class="sk-modal-header">
      <h4 class="sk-modal-title"><i class="fa fa-pencil"></i> Edit Akun</h4>
      <button class="sk-modal-close" onclick="closeModal('modalEdit')">&times;</button>
    </div>
    <form method="POST" action="">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" name="edit_id" id="editId">
      <div class="sk-modal-body">
        <div class="form-group">
          <label class="sk-settings-label">Username</label>
          <input type="text" name="username" id="editUsername" class="sk-settings-input" required autocomplete="off">
        </div>
        <div class="form-group">
          <label class="sk-settings-label">Password Baru <span style="color:#9ca3af;font-weight:400;">(kosongkan jika tidak diubah)</span></label>
          <input type="password" name="password" class="sk-settings-input" placeholder="Kosongkan jika tidak diubah" autocomplete="new-password">
        </div>
        <div class="form-group">
          <label class="sk-settings-label">Level</label>
          <select name="level" id="editLevel" class="sk-settings-input">
            <option value="admin">admin</option>
            <option value="sekretaris">sekretaris</option>
            <option value="bendahara">bendahara</option>
            <option value="anggota">anggota</option>
          </select>
        </div>
        <div class="form-group">
          <label class="sk-settings-label">ID Anggota <span style="color:#9ca3af;font-weight:400;">(opsional)</span></label>
          <input type="text" name="id_anggota" id="editIdAnggota" class="sk-settings-input">
        </div>
      </div>
      <div class="sk-modal-footer">
        <button type="button" class="sk-btn sk-btn-secondary" onclick="closeModal('modalEdit')">Batal</button>
        <button type="submit" class="sk-btn sk-btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<?php
// ===== HANDLE POST =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';

  if ($action === 'tambah') {
    $username   = trim($_POST['username']   ?? '');
    $password   = trim($_POST['password']   ?? '');
    $level      = trim($_POST['level']      ?? 'anggota');
    $id_anggota = trim($_POST['id_anggota'] ?? '');

    $allowed_levels = ['admin', 'sekretaris', 'bendahara', 'anggota'];
    if ($username === '' || $password === '' || !in_array($level, $allowed_levels)) {
      $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Data tidak valid. Periksa kembali isian form.'];
    } else {
      $u  = mysqli_real_escape_string($konek, $username);
      $p  = mysqli_real_escape_string($konek, $password);
      $lv = mysqli_real_escape_string($konek, $level);
      $ia = mysqli_real_escape_string($konek, $id_anggota);

      // Check duplicate username
      $chk = mysqli_fetch_row(mysqli_query($konek, "SELECT COUNT(*) FROM tbl_login WHERE username='$u'"));
      if ((int)$chk[0] > 0) {
        $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Username sudah digunakan, pilih username lain.'];
      } else {
        $ins = mysqli_query($konek, "INSERT INTO tbl_login (id_anggota, username, password, level) VALUES ('$ia','$u','$p','$lv')");
        if ($ins) {
          $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Akun baru berhasil ditambahkan!'];
        } else {
          $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Gagal menambahkan akun: ' . mysqli_error($konek)];
        }
      }
    }
    header('Location: manajemenakun.php'); exit;
  }

  if ($action === 'edit') {
    $edit_id    = (int)($_POST['edit_id']    ?? 0);
    $username   = trim($_POST['username']    ?? '');
    $password   = trim($_POST['password']    ?? '');
    $level      = trim($_POST['level']       ?? '');
    $id_anggota = trim($_POST['id_anggota']  ?? '');

    $allowed_levels = ['admin', 'sekretaris', 'bendahara', 'anggota'];
    if ($edit_id <= 0 || $username === '' || !in_array($level, $allowed_levels)) {
      $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Data tidak valid.'];
    } else {
      $u  = mysqli_real_escape_string($konek, $username);
      $lv = mysqli_real_escape_string($konek, $level);
      $ia = mysqli_real_escape_string($konek, $id_anggota);

      // Check duplicate username excluding self
      $chk = mysqli_fetch_row(mysqli_query($konek, "SELECT COUNT(*) FROM tbl_login WHERE username='$u' AND id!=$edit_id"));
      if ((int)$chk[0] > 0) {
        $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Username sudah digunakan, pilih username lain.'];
      } else {
        if ($password !== '') {
          $p = mysqli_real_escape_string($konek, $password);
          $upd = mysqli_query($konek, "UPDATE tbl_login SET username='$u', password='$p', level='$lv', id_anggota='$ia' WHERE id=$edit_id");
        } else {
          $upd = mysqli_query($konek, "UPDATE tbl_login SET username='$u', level='$lv', id_anggota='$ia' WHERE id=$edit_id");
        }
        if ($upd) {
          $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Akun berhasil diperbarui!'];
        } else {
          $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Gagal memperbarui akun: ' . mysqli_error($konek)];
        }
      }
    }
    header('Location: manajemenakun.php'); exit;
  }
}
?>

<style>
/* ===== Modal Styles ===== */
.sk-modal-overlay {
  position: fixed; inset: 0; background: rgba(15,23,42,0.55);
  backdrop-filter: blur(4px); z-index: 1000;
  display: flex; align-items: center; justify-content: center;
}
.sk-modal {
  background: #fff; border-radius: 16px; width: 100%; max-width: 480px;
  box-shadow: 0 25px 60px rgba(0,0,0,0.2); overflow: hidden;
}
.sk-modal-header {
  display: flex; align-items: center; justify-content: space-between;
  padding: 20px 24px; border-bottom: 1px solid #e2e8f0;
  background: linear-gradient(135deg,#2563eb,#1d4ed8);
}
.sk-modal-title { color:#fff; margin:0; font-size:1rem; font-weight:600; }
.sk-modal-title i { margin-right:8px; }
.sk-modal-close {
  background: rgba(255,255,255,0.15); border: none; color:#fff;
  width:30px; height:30px; border-radius:8px; font-size:18px;
  cursor:pointer; display:flex; align-items:center; justify-content:center;
  transition:background .2s;
}
.sk-modal-close:hover { background:rgba(255,255,255,0.3); }
.sk-modal-body { padding: 24px; display:flex; flex-direction:column; gap:14px; }
.sk-modal-footer {
  padding: 16px 24px; border-top: 1px solid #e2e8f0;
  display:flex; justify-content:flex-end; gap:10px;
  background:#f8fafc;
}
.sk-btn-sm { padding: 6px 14px !important; font-size: 13px !important; }
.sk-btn-warning { background: linear-gradient(135deg,#f59e0b,#d97706); color:#fff; border:none; }
.sk-btn-warning:hover { background: linear-gradient(135deg,#d97706,#b45309); color:#fff; }
.sk-btn-danger  { background: linear-gradient(135deg,#ef4444,#dc2626); color:#fff; border:none; }
.sk-btn-danger:hover  { background: linear-gradient(135deg,#dc2626,#b91c1c); color:#fff; }
.sk-btn-danger[disabled] { opacity:0.45; cursor:not-allowed; }
.sk-btn-secondary { background:#e2e8f0; color:#475569; border:none; }
.sk-btn-secondary:hover { background:#cbd5e1; }
</style>

<script>
function closeModal(id){ document.getElementById(id).style.display='none'; }
function openModal(id){ document.getElementById(id).style.display='flex'; }

// Open tambah modal
document.querySelector('[data-toggle-modal="modalTambah"]').addEventListener('click',function(){
  openModal('modalTambah');
});

// Close modal on overlay click
['modalTambah','modalEdit'].forEach(function(id){
  document.getElementById(id).addEventListener('click',function(e){
    if(e.target===this){ closeModal(id); }
  });
});

// Edit buttons — populate and open edit modal
document.querySelectorAll('.btn-edit-akun').forEach(function(btn){
  btn.addEventListener('click',function(){
    document.getElementById('editId').value          = this.dataset.id;
    document.getElementById('editUsername').value    = this.dataset.username;
    document.getElementById('editLevel').value       = this.dataset.level;
    document.getElementById('editIdAnggota').value   = this.dataset.idAnggota;
    openModal('modalEdit');
  });
});

// Re-open modal with errors if flash was error on page load
<?php if (!empty($_SESSION['_reopen_modal'])): ?>
openModal('<?php echo $_SESSION['_reopen_modal']; ?>');
<?php unset($_SESSION['_reopen_modal']); endif; ?>
</script>

<?php include ("style/footer.php"); ?>
