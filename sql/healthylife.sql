-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 30 Nis 2025, 01:58:59
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

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
(2, 'asas', 'asas', '44444444444', '5456456666', 'asddassd@gmail.com', '2025-04-12', 66, 170, 120, 'erkek', 'hafif', 'kilo_vermek', '25f9e794323b453885f5181f1b624d0b');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_id`);

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
-- Tablo için AUTO_INCREMENT değeri `user`
--
ALTER TABLE `user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
