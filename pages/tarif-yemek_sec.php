<?php
$section = strtolower($_GET['section'] ?? '');
include __DIR__ . '/tarif-array.php';
include __DIR__ . '/tarif-besin-array.php';

$tarif_listesi = isset($tarifler[$section]) ? $tarifler[$section] : [];
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Tarif Seç</title>
    <link rel="stylesheet" href="../assets/css/tarifler.css?v=<?= time(); ?>">
    <style>
    .ogun-form {
        margin: 2rem 0;
        margin-left: 1.5rem;
    }

    h1 {
        margin-left: 1.5rem;
    }

    h2 {
        margin-left: 1.5rem;
    }

    select {
        padding: 10px;
        font-size: 16px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .tarifler-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
    }

    .tarif-kart {
        background: #1c2331;
        border-radius: 16px;
        padding: 1rem;
        color: #fff;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
    }

    .tarif-kart:hover {
        transform: scale(1.03);
    }

    .tarif-kart img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 0.5rem;
    }

    .tarif-kart .etiket {
        background: #4caf50;
        color: white;
        padding: 4px 8px;
        font-size: 12px;
        border-radius: 0 0 8px 0;
        position: absolute;
        margin-top: 136px;
        margin-left: 0;
    }

    tarif-kart .makro {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        background: #4caf50;
        padding: 4px 8px;
        font-size: 12px;
    }

    .tarif-kart .makro span {
        background: #325aaa;
        border-radius: 8px;
        padding: 4px 8px;
        font-size: 0.75rem;
    }

    .tarif-kart h3 {
        font-size: 1rem;
        font-weight: bold;
        margin-bottom: 0.25rem;
    }

    .tarif-kart p {
        font-size: 0.85rem;
        color: #ccc;
        margin: 0;
    }

    .tarif-checkbox {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 20px;
        height: 20px;
        z-index: 2;
        accent-color: #007bff;
    }

    .form-title {
        font-size: 1.6rem;
        color: #ffffff;
        margin: 2rem 0 1rem;
        margin-left: 1.5rem;
    }

    .manuel-form {
        padding: 1.5rem;
        border-radius: 12px;
        max-width: 800px;
        color: #fff;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 1rem;
    }

    .form-row {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .form-group label {
        font-size: 1rem;
        margin-bottom: 0.3rem;
        font-weight: 500;
    }

    .manuel-form input[type="text"],
    .manuel-form input[type="number"] {
        background-color: #1f2937;
        color: #d1d5db;
        border: 1px solid #374151;
        border-radius: 8px;
        padding: 0.6rem 0.8rem;
        font-size: 1rem;
        outline: none;
        transition: border-color 0.3s;
    }

    .manuel-form input:focus {
        border-color: #3b82f6;
    }

    .submit-btn {
        margin-top: 1rem;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 6px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }
    </style>
    </style>
</head>

<body>
    <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
    <div
        style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 12px; border-radius: 8px; margin: 1rem 1.5rem;">
        ✅ Seçiminiz başarıyla kaydedildi!
    </div>
    <?php endif; ?>
    <h1>Yediğin Yemekleri Seç</h1>
    <div class="tarifler-page">

        <!-- GET Form: Öğün seçimi -->
        <form method="GET" action="" class="ogun-form">
            <label for="section">🍽️ Öğün Seçin:</label>
            <select name="section" id="section" onchange="this.form.submit()">
                <option value="">-- Öğün Seçin --</option>
                <option value="sabah" <?= $section === 'sabah' ? 'selected' : '' ?>>🌞 Sabah</option>
                <option value="ogle" <?= $section === 'ogle' ? 'selected' : '' ?>>🌤️ Öğle</option>
                <option value="aksam" <?= $section === 'aksam' ? 'selected' : '' ?>>🌙 Akşam</option>
            </select>
            <div style="margin-top: 1rem; color: red;">
                <?php if (empty($section)): ?>
                ⚠️ Lütfen bir öğün seçiniz!
                <?php endif; ?>
            </div>
        </form>

        <!-- POST Form: Tüm içerikler -->
        <form method="POST" action="tarif-kaydet.php" class="tarif-form">
            <input type="hidden" name="ogun" value="<?= htmlspecialchars($section) ?>">

            <?php if ($section && !empty($tarif_listesi)): ?>
            <h1 class="tarifler-title"><?= ucfirst($section) ?> Öğünü İçin Tarif Seç</h1>
            <div class="tarifler-grid">
                <?php foreach ($tarif_listesi as $id => $tarif): ?>
                <div class="tarif-kart" onclick="window.location.href='tarif-detay.php?tarif=<?= $id ?>'">
                    <input type="checkbox" name="secilen_tarifler[]" value="<?= $id ?>" class="tarif-checkbox"
                        onclick="event.stopPropagation();">
                    <img src="<?= $tarif['resim'] ?>" alt="<?= $tarif['baslik'] ?>">
                    <div class="etiket"><?= $tarif['sure'] ?></div>
                    <div class="makro">
                        <span><?= $tarif['kalori'] ?></span>
                        <span><?= $tarif['karb'] ?> karb</span>
                        <span><?= $tarif['pro'] ?> pro</span>
                        <span><?= $tarif['yag'] ?> yağ</span>
                    </div>
                    <h3><?= $tarif['baslik'] ?></h3>
                    <p><?= $tarif['aciklama'] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php elseif ($section): ?>
            <p style="color:red; text-align:center;">Bu öğün için tarif bulunamadı.</p>
            <?php endif; ?>

            <!-- Manuel Yemek Girişi -->
            <h2 class="form-title">📝 Manuel Yemek Ekle</h2>
            <div class="manuel-form">
                <div class="form-group">
                    <label for="manuel_yemek">Yemek Adı</label>
                    <input type="text" id="manuel_yemek" name="manuel_yemek" placeholder="Örn: Ev yapımı Börek">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="manuel_miktar">Miktar (gram)</label>
                        <input type="number" id="manuel_miktar" name="manuel_miktar" value="100" min="1">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="manuel_karbonhidrat">Karbonhidrat (100g)</label>
                        <input type="number" id="manuel_karbonhidrat" step="0.1" name="manuel_karbonhidrat">
                    </div>
                    <div class="form-group">
                        <label for="manuel_protein">Protein (100g)</label>
                        <input type="number" id="manuel_protein" step="0.1" name="manuel_protein">
                    </div>
                    <div class="form-group">
                        <label for="manuel_yag">Yağ (100g)</label>
                        <input type="number" id="manuel_yag" step="0.1" name="manuel_yag">
                    </div>
                </div>

                <div class="form-group">
                    <label for="manuel_kalori">Kalori (100g)</label>
                    <input type="number" id="manuel_kalori" step="1" name="manuel_kalori">
                </div>
            </div>

            <!-- Tamamlayıcı Besinler -->
            <h2>🥜 Tamamlayıcı Besinler</h2>
            <div class="tarifler-grid">
                <?php foreach ($besinler['tamamlayicilar'] as $key => $besin): ?>
                <label class="tarif-kart">
                    <input type="checkbox" name="tamamlayici[]" value="<?= $key ?>" class="tarif-checkbox">
                    <img src="<?= $besin['resim'] ?>" alt="<?= $besin['isim'] ?>">
                    <div class="makro">
                        <span><?= $besin['pro'] ?>g pro</span>
                        <span><?= $besin['karb'] ?>g karb</span>
                        <span><?= $besin['yag'] ?>g yağ</span>
                    </div>
                    <h3><?= $besin['isim'] ?></h3>
                </label>
                <?php endforeach; ?>
            </div>

            <!-- İçecekler -->
            <h2>🥤 İçecek Seçimi</h2>
            <div class="tarifler-grid">
                <?php foreach ($besinler['icecekler'] as $ad => $v): ?>
                <label class="tarif-kart">
                    <input type="checkbox" name="icecekler[]" value="<?= $ad ?>" class="tarif-checkbox">
                    <img src="<?= $v['resim'] ?>" alt="<?= $v['isim'] ?>">
                    <div class="makro">
                        <span><?= $v['kalori'] ?> kcal</span>
                        <span><?= $v['karb'] ?>g karb</span>
                        <span><?= $v['pro'] ?>g pro</span>
                        <span><?= $v['yag'] ?>g yağ</span>
                    </div>
                    <h3><?= $v['isim'] ?></h3>
                </label>
                <?php endforeach; ?>
            </div>

            <!-- Kaydet Butonu -->
            <div style="text-align:center; margin-top:2rem;">
                <button type="submit" class="submit-btn">💾 Beslenmeyi Kaydet</button>
            </div>

        </form>
    </div>
</body>

</html>