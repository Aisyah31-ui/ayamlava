<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

// Ambil data dari JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validasi input
if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Username dan Password baru wajib diisi']);
    exit;
}

$username = $data['username'];
$newpassword = $data['password']; // TANPA hash

try {
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE login SET password = :password WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $newpassword);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Password berhasil diperbarui']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Username tidak ditemukan atau password tidak berubah']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal memperbarui data: ' . $e->getMessage()]);
}
?>
