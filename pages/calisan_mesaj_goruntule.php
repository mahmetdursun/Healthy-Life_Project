<?php
session_start();
require_once('../includes/connection.php');

if (!isset($_SESSION["calisan_id"])) {
    header("Location: userLogin.php");
    exit;
}

$calisan_id = $_SESSION["calisan_id"];
$randevu_id = $_GET['randevu_id'] ?? null;

if (!$randevu_id) {
    echo "Randevu bilgisi eksik.";
    exit;
}

// Randevu bilgisi
$stmt = $connection->prepare("
    SELECT r.*, u.u_adi, u.u_soyadi
    FROM randevular r
    JOIN user u ON r.u_id = u.u_id
    WHERE r.r_id = :rid AND r.c_id = :cid
");
$stmt->execute(['rid' => $randevu_id, 'cid' => $calisan_id]);
$randevu = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$randevu) {
    echo "Randevu bulunamadı.";
    exit;
}

// Mesaj gönderimi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mesaj'])) {
    $mesaj = trim($_POST['mesaj']);

    if (!empty($mesaj)) {
        $mesajEkle = $connection->prepare("
            INSERT INTO mesajlar (randevu_id, gonderen_id, alici_id, kimden, mesaj_metni)
            VALUES (:r_id, :g_id, :a_id, 'calisan', :mesaj)
        ");
        $mesajEkle->execute([
            'r_id' => $randevu_id,
            'g_id' => $calisan_id,
            'a_id' => $randevu['u_id'],
            'mesaj' => $mesaj
        ]);
        header("Location: calisan_mesaj_goruntule.php?randevu_id=$randevu_id");
        exit;
    }
}

// Mesajları çek
$mesajSorgu = $connection->prepare("
    SELECT * FROM mesajlar
    WHERE randevu_id = :rid
    ORDER BY gonderilme_tarihi ASC
");
$mesajSorgu->execute(['rid' => $randevu_id]);
$mesajlar = $mesajSorgu->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($randevu['u_adi'] . ' ' . $randevu['u_soyadi']) ?> ile Mesajlaşma</title>
    <link rel="stylesheet" href="../assets/css/calisan_mesaj_goruntule.css?v=<?= time(); ?>">
</head>
<body>
    <div class="mesaj-container">
        <h2>📨 <?= htmlspecialchars($randevu['u_adi'] . ' ' . $randevu['u_soyadi']) ?> ile Mesajlaşma</h2>

        <div class="mesajlar">
            <?php foreach ($mesajlar as $mesaj): ?>
                <div class="mesaj <?= $mesaj['kimden'] === 'calisan' ? 'gonderen' : 'alici' ?>">
                    <div class="mesaj-icerik">
                        <?= nl2br(htmlspecialchars($mesaj['mesaj_metni'])) ?>
                    </div>
                    <div class="mesaj-tarih">
                        <?= $mesaj['gonderilme_tarihi'] ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <form method="POST" class="mesaj-form">
            <textarea name="mesaj" required placeholder="Mesajınızı yazın..."></textarea>
            <button type="submit">Gönder</button>
        </form>
    </div>
</body>
</html>
