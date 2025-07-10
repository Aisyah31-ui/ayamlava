<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'getyourlava');
define('DB_USER', 'root');
define('DB_PASS', '');

function getConnection() {
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die(json_encode(['success' => false, 'message' => 'Koneksi gagal: ' . $e->getMessage()]));
    }
}
?>
