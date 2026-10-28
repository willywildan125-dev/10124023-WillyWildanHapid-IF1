<?php
// logout.php - Backend only, no HTML
session_start();
$_SESSION = [];
session_destroy();
header('Location: ../HTML/login.html');
exit;
?>
