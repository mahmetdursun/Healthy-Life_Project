<?php
session_start();
include __DIR__ . '/../includes/connection.php';

if (!isset($connection)) {
    die("Veritabanı bağlantısı sağlanamadı!");
}

$userId = $_SESSION['user_id'] ?? 1;

$egzersizListesi = [
    "Koşu",
    "Yürüyüş",
    "Bisiklet",
    "Yoga",
    "Pilates",
    "Ağırlık Antrenmanı",
    "Yüzme",
    "Zumba",
    "Squat",
    "Plank"
];

// Egzersiz türlerine göre ortalama kalori yakma oranı (kcal/dakika)
$kaloriOranlari = [
    "Koşu" => 10,
    "Yürüyüş" => 4,
    "Bisiklet" => 8,
    "Yoga" => 3,
    "Pilates" => 4,
    "Ağırlık Antrenmanı" => 6,
    "Yüzme" => 9,
    "Zumba" => 7,
    "Squat" => 5,
    "Plank" => 4
];

// Egzersizleri kaydet
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['egzersiz']) && is_array($_POST['egzersiz'])) {
    foreach ($_POST['egzersiz'] as $adi => $veri) {
        $sure = $veri['sure'] ?? '';
        $baslangic = $veri['baslangic'] ?? null;
        $bitis = $veri['bitis'] ?? null;

        if (!empty($sure) && is_numeric($sure)) {
            // Aynı egzersiz var mı kontrol et
            $kontrol = $connection->prepare("SELECT id, suresi FROM egzersizler WHERE user_id = :user_id AND egzersiz_adi = :egzersiz_adi");
            $kontrol->execute([
                ':user_id' => $userId,
                ':egzersiz_adi' => $adi
            ]);
            $varMi = $kontrol->fetch(PDO::FETCH_ASSOC);

            if ($varMi) {
                // Kayıt varsa süreyi ekle, saatleri güncelle
                $yeniSure = $varMi['suresi'] + $sure;
                $update = $connection->prepare("UPDATE egzersizler SET suresi = :suresi, baslangic_saati = :baslangic, bitis_saati = :bitis WHERE id = :id");
                $update->execute([
                    ':suresi' => $yeniSure,
                    ':baslangic' => $baslangic,
                    ':bitis' => $bitis,
                    ':id' => $varMi['id']
                ]);
            } else {
                // Yoksa yeni kayıt ekle
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

    header("Location: egzersizplanlayici.php");
    exit();
}

// Egzersizleri çek
$stmt = $connection->prepare("SELECT * FROM egzersizler WHERE user_id = :user_id ORDER BY id DESC");
$stmt->execute([':user_id' => $userId]);
$egzersizler = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Toplam yakılan kalori hesapla
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
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        h1, h2, h3 {
            text-align: center;
            color: #2c3e50;
        }

        form {
            margin-top: 20px;
        }

        .egzersiz-listesi {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
            gap: 20px;
        }

        .egzersiz-item {
            background-color: #eef4f8;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .egzersiz-item label {
            font-weight: bold;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .egzersiz-item input[type="number"],
        .egzersiz-item input[type="time"] {
            width: 100%;
            margin-top: 6px;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            display: block;
            margin: 30px auto;
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #f0f0f0;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 30px;
            text-decoration: none;
            color: #2980b9;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>🏋️ Egzersiz Planlayıcı</h1>

    <form method="post">
        <div class="egzersiz-listesi">
            <?php foreach ($egzersizListesi as $egzersiz):
                $id = md5($egzersiz);
                ?>
                <div class="egzersiz-item">
                    <label>
                        <input type="checkbox" onclick="toggleFields(this)" data-target="<?= $id ?>">
                        <?= htmlspecialchars($egzersiz) ?>
                    </label>
                    <input type="number" name="egzersiz[<?= $egzersiz ?>][sure]" id="sure-<?= $id ?>" placeholder="Süre (dk)" min="0" disabled>
                    <input type="time" name="egzersiz[<?= $egzersiz ?>][baslangic]" id="start-<?= $id ?>" disabled>
                    <input type="time" name="egzersiz[<?= $egzersiz ?>][bitis]" id="end-<?= $id ?>" disabled>
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
            <?php foreach ($egzersizler as $row):
                $kalori = 0;
                if (isset($kaloriOranlari[$row['egzersiz_adi']])) {
                    $kalori = $row['suresi'] * $kaloriOranlari[$row['egzersiz_adi']];
                }
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['egzersiz_adi']) ?></td>
                    <td><?= htmlspecialchars($row['suresi']) ?></td>
                    <td><?= $row['baslangic_saati'] ?? '-' ?></td>
                    <td><?= $row['bitis_saati'] ?? '-' ?></td>
                    <td><?= number_format($kalori, 2) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center;">Henüz kayıtlı egzersiz yok.</p>
    <?php endif; ?>

    <a href="../index.php">← Ana Sayfaya Dön</a>
</div>

<script>
    function toggleFields(checkbox) {
        const id = checkbox.getAttribute('data-target');
        document.getElementById('sure-' + id).disabled = !checkbox.checked;
        document.getElementById('start-' + id).disabled = !checkbox.checked;
        document.getElementById('end-' + id).disabled = !checkbox.checked;
    }
</script>
</body>
</html>
