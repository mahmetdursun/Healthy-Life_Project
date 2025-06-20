<?php
session_start();
require_once('../includes/connection.php');
include __DIR__ . '/tarif-array.php';
include __DIR__ . '/tarif-besin-array.php'; // 💡 EKLENDİ

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('Location: tarif-yemek_sec.php');
    exit;
}

$ogun = $_POST['ogun'] ?? 'belirsiz';
$tarih = date('Y-m-d');

// 🌟 1) Tarifler
$secilen = $_POST['secilen_tarifler'] ?? [];
foreach ($secilen as $tarif_id) {
    foreach ($tarifler as $ogun_listesi) {
        if (isset($ogun_listesi[$tarif_id])) {
            $tarif = $ogun_listesi[$tarif_id];

            $stmt = $connection->prepare("
                INSERT INTO kullanici_beslenme 
                (user_id, ogun, yemek, miktar, karbonhidrat, protein, yag, kalori, tarih) 
                VALUES 
                (:user_id, :ogun, :yemek, :miktar, :karbonhidrat, :protein, :yag, :kalori, :tarih)
            ");
            $stmt->execute([
                ':user_id' => $user_id,
                ':ogun' => $ogun,
                ':yemek' => $tarif['baslik'],
                ':miktar' => 100,
                ':karbonhidrat' => (float)filter_var($tarif['karb'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                ':protein' => (float)filter_var($tarif['pro'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                ':yag' => (float)filter_var($tarif['yag'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                ':kalori' => (float)filter_var($tarif['kalori'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                ':tarih' => $tarih
            ]);
        }
    }
}

// 🌟 2) Tamamlayıcı besinler
if (!empty($_POST['tamamlayici'])) {
    foreach ($_POST['tamamlayici'] as $besin_id) {
        if (isset($besinler['tamamlayicilar'][$besin_id])) {
            $b = $besinler['tamamlayicilar'][$besin_id];

            $stmt = $connection->prepare("
                INSERT INTO kullanici_beslenme 
                (user_id, ogun, yemek, miktar, karbonhidrat, protein, yag, kalori, tarih) 
                VALUES 
                (:user_id, :ogun, :yemek, :miktar, :karbonhidrat, :protein, :yag, :kalori, :tarih)
            ");
            $stmt->execute([
                ':user_id' => $user_id,
                ':ogun' => $ogun,
                ':yemek' => $b['isim'],
                ':miktar' => 100,
                ':karbonhidrat' => (float)filter_var($b['karb'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                ':protein' => (float)filter_var($b['pro'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                ':yag' => (float)filter_var($b['yag'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                ':kalori' => (float)filter_var($b['kalori'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                ':tarih' => $tarih
            ]);
        }
    }
}

// 🌟 3) İçecekler
if (!empty($_POST['icecekler'])) {
    foreach ($_POST['icecekler'] as $icecek_id) {
        if (isset($besinler['icecekler'][$icecek_id])) {
            $i = $besinler['icecekler'][$icecek_id];

            $stmt = $connection->prepare("
                INSERT INTO kullanici_beslenme 
                (user_id, ogun, yemek, miktar, karbonhidrat, protein, yag, kalori, tarih) 
                VALUES 
                (:user_id, :ogun, :yemek, :miktar, :karbonhidrat, :protein, :yag, :kalori, :tarih)
            ");
            $stmt->execute([
                ':user_id' => $user_id,
                ':ogun' => $ogun,
                ':yemek' => $i['isim'],
                ':miktar' => 100,
                ':karbonhidrat' => $i['karb'],
                ':protein' => $i['pro'],
                ':yag' => $i['yag'],
                ':kalori' => $i['kalori'],
                ':tarih' => $tarih
            ]);
        }
    }
}

// 🌟 4) Manuel yemek
if (!empty($_POST['manuel_yemek']) && !empty($_POST['manuel_miktar'])) {
    $isim = trim($_POST['manuel_yemek']);
    $miktar = (int) $_POST['manuel_miktar'];
    $karb = (float) $_POST['manuel_karbonhidrat'];
    $pro = (float) $_POST['manuel_protein'];
    $yag = (float) $_POST['manuel_yag'];
    $kalori = (float) $_POST['manuel_kalori'];

    if ($isim && $miktar > 0) {
        $stmt = $connection->prepare("
            INSERT INTO kullanici_beslenme 
            (user_id, ogun, yemek, miktar, karbonhidrat, protein, yag, kalori, tarih) 
            VALUES 
            (:user_id, :ogun, :yemek, :miktar, :karbonhidrat, :protein, :yag, :kalori, :tarih)
        ");
        $stmt->execute([
            ':user_id' => $user_id,
            ':ogun' => $ogun,
            ':yemek' => $isim,
            ':miktar' => $miktar,
            ':karbonhidrat' => $karb,
            ':protein' => $pro,
            ':yag' => $yag,
            ':kalori' => $kalori,
            ':tarih' => $tarih
        ]);
    }
}


header("Location: tarif-yemek_sec.php?success=1");
exit;
