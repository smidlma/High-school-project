-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2019 at 04:44 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `autoservis`
--

-- --------------------------------------------------------

--
-- Table structure for table `adresa`
--

CREATE TABLE `adresa` (
  `adresa_id` int(11) NOT NULL,
  `ulice` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `cislo_popisne` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `mesto` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `psc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `adresa`
--

INSERT INTO `adresa` (`adresa_id`, `ulice`, `cislo_popisne`, `mesto`, `psc`) VALUES
(1, 'main', 'main', 'main', 0);

-- --------------------------------------------------------

--
-- Table structure for table `auto`
--

CREATE TABLE `auto` (
  `auto_id` int(11) NOT NULL,
  `spz` varchar(8) COLLATE utf8_czech_ci NOT NULL,
  `znacka` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `model` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `rok_vyroby` varchar(4) COLLATE utf8_czech_ci NOT NULL,
  `motor` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `provozovatel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `auto`
--

INSERT INTO `auto` (`auto_id`, `spz`, `znacka`, `model`, `rok_vyroby`, `motor`, `provozovatel_id`) VALUES
(1, 'nové', 'nové', 'nové', 'nové', 'nové', 1);

-- --------------------------------------------------------

--
-- Table structure for table `provozovatel`
--

CREATE TABLE `provozovatel` (
  `provozovatel_id` int(11) NOT NULL,
  `firma` varchar(50) COLLATE utf8_czech_ci DEFAULT 'jednotlivec',
  `jmeno` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `telefon` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `adresa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `provozovatel`
--

INSERT INTO `provozovatel` (`provozovatel_id`, `firma`, `jmeno`, `prijmeni`, `telefon`, `email`, `password`, `admin`, `adresa_id`) VALUES
(1, 'main', 'main', 'main', 'main', 'admin', '0CBC6611F5540BD0809A388DC95A615B', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `servisak`
--

CREATE TABLE `servisak` (
  `servisak_id` int(11) NOT NULL,
  `jmeno` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servisni_objednavka`
--

CREATE TABLE `servisni_objednavka` (
  `servisni_objednavka_id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `stav` varchar(10) COLLATE utf8_czech_ci NOT NULL DEFAULT 'přijata',
  `ukonceno` date DEFAULT NULL,
  `zavada` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `provozovatel_id` int(11) NOT NULL,
  `auto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servisni_objednavka_radky`
--

CREATE TABLE `servisni_objednavka_radky` (
  `servisni_objednavka_radky_id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `cena` int(11) NOT NULL,
  `popis` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `typ_zasahu_id` int(11) NOT NULL,
  `servisak_id` int(11) NOT NULL,
  `servisni_objednavka_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `token_id` int(11) NOT NULL,
  `value` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date_ex` date NOT NULL,
  `provozovatel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Table structure for table `typ_zasahu`
--

CREATE TABLE `typ_zasahu` (
  `typ_zasahu_id` int(11) NOT NULL,
  `nazev` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `cena` int(11) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `typ_zasahu` (`typ_zasahu_id`, `nazev`, `cena`, `valid`) VALUES
(1, 'jiné', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adresa`
--
ALTER TABLE `adresa`
  ADD PRIMARY KEY (`adresa_id`);

--
-- Indexes for table `auto`
--
ALTER TABLE `auto`
  ADD PRIMARY KEY (`auto_id`),
  ADD KEY `fk_Auto_Provozovatel1_idx` (`provozovatel_id`);

--
-- Indexes for table `provozovatel`
--
ALTER TABLE `provozovatel`
  ADD PRIMARY KEY (`provozovatel_id`),
  ADD KEY `fk_Provozovatel_Adresa_idx` (`adresa_id`);

--
-- Indexes for table `servisak`
--
ALTER TABLE `servisak`
  ADD PRIMARY KEY (`servisak_id`);

--
-- Indexes for table `servisni_objednavka`
--
ALTER TABLE `servisni_objednavka`
  ADD PRIMARY KEY (`servisni_objednavka_id`),
  ADD KEY `fk_Servisni_Objednavka_Provozovatel1_idx` (`provozovatel_id`),
  ADD KEY `fk_Servisni_Objednavka_Auto1_idx` (`auto_id`);

--
-- Indexes for table `servisni_objednavka_radky`
--
ALTER TABLE `servisni_objednavka_radky`
  ADD PRIMARY KEY (`servisni_objednavka_radky_id`),
  ADD KEY `fk_Servisni_Objednavka_Radky_Typ_Zasahu1_idx` (`typ_zasahu_id`),
  ADD KEY `fk_Servisni_Objednavka_Radky_Servisak1_idx` (`servisak_id`),
  ADD KEY `fk_Servisni_Objednavka_Radky_Servisni_Objednavka1_idx` (`servisni_objednavka_id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD KEY `pr_tok_fk` (`provozovatel_id`);

--
-- Indexes for table `typ_zasahu`
--
ALTER TABLE `typ_zasahu`
  ADD PRIMARY KEY (`typ_zasahu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adresa`
--
ALTER TABLE `adresa`
  MODIFY `adresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `auto`
--
ALTER TABLE `auto`
  MODIFY `auto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `provozovatel`
--
ALTER TABLE `provozovatel`
  MODIFY `provozovatel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `servisak`
--
ALTER TABLE `servisak`
  MODIFY `servisak_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servisni_objednavka`
--
ALTER TABLE `servisni_objednavka`
  MODIFY `servisni_objednavka_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servisni_objednavka_radky`
--
ALTER TABLE `servisni_objednavka_radky`
  MODIFY `servisni_objednavka_radky_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `typ_zasahu`
--
ALTER TABLE `typ_zasahu`
  MODIFY `typ_zasahu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auto`
--
ALTER TABLE `auto`
  ADD CONSTRAINT `fk_Auto_Provozovatel1` FOREIGN KEY (`provozovatel_id`) REFERENCES `provozovatel` (`provozovatel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `provozovatel`
--
ALTER TABLE `provozovatel`
  ADD CONSTRAINT `fk_Provozovatel_Adresa` FOREIGN KEY (`adresa_id`) REFERENCES `adresa` (`adresa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `servisni_objednavka`
--
ALTER TABLE `servisni_objednavka`
  ADD CONSTRAINT `fk_Servisni_Objednavka_Auto1` FOREIGN KEY (`auto_id`) REFERENCES `auto` (`auto_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Servisni_Objednavka_Provozovatel1` FOREIGN KEY (`provozovatel_id`) REFERENCES `provozovatel` (`provozovatel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `servisni_objednavka_radky`
--
ALTER TABLE `servisni_objednavka_radky`
  ADD CONSTRAINT `fk_Servisni_Objednavka_Radky_Servisak1` FOREIGN KEY (`servisak_id`) REFERENCES `servisak` (`servisak_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Servisni_Objednavka_Radky_Servisni_Objednavka1` FOREIGN KEY (`servisni_objednavka_id`) REFERENCES `servisni_objednavka` (`servisni_objednavka_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Servisni_Objednavka_Radky_Typ_Zasahu1` FOREIGN KEY (`typ_zasahu_id`) REFERENCES `typ_zasahu` (`typ_zasahu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `pr_tok_fk` FOREIGN KEY (`provozovatel_id`) REFERENCES `provozovatel` (`provozovatel_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
