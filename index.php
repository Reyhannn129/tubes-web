<?php
require_once "config/db.php";
require_once "includes/functions.php";
include "includes/header.php";

// Ambil 4 barang terbaru/populer
$stmt = $pdo->query(
  "SELECT * FROM items WHERE status != 'nonaktif' ORDER BY id DESC LIMIT 4",
);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil statistik (contoh data dinamis & statis)
$total_items = $pdo->query("SELECT COUNT(*) FROM items")->fetchColumn();
$total_rentals = $pdo->query("SELECT COUNT(*) FROM rentals")->fetchColumn();
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container" style="display: flex; align-items: center; justify-content: space-between;">
        <div class="hero-content reveal">
            <span class="badge" style="color: var(--primary); background: transparent; padding: 0; margin-bottom: 15px; border: none; font-size: 1.1rem;">Best Outdoor Rental</span>
            <h1 style="color: #2F3B59;">Sewa Alat Outdoor <br><span style="color: var(--primary);">Lebih Mudah</span></h1>
            <p>Jelajahi alam bebas tanpa repot memikirkan perlengkapan. Kami menyediakan alat outdoor berkualitas dengan proses booking yang cepat, aman, dan real-time.</p>
            <div class="hero-buttons">
                <a href="<?php echo $base_url; ?>katalog.php" class="btn-primary" style="border-radius: 50px;">Lihat Katalog <i class="fa-solid fa-arrow-right"></i></a>
                <a href="#cara-sewa" class="btn-secondary" style="border-radius: 50px;">Cara Booking <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
        <div class="hero-visual reveal">
            <!-- Icon/Image Placeholder for Hero -->
            <div style="font-size: 15rem; color: #F48C45; text-align: center; filter: drop-shadow(0 0 20px rgba(244, 140, 69, 0.5));">
                <i class="fa-solid fa-tent"></i>
            </div>

        </div>
    </div>
</section>

<!-- Keunggulan -->
<section id="keunggulan" class="container reveal">
    <h2 class="section-title text-center">Kenapa Memilih <span class="text-gradient">VentureGear</span>?</h2>
    <div class="features-grid">
        <div class="feature-card glass-card">
            <i class="fa-solid fa-user-clock feature-icon"></i>
            <h3>Tanpa Login</h3>
            <p class="text-muted mt-1">Proses booking cepat tanpa harus membuat akun atau login terlebih dahulu.</p>
        </div>
        <div class="feature-card glass-card">
            <i class="fa-solid fa-boxes-stacked feature-icon"></i>
            <h3>Stok Real-Time</h3>
            <p class="text-muted mt-1">Ketersediaan barang yang Anda lihat selalu akurat dan diperbarui secara otomatis.</p>
        </div>
        <div class="feature-card glass-card">
            <i class="fa-solid fa-money-bill-transfer feature-icon"></i>
            <h3>Pembayaran Aman</h3>
            <p class="text-muted mt-1">Cukup upload bukti transfer DP, kami akan mengamankan barang Anda.</p>
        </div>
        <div class="feature-card glass-card">
            <i class="fa-solid fa-check-double feature-icon"></i>
            <h3>Verifikasi Cepat</h3>
            <p class="text-muted mt-1">Admin kami memverifikasi pembayaran Anda dengan cepat agar transaksi lancar.</p>
        </div>
    </div>
</section>

<!-- Cara Sewa -->
<section id="cara-sewa" class="container reveal">
    <h2 class="section-title text-center">Cara <span class="text-gradient">Pemesanan</span></h2>
    <div class="steps-container">
        <div class="step-card">
            <div class="step-number">1</div>
            <h3>Pilih Alat</h3>
            <p class="text-muted mt-1">Cari dan pilih alat outdoor yang sesuai kebutuhanmu di katalog.</p>
        </div>
        <div class="step-card">
            <div class="step-number">2</div>
            <h3>Isi Form</h3>
            <p class="text-muted mt-1">Lengkapi data diri dan tentukan tanggal peminjaman barang.</p>
        </div>
        <div class="step-card">
            <div class="step-number">3</div>
            <h3>Upload DP</h3>
            <p class="text-muted mt-1">Lakukan pembayaran DP dan upload bukti transfer melalui form.</p>
        </div>
        <div class="step-card">
            <div class="step-number">4</div>
            <h3>Tunggu Verifikasi</h3>
            <p class="text-muted mt-1">Admin akan memverifikasi. Jika disetujui, barang siap diambil!</p>
        </div>
    </div>
