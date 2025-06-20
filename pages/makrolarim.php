<?php
session_start();
require_once('../includes/connection.php');

// Oturum kontrolü
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    header('Location: userLogin.php');
    exit;
}

// Günlük hedefleri çek (user tablosundan)
$stmt = $connection->prepare("SELECT gunluk_kalori, gunluk_protein, gunluk_karbonhidrat, gunluk_yag FROM user WHERE u_id = :id");
$stmt->execute([':id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Kullanıcı verisi bulunamadı.";
    exit;
}

// Değerleri al
$hedef_kalori = (float)$user['gunluk_kalori'];
$hedef_protein = (float)$user['gunluk_protein'];
$hedef_karb = (float)$user['gunluk_karbonhidrat'];
$hedef_yag = (float)$user['gunluk_yag'];

// Bugünkü alınan verileri topla
$tarih = $_GET['tarih'] ?? date('Y-m-d');
$stmt2 = $connection->prepare("
    SELECT 
        SUM(kalori) as alinan_kalori,
        SUM(protein) as alinan_protein,
        SUM(karbonhidrat) as alinan_karb,
        SUM(yag) as alinan_yag
    FROM kullanici_beslenme
    WHERE user_id = :id AND tarih = :tarih
");
$stmt2->execute([':id' => $userId, ':tarih' => $tarih]);
$alinan = $stmt2->fetch(PDO::FETCH_ASSOC);

// Alınan değerleri varsayılan 0 olarak belirle
$alinan_kalori = (float)($alinan['alinan_kalori'] ?? 0);
$alinan_protein = (float)($alinan['alinan_protein'] ?? 0);
$alinan_karb = (float)($alinan['alinan_karb'] ?? 0);
$alinan_yag = (float)($alinan['alinan_yag'] ?? 0);

// Kalan değerleri hesapla
$kalan_kalori = max(0, $hedef_kalori - $alinan_kalori);
$kalan_protein = max(0, $hedef_protein - $alinan_protein);
$kalan_karb = max(0, $hedef_karb - $alinan_karb);
$kalan_yag = max(0, $hedef_yag - $alinan_yag);
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Makrolarım</title>
    <link rel="stylesheet" href="../assets/css/makrolarim.css?v=<?= time(); ?>">
</head>

<body>
    <div class="makro-page">
        <div class="makro-header">
            <h2>Makrolarım</h2>
            <span class="date"><?= date("d.m.Y") ?></span>
        </div>

        <div class="makro-panel">
            <div class="makro-kalori">
                <h4>Kalori</h4>
                <div class="kalori-semicircle">
                    <svg viewBox="0 0 100 50" class="kalori-arc">
                        <path d="M 10 50 A 40 40 0 0 1 90 50" stroke="#3B82F6" stroke-width="5" fill="none" />
                    </svg>
                    <span class="label">kalan</span>
                    <span class="kalan-value"><?= $kalan_kalori ?> kcal</span>
                </div>
                <div class="kalori-degerler">
                    <span><?= $alinan_kalori ?></span>
                    <span><?= $hedef_kalori ?></span>
                </div>
            </div>

            <div class="makro-kutu protein">
                <span class="etiket">Protein</span>
                <span class="deger"><?= $alinan_protein ?> / <?= $hedef_protein ?>g</span>
                <div class="cizgi"></div>
                <small>kalan: <?= $kalan_protein ?>g</small>
            </div>

            <div class="makro-kutu karb">
                <span class="etiket">Karb.</span>
                <span class="deger"><?= $alinan_karb ?> / <?= $hedef_karb ?>g</span>
                <div class="cizgi"></div>
                <small>kalan: <?= $kalan_karb ?>g</small>
            </div>

            <div class="makro-kutu yag">
                <span class="etiket">Yağ</span>
                <span class="deger"><?= $alinan_yag ?> / <?= $hedef_yag ?>g</span>
                <div class="cizgi"></div>
                <small>kalan: <?= $kalan_yag ?>g</small>
            </div>

            <div class="su-kutusu">
                <h4>Su</h4>
                <div class="su-gorsel">
                    <span>-</span>
                    <span>0L</span>
                    <div class="bardaklar">
                        <?php for ($i = 0; $i < 6; $i++): ?>
                        <div class="bardak"></div>
                        <?php endfor; ?>
                    </div>
                    <span>3L</span>
                    <span>+</span>
                </div>
            </div>
        </div>

        <div class="yediklerim">
            <h3>Yediklerim</h3>

            <form method="GET" action="">
                <label for="tarih">📅 Tarih Seç:</label>
                <input type="date" name="tarih" id="tarih" value="<?= $_GET['tarih'] ?? date('Y-m-d') ?>">
                <button type="submit">Göster</button>
            </form>

            <?php
    $tarih = $_GET['tarih'] ?? date('Y-m-d');
    $ogunler = ['sabah' => '🌞 Sabah', 'ogle' => '🌤️ Öğle', 'aksam' => '🌙 Akşam'];

    foreach ($ogunler as $ogun_key => $ogun_label):
        $stmt = $connection->prepare("
            SELECT yemek, miktar, karbonhidrat, protein, yag, kalori 
            FROM kullanici_beslenme 
            WHERE user_id = :id AND LOWER(ogun) = :ogun AND tarih = :tarih
        ");
        $stmt->execute([
            ':id' => $userId,
            ':ogun' => strtolower($ogun_key),
            ':tarih' => $tarih
        ]);
        $yemekler = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($yemekler) > 0): ?>
            <div class="ogun-kart-baslik">
                <h4><?= $ogun_label ?> (<?= date("d.m.Y", strtotime($tarih)) ?>)</h4>
            </div>
            <?php foreach ($yemekler as $yemek): ?>
            <div class="yemek-kart">
                <div class="yemek-kart-icerik">
                    <div class="yemek-bilgileri">
                        <strong><?= htmlspecialchars($yemek['yemek']) ?></strong><br>
                        <?= $yemek['miktar'] ?>g için:<br>
                        <?= $yemek['protein'] ?>g protein,
                        <?= $yemek['karbonhidrat'] ?>g karb,
                        <?= $yemek['yag'] ?>g yağ,
                        <?= $yemek['kalori'] ?> kcal
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif;
    endforeach;
    ?>
        </div>

    </div>
</body>

</html>