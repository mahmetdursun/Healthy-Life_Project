<?php
session_start();
require_once('../includes/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['randevu_id'])) {
    $stmt = $connection->prepare("DELETE FROM randevular WHERE r_id = :id");
    $stmt->execute(['id' => $_POST['randevu_id']]);
}

header("Location: profile.php?section=randevular");
exit;
