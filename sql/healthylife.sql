-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 22 Haz 2025, 11:58:49
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
-- Tablo için tablo yapısı `calisanlar`
--

CREATE TABLE `calisanlar` (
  `c_id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `c_adi` varchar(100) NOT NULL,
  `c_soyadi` varchar(100) NOT NULL,
  `c_mail` varchar(150) NOT NULL,
  `c_sifre` varchar(255) NOT NULL,
  `tur` enum('diyetisyen','spor_egitmeni','doktor','hayat_kocu') NOT NULL,
  `uzmanlik` text DEFAULT NULL,
  `calisma_saatleri` text DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `mezuniyet` varchar(255) DEFAULT NULL,
  `deneyim` text DEFAULT NULL,
  `sertifikalar` text DEFAULT NULL,
  `aciklama` text DEFAULT NULL,
  `profil_resmi` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `calisanlar`
--

INSERT INTO `calisanlar` (`c_id`, `u_id`, `c_adi`, `c_soyadi`, `c_mail`, `c_sifre`, `tur`, `uzmanlik`, `calisma_saatleri`, `telefon`, `mezuniyet`, `deneyim`, `sertifikalar`, `aciklama`, `profil_resmi`) VALUES
(1, NULL, 'Zeynep', 'Kaya', 'zeynep.kaya@ornek.com', 'dyt1234', 'diyetisyen', 'Kilo Verme', 'Pzt-Cuma 09:00-17:00', '05001234567', 'Hacettepe Üniversitesi, Beslenme ve Diyetetik', '5 yıl', 'Uluslararası Beslenme Sertifikası', 'Uzman diyetisyen olarak sağlıklı yaşam danışmanlığı yapıyorum.', 'zeynep_kaya.jpg'),
(2, NULL, 'Ahmet', 'Demir', 'ahmet.demir@ornek.com', 'dyt5678', 'diyetisyen', 'Kilo Alma', 'Pzt-Cuma 10:00-18:00', '0502 222 3344', 'İstanbul Üniversitesi, Beslenme ve Diyetetik', '3 yıl özel klinik tecrübesi', 'Çocuk Beslenmesi Sertifikası', 'Kilo alma konusunda danışanlara özel programlar sunar.', 'ahmet_demir.jpg'),
(3, NULL, 'Elif', 'Yıldız', 'elif.yildiz@ornek.com', 'dyt9012', 'diyetisyen', 'Obezite', 'Salı-Cuma 08:30-16:30', '0503 333 4455', 'Ankara Üniversitesi, Beslenme ve Diyetetik', '4 yıl hastane deneyimi', 'Obezite ve Diyabet Yönetimi', 'Obezite ile mücadelede uzman diyetisyen.', 'elif_yildiz.jpg'),
(4, NULL, 'Mehmet', 'Çelik', 'mehmet.celik@ornek.com', 'dyt3456', 'diyetisyen', 'Diyabet', 'Çarşamba-Cumartesi 09:00-15:00', '0504 444 5566', 'Ege Üniversitesi, Beslenme ve Diyetetik', '6 yıl tecrübe', 'Endokrinoloji Diyetisyenliği', 'Diyabetli bireyler için sağlıklı beslenme planları sunar.', 'mehmet_celik.jpg'),
(5, NULL, 'Ayşe', 'Koç', 'ayse.koc@ornek.com', 'sport123', 'spor_egitmeni', 'Kas Gelişimi', 'Pzt-Cuma 11:00-19:00', '0505 555 6677', 'Marmara Üniversitesi, Spor Bilimleri', '7 yıl spor salonu eğitmenliği', 'Fitness Eğitmenliği', 'Kas gelişimi üzerine antrenman programları hazırlar.', 'ayse_koc.jpg'),
(6, NULL, 'Emre', 'Uçar', 'emre.ucar@ornek.com', 'sport456', 'spor_egitmeni', 'Kardiyo', 'Salı-Cuma 10:00-18:00', '0506 666 7788', 'Gazi Üniversitesi, Spor Bilimleri', '5 yıl profesyonel antrenörlük', 'Kardiyo ve Kondisyon Eğitimi', 'Kardiyovasküler sağlığı ön planda tutarak antrenmanlar düzenler.', 'emre_ucar.jpg'),
(7, NULL, 'Merve', 'Aslan', 'merve.aslan@ornek.com', 'sport789', 'spor_egitmeni', 'Esneklik', 'Pzt-Perş 12:00-20:00', '0507 777 8899', 'Celal Bayar Üniversitesi, Spor Bilimleri', '6 yıl spor akademisi eğitimi', 'Esneklik ve Denge Eğitimi', 'Esneklik üzerine kişisel programlar sunar.', 'merve_aslan.jpg'),
(8, NULL, 'Burak', 'Yılmaz', 'burak.yilmaz@ornek.com', 'sport999', 'spor_egitmeni', 'Fitness', 'Çarşamba-Cumartesi 13:00-21:00', '0508 888 9900', 'Akdeniz Üniversitesi, Spor Bilimleri', '4 yıl fitness eğitimi', 'Personal Trainer Sertifikası', 'Fitness hedefleri için bireysel antrenmanlar oluşturur.', 'burak_yilmaz.jpg'),
(9, NULL, 'Dr. Ayla', 'Ergin', 'ayla.ergin@ornek.com', 'doc1111', 'doktor', 'Beslenme', 'Pzt-Cuma 09:00-16:00', '0509 999 0011', 'İstanbul Tıp Fakültesi', '10 yıl aile hekimliği', 'Beslenme ve Sağlık Semineri', 'Genel sağlık danışmanlığı ve beslenme önerileri sunar.', 'ayla_ergin.jpg'),
(10, NULL, 'Dr. Serkan', 'Kurt', 'serkan.kurt@ornek.com', 'doc2222', 'doktor', 'Genel Sağlık', 'Pzt-Perş 08:30-15:30', '0510 000 1122', 'Ankara Üniversitesi Tıp Fakültesi', '12 yıl pratisyen doktorluk', 'Genel Tıp Sertifikası', 'Genel sağlık kontrolleri ve danışmanlık sağlar.', 'serkan_kurt.jpg'),
(11, NULL, 'Dr. Buse', 'Aydın', 'buse.aydin@ornek.com', 'doc3333', 'doktor', 'İç Hastalıklar', 'Salı-Cuma 09:00-17:00', '0511 111 2233', 'Ege Üniversitesi Tıp Fakültesi', '9 yıl iç hastalıkları uzmanlığı', 'İç Hastalıkları Uzmanlığı', 'İç hastalıkları tedavisi ve danışmanlık sunar.', 'buse_aydin.jpg'),
(12, NULL, 'Dr. Okan', 'Polat', 'okan.polat@ornek.com', 'doc4444', 'doktor', 'Check-up', 'Çarşamba-Cuma 10:00-16:00', '0512 222 3344', 'Dokuz Eylül Üniversitesi Tıp Fakültesi', '8 yıl uzman hekimlik', 'Check-up Uzmanlığı', 'Check-up hizmeti ve sağlık takibi sağlar.', 'okan_polat.jpg'),
(13, NULL, 'Nazlı', 'Şahin', 'nazli.sahin@ornek.com', 'coach11', 'hayat_kocu', 'Motivasyon', 'Pzt-Cuma 10:00-17:00', '0513 333 4455', 'İstanbul Üniversitesi Psikoloji', '6 yıl koçluk tecrübesi', 'Yaşam Koçluğu Sertifikası', 'Motivasyon artırmaya yönelik seanslar düzenler.', 'nazli_sahin.jpg'),
(14, NULL, 'Can', 'Güneş', 'can.gunes@ornek.com', 'coach22', 'hayat_kocu', 'Hedef Belirleme', 'Pzt-Cuma 09:30-16:30', '0514 444 5566', 'Hacettepe Üniversitesi Psikolojik Danışmanlık', '5 yıl yaşam koçluğu', 'Hedef Belirleme ve Takip Eğitimi', 'Hedef belirleme ve planlama alanında destek sağlar.', 'can_gunes.jpg'),
(15, NULL, 'Derya', 'Özkan', 'derya.ozkan@ornek.com', 'coach33', 'hayat_kocu', 'Ruhsal Gelişim', 'Salı-Perş 11:00-18:00', '0515 555 6677', 'Boğaziçi Üniversitesi Psikoloji', '7 yıl psikolojik destek', 'Ruhsal Gelişim Uzmanlığı', 'Ruhsal gelişim ve bireysel farkındalık konularında çalışır.', 'derya_ozkan.jpg'),
(16, NULL, 'Kerem', 'Bozkurt', 'kerem.bozkurt@ornek.com', 'coach44', 'hayat_kocu', 'Stres Yönetimi', 'Çarşamba-Cuma 12:00-19:00', '0516 666 7788', 'ODTÜ Psikoloji', '6 yıl bireysel danışmanlık', 'Stres Yönetimi Eğitimi', 'Stresle başa çıkma yöntemleri üzerine koçluk verir.', 'kerem_bozkurt.jpg'),
(22, NULL, 'Mehmet', 'Mertoğlu', 'selim@gmail.com', '1234', 'doktor', 'Beslenme', '4 saat', '0545 402 0455', 'Celal Bayar Üniversitesi, Spor Bilimleri', '5 Yıl', 'Esneklik ve Denge Eğitimi', 'deneyim', 'calisan_1750466857.png');

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
(1, NULL, 'FGSG', 3, 4, 4, 3, 'gfdggdfg', 'Standart', 'gdfd', 'gdgdgd', NULL, 'gddggd', '2025-06-02 11:40:42'),
(2, NULL, 'ahmet dursun', 22, 178, 78, 74, 'deneme', 'Standart', 'yok', 'yok', NULL, 'yok', '2025-06-02 21:38:41'),
(4, 13, 'ahmet dursun', 22, 178, 77, 70, '3 öğün ', 'Standart', 'yok', 'yok', NULL, 'yok', '2025-06-21 13:26:20'),
(5, 14, 'selim şengün', 22, 170, 65, 75, '3 öğün', 'Standart', 'yok', 'yok', NULL, 'süreci öğrenmek istiyorum', '2025-06-21 22:53:49');

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
(4, 1, 'Yürüyüş', 50, '17:42:00', '19:42:00', '2025-05-21 12:43:02'),
(5, 7, 'Yürüyüş', 120, '11:11:00', '13:11:00', '2025-06-02 21:28:16'),
(6, 7, 'Koşu', 120, '11:00:00', '13:00:00', '2025-06-02 21:35:21'),
(7, 7, 'Ağırlık Antrenmanı', 20, '14:20:00', '14:40:00', '2025-06-02 23:16:27'),
(8, 7, 'Bisiklet', 10, '12:00:00', '12:10:00', '2025-06-02 23:17:23'),
(9, 7, 'Squat', 5, '12:40:00', '12:45:00', '2025-06-02 23:18:01'),
(10, 13, 'Ağırlık Antrenmanı', 60, '12:00:00', '13:00:00', '2025-06-03 11:46:26'),
(11, 13, 'Bisiklet', 30, '12:30:00', '13:00:00', '2025-06-03 11:49:44'),
(12, 14, 'Koşu', 60, '01:03:00', '02:03:00', '2025-06-21 22:03:25');

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
(3, 6, 'esma', '19:45:00'),
(4, 7, 'aferin', '11:00:00'),
(5, 7, 'nurofen', '12:00:00'),
(6, 13, 'aferin', '12:00:00'),
(7, 14, 'parol', '12:00:00');

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
(1, 6, -0.2, 0.2, -3, 'nvn', 'nvv', 'nbn', 'vnvn', 'nvnv', 'bnvb', 'Mutlu', '2025-06-02 12:22:13'),
(3, 13, 3.0, 7.0, 3000, 'uyanmak', 'uyumak', 'not', 'kod yazmak', 'yok', 'kendime', 'Mutlu', '2025-06-03 12:27:25'),
(4, 14, 3.0, 8.0, 2000, 'uyanmak', 'uyumak', 'söz', 'kod yazmak', 'yok', 'yaşama', 'Mutlu', '2025-06-21 22:50:44');

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
(2, 1, 'İçecek', 'Taze Sıkılmış Portakal Suyu', 200, 20, 2, 0.4, 90, '2025-05-22', '2025-05-22 09:13:34'),
(3, 7, 'Sabah', 'Yulaf Ezmesi', 100, 60, 10, 7, 350, '2025-06-03', '2025-06-02 21:36:02'),
(4, 7, 'Atıştırmalık', 'Ceviz', 30, 4.2, 4.5, 19.5, 195, '2025-06-03', '2025-06-02 21:36:02'),
(5, 7, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-03', '2025-06-02 21:36:02'),
(6, 7, 'Atıştırmalık', 'Meyve Barı', 30, 21, 1.5, 3, 105, '2025-06-03', '2025-06-02 21:59:48'),
(7, 7, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-03', '2025-06-02 21:59:48'),
(8, 7, 'İçecek', 'Süt (200ml)', 200, 20, 14, 10, 240, '2025-06-03', '2025-06-02 21:59:48'),
(9, 7, 'Atıştırmalık', 'Badem', 30, 6.6, 6.3, 14.7, 172.5, '2025-06-03', '2025-06-02 22:00:10'),
(10, 7, 'İçecek', 'Yeşil Çay', 200, 0, 0, 0, 4, '2025-06-03', '2025-06-02 22:00:10'),
(11, 7, 'İçecek', 'Süt (200ml)', 200, 20, 14, 10, 240, '2025-06-03', '2025-06-02 22:00:10'),
(12, 13, 'Atıştırmalık', 'Ceviz', 30, 4.2, 4.5, 19.5, 195, '2025-06-03', '2025-06-03 12:07:28'),
(13, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-03', '2025-06-03 12:07:28'),
(14, 13, 'İçecek', 'Taze Sıkılmış Portakal Suyu', 200, 20, 2, 0.4, 90, '2025-06-03', '2025-06-03 12:07:28'),
(15, 13, 'İçecek', 'Yeşil Çay', 200, 0, 0, 0, 4, '2025-06-03', '2025-06-03 12:07:28'),
(16, 13, 'Sabah', 'Yulaf Ezmesi', 100, 60, 10, 7, 350, '2025-06-03', '2025-06-03 12:10:00'),
(17, 13, 'Atıştırmalık', 'Badem', 30, 6.6, 6.3, 14.7, 172.5, '2025-06-03', '2025-06-03 12:10:00'),
(18, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-03', '2025-06-03 12:10:00'),
(19, 13, 'Atıştırmalık', 'Badem', 30, 6.6, 6.3, 14.7, 172.5, '2025-06-03', '2025-06-03 12:10:03'),
(20, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-03', '2025-06-03 12:10:03'),
(21, 13, 'Sabah', 'Yulaf Ezmesi', 100, 60, 10, 7, 350, '2025-06-03', '2025-06-03 12:10:04'),
(22, 13, 'Atıştırmalık', 'Badem', 30, 6.6, 6.3, 14.7, 172.5, '2025-06-03', '2025-06-03 12:10:04'),
(23, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-03', '2025-06-03 12:10:04'),
(24, 13, 'Atıştırmalık', 'Badem', 30, 6.6, 6.3, 14.7, 172.5, '2025-06-03', '2025-06-03 12:10:06'),
(25, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-03', '2025-06-03 12:10:06'),
(26, 13, 'Sabah', 'Yulaf Ezmesi', 100, 60, 10, 7, 350, '2025-06-03', '2025-06-03 12:10:13'),
(27, 13, 'Sabah', 'Peynir', 100, 1.5, 25, 33, 350, '2025-06-03', '2025-06-03 12:10:33'),
(28, 13, 'Atıştırmalık', 'Meyve Barı', 30, 21, 1.5, 3, 105, '2025-06-03', '2025-06-03 12:10:33'),
(29, 13, 'İçecek', 'Yeşil Çay', 200, 0, 0, 0, 4, '2025-06-03', '2025-06-03 12:10:33'),
(30, 13, 'Sabah', 'Peynir', 100, 1.5, 25, 33, 350, '2025-06-03', '2025-06-03 12:12:28'),
(31, 13, 'Atıştırmalık', 'Meyve Barı', 30, 21, 1.5, 3, 105, '2025-06-03', '2025-06-03 12:12:28'),
(32, 13, 'İçecek', 'Yeşil Çay', 200, 0, 0, 0, 4, '2025-06-03', '2025-06-03 12:12:28'),
(33, 13, 'Öğle', 'Izgara Tavuk', 100, 0, 31, 3.6, 165, '2025-06-03', '2025-06-03 12:13:15'),
(34, 13, 'Atıştırmalık', 'Ceviz', 30, 4.2, 4.5, 19.5, 195, '2025-06-03', '2025-06-03 12:13:15'),
(35, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-03', '2025-06-03 12:13:15'),
(36, 13, 'İçecek', 'Yeşil Çay', 200, 0, 0, 0, 4, '2025-06-03', '2025-06-03 12:13:15'),
(37, 13, 'Atıştırmalık', 'Ceviz', 30, 4.2, 4.5, 19.5, 195, '2025-06-03', '2025-06-03 12:13:48'),
(38, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-03', '2025-06-03 12:13:48'),
(39, 13, 'İçecek', 'Yeşil Çay', 200, 0, 0, 0, 4, '2025-06-03', '2025-06-03 12:13:48'),
(40, 13, 'Akşam', 'Izgara Sebzeler', 100, 8, 2, 5, 80, '2025-06-03', '2025-06-03 12:13:55'),
(41, 13, 'İçecek', 'Taze Sıkılmış Portakal Suyu', 200, 20, 2, 0.4, 90, '2025-06-03', '2025-06-03 12:13:55'),
(42, 13, 'Akşam', 'Izgara Sebzeler', 100, 8, 2, 5, 80, '2025-06-03', '2025-06-03 12:15:16'),
(43, 13, 'İçecek', 'Taze Sıkılmış Portakal Suyu', 200, 20, 2, 0.4, 90, '2025-06-03', '2025-06-03 12:15:16'),
(44, 13, 'Öğle', 'Izgara Tavuk', 100, 0, 31, 3.6, 165, '2025-06-03', '2025-06-03 12:16:05'),
(45, 13, 'Atıştırmalık', 'Badem', 30, 6.6, 6.3, 14.7, 172.5, '2025-06-03', '2025-06-03 12:16:05'),
(46, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-03', '2025-06-03 12:16:05'),
(47, 13, 'Akşam', 'Balık', 100, 0, 22, 12, 210, '2025-06-09', '2025-06-08 21:54:14'),
(48, 13, 'Atıştırmalık', 'Ceviz', 30, 4.2, 4.5, 19.5, 195, '2025-06-09', '2025-06-08 21:54:14'),
(49, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-09', '2025-06-08 21:54:14'),
(50, 13, 'Öğle', 'Izgara Tavuk', 100, 0, 31, 3.6, 165, '2025-06-09', '2025-06-08 21:56:50'),
(51, 13, 'Öğle', 'Yoğurt', 100, 4, 3.5, 3, 60, '2025-06-09', '2025-06-08 21:56:50'),
(52, 13, 'Atıştırmalık', 'Ceviz', 30, 4.2, 4.5, 19.5, 195, '2025-06-09', '2025-06-08 21:56:50'),
(53, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-09', '2025-06-08 21:56:50'),
(54, 13, 'İçecek', 'Yeşil Çay', 200, 0, 0, 0, 4, '2025-06-09', '2025-06-08 21:56:50'),
(55, 13, 'Akşam', 'Haşlanmış Patates', 100, 20, 2, 0, 90, '2025-06-09', '2025-06-08 21:57:15'),
(56, 13, 'Atıştırmalık', 'Meyve Barı', 30, 21, 1.5, 3, 105, '2025-06-09', '2025-06-08 21:57:15'),
(57, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-09', '2025-06-08 21:57:15'),
(58, 13, 'Akşam', 'Mercimek Çorbası', 100, 15, 9, 1, 140, '2025-06-09', '2025-06-08 21:58:51'),
(59, 13, 'Atıştırmalık', 'Badem', 30, 6.6, 6.3, 14.7, 172.5, '2025-06-09', '2025-06-08 21:58:51'),
(60, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-09', '2025-06-08 21:58:51'),
(61, 13, 'Sabah', 'Yulaf Ezmesi', 100, 60, 10, 7, 350, '2025-06-09', '2025-06-08 22:00:00'),
(62, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-09', '2025-06-08 23:58:35'),
(63, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-09', '2025-06-08 23:58:38'),
(64, 13, 'İçecek', 'Su', 200, 0, 0, 0, 0, '2025-06-09', '2025-06-08 23:58:42'),
(65, 13, 'sabah', 'Orman Meyveli Smoothie Kasesi', 100, 36, 9, 10, 310, '2025-06-10', '2025-06-09 23:18:19'),
(66, 13, 'ogle', 'Fit Karnabahar Pilavı', 100, 18, 16, 12, 300, '2025-06-10', '2025-06-09 23:20:43'),
(67, 13, 'aksam', 'Kırmızı Lahana ve Nohut Salatası', 100, 25, 12, 14, 310, '2025-06-10', '2025-06-09 23:29:00'),
(68, 13, 'aksam', 'Kırmızı Lahana ve Nohut Salatası', 100, 25, 12, 14, 310, '2025-06-10', '2025-06-09 23:38:56'),
(69, 13, 'sabah', 'Yeşil Detoks Smoothie', 100, 20, 5, 8, 210, '2025-06-10', '2025-06-09 23:42:06'),
(70, 13, 'sabah', 'Yeşil Detoks Smoothie', 100, 20, 5, 8, 210, '2025-06-10', '2025-06-09 23:42:32'),
(71, 13, 'sabah', 'Yeşil Detoks Smoothie', 100, 20, 5, 8, 210, '2025-06-10', '2025-06-09 23:46:48'),
(72, 13, '', 'Portakal Suyu', 100, 10, 1, 0.2, 45, '2025-06-10', '2025-06-09 23:53:15'),
(73, 13, '', 'Süt', 100, 10, 7, 5, 120, '2025-06-10', '2025-06-09 23:54:35'),
(74, 13, '', 'Süt', 100, 10, 7, 5, 120, '2025-06-10', '2025-06-10 10:55:10'),
(75, 13, 'sabah', 'Meyveli Chia Puding', 100, 28, 9, 10, 250, '2025-06-10', '2025-06-10 10:55:56'),
(76, 13, 'sabah', 'Yeşil Çay', 100, 0, 0, 0, 2, '2025-06-10', '2025-06-10 10:57:14'),
(77, 13, 'aksam', 'Yeşil Çay', 100, 0, 0, 0, 2, '2025-06-10', '2025-06-10 10:57:53'),
(78, 13, 'sabah', 'Muz', 100, 23, 1, 0.3, 89, '2025-06-10', '2025-06-10 11:21:47'),
(79, 13, 'ogle', 'börek', 100, 10, 5, 3, 100, '2025-06-10', '2025-06-10 11:32:33'),
(80, 13, 'ogle', 'Yeşil Çay', 100, 0, 0, 0, 2, '2025-06-10', '2025-06-10 11:37:04'),
(81, 13, 'sabah', 'Meyveli Chia Puding', 100, 28, 9, 10, 250, '2025-06-10', '2025-06-10 21:36:22'),
(82, 13, 'sabah', 'Muz', 100, 23, 1, 0.3, 89, '2025-06-10', '2025-06-10 21:36:22'),
(83, 13, 'sabah', 'Yeşil Çay', 100, 0, 0, 0, 2, '2025-06-10', '2025-06-10 21:36:22'),
(84, 13, '', 'Portakal Suyu', 100, 10, 1, 0.2, 45, '2025-06-10', '2025-06-10 21:37:42'),
(85, 13, 'sabah', 'Meyveli Chia Puding', 100, 28, 9, 10, 250, '2025-06-11', '2025-06-10 22:02:03'),
(86, 13, 'sabah', 'Muz', 100, 23, 1, 0.3, 89, '2025-06-11', '2025-06-10 22:02:03'),
(87, 13, 'sabah', 'Süt', 100, 10, 7, 5, 120, '2025-06-11', '2025-06-10 22:02:03'),
(88, 14, 'sabah', 'Orman Meyveli Smoothie Kasesi', 100, 36, 9, 10, 310, '2025-06-22', '2025-06-21 22:28:57'),
(89, 14, 'sabah', 'Muz', 100, 23, 1, 0.3, 89, '2025-06-22', '2025-06-21 22:28:57'),
(90, 14, 'sabah', 'Süt', 100, 10, 7, 5, 120, '2025-06-22', '2025-06-21 22:28:57');

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
(3, 1, 'Motivasyonlu', '2025-05-22', 'bilmemmmm', '2025-05-22 09:14:49'),
(4, 7, 'Mutlu', '2025-06-02', 'iyi', '2025-06-02 21:35:32'),
(5, 13, 'Motivasyonlu', '2025-06-03', 'iyi gibi', '2025-06-03 11:50:18'),
(6, 14, 'Motivasyonlu', '2025-06-22', 'Motivasyonluyum', '2025-06-21 22:09:16');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mesajlar`
--

CREATE TABLE `mesajlar` (
  `m_id` int(11) NOT NULL,
  `gonderen_id` int(11) NOT NULL,
  `alici_id` int(11) NOT NULL,
  `mesaj_metni` text NOT NULL,
  `gonderilme_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `randevu_id` int(11) DEFAULT NULL,
  `kimden` enum('kullanici','calisan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `mesajlar`
--

INSERT INTO `mesajlar` (`m_id`, `gonderen_id`, `alici_id`, `mesaj_metni`, `gonderilme_tarihi`, `randevu_id`, `kimden`) VALUES
(1, 13, 10, 'genel sağlığım hakkında bilgi almak istiyorum', '2025-06-21 11:57:46', 3, 'kullanici'),
(2, 10, 13, 'Merhaba Hemen İlgileniyorum', '2025-06-21 12:19:24', 3, 'calisan'),
(3, 13, 10, 'Tamamdır Teşekkürler', '2025-06-21 12:19:54', 3, 'kullanici'),
(4, 13, 2, 'Merhaba', '2025-06-21 15:03:22', 2, 'kullanici'),
(5, 2, 13, 'Merhaba', '2025-06-21 15:04:01', 2, 'calisan'),
(6, 14, 1, 'Merhaba', '2025-06-21 23:49:24', 4, 'kullanici'),
(7, 1, 14, 'Merhaba', '2025-06-22 00:43:56', 4, 'calisan'),
(8, 13, 1, 'merhaba', '2025-06-22 08:28:58', 5, 'kullanici');

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
-- Tablo için tablo yapısı `randevular`
--

CREATE TABLE `randevular` (
  `r_id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `c_id` int(11) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  `saat` time DEFAULT NULL,
  `randevu_notu` text DEFAULT NULL,
  `olusturma_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `randevular`
--

INSERT INTO `randevular` (`r_id`, `u_id`, `c_id`, `tarih`, `saat`, `randevu_notu`, `olusturma_tarihi`) VALUES
(2, 13, 2, '2025-06-22', '17:32:00', 'deneme', '2025-06-21 11:29:38'),
(3, 13, 10, '2025-06-27', '15:41:00', 'denemeeee', '2025-06-21 11:40:31'),
(4, 14, 1, '2025-06-22', '10:00:00', 'Randevu', '2025-06-21 23:49:17'),
(5, 13, 1, '2025-06-22', '14:30:00', 'Deneme', '2025-06-22 08:28:50');

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
(1, 5, 'esma ', 20, 150, 50, 'A+', 'saman', 'Diyabet', 2, 8, 'Hayır', 'gjgjjb', 5, 'düzenli', 'hıgb', 'Evet', '2025-05-30 10:50:59'),
(2, 7, 'ahmet', 22, 178, 78, 'AB+', '', '', 2, 6, 'Hayır', 'yok', 2, '', 'yok', 'Evet', '2025-06-02 21:36:57'),
(3, 13, 'ahmet', 22, 178, 78, 'AB+', 'yok', '', 3, 6, 'Hayır', 'yok', 2, '', 'yok', 'Evet', '2025-06-03 12:21:54'),
(4, 14, 'selim şengün', 22, 175, 60, 'A-', 'yok', '', 3, 6, 'Hayır', 'yok', 3, 'yok', 'yok', 'Evet', '2025-06-21 22:41:31'),
(5, 14, 'selim şengün', 22, 170, 65, 'A+', 'yok', '', 3, 6, 'Hayır', 'yok', 5, 'yok', 'yok', 'Evet', '2025-06-21 22:46:38'),
(6, 14, 'selim şengün', 22, 170, 65, 'A+', 'yok', '', 3, 6, 'Hayır', 'yok', 5, 'yok', 'yok', 'Evet', '2025-06-21 22:48:34');

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
  `u_sifre` varchar(50) NOT NULL,
  `gunluk_kalori` int(11) DEFAULT 0,
  `profil_resmi` varchar(255) DEFAULT NULL,
  `gunluk_protein` float DEFAULT 0,
  `gunluk_yag` float DEFAULT 0,
  `gunluk_karbonhidrat` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `user`
--

INSERT INTO `user` (`u_id`, `u_adi`, `u_soyadi`, `u_tc`, `u_telefon`, `u_mail`, `u_dogumtarih`, `u_kilo`, `u_boy`, `u_antrenman_suresi`, `u_cinsiyet`, `u_aktivite`, `u_hedef`, `u_sifre`, `gunluk_kalori`, `profil_resmi`, `gunluk_protein`, `gunluk_yag`, `gunluk_karbonhidrat`) VALUES
(1, 'fatma', 'makarna', '44842304665', '5454030466', 'fatma3434@gmail.com', '1980-01-25', 80, 160, 200, 'kadın', 'orta', 'kilo_vermek', '25f9e794323b453885f5181f1b624d0b', 0, NULL, 0, 0, 0),
(2, 'asas', 'asas', '44444444444', '5456456666', 'asddassd@gmail.com', '2025-04-12', 66, 170, 120, 'erkek', 'hafif', 'kilo_vermek', '25f9e794323b453885f5181f1b624d0b', 0, NULL, 0, 0, 0),
(3, 'sudenaz', 'balıkçı', '15113402276', '05444305717', 'sudenazbalikcii58@gmail.com', '2005-01-14', 42, 160, 10, 'kadın', 'hafif', 'kilo_almak', '31afd7d02bcfcb3827da7b59d9ce20e0', 0, NULL, 0, 0, 0),
(4, 'sudenaz', 'balıkçı', '15113402276', '05444305717', 'sudenazbalikcii58@gmail.com', '2005-01-14', 42, 160, 30, 'kadın', 'hafif', 'kilo_almak', '31afd7d02bcfcb3827da7b59d9ce20e0', 0, NULL, 0, 0, 0),
(5, 'Esma', 'Çekiç', '10418666421', '02167485657', 'esceko@gmail.com', '2025-05-10', 50, 150, 15, 'kadın', 'hafif', 'kilo_korumak', 'ebba20e9d1f72a37245b1cbfed20b9c5', 0, NULL, 0, 0, 0),
(6, 'esra', 'na', '10418666424', '05352675659', 'escekor@gmail.com', '2025-06-20', 2, 2, 2, 'erkek', 'orta', 'kilo_vermek', 'e0580b7a065e6ab38a100991d6fa84fe', 0, NULL, 0, 0, 0),
(8, 'ahmetsassdsda', 'dursun', '76373763737', '5454020433333', 'maaaaahmet@gmail.com', '2025-06-05', 180, 77, 123, 'erkek', 'hareketsiz', 'kilo_vermek', '6ebe76c9fb411be97b3b0d48b791a7c9', 0, NULL, 0, 0, 0),
(9, 'ahmetsassdsda', 'dursun', '76373763737', '5454020433333', 'maaaaahmet@gmail.com', '2025-06-05', 5555, 555, 5555, 'erkek', 'hareketsiz', 'kilo_vermek', '6ebe76c9fb411be97b3b0d48b791a7c9', 0, NULL, 0, 0, 0),
(10, 'ahmetsassdsda', 'dursun', '76373763737', '545402043333322', 'maaaaasahmet@gmail.com', '2025-05-30', 177, 222, 2222, 'erkek', 'hareketsiz', 'kilo_vermek', '745309c91c7a429dc263e47aae973f75', 0, NULL, 0, 0, 0),
(11, 'asas', 'asas', '44444444444', '5456456666', 'asddassd@gmail.com', '2025-05-29', 133, 333, 3333, 'erkek', 'hareketsiz', 'kilo_vermek', '21f248ab0bffcdca77d888456f6209ef', 0, NULL, 0, 0, 0),
(12, 'ahmetsassdsda', 'dursun', '76373763737', '5454020433', 'maaaaahmet@gmail.com', '2025-06-12', 2222, 2222, 2222, 'erkek', 'hafif', 'kilo_vermek', 'b58a0586812ab0105e7958c1a110472b', 0, NULL, 0, 0, 0),
(13, 'Ahmet', 'Dursun', '7777666666', '5454020807', 'ahmet@gmail.com', '2003-01-18', 78, 178, 120, 'erkek', 'orta', 'kilo_vermek', '25f9e794323b453885f5181f1b624d0b', 2271, 'user_13_1748947785.png', 170, 76, 227),
(14, 'Selim', 'Şengün', '55678305778', '5356080018', 'selim@gmail.com', '2004-02-15', 60, 175, 100, 'erkek', 'hafif', 'kilo_almak', '25f9e794323b453885f5181f1b624d0b', 2491, NULL, 187, 83, 249);

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
(1, 6, '2025-06-13', '18:34:00', '20:35:00', 'bddb', '2025-06-02 12:35:11'),
(4, 13, '2025-06-03', '12:00:00', '08:00:00', 'güzel', '2025-06-03 16:33:22'),
(5, 14, '2025-06-22', '05:00:00', '12:58:00', 'iyi', '2025-06-21 22:58:24');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Tablo için indeksler `calisanlar`
--
ALTER TABLE `calisanlar`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `c_mail` (`c_mail`),
  ADD KEY `u_id` (`u_id`);

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
-- Tablo için indeksler `mesajlar`
--
ALTER TABLE `mesajlar`
  ADD PRIMARY KEY (`m_id`);

--
-- Tablo için indeksler `motivasyon`
--
ALTER TABLE `motivasyon`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `randevular`
--
ALTER TABLE `randevular`
  ADD PRIMARY KEY (`r_id`);

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
-- Tablo için AUTO_INCREMENT değeri `calisanlar`
--
ALTER TABLE `calisanlar`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Tablo için AUTO_INCREMENT değeri `diyetisyen_formlari`
--
ALTER TABLE `diyetisyen_formlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `egzersizler`
--
ALTER TABLE `egzersizler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `ilaclar`
--
ALTER TABLE `ilaclar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `kisisel_hedefler`
--
ALTER TABLE `kisisel_hedefler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici_beslenme`
--
ALTER TABLE `kullanici_beslenme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici_ruh_hali`
--
ALTER TABLE `kullanici_ruh_hali`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `mesajlar`
--
ALTER TABLE `mesajlar`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `motivasyon`
--
ALTER TABLE `motivasyon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `randevular`
--
ALTER TABLE `randevular`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `saglik_bilgileri`
--
ALTER TABLE `saglik_bilgileri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `user`
--
ALTER TABLE `user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `uyku_kayitlari`
--
ALTER TABLE `uyku_kayitlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `calisanlar`
--
ALTER TABLE `calisanlar`
  ADD CONSTRAINT `calisanlar_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`) ON DELETE CASCADE;

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
