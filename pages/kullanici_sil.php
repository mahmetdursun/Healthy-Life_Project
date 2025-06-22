<?php
require_once('../includes/connection.php');

$u_id = $_GET['id'] ?? null;

if ($u_id) {
    $stmt = $connection->prepare("DELETE FROM user WHERE u_id = ?");
    $stmt->execute([$u_id]);
}

header("Location: admin.php?page=kullanicilar");
exit;
