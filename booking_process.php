<?php
require_once 'config/db.php';
require_once 'includes/functions.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['item_id'];
    $nama_pelanggan = trim($_POST['nama_pelanggan']);
    $nik = trim($_POST['nik']);
    $no_hp = trim($_POST['no_hp']);
    $alamat = trim($_POST['alamat']);
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $total_dp = $_POST['total_dp'];
    
    // Server-side validations
    if(empty($item_id) || empty($nama_pelanggan) || empty($nik) || empty($no_hp) || empty($alamat) || empty($tgl_pinjam) || empty($tgl_kembali)) {
        header("Location: booking.php?item_id=$item_id&error=input_tidak_valid");
        exit();
    }

    if(!preg_match('/^[0-9]{16,}$/', $nik)) {
        header("Location: booking.php?item_id=$item_id&error=input_tidak_valid");
        exit();
    }

    $today = date('Y-m-d');
    $max_pinjam = date('Y-m-d', strtotime('+2 days'));
    
    if($tgl_pinjam <= $today || $tgl_pinjam > $max_pinjam || $tgl_kembali < $tgl_pinjam) {
        header("Location: booking.php?item_id=$item_id&error=input_tidak_valid");
        exit();
    }

    // File Upload Handling
    $bukti_bayar = '';
    if(isset($_FILES['bukti_bayar']) && $_FILES['bukti_bayar']['error'] == 0) {
        $file_tmp = $_FILES['bukti_bayar']['tmp_name'];
        $file_name = $_FILES['bukti_bayar']['name'];
        $file_size = $_FILES['bukti_bayar']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        
        if(!in_array($file_ext, $allowed)) {
            header("Location: booking.php?item_id=$item_id&error=format_file_salah");
            exit();
        }
        
        if($file_size > 2097152) { // 2MB
            header("Location: booking.php?item_id=$item_id&error=file_terlalu_besar");
            exit();
        }
        
        $new_name = time() . '_' . rand(1000, 9999) . '.' . $file_ext;
        $upload_path = 'assets/uploads/bukti_bayar/' . $new_name;
        
        if(move_uploaded_file($file_tmp, $upload_path)) {
            $bukti_bayar = $new_name;
        } else {
            header("Location: booking.php?item_id=$item_id&error=upload_gagal");
            exit();
        }
    } else {
        header("Location: booking.php?item_id=$item_id&error=input_tidak_valid");
        exit();
    }

    // Insert to database (status_pembayaran pending, status_booking menunggu)
    // Stok tidak dikurangi di sini
    try {
        $stmt = $pdo->prepare("INSERT INTO rentals (item_id, nama_pelanggan, nik, no_hp, alamat, tgl_pinjam, tgl_kembali, total_dp, bukti_bayar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$item_id, $nama_pelanggan, $nik, $no_hp, $alamat, $tgl_pinjam, $tgl_kembali, $total_dp, $bukti_bayar]);
        
        header("Location: booking_success.php");
        exit();
    } catch(PDOException $e) {
        die("Error saving data: " . $e->getMessage());
    }

} else {
    header("Location: index.php");
    exit();
}
?>
