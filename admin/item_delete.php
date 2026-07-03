<?php
require_once '../includes/auth.php';
cekLogin();
require_once '../config/db.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil info gambar untuk dihapus
    $stmt = $pdo->prepare("SELECT gambar FROM items WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    
    if($item && $item['gambar'] && file_exists('../assets/uploads/items/'.$item['gambar'])) {
        unlink('../assets/uploads/items/'.$item['gambar']);
    }

    $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: items.php?msg=deleted");
} else {
    header("Location: items.php");
}
exit();
?>
