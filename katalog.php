<?php
require_once 'config/db.php';
require_once 'includes/functions.php';
include 'includes/header.php';

// Ambil semua barang
$stmt = $pdo->query("SELECT * FROM items WHERE status != 'nonaktif' ORDER BY nama_barang ASC");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div style="padding-top: 100px;">
    <section class="container reveal">
        <div class="text-center mb-4">
            <h1 class="section-title"><span class="text-gradient">Katalog</span> Alat Outdoor</h1>
            <p class="text-muted">Pilih dan sewa alat sesuai dengan kebutuhan petualanganmu.</p>
        </div>

        <div class="catalog-grid mb-4">
            <?php foreach($items as $item): ?>
            <div class="item-card glass-card">
                <div class="item-img-container">
                    <span class="item-status <?php echo $item['stok_tersedia'] > 0 ? 'status-tersedia' : 'status-habis'; ?>">
                        <?php echo $item['stok_tersedia'] > 0 ? 'Tersedia' : 'Habis'; ?>
                    </span>
                    <?php 
                    $img_path = "assets/uploads/items/" . $item['gambar'];
                    if(!file_exists($img_path) || empty($item['gambar'])) {
                        echo '<div style="width:100%; height:100%; background:var(--card-dark); display:flex; align-items:center; justify-content:center; color:var(--text-muted);"><i class="fa-solid fa-image fa-3x"></i></div>';
                    } else {
                        echo '<img src="'.$img_path.'" alt="'.e($item['nama_barang']).'" class="item-img">';
                    }
                    ?>
                </div>
                <div class="item-details">
                    <div class="item-category"><?php echo e($item['kategori']); ?></div>
                    <h3 class="item-title"><?php echo e($item['nama_barang']); ?></h3>
                    <p class="text-muted" style="font-size:0.9rem; margin-bottom:10px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                        <?php echo e($item['deskripsi']); ?>
                    </p>
                    <div class="item-price"><?php echo formatRupiah($item['harga_sewa']); ?><span style="font-size:0.8rem;color:var(--text-muted);font-weight:normal;">/hari</span></div>
                    <div class="item-stock">Stok Tersedia: <strong><?php echo $item['stok_tersedia']; ?></strong> / <?php echo $item['stok_total']; ?></div>
                    <div class="item-actions">
                        <a href="detail.php?id=<?php echo $item['id']; ?>" class="btn-secondary">Detail</a>
                        <?php if($item['stok_tersedia'] > 0): ?>
                            <a href="booking.php?item_id=<?php echo $item['id']; ?>" class="btn-primary">Booking</a>
                        <?php else: ?>
                            <button class="btn-primary" style="background:#555;cursor:not-allowed;" disabled>Habis</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if(empty($items)): ?>
            <div class="glass-card text-center" style="padding: 50px;">
                <i class="fa-solid fa-box-open fa-4x text-muted mb-2"></i>
                <h3>Katalog Kosong</h3>
                <p class="text-muted">Belum ada alat yang tersedia saat ini.</p>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php include 'includes/footer.php'; ?>
