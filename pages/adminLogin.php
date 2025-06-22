<?php
session_start();
require_once('../includes/connection.php');

// Admin Giriş
if (isset($_POST["admin"])) {
    $a_adi = $_POST["a_adi"];
    $a_sifre = $_POST["a_sifre"];

    $sql = "SELECT * FROM admin WHERE a_adi = ? AND a_sifre = ?";
    $query = $connection->prepare($sql);
    $query->bindParam(1, $a_adi, PDO::PARAM_STR);
    $query->bindParam(2, $a_sifre, PDO::PARAM_STR);
    $query->execute();

    if ($result = $query->fetch()) {
        $_SESSION["admin_id"] = $result["a_id"];
        $_SESSION["a_adi"] = $result["a_adi"];
        header("Location: admin.php"); 
        exit;
    } else {
        echo "<script>alert('Admin giriş bilgileri hatalı.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Girişi</title>
    <link rel="stylesheet" href="/proje/assets/css/adminLogin.css?v=<?= time(); ?>">
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <img src="/proje/assets/images/adminLogin.png" alt="Admin Login Illustration">
        </div>
        <div class="login-right">
            <h2>Admin Girişi</h2>
            <p class="description">Yönetim paneline giriş yapın</p>
            <form method="POST" class="form">
                <label for="a_adi">Admin Adı</label>
                <input type="text" name="a_adi" id="a_adi" required>

                <label for="a_sifre">Şifre</label>
                <input type="password" name="a_sifre" id="a_sifre" required>

                <button type="submit" name="admin">Giriş Yap</button>
            </form>
        </div>
    </div>
</body>
</html>
