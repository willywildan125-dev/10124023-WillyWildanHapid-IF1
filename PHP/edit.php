<?php
// edit.php - Backend only, no HTML
session_start();
require_once __DIR__ . '/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../HTML/login.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../HTML/index.html');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$nama = htmlspecialchars(trim($_POST['nama'] ?? ''));
$deskripsi = htmlspecialchars(trim($_POST['deskripsi'] ?? ''));
$harga = filter_var($_POST['harga'] ?? 0, FILTER_VALIDATE_FLOAT);
$stok = filter_var($_POST['stok'] ?? 0, FILTER_VALIDATE_INT);

if (empty($nama) || $harga === false || $stok === false) {
    header('Location: ../HTML/edit.html?id=' . $id . '&error=field_required');
    exit;
}

$stmt = $db->prepare("UPDATE items SET nama = :nama, deskripsi = :deskripsi, harga = :harga, stok = :stok WHERE id = :id AND user_id = :uid");
$result = $stmt->execute([
    ':nama' => $nama,
    ':deskripsi' => $deskripsi,
    ':harga' => $harga,
    ':stok' => $stok,
    ':id' => $id,
    ':uid' => $_SESSION['user_id']
]);

if ($result) {
    header('Location: ../HTML/index.html?msg=edited');
} else {
    header('Location: ../HTML/edit.html?id=' . $id . '&error=failed');
}
exit;
?>
