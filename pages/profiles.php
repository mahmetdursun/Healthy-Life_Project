<?php
session_start();
require_once('../includes/connection.php');

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_message'] = 'Bu sayfayı görüntülemek için giriş yapmalısınız.';
    header("Location: userLogin.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Kullanıcı bilgilerini al
$user_query = $connection->prepare("SELECT * FROM user WHERE u_id = :id");
$user_query->execute(['id' => $user_id]);
$user = $user_query->fetch(PDO::FETCH_ASSOC);

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
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Profilim</title>
    <link rel="stylesheet" href="../assets/css/profile.css?v=<?= time(); ?>">
</head>
<body>

<h1>👤 Kullanıcı Bilgileri</h1>
<a href="../index.php">Ana Sayfaya Dön</a>
<div class="block">
    <strong>Ad Soyad:</strong> <?= htmlspecialchars($user['u_adi'] . ' ' . $user['u_soyadi']) ?><br>
    <strong>Email:</strong> <?= htmlspecialchars($user['u_mail']) ?><br>
    <strong>Telefon:</strong> <?= htmlspecialchars($user['u_telefon']) ?>
</div>

<h2>💊 İlaçlarım</h2>
<div class="block">
    <?php foreach ($ilaclar as $ilac): ?>
        <div class="ilac"><?= htmlspecialchars($ilac['ilac_ismi']) ?> - <?= $ilac['ilac_saati'] ?> <button class="btn red">Sil</button></div>
    <?php endforeach; ?>
    <button class="btn">+ Yeni İlaç Ekle</button>
</div>

<h2>🏃‍♂️ Egzersizlerim</h2>
<div class="block">
    <?php foreach ($egzersizler as $e): ?>
        <div class="egz">
            <?= htmlspecialchars($e['egzersiz_adi']) ?> | Süre: <?= $e['suresi'] ?> dk | <?= $e['baslangic_saati'] ?> - <?= $e['bitis_saati'] ?>
        </div>
    <?php endforeach; ?>
    <br>
    <p><strong>Toplam Yakılan Kalori:</strong> <?= $toplamEgzKalori ?> kcal</p>
    <button class="btn">+ Egzersiz Ekle</button>
</div>

<h2>🙂 Ruh Halim</h2>
<div class="block">
    <?php foreach ($ruhlar as $ruh): ?>
        <div class="ruh"><?= $ruh['tarih'] ?>: <?= $ruh['ruh_hali'] ?> - <?= $ruh['yorum'] ?></div>
    <?php endforeach; ?>
    <button class="btn">+ Ruh Hali Ekle</button>
</div>

<h2>🍽️ Beslenme Bilgilerim</h2>
<div class="block">
    <p><strong>Toplam Kalori:</strong> <?= $toplamKalori ?> kcal</p>
    <p><strong>Protein:</strong> <?= $toplamProtein ?> g | <strong>Karbonhidrat:</strong> <?= $toplamKarbonhidrat ?> g | <strong>Yağ:</strong> <?= $toplamYag ?> g</p>
    <p><strong>Günlük Kalori Hedefi:</strong> <?= $gunluk_kalori ?> kcal</p>
    <div style="width: 100%; background: #eee; border-radius: 8px; overflow: hidden; height: 24px;">
        <div style="width: <?= $kalori_yuzde ?>%; background: #4caf50; height: 100%; color: #fff; text-align: center; line-height: 24px;">
            <?= $kalori_yuzde ?>%
        </div>
    </div>
    <br>
    <button class="btn">+ Beslenme Ekle</button>
</div>


<h2>🧬 Sağlık Bilgilerim</h2>
<div class="block">
    Boy: <?= $saglik['boy'] ?> cm<br>
    Kilo: <?= $saglik['kilo'] ?> kg<br>
    Kan Grubu: <?= $saglik['kan_grubu'] ?><br>
    <button class="btn">Bilgileri Düzenle</button>
</div>

<h2>🎯 Kişisel Hedefler</h2>
<div class="block">
    <?php foreach ($hedefler as $hedef): ?>
        <div>
            <strong><?= $hedef['created_at'] ?>:</strong>
            Su: <?= $hedef['su_hedef'] ?> L |
            Uyku: <?= $hedef['uyku_hedef'] ?> Saat |
            Adım: <?= $hedef['adim_hedef'] ?> <br>
            Sabah: <?= $hedef['sabah_rutin'] ?> |
            Akşam: <?= $hedef['aksam_rutin'] ?> <br>
            Minnettarlık: <?= $hedef['minnettarlik'] ?> |
            Ruh Hali: <?= $hedef['ruh_hali'] ?>
        </div><br>
    <?php endforeach; ?>
    <button class="btn">+ Yeni Hedef Ekle</button>
</div>

<h2>🥗 Diyetisyen Desteği</h2>
<div class="block">
    <?php if ($diyet_form): ?>
        Ad: <?= $diyet_form['adsoyad'] ?> - Hedef Kilo: <?= $diyet_form['hedef_kilo'] ?><br>
        Tercih: <?= $diyet_form['tercih'] ?> - Alerji: <?= $diyet_form['alerji'] ?><br>
        <button class="btn">Düzenle</button>
    <?php else: ?>
        <button class="btn">Diyetisyen Desteği Al</button>
    <?php endif; ?>
</div>

<h2>😴 Uyku Takibi</h2>
<div class="block">
    <?php foreach ($uykular as $uyku): ?>
        <div class="uyku">
            <?= $uyku['tarih'] ?> | Uyuma: <?= $uyku['uyuma_saati'] ?> | Uyanma: <?= $uyku['uyanma_saati'] ?><br>
            <?= $uyku['notlar'] ?>
        </div><br>
    <?php endforeach; ?>
    <button class="btn">+ Yeni Uyku Kaydı</button>
</div>

</body>
</html>
