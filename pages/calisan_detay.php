<?php
session_start();
require_once('../includes/connection.php');

// ID kontrolü
if (!isset($_GET['id'])) {
    echo "Çalışan bulunamadı.";
    exit;
}

$c_id = (int)$_GET['id'];

// Çalışan bilgilerini al
$stmt = $connection->prepare("SELECT * FROM calisanlar WHERE c_id = :id");
$stmt->execute(['id' => $c_id]);
$calisan = $stmt->fetch(PDO::FETCH_ASSOC);

// Çalışan yoksa
if (!$calisan) {
    echo "Çalışan bulunamadı.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Çalışan Detayı</title>
    <link rel="stylesheet" href="/proje/assets/css/calisan_detay.css?v=<?= time(); ?>">
</head>
<body>
    <div class="detay-container">
        <div class="detay-card">
            <img src="../uploads/<?= htmlspecialchars($calisan['profil_resmi']) ?>" alt="Profil Resmi" class="profil-img">
            <h2><?= htmlspecialchars($calisan['c_adi'] . ' ' . $calisan['c_soyadi']) ?></h2>
            <p><strong>Görev Türü:</strong> <?= ucfirst(str_replace('_', ' ', $calisan['tur'])) ?></p>
            <p><strong>Uzmanlık:</strong> <?= htmlspecialchars($calisan['uzmanlik']) ?></p>
            <p><strong>Mezuniyet:</strong> <?= htmlspecialchars($calisan['mezuniyet']) ?></p>
            <p><strong>Deneyim:</strong> <?= htmlspecialchars($calisan['deneyim']) ?></p>
            <p><strong>Sertifikalar:</strong> <?= htmlspecialchars($calisan['sertifikalar']) ?></p>
            <p><strong>Açıklama:</strong> <?= nl2br(htmlspecialchars($calisan['aciklama'])) ?></p>
            <p><strong>Çalışma Saatleri:</strong> <?= nl2br(htmlspecialchars($calisan['calisma_saatleri'])) ?></p>

            <a href="randevu_al.php?c_id=<?= $calisan['c_id'] ?>" class="btn">📅 Randevu Al</a>
        </div>
    </div>
</body>
</html>
