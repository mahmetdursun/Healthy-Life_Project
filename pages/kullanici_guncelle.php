<?php
require_once('../includes/connection.php');
session_start();

$u_id = $_GET['id'] ?? null;

if (!$u_id) {
    header("Location: admin.php?page=kullanicilar");
    exit;
}

// GÜNCELLEME FORMU GÖNDERİLDİYSE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u_adi = $_POST['u_adi'];
    $u_soyadi = $_POST['u_soyadi'];
    $u_mail = $_POST['u_mail'];
    $u_telefon = $_POST['u_telefon'];

    $stmt = $connection->prepare("UPDATE user SET u_adi = ?, u_soyadi = ?, u_mail = ?, u_telefon = ? WHERE u_id = ?");
    $stmt->execute([$u_adi, $u_soyadi, $u_mail, $u_telefon, $u_id]);

    header("Location: admin.php?page=kullanicilar");
    exit;
}

// MEVCUT KULLANICIYI GETİR
$stmt = $connection->prepare("SELECT * FROM user WHERE u_id = ?");
$stmt->execute([$u_id]);
$kullanici = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$kullanici) {
    echo "Kullanıcı bulunamadı.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcı Güncelle</title>
    <link rel="stylesheet" href="../assets/css/admin.css?v=<?= time(); ?>">
</head>
<body>
    <div class="form-container">
        <h2>Kullanıcı Bilgilerini Güncelle</h2>
        <form method="POST" class="form-add">
            <div class="form-group">
                <label for="u_adi">Adı</label>
                <input type="text" name="u_adi" id="u_adi" value="<?= htmlspecialchars($kullanici['u_adi']) ?>" required>
            </div>
            <div class="form-group">
                <label for="u_soyadi">Soyadı</label>
                <input type="text" name="u_soyadi" id="u_soyadi" value="<?= htmlspecialchars($kullanici['u_soyadi']) ?>" required>
            </div>
            <div class="form-group">
                <label for="u_mail">Mail</label>
                <input type="email" name="u_mail" id="u_mail" value="<?= htmlspecialchars($kullanici['u_mail']) ?>" required>
            </div>
            <div class="form-group">
                <label for="u_telefon">Telefon</label>
                <input type="text" name="u_telefon" id="u_telefon" value="<?= htmlspecialchars($kullanici['u_telefon']) ?>" required>
            </div>
            <button type="submit">Güncelle</button>
        </form>
    </div>
</body>
</html>
