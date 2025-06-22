<?php
require_once('../includes/connection.php');

$c_id = $_GET['id'] ?? null;

if ($c_id) {
    $stmt = $connection->prepare("DELETE FROM calisanlar WHERE c_id = ?");
    $stmt->execute([$c_id]);
}

header("Location: admin.php?page=calisanlar");
exit;
