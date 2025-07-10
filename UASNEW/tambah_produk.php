<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['code_produk'], $data['nama_produk'], $data['harga'], $data['detail_produk'])) {
    echo json_encode(['success' => false, 'message' => 'Semua data produk wajib diisi']);
    exit;
}

try {
    $conn = getConnection();
    $stmt = $conn->prepare("INSERT INTO produk (code_produk, nama_produk, harga, detail_produk)
                            VALUES (:code, :nama, :harga, :detail)");
    $stmt->bindParam(':code', $data['code_produk']);
    $stmt->bindParam(':nama', $data['nama_produk']);
    $stmt->bindParam(':harga', $data['harga']);
    $stmt->bindParam(':detail', $data['detail_produk']);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Produk berhasil ditambahkan']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal tambah produk: ' . $e->getMessage()]);
}
