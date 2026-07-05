<?php
session_start();
if(isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - VentureGear</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="display:flex; align-items:center; justify-content:center; min-height:100vh;">

<div class="glass-card" style="padding: 40px; width: 100%; max-width: 400px; position: relative; z-index: 10;">
    <div class="text-center mb-4">
        <a href="../index.php" class="logo" style="justify-content:center; margin:0 auto 20px auto; display:inline-flex; align-items:center;">
            <img src="../assets/images/logo_transparant.png" alt="VentureGear Logo" style="height: 80px; max-width: 100%; object-fit: contain;">
        </a>
        <h2 class="text-gradient">Admin Panel</h2>
    </div>

    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger mb-4" style="font-size:0.9rem;">
            <?php 
            if($_GET['error'] == 'invalid_credentials') echo 'Username atau password salah.';
            elseif($_GET['error'] == 'empty_fields') echo 'Harap isi username dan password.';
            elseif($_GET['error'] == 'not_logged_in') echo 'Silakan login terlebih dahulu.';
            ?>
        </div>
    <?php endif; ?>

    <form action="login_process.php" method="POST">
        <div class="form-group">
            <label for="username"><i class="fa-solid fa-user"></i> Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn-primary w-100 glow-btn mt-4">Masuk Dashboard</button>
    </form>
    
    <div class="text-center mt-4">
        <a href="../index.php" class="text-muted" style="font-size:0.9rem;"><i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda</a>
    </div>
</div>

</body>
</html>
