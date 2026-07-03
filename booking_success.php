<?php
require_once 'config/db.php';
include 'includes/header.php';
?>

<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding-top: 80px;">
    <div class="glass-card text-center reveal" style="padding: 60px 40px; max-width: 500px; width: 100%; border-color: var(--primary);">
        <div style="font-size: 5rem; color: var(--primary); margin-bottom: 20px; filter: drop-shadow(0 0 20px rgba(56, 189, 248, 0.5));">
            <i class="fa-regular fa-circle-check"></i>
        </div>
        <h2 class="text-gradient mb-2">Booking Berhasil!</h2>
        <p class="text-muted mb-4" style="line-height: 1.6;">
            Terima kasih telah menggunakan VentureGear.<br>
            Data booking Anda dan bukti pembayaran telah kami terima dan saat ini berstatus <strong>Menunggu Verifikasi Admin</strong>.
        </p>
        <div class="glass-card bg-info" style="padding: 15px; margin-bottom: 30px; font-size: 0.9rem;">
            Admin kami akan segera mengecek pembayaran Anda. Mohon tunggu informasi selanjutnya.
        </div>
        <a href="katalog.php" class="btn-primary glow-btn w-100"><i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
