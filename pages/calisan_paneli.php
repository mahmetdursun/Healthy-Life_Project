<?php
session_start();
require_once('../includes/connection.php');

// Giriş kontrolü
if (!isset($_SESSION["calisan_id"])) {
    header("Location: userLogin.php");
    exit;
}

$calisan_adi = $_SESSION["c_adi"] ?? '';
$calisan_soyadi = $_SESSION["c_soyadi"] ?? '';
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
                <p>Buradan size atanmış kullanıcıların sağlık bilgilerini, diyet planlarını veya egzersiz kayıtlarını görebileceksiniz.</p>
                <!-- Sonradan: Kullanıcı listeleme, yönlendirme butonları -->
            </section>
        </main>
    </div>
</body>
</html>
