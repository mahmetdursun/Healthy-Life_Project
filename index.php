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
               <a href="pages/profile.php" class="profile-link">
                👤 <?php echo ucfirst(htmlspecialchars($_SESSION["u_adi"])); ?>
               </a>
               <a href="pages/logout.php" class="btn">Çıkış Yap</a>
            <?php else: ?>
               <!-- Giriş yapılmadıysa -->
               <a href="pages/userLogin.php">Giriş Yap</a>
               <a href="pages/userRegistration.php" class="btn">Kayıt Ol</a>
            <?php endif; ?>
        </nav>
    </header>

    <section class="hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1>Sağlıklı Yaşam <br> Takip Sistemi </h1>
            <p>Hedefine ulaşmak için bugün adım at. <br> Senin için buradayız.</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="pages/userRegistration.php" class="cta">Hemen Başla</a>
            <?php else: ?>
                <a href="pages/profile.php" class="cta">Kontrol Paneline Git</a>
            <?php endif; ?>
        </div>
    </div>
    </section>

    <section class="features" id="features">
    <h2>Uygulama Özellikleri</h2>
    <div class="cards">

        <!-- 1. İlaç Hatırlatıcı -->
        <div class="card">
            <img src="assets/images/ilac.jpg" alt="İlaç Hatırlatıcı">
            <h3>İlaç Hatırlatıcı</h3>
            <p>İlaç saatlerinizi belirleyin, sistem sizi e-posta ve SMS ile zamanında uyarsın.</p>
            <a href="pages/ilachatirlatici.php">Detaylı Bilgi</a>
        </div>

        <!-- 2. Egzersiz Planlayıcı -->
        <div class="card">
            <img src="assets/images/egzersiz.jpg" alt="Egzersiz Planlayıcı">
            <h3>Egzersiz Planlayıcı</h3>
            <p>Günlük antrenmanlarını kaydet, hedeflerine uygun planlarla ilerle.</p>
            <a href="pages/egzersizplanlayici.php">Detaylı Bilgi</a>
        </div>

        <!-- 3. Ruh Hali Takibi -->
        <div class="card">
            <img src="assets/images/ruh.jpg" alt="Ruh Hali Takibi">
            <h3>Ruh Hali Takibi</h3>
            <p>Duygusal durumunu kaydet, stres ve mutluluğu görselleştirerek analiz et.</p>
            <a href="pages/ruh_takibi.php">Detaylı Bilgi</a>
        </div>

        <!-- 4. Beslenme ve Kalori -->
        <div class="card">
            <img src="assets/images/beslenme.jpg" alt="Beslenme ve Kalori Hesaplama">
            <h3>Beslenme ve Kalori</h3>
            <p>Günlük öğünlerini gir, kalori hesapla, dengeli beslenmeye ulaş.</p>
            <a href="pages/kullanici_beslenme.php">Detaylı Bilgi</a>
        </div>

        <!-- 5. Gelişim Raporları -->
        <div class="card">
            <img src="assets/images/rapor.jpg" alt="Gelişim Raporları">
            <h3>Gelişim Raporları</h3>
            <p>Haftalık ve aylık grafiklerle gelişimini gör, hedeflerine ne kadar yaklaştığını takip et.</p>
            <a href="pages/gelisimraporlari.php">Detaylı Bilgi</a>
        </div>

        <!-- 6. Günlük Motivasyon -->
        <div class="card">
            <img src="assets/images/motivasyon.jpg" alt="Günlük Motivasyon">
            <h3>Günlük Motivasyon</h3>
            <p>Her gün seni harekete geçirecek kısa öneriler, alıntılar ve hedef hatırlatmaları.</p>
            <a href="pages/motivasyon.php">Detaylı Bilgi</a>
        </div>

        <!-- 7. Sağlık Bilgileri -->
        <div class="card">
            <img src="assets/images/saglik.jpg" alt="Sağlık Bilgileri">
            <h3>Sağlık Bilgileri</h3>
            <p>Temel sağlık verilerini sakla, yaş, boy, kilo gibi parametrelerini güncel tut.</p>
            <a href="pages/saglik_bilgileri.php">Detaylı Bilgi</a>
        </div>

        <!-- 8. Kişisel Hedefler -->
        <div class="card">
            <img src="assets/images/hedef.jpg" alt="Kişisel Hedefler">
            <h3>Kişisel Hedefler</h3>
            <p>Kilo, su, adım veya kalori gibi hedefler belirle, sistem seni izlesin.</p>
            <a href="pages/kisisel_hedefler.php">Detaylı Bilgi</a>
        </div>

        <!-- 9. Diyetisyen Desteği -->
        <div class="card">
            <img src="assets/images/diyetisyen.jpg" alt="Diyetisyen Desteği">
            <h3>Diyetisyen Desteği</h3>
            <p>Profesyonel diyetisyenlerle bağlantıya geç, birebir beslenme desteği al.</p>
            <a href="pages/diyetisyen_destek.php">Detaylı Bilgi</a>
        </div>

        <!-- 10. Uyku Takibi -->
        <div class="card">
            <img src="assets/images/uyku.jpg" alt="Uyku Takibi">
            <h3>Uyku Takibi</h3>
            <p>Gece ne kadar uyudun? Kaliteyi ölç, günlük enerjini optimize et.</p>
            <a href="pages/uykutakip.php">Detaylı Bilgi</a>
        </div>

    </div>
</section>



    <footer>
        <p>&copy; 2025 SağlıklıYaşam Takip | Tüm hakları saklıdır.</p>
    </footer>

</body>
</html>
