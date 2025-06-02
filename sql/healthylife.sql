-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 02 Haz 2025, 18:13:08
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `healthylife`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin`
--

CREATE TABLE `admin` (
  `a_id` int(11) NOT NULL,
  `a_adi` varchar(50) NOT NULL,
  `a_sifre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `admin`
--

INSERT INTO `admin` (`a_id`, `a_adi`, `a_sifre`) VALUES
(1, 'ahmet', '19053466'),
(2, 'sude', '0987654321'),
(3, 'esma', '1234567890');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `diyetisyen_formlari`
--

CREATE TABLE `diyetisyen_formlari` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `adsoyad` varchar(100) NOT NULL,
  `yas` int(11) NOT NULL,
  `boy` int(11) NOT NULL,
  `kilo` int(11) NOT NULL,
  `hedef_kilo` int(11) DEFAULT NULL,
  `ogun` text DEFAULT NULL,
  `tercih` enum('Standart','Vegan','Vejetaryen','Glütensiz','Ketojenik') DEFAULT 'Standart',
  `alerji` varchar(255) DEFAULT NULL,
  `gecmis_diyet` text DEFAULT NULL,
  `rapor` varchar(255) DEFAULT NULL,
  `mesaj` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `diyetisyen_formlari`
--

INSERT INTO `diyetisyen_formlari` (`id`, `user_id`, `adsoyad`, `yas`, `boy`, `kilo`, `hedef_kilo`, `ogun`, `tercih`, `alerji`, `gecmis_diyet`, `rapor`, `mesaj`, `created_at`) VALUES
(1, NULL, 'FGSG', 3, 4, 4, 3, 'gfdggdfg', 'Standart', 'gdfd', 'gdgdgd', NULL, 'gddggd', '2025-06-02 11:40:42');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `egzersizler`
--

CREATE TABLE `egzersizler` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `egzersiz_adi` varchar(100) NOT NULL,
  `suresi` int(11) NOT NULL,
  `baslangic_saati` time DEFAULT NULL,
  `bitis_saati` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `egzersizler`
--

INSERT INTO `egzersizler` (`id`, `user_id`, `egzersiz_adi`, `suresi`, `baslangic_saati`, `bitis_saati`, `created_at`) VALUES
(1, 1, 'Koşu', 30, '17:00:00', '18:32:00', '2025-05-21 12:30:24'),
(2, 1, 'Zumba', 60, '16:30:00', '17:30:00', '2025-05-21 12:30:24'),
(3, 1, 'Koşu', 30, '16:42:00', '17:42:00', '2025-05-21 12:43:02'),
(4, 1, 'Yürüyüş', 50, '17:42:00', '19:42:00', '2025-05-21 12:43:02');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ilaclar`
--

CREATE TABLE `ilaclar` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ilac_ismi` varchar(255) NOT NULL,
  `ilac_saati` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ilaclar`
--

INSERT INTO `ilaclar` (`id`, `user_id`, `ilac_ismi`, `ilac_saati`) VALUES
(1, 1, 'parol', '12:00:00'),
(2, 1, 'parol', '12:30:00'),
(3, 6, 'esma', '19:45:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kisisel_hedefler`
--

CREATE TABLE `kisisel_hedefler` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `su_hedef` decimal(4,1) DEFAULT NULL,
  `uyku_hedef` decimal(4,1) DEFAULT NULL,
  `adim_hedef` int(11) DEFAULT NULL,
  `sabah_rutin` varchar(255) DEFAULT NULL,
  `aksam_rutin` varchar(255) DEFAULT NULL,
  `gunluk_motivasyon` text DEFAULT NULL,
  `yeni_aliskanlik` varchar(255) DEFAULT NULL,
  `stres_strateji` text DEFAULT NULL,
  `minnettarlik` text DEFAULT NULL,
  `ruh_hali` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kisisel_hedefler`
--

INSERT INTO `kisisel_hedefler` (`id`, `u_id`, `su_hedef`, `uyku_hedef`, `adim_hedef`, `sabah_rutin`, `aksam_rutin`, `gunluk_motivasyon`, `yeni_aliskanlik`, `stres_strateji`, `minnettarlik`, `ruh_hali`, `created_at`) VALUES
(1, 6, -0.2, 0.2, -3, 'nvn', 'nvv', 'nbn', 'vnvn', 'nvnv', 'bnvb', 'Mutlu', '2025-06-02 12:22:13');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(50) NOT NULL,
  `parola` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `kayit_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `kullanici_adi`, `parola`, `email`, `kayit_tarihi`) VALUES
