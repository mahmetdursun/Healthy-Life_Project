<?php
require_once('../includes/connection.php');
session_start();

$c_id = $_GET['id'] ?? null;

if (!$c_id) {
    header("Location: ../pages/admin.php?page=calisanlar");
exit;

}

// FORM GÖNDERİLDİYSE GÜNCELLE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $c_adi = $_POST['c_adi'];
    $c_soyadi = $_POST['c_soyadi'];
    $c_mail = $_POST['c_mail'];
    $calisma_saatleri = $_POST['calisma_saatleri'];

    $stmt = $connection->prepare("UPDATE calisanlar SET c_adi = ?, c_soyadi = ?, c_mail = ?, calisma_saatleri = ? WHERE c_id = ?");
    $stmt->execute([$c_adi, $c_soyadi, $c_mail, $calisma_saatleri, $c_id]);

    header("Location: ../pages/admin.php?page=calisanlar");
exit;

}

// MEVCUT VERİLERİ GETİR
$stmt = $connection->prepare("SELECT * FROM calisanlar WHERE c_id = ?");
$stmt->execute([$c_id]);
$calisan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$calisan) {
    echo "Çalışan bulunamadı.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Çalışan Güncelle</title>
    <link rel="stylesheet" href="../assets/css/admin.css?v=<?= time(); ?>">
</head>
<body>
    <div class="form-container">
        <h2>Çalışan Güncelle</h2>
        <form action="" method="POST" class="form-add">
            <div class="form-group">
                <label for="c_adi">Adı</label>
                <input type="text" name="c_adi" id="c_adi" value="<?= htmlspecialchars($calisan['c_adi']) ?>" required>
            </div>
            <div class="form-group">
                <label for="c_soyadi">Soyadı</label>
                <input type="text" name="c_soyadi" id="c_soyadi" value="<?= htmlspecialchars($calisan['c_soyadi']) ?>" required>
            </div>
            <div class="form-group">
                <label for="c_mail">Mail</label>
                <input type="email" name="c_mail" id="c_mail" value="<?= htmlspecialchars($calisan['c_mail']) ?>" required>
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label for="calisma_saatleri">Çalışma Saatleri</label>
                <textarea name="calisma_saatleri" id="calisma_saatleri" rows="3" required><?= htmlspecialchars($calisan['calisma_saatleri']) ?></textarea>
            </div>
            <button type="submit">Güncelle</button>
        </form>
    </div>
</body>
</html>
