<?php
require_once '../includes/auth.php';
cekLogin();
require_once '../config/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga_sewa'];
    $stok = $_POST['stok_total'];
    $status = $stok > 0 ? 'tersedia' : 'habis';
    $deskripsi = $_POST['deskripsi'];

    // Handle File Upload
    $gambar = '';
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $gambar = time().'_'.rand(100,999).'.'.$ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], '../assets/uploads/items/'.$gambar);
    }

    $stmt = $pdo->prepare("INSERT INTO items (nama_barang, kategori, harga_sewa, stok_total, stok_tersedia, status, deskripsi, gambar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $kategori, $harga, $stok, $stok, $status, $deskripsi, $gambar]);

    header("Location: items.php?msg=added");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - VentureGear</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
<div class="sidebar">
    <div class="sidebar-logo text-gradient">
        <img src="../assets/images/logo_transparant.png" alt="VentureGear Logo">
    </div>
    <div class="sidebar-menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="items.php" class="active">Kelola Barang</a>
        <a href="rentals.php">Kelola Booking</a>
    </div>
    <div class="sidebar-footer">
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="main-content">
    <div class="admin-header">
        <div class="admin-title">
            <h2>Tambah Barang</h2>
        </div>
        <div>
            <a href="items.php" class="btn-secondary">Kembali</a>
        </div>
    </div>

    <div class="glass-card" style="padding: 30px; max-width: 800px;">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" required>
            </div>
            <div class="form-group" style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                <div>
                    <label>Kategori</label>
                    <select name="kategori" required>
                        <option value="Tenda">Tenda</option>
                        <option value="Tas">Tas / Carrier</option>
                        <option value="Perlengkapan Tidur">Perlengkapan Tidur</option>
                        <option value="Peralatan Masak">Peralatan Masak</option>
                        <option value="Pakaian">Pakaian / Jaket</option>
                        <option value="Aksesoris">Aksesoris (Lampu, Pole, dll)</option>
                    </select>
                </div>
                <div>
                    <label>Harga Sewa / Hari</label>
                    <input type="number" name="harga_sewa" required min="0">
                </div>
            </div>
            <div class="form-group">
                <label>Stok Total</label>
                <input type="number" name="stok_total" required min="1">
            </div>
            <div class="form-group">
                <label>Upload Gambar Barang</label>
                <input type="file" name="gambar" accept="image/*" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn-primary glow-btn w-100">Simpan Barang</button>
        </form>
    </div>
</div>
</body>
</html>
