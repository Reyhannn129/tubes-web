<?php
// includes/functions.php

function formatRupiah($angka){
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	return $hasil_rupiah;
}

function hitungHari($tgl_pinjam, $tgl_kembali) {
    $datetime1 = new DateTime($tgl_pinjam);
    $datetime2 = new DateTime($tgl_kembali);
    $interval = $datetime1->diff($datetime2);
    // jika kembali hari yang sama, hitung 1 hari
    $days = $interval->format('%a');
    return $days > 0 ? $days : 1;
}

// Security: escape output
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>
