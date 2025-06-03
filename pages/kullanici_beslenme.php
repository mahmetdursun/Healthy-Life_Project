<?php
session_start();
include __DIR__ . '/../includes/connection.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = 'Bu sayfaya erişmek için lütfen giriş yapınız.';
    header('Location: userLogin.php');
    exit;
}

if (!isset($connection)) {
    die("Veritabanı bağlantısı sağlanamadı!");
}

$userId = $_SESSION['user_id'] ?? 1;

$ogunler = ['Sabah', 'Öğle', 'Akşam'];

// Yemekler ve besin değerleri (100 gr için)
$yemekler = [
    'Sabah' => [
        'Yulaf Ezmesi' => ['karbonhidrat'=>60, 'protein'=>10, 'yag'=>7, 'kalori'=>350],
        'Haşlanmış Yumurta' => ['karbonhidrat'=>1, 'protein'=>13, 'yag'=>11, 'kalori'=>155],
        'Muz' => ['karbonhidrat'=>23, 'protein'=>1.3, 'yag'=>0.3, 'kalori'=>90],
        'Peynir' => ['karbonhidrat'=>1.5, 'protein'=>25, 'yag'=>33, 'kalori'=>350],
        'Tam Buğday Ekmeği' => ['karbonhidrat'=>43, 'protein'=>9, 'yag'=>4, 'kalori'=>250],
    ],
    'Öğle' => [
        'Izgara Tavuk' => ['karbonhidrat'=>0, 'protein'=>31, 'yag'=>3.6, 'kalori'=>165],
        'Pirinç' => ['karbonhidrat'=>28, 'protein'=>2.7, 'yag'=>0.3, 'kalori'=>130],
        'Sebze Salatası' => ['karbonhidrat'=>10, 'protein'=>2, 'yag'=>5, 'kalori'=>90],
        'Yoğurt' => ['karbonhidrat'=>4, 'protein'=>3.5, 'yag'=>3, 'kalori'=>60],
        'Zeytinyağlı Enginar' => ['karbonhidrat'=>12, 'protein'=>1, 'yag'=>7, 'kalori'=>120],
    ],
    'Akşam' => [
        'Balık' => ['karbonhidrat'=>0, 'protein'=>22, 'yag'=>12, 'kalori'=>210],
        'Haşlanmış Patates' => ['karbonhidrat'=>20, 'protein'=>2, 'yag'=>0, 'kalori'=>90],
        'Brokoli' => ['karbonhidrat'=>7, 'protein'=>3, 'yag'=>0.4, 'kalori'=>35],
        'Mercimek Çorbası' => ['karbonhidrat'=>15, 'protein'=>9, 'yag'=>1, 'kalori'=>140],
        'Izgara Sebzeler' => ['karbonhidrat'=>8, 'protein'=>2, 'yag'=>5, 'kalori'=>80],
    ],
];

// Atıştırmalıklar
$atistirmaliklar = [
    'Ceviz' => ['karbonhidrat'=>14, 'protein'=>15, 'yag'=>65, 'kalori'=>650],
    'Badem' => ['karbonhidrat'=>22, 'protein'=>21, 'yag'=>49, 'kalori'=>575],
    'Meyve Barı' => ['karbonhidrat'=>70, 'protein'=>5, 'yag'=>10, 'kalori'=>350],
    'Havuç' => ['karbonhidrat'=>10, 'protein'=>1, 'yag'=>0.2, 'kalori'=>40],
];

// İçecekler
$icecekler = [
    'Su' => ['karbonhidrat'=>0, 'protein'=>0, 'yag'=>0, 'kalori'=>0],
    'Taze Sıkılmış Portakal Suyu' => ['karbonhidrat'=>10, 'protein'=>1, 'yag'=>0.2, 'kalori'=>45],
    'Yeşil Çay' => ['karbonhidrat'=>0, 'protein'=>0, 'yag'=>0, 'kalori'=>2],
    'Süt (200ml)' => ['karbonhidrat'=>10, 'protein'=>7, 'yag'=>5, 'kalori'=>120],
];

