<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id_customer'])) {
    echo json_encode(['success' => false, 'message' => 'ID customer wajib diisi']);
    exit;
}

$id = $data['id_customer'];

try {
    $conn = getConnection();
    $stmt = $conn->prepare("DELETE FROM customer WHERE id_customer = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Customer berhasil dihapus']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus customer: ' . $e->getMessage()]);
}
