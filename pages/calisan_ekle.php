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
    $telefon = $_POST["telefon"] ?? '';
    $mezuniyet = $_POST["mezuniyet"] ?? '';
    $deneyim = $_POST["deneyim"] ?? '';
    $sertifikalar = $_POST["sertifikalar"] ?? '';
    $aciklama = $_POST["aciklama"] ?? '';
    $profil_resmi = null;

    // Profil resmi yüklendiyse işle
    if (!empty($_FILES['profil_resmi']['name'])) {
        $dosya = $_FILES['profil_resmi'];
        $uzanti = strtolower(pathinfo($dosya['name'], PATHINFO_EXTENSION));
        $dosya_adi = 'calisan_' . time() . '.' . $uzanti;
        $hedef_yol = '../uploads/' . $dosya_adi;

        if (move_uploaded_file($dosya['tmp_name'], $hedef_yol)) {
            $profil_resmi = $dosya_adi;
        }
    }

    if ($c_adi && $c_soyadi && $c_mail && $c_sifre && $tur && $uzmanlik && $calisma_saatleri) {
        try {
            $stmt = $connection->prepare("
                INSERT INTO calisanlar 
                (c_adi, c_soyadi, c_mail, c_sifre, tur, uzmanlik, calisma_saatleri, telefon, mezuniyet, deneyim, sertifikalar, aciklama, profil_resmi, u_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL)
            ");
            $stmt->execute([
                $c_adi, $c_soyadi, $c_mail, $c_sifre, $tur, $uzmanlik, $calisma_saatleri,
                $telefon, $mezuniyet, $deneyim, $sertifikalar, $aciklama, $profil_resmi
            ]);

            header("Location: admin.php?page=calisanlar");
            exit;
        } catch (PDOException $e) {
            echo "Veritabanı hatası: " . $e->getMessage();
        }
    } else {
        echo "Lütfen zorunlu alanları doldurun.";
    }
} else {
    header("Location: admin.php?page=ekle");
    exit;
}