// POST ile gelen verileri işle
$error = '';
$mesaj = '';
$sonuc = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ogun = $_POST['ogun'] ?? '';
    if (!in_array($ogun, $ogunler)) {
        $error = "Lütfen geçerli bir öğün seçiniz.";
    } else {
        $topKarbonhidrat = 0;
        $topProtein = 0;
        $topYag = 0;
        $topKalori = 0;

        // Öğün yemekleri
        if (!empty($_POST['yemek']) && is_array($_POST['yemek'])) {
            foreach ($_POST['yemek'] as $yemekAdi) {
                if (isset($yemekler[$ogun][$yemekAdi])) {
                    $miktar = floatval($_POST['miktar_yemek'][$yemekAdi] ?? 100);
                    if ($miktar <= 0) $miktar = 100;
                    $vals = $yemekler[$ogun][$yemekAdi];
                    $karb = ($vals['karbonhidrat'] / 100) * $miktar;
                    $prot = ($vals['protein'] / 100) * $miktar;
                    $yag = ($vals['yag'] / 100) * $miktar;
                    $kal = ($vals['kalori'] / 100) * $miktar;

                    $topKarbonhidrat += $karb;
                    $topProtein += $prot;
                    $topYag += $yag;
                    $topKalori += $kal;

                    // Kaydet
                    $stmt = $connection->prepare("INSERT INTO kullanici_beslenme (user_id, ogun, yemek, miktar, karbonhidrat, protein, yag, kalori, tarih) VALUES (:user_id, :ogun, :yemek, :miktar, :karbonhidrat, :protein, :yag, :kalori, CURDATE())");
                    $stmt->execute([
                        ':user_id' => $userId,
                        ':ogun' => $ogun,
                        ':yemek' => $yemekAdi,
                        ':miktar' => $miktar,
                        ':karbonhidrat' => $karb,
                        ':protein' => $prot,
                        ':yag' => $yag,
                        ':kalori' => $kal,
                    ]);
                }
            }
        }

        // Atıştırmalıklar
        if (!empty($_POST['atistirmalik']) && is_array($_POST['atistirmalik'])) {
            foreach ($_POST['atistirmalik'] as $atkAdi) {
                if (isset($atistirmaliklar[$atkAdi])) {
                    $miktar = floatval($_POST['miktar_atistirmalik'][$atkAdi] ?? 30);
                    if ($miktar <= 0) $miktar = 30; // varsayılan 30 gr
                    $vals = $atistirmaliklar[$atkAdi];
                    $karb = ($vals['karbonhidrat'] / 100) * $miktar;
                    $prot = ($vals['protein'] / 100) * $miktar;
                    $yag = ($vals['yag'] / 100) * $miktar;
                    $kal = ($vals['kalori'] / 100) * $miktar;

                    $topKarbonhidrat += $karb;
                    $topProtein += $prot;
                    $topYag += $yag;
                    $topKalori += $kal;

                    // Kaydet
                    $stmt = $connection->prepare("INSERT INTO kullanici_beslenme (user_id, ogun, yemek, miktar, karbonhidrat, protein, yag, kalori, tarih) VALUES (:user_id, :ogun, :yemek, :miktar, :karbonhidrat, :protein, :yag, :kalori, CURDATE())");
                    $stmt->execute([
                        ':user_id' => $userId,
                        ':ogun' => 'Atıştırmalık',
                        ':yemek' => $atkAdi,
                        ':miktar' => $miktar,
                        ':karbonhidrat' => $karb,
                        ':protein' => $prot,
                        ':yag' => $yag,
                        ':kalori' => $kal,
                    ]);
                }
            }
        }

        // İçecekler
        if (!empty($_POST['icecek']) && is_array($_POST['icecek'])) {
            foreach ($_POST['icecek'] as $icAdi) {
                if (isset($icecekler[$icAdi])) {
                    $miktar = floatval($_POST['miktar_icecek'][$icAdi] ?? 200);
                    if ($miktar <= 0) $miktar = 200; // varsayılan 200ml
                    $vals = $icecekler[$icAdi];
                    $karb = ($vals['karbonhidrat'] / 100) * $miktar;
                    $prot = ($vals['protein'] / 100) * $miktar;
                    $yag = ($vals['yag'] / 100) * $miktar;
                    $kal = ($vals['kalori'] / 100) * $miktar;

                    $topKarbonhidrat += $karb;
                    $topProtein += $prot;
                    $topYag += $yag;
                    $topKalori += $kal;

                    // Kaydet
                    $stmt = $connection->prepare("INSERT INTO kullanici_beslenme (user_id, ogun, yemek, miktar, karbonhidrat, protein, yag, kalori, tarih) VALUES (:user_id, :ogun, :yemek, :miktar, :karbonhidrat, :protein, :yag, :kalori, CURDATE())");
                    $stmt->execute([
                        ':user_id' => $userId,
                        ':ogun' => 'İçecek',
                        ':yemek' => $icAdi,
                        ':miktar' => $miktar,
                        ':karbonhidrat' => $karb,
                        ':protein' => $prot,
                        ':yag' => $yag,
                        ':kalori' => $kal,
                    ]);
                }
            }
        }

        // Manuel yemek ekleme
        $manuelYemek = trim($_POST['manuel_yemek'] ?? '');
        $manuelKarbonhidrat = floatval($_POST['manuel_karbonhidrat'] ?? 0);
        $manuelProtein = floatval($_POST['manuel_protein'] ?? 0);
        $manuelYag = floatval($_POST['manuel_yag'] ?? 0);
        $manuelKalori = floatval($_POST['manuel_kalori'] ?? 0);
        $manuelMiktar = floatval($_POST['manuel_miktar'] ?? 100);

        if ($manuelYemek !== '') {
            $karb = ($manuelKarbonhidrat / 100) * $manuelMiktar;
            $prot = ($manuelProtein / 100) * $manuelMiktar;
            $yag = ($manuelYag / 100) * $manuelMiktar;
            $kal = ($manuelKalori / 100) * $manuelMiktar;

            $topKarbonhidrat += $karb;
            $topProtein += $prot;
            $topYag += $yag;
            $topKalori += $kal;

            $stmt = $connection->prepare("INSERT INTO kullanici_beslenme (user_id, ogun, yemek, miktar, karbonhidrat, protein, yag, kalori, tarih) VALUES (:user_id, :ogun, :yemek, :miktar, :karbonhidrat, :protein, :yag, :kalori, CURDATE())");
            $stmt->execute([
                ':user_id' => $userId,
                ':ogun' => $ogun,
                ':yemek' => $manuelYemek,
                ':miktar' => $manuelMiktar,
                ':karbonhidrat' => $karb,
                ':protein' => $prot,
                ':yag' => $yag,
                ':kalori' => $kal,
            ]);
        }

        // Sonuç mesajı
        $mesaj = "Toplam Tüketim: Kalori: ".round($topKalori,2)." kcal, Protein: ".round($topProtein,2)." g, Karbonhidrat: ".round($topKarbonhidrat,2)." g, Yağ: ".round($topYag,2)." g.";

        // Motivasyon mesajı
        if ($topKalori < 1500) {
            $mesaj .= " Harika! Dengeli beslenmeye devam.";
        } elseif ($topKalori <= 2500) {
            $mesaj .= " İyi gidiyorsun, sağlıklı seçimler yapmaya devam et.";
        } else {
            $mesaj .= " Dikkat! Kalori alımını biraz kontrol etmelisin.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Beslenme Takip Formu</title>
<link rel="stylesheet" href="../assets/css/kullanici_beslenme.css?v=<?= time(); ?>">
</head>
<body>

<div class="container">
  <h1>Günlük Beslenme Takibi</h1>

  <?php if($error): ?>
    <div class="message error"><?=htmlspecialchars($error)?></div>
  <?php elseif($mesaj): ?>
    <div class="message"><?=htmlspecialchars($mesaj)?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="section">
      <h2>Öğün Seçimi & Yemekler</h2>
      <label for="ogun">Öğün</label>
      <select name="ogun" id="ogun" required>
        <option value="">Seçiniz...</option>
        <?php foreach ($ogunler as $o): ?>
          <option value="<?=htmlspecialchars($o)?>" <?= (($_POST['ogun'] ?? '') === $o) ? 'selected' : '' ?>><?=htmlspecialchars($o)?></option>
        <?php endforeach; ?>
      </select>

      <?php foreach ($ogunler as $o): ?>
        <div class="items-list" style="display: <?= (($_POST['ogun'] ?? '') === $o) ? 'block' : 'none' ?>;">
          <p><strong><?=htmlspecialchars($o)?> Yemekleri</strong></p>
          <?php foreach ($yemekler[$o] as $yemekAdi => $vals): ?>
            <label>
              <input type="checkbox" name="yemek[]" value="<?=htmlspecialchars($yemekAdi)?>" 
              <?= (isset($_POST['yemek']) && in_array($yemekAdi, $_POST['yemek'])) ? 'checked' : '' ?>>
              <?=htmlspecialchars($yemekAdi)?>
              <input type="number" name="miktar_yemek[<?=htmlspecialchars($yemekAdi)?>]" min="10" max="1000" step="1" value="<?=htmlspecialchars($_POST['miktar_yemek'][$yemekAdi] ?? 100)?>">
              gr
            </label>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>

      <hr>

      <h3>Manuel Yemek Ekle</h3>
      <label for="manuel_yemek">Yemek Adı</label>
      <input type="text" name="manuel_yemek" id="manuel_yemek" placeholder="Örn: Ev yapımı börek" value="<?=htmlspecialchars($_POST['manuel_yemek'] ?? '')?>">
      <label for="manuel_miktar">Miktar (gram)</label>
      <input type="number" name="manuel_miktar" id="manuel_miktar" min="10" max="2000" step="1" value="<?=htmlspecialchars($_POST['manuel_miktar'] ?? 100)?>">
      <label for="manuel_karbonhidrat">Karbonhidrat (100 gr'da)</label>
      <input type="number" name="manuel_karbonhidrat" id="manuel_karbonhidrat" min="0" step="0.1" value="<?=htmlspecialchars($_POST['manuel_karbonhidrat'] ?? 0)?>">
      <label for="manuel_protein">Protein (100 gr'da)</label>
      <input type="number" name="manuel_protein" id="manuel_protein" min="0" step="0.1" value="<?=htmlspecialchars($_POST['manuel_protein'] ?? 0)?>">
      <label for="manuel_yag">Yağ (100 gr'da)</label>
      <input type="number" name="manuel_yag" id="manuel_yag" min="0" step="0.1" value="<?=htmlspecialchars($_POST['manuel_yag'] ?? 0)?>">
      <label for="manuel_kalori">Kalori (100 gr'da)</label>
      <input type="number" name="manuel_kalori" id="manuel_kalori" min="0" step="0.1" value="<?=htmlspecialchars($_POST['manuel_kalori'] ?? 0)?>">
    </div>

    <div class="section">
      <h2>Atıştırmalıklar</h2>
      <div class="items-list">
        <?php foreach ($atistirmaliklar as $atkAdi => $vals): ?>
          <label>
            <input type="checkbox" name="atistirmalik[]" value="<?=htmlspecialchars($atkAdi)?>" 
            <?= (isset($_POST['atistirmalik']) && in_array($atkAdi, $_POST['atistirmalik'])) ? 'checked' : '' ?>>
            <?=htmlspecialchars($atkAdi)?>
            <input type="number" name="miktar_atistirmalik[<?=htmlspecialchars($atkAdi)?>]" min="5" max="200" step="1" value="<?=htmlspecialchars($_POST['miktar_atistirmalik'][$atkAdi] ?? 30)?>">
            gr
          </label>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="section">
      <h2>İçecekler</h2>
      <div class="items-list">
        <?php foreach ($icecekler as $icAdi => $vals): ?>
          <label>
            <input type="checkbox" name="icecek[]" value="<?=htmlspecialchars($icAdi)?>" 
            <?= (isset($_POST['icecek']) && in_array($icAdi, $_POST['icecek'])) ? 'checked' : '' ?>>
            <?=htmlspecialchars($icAdi)?>
            <input type="number" name="miktar_icecek[<?=htmlspecialchars($icAdi)?>]" min="50" max="1000" step="10" value="<?=htmlspecialchars($_POST['miktar_icecek'][$icAdi] ?? 200)?>">
            ml/gr
          </label>
        <?php endforeach; ?>
      </div>
    </div>

    <button type="submit">Beslenmeyi Kaydet</button>
    <a href="../index.php">Ana Sayfaya Dön</a>
  </form>
</div>
</body>
</html>
