<?php
session_start();
require_once('../includes/connection.php');

if (isset($_SESSION['error_message'])):
?>
    <div style="
        position: fixed;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        background-color: #f44336;
        color: white;
        padding: 15px 25px;
        border-radius: 5px;
        font-family: sans-serif;
        font-size: 16px;
        font-weight: bold;
        z-index: 9999;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        text-align: center;
    ">
        ⚠️ <?= $_SESSION['error_message']; ?>
    </div>
<?php
unset($_SESSION['error_message']);
endif;

// Kullanıcı Giriş
if (isset($_POST["giris"])) {
    $mail = $_POST["mail"];
    $sifre = md5($_POST["sifre"]);

    $sql = "SELECT * FROM user WHERE u_mail = ? AND u_sifre = ?";
    $query = $connection->prepare($sql);
    $query->bindParam(1, $mail, PDO::PARAM_STR);
    $query->bindParam(2, $sifre, PDO::PARAM_STR);
    $query->execute();

    if ($result = $query->fetch()) {
        $_SESSION["user_id"] = $result["u_id"];
        $_SESSION["u_adi"] = $result["u_adi"];
        header("Location: /proje/index.php");
        exit;
    } else {
        echo "<script>alert('Giriş bilgileri hatalı.');</script>";
    }
}

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Formu</title>
    <link rel="stylesheet" href="/proje/assets/css/userLogin.css?v=<?= time(); ?>">
</head>
<body>
    <div class="container">
        <img src="img/logo.webp" alt="Logo" class="logo">
        <h2>Giriş Paneli</h2>
        <div class="form-wrapper">

            <!-- Kullanıcı Giriş Formu -->
            <div class="form">
                <div class="lock-icon"></div>
                <form action="" method="POST">
                    <label for="mail">Mail:</label>
                    <input type="text" id="mail" name="mail" required>

                    <label for="sifre">Şifre:</label>
                    <input type="password" id="sifre" name="sifre" required>

                    <button type="submit" name="giris">Giriş Yap</button>
                </form>
            </div>

            <!-- Admin Giriş Formu -->
            <div class="form">
                <div class="lock-icon"></div>
                <form action="" method="POST">
                    <label for="a_adi">Admin Adı:</label>
                    <input type="text" id="a_adi" name="a_adi" required>

                    <label for="a_sifre">Şifre:</label>
                    <input type="password" id="a_sifre" name="a_sifre" required>

                    <button type="submit" name="admin">Admin Giriş</button>
                </form>
            </div>

        </div>
    </div>
</body>
</html>
