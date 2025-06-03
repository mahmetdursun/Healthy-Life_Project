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
<link rel="stylesheet" href="../assets/css/ruh_takip.css?v=<?= time(); ?>">
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
    <a href="../index.php">Ana Sayfaya Dön</a>
</div>

</body>
</html>
