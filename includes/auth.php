<?php
// includes/auth.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function cekLogin() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: ../index.php?error=not_logged_in");
        exit();
    }
}
?>
