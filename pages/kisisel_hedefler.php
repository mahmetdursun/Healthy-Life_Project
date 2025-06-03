<?php
session_start();
require_once '../includes/connection.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = 'Bu sayfaya erişmek için lütfen giriş yapınız.';
    header('Location: userLogin.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $su_hedef = $_POST['su_hedef'];
    $uyku_hedef = $_POST['uyku_hedef'];
    $adim_hedef = $_POST['adim_hedef'];
    $sabah_rutin = $_POST['sabah_rutin'];
    $aksam_rutin = $_POST['aksam_rutin'];
    $gunluk_motivasyon = $_POST['gunluk_motivasyon'];
    $yeni_aliskanlik = $_POST['yeni_aliskanlik'];
    $stres_strateji = $_POST['stres_strateji'];
    $minnettarlik = $_POST['minnettarlik'];
    $ruh_hali = $_POST['ruh_hali'];

    $sql = "INSERT INTO kisisel_hedefler 
    (u_id, su_hedef, uyku_hedef, adim_hedef, sabah_rutin, aksam_rutin, gunluk_motivasyon, yeni_aliskanlik, stres_strateji, minnettarlik, ruh_hali)
    VALUES 
    (:u_id, :su_hedef, :uyku_hedef, :adim_hedef, :sabah_rutin, :aksam_rutin, :gunluk_motivasyon, :yeni_aliskanlik, :stres_strateji, :minnettarlik, :ruh_hali)";


    $stmt = $connection->prepare($sql);

    $stmt->execute([
    ':u_id' => $user_id,
    ':su_hedef' => $su_hedef,
    ':uyku_hedef' => $uyku_hedef,
    ':adim_hedef' => $adim_hedef,
    ':sabah_rutin' => $sabah_rutin,
    ':aksam_rutin' => $aksam_rutin,
    ':gunluk_motivasyon' => $gunluk_motivasyon,
    ':yeni_aliskanlik' => $yeni_aliskanlik,
    ':stres_strateji' => $stres_strateji,
    ':minnettarlik' => $minnettarlik,
    ':ruh_hali' => $ruh_hali
]);


    echo "<script>alert('Hedefleriniz başarıyla kaydedildi!');</script>";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kişisel Hedefler</title>
    <link rel="stylesheet" href="../assets/css/kisisel_hedefler.css?v=<?= time(); ?>">
</head>
<body>

<div class="container">
    <h1>Kişisel Hedeflerini Belirle</h1>
    <form action="#" method="post" class="grid-form">

        <div class="input-box">
            <label>Günlük Su Tüketimi Hedefi (litre):</label>
            <input type="number" name="su_hedef" step="0.1">
        </div>

        <div class="input-box">
            <label>Uyku Süresi Hedefi (saat):</label>
            <input type="number" name="uyku_hedef" step="0.1">
        </div>

        <div class="input-box">
            <label>Günlük Adım Sayısı:</label>
            <input type="number" name="adim_hedef">
        </div>

        <div class="input-box">
            <label>Sabah Rutin Hedefin:</label>
            <input type="text" name="sabah_rutin">
        </div>

        <div class="input-box">
            <label>Akşam Rutin Hedefin:</label>
            <input type="text" name="aksam_rutin">
        </div>

        <div class="input-box">
            <label>Bugün Kendine Ne Söylemek İstersin?</label>
            <textarea name="gunluk_motivasyon"></textarea>
        </div>

        <div class="input-box">
            <label>Yeni Alışkanlık Kazanmak İstediğin Bir Şey:</label>
            <input type="text" name="yeni_aliskanlik">
        </div>

        <div class="input-box">
            <label>Stresle Başa Çıkma Stratejin:</label>
            <textarea name="stres_strateji"></textarea>
        </div>

        <div class="input-box">
            <label>Bugün Neye Minnettarsın?</label>
            <textarea name="minnettarlik"></textarea>
        </div>

        <div class="input-box">
            <label>Ruh Halini Bugün Nasıl Tanımlarsın?</label>
            <select name="ruh_hali">
                <option>Mutlu</option>
                <option>Endişeli</option>
                <option>Yorgun</option>
                <option>Motivasyonlu</option>
                <option>Üzgün</option>
            </select>
        </div>

        <div class="full-width">
            <button type="submit">Kaydet</button>
            <a href="../index.php">Ana Sayfaya Dön</a>
        </div>
    </form>
</div>

</body>
</html>