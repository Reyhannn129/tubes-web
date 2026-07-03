# VentureGear - Modern Outdoor Rental (Progress 1)

Website penyewaan alat outdoor berbasis PHP Native (Progress Tahap 1 - Tanpa Fitur Admin).

## Fitur (User Side Only)
* **Katalog Barang**: Menampilkan daftar perlengkapan outdoor aktif dengan status ketersediaan stok yang real-time.
* **Detail Barang**: Informasi lengkap mengenai alat outdoor yang dipilih.
* **Booking Online**: Proses pemesanan alat sewa secara langsung tanpa perlu membuat akun / login terlebih dahulu.
* **Statistik & Informasi**: Menampilkan keunggulan, petunjuk cara sewa, kontak admin, dan statistik penyewaan.

## Struktur Project
* `/assets/` - Asset CSS, JS, dan Gambar.
* `/config/` - Konfigurasi koneksi database.
* `/includes/` - Potongan file layout (header & footer).
* `index.php` - Halaman utama / landing page.
* `katalog.php` - Daftar semua katalog barang.
* `detail.php` - Halaman informasi detail barang.
* `booking.php` - Form pemesanan barang.
* `booking_process.php` - Logika pemrosesan booking & upload DP.
* `booking_success.php` - Halaman bukti transaksi sewa berhasil.

# Modern Outdoor Rental (Progress 2)

## Fitur

### User Side
* **Katalog Barang**: Menampilkan daftar perlengkapan outdoor aktif dengan status ketersediaan stok yang real-time.
* **Detail Barang**: Informasi lengkap mengenai alat outdoor yang dipilih.
* **Booking Online**: Proses pemesanan alat sewa secara langsung tanpa perlu membuat akun / login terlebih dahulu.
* **Statistik & Informasi**: Menampilkan keunggulan, petunjuk cara sewa, kontak admin, dan statistik penyewaan.

### Admin Panel
* **Login Admin**: Sistem autentikasi admin dengan session management.
* **Dashboard**: Ringkasan statistik penyewaan dan overview data.
* **Manajemen Barang**: Tambah, edit, dan hapus data perlengkapan outdoor (CRUD).
* **Manajemen Penyewaan**: Daftar semua transaksi booking masuk.
* **Approval Booking**: Approve atau reject permintaan penyewaan dari pelanggan.

## Struktur Project
* `/assets/` - Asset CSS, JS, dan Gambar.
* `/config/` - Konfigurasi koneksi database.
* `/includes/` - Potongan file layout (header, footer, auth, functions).
* `/admin/` - Halaman admin panel.
  * `login.php` - Halaman login admin.
  * `login_process.php` - Logika proses autentikasi.
  * `logout.php` - Proses logout admin.
  * `dashboard.php` - Dashboard utama admin.
  * `items.php` - Daftar manajemen barang.
  * `item_add.php` - Tambah barang baru.
  * `item_edit.php` - Edit data barang.
  * `item_delete.php` - Hapus barang.
  * `rentals.php` - Daftar transaksi penyewaan.
  * `approve.php` - Proses approve booking.
  * `reject.php` - Proses reject booking.
* `index.php` - Halaman utama / landing page.
* `katalog.php` - Daftar semua katalog barang.
* `detail.php` - Halaman informasi detail barang.
* `booking.php` - Form pemesanan barang.
* `booking_process.php` - Logika pemrosesan booking & upload DP.
* `booking_success.php` - Halaman bukti transaksi sewa berhasil.
* `seed_admin.php` - Script seeder akun admin.

## Cara Menjalankan
1. Import database `database.sql` ke MySQL.
2. Konfigurasi koneksi di `config/db.php`.
3. Jalankan `seed_admin.php` untuk membuat akun admin awal.
4. Jalankan server lokal:
   ```bash
   php -S localhost:3000
   ```
5. Buka `http://localhost:3000` di browser.
6. Akses admin panel di `http://localhost:3000/admin/login.php`.

## Cara Menjalankan
1. Import database `database.sql` ke MySQL.
2. Konfigurasi koneksi di `config/db.php`.
3. Jalankan server lokal:
   ```bash
   php -S localhost:3000
   ```
4. Buka `http://localhost:3000` di browser.
