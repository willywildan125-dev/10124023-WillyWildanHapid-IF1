<?php
// login.php - Backend only, no HTML
session_start();
require_once __DIR__ . '/koneksi.php';

// Kalau bukan POST, redirect ke HTML
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../HTML/login.html');
    exit;
}

$username = htmlspecialchars(trim($_POST['username'] ?? ''));
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    header('Location: ../HTML/login.html?error=field_required');
    exit;
}

$stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute([':username' => $username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    header('Location: ../HTML/index.html');
    exit;
} else {
    header('Location: ../HTML/login.html?error=login_failed');
    exit;
}
?>
