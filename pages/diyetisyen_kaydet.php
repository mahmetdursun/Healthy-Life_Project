<?php
session_start();
require_once('../includes/connection.php');

if (!isset($_SESSION['user_id'])) {
    echo "Oturum bulunamadı.";
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form verilerini al
    $adsoyad = $_POST['adsoyad'];
    $yas = $_POST['yas'];
    $boy = $_POST['boy'];
    $kilo = $_POST['kilo'];
    $hedef_kilo = $_POST['hedef_kilo'] ?? null;
    $ogun = $_POST['ogun'] ?? null;
    $tercih = $_POST['tercih'] ?? 'Standart';
    $alerji = $_POST['alerji'] ?? null;
    $gecmis_diyet = $_POST['gecmis_diyet'] ?? null;
    $mesaj = $_POST['mesaj'] ?? null;

    // Dosya yükleme işlemi
    $rapor_yolu = null;
    if (isset($_FILES['rapor']) && $_FILES['rapor']['error'] == UPLOAD_ERR_OK) {
        $dosya_adi = time() . '_' . basename($_FILES['rapor']['name']);
        $hedef_dizin = '../uploads/';
        if (!is_dir($hedef_dizin)) {
            mkdir($hedef_dizin, 0777, true);
        }
        $hedef_yol = $hedef_dizin . $dosya_adi;
        move_uploaded_file($_FILES['rapor']['tmp_name'], $hedef_yol);
        $rapor_yolu = $dosya_adi;
    }

    try {
        $sql = "INSERT INTO diyetisyen_formlari 
            (user_id, adsoyad, yas, boy, kilo, hedef_kilo, ogun, tercih, alerji, gecmis_diyet, rapor, mesaj, created_at) 
            VALUES 
            (:user_id, :adsoyad, :yas, :boy, :kilo, :hedef_kilo, :ogun, :tercih, :alerji, :gecmis_diyet, :rapor, :mesaj, NOW())";

        $stmt = $connection->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':adsoyad' => $adsoyad,
            ':yas' => $yas,
            ':boy' => $boy,
            ':kilo' => $kilo,
            ':hedef_kilo' => $hedef_kilo,
            ':ogun' => $ogun,
            ':tercih' => $tercih,
            ':alerji' => $alerji,
            ':gecmis_diyet' => $gecmis_diyet,
            ':rapor' => $rapor_yolu,
            ':mesaj' => $mesaj
        ]);

        echo "<script>alert('Form başarıyla kaydedildi.'); window.location.href = 'diyetisyen_destek.php';</script>";
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
} else {
    echo "Geçersiz istek.";
}
