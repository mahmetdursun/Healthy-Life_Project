<?php
session_start();
require_once('../includes/connection.php');

// Giriş kontrolü
if (!isset($_SESSION['user_id'])) {
    header("Location: userLogin.php");
    exit;
}

// Çalışan ID kontrolü
if (!isset($_GET['c_id'])) {
    echo "Çalışan seçilmedi.";
    exit;
}

$c_id = (int)$_GET['c_id'];
$u_id = $_SESSION['user_id'];

// Çalışan bilgisi
$stmt = $connection->prepare("SELECT * FROM calisanlar WHERE c_id = :id");
$stmt->execute(['id' => $c_id]);
$calisan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$calisan) {
    echo "Çalışan bulunamadı.";
    exit;
}

// Form gönderildiyse
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarih = $_POST['tarih'];
    $saat = $_POST['saat'];
    $randevu_notu = $_POST['randevu_notu'] ?? '';

    // Çakışma kontrolü
    $check = $connection->prepare("SELECT * FROM randevular WHERE c_id = :c_id AND tarih = :tarih AND saat = :saat");
    $check->execute([
        'c_id' => $c_id,
        'tarih' => $tarih,
        'saat' => $saat
    ]);

    if ($check->rowCount() > 0) {
        $hata = "Bu saatte başka bir randevu zaten alınmış.";
    } else {
        $stmt = $connection->prepare("INSERT INTO randevular (u_id, c_id, tarih, saat, randevu_notu, olusturma_tarihi) 
                                      VALUES (:u_id, :c_id, :tarih, :saat, :randevu_notu, NOW())");
        $stmt->execute([
            'u_id' => $u_id,
            'c_id' => $c_id,
            'tarih' => $tarih,
            'saat' => $saat,
            'randevu_notu' => $randevu_notu
        ]);

        header("Location: profile.php?section=randevular");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Randevu Al</title>
    <link rel="stylesheet" href="/proje/assets/css/randevu_al.css?v=<?= time(); ?>">
</head>
<body>
    <div class="randevu-form-container">
        <h2><?= htmlspecialchars($calisan['c_adi'] . ' ' . $calisan['c_soyadi']) ?> için Randevu Al</h2>

        <?php if (!empty($hata)): ?>
            <div class="error"><?= $hata ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="tarih">Tarih</label>
            <input type="date" name="tarih" required min="<?= date('Y-m-d') ?>">

            <label for="saat">Saat</label>
            <input type="time" name="saat" required>

            <label for="randevu_notu">not (isteğe bağlı)</label>
            <textarea name="randevu_notu" rows="3" placeholder="Varsa ek bilgi..."></textarea>

            <button type="submit">Randevuyu Kaydet</button>
        </form>
    </div>
</body>
</html>
