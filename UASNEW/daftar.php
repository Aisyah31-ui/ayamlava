<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

// Ambil data dari JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validasi
if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Username dan Password wajib diisi']);
    exit;
}

$username = $data['username'];
$password = $data['password']; // tanpa hashing

try {
    $conn = getConnection();

    // Cek apakah username sudah dipakai
    $check = $conn->prepare("SELECT * FROM login WHERE username = :username");
    $check->bindParam(':username', $username);
    $check->execute();

    if ($check->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Username sudah digunakan']);
        exit;
    }

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO login (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Akun berhasil dibuat']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal daftar: ' . $e->getMessage()]);
}
?>
