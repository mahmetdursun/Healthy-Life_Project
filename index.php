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
            <a href="pages/userLogin.php">Giriş Yap</a>
            <a href="pages/userRegistration.php" class="btn">Kayıt Ol</a>
        </nav>
    </header>

    <section class="hero">
        <h1>Sağlıklı Yaşam Yolculuğuna Başla</h1>
        <p>Hedefine ulaşmak için bugün adım at. Senin için buradayız.</p>
        <a href="pages/userRegistration.php" class="cta">Hemen Başla</a>
    </section>

    <section class="features" id="features">
        <h2>Uygulama Özellikleri</h2>
        <div class="cards">
            <div class="card">💊 İlaç Hatırlatıcı</div>
            <div class="card">🏃 Egzersiz Planlayıcı</div>
            <div class="card">🧘 Ruh Hali Takibi</div>
            <div class="card">🍽️ Beslenme ve Kalori Hesaplama</div>
            <div class="card">📊 Gelişim Raporları</div>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 SağlıklıYaşam Takip | Tüm hakları saklıdır.</p>
    </footer>

</body>
</html>
