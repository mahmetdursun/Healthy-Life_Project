<?php
session_start();
require_once('../includes/connection.php');

// Şu anki kullanıcıyı sessiondan almıyoruz, çünkü kayıt sonrası doğrudan buraya geliyoruz.
// Veritabanından en son eklenen kullanıcıyı çekelim:

$sql = "SELECT * FROM user ORDER BY u_id DESC LIMIT 1";
$stmt = $connection->prepare($sql);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Eğer kullanıcı bulunamadıysa login'e yönlendir
if (!$user) {
    header("Location: userLogin.php");
    exit;
}

// Verileri çekelim
$kilo = $user['u_kilo'];
$boy = $user['u_boy'];
$antrenman_suresi = $user['u_antrenman_suresi'];
$cinsiyet = $user['u_cinsiyet'];
$aktivite = $user['u_aktivite'];
$hedef = $user['u_hedef'];
$dogumtarih = $user['u_dogumtarih'];

// Yaşı Hesapla
$dogum = new DateTime($dogumtarih);
$bugun = new DateTime();
$yas = $bugun->diff($dogum)->y;

// BMR Hesapla
if ($cinsiyet == 'erkek') {
    $bmr = 10 * $kilo + 6.25 * $boy - 5 * $yas + 5;
} else {
    $bmr = 10 * $kilo + 6.25 * $boy - 5 * $yas - 161;
}

// Aktivite Katsayısı
switch ($aktivite) {
    case 'hareketsiz':
        $aktivite_katsayisi = 1.2;
        break;
    case 'hafif':
        $aktivite_katsayisi = 1.375;
        break;
    case 'orta':
        $aktivite_katsayisi = 1.55;
        break;
    case 'çok':
        $aktivite_katsayisi = 1.725;
        break;
    default:
        $aktivite_katsayisi = 1.2;
}

// Günlük kalori ihtiyacı
$gunluk_kalori = round($bmr * $aktivite_katsayisi);

// Hedefe Göre Ayarlama
if ($hedef == 'kilo_vermek') {
    $hedef_kalori = $gunluk_kalori - 500;
    $hedef_mesaj = "Kilo vermek için günlük yaklaşık $hedef_kalori kcal almalısın.";
} elseif ($hedef == 'kilo_almak') {
    $hedef_kalori = $gunluk_kalori + 300;
    $hedef_mesaj = "Kilo almak için günlük yaklaşık $hedef_kalori kcal almalısın.";
} else {
    $hedef_kalori = $gunluk_kalori;
    $hedef_mesaj = "Kilonu korumak için günlük yaklaşık $hedef_kalori kcal almalısın.";
}

// Günlük kalori ihtiyacını veritabanına kaydet
$update = $connection->prepare("UPDATE user SET gunluk_kalori = :kalori WHERE u_id = :id");
$update->execute([
    ':kalori' => $hedef_kalori,
    ':id' => $user['u_id']
]);

// Antrenman süresine göre öneri
if ($antrenman_suresi < 30) {
    $antrenman_mesaj = "Antrenman süren az. Günlük en az 30 dakika egzersiz öneriyoruz.";
} elseif ($antrenman_suresi >= 30 && $antrenman_suresi <= 60) {
    $antrenman_mesaj = "Antrenman süren iyi. Düzenli devam edersen hedeflerine rahat ulaşırsın.";
} else {
    $antrenman_mesaj = "Süper! Yoğun bir antrenman programın var, bu şekilde hedeflerine daha hızlı ulaşırsın.";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hesaplama Sonucu</title>
    <link rel="stylesheet" href="/proje/assets/css/hesapla.css?v=<?= time(); ?>">
</head>
<body>
    <div class="container">
        <h2>Hoş Geldin <?php echo htmlspecialchars($user['u_adi']); ?>!</h2>
        <p>Yaşın: <strong><?php echo $yas; ?> yaş</strong></p>
        <p>Günlük tahmini kalori ihtiyacın: <strong><?php echo $gunluk_kalori; ?> kcal</strong></p>
        <p><?php echo $hedef_mesaj; ?></p>
        <p><?php echo $antrenman_mesaj; ?></p>

        <a href="/proje/index.php" class="button">Ana Sayfaya Dön</a>
    </div>
</body>
</html>
