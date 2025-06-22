<?php
session_start();
require_once('../includes/connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/userLogin.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$randevu_id = $_GET['randevu_id'] ?? null;

if (!$randevu_id) {
    echo "Randevu bilgisi eksik.";
    exit;
}

// Randevu bilgisi
$stmt = $connection->prepare("
    SELECT r.*, c.c_adi, c.c_soyadi
    FROM randevular r
    JOIN calisanlar c ON r.c_id = c.c_id
    WHERE r.r_id = :rid AND r.u_id = :uid
");
$stmt->execute(['rid' => $randevu_id, 'uid' => $user_id]);
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
            VALUES (:r_id, :g_id, :a_id, 'kullanici', :mesaj)
        ");
        $mesajEkle->execute([
            'r_id' => $randevu_id,
            'g_id' => $user_id,
            'a_id' => $randevu['c_id'],
            'mesaj' => $mesaj
        ]);
        header("Location: mesaj_gonder.php?randevu_id=$randevu_id");
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
    <title>Mesajlaşma - <?= htmlspecialchars($randevu['c_adi'] . ' ' . $randevu['c_soyadi']) ?></title>
    <link rel="stylesheet" href="../assets/css/mesaj.css?v=<?= time(); ?>">
    <style>
        .mesaj-container {
    max-width: 700px;
    margin: auto;
    padding: 20px;
    background: #f9f9f9;
    font-family: Arial, sans-serif;
}

.mesajlar {
    max-height: 400px;
    overflow-y: auto;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    background: #fff;
    padding: 10px;
}

.mesaj {
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 8px;
    max-width: 75%;
}

.gonderen {
    background: #d1f5d3;
    align-self: flex-end;
    margin-left: auto;
}

.alici {
    background: #f1f1f1;
    align-self: flex-start;
}

.mesaj-icerik {
    white-space: pre-wrap;
}

.mesaj-tarih {
    font-size: 0.8em;
    color: #666;
    text-align: right;
}

.mesaj-form {
    display: flex;
    flex-direction: column;
}

.mesaj-form textarea {
    height: 100px;
    padding: 10px;
    font-size: 1em;
    resize: none;
    margin-bottom: 10px;
}

.mesaj-form button {
    padding: 10px;
    background: #2b8cff;
    color: white;
    border: none;
    cursor: pointer;
}

    </style>
</head>
<body>
    <div class="mesaj-container">
        <h2>📨 <?= htmlspecialchars($randevu['c_adi'] . ' ' . $randevu['c_soyadi']) ?> ile Mesajlaşma</h2>

        <div class="mesajlar">
            <?php foreach ($mesajlar as $mesaj): ?>
                <div class="mesaj <?= $mesaj['kimden'] === 'kullanici' ? 'gonderen' : 'alici' ?>">
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
