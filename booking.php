<?php
require_once 'config/db.php';
require_once 'includes/functions.php';

if(!isset($_GET['item_id']) || empty($_GET['item_id'])) {
    header("Location: katalog.php");
    exit();
}

$item_id = $_GET['item_id'];
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ? AND stok_tersedia > 0 AND status != 'nonaktif'");
$stmt->execute([$item_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$item) {
    header("Location: katalog.php?error=stok_habis");
    exit();
}

include 'includes/header.php';
?>

<div style="padding-top: 100px;">
    <section class="container reveal">
        <div class="detail-container" style="margin-top: 0; padding-top: 20px;">
            <div class="glass-card" style="padding: 30px;">
                <h2 class="section-title text-gradient mb-4">Informasi Barang</h2>
                <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 20px;">
                    <div style="width: 100px; height: 100px; border-radius: 8px; overflow: hidden; background: var(--card-dark);">
                        <?php if($item['gambar'] && file_exists("assets/uploads/items/".$item['gambar'])): ?>
                            <img src="assets/uploads/items/<?php echo $item['gambar']; ?>" alt="img" style="width:100%; height:100%; object-fit:cover;">
                        <?php else: ?>
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:var(--text-muted);"><i class="fa-solid fa-image fa-2x"></i></div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <div class="badge"><?php echo e($item['kategori']); ?></div>
                        <h3 class="mt-1"><?php echo e($item['nama_barang']); ?></h3>
                        <div class="text-cyan-soft" style="font-weight: bold; margin-top: 5px;"><?php echo formatRupiah($item['harga_sewa']); ?> / hari</div>
                    </div>
                </div>
                <hr style="border-color: var(--glass-border); margin-bottom: 20px;">
                <h3 class="mb-2">Total Pembayaran (DP)</h3>
                <div id="displayDp" style="font-size: 2.5rem; font-weight: bold; color: var(--primary); text-shadow: var(--glow-shadow);">
                    Rp 0
                </div>
                <p class="text-muted mt-2"><i class="fa-solid fa-circle-info"></i> Silakan isi tanggal peminjaman untuk melihat total biaya yang harus ditransfer sebagai DP.</p>
                <div class="mt-4 p-3 glass-card bg-info">
                    <strong>Rekening Pembayaran:</strong><br>
                    BCA: 1234567890 a.n VentureGear<br>
                    Mandiri: 0987654321 a.n VentureGear
                </div>
            </div>

            <div class="glass-card" style="padding: 30px;">
                <h2 class="section-title text-gradient mb-4">Formulir Booking</h2>
                
                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger mb-4">
                        <i class="fa-solid fa-circle-exclamation"></i> 
                        <?php 
                        if($_GET['error'] == 'input_tidak_valid') echo 'Data yang diinput tidak valid, silakan periksa kembali.';
                        elseif($_GET['error'] == 'file_terlalu_besar') echo 'Ukuran bukti bayar maksimal 2 MB.';
                        elseif($_GET['error'] == 'format_file_salah') echo 'Format bukti bayar hanya boleh JPG, JPEG, PNG, PDF.';
                        elseif($_GET['error'] == 'upload_gagal') echo 'Gagal mengupload bukti bayar.';
                        ?>
                    </div>
                <?php endif; ?>

                <form id="bookingForm" action="booking_process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                    <input type="hidden" id="hargaSewa" value="<?php echo $item['harga_sewa']; ?>">
                    <input type="hidden" id="hiddenDp" name="total_dp" value="0">

                    <div class="form-group">
                        <label for="nama_pelanggan">Nama Lengkap</label>
                        <input type="text" id="nama_pelanggan" name="nama_pelanggan" required placeholder="Sesuai KTP">
                    </div>

                    <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label for="nik">NIK (16 Digit)</label>
                            <input type="text" id="nik" name="nik" required placeholder="Contoh: 3201..." maxlength="16">
                        </div>
                        <div>
                            <label for="no_hp">No. WhatsApp</label>
                            <input type="text" id="no_hp" name="no_hp" required placeholder="Contoh: 0812...">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat Lengkap</label>
                        <textarea id="alamat" name="alamat" required rows="3" placeholder="Alamat pengiriman / domisili"></textarea>
                    </div>

                    <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label for="tgl_pinjam">Tanggal Peminjaman</label>
                            <input type="date" id="tgl_pinjam" name="tgl_pinjam" required>
                        </div>
                        <div>
                            <label for="tgl_kembali">Tanggal Pengembalian</label>
                            <input type="date" id="tgl_kembali" name="tgl_kembali" required>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <label for="bukti_bayar">Upload Bukti Transfer DP</label>
                        <input type="file" id="bukti_bayar" name="bukti_bayar" accept=".jpg, .jpeg, .png, .pdf" required>
                        <small class="text-muted">Format: JPG, PNG, PDF. Max: 2MB.</small>
                    </div>

                    <button type="submit" class="btn-primary glow-btn w-100 mt-4" style="padding: 15px; font-size: 1.1rem;">Submit Booking</button>
                </form>
            </div>
        </div>
    </section>
</div>

<script src="<?php echo $base_url; ?>assets/js/booking-validation.js"></script>
<?php include 'includes/footer.php'; ?>
