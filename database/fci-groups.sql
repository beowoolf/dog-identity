-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 03 Lut 2016, 14:22
-- Wersja serwera: 10.1.8-MariaDB
-- Wersja PHP: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `wds_di`
--

--
-- Tabela Truncate przed wstawieniem `fci`
--

TRUNCATE TABLE `fci`;
--
-- Zrzut danych tabeli `fci`
--

INSERT INTO `fci` (`ID`, `NAZWA`) VALUES
(1, 'Owczarki i inne psy pasterskie z wyłączeniem szwajcarskich psów do bydła'),
(2, 'Pinczery i sznaucery, molosy, szwajcarskie psy górskie i do bydła, pozostałe rasy'),
(3, 'Teriery'),
(4, 'Jamniki'),
(5, 'Szpice i psy w typie pierwotnym'),
(6, 'Psy gończe i rasy pokrewne'),
(7, 'Wyżły (psy wystawiające zwierzynę)'),
(8, 'Aportery, płochacze i psy dowodne'),
(9, 'Psy ozdobne i do towarzystwa'),
(10, 'Charty');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
