<?php
session_start();
require_once('../includes/connection.php');

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_message'] = 'Bu sayfayı görüntülemek için giriş yapmalısınız.';
    header("Location: userLogin.php");
    exit;
}

// Kullanıcı bilgilerini 
$user_id = $_SESSION['user_id'];
$user_query = $connection->prepare("SELECT * FROM user WHERE u_id = :id");
$user_query->execute(['id' => $user_id]);
$user = $user_query->fetch(PDO::FETCH_ASSOC);
$section = $_GET['section'] ?? 'profil';

// İlaçlar
$ilac_query = $connection->prepare("SELECT * FROM ilaclar WHERE user_id = :id ORDER BY ilac_saati DESC");
$ilac_query->execute(['id' => $user_id]);
$ilaclar = $ilac_query->fetchAll(PDO::FETCH_ASSOC);

// Egzersizler ve toplam kalori
$egz_query = $connection->prepare("SELECT * FROM egzersizler WHERE user_id = :id");
$egz_query->execute(['id' => $user_id]);
$egzersizler = $egz_query->fetchAll(PDO::FETCH_ASSOC);

// Yakılan toplam kaloriyi hesapla (örneğin 5 kcal / dk varsayalım)
$toplamEgzKalori = 0;
foreach ($egzersizler as $egz) {
    $toplamEgzKalori += $egz['suresi'] * 5;
}

// Ruh hali
$ruh_query = $connection->prepare("SELECT * FROM kullanici_ruh_hali WHERE user_id = :id ORDER BY tarih DESC");
$ruh_query->execute(['id' => $user_id]);
$ruhlar = $ruh_query->fetchAll(PDO::FETCH_ASSOC);

