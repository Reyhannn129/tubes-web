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

## Cara Menjalankan
1. Import database `database.sql` ke MySQL.
2. Konfigurasi koneksi di `config/db.php`.
3. Jalankan server lokal:
   ```bash
   php -S localhost:3000
   ```
4. Buka `http://localhost:3000` di browser.
