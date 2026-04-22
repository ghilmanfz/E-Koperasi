# Sistem Informasi Simpan Pinjam Koperasi

Aplikasi web untuk pengelolaan data koperasi simpan pinjam, meliputi data anggota, simpanan, pinjaman, angsuran, pengambilan, dan laporan.

## Ringkasan

Proyek ini dibangun menggunakan PHP dan MySQL dengan tampilan berbasis AdminLTE (Bootstrap 3). Pada halaman utama sudah diterapkan landing page modern untuk tampilan publik, sementara halaman manajemen internal tetap menggunakan layout dashboard/sidebar.

## Fitur Utama

- Landing page publik (home, syarat, alur, kontak)
- Manajemen data anggota
- Manajemen simpanan dan tabungan
- Manajemen pinjaman dan pembayaran angsuran
- Riwayat simpanan, pinjaman, angsuran, dan pengambilan
- Laporan dan cetak laporan (sekretaris dan bendahara)
- Otentikasi login/logout

## Teknologi

- PHP (direkomendasikan kompatibel dengan basis kode lama, minimal PHP 5.6)
- MySQL / MariaDB
- Bootstrap 3
- AdminLTE
- Font Awesome

## Struktur Folder Singkat

- anggota/: Modul data dan riwayat anggota
- bendahara/: Laporan dan cetak untuk bendahara
- sekretaris/: CRUD data operasional koperasi
- config/: Konfigurasi database
- database/: File SQL untuk inisialisasi database
- assets/: CSS, JS, font, dan aset tampilan
- style/: Komponen layout global (header, sidebar, footer)

## Cara Menjalankan (Lokal)

1. Letakkan folder proyek di web root server lokal (contoh: Laragon www atau XAMPP htdocs).
2. Buat database baru, misalnya koperasi_bmt.
3. Import file SQL dari database/koperasi_bmt.sql.
4. Atur koneksi database pada file config/koneksi.php sesuai host, user, password, dan nama database Anda.
5. Jalankan server Apache + MySQL.
6. Akses aplikasi melalui browser:

	http://localhost/koperasi-nur/

## Akun dan Akses

Silakan cek data user awal pada SQL seed (database/koperasi_bmt.sql) atau modul terkait login untuk memastikan kredensial default di lingkungan Anda.

## Catatan

- Halaman profil lama (profil.php) sudah dihapus dari proyek.
- Seluruh tautan yang mengarah ke halaman tersebut sudah diperbarui.
- Jika menggunakan PHP versi terbaru, tetap uji fungsi utama (login, CRUD, laporan) untuk memastikan kompatibilitas lingkungan.

## Lisensi

Proyek ini digunakan untuk kebutuhan akademik/pengembangan internal. Sesuaikan kebijakan lisensi sesuai kebutuhan institusi Anda.
