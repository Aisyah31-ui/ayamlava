<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['nama'], $data['password'], $data['no_hp'], $data['alamat'])) {
    echo json_encode(['success' => false, 'message' => 'Semua data wajib diisi']);
    exit;
}

$nama = $data['nama'];
$password = password_hash($data['password'], PASSWORD_DEFAULT); // Enkripsi
$no_hp = $data['no_hp'];
$alamat = $data['alamat'];

try {
    $conn = getConnection();
    $stmt = $conn->prepare("INSERT INTO customer (nama, password, no_hp, alamat) VALUES (:nama, :password, :no_hp, :alamat)");
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':no_hp', $no_hp);
    $stmt->bindParam(':alamat', $alamat);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Customer berhasil ditambahkan']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal menambahkan customer: ' . $e->getMessage()]);
}
