<?php
// create.php - Backend only, no HTML
session_start();
require_once __DIR__ . '/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../HTML/login.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../HTML/create.html');
    exit;
}

$nama = htmlspecialchars(trim($_POST['nama'] ?? ''));
$deskripsi = htmlspecialchars(trim($_POST['deskripsi'] ?? ''));
$harga = filter_var($_POST['harga'] ?? 0, FILTER_VALIDATE_FLOAT);
$stok = filter_var($_POST['stok'] ?? 0, FILTER_VALIDATE_INT);

if (empty($nama) || $harga === false || $stok === false) {
    header('Location: ../HTML/create.html?error=field_required');
    exit;
}

$stmt = $db->prepare("INSERT INTO items (user_id, nama, deskripsi, harga, stok) VALUES (:uid, :nama, :deskripsi, :harga, :stok)");
$result = $stmt->execute([
    ':uid' => $_SESSION['user_id'],
    ':nama' => $nama,
    ':deskripsi' => $deskripsi,
    ':harga' => $harga,
    ':stok' => $stok
]);

if ($result) {
    header('Location: ../HTML/index.html?msg=added');
} else {
    header('Location: ../HTML/create.html?error=failed');
}
exit;
?>
