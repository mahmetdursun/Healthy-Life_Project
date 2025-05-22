<?php
session_start();
include __DIR__ . '/../includes/connection.php';

if (!isset($connection)) {
    die("Veritabanı bağlantısı sağlanamadı!");
}

$userId = $_SESSION['user_id'] ?? 1;

$error = '';
$mesaj = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ruhHali = $_POST['ruh_hali'] ?? '';
    $tarih = $_POST['tarih'] ?? date('Y-m-d');
    $yorum = trim($_POST['yorum'] ?? '');

    $gecerliRuhlar = ['Mutlu', 'Neşeli', 'Motivasyonlu', 'Üzgün', 'Kötü', 'Stresli'];

    if (in_array($ruhHali, $gecerliRuhlar)) {
        $stmt = $connection->prepare("INSERT INTO kullanici_ruh_hali (user_id, ruh_hali, tarih, yorum) VALUES (:user_id, :ruh_hali, :tarih, :yorum)");
        $stmt->execute([
            ':user_id' => $userId,
            ':ruh_hali' => $ruhHali,
            ':tarih' => $tarih,
            ':yorum' => $yorum,
        ]);

        $pozitifler = ['Mutlu', 'Neşeli', 'Motivasyonlu'];
        $negatifler = ['Üzgün', 'Kötü', 'Stresli'];

        if (in_array($ruhHali, $pozitifler)) {
            $mesaj = "Harika! Bugün pozitif bir enerjiyle dolusun. Güzel günler bizi bekliyor!";
            $mesajTipi = 'pozitif';
        } elseif (in_array($ruhHali, $negatifler)) {
            $mesaj = "Zor günler olabilir ama unutma, her karanlık gecenin bir sabahı vardır. Güçlü kal!";
            $mesajTipi = 'negatif';
        } else {
            $mesaj = '';
            $mesajTipi = '';
        }
    } else {
        $error = "Lütfen geçerli bir ruh hali seçin.";
    }
}

$stmt = $connection->prepare("SELECT * FROM kullanici_ruh_hali WHERE user_id = :user_id ORDER BY tarih DESC, id DESC LIMIT 30");
$stmt->execute([':user_id' => $userId]);
$ruhKayitlari = $stmt->fetchAll(PDO::FETCH_ASSOC);

$ruhPuanlari = [
    'Mutlu' => 5,
    'Neşeli' => 4,
    'Motivasyonlu' => 4,
    'Üzgün' => 2,
    'Kötü' => 1,
    'Stresli' => 1,
];

