<?php
require_once '../includes/auth.php';
cekLogin();
require_once '../config/db.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $pdo->beginTransaction();
        
        // Cek data booking
        $stmt = $pdo->prepare("SELECT * FROM rentals WHERE id = ? FOR UPDATE");
        $stmt->execute([$id]);
        $rental = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!$rental || $rental['status_pembayaran'] != 'pending') {
            $pdo->rollBack();
            header("Location: rentals.php?err=invalid");
            exit();
        }
        
        // Cek stok barang
        $stmt_item = $pdo->prepare("SELECT stok_tersedia FROM items WHERE id = ? FOR UPDATE");
        $stmt_item->execute([$rental['item_id']]);
        $item = $stmt_item->fetch(PDO::FETCH_ASSOC);
        
        if(!$item || $item['stok_tersedia'] <= 0) {
            $pdo->rollBack();
            header("Location: rentals.php?err=stok_habis");
            exit();
        }
        
        // Update booking status
        $stmt_update_rental = $pdo->prepare("UPDATE rentals SET status_pembayaran = 'verified', status_booking = 'disetujui' WHERE id = ?");
        $stmt_update_rental->execute([$id]);
        
        // Update item stock
        $stmt_update_item = $pdo->prepare("UPDATE items SET stok_tersedia = stok_tersedia - 1 WHERE id = ?");
        $stmt_update_item->execute([$rental['item_id']]);
        
        // Jika stok tersedia menjadi 0, update status menjadi habis
        $stmt_check_empty = $pdo->prepare("UPDATE items SET status = 'habis' WHERE id = ? AND stok_tersedia = 0");
        $stmt_check_empty->execute([$rental['item_id']]);
        
        $pdo->commit();
        header("Location: rentals.php?msg=approved");
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Terjadi kesalahan: " . $e->getMessage());
    }
} else {
    header("Location: rentals.php");
}
exit();
?>