</section>

<!-- Katalog Populer -->
<section id="katalog" class="container reveal">
    <h2 class="section-title text-center">Katalog <span class="text-gradient">Populer</span></h2>
    <div class="catalog-grid">
        <?php foreach ($items as $item): ?>
        <div class="item-card glass-card">
            <div class="item-img-container">
                <span class="item-status <?php echo $item["stok_tersedia"] > 0
                  ? "status-tersedia"
                  : "status-habis"; ?>">
                    <?php echo $item["stok_tersedia"] > 0
                      ? "Tersedia"
                      : "Habis"; ?>
                </span>
                <?php
                $img_path = "assets/uploads/items/" . $item["gambar"];
                if (!file_exists($img_path) || empty($item["gambar"])) {
                  // Fallback to placeholder if image doesn't exist
                  echo '<div style="width:100%; height:100%; background:var(--card-dark); display:flex; align-items:center; justify-content:center; color:var(--text-muted);"><i class="fa-solid fa-image fa-3x"></i></div>';
                } else {
                  echo '<img src="' .
                    $img_path .
                    '" alt="' .
                    e($item["nama_barang"]) .
                    '" class="item-img">';
                }
                ?>
            </div>
            <div class="item-details">
                <div class="item-category"><?php echo e(
                  $item["kategori"],
                ); ?></div>
                <h3 class="item-title"><?php echo e(
                  $item["nama_barang"],
                ); ?></h3>
                <div class="item-price"><?php echo formatRupiah(
                  $item["harga_sewa"],
                ); ?><span style="font-size:0.8rem;color:var(--text-muted);font-weight:normal;">/hari</span></div>
                <div class="item-stock">Stok Tersedia: <strong><?php echo $item[
                  "stok_tersedia"
                ]; ?></strong> / <?php echo $item["stok_total"]; ?></div>
                <div class="item-actions">
                    <a href="detail.php?id=<?php echo $item[
                      "id"
                    ]; ?>" class="btn-secondary">Detail</a>
                    <?php if ($item["stok_tersedia"] > 0): ?>
                        <a href="booking.php?item_id=<?php echo $item[
                          "id"
                        ]; ?>" class="btn-primary">Booking</a>
                    <?php else: ?>
                        <button class="btn-primary" style="background:#555;cursor:not-allowed;" disabled>Habis</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
        <a href="katalog.php" class="btn-primary glow-btn" style="padding: 12px 30px; font-size: 1.1rem;">Lihat Semua Alat <i class="fa-solid fa-arrow-right"></i></a>
    </div>
</section>

<!-- Statistik -->
<section id="statistik" class="container reveal">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_items + 20; ?>+</div>
            <div class="text-muted">Alat Outdoor</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_rentals + 150; ?>+</div>
            <div class="text-muted">Transaksi Sewa</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">24/7</div>
            <div class="text-muted">Layanan Online</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">98%</div>
            <div class="text-muted">Pelanggan Puas</div>
        </div>
    </div>
</section>

<!-- Kontak -->
<section id="kontak" class="container reveal mb-4">
    <div class="contact-box">
        <h2 class="section-title">Butuh Bantuan?</h2>
        <p class="text-muted mb-4">Tim admin kami siap membantu Anda 24 jam untuk segala kebutuhan penyewaan.</p>
        <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            <a href="#" class="btn-primary glow-btn"><i class="fa-brands fa-whatsapp"></i> Chat WhatsApp</a>
            <a href="#" class="btn-secondary"><i class="fa-brands fa-instagram"></i> Follow Instagram</a>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>
