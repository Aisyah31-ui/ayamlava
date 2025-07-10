<?php
require_once 'koneksi.php'; // memanggil file koneksi

header('Content-Type: application/json');

// Ambil data JSON dari body request
$data = json_decode(file_get_contents('php://input'), true);

// Validasi input
if (!isset($data['username']) || !isset($data['password']) || empty($data['username']) || empty($data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Username dan Password wajib diisi']);
    exit;
}

$username = $data['username'];
$password = $data['password'];


try {
    $conn = getConnection();
    $stmt = $conn->prepare("INSERT INTO login (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password); // simpan password yang sudah di-hash
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Akun login berhasil ditambahkan']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal menambahkan data: ' . $e->getMessage()]);
}
?>
