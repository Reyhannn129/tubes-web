<?php
require_once 'config/db.php';

$username = 'admin';
$password = 'admin123';
$nama_admin = 'Super Admin';

// Hash password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

try {
    // Cek apakah admin sudah ada
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $exists = $stmt->fetchColumn();

    if ($exists) {
        // Update password jika sudah ada
        $stmt = $pdo->prepare("UPDATE admins SET password = ?, nama_admin = ? WHERE username = ?");
        $stmt->execute([$hashed_password, $nama_admin, $username]);
        echo "Admin account '$username' updated successfully.\n";
    } else {
        // Insert jika belum ada
        $stmt = $pdo->prepare("INSERT INTO admins (username, password, nama_admin) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashed_password, $nama_admin]);
        echo "Admin account '$username' created successfully.\n";
    }
    echo "Username: $username\n";
    echo "Password: $password\n";
} catch (PDOException $e) {
    echo "Error seeding admin: " . $e->getMessage() . "\n";
}
?>
