<?php
session_start();
require_once('../includes/connection.php');

if (isset($_POST["kaydet"])) {
    $u_kilo = $_POST["u_kilo"];
    $u_boy = $_POST["u_boy"];
    $u_antrenman_suresi = $_POST["u_antrenman_suresi"];
    $u_cinsiyet = $_POST["u_cinsiyet"];
    $u_aktivite = $_POST["u_aktivite"];
    $u_hedef = $_POST["u_hedef"];

    $sql = "INSERT INTO user (u_adi, u_soyadi, u_tc, u_telefon, u_dogumtarih, u_mail, u_sifre, u_kilo, u_boy, u_antrenman_suresi, u_cinsiyet, u_aktivite, u_hedef)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->execute([
        $_SESSION["u_adi"],
        $_SESSION["u_soyadi"],
        $_SESSION["u_tc"],
        $_SESSION["u_telefon"],
        $_SESSION["u_dogumtarih"],
        $_SESSION["u_mail"],
        $_SESSION["u_sifre"],
        $u_kilo,
        $u_boy,
        $u_antrenman_suresi,
        $u_cinsiyet,
        $u_aktivite,
        $u_hedef
    ]);

    session_destroy();
    header("Location: hesapla.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - 2. Adım</title>
    <link rel="stylesheet" href="/proje/assets/css/userRegistration.css?v=<?= time(); ?>">
</head>
<body>
    <div class="container">
        <h2>Vücut ve Aktivite Bilgileri</h2>
        <form action="" method="POST">
            <input type="number" name="u_kilo" placeholder="Kilonuz (kg)" required>
            <input type="number" name="u_boy" placeholder="Boyunuz (cm)" required>
            <input type="number" name="u_antrenman_suresi" placeholder="Günlük Antrenman Süresi (dk)" required>
            
            <select name="u_cinsiyet" required>
                <option value="">Cinsiyetinizi Seçin</option>
                <option value="erkek">Erkek</option>
                <option value="kadın">Kadın</option>
            </select>

            <select name="u_aktivite" required>
                <option value="">Aktivite Düzeyi Seçin</option>
                <option value="hareketsiz">Hareketsiz</option>
                <option value="hafif">Hafif Aktif</option>
                <option value="orta">Orta Aktif</option>
                <option value="çok">Çok Aktif</option>
            </select>

            <select name="u_hedef" required>
                <option value="">Hedef Seçin</option>
                <option value="kilo_vermek">Kilo Vermek</option>
                <option value="kilo_korumak">Kilo Korumak</option>
                <option value="kilo_almak">Kilo Almak</option>
            </select>

            <button type="submit" name="kaydet">Devam</button>
        </form>
    </div>
</body>
</html>
