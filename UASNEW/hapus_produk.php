<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['code_produk'])) {
    echo json_encode(['success' => false, 'message' => 'Kode produk wajib diisi']);
    exit;
}

try {
    $conn = getConnection();
    $stmt = $conn->prepare("DELETE FROM produk WHERE code_produk = :code");
    $stmt->bindParam(':code', $data['code_produk']);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Produk berhasil dihapus']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal hapus produk: ' . $e->getMessage()]);
}
