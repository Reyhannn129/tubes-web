<?php
require_once '../includes/auth.php';
cekLogin();
require_once '../config/db.php';

if(!isset($_GET['id'])) {
    header("Location: items.php");
    exit();
}
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$item){
    header("Location: items.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga_sewa'];
    $stok_total_baru = $_POST['stok_total'];
    $status = $_POST['status'];
    $deskripsi = $_POST['deskripsi'];

    // Hitung stok tersedia (total baru - (total lama - tersedia lama))
    // Asumsi: yang dipinjam adalah selisih stok_total lama dan stok_tersedia lama
    $dipinjam = $item['stok_total'] - $item['stok_tersedia'];
    $stok_tersedia_baru = $stok_total_baru - $dipinjam;
    
    // Jika stok tersedia <= 0 otomatis status habis
    if($stok_tersedia_baru <= 0) {
        $stok_tersedia_baru = 0;
        $status = 'habis';
    }

    $gambar = $item['gambar'];
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $gambar = time().'_'.rand(100,999).'.'.$ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], '../assets/uploads/items/'.$gambar);
        // Hapus gambar lama jika ada
        if($item['gambar'] && file_exists('../assets/uploads/items/'.$item['gambar'])) {
            unlink('../assets/uploads/items/'.$item['gambar']);
        }
    }

    $stmt = $pdo->prepare("UPDATE items SET nama_barang=?, kategori=?, harga_sewa=?, stok_total=?, stok_tersedia=?, status=?, deskripsi=?, gambar=? WHERE id=?");
    $stmt->execute([$nama, $kategori, $harga, $stok_total_baru, $stok_tersedia_baru, $status, $deskripsi, $gambar, $id]);

    header("Location: items.php?msg=updated");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - VentureGear</title>
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
            <h2>Edit Barang</h2>
        </div>
        <div>
            <a href="items.php" class="btn-secondary">Kembali</a>
        </div>
    </div>

    <div class="glass-card" style="padding: 30px; max-width: 800px;">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" value="<?php echo htmlspecialchars($item['nama_barang']); ?>" required>
            </div>
            <div class="form-group" style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                <div>
                    <label>Kategori</label>
                    <select name="kategori" required>
                        <option value="Tenda" <?php if($item['kategori']=='Tenda') echo 'selected';?>>Tenda</option>
                        <option value="Tas" <?php if($item['kategori']=='Tas') echo 'selected';?>>Tas / Carrier</option>
                        <option value="Perlengkapan Tidur" <?php if($item['kategori']=='Perlengkapan Tidur') echo 'selected';?>>Perlengkapan Tidur</option>
                        <option value="Peralatan Masak" <?php if($item['kategori']=='Peralatan Masak') echo 'selected';?>>Peralatan Masak</option>
                        <option value="Pakaian" <?php if($item['kategori']=='Pakaian') echo 'selected';?>>Pakaian / Jaket</option>
                        <option value="Aksesoris" <?php if($item['kategori']=='Aksesoris') echo 'selected';?>>Aksesoris (Lampu, Pole, dll)</option>
                    </select>
                </div>
                <div>
                    <label>Harga Sewa / Hari</label>
                    <input type="number" name="harga_sewa" value="<?php echo $item['harga_sewa']; ?>" required min="0">
                </div>
            </div>
            <div class="form-group" style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                <div>
                    <label>Stok Total</label>
                    <input type="number" name="stok_total" value="<?php echo $item['stok_total']; ?>" required min="1">
                    <small class="text-muted">Stok tersedia saat ini: <?php echo $item['stok_tersedia']; ?></small>
                </div>
                <div>
                    <label>Status Barang</label>
                    <select name="status">
                        <option value="tersedia" <?php if($item['status']=='tersedia') echo 'selected';?>>Tersedia</option>
                        <option value="habis" <?php if($item['status']=='habis') echo 'selected';?>>Habis</option>
                        <option value="nonaktif" <?php if($item['status']=='nonaktif') echo 'selected';?>>Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Ganti Gambar (Kosongkan jika tidak diganti)</label>
                <input type="file" name="gambar" accept="image/*">
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="5" required><?php echo htmlspecialchars($item['deskripsi']); ?></textarea>
            </div>
            <button type="submit" class="btn-primary glow-btn w-100">Update Barang</button>
        </form>
    </div>
</div>
</body>
</html>
