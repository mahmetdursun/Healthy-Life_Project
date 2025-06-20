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
                <a href="pages/tarif-yemek_sec.php">Detaylı Bilgi</a>
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

    <section class="fit-tarifler">
        <a href="pages/tarifler.php">
            <h2 class="fit-tarifler__baslik">🔥 Fit Tarifler</h2>
            <div class="fit-tarifler__marquee">
                <div class="fit-tarifler__marquee-content">
                    <?php for ($i = 0; $i < 2; $i++): ?>
                    <a href="tarifler.php?tarif=yulaf-ruyasi" class="tarif-kart">
                        <img src="assets/images/fit-yulaf_omlet.png" alt="Yulaf Rüyası Omlet">
                        <div class="etiket">15dk</div>
                        <div class="makro">
                            <span>594kcal</span>
                            <span>58.9g karb</span>
                            <span>33.3g pro</span>
                            <span>15.7g yağ</span>
                        </div>
                        <h3>Yulaf Rüyası Omlet</h3>
                        <p>Omleti en çok kahvaltıda mı seversiniz? Bu tarif tam sana göre.</p>
                    </a>

                    <a href="tarifler.php?tarif=protein-pankek" class="tarif-kart">
                        <img src="assets/images/fit-protein_kek.png" alt="Protein Pankek">
                        <div class="etiket">20dk</div>
                        <div class="makro">
                            <span>470kcal</span>
                            <span>38g karb</span>
                            <span>27g pro</span>
                            <span>12g yağ</span>
                        </div>
                        <h3>Protein Pankek</h3>
                        <p>Kaslarını besle, enerjini koru. Tatlı krizlerine fit çözüm.</p>
                    </a>

                    <a href="tarifler.php?tarif=tavuklu-kinoali-salata" class="tarif-kart">
                        <img src="assets/images/fit-tavuklu_kinoa.png" alt="Tavuklu Kinoa Salatası">
                        <div class="etiket">25dk</div>
                        <div class="makro">
                            <span>520kcal</span>
                            <span>42g karb</span>
                            <span>35g pro</span>
                            <span>14g yağ</span>
                        </div>
                        <h3>Tavuklu Kinoa Salatası</h3>
                        <p>Hem hafif hem doyurucu. Öğle öğünü için ideal.</p>
                    </a>

                    <a href="tarifler.php?tarif=sebzeli-firin-omlet" class="tarif-kart">
                        <img src="assets/images/fit-sebzeli_fırın_omlet.png" alt="Sebzeli Fırın Omlet">
                        <div class="etiket">18dk</div>
                        <div class="makro">
                            <span>430kcal</span>
                            <span>20g karb</span>
                            <span>29g pro</span>
                            <span>18g yağ</span>
                        </div>
                        <h3>Sebzeli Fırın Omlet</h3>
                        <p>Yumurtaya yeni bir boyut: fırınlanmış, fit, sebzeli.</p>
                    </a>

                    <a href="tarifler.php?tarif=ton-balikli-sandvic" class="tarif-kart">
                        <img src="assets/images/fit-ton_sandvic.png" alt="Ton Balıklı Sandviç">
                        <div class="etiket">10dk</div>
                        <div class="makro">
                            <span>395kcal</span>
                            <span>30g karb</span>
                            <span>28g pro</span>
                            <span>11g yağ</span>
                        </div>
                        <h3>Ton Balıklı Sandviç</h3>
                        <p>Hızlı, pratik ve besleyici bir öğün arayanlara özel.</p>
                    </a>

                    <a href="tarifler.php?tarif=fit-kabak-muffin" class="tarif-kart">
                        <img src="assets/images/fit-kabak_muffin.png" alt="Fit Kabak Muffin">
                        <div class="etiket">30dk</div>
                        <div class="makro">
                            <span>310kcal</span>
                            <span>22g karb</span>
                            <span>12g pro</span>
                            <span>9g yağ</span>
                        </div>
                        <h3>Fit Kabak Muffin</h3>
                        <p>Öğün arası atıştırmalıkta sebze ve lezzet bir arada.</p>
                    </a>
                    <?php endfor; ?>
                </div>
            </div>
        </a>
    </section>

    <footer>
        <p>&copy; 2025 SağlıklıYaşam Takip | Tüm hakları saklıdır.</p>
    </footer>

</body>

</html>