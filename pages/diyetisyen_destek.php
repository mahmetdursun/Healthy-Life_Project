<?php session_start(); 

require_once('../includes/connection.php');

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = 'Bu sayfaya erişmek için lütfen giriş yapınız.';
    header('Location: userLogin.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Diyetisyen Desteği</title>
    <link rel="stylesheet" href="../assets/css/diyetisyen_destek.css?v=<?= time(); ?>">
</head>
<body>
    <div class="container">
        <h1> Diyetisyen Desteği Formu</h1>
        <form action="diyetisyen_kaydet.php" method="POST" enctype="multipart/form-data">

            <div class="grid">
                <div>
                    <label>Ad Soyad:</label>
                    <input type="text" name="adsoyad" required>
                </div>
                <div>
                    <label>Yaş:</label>
                    <input type="number" name="yas" required>
                </div>
                <div>
                    <label>Boy (cm):</label>
                    <input type="number" name="boy" required>
                </div>
                <div>
                    <label>Kilo (kg):</label>
                    <input type="number" name="kilo" required>
                </div>
                <div>
                    <label>Hedef Kilo:</label>
                    <input type="number" name="hedef_kilo">
                </div>
            </div>

            <label>Günlük Öğün Alışkanlıkları:</label>
            <textarea name="ogun" placeholder="Kahvaltı - Öğle - Akşam - Ara öğünler" rows="3"></textarea>

            <label>Beslenme Tercihleri:</label>
            <select name="tercih">
                <option>Standart</option>
                <option>Vegan</option>
                <option>Vejetaryen</option>
                <option>Glütensiz</option>
                <option>Ketojenik</option>
            </select>

            <label>Alerjiler / Hassasiyetler:</label>
            <input type="text" name="alerji" placeholder="Örn: Laktoz, Kuruyemiş...">

            <label>Önceki Diyet Deneyimleriniz:</label>
            <textarea name="gecmis_diyet" rows="4"></textarea>

            <label>Varsa Rapor veya Ölçüm Dosyası:</label>
            <input type="file" name="rapor">

            <label>Diyetisyene Mesajınız:</label>
            <textarea name="mesaj" rows="3"></textarea>

            <button type="submit">Formu Gönder</button>
            <a href="../index.php">Ana Sayfaya Dön</a>
        </form>
    </div>
</body>
</html>