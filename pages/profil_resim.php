<?php
session_start();
require_once('../includes/connection.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header("Location: userLogin.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!empty($_FILES['profil_resmi']['name'])) {
    $dosya = $_FILES['profil_resmi'];
    $uzanti = strtolower(pathinfo($dosya['name'], PATHINFO_EXTENSION));
    $dosya_adi = 'user_' . $user_id . '_' . time() . '.' . $uzanti;
    $yukleme_yolu = '../uploads/' . $dosya_adi;

    if (move_uploaded_file($dosya['tmp_name'], $yukleme_yolu)) {
        $stmt = $connection->prepare("UPDATE user SET profil_resmi = :resim WHERE u_id = :id");
        $stmt->execute([
            'resim' => $dosya_adi,
            'id' => $user_id
        ]);
    } else {
        echo "Hata: Dosya yüklenemedi.";
        exit;
    }
}

header("Location: profile.php?section=profil");
exit;
