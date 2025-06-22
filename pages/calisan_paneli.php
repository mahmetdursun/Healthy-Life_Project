<?php
session_start();
require_once('../includes/connection.php');
// $_SESSION["tur"] = 'doktor'; // geçici olarak test etmek için

// Giriş kontrolü
if (!isset($_SESSION["calisan_id"])) {
    header("Location: userLogin.php");
    exit;
}

$calisan_adi = $_SESSION["c_adi"] ?? '';
$calisan_soyadi = $_SESSION["c_soyadi"] ?? '';

$calisan_id = $_SESSION["calisan_id"];

// Randevulu kullanıcıları çek
$kullanicilarSorgu = $connection->prepare("
    SELECT DISTINCT u.u_id, u.u_adi, u.u_soyadi, r.tarih, r.saat
    FROM randevular r
    JOIN user u ON r.u_id = u.u_id
    WHERE r.c_id = :cid
    ORDER BY r.tarih DESC
");
$kullanicilarSorgu->execute(['cid' => $calisan_id]);
$kullanicilar = $kullanicilarSorgu->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Çalışan Paneli</title>
    <link rel="stylesheet" href="/proje/assets/css/calisan_panel.css?v=<?= time(); ?>">
</head>

<body>
    <div class="calisan-panel-container">
        <header>
            <h1>👨‍⚕️ Hoş Geldiniz, <?= htmlspecialchars($calisan_adi . ' ' . $calisan_soyadi) ?></h1>
            <a href="logout.php" class="logout-button">Çıkış Yap</a>
        </header>

        <main>
            <section class="panel-box">
                <h2>📋 Görev Paneliniz</h2>
                <p>Buradan size atanmış kullanıcıların sağlık bilgilerini, diyet planlarını veya egzersiz kayıtlarını
                    görebileceksiniz.</p>
                <!-- Sonradan: Kullanıcı listeleme, yönlendirme butonları -->
                <a href="calisan_mesajlar.php" class="btn btn-primary">📨 Gelen Mesajlar</a>
            </section>
        </main>
        <section class="panel-box">
            <h2>👥 Randevulu Kullanıcılar</h2>
            <?php if (empty($kullanicilar)): ?>
            <p>Henüz randevu alınmamış.</p>
            <?php else: ?>
            <ul class="kullanici-listesi">
                <?php foreach ($kullanicilar as $k): ?>
                <li class="kullanici-kart">
                    <strong><?= htmlspecialchars($k['u_adi'] . ' ' . $k['u_soyadi']) ?></strong><br>
                    📅 <?= $k['tarih'] ?> ⏰ <?= $k['saat'] ?><br>
                    <a href="calisan_kullanici_detay.php?u_id=<?= $k['u_id'] ?>" class="btn">🔍 Kullanıcıyı Gör</a>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </section>
    </div>
</body>

</html>