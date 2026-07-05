<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
// Base URL to handle absolute paths for assets
$base_url = "http://" . $_SERVER["HTTP_HOST"] . "/";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VentureGear - Modern Outdoor Rental</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Quicksand:wght@500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/style.css">
</head>
<body>

<!-- Top Bar -->
<div class="top-bar">
    <div class="top-bar-container">
      <a href="<?php echo $base_url; ?>index.php" class="logo">
          <img src="<?php echo $base_url; ?>assets/images/logo_navbar.png" alt="VentureGear Logo">
      </a>
        <ul class="nav-menu">
          <li><a href="<?php echo $base_url; ?>index.php">Beranda</a></li>
          <li><a href="<?php echo $base_url; ?>katalog.php">Katalog</a></li>
          <li><a href="<?php echo $base_url; ?>index.php#cara-sewa">Cara Sewa</a></li>
          <li><a href="<?php echo $base_url; ?>index.php#keunggulan">Keunggulan</a></li>
          <li><a href="<?php echo $base_url; ?>index.php#kontak">Kontak</a></li>
        </ul>
        <div class="top-bar-right">
          <div class="nav-actions">
              <?php if (isset($_SESSION["admin_id"])): ?>
                  <a href="<?php echo $base_url; ?>admin/dashboard.php" class="btn-primary">Dashboard Admin</a>
              <?php else: ?>
                  <button class="btn-primary" id="adminLoginBtn">Login Admin <i class="fa-solid fa-arrow-right"></i></button>
              <?php endif; ?>
          </div>
        </div>
    </div>
    <div class="top-bar-wave"></div>
</div>

<!-- Admin Login Modal -->
<div class="modal-overlay" id="adminLoginModal">
    <div class="modal-content glass-card">
        <button class="close-modal" id="closeLoginModal">&times;</button>
        <h2 class="text-gradient">Admin Panel</h2>
        <p class="text-muted">Masuk untuk mengelola data VentureGear</p>

        <form action="<?php echo $base_url; ?>admin/login_process.php" method="POST" class="login-form mt-4">
            <div class="form-group">
                <label for="username"><i class="fa-solid fa-user"></i> Username</label>
                <input type="text" id="username" name="username" required placeholder="Masukkan username">
            </div>
            <div class="form-group">
                <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan password">
            </div>
            <button type="submit" class="btn-primary w-100 glow-btn mt-4">Masuk Dashboard</button>
        </form>
    </div>
</div>
