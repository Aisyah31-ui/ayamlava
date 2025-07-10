<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

// Ambil data JSON dari request
$data = json_decode(file_get_contents('php://input'), true);

// Validasi input username
if (!isset($data['username']) || empty($data['username'])) {
    echo json_encode(['success' => false, 'message' => 'Username wajib diisi']);
    exit;
}

$username = $data['username'];

try {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT username FROM login WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode(['success' => true, 'data' => $user]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal mencari data: ' . $e->getMessage()]);
}
?>
