<?php
require_once 'config/db.php';
require_once 'includes/functions.php';

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: katalog.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ? AND status != 'nonaktif'");
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$item) {
    header("Location: katalog.php");
    exit();
}

include 'includes/header.php';
?>

<div class="container reveal">
    <div class="detail-container glass-card">
        <div class="detail-img-wrap">
            <?php 
            $img_path = "assets/uploads/items/" . $item['gambar'];
            if(!file_exists($img_path) || empty($item['gambar'])) {
                echo '<div style="width:100%; height:400px; background:var(--card-dark); display:flex; align-items:center; justify-content:center; color:var(--text-muted);"><i class="fa-solid fa-image fa-5x"></i></div>';
            } else {
                echo '<img src="'.$img_path.'" alt="'.e($item['nama_barang']).'">';
            }
            ?>
        </div>
        <div class="detail-info">
            <div class="badge mb-2"><?php echo e($item['kategori']); ?></div>
            <h1 class="text-gradient"><?php echo e($item['nama_barang']); ?></h1>
            
            <div class="item-price" style="font-size: 2rem; margin: 20px 0;">
                <?php echo formatRupiah($item['harga_sewa']); ?>
                <span style="font-size: 1rem; color: var(--text-muted); font-weight: normal;">/ hari</span>
            </div>
            
            <div class="glass-card" style="padding: 15px; margin-bottom: 20px; display: inline-block;">
                <div class="item-stock">
                    <i class="fa-solid fa-box"></i> Stok Tersedia: <strong><?php echo $item['stok_tersedia']; ?></strong> dari <?php echo $item['stok_total']; ?>
                </div>
            </div>

            <h3 class="mb-2">Deskripsi Produk</h3>
            <p class="text-muted" style="white-space: pre-line; line-height: 1.8; margin-bottom: 30px;">
                <?php echo e($item['deskripsi']); ?>
            </p>

            <div style="display: flex; gap: 15px;">
                <?php if($item['stok_tersedia'] > 0): ?>
                    <a href="booking.php?item_id=<?php echo $item['id']; ?>" class="btn-primary glow-btn" style="flex: 1; text-align: center; font-size: 1.1rem; padding: 15px;">Booking Sekarang</a>
                <?php else: ?>
                    <button class="btn-primary" style="flex: 1; background: #555; cursor: not-allowed; padding: 15px;" disabled>Stok Habis</button>
                <?php endif; ?>
                <a href="katalog.php" class="btn-secondary" style="padding: 15px;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
