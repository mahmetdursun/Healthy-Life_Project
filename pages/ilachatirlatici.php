<?php
session_start();

// connection.php dosyasını dahil et
include __DIR__ . '/../includes/connection.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = 'Bu sayfaya erişmek için lütfen giriş yapınız.';
    header('Location: userLogin.php');
    exit;
}

// Bağlantı kontrolü
if (!isset($connection)) {
    die("Veritabanı bağlantısı sağlanamadı!");
}

// Kullanıcı ID'si (varsa session'dan al yoksa 1 ata)
$userId = $_SESSION['user_id'] ?? 1;

// POST isteği ile ilaç ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ilac_ismi']) && !empty($_POST['ilac_saati'])) {
    $ilacIsmi = trim($_POST['ilac_ismi']);
    $ilacSaati = trim($_POST['ilac_saati']);

    $stmt = $connection->prepare("INSERT INTO ilaclar (user_id, ilac_ismi, ilac_saati) VALUES (:user_id, :ilac_ismi, :ilac_saati)");
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':ilac_ismi', $ilacIsmi);
    $stmt->bindParam(':ilac_saati', $ilacSaati);
    $stmt->execute();

    header("Location: ilachatirlatici.php");
    exit();
}

// Kullanıcının kayıtlı ilaçlarını çek
$stmt = $connection->prepare("SELECT * FROM ilaclar WHERE user_id = :user_id ORDER BY ilac_saati");
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$ilaclar = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>İlaç Hatırlatıcı</title>
    <link rel="stylesheet" href="../assets/css/ilachatirlatici.css?v=<?= time(); ?>">
</head>
<body>
    <div class="container">
        <h1>💊 İlaç Hatırlatıcı</h1>

        <form method="post" action="">
            <label for="ilac_ismi">İlaç Adı:</label>
            <input type="text" name="ilac_ismi" id="ilac_ismi" required />

            <label for="ilac_saati">Saat (örn: 08:30):</label>
            <input type="time" name="ilac_saati" id="ilac_saati" required />

            <button type="submit">İlaç Ekle</button>
        </form>

        <h2>Kayıtlı İlaçların</h2>

        <?php if (count($ilaclar) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>İlaç Adı</th>
                        <th>Alınacak Saat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ilaclar as $ilac): ?>
                        <tr>
                            <td><?=htmlspecialchars($ilac['ilac_ismi'])?></td>
                            <td><?=htmlspecialchars($ilac['ilac_saati'])?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Henüz kayıtlı ilaç yok.</p>
        <?php endif; ?>

        <a href="../index.php">Ana Sayfaya Dön</a>
    </div>
</body>
</html>
