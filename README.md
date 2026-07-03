# VentureGear - Modern Outdoor Rental

Website penyewaan alat outdoor berbasis PHP Native.

---

## Progress 1 - User Side (Tanpa Fitur Admin)

### Fitur
* **Katalog Barang**: Menampilkan daftar perlengkapan outdoor aktif dengan status ketersediaan stok yang real-time.
* **Detail Barang**: Informasi lengkap mengenai alat outdoor yang dipilih.
* **Booking Online**: Proses pemesanan alat sewa secara langsung tanpa perlu membuat akun / login terlebih dahulu.
* **Statistik & Informasi**: Menampilkan keunggulan, petunjuk cara sewa, kontak admin, dan statistik penyewaan.

### Struktur Project
* `/assets/` - Asset CSS, JS, dan Gambar.
* `/config/` - Konfigurasi koneksi database.
* `/includes/` - Potongan file layout (header & footer).
* `index.php` - Halaman utama / landing page.
* `katalog.php` - Daftar semua katalog barang.
* `detail.php` - Halaman informasi detail barang.
* `booking.php` - Form pemesanan barang.
* `booking_process.php` - Logika pemrosesan booking & upload DP.
* `booking_success.php` - Halaman bukti transaksi sewa berhasil.

### Cara Menjalankan
1. Import database `database.sql` ke MySQL.
2. Konfigurasi koneksi di `config/db.php`.
3. Jalankan server lokal:
   ```bash
   php -S localhost:3000
   ```
4. Buka `http://localhost:3000` di browser.

---

## Progress 2 - Admin Panel

### Fitur Baru
* **Login Admin**: Sistem autentikasi admin dengan session management.
* **Dashboard**: Ringkasan statistik penyewaan dan overview data.
* **Manajemen Barang**: Tambah, edit, dan hapus data perlengkapan outdoor (CRUD).
* **Manajemen Penyewaan**: Daftar semua transaksi booking masuk.
* **Approval Booking**: Approve atau reject permintaan penyewaan dari pelanggan.

### File Baru
* `/includes/auth.php` - Middleware autentikasi admin.
* `/includes/functions.php` - Helper functions.
* `/admin/login.php` - Halaman login admin.
* `/admin/login_process.php` - Logika proses autentikasi.
* `/admin/logout.php` - Proses logout admin.
* `/admin/dashboard.php` - Dashboard utama admin.
* `/admin/items.php` - Daftar manajemen barang.
* `/admin/item_add.php` - Tambah barang baru.
* `/admin/item_edit.php` - Edit data barang.
* `/admin/item_delete.php` - Hapus barang.
* `/admin/rentals.php` - Daftar transaksi penyewaan.
* `/admin/approve.php` - Proses approve booking.
* `/admin/reject.php` - Proses reject booking.
* `seed_admin.php` - Script seeder akun admin.

### Cara Menjalankan Admin
1. Jalankan `seed_admin.php` untuk membuat akun admin awal.
2. Akses admin panel di `http://localhost:3000/admin/login.php`.
