<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id_customer'], $data['nama'], $data['password'], $data['no_hp'], $data['alamat'])) {
    echo json_encode(['success' => false, 'message' => 'Semua data wajib diisi']);
    exit;
}

$id = $data['id_customer'];
$nama = $data['nama'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$no_hp = $data['no_hp'];
$alamat = $data['alamat'];

try {
    $conn = getConnection();
    $stmt = $conn->prepare("UPDATE customer SET nama = :nama, password = :password, no_hp = :no_hp, alamat = :alamat WHERE id_customer = :id");
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':no_hp', $no_hp);
    $stmt->bindParam(':alamat', $alamat);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Data customer berhasil diperbarui']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal update: ' . $e->getMessage()]);
}
