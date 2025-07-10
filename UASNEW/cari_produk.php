<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$code = $_GET['code_produk'] ?? null;

try {
    $conn = getConnection();
    if ($code) {
        $stmt = $conn->prepare("SELECT * FROM produk WHERE code_produk = :code");
        $stmt->bindParam(':code', $code);
    } else {
        $stmt = $conn->prepare("SELECT * FROM produk");
    }
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $data]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal ambil data: ' . $e->getMessage()]);
}
