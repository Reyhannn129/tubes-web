<?php
session_start();
require_once '../config/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if(empty($username) || empty($password)) {
        header("Location: login.php?error=empty_fields");
        exit();
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if($admin && password_verify($password, $admin['password'])) {
            // Login success
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['nama_admin'];
            
            header("Location: dashboard.php");
            exit();
        } else {
            // Login failed
            header("Location: login.php?error=invalid_credentials");
            exit();
        }
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: login.php");
    exit();
}
?>