(1, 'deneme', '123456', 'deneme@example.com', '2025-05-21 12:55:21');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici_beslenme`
--

CREATE TABLE `kullanici_beslenme` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ogun` varchar(50) NOT NULL,
  `yemek` varchar(255) NOT NULL,
  `miktar` float NOT NULL,
  `karbonhidrat` float NOT NULL,
  `protein` float NOT NULL,
  `yag` float NOT NULL,
  `kalori` float NOT NULL,
  `tarih` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanici_beslenme`
--

INSERT INTO `kullanici_beslenme` (`id`, `user_id`, `ogun`, `yemek`, `miktar`, `karbonhidrat`, `protein`, `yag`, `kalori`, `tarih`, `created_at`) VALUES
(1, 1, 'Atıştırmalık', 'Ceviz', 30, 4.2, 4.5, 19.5, 195, '2025-05-22', '2025-05-22 09:13:34'),
(2, 1, 'İçecek', 'Taze Sıkılmış Portakal Suyu', 200, 20, 2, 0.4, 90, '2025-05-22', '2025-05-22 09:13:34');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici_ruh_hali`
--

CREATE TABLE `kullanici_ruh_hali` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ruh_hali` varchar(20) NOT NULL,
  `tarih` date NOT NULL,
  `yorum` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanici_ruh_hali`
--

INSERT INTO `kullanici_ruh_hali` (`id`, `user_id`, `ruh_hali`, `tarih`, `yorum`, `created_at`) VALUES
(1, 1, 'Kötü', '2025-05-22', 'staj', '2025-05-22 08:40:39'),
(2, 1, 'Neşeli', '2025-05-22', 'öylesine', '2025-05-22 08:44:36'),
(3, 1, 'Motivasyonlu', '2025-05-22', 'bilmemmmm', '2025-05-22 09:14:49');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `motivasyon`
--

