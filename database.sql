CREATE DATABASE IF NOT EXISTS venturegear;
USE venturegear;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_admin VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(100) NOT NULL,
    deskripsi TEXT NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    harga_sewa DECIMAL(10, 2) NOT NULL,
    gambar VARCHAR(255) NOT NULL,
    stok_total INT NOT NULL,
    stok_tersedia INT NOT NULL,
    status ENUM('tersedia', 'habis', 'nonaktif') DEFAULT 'tersedia',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rentals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    nama_pelanggan VARCHAR(100) NOT NULL,
    nik VARCHAR(20) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    alamat TEXT NOT NULL,
    tgl_pinjam DATE NOT NULL,
    tgl_kembali DATE NOT NULL,
    total_dp DECIMAL(10, 2) NOT NULL,
    bukti_bayar VARCHAR(255) NOT NULL,
    status_pembayaran ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    status_booking ENUM('menunggu', 'disetujui', 'ditolak', 'selesai') DEFAULT 'menunggu',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE
);

-- Insert dummy data
-- Default admin password is 'admin123'
INSERT INTO admins (username, password, nama_admin) 
VALUES ('admin', '$2y$10$eE6W2Y5G0b8X6qI4T3.O9.pC/.5V7Wc13Q2jZ6x4G1D2p2g0p8JpW', 'Super Admin');

INSERT INTO items (nama_barang, deskripsi, kategori, harga_sewa, gambar, stok_total, stok_tersedia, status) VALUES
('Tenda Dome 4 Orang', 'Tenda dome kapasitas 4 orang, double layer, tahan hujan dan angin.', 'Tenda', 50000, 'tenda_dome.jpg', 10, 10, 'tersedia'),
('Carrier 60L', 'Tas gunung berkapasitas 60 liter dengan backsystem nyaman.', 'Tas', 40000, 'carrier_60l.jpg', 15, 15, 'tersedia'),
('Sleeping Bag', 'Sleeping bag polar tebal, cocok untuk suhu dingin ekstrem.', 'Perlengkapan Tidur', 15000, 'sleeping_bag.jpg', 30, 30, 'tersedia'),
('Kompor Portable', 'Kompor lipat kecil anti badai, sudah termasuk wind shield.', 'Peralatan Masak', 20000, 'kompor.jpg', 20, 20, 'tersedia'),
('Matras Camping', 'Matras karet spons tebal 3mm, nyaman untuk alas tidur di tenda.', 'Perlengkapan Tidur', 10000, 'matras.jpg', 40, 40, 'tersedia'),
('Trekking Pole', 'Trekking pole aluminium alloy ringan dan kuat.', 'Aksesoris', 15000, 'trekking_pole.jpg', 25, 25, 'tersedia');

-- Dummy rentals (dates adjusted for example)
INSERT INTO rentals (item_id, nama_pelanggan, nik, no_hp, alamat, tgl_pinjam, tgl_kembali, total_dp, bukti_bayar, status_pembayaran, status_booking) VALUES
(1, 'Budi Santoso', '3201234567890001', '081234567890', 'Jl. Merdeka No. 10', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 2 DAY), 100000, 'dummy_bayar_1.jpg', 'verified', 'disetujui'),
(2, 'Andi Hidayat', '3201234567890002', '081987654321', 'Jl. Sudirman No. 20', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 DAY), 40000, 'dummy_bayar_2.jpg', 'pending', 'menunggu'),
(3, 'Siti Aminah', '3201234567890003', '085612349876', 'Jl. Ahmad Yani No. 5', DATE_ADD(CURDATE(), INTERVAL 1 DAY), DATE_ADD(CURDATE(), INTERVAL 3 DAY), 30000, 'dummy_bayar_3.jpg', 'rejected', 'ditolak');

-- Update stock based on approved rental
UPDATE items SET stok_tersedia = stok_tersedia - 1 WHERE id = 1;
