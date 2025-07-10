<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['code_produk'], $data['nama_produk'], $data['harga'], $data['detail_produk'])) {
    echo json_encode(['success' => false, 'message' => 'Semua data wajib diisi']);
    exit;
}

try {
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE produk SET nama_produk = :nama, harga = :harga, detail_produk = :detail
                            WHERE code_produk = :code");
    $stmt->bindParam(':nama', $data['nama_produk']);
    $stmt->bindParam(':harga', $data['harga']);
    $stmt->bindParam(':detail', $data['detail_produk']);
    $stmt->bindParam(':code', $data['code_produk']);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Produk berhasil diperbarui']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal update produk: ' . $e->getMessage()]);
}
