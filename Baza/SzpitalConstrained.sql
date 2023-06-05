-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 05, 2023 at 04:42 PM
-- Server version: 8.0.32-0buntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Szpital`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addPatient` (IN `imie` VARCHAR(100), IN `nazwisko` VARCHAR(100), IN `pesel` VARCHAR(11), IN `telefon` VARCHAR(9), IN `kod_pocztowy` VARCHAR(6), IN `adres` VARCHAR(150))  BEGIN
	INSERT INTO Pacjenci(
        Imie, 
        Nazwisko, 
        PESEL, 
        Telefon, 
        Kod_Pocztowy, 
        Adres
    ) VALUES (
        imie,
        nazwisko,
        pesel,
        telefon,
		kod_pocztowy,
        adres
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addProcedure` (IN `id_pacjenta` INT, IN `rodzaj_zabiegu` VARCHAR(50), IN `data_zabiegu` DATE, IN `id_lekarza` INT)  BEGIN
	INSERT INTO Zabiegi(
        ID_Pacjenta,
        Rodzaj_Zabiegu,
        Data_Zabiegu,
        ID_Lekarza
    ) VALUES (
    	id_pacjenta,
        rodzaj_zabiegu,
        data_zabiegu,
        id_lekarza
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `filterProcedureDate` (IN `filter` BOOLEAN)  BEGIN
	IF filter=1 THEN
		SELECT * FROM Zabiegi ORDER BY Data_Zabiegu ASC;
    ELSE
    	SELECT * FROM Zabiegi ORDER BY Data_Zabiegu DESC;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `filterProcedureSurname` (IN `surname` VARCHAR(100))  BEGIN
	SELECT Zabiegi.* FROM Zabiegi LEFT JOIN Pacjenci ON Zabiegi.ID_Pacjenta=Pacjenci.ID_Pacjenta WHERE Pacjenci.Nazwisko=surname;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `filterProcedureType` (IN `filter` BOOLEAN)  BEGIN
	IF filter=1 THEN
    	SELECT * FROM Zabiegi WHERE Rodzaj_Zabiegu="PILNE";
    ELSE 
    	SELECT * FROM Zabiegi WHERE Rodzaj_Zabiegu="RUTYNA";
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getData` (IN `tableName` VARCHAR(100))  BEGIN
	IF tableName='Lekarze' THEN
    	SELECT * FROM Lekarze;
    END IF;
    
    IF tableName='Oddzialy' THEN
    	SELECT * FROM Oddzialy;
    END IF;
    
    IF tableName='Pacjenci' THEN
    	SELECT * FROM Pacjenci;
    END IF;
    
    IF tableName='Pielegniarki' THEN
    	SELECT * FROM Pielegniarki;
    END IF;
    
    IF tableName='Zabiegi' THEN
    	SELECT * FROM Zabiegi;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `importPrepare` (IN `tableName` VARCHAR(100))  BEGIN
	SET FOREIGN_KEY_CHECKS=0;
    
    IF tableName='Lekarze' THEN
    	TRUNCATE TABLE Lekarze;
    END IF;
    
    IF tableName='Oddzialy' THEN
    	TRUNCATE TABLE Oddzialy;
    END IF;
    
    IF tableName='Pacjenci' THEN
    	TRUNCATE TABLE Pacjenci;      
    END IF;
    
    IF tableName='Pielegniarki' THEN
    	TRUNCATE TABLE Pielegniarki;
    END IF;
    
    IF tableName='Zabiegi' THEN
    	TRUNCATE TABLE Zabiegi;
    END IF;
    
    SET FOREIGN_KEY_CHECKS=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `importPreparium` (IN `tableName` VARCHAR(100))  BEGIN
	SET FOREIGN_KEY_CHECKS=0;
    IF tableName='Lekarze' THEN
    	DROP TABLE IF EXISTS Lekarze;
    	CREATE TABLE Lekarze (
              ID_Lekarza int NOT NULL PRIMARY KEY AUTO_INCREMENT,
              Imie varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
              Nazwisko varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci 					NOT NULL,
              Specjalizacja varchar(50) NOT NULL,
              Telefon varchar(9) NOT NULL,
              ID_Oddzialu int NOT NULL
        );
    END IF;
    
    IF tableName='Oddzialy' THEN
    	DROP TABLE IF EXISTS Oddzialy;
		CREATE TABLE Oddzialy (
          ID_Oddzialu int NOT NULL PRIMARY KEY AUTO_INCREMENT,
          Budynek varchar(100) CHARACTER SET utf8mb4 COLLATE 			utf8mb4_0900_ai_ci NOT NULL,
          Sektor varchar(100) CHARACTER SET utf8mb4 COLLATE 			utf8mb4_0900_ai_ci NOT NULL,
          Ulica varchar(100) CHARACTER SET utf8mb4 COLLATE 			utf8mb4_0900_ai_ci NOT NULL
        );
    END IF;
    
    IF tableName='Pacjenci' THEN
    DROP TABLE IF EXISTS Pacjenci;
    	CREATE TABLE Pacjenci (
          ID_Pacjenta int NOT NULL PRIMARY KEY AUTO_INCREMENT,
          Imie varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
          Nazwisko varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
          PESEL varchar(11) NOT NULL,
          Telefon varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
          Kod_Pocztowy varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
          Adres varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
		);
    END IF;
    
    IF tableName='Pielegniarki' THEN
    DROP TABLE IF EXISTS Pielegniarki;
    	CREATE TABLE Pielegniarki (
          ID_Pielegniarki int NOT NULL PRIMARY KEY AUTO_INCREMENT,
          Imie varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
          Nazwisko varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
          Telefon varchar(9) NOT NULL,
          ID_Oddzialu int NOT NULL
	);
    END IF;
    
    IF tableName='Zabiegi' THEN
    	DROP TABLE IF EXISTS Zabiegi;
        CREATE TABLE Zabiegi (
          ID_Zabiegu int NOT NULL PRIMARY KEY AUTO_INCREMENT,
          ID_Pacjenta int NOT NULL,
          Rodzaj_Zabiegu varchar(50) NOT NULL,
          Data_Zabiegu date NOT NULL,
          ID_Lekarza int NOT NULL
        );
    END IF;
    SET FOREIGN_KEY_CHECKS=1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Lekarze`
--

CREATE TABLE `Lekarze` (
  `ID_Lekarza` int NOT NULL,
  `Imie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Nazwisko` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Specjalizacja` varchar(50) NOT NULL,
  `Telefon` varchar(9) NOT NULL,
  `ID_Oddzialu` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Oddzialy`
--

CREATE TABLE `Oddzialy` (
  `ID_Oddzialu` int NOT NULL,
  `Budynek` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Sektor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Ulica` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Pacjenci`
--

CREATE TABLE `Pacjenci` (
  `ID_Pacjenta` int NOT NULL,
  `Imie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Nazwisko` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `PESEL` varchar(11) NOT NULL,
  `Telefon` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Kod_Pocztowy` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Adres` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Pielegniarki`
--

CREATE TABLE `Pielegniarki` (
  `ID_Pielegniarki` int NOT NULL,
  `Imie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Nazwisko` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Telefon` varchar(9) NOT NULL,
  `ID_Oddzialu` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Zabiegi`
--

CREATE TABLE `Zabiegi` (
  `ID_Zabiegu` int NOT NULL,
  `ID_Pacjenta` int NOT NULL,
  `Rodzaj_Zabiegu` varchar(50) NOT NULL,
  `Data_Zabiegu` date NOT NULL,
  `ID_Lekarza` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Lekarze`
--
ALTER TABLE `Lekarze`
  ADD PRIMARY KEY (`ID_Lekarza`),
  ADD KEY `Lekarze_ibfk_1` (`ID_Oddzialu`);

--
-- Indexes for table `Oddzialy`
--
ALTER TABLE `Oddzialy`
  ADD PRIMARY KEY (`ID_Oddzialu`),
  ADD KEY `ID_Oddzialu` (`ID_Oddzialu`) USING BTREE;

--
-- Indexes for table `Pacjenci`
--
ALTER TABLE `Pacjenci`
  ADD PRIMARY KEY (`ID_Pacjenta`);

--
-- Indexes for table `Pielegniarki`
--
ALTER TABLE `Pielegniarki`
  ADD PRIMARY KEY (`ID_Pielegniarki`),
  ADD KEY `ID_Oddzialu` (`ID_Oddzialu`) USING BTREE;

--
-- Indexes for table `Zabiegi`
--
ALTER TABLE `Zabiegi`
  ADD PRIMARY KEY (`ID_Zabiegu`),
  ADD KEY `ID_Lekarza` (`ID_Lekarza`) USING BTREE,
  ADD KEY `ID_Pacjenta` (`ID_Pacjenta`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Lekarze`
--
ALTER TABLE `Lekarze`
  MODIFY `ID_Lekarza` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `Oddzialy`
--
ALTER TABLE `Oddzialy`
  MODIFY `ID_Oddzialu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `Pacjenci`
--
ALTER TABLE `Pacjenci`
  MODIFY `ID_Pacjenta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `Pielegniarki`
--
ALTER TABLE `Pielegniarki`
  MODIFY `ID_Pielegniarki` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `Zabiegi`
--
ALTER TABLE `Zabiegi`
  MODIFY `ID_Zabiegu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Lekarze`
--
ALTER TABLE `Lekarze`
  ADD CONSTRAINT `Lekarze_ibfk_1` FOREIGN KEY (`ID_Oddzialu`) REFERENCES `Oddzialy` (`ID_Oddzialu`);

--
-- Constraints for table `Pielegniarki`
--
ALTER TABLE `Pielegniarki`
  ADD CONSTRAINT `Pielegniarki_ibfk_1` FOREIGN KEY (`ID_Oddzialu`) REFERENCES `Oddzialy` (`ID_Oddzialu`);

--
-- Constraints for table `Zabiegi`
--
ALTER TABLE `Zabiegi`
  ADD CONSTRAINT `Zabiegi_ibfk_1` FOREIGN KEY (`ID_Lekarza`) REFERENCES `Lekarze` (`ID_Lekarza`),
  ADD CONSTRAINT `Zabiegi_ibfk_2` FOREIGN KEY (`ID_Pacjenta`) REFERENCES `Pacjenci` (`ID_Pacjenta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
