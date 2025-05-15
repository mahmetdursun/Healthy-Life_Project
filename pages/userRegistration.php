<?php
session_start();
require_once('../includes/connection.php');

if (isset($_POST["devam"])) {
    $_SESSION["u_adi"] = $_POST["u_adi"];
    $_SESSION["u_soyadi"] = $_POST["u_soyadi"];
    $_SESSION["u_tc"] = $_POST["u_tc"];
    $_SESSION["u_telefon"] = $_POST["u_telefon"];
    $_SESSION["u_dogumtarih"] = $_POST["u_dogumtarih"];
    $_SESSION["u_mail"] = $_POST["u_mail"];
    $_SESSION["u_sifre"] = md5($_POST["u_sifre"]); // Şu an md5 kullanıyoruz

    header("Location: userRegistration2.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - 1. Adım</title>
    <link rel="stylesheet" href="/proje/assets/css/userRegistration.css?v=<?= time(); ?>">
</head>
<body>
    <div class="container">
        <h2>Kayıt Ol - Kişisel Bilgiler</h2>
        <form action="" method="POST">
            <input type="text" name="u_adi" placeholder="Adınız" required>
            <input type="text" name="u_soyadi" placeholder="Soyadınız" required>
            <input type="text" name="u_tc" placeholder="TC Kimlik No" required>
            <input type="text" name="u_telefon" placeholder="Telefon Numaranız" required>
            <input type="date" name="u_dogumtarih" placeholder="Doğum Tarihiniz" required>
            <input type="email" name="u_mail" placeholder="E-posta" required>
            <input type="password" name="u_sifre" placeholder="Şifre" required>
            <button type="submit" name="devam">Devam Et</button>
        </form>
    </div>
</body>
</html>
