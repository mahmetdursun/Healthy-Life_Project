<?php
$tarifId = $_GET['tarif'] ?? '';

// Diziyi dahil et
include __DIR__ . '/tarif-array.php';

$tarif = null;

// Her kategori içinde arama yap
foreach ($tarifler as $kategori => $liste) {
    if (isset($liste[$tarifId])) {
        $tarif = $liste[$tarifId];
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title><?= $tarif['baslik'] ?? 'Tarif Bulunamadı' ?></title>
    <link rel="stylesheet" href="../assets/css/tarif-detay.css?v=<?= time(); ?>">
</head>

<body>
    <?php if ($tarif): ?>
    <div class="tarif-detay">
        <img src="<?= $tarif['resim'] ?>" alt="<?= $tarif['baslik'] ?>" class="tarif-resim">
        <div class="etiket"><?= $tarif['sure'] ?></div>
        <div class="makro">
            <span><?= $tarif['kalori'] ?></span>
            <span><?= $tarif['karb'] ?> karb</span>
            <span><?= $tarif['pro'] ?> protein</span>
            <span><?= $tarif['yag'] ?> yağ</span>
        </div>
        <h1><?= $tarif['baslik'] ?></h1>
        <p><?= $tarif['aciklama'] ?></p>

        <h2>Malzemeler</h2>
        <ul>
            <?php foreach ($tarif['malzemeler'] as $malzeme): ?>
            <li><?= $malzeme ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>Talimatlar</h2>
        <ul>
            <?php foreach ($tarif['talimatlar'] as $adim): ?>
            <li><?= $adim ?></li>
            <?php endforeach; ?>
        </ul>

        <h2>Püf Noktalar</h2>
        <ul>
            <?php foreach ($tarif['puf'] as $ipucu): ?>
            <li><?= $ipucu ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php else: ?>
    <p>Tarif bulunamadı.</p>
    <?php endif; ?>
</body>

</html>