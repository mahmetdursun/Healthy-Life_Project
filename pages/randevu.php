<?php
session_start();
require_once('../includes/connection.php');

// Oturum kontrolü
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = 'Bu sayfaya erişmek için lütfen giriş yapınız.';
    header('Location: userLogin.php');
    exit;
}

// Tüm çalışanları çek
$stmt = $connection->prepare("SELECT * FROM calisanlar");
$stmt->execute();
$calisanlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Türlerine göre gruplandır
$gruplar = [];
foreach ($calisanlar as $c) {
    $tur = ucfirst(str_replace('_', ' ', $c['tur']));
    $gruplar[$tur][] = $c;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Çalışan Paneli</title>
    <link rel="stylesheet" href="/proje/assets/css/randevu.css?v=<?= time(); ?>">
</head>
<body>
    <div class="randevu-container">
        <h2>Randevu Alabileceğiniz Uzmanlar</h2>

        <?php foreach ($gruplar as $tur => $calisanlar): ?>
            <h3 class="kategori-baslik"><?= htmlspecialchars($tur) ?></h3>
            <div class="calisan-card-wrapper">
                <?php foreach ($calisanlar as $c): ?>
                    <div class="calisan-card">
                        <h3><?= htmlspecialchars($c['c_adi'] . ' ' . $c['c_soyadi']) ?></h3>
                        <p><strong>Görev:</strong> <?= htmlspecialchars($tur) ?></p>
                        <p><strong>Uzmanlık:</strong> <?= htmlspecialchars($c['uzmanlik']) ?></p>
                        <p><?= mb_substr($c['aciklama'] ?? 'Bu uzman hakkında detaylı bilgi için tıklayın.', 0, 60) ?>...</p>
                        <a href="calisan_detay.php?id=<?= $c['c_id'] ?>" class="btn">Detayları Gör</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
