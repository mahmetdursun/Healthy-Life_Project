<?php
session_start();
require_once('../includes/connection.php');

if (!isset($_SESSION["calisan_id"])) {
    header("Location: userLogin.php");
    exit;
}

$calisan_id = $_SESSION["calisan_id"];
$calisan_tur = $_SESSION["tur"] ?? '';
$calisan_adi = $_SESSION["c_adi"] ?? '';
$calisan_soyadi = $_SESSION["c_soyadi"] ?? '';

$u_id = $_GET['u_id'] ?? null;
if (!$u_id) {
    echo "Kullanıcı bilgisi eksik.";
    exit;
}

$izinliTablolar = [
    'doktor' => ['ilaclar', 'kullanici_ruh_hali', 'kullanici_beslenme', 'saglik_bilgileri', 'kisisel_hedefler', 'uyku_kayitlari'],
    'diyetisyen' => ['egzersizler', 'kullanici_beslenme', 'kisisel_hedefler'],
    'spor_egitmeni' => ['egzersizler', 'kullanici_beslenme', 'kisisel_hedefler'],
    'hayat_kocu' => ['kullanici_ruh_hali', 'saglik_bilgileri', 'kisisel_hedefler'],
];

$gosterilecekTablolar = $izinliTablolar[$calisan_tur] ?? [];

$sutunAdlari = [
    'ilaclar' => 'user_id',
    'kullanici_ruh_hali' => 'user_id',
    'kullanici_beslenme' => 'user_id',
    'saglik_bilgileri' => 'user_id',
    'kisisel_hedefler' => 'u_id',
    'uyku_kayitlari' => 'kullanici_id',
    'egzersizler' => 'user_id',
    'diyetisyen_formlari' => 'user_id',
];

$veriler = [];

foreach ($gosterilecekTablolar as $tablo) {
    $kolon = $sutunAdlari[$tablo] ?? 'user_id';
    $sorgu = $connection->prepare("SELECT * FROM $tablo WHERE $kolon = :uid ORDER BY 1 DESC");
    $sorgu->execute(['uid' => $u_id]);
    $veriler[$tablo] = $sorgu->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Kullanıcı Verileri</title>
    <link rel="stylesheet" href="/proje/assets/css/calisan_kullanici_detay.css?v=<?= time(); ?>">
</head>

<body>
    <div class="container">
        <h1>👤 Kullanıcı Verileri (Çalışan: <?= htmlspecialchars($calisan_adi . ' ' . $calisan_soyadi) ?>)</h1>
        <a href="calisan_paneli.php" class="btn">⬅️ Geri Dön</a>

        <?php foreach ($veriler as $tablo => $rows): ?>
        <section class="veri-kutusu">
            <?php
$basliklar = [
    'ilaclar' => 'İlaçlar',
    'kullanici_ruh_hali' => 'Ruh Hali Kayıtları',
    'kullanici_beslenme' => 'Beslenme Kayıtları',
    'saglik_bilgileri' => 'Sağlık Bilgileri',
    'kisisel_hedefler' => 'Kişisel Hedefler',
    'uyku_kayitlari' => 'Uyku Takibi',
    'egzersizler' => 'Egzersiz Planı',
    'diyetisyen_formlari' => 'Diyetisyen Formları'
];
?>
            <h2><?= $basliklar[$tablo] ?? ucfirst(str_replace('_', ' ', $tablo)) ?></h2>

            <?php if (empty($rows)): ?>
            <p>Veri bulunamadı.</p>
            <?php else: ?>
            <table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <?php foreach (array_keys($rows[0]) as $col): ?>
                        <th><?= htmlspecialchars($col) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                    <tr>
                        <?php foreach ($row as $val): ?>
                        <td><?= htmlspecialchars($val) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </section>
        <?php endforeach; ?>
    </div>
</body>

</html>