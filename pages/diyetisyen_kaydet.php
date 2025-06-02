<?php
session_start();
require_once 'connection.php';


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
        $hedef_dizin = '../uploads/'; // uploads klasörü olmalı
        if (!is_dir($hedef_dizin)) {
            mkdir($hedef_dizin, 0777, true);
        }
        $hedef_yol = $hedef_dizin . $dosya_adi;
        move_uploaded_file($_FILES['rapor']['tmp_name'], $hedef_yol);
        $rapor_yolu = $dosya_adi;
    }

    try {
        $sql = "INSERT INTO diyetisyen_formlari 
                (adsoyad, yas, boy, kilo, hedef_kilo, ogun, tercih, alerji, gecmis_diyet, rapor, mesaj) 
                VALUES (:adsoyad, :yas, :boy, :kilo, :hedef_kilo, :ogun, :tercih, :alerji, :gecmis_diyet, :rapor, :mesaj)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
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
?>
