<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

// Ambil data dari input JSON
$data = json_decode(file_get_contents("php://input"), true);

// Cek input
if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Username dan Password wajib diisi']);
    exit;
}

$username = $data['username'];
$password = $data['password'];

try {
    $conn = getConnection();

    // Cek apakah user ada
    $stmt = $conn->prepare("SELECT * FROM login WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user['password'] === $password) {
            echo json_encode(['success' => true, 'message' => 'Login berhasil']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Password salah']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Username tidak ditemukan']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Kesalahan server: ' . $e->getMessage()]);
} session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

?>
