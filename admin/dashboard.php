<?php
require_once '../includes/auth.php';
cekLogin();
require_once '../config/db.php';
require_once '../includes/functions.php';

// Statistik
$tot_barang = $pdo->query("SELECT COUNT(*) FROM items")->fetchColumn();
$tot_stok = $pdo->query("SELECT SUM(stok_tersedia) FROM items")->fetchColumn();
$tot_booking = $pdo->query("SELECT COUNT(*) FROM rentals")->fetchColumn();
$tot_pending = $pdo->query("SELECT COUNT(*) FROM rentals WHERE status_pembayaran = 'pending'")->fetchColumn();

// Booking terbaru
$stmt = $pdo->query("
    SELECT r.*, i.nama_barang 
    FROM rentals r 
    JOIN items i ON r.item_id = i.id 
    ORDER BY r.id DESC LIMIT 5
");
$recent_rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - VentureGear</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-logo text-gradient">
        <i class="fa-solid fa-mountain-sun"></i> VentureGear
    </div>
    <div class="sidebar-menu">
        <a href="dashboard.php" class="active"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="items.php"><i class="fa-solid fa-boxes-stacked"></i> Kelola Barang</a>
        <a href="rentals.php"><i class="fa-solid fa-file-invoice-dollar"></i> Kelola Booking</a>
    </div>
    <div class="sidebar-footer">
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="admin-header">
        <div class="admin-title">
            <h2>Dashboard Overview</h2>
            <p class="text-muted">Selamat datang, <?php echo $_SESSION['admin_name']; ?></p>
        </div>
        <div class="admin-profile">
            <div class="admin-avatar"><?php echo substr($_SESSION['admin_name'], 0, 1); ?></div>
            <span><?php echo $_SESSION['admin_name']; ?></span>
        </div>
    </div>

    <div class="dashboard-stats">
        <div class="glass-card d-card">
            <div class="d-icon c-blue"><i class="fa-solid fa-box"></i></div>
            <div class="d-info">
                <h4>Total Barang</h4>
                <h2><?php echo $tot_barang; ?></h2>
            </div>
        </div>
        <div class="glass-card d-card">
            <div class="d-icon c-green"><i class="fa-solid fa-boxes-stacked"></i></div>
            <div class="d-info">
                <h4>Stok Tersedia</h4>
                <h2><?php echo $tot_stok ? $tot_stok : 0; ?></h2>
            </div>
        </div>
        <div class="glass-card d-card">
            <div class="d-icon c-orange"><i class="fa-solid fa-clock-rotate-left"></i></div>
            <div class="d-info">
                <h4>Booking Pending</h4>
                <h2><?php echo $tot_pending; ?></h2>
            </div>
        </div>
        <div class="glass-card d-card">
            <div class="d-icon c-blue"><i class="fa-solid fa-file-invoice"></i></div>
            <div class="d-info">
                <h4>Total Booking</h4>
                <h2><?php echo $tot_booking; ?></h2>
            </div>
        </div>
    </div>

    <div class="glass-card p-4" style="padding: 20px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h3>Booking Terbaru</h3>
            <a href="rentals.php" class="btn-sm btn-secondary">Lihat Semua</a>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Pelanggan</th>
                        <th>Barang</th>
                        <th>Tgl Pinjam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($recent_rentals as $row): ?>
                    <tr>
                        <td><?php echo e($row['nama_pelanggan']); ?></td>
                        <td><?php echo e($row['nama_barang']); ?></td>
                        <td><?php echo e($row['tgl_pinjam']); ?></td>
                        <td>
                            <?php if($row['status_pembayaran'] == 'pending'): ?>
                                <span class="badge-status bg-warning">Pending</span>
                            <?php elseif($row['status_pembayaran'] == 'verified'): ?>
                                <span class="badge-status bg-success">Verified</span>
                            <?php else: ?>
                                <span class="badge-status bg-danger">Rejected</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($recent_rentals)): ?>
                        <tr><td colspan="4" class="text-center text-muted">Belum ada booking</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="../assets/js/admin.js"></script>
</body>
</html>
