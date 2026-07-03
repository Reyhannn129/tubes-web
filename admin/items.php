<?php
require_once '../includes/auth.php';
cekLogin();
require_once '../config/db.php';
require_once '../includes/functions.php';

$stmt = $pdo->query("SELECT * FROM items ORDER BY id DESC");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Barang - VentureGear</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="sidebar">
    <div class="sidebar-logo text-gradient"><i class="fa-solid fa-mountain-sun"></i> VentureGear</div>
    <div class="sidebar-menu">
        <a href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="items.php" class="active"><i class="fa-solid fa-boxes-stacked"></i> Kelola Barang</a>
        <a href="rentals.php"><i class="fa-solid fa-file-invoice-dollar"></i> Kelola Booking</a>
    </div>
    <div class="sidebar-footer">
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<div class="main-content">
    <div class="admin-header">
        <div class="admin-title">
            <h2>Data Barang Outdoor</h2>
        </div>
        <div class="admin-profile">
            <a href="item_add.php" class="btn-primary"><i class="fa-solid fa-plus"></i> Tambah Barang</a>
        </div>
    </div>

    <?php if(isset($_GET['msg'])): ?>
        <div class="alert alert-success">
            <?php 
            if($_GET['msg'] == 'added') echo 'Barang berhasil ditambahkan.';
            elseif($_GET['msg'] == 'updated') echo 'Barang berhasil diupdate.';
            elseif($_GET['msg'] == 'deleted') echo 'Barang berhasil dihapus.';
            ?>
        </div>
    <?php endif; ?>

    <div class="glass-card table-container" style="padding: 20px;">
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga Sewa</th>
                    <th>Stok (Tersedia/Total)</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $row): ?>
                <tr>
                    <td>
                        <?php if($row['gambar'] && file_exists("../assets/uploads/items/".$row['gambar'])): ?>
                            <img src="../assets/uploads/items/<?php echo $row['gambar']; ?>" alt="img" style="width:50px; height:50px; object-fit:cover; border-radius:4px;">
                        <?php else: ?>
                            <div style="width:50px; height:50px; background:#333; display:flex; align-items:center; justify-content:center; border-radius:4px;"><i class="fa-solid fa-image"></i></div>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($row['nama_barang']); ?></td>
                    <td><?php echo e($row['kategori']); ?></td>
                    <td><?php echo formatRupiah($row['harga_sewa']); ?></td>
                    <td><?php echo $row['stok_tersedia'] . ' / ' . $row['stok_total']; ?></td>
                    <td>
                        <?php if($row['status'] == 'tersedia'): ?>
                            <span class="badge-status bg-success">Tersedia</span>
                        <?php elseif($row['status'] == 'habis'): ?>
                            <span class="badge-status bg-danger">Habis</span>
                        <?php else: ?>
                            <span class="badge-status bg-warning">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="item_edit.php?id=<?php echo $row['id']; ?>" class="btn-secondary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="item_delete.php?id=<?php echo $row['id']; ?>" class="btn-primary btn-sm delete-btn" style="background:#EF4444;"><i class="fa-solid fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="../assets/js/admin.js"></script>
</body>
</html>
