<?php
require_once '../includes/auth.php';
cekLogin();
require_once '../config/db.php';
require_once '../includes/functions.php';

// Filter
$status = isset($_GET['status']) ? $_GET['status'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT r.*, i.nama_barang FROM rentals r JOIN items i ON r.item_id = i.id WHERE 1=1";
$params = [];

if($status != 'all') {
    $query .= " AND r.status_pembayaran = ?";
    $params[] = $status;
}

if($search != '') {
    $query .= " AND (r.nama_pelanggan LIKE ? OR i.nama_barang LIKE ? OR r.nik LIKE ? OR r.no_hp LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$query .= " ORDER BY r.id DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Booking - VentureGear</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="sidebar">
    <div class="sidebar-logo text-gradient">
        <img src="../assets/images/logo_transparant.png" alt="VentureGear Logo">
    </div>
    <div class="sidebar-menu">
        <a href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="items.php"><i class="fa-solid fa-boxes-stacked"></i> Kelola Barang</a>
        <a href="rentals.php" class="active"><i class="fa-solid fa-file-invoice-dollar"></i> Kelola Booking</a>
    </div>
    <div class="sidebar-footer">
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<div class="main-content">
    <div class="admin-header">
        <div class="admin-title">
            <h2>Data Booking</h2>
        </div>
    </div>

    <?php if(isset($_GET['msg'])): ?>
        <div class="alert alert-success">
            <?php 
            if($_GET['msg'] == 'approved') echo 'Booking berhasil disetujui dan stok telah diperbarui.';
            elseif($_GET['msg'] == 'rejected') echo 'Booking berhasil ditolak.';
            ?>
        </div>
    <?php endif; ?>
    <?php if(isset($_GET['err'])): ?>
        <div class="alert alert-danger">
            <?php 
            if($_GET['err'] == 'stok_habis') echo 'Gagal! Stok barang tidak mencukupi.';
            elseif($_GET['err'] == 'invalid') echo 'Data tidak valid.';
            ?>
        </div>
    <?php endif; ?>

    <div class="glass-card" style="padding: 20px; margin-bottom: 20px;">
        <form method="GET" style="display:flex; gap:15px; flex-wrap:wrap; align-items:flex-end;">
            <div class="form-group" style="margin-bottom:0;">
                <label>Status</label>
                <select name="status" style="width:150px; padding:10px;">
                    <option value="all" <?php if($status=='all') echo 'selected';?>>Semua</option>
                    <option value="pending" <?php if($status=='pending') echo 'selected';?>>Pending</option>
                    <option value="verified" <?php if($status=='verified') echo 'selected';?>>Verified</option>
                    <option value="rejected" <?php if($status=='rejected') echo 'selected';?>>Rejected</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom:0; flex:1;">
                <label>Pencarian</label>
                <input type="text" name="search" placeholder="Nama, NIK, No.HP, Nama Barang" value="<?php echo htmlspecialchars($search); ?>" style="padding:10px;">
            </div>
            <button type="submit" class="btn-primary" style="padding:10px 20px;"><i class="fa-solid fa-magnifying-glass"></i> Filter</button>
        </form>
    </div>

    <div class="glass-card table-container" style="padding: 20px;">
        <table>
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Kontak</th>
                    <th>Barang</th>
                    <th>Tgl Pinjam - Kembali</th>
                    <th>Total DP</th>
                    <th>Bukti</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($rentals as $row): ?>
                <tr>
                    <td>
                        <strong><?php echo e($row['nama_pelanggan']); ?></strong><br>
                        <small class="text-muted">NIK: <?php echo e($row['nik']); ?></small>
                    </td>
                    <td><?php echo e($row['no_hp']); ?></td>
                    <td><?php echo e($row['nama_barang']); ?></td>
                    <td><?php echo e($row['tgl_pinjam']); ?> <br> s/d <br> <?php echo e($row['tgl_kembali']); ?></td>
                    <td><?php echo formatRupiah($row['total_dp']); ?></td>
                    <td>
                        <a href="../assets/uploads/bukti_bayar/<?php echo $row['bukti_bayar']; ?>" target="_blank" class="btn-sm btn-secondary">
                            Lihat
                        </a>
                    </td>
                    <td>
                        <?php if($row['status_pembayaran'] == 'pending'): ?>
                            <span class="badge-status bg-warning">Pending</span>
                        <?php elseif($row['status_pembayaran'] == 'verified'): ?>
                            <span class="badge-status bg-success">Verified</span>
                        <?php else: ?>
                            <span class="badge-status bg-danger">Rejected</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($row['status_pembayaran'] == 'pending'): ?>
                            <div class="action-btns" style="flex-direction:column; gap:5px;">
                                <a href="approve.php?id=<?php echo $row['id']; ?>" class="btn-primary btn-sm confirm-btn text-center" style="background:#10B981;"><i class="fa-solid fa-check"></i> Approve</a>
                                <a href="reject.php?id=<?php echo $row['id']; ?>" class="btn-primary btn-sm confirm-btn text-center" style="background:#EF4444;"><i class="fa-solid fa-xmark"></i> Reject</a>
                            </div>
                        <?php else: ?>
                            <span class="text-muted" style="font-size:0.8rem;">Selesai</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($rentals)): ?>
                    <tr><td colspan="8" class="text-center text-muted">Tidak ada data ditemukan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="../assets/js/admin.js"></script>
</body>
</html>
