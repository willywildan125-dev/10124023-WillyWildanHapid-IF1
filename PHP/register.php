<?php
// register.php - Backend only, no HTML
session_start();
require_once __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../HTML/register.html');
    exit;
}

$username = htmlspecialchars(trim($_POST['username'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    header('Location: ../HTML/register.html?error=field_required');
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../HTML/register.html?error=invalid_email');
    exit;
}
if ($password !== $confirm_password) {
    header('Location: ../HTML/register.html?error=password_mismatch');
    exit;
}

$stmt = $db->prepare("SELECT id FROM users WHERE username = :username");
$stmt->execute([':username' => $username]);
if ($stmt->fetch()) {
    header('Location: ../HTML/register.html?error=username_exists');
    exit;
}

$stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
$stmt->execute([':email' => $email]);
if ($stmt->fetch()) {
    header('Location: ../HTML/register.html?error=email_exists');
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
$result = $stmt->execute([':username' => $username, ':email' => $email, ':password' => $hashed]);

if ($result) {
    header('Location: ../HTML/login.html?success=registered');
} else {
    header('Location: ../HTML/register.html?error=register_failed');
}
exit;
?>
