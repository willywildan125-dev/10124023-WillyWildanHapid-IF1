<?php
session_start();
require_once __DIR__ . '/koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'not_logged_in']);
    exit;
}

$uid = $_SESSION['user_id'];
$action = $_GET['action'] ?? '';

if ($action === 'list') {
    $search = trim($_GET['search'] ?? '');
    if (!empty($search)) {
        $stmt = $db->prepare("SELECT * FROM items WHERE user_id = :uid AND (nama LIKE :search OR deskripsi LIKE :search) ORDER BY id DESC");
        $stmt->execute([':uid' => $uid, ':search' => '%' . $search . '%']);
    } else {
        $stmt = $db->prepare("SELECT * FROM items WHERE user_id = :uid ORDER BY id DESC");
        $stmt->execute([':uid' => $uid]);
    }
    $items = $stmt->fetchAll();

    $stmt = $db->prepare("SELECT COUNT(*) FROM items WHERE user_id = :uid");
    $stmt->execute([':uid' => $uid]);
    $totalItems = $stmt->fetchColumn();

    $stmt = $db->prepare("SELECT COALESCE(SUM(stok), 0) FROM items WHERE user_id = :uid");
    $stmt->execute([':uid' => $uid]);
    $totalStock = $stmt->fetchColumn();

    $stmt = $db->prepare("SELECT COALESCE(SUM(harga * stok), 0) FROM items WHERE user_id = :uid");
    $stmt->execute([':uid' => $uid]);
    $totalValue = $stmt->fetchColumn();

    echo json_encode([
        'items' => $items,
        'totalItems' => $totalItems,
        'totalStock' => $totalStock,
        'totalValue' => $totalValue,
        'username' => $_SESSION['username']
    ]);
}

elseif ($action === 'get') {
    $id = (int) ($_GET['id'] ?? 0);
    $stmt = $db->prepare("SELECT * FROM items WHERE id = :id AND user_id = :uid");
    $stmt->execute([':id' => $id, ':uid' => $uid]);
    $item = $stmt->fetch();
    if ($item) {
        echo json_encode($item);
    } else {
        echo json_encode(['error' => 'not_found']);
    }
}

elseif ($action === 'delete') {
    $id = (int) ($_GET['id'] ?? 0);
    $stmt = $db->prepare("DELETE FROM items WHERE id = :id AND user_id = :uid");
    $stmt->execute([':id' => $id, ':uid' => $uid]);
    echo json_encode(['success' => true]);
}

elseif ($action === 'session') {
    echo json_encode([
        'logged_in' => true,
        'username' => $_SESSION['username']
    ]);
}

else {
    echo json_encode(['error' => 'invalid_action']);
}
?>
