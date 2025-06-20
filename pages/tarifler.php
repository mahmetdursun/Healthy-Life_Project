<?php
$ogun = $_GET['ogun'] ?? null;
$kalori_aralik = $_GET['kalori'] ?? null;
include __DIR__ . '/tarif-array.php';
include __DIR__ . '/tarif-besin-array.php';
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tarifler</title>
    <link rel="stylesheet" href="../assets/css/tarifler.css?v=<?= time(); ?>" />
</head>

<body>
    <div class="tarifler-page">
        <div class="tarifler-header">
            <div>
                <h1 class="tarifler-title">🌟 Öne Çıkan Fit Tarifler</h1>
            </div>
            <div> 
                <a href="../index.php" class="makrolarim-link">Ana Sayfaya Dön</a>
                <a href="makrolarim.php" class="makrolarim-link">Makrolarım</a>
                <a href="tarif-yemek_sec.php" class="makrolarim-link">Seçim</a>
            </div>
        </div>

        <?php if (!$ogun && !$kalori_aralik): ?>
        <div class="tarifler-grid">
            <!-- Öne çıkan örnek tarifler -->
            <a href="tarif-detay.php?tarif=yulaf-ruyasi" class="tarif-kart">
                <img src="../assets/images/fit-yulaf_omlet.png" alt="Yulaf Rüyası Omlet" />
                <div class="etiket">15dk</div>
                <div class="makro">
                    <span>594kcal</span><span>58.9g karb</span><span>33.3g pro</span><span>15.7g yağ</span>
                </div>
                <h3>Yulaf Rüyası Omlet</h3>
                <p>Kahvaltını daha besleyici yapmak isteyenlere birebir.</p>
            </a>

            <a href="tarif-detay.php?tarif=protein-pankek" class="tarif-kart">
                <img src="../assets/images/fit-protein_kek.png" alt="Protein Pankek">
                <div class="etiket">20dk</div>
                <div class="makro">
                    <span>470kcal</span>
                    <span>38g karb</span>
                    <span>27g pro</span>
                    <span>12g yağ</span>
                </div>
                <h3>Protein Pankek</h3>
                <p>Tat krizlerini bastır, enerjini koru!</p>
            </a>

            <a href="tarif-detay.php?tarif=tavuklu-kinoa" class="tarif-kart">
                <img src="../assets/images/fit-tavuklu_kinoa.png" alt="Tavuklu Kinoa">
                <div class="etiket">25dk</div>
                <div class="makro">
                    <span>520kcal</span>
                    <span>42g karb</span>
                    <span>35g pro</span>
                    <span>14g yağ</span>
                </div>
                <h3>Tavuklu Kinoa Salatası</h3>
                <p>Hafif, doyurucu, öğle öğünü için ideal.</p>
            </a>

            <a href="tarif-detay.php?tarif=sebzeli-omlet" class="tarif-kart">
                <img src="../assets/images/fit-sebzeli_fırın_omlet.png" alt="Sebzeli Fırın Omlet">
                <div class="etiket">18dk</div>
                <div class="makro">
                    <span>430kcal</span>
                    <span>20g karb</span>
                    <span>29g pro</span>
                    <span>18g yağ</span>
                </div>
                <h3>Sebzeli Fırın Omlet</h3>
                <p>Fırında sebzeli yumurtayla fit bir başlangıç yap.</p>
            </a>

            <a href="tarif-detay.php?tarif=ton-sandvic" class="tarif-kart">
                <img src="../assets/images/fit-ton_sandvic.png" alt="Ton Balıklı Sandviç">
                <div class="etiket">10dk</div>
                <div class="makro">
                    <span>395kcal</span>
                    <span>30g karb</span>
                    <span>28g pro</span>
                    <span>11g yağ</span>
                </div>
                <h3>Ton Balıklı Sandviç</h3>
                <p>Hızlı ve besleyici bir atıstırmalık için birebir.</p>
            </a>
        </div>

        <h1 class="tarifler-title">🍽️ Hangi öğün için tarif arıyorsun?</h1>
        <div class="tarif-secim">
            <a href="tarifler.php?ogun=sabah" class="ogun-btn">🌞 Sabah Tarifleri</a>
            <a href="tarifler.php?ogun=ogle" class="ogun-btn">🌤️ Öğle Tarifleri</a>
            <a href="tarifler.php?ogun=aksam" class="ogun-btn">🌙 Akşam Tarifleri</a>
        </div>

        <h1 class="tarifler-title">📊 Kaloriye Göre Filtrele</h1>
        <div class="kalori-filter">
            <a href="tarifler.php?kalori=100-300" class="filter-btn">100-300 kcal</a>
            <a href="tarifler.php?kalori=300-500" class="filter-btn">300-500 kcal</a>
            <a href="tarifler.php?kalori=500-700" class="filter-btn">500-700 kcal</a>
            <a href="tarifler.php?kalori=900-1500" class="filter-btn">900+ kcal</a>
        </div>

        <?php elseif ($kalori_aralik && !$ogun): ?>
        <?php
      if (strpos($kalori_aralik, '+') !== false) {
        $min = (int) filter_var($kalori_aralik, FILTER_SANITIZE_NUMBER_INT);
        $max = PHP_INT_MAX;
      } else {
        [$min, $max] = explode('-', $kalori_aralik);
        $min = (int) $min;
        $max = (int) $max;
      }
      ?>
        <h1 class="tarifler-title">🔥 <?= $min ?> - <?= $max === PHP_INT_MAX ? '∞' : $max ?> Kalori Arası Tarifler</h1>
        <div class="tarifler-grid">
            <?php foreach ($tarifler as $ogunler): ?>
            <?php foreach ($ogunler as $id => $tarif): ?>
            <?php $kcal = (int) filter_var($tarif['kalori'], FILTER_SANITIZE_NUMBER_INT); ?>
            <?php if ($kcal >= $min && $kcal <= $max): ?>
            <a href="tarif-detay.php?tarif=<?= $id ?>" class="tarif-kart">
                <img src="<?= $tarif['resim'] ?>" alt="<?= $tarif['baslik'] ?>" />
                <div class="etiket"><?= $tarif['sure'] ?></div>
                <div class="makro">
                    <span><?= $tarif['kalori'] ?></span>
                    <span><?= $tarif['karb'] ?> karb</span>
                    <span><?= $tarif['pro'] ?> pro</span>
                    <span><?= $tarif['yag'] ?> yağ</span>
                </div>
                <h3><?= $tarif['baslik'] ?></h3>
                <p><?= $tarif['aciklama'] ?></p>
            </a>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
        <div style="text-align:center;margin-top:2rem">
            <a href="tarifler.php" class="ogun-btn">🔙 Geri Dön</a>
        </div>

        <?php elseif (isset($tarifler[$ogun])): ?>
        <h1 class="tarifler-title">
            <?= $ogun === 'sabah' ? '🌞 Sabah Tarifleri' : ($ogun === 'ogle' ? '🌤️ Öğle Tarifleri' : '🌙 Akşam Tarifleri') ?>
        </h1>
        <div class="tarifler-grid">
            <?php foreach ($tarifler[$ogun] as $id => $tarif): ?>
            <a href="tarif-detay.php?tarif=<?= $id ?>" class="tarif-kart">
                <img src="<?= $tarif['resim'] ?>" alt="<?= $tarif['baslik'] ?>" />
                <div class="etiket"><?= $tarif['sure'] ?></div>
                <div class="makro">
                    <span><?= $tarif['kalori'] ?></span>
                    <span><?= $tarif['karb'] ?> karb</span>
                    <span><?= $tarif['pro'] ?> pro</span>
                    <span><?= $tarif['yag'] ?> yağ</span>
                </div>
                <h3><?= $tarif['baslik'] ?></h3>
                <p><?= $tarif['aciklama'] ?></p>
            </a>
            <?php endforeach; ?>
        </div>
        <div style="text-align:center;margin-top:2rem">
            <a href="tarifler.php" class="ogun-btn">🔙 Geri Dön</a>
        </div>

        <?php else: ?>
        <p>Geçersiz seçim yapıldı veya tarif bulunamadı.</p>
        <?php endif; ?>
    </div>

    <h2 class="tamamlayici-baslik">Tamamlayıcı Besinler <a href="tamamlayici.php" class="gor-link">Tümünü gör</a></h2>
    <div class="tamamlayici-grid">
        <?php foreach ($besinler['tamamlayicilar'] as $besin): ?>
        <div class="besin-kart">
            <img src="<?= $besin['resim'] ?>" alt="<?= $besin['isim'] ?>" class="besin-resim">
            <div class="besin-bilgi">
                <strong><?= $besin['isim'] ?></strong>
                <p>100g için;<br>
                    <?= $besin['pro'] ?> protein <?= $besin['karb'] ?> karb <?= $besin['yag'] ?> yağ
                </p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <h2 class="tamamlayici-baslik">İçecek Seçimi <a href="tamamlayici.php" class="gor-link">Tümünü gör</a></h2>
    <div class="tamamlayici-grid">
        <?php foreach ($besinler['icecekler'] as $ad => $v): ?>
        <label class="besin-kart">
            <img class="besin-resim" src="<?= $v['resim'] ?>" alt="<?= $v['isim'] ?>">
            <div class="besin-bilgi">
                <strong><?= $besin['isim'] ?></strong>
                <span><?= $v['kalori'] ?> kcal</span>
                <span><?= $v['karb'] ?>g karb</span>
                <span><?= $v['pro'] ?>g pro</span>
                <span><?= $v['yag'] ?>g yağ</span>
            </div>
            <h3><?= $v['isim'] ?></h3>
        </label>
        <?php endforeach; ?>
    </div>
</body>

</html>