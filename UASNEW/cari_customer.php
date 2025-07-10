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
    $stmt = $conn->prepare("SELECT * FROM customer WHERE id_customer = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        echo json_encode(['success' => true, 'data' => $result]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Customer tidak ditemukan']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Kesalahan: ' . $e->getMessage()]);
}
