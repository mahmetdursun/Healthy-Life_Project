<?php
session_start();
require_once('../includes/connection.php');

$randevu_id = $_GET['id'] ?? null;

if (!$randevu_id) {
    header("Location: profile.php?section=randevular");
    exit;
}

$stmt = $connection->prepare("SELECT * FROM randevular WHERE r_id = :id");
$stmt->execute(['id' => $randevu_id]);
$randevu = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $update = $connection->prepare("UPDATE randevular SET tarih = :tarih, saat = :saat, randevu_notu = :not WHERE r_id = :id");
    $update->execute([
        'tarih' => $_POST['tarih'],
        'saat' => $_POST['saat'],
        'not' => $_POST['randevu_notu'],
        'id' => $randevu_id
    ]);
    header("Location: profile.php?section=randevular");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f2f2f2;
        padding: 30px;
        color: #333;
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
    }

    form {
        max-width: 500px;
        margin: auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.08);
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
    }

    input[type="date"],
    input[type="time"],
    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-bottom: 15px;
        font-size: 15px;
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        border: none;
        color: white;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #45a049;
    }
</style>

</head>

<body>
    <form method="POST">
        <label>Tarih:</label>
        <input type="date" name="tarih" value="<?= $randevu['tarih'] ?>" required><br>
        <label>Saat:</label>
        <input type="time" name="saat" value="<?= $randevu['saat'] ?>" required><br>
        <label>Not:</label>
        <textarea name="randevu_notu"><?= htmlspecialchars($randevu['randevu_notu']) ?></textarea><br>
        <button type="submit">Güncelle</button>
    </form>
</body>

</html>