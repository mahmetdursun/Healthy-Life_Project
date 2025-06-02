<?php
session_start();
require_once 'connection.php';
?>
<?php
// Mesajları çek
$stmtMesaj = $connection->prepare("SELECT icerik FROM motivasyon WHERE tur = 'mesaj'");
$stmtMesaj->execute();
$mesajlar = $stmtMesaj->fetchAll(PDO::FETCH_COLUMN);

// Önerileri çek
$stmtOneri = $connection->prepare("SELECT icerik FROM motivasyon WHERE tur = 'oneri'");
$stmtOneri->execute();
$oneriler = $stmtOneri->fetchAll(PDO::FETCH_COLUMN);

// Rastgele seçim
$gununMesaji = $mesajlar[array_rand($mesajlar)];
$gununOnerisi = $oneriler[array_rand($oneriler)];
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Günlük Motivasyon</title>
    <link rel="stylesheet" href="../assets/css/motivasyon.css?v=<?= time(); ?>">
</head>
<body>

    <header class="navbar">
        <div class="logo">SağlıklıYaşam</div>
        <nav>
            <a href="../index.php">Ana Sayfa</a>
            <a href="#motivasyon">Motivasyon</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php">Panel</a>
                <a href="logout.php" class="btn">Çıkış</a>
            <?php else: ?>
                <a href="userLogin.php">Giriş</a>
                <a href="userRegistration.php" class="btn">Kayıt</a>
            <?php endif; ?>
        </nav>
    </header>

    <section class="content" id="motivasyon">
        <?php
        $mesajlar = [
            "Bugün bir adım atmak, yarın için dev bir adımdır.",
            "Sağlığın kıymetini kaybetmeden bil!",
            "Küçük değişimler, büyük sonuçlar doğurur.",
            "Kendine iyi bak, çünkü sen özelsin.",
            "Zihinsel sağlık, beden sağlığıyla başlar.",
            "Başlamak için harika bir gün!",
            "Unutma, sağlıklı yaşam bir yolculuktur, yarış değil."
        ];

        $oneriler = [
            "Bugün 2 litre su içmeyi hedefle!",
            "10 dakikalık kısa bir yürüyüş yap.",
            "Şekerli içecek yerine limonlu su dene.",
            "Bir meditasyon müziği açıp rahatla.",
            "Ekran süreni bugün 30 dk azaltmaya çalış."
        ];

        $gununMesaji = $mesajlar[array_rand($mesajlar)];
        $gununOnerisi = $oneriler[array_rand($oneriler)];
        ?>

        <div class="message-box">
            <h2> Günün Motivasyon Mesajı</h2>
            <p><?= $gununMesaji ?></p>
        </div>

        <div class="suggestion-box">
            <h2> Bugünün Önerisi</h2>
            <p><?= $gununOnerisi ?></p>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 SağlıklıYaşam Takip</p>
    </footer>

</body>
</html>