// Beslenme bilgisi: kalori, protein, karbonhidrat, yag
$bes_query = $connection->prepare("SELECT 
    SUM(kalori) AS toplam_kalori,
    SUM(protein) AS toplam_protein,
    SUM(karbonhidrat) AS toplam_karbonhidrat,
    SUM(yag) AS toplam_yag
    FROM kullanici_beslenme 
    WHERE user_id = :id AND tarih = CURDATE()");
$bes_query->execute(['id' => $user_id]);
$bes = $bes_query->fetch(PDO::FETCH_ASSOC);
$toplamKalori = $bes['toplam_kalori'] ?? 0;
$toplamProtein = intval($bes['toplam_protein'] ?? 0);
$toplamKarbonhidrat = intval($bes['toplam_karbonhidrat'] ?? 0);
$toplamYag = intval($bes['toplam_yag'] ?? 0);
$gunluk_kalori = $user['gunluk_kalori'] ?? 0;

if ($gunluk_kalori > 0) {
    $kalori_yuzde = min(100, round(($toplamKalori / $gunluk_kalori) * 100));
} else {
    $kalori_yuzde = 0; // veya null, uyarı göstermek için
}

// Sağlık bilgisi
$saglik_query = $connection->prepare("SELECT * FROM saglik_bilgileri WHERE user_id = :id ORDER BY id DESC LIMIT 1");
$saglik_query->execute(['id' => $user_id]);
$saglik = $saglik_query->fetch(PDO::FETCH_ASSOC);

// Hedefler
$hedef_query = $connection->prepare("SELECT * FROM kisisel_hedefler WHERE u_id = :id ORDER BY created_at DESC");
$hedef_query->execute(['id' => $user_id]);
$hedefler = $hedef_query->fetchAll(PDO::FETCH_ASSOC);

// Diyetisyen desteği
$diyet_query = $connection->prepare("SELECT * FROM diyetisyen_formlari WHERE adsoyad = :adsoyad ORDER BY id DESC LIMIT 1");
$diyet_query->execute(['adsoyad' => $user['u_adi'] . ' ' . $user['u_soyadi']]);
$diyet_form = $diyet_query->fetch(PDO::FETCH_ASSOC);

// Uyku takibi
$uyku_query = $connection->prepare("SELECT * FROM uyku_kayitlari WHERE kullanici_id = :id ORDER BY tarih DESC");
$uyku_query->execute(['id' => $user_id]);
$uykular = $uyku_query->fetchAll(PDO::FETCH_ASSOC);

// Randevular
$randevu_query = $connection->prepare("
    SELECT r.r_id, c.c_adi, c.c_soyadi, c.uzmanlik, r.tarih, r.saat, r.randevu_notu
    FROM randevular r
    JOIN calisanlar c ON r.c_id = c.c_id
    WHERE r.u_id = :id
    ORDER BY r.tarih DESC
");
$randevu_query->execute(['id' => $user_id]);
$randevular = $randevu_query->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Profil Sayfası</title>
    <link rel="stylesheet" href="../assets/css/profile.css?v=<?= time(); ?>">
</head>

<body>

    <aside>
        <h2>Menü</h2>
        <a href="../index.php">Ana Sayfaya Dön</a>
        <a href="?section=profil" class="<?= $section === 'profil' ? 'active' : '' ?>">👤 Profil</a>
        <a href="?section=ilaclar" class="<?= $section === 'ilaclar' ? 'active' : '' ?>">💊 İlaçlar</a>
        <a href="?section=egzersiz" class="<?= $section === 'egzersiz' ? 'active' : '' ?>">🏃‍♂️ Egzersiz</a>
        <a href="?section=ruh" class="<?= $section === 'ruh' ? 'active' : '' ?>">🙂 Ruh Hali</a>
        <a href="?section=beslenme" class="<?= $section === 'beslenme' ? 'active' : '' ?>">🍽️ Beslenme</a>
        <a href="?section=saglik" class="<?= $section === 'saglik' ? 'active' : '' ?>">🧬 Sağlık Bilgisi</a>
        <a href="?section=hedef" class="<?= $section === 'hedef' ? 'active' : '' ?>">🎯 Hedefler</a>
        <a href="?section=diyet" class="<?= $section === 'diyet' ? 'active' : '' ?>">🥗 Diyetisyen</a>
        <a href="?section=uyku" class="<?= $section === 'uyku' ? 'active' : '' ?>">😴 Uyku</a>
        <a href="?section=randevular" class="<?= $section === 'randevular' ? 'active' : '' ?>">📅 Randevularım</a>
    </aside>

    <main>
        <?php if ($section === 'profil'): ?>
        <div class="block">
            <h2 class="block-header">Profil Bilgileri</h2>

            <div class="block-header-c">
                <?php if (!empty($user['profil_resmi'])): ?>
                <img src="../uploads/<?= htmlspecialchars($user['profil_resmi']) ?>" class="block-header-c-img">
                <?php else: ?>
                <div class="block-header-c-box"></div>
                <?php endif; ?>
                <br><br>
                <form action="profil_resim.php" method="POST" enctype="multipart/form-data">
                    <label class="file-label">
                        📁 Dosya Seç
                        <input type="file" name="profil_resmi" class="file-input">
                    </label>
                    <button type="submit" class="btn upload-btn">📤 Yükle</button>
                </form>
            </div>

            <div class="readonly-grid">
                <div>
                    <label>Ad</label>
                    <div class="readonly-box"><?= htmlspecialchars($user['u_adi']) ?></div>
                </div>
                <div>
                    <label>Soyad</label>
                    <div class="readonly-box"><?= htmlspecialchars($user['u_soyadi']) ?></div>
                </div>
                <div>
                    <label>Email</label>
                    <div class="readonly-box"><?= htmlspecialchars($user['u_mail']) ?></div>
                </div>
                <div>
                    <label>Telefon</label>
                    <div class="readonly-box"><?= htmlspecialchars($user['u_telefon']) ?></div>
                </div>
            </div>
        </div>

        <?php elseif ($section === 'ilaclar'): ?>
        <div class="block">
            <h2 class="section-title">💊 İlaçlarım</h2>

            <div class="ilaclar-listesi">
                <?php if (empty($ilaclar)): ?>
                <p class="bos-ilac-mesaji">Kayıtlı ilacınız bulunmamaktadır.</p>
                <?php else: ?>
                <?php foreach ($ilaclar as $ilac): ?>
                <div class="ilac-item">
                    <div class="ilac-info">
                        <strong><?= htmlspecialchars($ilac['ilac_ismi']) ?></strong>
                        <span class="ilac-saat"><?= $ilac['ilac_saati'] ?></span>
                    </div>
                    <form action="profil_ilac_sil.php" method="POST" class="ilac-sil-form">
                        <input type="hidden" name="ilac_id" value="<?= $ilac['id'] ?>">
                        <button type="submit" class="btn red">Sil</button>
                    </form>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="ilac-ekle-container">
                <a href="ilachatirlatici.php" class="btn btn-ekle">
                    ➕ Yeni İlaç Ekle
                </a>
            </div>
        </div>

        <?php elseif ($section === 'egzersiz'): ?>
        <div class="block">
            <h2>🏃‍♂️ Egzersizlerim</h2>
            <br>
            <div class="egzersiz-container">
                <?php foreach ($egzersizler as $e): ?>
                <div class="egzersiz-card">
                    <div class="egzersiz-baslik"><?= htmlspecialchars($e['egzersiz_adi']) ?></div>
                    <div class="egzersiz-detay">
                        Süre: <?= $e['suresi'] ?> dk <br>
                        Zaman: <?= $e['baslangic_saati'] ?> - <?= $e['bitis_saati'] ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <div class="egzersiz-kalori">
                    <strong>Toplam Yakılan Kalori:</strong> <?= $toplamEgzKalori ?> kcal
                </div>

                <div class="egzersiz-ekle">
                    <a href="egzersizplanlayici.php" class="btn btn-ekle">➕ Egzersiz Ekle</a>
                </div>
            </div>
        </div>
        <?php elseif ($section === 'ruh'): ?>
        <div class="block">
            <h2>🙂 Ruh Halim</h2>
            <br>
            <div class="ruh-container">
                <?php foreach ($ruhlar as $ruh): ?>
                <div class="ruh-card">
                    <div class="ruh-tarih"><?= htmlspecialchars($ruh['tarih']) ?></div>
                    <div class="ruh-hali"><?= htmlspecialchars($ruh['ruh_hali']) ?></div>
                    <div class="ruh-yorum"><?= htmlspecialchars($ruh['yorum']) ?></div>
                </div>
                <?php endforeach; ?>

                <div class="ruh-ekle">
                    <a href="ruh_takibi.php" class="btn btn-ekle">➕ Ruh Hali Ekle</a>
                </div>
            </div>
        </div>
        <?php elseif ($section === 'beslenme'): ?>
        <div class="block">
            <h2 class="section-title">🍽️ Beslenme Bilgilerim</h2>
            <div class="nutrition-stats-box">
                <div class="nutrition-stat"><strong>Toplam Kalori:</strong> <?= $toplamKalori ?> kcal</div>
                <div class="nutrition-stat">
                    <strong>Protein:</strong> <?= $toplamProtein ?> g |
                    <strong>Karbonhidrat:</strong> <?= $toplamKarbonhidrat ?> g |
                    <strong>Yağ:</strong> <?= $toplamYag ?> g
                </div>
                <div class="nutrition-stat"><strong>Günlük Kalori Hedefi:</strong> <?= $gunluk_kalori ?> kcal</div>

                <div class="progress-bar-outer">
                    <div class="progress-bar-inner" style="width: <?= $kalori_yuzde ?>%;">
                        <?= $kalori_yuzde ?>%
                    </div>
                </div>

                <div class="btn-container">
                    <a href="tarif-yemek_sec.php.php" class="btn btn-ekle">➕ Beslenme Ekle</a>
                </div>
            </div>
        </div>
        <?php elseif ($section === 'saglik'): ?>
        <div class="profil-saglik">
            <h2 class="profil-saglik__title">🧬 Sağlık Bilgilerim</h2>
            <div class="profil-saglik__box">
                <div class="profil-saglik__item"><strong>Boy:</strong> 178 cm</div>
                <div class="profil-saglik__item"><strong>Kilo:</strong> 70 kg</div>
                <div class="profil-saglik__item"><strong>Kan Grubu:</strong> 0 Rh+</div>
                <div class="profil-saglik__btn-wrapper">
                    <a href="/proje/pages/saglik_bilgileri.php" class="btn btn--secondary">Bilgileri Düzenle</a>
                </div>
            </div>
        </div>
        <?php elseif ($section === 'hedef'): ?>
        <div class="profil-hedef">
            <h2 class="profil-hedef__title">🎯 Kişisel Hedefler</h2>
            <div class="profil-hedef__list">
                <?php foreach ($hedefler as $hedef): ?>
                <div class="profil-hedef__card">
                    <div class="profil-hedef__card-header">
                        <span><?= $hedef['created_at'] ?></span>
                    </div>

                    <div class="profil-hedef__card-content">
                        <!-- Su, Uyku, Adım -->
                        <div class="subcard">
                            <h4>Günlük Takip</h4>
                            <div class="subcard-content">
                                <div class="stat-box"><span>💧 Su:</span> <?= $hedef['su_hedef'] ?> L</div>
                                <div class="stat-box"><span>😴 Uyku:</span> <?= $hedef['uyku_hedef'] ?> Saat</div>
                                <div class="stat-box"><span>👟 Adım:</span> <?= $hedef['adim_hedef'] ?></div>
                            </div>
                        </div>

                        <!-- Sabah / Akşam Rutin -->
                        <div class="subcard">
                            <h4>Rutinler</h4>
                            <div class="subcard-content">
                                <div class="stat-box"><span>🌅 Sabah:</span> <?= $hedef['sabah_rutin'] ?></div>
                                <div class="stat-box"><span>🌙 Akşam:</span> <?= $hedef['aksam_rutin'] ?></div>
                            </div>
                        </div>

                        <!-- Minnettarlık / Ruh Hali -->
                        <div class="subcard">
                            <h4>Duygusal Durum</h4>
                            <div class="subcard-content">
                                <div class="stat-box"><span>🙏 Minnettarlık:</span> <?= $hedef['minnettarlik'] ?></div>
                                <div class="stat-box"><span>🙂 Ruh Hali:</span> <?= $hedef['ruh_hali'] ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="profil-hedef__add">
                <a class="profil-hedef-btn" href="kisisel_hedefler.php" >+ Yeni Hedef Ekle</a>
            </div>
        </div>

        <?php elseif ($section === 'diyet'): ?>
        <div class="profil-diyet">
            <h2 class="profil-diyet__title">🥗 Diyetisyen Desteği</h2>
            <div class="profil-diyet__card">
                <?php if ($diyet_form): ?>
                <div class="diyet-info">
                    <div class="diyet-row">
                        <span class="diyet-label">👤 Ad:</span> <?= htmlspecialchars($diyet_form['adsoyad']) ?>
                    </div>
                    <div class="diyet-row">
                        <span class="diyet-label">🎯 Hedef Kilo:</span>
                        <?= htmlspecialchars($diyet_form['hedef_kilo']) ?> kg
                    </div>
                    <div class="diyet-row">
                        <span class="diyet-label">🍽️ Tercih:</span> <?= htmlspecialchars($diyet_form['tercih']) ?>
                    </div>
                    <div class="diyet-row">
                        <span class="diyet-label">⚠️ Alerji:</span> <?= htmlspecialchars($diyet_form['alerji']) ?>
                    </div>
                    <div class="profil-diyet__btn">
                        <button class="btn">Düzenle</button>
                    </div>
                </div>
                <?php else: ?>
                <div class="profil-diyet__btn">
                    <button class="btn">Diyetisyen Desteği Al</button>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php elseif ($section === 'uyku'): ?>
        <div class="profil-uyku">
            <h2 class="profil-uyku__title">😴 Uyku Takibi</h2>
            <div class="profil-uyku__list">
                <?php foreach ($uykular as $uyku): ?>
                <div class="profil-uyku__card">
                    <div class="uyku-row">
                        <span class="uyku-label">📅 Tarih:</span> <?= htmlspecialchars($uyku['tarih']) ?>
                    </div>
                    <div class="uyku-row">
                        <span class="uyku-label">🛏️ Uyuma:</span> <?= htmlspecialchars($uyku['uyuma_saati']) ?>
                        <span class="uyku-label">⏰ Uyanma:</span> <?= htmlspecialchars($uyku['uyanma_saati']) ?>
                    </div>
                    <div class="uyku-row">
                        <span class="uyku-label">📝 Not:</span> <?= nl2br(htmlspecialchars($uyku['notlar'])) ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <div class="profil-uyku__btn">
                    <a class="profil-hedef-btn" href="uykutakip.php">+ Yeni Uyku Kaydı</a>
                </div>
            </div>
        </div>

        <?php elseif ($section === 'randevular'): ?>
        <div class="block">
            <h2 class="section-title">📅 Randevularım</h2>
            <?php if (empty($randevular)): ?>
            <p>Henüz randevunuz bulunmamaktadır.</p>
            <?php else: ?>
            <div class="randevu-listesi">
                <?php foreach ($randevular as $r): ?>
                <div class="randevu-card">
                    <strong><?= htmlspecialchars($r['c_adi'] . ' ' . $r['c_soyadi']) ?></strong> -
                    <?= htmlspecialchars($r['uzmanlik']) ?><br>
                    📅 <?= $r['tarih'] ?> ⏰ <?= $r['saat'] ?><br>
                    📝 <?= nl2br(htmlspecialchars($r['randevu_notu'])) ?>
                </div>
                <a href="mesaj_gonder.php?randevu_id=<?= $r['r_id'] ?>" class="btn btn-mesaj">✉️ Mesaj Gönder</a>
                <form action="profil_randevu_sil.php" method="POST" style="display:inline;">
                    <input type="hidden" name="randevu_id" value="<?= $r['r_id'] ?>">
                    <button type="submit" class="btn red">Sil</button>
                </form>
                <a href="profil_randevu_guncelle.php?id=<?= $r['r_id'] ?>" class="btn">Güncelle</a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </main>

</body>

</html>