<?php
require_once('../includes/connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $c_adi = $_POST["c_adi"] ?? '';
    $c_soyadi = $_POST["c_soyadi"] ?? '';
    $c_mail = $_POST["c_mail"] ?? '';
    $c_sifre = $_POST["c_sifre"] ?? '';
    $tur = $_POST["tur"] ?? '';
    $uzmanlik = $_POST["uzmanlik"] ?? '';
    $calisma_saatleri = $_POST["calisma_saatleri"] ?? '';

    if ($c_adi && $c_soyadi && $c_mail && $c_sifre && $tur && $uzmanlik && $calisma_saatleri) {
        try {
            $stmt = $connection->prepare("
    INSERT INTO calisanlar 
    (c_adi, c_soyadi, c_mail, c_sifre, tur, uzmanlik, calisma_saatleri, u_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, NULL)
");
            $stmt->execute([$c_adi, $c_soyadi, $c_mail, $c_sifre, $tur, $uzmanlik, $calisma_saatleri]);

            header("Location: admin.php?page=calisanlar");
            exit;
        } catch (PDOException $e) {
            echo "Veritabanı hatası: " . $e->getMessage();
        }
    } else {
        echo "Lütfen tüm alanları doldurun.";
    }
} else {
    header("Location: admin.php?page=ekle");
    exit;
}