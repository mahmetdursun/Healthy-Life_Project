<?php
session_start();
require_once('../includes/connection.php');

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = 'Bu sayfaya erişmek için lütfen giriş yapınız.';
    header('Location: userLogin.php');
    exit;
}

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
        <a href="../index.php">Ana Sayfaya Dön</a>
    </section>
</body>
</html>