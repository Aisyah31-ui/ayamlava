<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Belum login
    header("Location: login.html");
    exit;
}

// Sudah login → kirim ke WA
$nama = $_SESSION['username'];
$pesan = urlencode("Halo, saya $nama ingin pesan Ayam Lava");
header("Location: https://wa.me/6281234567890?text=$pesan");
exit;
?>
