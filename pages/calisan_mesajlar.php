<?php
session_start();
require_once('../includes/connection.php');

if (!isset($_SESSION["calisan_id"])) {
    header("Location: userLogin.php");
    exit;
}

$calisan_id = $_SESSION["calisan_id"];

// Mesajları çek (bu çalışana gelenler)
$stmt = $connection->prepare("
    SELECT m.*, u.u_adi, u.u_soyadi 
    FROM mesajlar m
    JOIN randevular r ON m.randevu_id = r.r_id
    JOIN user u ON r.u_id = u.u_id
    WHERE m.alici_id = :cid
    ORDER BY m.gonderilme_tarihi DESC
");
$stmt->execute(['cid' => $calisan_id]);
$mesajlar = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Gelen Mesajlar</title>
    <link rel="stylesheet" href="/proje/assets/css/calisan_mesajlar.css?v=<?= time(); ?>">
  
</head>
<body>
    <h2>📨 Gelen Mesajlar</h2>

    <?php if (empty($mesajlar)): ?>
        <p>Hiç mesajınız bulunmamaktadır.</p>
    <?php else: ?>
        <?php foreach ($mesajlar as $m): ?>
            <div class="mesaj-kutu">
                <strong><?= htmlspecialchars($m['u_adi'] . ' ' . $m['u_soyadi']) ?></strong> 
                <div class="mesaj-icerik"><?= nl2br(htmlspecialchars($m['mesaj_metni'])) ?></div>
                <div class="mesaj-tarih"><?= $m['gonderilme_tarihi'] ?></div>
                <a href="calisan_mesaj_goruntule.php?randevu_id=<?= $m['randevu_id'] ?>" class="btn btn-sm">Gör</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
