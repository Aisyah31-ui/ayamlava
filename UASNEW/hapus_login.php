<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['username'])) {
    echo json_encode(['success' => false, 'message' => 'Username wajib diisi']);
    exit;
}

$username = $data['username'];

try {
    $conn = getConnection();
    $stmt = $conn->prepare("DELETE FROM login WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Akun berhasil dihapus']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal menghapus akun: ' . $e->getMessage()]);
}
?>
