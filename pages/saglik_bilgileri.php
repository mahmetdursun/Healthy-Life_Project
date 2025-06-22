<?php
session_start();
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
    <title>Kişisel Sağlık Bilgi Formu</title>
    <link rel="stylesheet" href="../assets/css/saglik_bilgileri.css?v=<?= time(); ?>">
</head>
<body>
    <div class="container">
        <h1>Kişisel Sağlık Bilgi Formu</h1>
        <form action="form_gonder.php" method="POST">

            <label>Ad Soyad:</label>
            <input type="text" name="ad_soyad" required>

            <label>Yaş:</label>
            <input type="number" name="yas" required>

            <label>Boy (cm):</label>
            <input type="number" name="boy" required>

            <label>Kilo (kg):</label>
            <input type="number" name="kilo" required>

            <label>Kan Grubu:</label>
            <select name="kan_grubu">
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="0+">0+</option>
                <option value="0-">0-</option>
            </select>

            <label>Alerjiler:</label>
            <textarea name="alerjiler" placeholder="Varsa belirtiniz..."></textarea>

            <label>Geçmiş Hastalıklar:</label>
            <div class="checkboxes">
                <label><input type="checkbox" name="hastaliklar[]" value="Diyabet"> Diyabet</label>
                <label><input type="checkbox" name="hastaliklar[]" value="Hipertansiyon"> Hipertansiyon</label>
                <label><input type="checkbox" name="hastaliklar[]" value="Astım"> Astım</label>
                <label><input type="checkbox" name="hastaliklar[]" value="Tiroid"> Tiroid</label>
            </div>

            <label>Günlük Su Tüketimi (litre):</label>
            <input type="number" step="0.1" name="su">

            <label>Uyku Süresi (saat):</label>
            <input type="number" step="0.5" name="uyku">

            <label>Sigara Kullanıyor musunuz?</label>
            <select name="sigara">
                <option value="Hayır">Hayır</option>
                <option value="Evet">Evet</option>
            </select>

            <label>Düzenli Kullandığınız İlaçlar:</label>
            <textarea name="ilaclar"></textarea>

            <label>Stres Seviyesi:</label>
            <input type="range" name="stres" min="0" max="10">

            <label>Adet Düzeni (Varsa):</label>
            <input type="text" name="adet_duzeni" placeholder="Düzenli / Düzensiz / Yok">

            <label>Ailede Kronik Hastalıklar:</label>
            <textarea name="aile_hastalik"></textarea>

            <label>Düzenli Spor Yapıyor musunuz?</label>
            <select name="spor">
                <option value="Evet">Evet</option>
                <option value="Hayır">Hayır</option>
            </select>

            <button type="submit">Formu Gönder</button>
            <a class="dön" href="../index.php">Ana Sayfaya Dön</a>
        </form>
    </div>
</body>
</html>