$toplamPuan = 0;
$sayac = 0;
foreach ($ruhKayitlari as $kayit) {
    if (isset($ruhPuanlari[$kayit['ruh_hali']])) {
        $toplamPuan += $ruhPuanlari[$kayit['ruh_hali']];
        $sayac++;
    }
}
$ortalamaPuan = $sayac ? round($toplamPuan / $sayac, 2) : 0;
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8" />
<title>Ruh Hali Takibi</title>
<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: #f9f9f9;
        color: #333;
    }

    .container {
        max-width: 900px;
        margin: 40px auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        padding: 40px 50px;
        box-sizing: border-box;
    }

    h1 {
        font-size: 36px;
        font-weight: 700;
        color: #4CAF50;
        text-align: center;
        margin-bottom: 30px;
    }

    form label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 16px;
        color: #555;
        margin-top: 25px;
    }

    select, input[type="date"], textarea {
        width: 100%;
        padding: 12px 16px;
        border-radius: 8px;
        border: 1.5px solid #ccc;
        font-size: 16px;
        font-family: inherit;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    select:focus, input[type="date"]:focus, textarea:focus {
        border-color: #4CAF50;
        outline: none;
        box-shadow: 0 0 6px rgba(76, 175, 80, 0.4);
    }

    textarea {
        min-height: 90px;
        resize: vertical;
        font-size: 15px;
    }

    button {
        margin-top: 30px;
        width: 100%;
        padding: 15px;
        background: #4CAF50;
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: 700;
        font-size: 18px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button:hover {
        background: #45a049;
    }

    .mesaj {
        margin-top: 30px;
        padding: 20px;
        border-radius: 12px;
        font-weight: 600;
        text-align: center;
        font-size: 18px;
        box-shadow: 0 1px 8px rgba(0,0,0,0.1);
    }

    .pozitif {
        background-color: #d7f3d7;
        color: #2e7d32;
        border: 1.5px solid #4CAF50;
    }

    .negatif {
        background-color: #fce4e4;
        color: #c62828;
        border: 1.5px solid #e53935;
    }

    .error {
        color: #c62828;
        font-weight: 700;
        margin-top: 15px;
        text-align: center;
    }

    table {
        width: 100%;
        margin-top: 40px;
        border-collapse: separate;
        border-spacing: 0 12px;
        font-size: 15px;
    }

    th, td {
        padding: 14px 20px;
        background: #f9f9f9;
        color: #444;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        vertical-align: middle;
    }

    th {
        background: #4CAF50;
        color: white;
        font-weight: 600;
    }

    .grafik {
        margin-top: 35px;
        padding: 18px 20px;
        border-radius: 12px;
        background: #e8f5e9;
        border: 1.5px solid #4caf50;
        font-weight: 600;
        color: #388e3c;
        text-align: center;
        font-size: 17px;
    }

    progress {
        width: 100%;
        height: 24px;
        border-radius: 12px;
        margin-top: 12px;
        appearance: none;
        -webkit-appearance: none;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    progress::-webkit-progress-bar {
        background-color: #c8e6c9;
        border-radius: 12px;
    }

    progress::-webkit-progress-value {
        background-color: #4CAF50;
        border-radius: 12px;
    }

    progress::-moz-progress-bar {
        background-color: #4CAF50;
        border-radius: 12px;
    }
</style>
</head>
<body>

<div class="container">
    <h1>Ruh Hali Takibi</h1>

    <?php if ($error): ?>
        <p class="error"><?=htmlspecialchars($error)?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="ruh_hali">Ruh Haliniz:</label>
        <select id="ruh_hali" name="ruh_hali" required>
            <option value="">-- Seçiniz --</option>
            <option value="Mutlu" <?= (isset($ruhHali) && $ruhHali === 'Mutlu') ? 'selected' : '' ?>>Mutlu</option>
            <option value="Neşeli" <?= (isset($ruhHali) && $ruhHali === 'Neşeli') ? 'selected' : '' ?>>Neşeli</option>
            <option value="Motivasyonlu" <?= (isset($ruhHali) && $ruhHali === 'Motivasyonlu') ? 'selected' : '' ?>>Motivasyonlu</option>
            <option value="Üzgün" <?= (isset($ruhHali) && $ruhHali === 'Üzgün') ? 'selected' : '' ?>>Üzgün</option>
            <option value="Kötü" <?= (isset($ruhHali) && $ruhHali === 'Kötü') ? 'selected' : '' ?>>Kötü</option>
            <option value="Stresli" <?= (isset($ruhHali) && $ruhHali === 'Stresli') ? 'selected' : '' ?>>Stresli</option>
        </select>

        <label for="tarih">Tarih:</label>
        <input type="date" id="tarih" name="tarih" value="<?=htmlspecialchars($_POST['tarih'] ?? date('Y-m-d'))?>" required>

        <label for="yorum">Yorum (opsiyonel):</label>
        <textarea id="yorum" name="yorum" placeholder="Ruh halinizle ilgili not yazabilirsiniz..."><?=htmlspecialchars($_POST['yorum'] ?? '')?></textarea>

        <button type="submit">Kaydet</button>
    </form>

    <?php if ($mesaj): ?>
        <div class="mesaj <?= $mesajTipi ?>">
            <?=htmlspecialchars($mesaj)?>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Tarih</th>
                <th>Ruh Hali</th>
                <th>Yorum</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($ruhKayitlari): ?>
                <?php foreach ($ruhKayitlari as $kayit): ?>
                    <tr>
                        <td><?=htmlspecialchars($kayit['tarih'])?></td>
                        <td><?=htmlspecialchars($kayit['ruh_hali'])?></td>
                        <td><?=htmlspecialchars($kayit['yorum'])?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3">Henüz kayıt yok.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="grafik">
        Ortalama Ruh Hali Puanınız: <strong><?= $ortalamaPuan ?></strong> / 5
        <progress value="<?= $ortalamaPuan ?>" max="5"></progress>
    </div>
</div>

</body>
</html>
