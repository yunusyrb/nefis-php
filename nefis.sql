-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 10 May 2019, 06:13:41
-- Sunucu sürümü: 10.1.38-MariaDB
-- PHP Sürümü: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `nefis`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anket`
--

CREATE TABLE `anket` (
  `id` int(11) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `tarif_id` int(11) NOT NULL,
  `yanit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `anket`
--

INSERT INTO `anket` (`id`, `uye_id`, `tarif_id`, `yanit`) VALUES
(1, 1, 2, 1),
(2, 1, 3, 0),
(3, 1, 4, 1),
(4, 1, 5, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `begeniler`
--

CREATE TABLE `begeniler` (
  `begeni_id` int(11) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `tarif_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `begeniler`
--

INSERT INTO `begeniler` (`begeni_id`, `uye_id`, `tarif_id`) VALUES
(3, 4, 3),
(8, 1, 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `kat_id` int(11) NOT NULL,
  `kat_isim` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`kat_id`, `kat_isim`) VALUES
(1, 'Kahvaltılık'),
(2, 'Salata'),
(3, 'Kek'),
(4, 'Tavuk'),
(5, 'Zeytinyağlı'),
(6, 'Et'),
(7, 'Balık'),
(8, 'Pasta');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tarifler`
--

CREATE TABLE `tarifler` (
  `tarif_id` int(11) NOT NULL,
  `baslik` varchar(100) NOT NULL,
  `kac_kisilik` varchar(100) NOT NULL,
  `hazirlanma_suresi` varchar(100) NOT NULL,
  `pisirme_suresi` varchar(100) NOT NULL,
  `malzemeler_detay` text NOT NULL,
  `hazirlanis_detay` text NOT NULL,
  `resim` varchar(100) DEFAULT NULL,
  `uye_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `okunma` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `tarifler`
--

INSERT INTO `tarifler` (`tarif_id`, `baslik`, `kac_kisilik`, `hazirlanma_suresi`, `pisirme_suresi`, `malzemeler_detay`, `hazirlanis_detay`, `resim`, `uye_id`, `kategori_id`, `tarih`, `okunma`) VALUES
(2, 'safaff', '1-2 kişilik', '5 dk', '15 dk', 'asfasfasf', 'afafsfa', 'resimler/tarif.jpg', 1, 5, '2019-03-10 13:18:47', 48),
(3, 'deneme', '1-2 kişilik', '5 dk', '15 dk', 'asfas.faf', 'çsfsaçga', 'resimler/tarif.jpg', 1, 3, '2019-03-10 13:20:48', 107),
(4, 'tepsi yemeği', '4-6 kişilik', '30 dk', '90 dk', '5 adet patates\r\n2 adet soğan\r\n7 adet biber\r\n3 yemek kaşığı salça', 'Sebzeleri doğruyoruz.Salça ve baharatlıyoruz.', 'resimler/firinda-kiymali-patates-yemegi-tarifi.jpg', 1, 4, '2019-05-08 19:31:01', 7),
(5, 'denemeaasdasdf', '1-2 kişilik', '5 dk', '15 dk', 'jsdjdsjjs \r\nds\r\nds\r\nds\r\nds\r\ndsd\r\nd\r\nds\r\nsd', 'asd s\r\ns\r\ns\r\ns\r\ns\r\ns\r\ns\r\ns\r\ns', 'resimler/', 1, 1, '2019-05-10 02:03:43', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uyeler`
--

CREATE TABLE `uyeler` (
  `uye_id` int(11) NOT NULL,
  `eposta` varchar(64) NOT NULL,
  `isim` varchar(64) NOT NULL,
  `sifre` varchar(64) NOT NULL,
  `cinsiyet` varchar(10) NOT NULL,
  `kullanici_adi` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `uyeler`
--

INSERT INTO `uyeler` (`uye_id`, `eposta`, `isim`, `sifre`, `cinsiyet`, `kullanici_adi`) VALUES
(1, 'yunusyrb@gmail.com', 'yunus yarba 111', '123456', 'Erkek', 'asigenç'),
(2, 'asdsad', '111', 'sfaf', 'K', 'asfasf'),
(3, 'funda@gmail.com', 'Funda ESE', '1', 'K', 'ortim'),
(4, 'deneme@gmail.com', '123456', 'deneme deneme', 'K', 'deneme');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `yorum_id` int(11) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `tarif_id` int(11) NOT NULL,
  `ust_id` int(11) NOT NULL DEFAULT '0',
  `yorum` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`yorum_id`, `uye_id`, `tarif_id`, `ust_id`, `yorum`) VALUES
(1, 1, 3, 0, 'süper'),
(2, 1, 3, 1, 'süper değil'),
(3, 1, 3, 0, 'deneme'),
(4, 1, 3, 1, 'test'),
(5, 3, 3, 1, 'naber'),
(6, 1, 3, 1, 'iyidir senden'),
(7, 1, 3, 0, 'denemee eeee'),
(8, 1, 3, 7, 'eeee\r\n');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `anket`
--
ALTER TABLE `anket`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `begeniler`
--
ALTER TABLE `begeniler`
  ADD PRIMARY KEY (`begeni_id`);

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`kat_id`);

--
-- Tablo için indeksler `tarifler`
--
ALTER TABLE `tarifler`
  ADD PRIMARY KEY (`tarif_id`);

--
-- Tablo için indeksler `uyeler`
--
ALTER TABLE `uyeler`
  ADD PRIMARY KEY (`uye_id`);

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`yorum_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `anket`
--
ALTER TABLE `anket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `begeniler`
--
ALTER TABLE `begeniler`
  MODIFY `begeni_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `kat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `tarifler`
--
ALTER TABLE `tarifler`
  MODIFY `tarif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `uyeler`
--
ALTER TABLE `uyeler`
  MODIFY `uye_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `yorum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
