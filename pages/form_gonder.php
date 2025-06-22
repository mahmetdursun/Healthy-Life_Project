<?php
session_start();
require_once('../includes/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION['user_id'] ?? null;

    $ad_soyad = $_POST['ad_soyad'];
    $yas = $_POST['yas'];
    $boy = $_POST['boy'];
    $kilo = $_POST['kilo'];
    $kan_grubu = $_POST['kan_grubu'];
    $alerjiler = $_POST['alerjiler'];
    $hastaliklar = isset($_POST['hastaliklar']) ? implode(", ", $_POST['hastaliklar']) : '';
    $su = $_POST['su'];
    $uyku = $_POST['uyku'];
    $sigara = $_POST['sigara'];
    $ilaclar = $_POST['ilaclar'];
    $stres = $_POST['stres'];
    $adet_duzeni = $_POST['adet_duzeni'];
    $aile_hastalik = $_POST['aile_hastalik'];
    $spor = $_POST['spor'];

    try {
        $sql = "INSERT INTO saglik_bilgileri 
        (user_id, ad_soyad, yas, boy, kilo, kan_grubu, alerjiler, hastaliklar, su, uyku, sigara, ilaclar, stres, adet_duzeni, aile_hastalik, spor)
        VALUES (:user_id, :ad_soyad, :yas, :boy, :kilo, :kan_grubu, :alerjiler, :hastaliklar, :su, :uyku, :sigara, :ilaclar, :stres, :adet_duzeni, :aile_hastalik, :spor)";

        $stmt = $connection->prepare($sql);

        $stmt->execute([
            ':user_id' => $user_id,
            ':ad_soyad' => $ad_soyad,
            ':yas' => $yas,
            ':boy' => $boy,
            ':kilo' => $kilo,
            ':kan_grubu' => $kan_grubu,
            ':alerjiler' => $alerjiler,
            ':hastaliklar' => $hastaliklar,
            ':su' => $su,
            ':uyku' => $uyku,
            ':sigara' => $sigara,
            ':ilaclar' => $ilaclar,
            ':stres' => $stres,
            ':adet_duzeni' => $adet_duzeni,
            ':aile_hastalik' => $aile_hastalik,
            ':spor' => $spor
        ]);

        // Başarılı ise yönlendir
        header("Location: profile.php?section=saglik");
        exit();

    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}
?>
