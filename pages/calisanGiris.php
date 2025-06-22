<?php
session_start();
require_once('../includes/connection.php');

if (isset($_POST["calisan"])) {
    $mail = $_POST["c_mail"];
    $sifre = $_POST["c_sifre"]; 

    $sql = "SELECT * FROM calisanlar WHERE c_mail = ? AND c_sifre = ?";
    $query = $connection->prepare($sql);
    $query->bindParam(1, $mail, PDO::PARAM_STR);
    $query->bindParam(2, $sifre, PDO::PARAM_STR);
    $query->execute();

    if ($result = $query->fetch()) {
        $_SESSION["calisan_id"] = $result["c_id"];
        $_SESSION["c_adi"] = $result["c_adi"];
        $_SESSION["c_soyadi"] = $result["c_soyadi"];
        $_SESSION["tur"] = $result["tur"]; 
        header("Location: calisan_paneli.php");
        exit;
    } else {
        echo "<script>alert('Çalışan giriş bilgileri hatalı.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Çalışan Girişi</title>
    <link rel="stylesheet" href="/proje/assets/css/calisanLogin.css?v=<?= time(); ?>">
</head>
<body>
    <div class="form-container">
        <form action="" method="POST" class="login-form">
            <h2>Çalışan Girişi</h2>
            <label for="c_mail">Mail:</label>
            <input type="text" id="c_mail" name="c_mail" required>

            <label for="c_sifre">Şifre:</label>
            <input type="password" id="c_sifre" name="c_sifre" required>

            <button type="submit" name="calisan">Giriş Yap</button>
        </form>
    </div>
</body>
</html>