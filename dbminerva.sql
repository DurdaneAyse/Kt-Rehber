-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 19 May 2020, 03:01:20
-- Sunucu sürümü: 10.4.11-MariaDB
-- PHP Sürümü: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `dbminerva`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tableanonymous`
--

CREATE TABLE `tableanonymous` (
  `id` int(10) UNSIGNED NOT NULL,
  `Aemail` varchar(50) NOT NULL,
  `Apassword` varchar(32) NOT NULL,
  `time` varchar(19) NOT NULL,
  `activationcode` varchar(32) NOT NULL,
  `activation` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tableanonymous`
--

INSERT INTO `tableanonymous` (`id`, `Aemail`, `Apassword`, `time`, `activationcode`, `activation`) VALUES
(1, 'riser36269@gotkmail.com', '1234', '04.04.2020 19.32.29', '2e575757e2f8fde0d39de6599b024c85', 1),
(6, 'merhablardo@2go-mail.com', '1a18886587c2efa7b720554ff646d482', '14.04.2020 10.23.00', '89c4be7941a6024a1ee66a079384a50d', 1),
(9, 'coloto3196@toracw.com', '7815696ecbf1c96e6894b779456d330e', '14.05.2020 04.28.06', '93f5d8200c7b846a6f774839402eead4', 1),
(10, 'molowip158@box4mls.com', '202cb962ac59075b964b07152d234b70', '18.05.2020 18.07.18', 'c4ed82637e5ff457a26bbf5595cc7779', 0),
(18, 'dqwety@beiop.com', 'e10adc3949ba59abbe56e057f20f883e', '18.05.2020 18.55.51', 'ebbb974f7dcd671de6fa9c03950f0c8f', 0),
(21, 'asdas@box4mls.com', '202cb962ac59075b964b07152d234b70', '18.05.2020 19.43.04', 'c7f190ac3ad2fe25888bb73cdb1d9964', 0),
(22, 'asd@asd.com', '7815696ecbf1c96e6894b779456d330e', '19.05.2020 03.52.28', 'fe8228e0ffbb437647485ddad4fa19fc', 1),
(23, 'qwert@qwe.com', '7815696ecbf1c96e6894b779456d330e', '19.05.2020 03.59.28', 'bab8e1e48f51fed0d09d857fc7c7373e', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tableanswer`
--

CREATE TABLE `tableanswer` (
  `id` int(10) UNSIGNED NOT NULL,
  `answererid` int(11) NOT NULL,
  `questionid` int(11) NOT NULL,
  `answer` varchar(250) NOT NULL,
  `time` varchar(19) NOT NULL,
  `userType` int(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tableanswer`
--

INSERT INTO `tableanswer` (`id`, `answererid`, `questionid`, `answer`, `time`, `userType`) VALUES
(52, 10, 1, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(53, 10, 2, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(54, 10, 3, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(55, 10, 4, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(56, 10, 5, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(57, 10, 6, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(58, 10, 7, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(59, 10, 8, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(60, 10, 9, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(61, 10, 10, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(62, 10, 11, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(63, 10, 12, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(64, 10, 13, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(65, 10, 14, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(66, 10, 15, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(67, 10, 16, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(68, 10, 17, 'denemeAnswer', '14.05.2020 01.19.09', 1),
(70, 10, 5, 'bir cevap yazalım', '14.05.2020 04.22.16', 1),
(71, 10, 5, 'bir cevap yazalım', '14.05.2020 04.22.48', 1),
(72, 10, 5, 'bir cevap yazalım', '14.05.2020 04.22.49', 1),
(73, 10, 5, 'bir cevap yazalım', '14.05.2020 04.22.49', 1),
(74, 10, 17, 'ulan yanlış hesapla deneme yaptık\r\n', '14.05.2020 04.24.38', 1),
(75, 10, 17, 'ulan yanlış hesapla deneme yaptık\r\n', '14.05.2020 04.24.41', 1),
(76, 10, 17, 'ulan yanlış hesapla deneme yaptık\r\n', '14.05.2020 04.25.55', 1),
(77, 10, 4, 'bir deneme daha', '14.05.2020 04.26.07', 1),
(78, 10, 24, 'deneme cevap atalım', '16.05.2020 06.22.05', 1),
(80, 10, 26, 'deneme cevap 2', '16.05.2020 06.36.41', 1),
(81, 10, 27, 'deneme cevap 3', '16.05.2020 06.37.12', 1),
(82, 10, 28, 'deneme cvp 4', '16.05.2020 06.42.02', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tablefaculty`
--

CREATE TABLE `tablefaculty` (
  `id` int(11) UNSIGNED NOT NULL,
  `fName` varchar(200) NOT NULL,
  `adress` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tablefaculty`
--

INSERT INTO `tablefaculty` (`id`, `fName`, `adress`) VALUES
(1, 'DİŞ HEKİMLİĞİ FAKÜLTESİ', 'asd'),
(2, 'ECZACILIK FAKÜLTESİ', 'asd'),
(3, 'EDEBİYAT FAKÜLTESİ', 'asd'),
(4, 'FATİH EĞİTİM FAKÜLTESİ', 'asd'),
(5, 'FEN FAKÜLTESİ', 'asd'),
(6, 'GÜZEL SANATLAR FAKÜLTESİ', 'asd'),
(7, 'HUKUK FAKÜLTESİ', 'asd'),
(8, 'İKTİSADİ VE İDARİ BİLİMLER FAKÜLTESİ', 'asd'),
(9, 'İLAHİYAT FAKÜLTESİ', 'asd'),
(10, 'İLETİŞİM FAKÜLTESİ', 'asd'),
(11, 'MİMARLIK FAKÜLTESİ', 'asd'),
(12, 'MÜHENDİSLİK FAKÜLTESİ', 'asd'),
(13, 'OF TEKNOLOJİ FAKÜLTESİ', 'asd'),
(14, 'ORMAN FAKÜLTESİ', 'asd'),
(15, 'SAĞLIK BİLİMLERİ FAKÜLTESİ', 'asd'),
(16, 'SÜRMENE DENİZ BİLİMLERİ FAKÜLTESİ', 'asd'),
(17, 'TIP FAKÜLTESİ', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tablequestion`
--

CREATE TABLE `tablequestion` (
  `id` int(10) UNSIGNED NOT NULL,
  `questionerid` int(10) UNSIGNED NOT NULL,
  `question` varchar(250) NOT NULL,
  `time` varchar(19) NOT NULL,
  `faculty` int(10) UNSIGNED NOT NULL,
  `userType` int(1) UNSIGNED NOT NULL,
  `qmsg` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tablequestion`
--

INSERT INTO `tablequestion` (`id`, `questionerid`, `question`, `time`, `faculty`, `userType`, `qmsg`) VALUES
(1, 1, 'deneme', '14.05.2020 01.08.25', 1, 0, 'deneme1'),
(2, 1, 'deneme', '14.05.2020 01.08.25', 2, 0, 'deneme1'),
(3, 1, 'deneme', '14.05.2020 01.08.25', 3, 0, 'deneme1'),
(4, 1, 'deneme', '14.05.2020 01.08.25', 4, 0, 'deneme1'),
(5, 1, 'deneme', '14.05.2020 01.08.25', 5, 0, 'deneme1'),
(6, 1, 'deneme', '14.05.2020 01.08.25', 6, 0, 'deneme1'),
(7, 1, 'deneme', '14.05.2020 01.08.25', 7, 0, 'deneme1'),
(8, 1, 'deneme', '14.05.2020 01.08.25', 8, 0, 'deneme1'),
(9, 1, 'deneme', '14.05.2020 01.08.25', 9, 0, 'deneme1'),
(10, 1, 'deneme', '14.05.2020 01.08.25', 10, 0, 'deneme1'),
(11, 1, 'deneme', '14.05.2020 01.08.25', 11, 0, 'deneme1'),
(12, 1, 'deneme', '14.05.2020 01.08.25', 12, 0, 'deneme1'),
(13, 1, 'deneme', '14.05.2020 01.08.25', 13, 0, 'deneme1'),
(14, 1, 'deneme', '14.05.2020 01.08.25', 14, 0, 'deneme1'),
(15, 1, 'deneme', '14.05.2020 01.08.25', 15, 0, 'deneme1'),
(16, 1, 'deneme', '14.05.2020 01.08.25', 16, 0, 'deneme1'),
(17, 1, 'deneme', '14.05.2020 01.08.25', 17, 0, 'deneme1'),
(24, 10, 'deneme soru ekelem', '16.05.2020 06.10.35', 1, 1, 'deneme soru ekleme alt yazı'),
(26, 10, 'denem soru 2', '16.05.2020 06.30.34', 1, 1, 'deneme soru 2'),
(27, 10, 'denem soru 3', '16.05.2020 06.37.01', 2, 1, 'deneme soru 3'),
(28, 10, 'deneme 4', '16.05.2020 06.41.49', 13, 1, 'deneme 4 msj'),
(29, 22, 'deneme soru Son !!!', '19.05.2020 03.53.21', 1, 0, 'deneme soru Son!!');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tablestudent`
--

CREATE TABLE `tablestudent` (
  `id` int(11) UNSIGNED NOT NULL,
  `Semail` varchar(50) NOT NULL,
  `Spassword` varchar(32) NOT NULL,
  `time` varchar(19) NOT NULL,
  `activationcode` varchar(32) NOT NULL,
  `activation` int(1) NOT NULL DEFAULT 0,
  `facultyId` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tablestudent`
--

INSERT INTO `tablestudent` (`id`, `Semail`, `Spassword`, `time`, `activationcode`, `activation`, `facultyId`) VALUES
(10, 'kmester.to@gmail.com', '3dad9cbf9baaa0360c0f2ba372d25716', '14.04.2020 08.28.44', '150b7a9aa8af8dd6c38273b0e8ffd5fd', 1, 1),
(14, 'yajopag733@hubopss.com', '7815696ecbf1c96e6894b779456d330e', '14.04.2020 10.08.15', '6cae3480d89251cdff93184c7480ba49', 1, 7),
(38, 'asd@ogr.ktu.edu.tr', '3dad9cbf9baaa0360c0f2ba372d25716', '19.05.2020 03.55.49', 'f628751c35c19c144e47b584d8c4a5cb', 1, 10),
(39, '888@ogr.ktu.edu.tr', '7815696ecbf1c96e6894b779456d330e', '19.05.2020 03.59.15', '8a8e40812be9cf248682eeb55a514d78', 1, 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `tableanonymous`
--
ALTER TABLE `tableanonymous`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`Aemail`);

--
-- Tablo için indeksler `tableanswer`
--
ALTER TABLE `tableanswer`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tablefaculty`
--
ALTER TABLE `tablefaculty`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tablequestion`
--
ALTER TABLE `tablequestion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questionerid` (`questionerid`);

--
-- Tablo için indeksler `tablestudent`
--
ALTER TABLE `tablestudent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Semail` (`Semail`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `tableanonymous`
--
ALTER TABLE `tableanonymous`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Tablo için AUTO_INCREMENT değeri `tableanswer`
--
ALTER TABLE `tableanswer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- Tablo için AUTO_INCREMENT değeri `tablefaculty`
--
ALTER TABLE `tablefaculty`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `tablequestion`
--
ALTER TABLE `tablequestion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Tablo için AUTO_INCREMENT değeri `tablestudent`
--
ALTER TABLE `tablestudent`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
