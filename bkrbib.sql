-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 05. Feb 2024 um 12:38
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `bkrbib`
--
CREATE DATABASE IF NOT EXISTS `bkrbib` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bkrbib`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `autor`
--

DROP TABLE IF EXISTS `autor`;
CREATE TABLE `autor` (
  `autor_ID` int(4) NOT NULL,
  `name` varchar(32) NOT NULL,
  `vorname` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `autor`
--

INSERT INTO `autor` (`autor_ID`, `name`, `vorname`) VALUES
(1, 'Müller', 'Anna'),
(2, 'Schmidt', 'Michael'),
(3, 'Wagner', 'Julia'),
(4, 'Becker', 'Markus'),
(5, 'Schulz', 'Sophie'),
(6, 'Fischer', 'David'),
(7, 'Koch', 'Laura'),
(8, 'Huber', 'Thomas'),
(9, 'Bauer', 'Lena'),
(10, 'Schneider', 'Paul');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buch`
--

DROP TABLE IF EXISTS `buch`;
CREATE TABLE `buch` (
  `buch_ID` int(4) NOT NULL,
  `verlag_ID` int(4) NOT NULL,
  `kategorie_ID` int(4) NOT NULL,
  `buchtitel` varchar(32) NOT NULL,
  `erscheinungsjahr` year(4) NOT NULL,
  `ISBN` varchar(32) NOT NULL,
  `tagespreis` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `buch`
--

INSERT INTO `buch` (`buch_ID`, `verlag_ID`, `kategorie_ID`, `buchtitel`, `erscheinungsjahr`, `ISBN`, `tagespreis`) VALUES
(21, 1, 1, 'Die Kunst des Programmierens', '2020', '978-3-16-148410-0', 2),
(22, 2, 2, 'Der Weg zum Erfolg', '2015', '978-3-16-148410-1', 2),
(23, 3, 3, 'Die Geheimnisse des Universums', '2018', '978-3-16-148410-2', 2),
(24, 4, 4, 'Kochkunst für Anfänger', '2021', '978-3-16-148410-3', 2),
(25, 5, 5, 'Geschichte der Antike', '2017', '978-3-16-148410-4', 4),
(26, 6, 1, 'Moderne Kunst verstehen', '2019', '978-3-16-148410-5', 4),
(27, 7, 2, 'Romane für die Seele', '2016', '978-3-16-148410-6', 2),
(28, 8, 3, 'Die Welt der Tiere', '2022', '978-3-16-148410-7', 4),
(29, 9, 4, 'Pflanzen und ihre Bedeutung', '2014', '978-3-16-148410-8', 2),
(30, 10, 5, 'Musikgeschichte kompakt', '2023', '978-3-16-148410-9', 3),
(33, 1, 1, 'fgsfsdf', '0000', '2423423', 0),
(34, 8, 8, 'natt', '0000', '123123', 0),
(35, 5, 4, 'Buch Name', '0000', '123123123', 5),
(36, 1, 1, 'natt', '2010', '34234', 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `buch_autor`
--

DROP TABLE IF EXISTS `buch_autor`;
CREATE TABLE `buch_autor` (
  `buchAutor_ID` int(4) NOT NULL,
  `buch_ID` int(4) NOT NULL,
  `autor_ID` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `buch_autor`
--

INSERT INTO `buch_autor` (`buchAutor_ID`, `buch_ID`, `autor_ID`) VALUES
(1, 21, 1),
(2, 22, 2),
(3, 23, 3),
(4, 24, 4),
(5, 25, 5),
(6, 26, 6),
(7, 27, 7),
(8, 28, 8),
(9, 29, 9),
(10, 30, 10);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `exemplar`
--

DROP TABLE IF EXISTS `exemplar`;
CREATE TABLE `exemplar` (
  `exemplar_ID` int(4) NOT NULL,
  `buch_ID` int(4) NOT NULL,
  `zustand` varchar(32) NOT NULL,
  `verfügbarkeit` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `exemplar`
--

INSERT INTO `exemplar` (`exemplar_ID`, `buch_ID`, `zustand`, `verfügbarkeit`) VALUES
(20, 21, 'Neu', 1),
(21, 21, 'Gut', 1),
(22, 21, 'Gebraucht', 1),
(23, 22, 'Neu', 1),
(24, 22, 'Gut', 1),
(25, 23, 'Neu', 1),
(26, 23, 'Gut', 1),
(27, 24, 'Neu', 1),
(28, 24, 'Gut', 1),
(29, 25, 'Neu', 1),
(30, 25, 'Gut', 1),
(31, 26, 'Neu', 1),
(32, 27, 'Gut', 1),
(33, 28, 'Neu', 1),
(34, 28, 'Gut', 1),
(35, 29, 'Neu', 1),
(36, 29, 'Gut', 1),
(37, 30, 'Neu', 1),
(38, 30, 'Gut', 1),
(39, 35, 'Gut', 1),
(40, 26, 'Ja is okay', 1),
(41, 22, 'ja', 1),
(42, 29, 'ne', 1),
(43, 29, 'ne', 1),
(44, 29, 'ne', 1),
(45, 29, 'ne', 1),
(46, 29, 'ne', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kategorie`
--

DROP TABLE IF EXISTS `kategorie`;
CREATE TABLE `kategorie` (
  `kategorie_ID` int(4) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `kategorie`
--

INSERT INTO `kategorie` (`kategorie_ID`, `name`) VALUES
(1, 'Informatik'),
(2, 'Bildung'),
(3, 'Wissenschaft'),
(4, 'Kochen'),
(5, 'Geschichte'),
(6, 'Kunst'),
(7, 'Romane'),
(8, 'Natur'),
(9, 'Garten'),
(10, 'Musik');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kunde`
--

DROP TABLE IF EXISTS `kunde`;
CREATE TABLE `kunde` (
  `kunde_ID` int(4) NOT NULL,
  `name` varchar(32) NOT NULL,
  `vorname` varchar(32) NOT NULL,
  `geburtsdatum` date NOT NULL,
  `telefon` varchar(16) NOT NULL,
  `email` varchar(32) NOT NULL,
  `passwort` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `ort_ID` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `kunde`
--

INSERT INTO `kunde` (`kunde_ID`, `name`, `vorname`, `geburtsdatum`, `telefon`, `email`, `passwort`, `status`, `ort_ID`) VALUES
(11, 'Müller', 'Hans', '1980-05-15', '+49 176 12345678', 'hans.mueller@example.com', '1234', 0, 1),
(12, 'Schmidt', 'Sabine', '1992-08-22', '+49 176 23456789', 'sabine.schmidt@example.com', '', 0, 1),
(13, 'Wagner', 'Jens', '1985-03-10', '+49 176 34567890', 'jens.wagner@example.com', '', 0, 1),
(14, 'Becker', 'Anja', '1990-11-28', '+49 176 45678901', 'anja.becker@example.com', '', 0, 4),
(15, 'Schulz', 'Felix', '1982-07-03', '+49 176 56789012', 'felix.schulz@example.com', '', 0, 4),
(16, 'Fischer', 'Laura', '1988-01-18', '+49 176 67890123', 'laura.fischer@example.com', '', 0, 3),
(17, 'Koch', 'Robert', '1995-06-25', '+49 176 78901234', 'robert.koch@example.com', '', 0, 9),
(18, 'Huber', 'Sophie', '1987-09-12', '+49 176 89012345', 'sophie.huber@example.com', '', 0, 1),
(19, 'Bauer', 'Mark', '1984-04-05', '+49 176 90123456', 'mark.bauer@example.com', '', 0, 1),
(20, 'Schneider', 'Lena', '1998-02-14', '+49 176 01234567', 'lena.schneider@example.com', '', 0, 2),
(21, 'admin', 'pascal', '1987-01-27', '12345', 'admin@bib.de', '1234', 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ort`
--

DROP TABLE IF EXISTS `ort`;
CREATE TABLE `ort` (
  `ort_ID` int(4) NOT NULL,
  `name` varchar(32) NOT NULL,
  `plz` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `ort`
--

INSERT INTO `ort` (`ort_ID`, `name`, `plz`) VALUES
(1, 'Berlin', 10115),
(2, 'München', 80331),
(3, 'Hamburg', 20095),
(4, 'Frankfurt', 60306),
(5, 'Köln', 50667),
(6, 'Düsseldorf', 40210),
(7, 'Stuttgart', 70173),
(8, 'Dresden', 1067),
(9, 'Leipzig', 4109),
(10, 'Nürnberg', 90402);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rückgabe`
--

DROP TABLE IF EXISTS `rückgabe`;
CREATE TABLE `rückgabe` (
  `rückgabe_ID` int(11) NOT NULL,
  `exemplar_ID` int(11) NOT NULL,
  `verleihvorgangs_ID` int(11) NOT NULL,
  `rückgabedatum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `verlag`
--

DROP TABLE IF EXISTS `verlag`;
CREATE TABLE `verlag` (
  `verlag_ID` int(4) NOT NULL,
  `verlagname` varchar(32) NOT NULL,
  `ort_ID` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `verlag`
--

INSERT INTO `verlag` (`verlag_ID`, `verlagname`, `ort_ID`) VALUES
(1, 'TechVerlag', 1),
(2, 'WissenVerlag', 2),
(3, 'ForschungsVerlag', 3),
(4, 'KochVerlag', 4),
(5, 'GeschichteVerlag', 5),
(6, 'KunstVerlag', 6),
(7, 'RomanVerlag', 7),
(8, 'NaturVerlag', 8),
(9, 'GartenVerlag', 9),
(10, 'MusikVerlag', 10);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `verleihvorgang`
--

DROP TABLE IF EXISTS `verleihvorgang`;
CREATE TABLE `verleihvorgang` (
  `verleih_ID` int(4) NOT NULL,
  `kunden_ID` int(4) NOT NULL,
  `ausleihdatum` date NOT NULL,
  `rückgabedatum` date DEFAULT NULL,
  `rückgabestatus` tinyint(1) NOT NULL,
  `preis` int(12) NOT NULL,
  `zahlungsstatus` tinyint(1) NOT NULL,
  `exemplar_ID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`autor_ID`);

--
-- Indizes für die Tabelle `buch`
--
ALTER TABLE `buch`
  ADD PRIMARY KEY (`buch_ID`),
  ADD KEY `kategorie_ID` (`kategorie_ID`),
  ADD KEY `verlag_ID` (`verlag_ID`);

--
-- Indizes für die Tabelle `buch_autor`
--
ALTER TABLE `buch_autor`
  ADD PRIMARY KEY (`buchAutor_ID`),
  ADD KEY `autor_ID` (`autor_ID`),
  ADD KEY `buch_ID` (`buch_ID`);

--
-- Indizes für die Tabelle `exemplar`
--
ALTER TABLE `exemplar`
  ADD PRIMARY KEY (`exemplar_ID`),
  ADD KEY `buch_ID` (`buch_ID`);

--
-- Indizes für die Tabelle `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`kategorie_ID`);

--
-- Indizes für die Tabelle `kunde`
--
ALTER TABLE `kunde`
  ADD PRIMARY KEY (`kunde_ID`),
  ADD KEY `ort_ID` (`ort_ID`);

--
-- Indizes für die Tabelle `ort`
--
ALTER TABLE `ort`
  ADD PRIMARY KEY (`ort_ID`);

--
-- Indizes für die Tabelle `rückgabe`
--
ALTER TABLE `rückgabe`
  ADD PRIMARY KEY (`rückgabe_ID`),
  ADD KEY `exemplar_ID` (`exemplar_ID`),
  ADD KEY `verleihvorgangs_ID` (`verleihvorgangs_ID`);

--
-- Indizes für die Tabelle `verlag`
--
ALTER TABLE `verlag`
  ADD PRIMARY KEY (`verlag_ID`),
  ADD KEY `ort_ID` (`ort_ID`);

--
-- Indizes für die Tabelle `verleihvorgang`
--
ALTER TABLE `verleihvorgang`
  ADD PRIMARY KEY (`verleih_ID`),
  ADD KEY `kunden_ID` (`kunden_ID`),
  ADD KEY `exemplar_ID` (`exemplar_ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `autor`
--
ALTER TABLE `autor`
  MODIFY `autor_ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `buch`
--
ALTER TABLE `buch`
  MODIFY `buch_ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT für Tabelle `buch_autor`
--
ALTER TABLE `buch_autor`
  MODIFY `buchAutor_ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `exemplar`
--
ALTER TABLE `exemplar`
  MODIFY `exemplar_ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT für Tabelle `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `kategorie_ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `kunde`
--
ALTER TABLE `kunde`
  MODIFY `kunde_ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT für Tabelle `ort`
--
ALTER TABLE `ort`
  MODIFY `ort_ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `rückgabe`
--
ALTER TABLE `rückgabe`
  MODIFY `rückgabe_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `verlag`
--
ALTER TABLE `verlag`
  MODIFY `verlag_ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `verleihvorgang`
--
ALTER TABLE `verleihvorgang`
  MODIFY `verleih_ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `buch`
--
ALTER TABLE `buch`
  ADD CONSTRAINT `buch_ibfk_1` FOREIGN KEY (`kategorie_ID`) REFERENCES `kategorie` (`kategorie_ID`),
  ADD CONSTRAINT `buch_ibfk_2` FOREIGN KEY (`verlag_ID`) REFERENCES `verlag` (`verlag_ID`);

--
-- Constraints der Tabelle `buch_autor`
--
ALTER TABLE `buch_autor`
  ADD CONSTRAINT `buch_autor_ibfk_1` FOREIGN KEY (`autor_ID`) REFERENCES `autor` (`autor_ID`),
  ADD CONSTRAINT `buch_autor_ibfk_2` FOREIGN KEY (`buch_ID`) REFERENCES `buch` (`buch_ID`);

--
-- Constraints der Tabelle `exemplar`
--
ALTER TABLE `exemplar`
  ADD CONSTRAINT `exemplar_ibfk_1` FOREIGN KEY (`buch_ID`) REFERENCES `buch` (`buch_ID`);

--
-- Constraints der Tabelle `kunde`
--
ALTER TABLE `kunde`
  ADD CONSTRAINT `kunde_ibfk_1` FOREIGN KEY (`ort_ID`) REFERENCES `ort` (`ort_ID`);

--
-- Constraints der Tabelle `rückgabe`
--
ALTER TABLE `rückgabe`
  ADD CONSTRAINT `rückgabe_ibfk_1` FOREIGN KEY (`exemplar_ID`) REFERENCES `exemplar` (`exemplar_ID`),
  ADD CONSTRAINT `rückgabe_ibfk_2` FOREIGN KEY (`verleihvorgangs_ID`) REFERENCES `verleihvorgang` (`verleih_ID`);

--
-- Constraints der Tabelle `verlag`
--
ALTER TABLE `verlag`
  ADD CONSTRAINT `verlag_ibfk_1` FOREIGN KEY (`ort_ID`) REFERENCES `ort` (`ort_ID`);

--
-- Constraints der Tabelle `verleihvorgang`
--
ALTER TABLE `verleihvorgang`
  ADD CONSTRAINT `verleihvorgang_ibfk_2` FOREIGN KEY (`kunden_ID`) REFERENCES `kunde` (`kunde_ID`),
  ADD CONSTRAINT `verleihvorgang_ibfk_3` FOREIGN KEY (`exemplar_ID`) REFERENCES `exemplar` (`exemplar_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