CREATE TABLE `motivasyon` (
  `id` int(11) NOT NULL,
  `tur` enum('mesaj','oneri') NOT NULL,
  `icerik` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `motivasyon`
--

INSERT INTO `motivasyon` (`id`, `tur`, `icerik`) VALUES
(1, 'mesaj', 'Bugün bir adım atmak, yarın için dev bir adımdır.'),
(2, 'mesaj', 'Sağlığın kıymetini kaybetmeden bil!'),
(3, 'mesaj', 'Küçük değişimler, büyük sonuçlar doğurur.'),
(4, 'mesaj', 'Kendine iyi bak, çünkü sen özelsin.'),
(5, 'mesaj', 'Zihinsel sağlık, beden sağlığıyla başlar.'),
(6, 'mesaj', 'Başlamak için harika bir gün!'),
(7, 'mesaj', 'Unutma, sağlıklı yaşam bir yolculuktur, yarış değil.'),
(8, 'oneri', 'Bugün 2 litre su içmeyi hedefle!'),
(9, 'oneri', '10 dakikalık kısa bir yürüyüş yap.'),
(10, 'oneri', 'Şekerli içecek yerine limonlu su dene.'),
(11, 'oneri', 'Bir meditasyon müziği açıp rahatla.'),
(12, 'oneri', 'Ekran süreni bugün 30 dk azaltmaya çalış.');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `saglik_bilgileri`
--

CREATE TABLE `saglik_bilgileri` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ad_soyad` varchar(100) DEFAULT NULL,
  `yas` int(11) DEFAULT NULL,
  `boy` int(11) DEFAULT NULL,
  `kilo` int(11) DEFAULT NULL,
  `kan_grubu` varchar(5) DEFAULT NULL,
  `alerjiler` text DEFAULT NULL,
  `hastaliklar` text DEFAULT NULL,
  `su` float DEFAULT NULL,
  `uyku` float DEFAULT NULL,
  `sigara` varchar(10) DEFAULT NULL,
  `ilaclar` text DEFAULT NULL,
  `stres` int(11) DEFAULT NULL,
  `adet_duzeni` varchar(50) DEFAULT NULL,
  `aile_hastalik` text DEFAULT NULL,
  `spor` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `saglik_bilgileri`
--

INSERT INTO `saglik_bilgileri` (`id`, `user_id`, `ad_soyad`, `yas`, `boy`, `kilo`, `kan_grubu`, `alerjiler`, `hastaliklar`, `su`, `uyku`, `sigara`, `ilaclar`, `stres`, `adet_duzeni`, `aile_hastalik`, `spor`, `created_at`) VALUES
(1, 5, 'esma ', 20, 150, 50, 'A+', 'saman', 'Diyabet', 2, 8, 'Hayır', 'gjgjjb', 5, 'düzenli', 'hıgb', 'Evet', '2025-05-30 10:50:59');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user`
--

CREATE TABLE `user` (
  `u_id` int(11) NOT NULL,
  `u_adi` varchar(50) NOT NULL,
  `u_soyadi` varchar(50) NOT NULL,
  `u_tc` varchar(11) DEFAULT NULL,
  `u_telefon` varchar(20) DEFAULT NULL,
  `u_mail` varchar(50) NOT NULL,
  `u_dogumtarih` date NOT NULL,
  `u_kilo` int(3) DEFAULT NULL,
  `u_boy` int(3) DEFAULT NULL,
  `u_antrenman_suresi` int(3) DEFAULT NULL,
  `u_cinsiyet` enum('erkek','kadın') DEFAULT NULL,
  `u_aktivite` enum('hareketsiz','hafif','orta','çok') DEFAULT NULL,
  `u_hedef` enum('kilo_vermek','kilo_korumak','kilo_almak') DEFAULT NULL,
  `u_sifre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `user`
--

INSERT INTO `user` (`u_id`, `u_adi`, `u_soyadi`, `u_tc`, `u_telefon`, `u_mail`, `u_dogumtarih`, `u_kilo`, `u_boy`, `u_antrenman_suresi`, `u_cinsiyet`, `u_aktivite`, `u_hedef`, `u_sifre`) VALUES
(1, 'fatma', 'makarna', '44842304665', '5454030466', 'fatma3434@gmail.com', '1980-01-25', 80, 160, 200, 'kadın', 'orta', 'kilo_vermek', '25f9e794323b453885f5181f1b624d0b'),
(2, 'asas', 'asas', '44444444444', '5456456666', 'asddassd@gmail.com', '2025-04-12', 66, 170, 120, 'erkek', 'hafif', 'kilo_vermek', '25f9e794323b453885f5181f1b624d0b'),
(3, 'sudenaz', 'balıkçı', '15113402276', '05444305717', 'sudenazbalikcii58@gmail.com', '2005-01-14', 42, 160, 10, 'kadın', 'hafif', 'kilo_almak', '31afd7d02bcfcb3827da7b59d9ce20e0'),
(4, 'sudenaz', 'balıkçı', '15113402276', '05444305717', 'sudenazbalikcii58@gmail.com', '2005-01-14', 42, 160, 30, 'kadın', 'hafif', 'kilo_almak', '31afd7d02bcfcb3827da7b59d9ce20e0'),
(5, 'Esma', 'Çekiç', '10418666421', '02167485657', 'esceko@gmail.com', '2025-05-10', 50, 150, 15, 'kadın', 'hafif', 'kilo_korumak', 'ebba20e9d1f72a37245b1cbfed20b9c5'),
(6, 'esra', 'na', '10418666424', '05352675659', 'escekor@gmail.com', '2025-06-20', 2, 2, 2, 'erkek', 'orta', 'kilo_vermek', 'e0580b7a065e6ab38a100991d6fa84fe');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uyku_kayitlari`
--

CREATE TABLE `uyku_kayitlari` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `tarih` date NOT NULL,
  `uyuma_saati` time NOT NULL,
  `uyanma_saati` time NOT NULL,
  `notlar` text DEFAULT NULL,
  `eklenme_zamani` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `uyku_kayitlari`
--

INSERT INTO `uyku_kayitlari` (`id`, `kullanici_id`, `tarih`, `uyuma_saati`, `uyanma_saati`, `notlar`, `eklenme_zamani`) VALUES
(1, 6, '2025-06-13', '18:34:00', '20:35:00', 'bddb', '2025-06-02 12:35:11');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Tablo için indeksler `diyetisyen_formlari`
--
ALTER TABLE `diyetisyen_formlari`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `egzersizler`
--
ALTER TABLE `egzersizler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ilaclar`
--
ALTER TABLE `ilaclar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kisisel_hedefler`
--
ALTER TABLE `kisisel_hedefler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_id` (`u_id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kullanici_adi` (`kullanici_adi`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `kullanici_beslenme`
--
ALTER TABLE `kullanici_beslenme`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanici_ruh_hali`
--
ALTER TABLE `kullanici_ruh_hali`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `motivasyon`
--
ALTER TABLE `motivasyon`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `saglik_bilgileri`
--
ALTER TABLE `saglik_bilgileri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_id`);

--
-- Tablo için indeksler `uyku_kayitlari`
--
ALTER TABLE `uyku_kayitlari`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admin`
--
ALTER TABLE `admin`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `diyetisyen_formlari`
--
ALTER TABLE `diyetisyen_formlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `egzersizler`
--
ALTER TABLE `egzersizler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `ilaclar`
--
ALTER TABLE `ilaclar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `kisisel_hedefler`
--
ALTER TABLE `kisisel_hedefler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici_beslenme`
--
ALTER TABLE `kullanici_beslenme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici_ruh_hali`
--
ALTER TABLE `kullanici_ruh_hali`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `motivasyon`
--
ALTER TABLE `motivasyon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `saglik_bilgileri`
--
ALTER TABLE `saglik_bilgileri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `user`
--
ALTER TABLE `user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `uyku_kayitlari`
--
ALTER TABLE `uyku_kayitlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `kisisel_hedefler`
--
ALTER TABLE `kisisel_hedefler`
  ADD CONSTRAINT `kisisel_hedefler_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `uyku_kayitlari`
--
ALTER TABLE `uyku_kayitlari`
  ADD CONSTRAINT `uyku_kayitlari_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `user` (`u_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
