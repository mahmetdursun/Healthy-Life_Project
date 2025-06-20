<?php
session_start();
require_once('../includes/connection.php');

$sql = "SELECT * FROM user ORDER BY u_id DESC LIMIT 1";
$stmt = $connection->prepare($sql);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: userLogin.php");
    exit;
}

$kilo = $user['u_kilo'];
$boy = $user['u_boy'];
$antrenman_suresi = $user['u_antrenman_suresi'];
$cinsiyet = $user['u_cinsiyet'];
$aktivite = $user['u_aktivite'];
$hedef = $user['u_hedef'];
$dogumtarih = $user['u_dogumtarih'];

$dogum = new DateTime($dogumtarih);
$bugun = new DateTime();
$yas = $bugun->diff($dogum)->y;

// BMR
if ($cinsiyet == 'erkek') {
    $bmr = 10 * $kilo + 6.25 * $boy - 5 * $yas + 5;
} else {
    $bmr = 10 * $kilo + 6.25 * $boy - 5 * $yas - 161;
}

// Aktivite katsayısı
switch ($aktivite) {
    case 'hareketsiz': $aktivite_katsayisi = 1.2; break;
    case 'hafif':      $aktivite_katsayisi = 1.375; break;
    case 'orta':       $aktivite_katsayisi = 1.55; break;
    case 'çok':        $aktivite_katsayisi = 1.725; break;
    default:           $aktivite_katsayisi = 1.2;
}

$gunluk_kalori = round($bmr * $aktivite_katsayisi);

// Hedefe göre ayarlama
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

// Makro hesaplama (%40 Karbonhidrat, %30 Protein, %30 Yağ)
$gunluk_karbonhidrat = round($hedef_kalori * 0.4 / 4);
$gunluk_protein = round($hedef_kalori * 0.3 / 4);
$gunluk_yag = round($hedef_kalori * 0.3 / 9);

// Veritabanına kaydet
$update = $connection->prepare("UPDATE user SET 
    gunluk_kalori = :kalori,
    gunluk_protein = :protein,
    gunluk_yag = :yag,
    gunluk_karbonhidrat = :karb
    WHERE u_id = :id");

$update->execute([
    ':kalori' => $hedef_kalori,
    ':protein' => $gunluk_protein,
    ':yag' => $gunluk_yag,
    ':karb' => $gunluk_karbonhidrat,
    ':id' => $user['u_id']
]);

// Antrenman mesajı
if ($antrenman_suresi < 30) {
    $antrenman_mesaj = "Antrenman süren az. Günlük en az 30 dakika egzersiz öneriyoruz.";
} elseif ($antrenman_suresi <= 60) {
    $antrenman_mesaj = "Antrenman süren iyi. Düzenli devam edersen hedeflerine rahat ulaşırsın.";
} else {
    $antrenman_mesaj = "Süper! Yoğun bir antrenman programın var, bu şekilde hedeflerine daha hızlı ulaşırsın.";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Hesaplama Sonucu</title>
    <link rel="stylesheet" href="/proje/assets/css/hesapla.css?v=<?= time(); ?>">
</head>
<body>
<div class="container">
    <h2>Hoş Geldin <?php echo htmlspecialchars($user['u_adi']); ?>!</h2>
    <p>Yaşın: <strong><?php echo $yas; ?> yaş</strong></p>
    <p>Günlük tahmini kalori ihtiyacın: <strong><?php echo $gunluk_kalori; ?> kcal</strong></p>
    <p><strong><?php echo $hedef_mesaj; ?></strong></p>

    <h3>🎯 Günlük Makro Hedeflerin</h3>
    <ul>
        <li>🍞 Karbonhidrat: <strong><?php echo $gunluk_karbonhidrat; ?>g</strong></li>
        <li>🥩 Protein: <strong><?php echo $gunluk_protein; ?>g</strong></li>
        <li>🥑 Yağ: <strong><?php echo $gunluk_yag; ?>g</strong></li>
    </ul>

    <p><?php echo $antrenman_mesaj; ?></p>

    <a href="/proje/index.php" class="button">Ana Sayfaya Dön</a>
</div>
</body>
</html>
