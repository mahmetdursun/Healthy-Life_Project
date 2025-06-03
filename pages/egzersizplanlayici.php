<?php
session_start();
include __DIR__ . '/../includes/connection.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = 'Bu sayfaya erişmek için lütfen giriş yapınız.';
    header('Location: userLogin.php');
    exit;
}

if (!isset($connection)) {
    die("Veritabanı bağlantısı sağlanamadı!");
}

$userId = $_SESSION['user_id'] ?? 1;

$egzersizListesi = [
    "Koşu", "Yürüyüş", "Bisiklet", "Yoga", "Pilates",
    "Ağırlık Antrenmanı", "Yüzme", "Zumba", "Squat", "Plank"
];

$kaloriOranlari = [
    "Koşu" => 10, "Yürüyüş" => 4, "Bisiklet" => 8, "Yoga" => 3,
    "Pilates" => 4, "Ağırlık Antrenmanı" => 6, "Yüzme" => 9,
    "Zumba" => 7, "Squat" => 5, "Plank" => 4
];

$hataMesaji = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['egzersiz']) && is_array($_POST['egzersiz'])) {
    $gecerliVeriVarMi = false;

    foreach ($_POST['egzersiz'] as $adi => $veri) {
        $sure = $veri['sure'] ?? '';
        $baslangic = $veri['baslangic'] ?? null;
        $bitis = $veri['bitis'] ?? null;

        // Eğer checkbox seçilmemişse veri gönderilmesin
        if (!isset($_POST['secili'][$adi])) {
            if (!empty($sure)) {
                $hataMesaji = "$adi egzersizi için süre girildi ama seçim yapılmadı.";
                break;
            }
            continue;
        }

        if (!empty($sure) && is_numeric($sure)) {
            $gecerliVeriVarMi = true;

            $kontrol = $connection->prepare("SELECT id, suresi FROM egzersizler WHERE user_id = :user_id AND egzersiz_adi = :egzersiz_adi");
            $kontrol->execute([
                ':user_id' => $userId,
                ':egzersiz_adi' => $adi
            ]);
            $varMi = $kontrol->fetch(PDO::FETCH_ASSOC);

            if ($varMi) {
                $yeniSure = $varMi['suresi'] + $sure;
                $update = $connection->prepare("UPDATE egzersizler SET suresi = :suresi, baslangic_saati = :baslangic, bitis_saati = :bitis WHERE id = :id");
                $update->execute([
                    ':suresi' => $yeniSure,
                    ':baslangic' => $baslangic,
                    ':bitis' => $bitis,
                    ':id' => $varMi['id']
                ]);
            } else {
                $insert = $connection->prepare("INSERT INTO egzersizler (user_id, egzersiz_adi, suresi, baslangic_saati, bitis_saati)
                    VALUES (:user_id, :egzersiz_adi, :suresi, :baslangic, :bitis)");
                $insert->execute([
                    ':user_id' => $userId,
                    ':egzersiz_adi' => $adi,
                    ':suresi' => $sure,
                    ':baslangic' => $baslangic,
                    ':bitis' => $bitis
                ]);
            }
        }
    }

    if (empty($hataMesaji) && $gecerliVeriVarMi) {
        header("Location: egzersizplanlayici.php");
        exit;
    }
}

$stmt = $connection->prepare("SELECT * FROM egzersizler WHERE user_id = :user_id ORDER BY id DESC");
$stmt->execute([':user_id' => $userId]);
$egzersizler = $stmt->fetchAll(PDO::FETCH_ASSOC);

$toplamKalori = 0;
foreach ($egzersizler as $egz) {
    $sure = (float)$egz['suresi'];
    $adi = $egz['egzersiz_adi'];
    if (isset($kaloriOranlari[$adi])) {
        $toplamKalori += $sure * $kaloriOranlari[$adi];
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Egzersiz Planlayıcı</title>
    <link rel="stylesheet" href="../assets/css/egzersizplanlayici.css?v=<?= time(); ?>">
</head>
<body>
<div class="container">
    <h1>🏋️ Egzersiz Planlayıcı</h1>

    <?php if (!empty($hataMesaji)): ?>
        <div style="color: red; margin-bottom: 1rem; font-weight: bold;"><?= htmlspecialchars($hataMesaji) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="egzersiz-listesi">
            <?php foreach ($egzersizListesi as $egzersiz): ?>
                <div class="egzersiz-item">
                    <label>
                        <input type="checkbox" name="secili[<?= $egzersiz ?>]">
                        <?= htmlspecialchars($egzersiz) ?>
                    </label>
                    <input type="number" name="egzersiz[<?= $egzersiz ?>][sure]" placeholder="Süre (dk)" min="0">
                    <input type="time" name="egzersiz[<?= $egzersiz ?>][baslangic]">
                    <input type="time" name="egzersiz[<?= $egzersiz ?>][bitis]">
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit">Egzersizleri Kaydet</button>
    </form>

    <h2>📋 Kayıtlı Egzersizler</h2>
    <h3>🔥 Toplam Yakılan Kalori: <?= number_format($toplamKalori, 2) ?> kcal</h3>

    <?php if (count($egzersizler) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Egzersiz Adı</th>
                    <th>Süre (dk)</th>
                    <th>Başlangıç Saati</th>
                    <th>Bitiş Saati</th>
                    <th>Yakılan Kalori (kcal)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($egzersizler as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['egzersiz_adi']) ?></td>
                        <td><?= htmlspecialchars($row['suresi']) ?></td>
                        <td><?= $row['baslangic_saati'] ?? '-' ?></td>
                        <td><?= $row['bitis_saati'] ?? '-' ?></td>
                        <td><?= number_format($row['suresi'] * $kaloriOranlari[$row['egzersiz_adi']], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center;">Henüz kayıtlı egzersiz yok.</p>
    <?php endif; ?>

    <a href="../index.php">← Ana Sayfaya Dön</a>
</div>
</body>
</html>
