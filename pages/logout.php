<?php
session_start();
session_unset();      // Tüm session değişkenlerini temizle
session_destroy();    // Oturumu tamamen sonlandır

header("Location: ../index.php");  // Anasayfaya yönlendir
exit;
?>