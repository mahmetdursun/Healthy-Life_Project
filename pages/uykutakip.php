<?php
session_start();
require_once('../includes/connection.php');

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = 'Bu sayfaya erişmek için lütfen giriş yapınız.';
    header('Location: userLogin.php');
    exit;
}

$kullanici_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tarih = $_POST['sleep_date'];
    $uyuma_saati = $_POST['sleep_time'];
    $uyanma_saati = $_POST['wake_time'];
    $notlar = $_POST['sleep_quality'];

    $query = "INSERT INTO uyku_kayitlari (kullanici_id, tarih, uyuma_saati, uyanma_saati, notlar) 
              VALUES (:kullanici_id, :tarih, :uyuma_saati, :uyanma_saati, :notlar)";
    $stmt = $connection->prepare($query);

    try {
        $stmt->execute([
            'kullanici_id' => $kullanici_id,
            'tarih' => $tarih,
            'uyuma_saati' => $uyuma_saati,
            'uyanma_saati' => $uyanma_saati,
            'notlar' => $notlar
        ]);

        $success_message = "Veriler başarıyla kaydedildi!";
    } catch (PDOException $e) {
        $error_message = "Hata: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Uyku Takip</title>
  <link rel="stylesheet" href="../assets/css/uykutakip.css?v=<?= time(); ?>">
</head>
<body>

  <div class="container">
    <h2>😴 Uyku Takip Formu</h2>
    <form action="#" method="post">
      <label for="sleep_date">📅 Tarih:</label>
      <input type="date" id="sleep_date" name="sleep_date" required>

      <label for="sleep_time">🌙 Uykuya Yatma Saati:</label>
      <input type="time" id="sleep_time" name="sleep_time" required>

      <label for="wake_time">☀️ Uyanma Saati:</label>
      <input type="time" id="wake_time" name="wake_time" required>

      <label for="sleep_quality">💬 Uyku Kalitesi / Not:</label>
      <textarea id="sleep_quality" name="sleep_quality" rows="4" placeholder="Örneğin: 7 saat uyudum, derin uyudum, uyanmak zor oldu..."></textarea>

      <button type="submit">💾 Kaydet</button>
      <a href="../index.php">Ana Sayfaya Dön</a>
    </form>
  </div>

</body>
</html>
