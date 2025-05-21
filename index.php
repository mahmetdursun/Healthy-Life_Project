<?php
session_start();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sağlıklı Yaşam Takip</title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time(); ?>">
</head>
<body>

    <header class="navbar">
        <div class="logo">SağlıklıYaşam</div>
        <nav>
            <a href="#features">Özellikler</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Kullanıcı giriş yaptıysa -->
                <a href="pages/profile.php">Profilim</a>
                <a href="pages/logout.php" class="btn">Çıkış Yap</a>
            <?php else: ?>
                <!-- Giriş yapılmadıysa -->
                <a href="pages/userLogin.php">Giriş Yap</a>
                <a href="pages/userRegistration.php" class="btn">Kayıt Ol</a>
            <?php endif; ?>
        </nav>
    </header>

    <section class="hero">
        <h1>Sağlıklı Yaşam Yolculuğuna Başla</h1>
        <p>Hedefine ulaşmak için bugün adım at. Senin için buradayız.</p>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="pages/userRegistration.php" class="cta">Hemen Başla</a>
        <?php else: ?>
            <a href="pages/dashboard.php" class="cta">Kontrol Paneline Git</a>
        <?php endif; ?>
    </section>

    <section class="features" id="features">
        <h2>Uygulama Özellikleri</h2>
        <div class="cards">
            <div class="card"><a href="pages/ilachatirlatici.php">💊 İlaç Hatırlatıcı</a></div>
            <div class="card"><a href="pages/egzersizplanlayici.php">🏃 Egzersiz Planlayıcı</a></div>
            <div class="card"><a href="pages/ruhmulitakip.php">🧘 Ruh Hali Takibi</a></div>
            <div class="card"><a href="pages/beslenme.php">🍽️ Beslenme ve Kalori Hesaplama</a></div>
            <div class="card"><a href="pages/gelisimraporlari.php">📊 Gelişim Raporları</a></div>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 SağlıklıYaşam Takip | Tüm hakları saklıdır.</p>
    </footer>

</body>
</html>
