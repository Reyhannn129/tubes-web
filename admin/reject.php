<?php
require_once '../includes/auth.php';
cekLogin();
require_once '../config/db.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Cek status booking
    $stmt = $pdo->prepare("SELECT status_pembayaran FROM rentals WHERE id = ?");
    $stmt->execute([$id]);
    $rental = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($rental && $rental['status_pembayaran'] == 'pending') {
        // Update status ditolak (tanpa mengurangi stok)
        $stmt_update = $pdo->prepare("UPDATE rentals SET status_pembayaran = 'rejected', status_booking = 'ditolak' WHERE id = ?");
        $stmt_update->execute([$id]);
        
        header("Location: rentals.php?msg=rejected");
    } else {
        header("Location: rentals.php?err=invalid");
    }
} else {
    header("Location: rentals.php");
}
exit();
?>
