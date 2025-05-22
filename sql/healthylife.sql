-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 22 May 2025, 11:47:41
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
(2, 1, 'parol', '12:30:00');

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
(4, 'sudenaz', 'balıkçı', '15113402276', '05444305717', 'sudenazbalikcii58@gmail.com', '2005-01-14', 42, 160, 30, 'kadın', 'hafif', 'kilo_almak', '31afd7d02bcfcb3827da7b59d9ce20e0');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_id`);

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
-- Tablo için indeksler `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admin`
--
ALTER TABLE `admin`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `egzersizler`
--
ALTER TABLE `egzersizler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `ilaclar`
--
ALTER TABLE `ilaclar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- Tablo için AUTO_INCREMENT değeri `user`
--
ALTER TABLE `user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
