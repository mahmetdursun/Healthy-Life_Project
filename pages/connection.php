<?php
$host = "localhost";
$user = "root";
$dbName = "healthylife";
$password = "";

try {
    $connection = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Bağlantı hatası: " . $e->getMessage());
}
