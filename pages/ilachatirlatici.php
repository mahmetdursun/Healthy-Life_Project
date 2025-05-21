<?php
session_start();

// connection.php dosyasını dahil et
include __DIR__ . '/../includes/connection.php';

// Bağlantı kontrolü
if (!isset($connection)) {
    die("Veritabanı bağlantısı sağlanamadı!");
}

// Kullanıcı ID'si (varsa session'dan al yoksa 1 ata)
$userId = $_SESSION['user_id'] ?? 1;

// POST isteği ile ilaç ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ilac_ismi']) && !empty($_POST['ilac_saati'])) {
    $ilacIsmi = trim($_POST['ilac_ismi']);
    $ilacSaati = trim($_POST['ilac_saati']);

    $stmt = $connection->prepare("INSERT INTO ilaclar (user_id, ilac_ismi, ilac_saati) VALUES (:user_id, :ilac_ismi, :ilac_saati)");
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':ilac_ismi', $ilacIsmi);
    $stmt->bindParam(':ilac_saati', $ilacSaati);
    $stmt->execute();

    header("Location: ilachatirlatici.php");
    exit();
}

// Kullanıcının kayıtlı ilaçlarını çek
$stmt = $connection->prepare("SELECT * FROM ilaclar WHERE user_id = :user_id ORDER BY ilac_saati");
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$ilaclar = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>İlaç Hatırlatıcı</title>
    <style>
        /* Temel ayarlar */
        * {
            box-sizing: border-box;
        }
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background-color: white;
            max-width: 450px;
            width: 100%;
            border-radius: 12px;
            padding: 30px 40px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 {
            color: #4CAF50;
            margin-bottom: 25px;
            font-size: 28px;
        }
        form label {
            display: block;
            text-align: left;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
            margin-top: 15px;
        }
        form input[type="text"],
        form input[type="time"] {
            width: 100%;
            padding: 10px 12px;
            font-size: 16px;
            border: 1.5px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }
        form input[type="text"]:focus,
        form input[type="time"]:focus {
            outline: none;
            border-color: #4CAF50;
        }
        button {
            margin-top: 25px;
            width: 100%;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            padding: 12px 0;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #45a049;
        }
        h2 {
            margin-top: 40px;
            margin-bottom: 15px;
            color: #333;
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        thead {
            background-color: #4CAF50;
            color: white;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        p {
            color: #666;
            margin-top: 15px;
            text-align: left;
        }
        a {
            display: inline-block;
            margin-top: 30px;
            color: #4CAF50;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #388e3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>💊 İlaç Hatırlatıcı</h1>

        <form method="post" action="">
            <label for="ilac_ismi">İlaç Adı:</label>
            <input type="text" name="ilac_ismi" id="ilac_ismi" required />

            <label for="ilac_saati">Saat (örn: 08:30):</label>
            <input type="time" name="ilac_saati" id="ilac_saati" required />

            <button type="submit">İlaç Ekle</button>
        </form>

        <h2>Kayıtlı İlaçların</h2>

        <?php if (count($ilaclar) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>İlaç Adı</th>
                        <th>Alınacak Saat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ilaclar as $ilac): ?>
                        <tr>
                            <td><?=htmlspecialchars($ilac['ilac_ismi'])?></td>
                            <td><?=htmlspecialchars($ilac['ilac_saati'])?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Henüz kayıtlı ilaç yok.</p>
        <?php endif; ?>

        <a href="../index.php">Ana Sayfaya Dön</a>
    </div>
</body>
</html>
