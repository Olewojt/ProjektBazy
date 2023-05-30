-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 30, 2023 at 03:16 PM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `getData` (IN `tableName` VARCHAR(50))  BEGIN
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
          Kod_Pocztowy varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
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
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ileZabiegow`
--

CREATE TABLE `ileZabiegow` (
  `Rok` int DEFAULT NULL,
  `Miesiac` int DEFAULT NULL,
  `Ilosc_Zabiegow` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ileZabiegow`
--

INSERT INTO `ileZabiegow` (`Rok`, `Miesiac`, `Ilosc_Zabiegow`) VALUES
(2022, 11, 8),
(2022, 12, 6),
(2023, 1, 7),
(2023, 2, 10),
(2023, 3, 10),
(2023, 4, 9);

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

--
-- Dumping data for table `Lekarze`
--

INSERT INTO `Lekarze` (`ID_Lekarza`, `Imie`, `Nazwisko`, `Specjalizacja`, `Telefon`, `ID_Oddzialu`) VALUES
(1, 'Lea', 'Szumski', 'Chłopskirozumolog', '860970332', 7),
(2, 'Albin', 'Kramarz', 'Wykopolog', '212650171', 14),
(3, 'Gertruda', 'Bobowski', 'Wykopolog', '197853890', 37),
(4, 'Megi', 'Korcz', 'Stomatolog', '232554342', 28),
(5, 'Aleksy', 'Borowiecki', 'Stomatolog', '584386656', 43),
(6, 'Roland', 'Sałata', 'Chirurg', '429337983', 8),
(7, 'Dorota', 'Kędzior', 'Informatolog', '852401434', 27),
(8, 'Irma', 'Nikiel', 'Informatolog', '265016591', 13),
(9, 'Amanda', 'Kurdziel', 'Kardiolog', '223416878', 1),
(10, 'Marek', 'Bartosz', 'Patolog', '188015807', 25),
(11, 'Angela', 'Czapka', 'Patolog', '7938924', 2),
(12, 'Aaron', 'Szczepański', 'Kardiolog', '611559130', 16),
(13, 'Herakles', 'Bakalarz', 'Patolog', '359304118', 44),
(14, 'Rudolf', 'Dudziński', 'Wykopolog', '36465174', 45),
(15, 'Bert', 'Markowicz', 'Łopatolog', '279866208', 38),
(16, 'Kunegunda', 'Pac', 'Archeolog', '169329809', 12),
(17, 'Wilhelm', 'Ignatowicz', 'Patolog', '247811454', 3),
(18, 'Abel', 'Romanek', 'Neurolog', '433580169', 36),
(19, 'Rebeka', 'Kowalik', 'Kardiolog', '339710866', 22),
(20, 'Petronia', 'Karp', 'Stomatolog', '164096794', 46),
(21, 'Aldona', 'Danielewicz', 'Stomatolog', '649548881', 34),
(22, 'Patryk', 'Abramek', 'Neurolog', '173589723', 10),
(23, 'Derwit', 'Michalczyk', 'Patolog', '252176717', 41),
(24, 'Waleria', 'Śliwka', 'Neurolog', '840388705', 18),
(25, 'Joanna', 'Zimnicki', 'Neurolog', '389154326', 42),
(26, 'Estera', 'Kopania', 'Patolog', '365710320', 17),
(27, 'Zenon', 'Andruszkiewicz', 'Neurolog', '49463127', 49),
(28, 'Rita', 'Czaplicki', 'Archeolog', '179430258', 30),
(29, 'Antonio', 'Lubas', 'Informatolog', '91066500', 48),
(30, 'Gniewomira', 'Fischer', 'Archeolog', '308544876', 33),
(31, 'Adriana', 'Sawicz', 'Chirurg', '746764974', 20),
(32, 'Kazimierz', 'Szczepanek', 'Wykopolog', '290087733', 15),
(33, 'Jacek', 'Radomski', 'Kardiolog', '436267120', 40),
(34, 'Renat', 'Michałek', 'Informatolog', '691063969', 4),
(35, 'Przybysław', 'Kubis', 'Informatolog', '415552889', 23),
(36, 'Joachima', 'Rucki', 'Kardiolog', '692166080', 32),
(37, 'Dagmara', 'Filip', 'Patolog', '673300493', 24),
(38, 'Konstancja', 'Wrzesiński', 'Chłopskirozumolog', '804774942', 39),
(39, 'Izabela', 'Mroziński', 'Łopatolog', '225871615', 9),
(40, 'Mieczysława', 'Frączak', 'Chirurg', '107800799', 19),
(41, 'Oktawiusz', 'Zdybel', 'Łopatolog', '225627578', 35),
(42, 'Franciszka', 'Kopaczewski', 'Archeolog', '902609049', 26),
(43, 'Julian', 'Borowa', 'Kardiolog', '204599071', 47),
(44, 'Szejma', 'Wybraniec', 'Archeolog', '799418317', 21),
(45, 'Izolda', 'Drwal', 'Patolog', '305524133', 5),
(46, 'Eleonora', 'Duszyński', 'Neurolog', '223639853', 31),
(47, 'Amelia', 'Niedziela', 'Łopatolog', '604103347', 50),
(48, 'Nikodema', 'Kolczyński', 'Patolog', '513209003', 29),
(49, 'Marianna', 'Kochanek', 'Chirurg', '592598789', 11),
(50, 'Bogumir', 'Kuryło', 'Archeolog', '172815558', 6);

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

--
-- Dumping data for table `Oddzialy`
--

INSERT INTO `Oddzialy` (`ID_Oddzialu`, `Budynek`, `Sektor`, `Ulica`) VALUES
(1, 'A0', 'Kardiologia', 'ul. Jeżowa 10'),
(2, 'A2', 'Stomatologia', 'ul. Szpitalna 5'),
(3, 'A5', 'Chirurgia', 'ul. Kapitańska 2'),
(4, 'A2', 'Stomatologia', 'ul. Francuska 11'),
(5, 'A4', 'Neurologia', 'ul. Niemiecka 8'),
(6, 'A0', 'Kardiologia', 'ul. Czarnogórska 16'),
(7, 'A3', 'Operacyjny', 'ul. Nigeryjska 43'),
(8, 'A2', 'Stomatologia', 'ul. Czadowa 16'),
(9, 'A4', 'Neurologia', 'ul. Algierska 65'),
(10, 'A6', 'Pediatria', 'ul. Senegalska 19'),
(11, 'A7', 'Rehabilitacja', 'ul. Dżibutańska 15'),
(12, 'A0', 'Kardiologia', 'ul. Jeżowa 11'),
(13, 'A1', 'Cuckoldia', 'ul. Szpitalna 6'),
(14, 'A6', 'Pediatria', 'ul. Kapitańska 3'),
(15, 'A0', 'Kardiologia', 'ul. Francuska 12'),
(16, 'A4', 'Neurologia', 'ul. Niemiecka 9'),
(17, 'A2', 'Stomatologia', 'ul. Czarnogórska 17'),
(18, 'A2', 'Stomatologia', 'ul. Nigeryjska 44'),
(19, 'A1', 'Cuckoldia', 'ul. Czadowa 17'),
(20, 'A6', 'Pediatria', 'ul. Algierska 66'),
(21, 'A7', 'Rehabilitacja', 'ul. Senegalska 20'),
(22, 'A1', 'Cuckoldia', 'ul. Dżibutańska 16'),
(23, 'A7', 'Rehabilitacja', 'ul. Jeżowa 12'),
(24, 'A2', 'Stomatologia', 'ul. Szpitalna 7'),
(25, 'A4', 'Neurologia', 'ul. Kapitańska 4'),
(26, 'A4', 'Neurologia', 'ul. Francuska 13'),
(27, 'A4', 'Neurologia', 'ul. Niemiecka 10'),
(28, 'A7', 'Rehabilitacja', 'ul. Czarnogórska 18'),
(29, 'A6', 'Pediatria', 'ul. Nigeryjska 45'),
(30, 'A5', 'Chirurgia', 'ul. Czadowa 18'),
(31, 'A0', 'Kardiologia', 'ul. Algierska 67'),
(32, 'A7', 'Rehabilitacja', 'ul. Senegalska 21'),
(33, 'A2', 'Stomatologia', 'ul. Dżibutańska 17'),
(34, 'A2', 'Stomatologia', 'ul. Jeżowa 13'),
(35, 'A6', 'Pediatria', 'ul. Szpitalna 8'),
(36, 'A5', 'Chirurgia', 'ul. Kapitańska 5'),
(37, 'A7', 'Rehabilitacja', 'ul. Francuska 14'),
(38, 'A6', 'Pediatria', 'ul. Niemiecka 11'),
(39, 'A0', 'Kardiologia', 'ul. Czarnogórska 19'),
(40, 'A3', 'Operacyjny', 'ul. Nigeryjska 46'),
(41, 'A7', 'Rehabilitacja', 'ul. Czadowa 19'),
(42, 'A5', 'Chirurgia', 'ul. Algierska 68'),
(43, 'A7', 'Rehabilitacja', 'ul. Senegalska 22'),
(44, 'A3', 'Operacyjny', 'ul. Dżibutańska 18'),
(45, 'A7', 'Rehabilitacja', 'ul. Jeżowa 14'),
(46, 'A0', 'Kardiologia', 'ul. Szpitalna 9'),
(47, 'A3', 'Operacyjny', 'ul. Kapitańska 6'),
(48, 'A3', 'Operacyjny', 'ul. Francuska 15'),
(49, 'A5', 'Chirurgia', 'ul. Niemiecka 12'),
(50, 'A5', 'Chirurgia', 'ul. Czarnogórska 20');

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

--
-- Dumping data for table `Pacjenci`
--

INSERT INTO `Pacjenci` (`ID_Pacjenta`, `Imie`, `Nazwisko`, `PESEL`, `Telefon`, `Kod_Pocztowy`, `Adres`) VALUES
(1, 'Cecyl', 'Klimas', '51083161874', '473213339', '00-001', 'ul. Lipowa 23'),
(2, 'Strzeżymir', 'Kotala', '67081914796', '951915143', '00-002', 'ul. Laskowa 5'),
(3, 'Klaudiusz', 'Rogala', '75041426773', '117985887', '00-003', 'ul. Studentska 10'),
(4, 'Żarko', 'Jaskółka', '55120979534', '742673503', '00-004', 'ul. Bananowa 7'),
(5, 'Sydoniusz', 'Radzki', '99011142135', '566554938', '00-005', 'ul. Kata 9'),
(6, 'Eliot', 'Gluza', '91072441455', '959120103', '00-006', 'ul. Cuckolda 10'),
(7, 'Ernest', 'Bułat', '86111872211', '983846642', '00-007', 'ul. Karkowa 64'),
(8, 'Lubosław', 'Bryl', '76063033598', '813058543', '00-008', 'ul. Belzebuba 100'),
(9, 'Otto', 'Sykuła', '60071248851', '413017221', '00-009', 'ul. Harda 6'),
(10, 'Walter', 'Bagrowski', '61090225371', '317888689', '00-010', 'ul. Saksońska 73'),
(11, 'Faustyn', 'Korytkowski', '95091844273', '359008429', '00-011', 'ul. Rejtana 5'),
(12, 'Achilles', 'Rękas', '90072099354', '406758058', '00-012', 'ul. Sienkiewicza 1'),
(13, 'Aleksander', 'Rajski', '71092097599', '343351595', '00-013', 'ul. Niemann\'a 84'),
(14, 'Maria', 'Foks', '80122887996', '75177950', '00-014', 'ul. Papugi 112'),
(15, 'Protazy', 'Frankowski', '78030539395', '663046466', '00-015', 'ul. Policyjna 7'),
(16, 'Ksawery', 'Urban', '62031026712', '457447120', '00-016', 'ul. Strażacka 45'),
(17, 'Heliodor', 'Jokiel', '60061054237', '114201068', '00-017', 'ul. Bohaterów 90'),
(18, 'Dobrogost', 'Urbanowicz', '66012224931', '663643150', '00-018', 'ul. Karmazynowa 11'),
(19, 'Ananiasz', 'Pawlik', '75011973791', '969764877', '00-019', 'ul. Lipowa 1'),
(20, 'Ajdin', 'Aksamit', '65060346172', '291157371', '00-020', 'ul. Laskowa 76'),
(21, 'Sydoniusz', 'Wyrzykowski', '86083192432', '601121567', '00-021', 'ul. Lipowa 3'),
(22, 'Urban', 'Wolak', '97080799775', '83049989', '00-022', 'ul. Laskowa 6'),
(23, 'Herakliusz', 'Chyła', '91092582693', '533982640', '00-023', 'ul. Studentska 11'),
(24, 'Gwalbert', 'Dudziński', '92120981954', '607181123', '00-024', 'ul. Bananowa 8'),
(25, 'Zefiryn', 'Kalus', '73052562477', '875202430', '00-025', 'ul. Kata 10'),
(26, 'Aneta', 'Kosakowski', '51100446988', '959569536', '00-026', 'ul. Cuckolda 11'),
(27, 'Irmina', 'Zmysłowski', '96061191546', '116294482', '00-027', 'ul. Karkowa 65'),
(28, 'Błażena', 'Kraus', '82120364882', '894530410', '00-028', 'ul. Belzebuba 101'),
(29, 'Sędzisława', 'Paradowski', '6252265589', '267431100', '00-029', 'ul. Harda 7'),
(30, 'Sydonia', 'Iwanowicz', '81100281926', '123868779', '00-030', 'ul. Saksońska 74'),
(31, 'Magdalena', 'Pączek', '97052194766', '951471817', '00-031', 'ul. Rejtana 6'),
(32, 'Klara', 'Błachnio', '60103154383', '760184794', '00-032', 'ul. Sienkiewicza 2'),
(33, 'Kalina', 'Piorun', '50122425885', '888641875', '00-033', 'ul. Niemann\'a 85'),
(34, 'Tatiana', 'Marciniec', '64031916266', '596948370', '00-034', 'ul. Papugi 113'),
(35, 'Maksyma', 'Wierzchowski', '59042573849', '99045577', '00-035', 'ul. Policyjna 8'),
(36, 'Iga', 'Barszcz', '86040486327', '516174489', '00-036', 'ul. Strażacka 46'),
(37, 'Bogusława', 'Olech', '62120283486', '813947945', '00-037', 'ul. Bohaterów 91'),
(38, 'Kiliana', 'Dudkowski', '64081932584', '636770765', '00-038', 'ul. Karmazynowa 12'),
(39, 'Cinosława', 'Kula', '83122429481', '665374740', '00-039', 'ul. Lipowa 75'),
(40, 'Saloma', 'Kunc', '58021855923', '479277118', '00-040', 'ul. Laskowa 71'),
(41, 'Ksawera', 'Chmieliński', '53073075228', '282233655', '00-041', 'ul. Lipowa 43'),
(42, 'Judyta', 'Majcherek', '6233085281', '460710781', '00-042', 'ul. Laskowa 7'),
(43, 'Stanisława', 'Lisewski', '99050693247', '446985866', '00-043', 'ul. Studentska 12'),
(44, 'Aleksa', 'Grzesik', '48091652764', '798426982', '00-044', 'ul. Bananowa 9'),
(45, 'Fabiana', 'Kurdziel', '57010161124', '711605601', '00-045', 'ul. Kata 11'),
(46, 'Amina', 'Karczewski', '64012281949', '350271629', '00-046', 'ul. Cuckolda 12'),
(47, 'Delfina', 'Sikora', '91051844226', '264578035', '00-047', 'ul. Karkowa 66'),
(48, 'Najmiła', 'Łysik', '84091953986', '745562697', '00-048', 'ul. Belzebuba 102'),
(49, 'Karola', 'Masternak', '56112922666', '850208181', '00-049', 'ul. Harda 8'),
(50, 'Elwira', 'Płachta', '75021569582', '607378376', '00-050', 'ul. Saksońska 75'),
(51, 'Wojciech', 'Olejko', '12123412354', '999222000', '32423', 'Rzeszów Zalesie'),
(52, 'Tomasz', 'Nowak', '21212113143', '345435436', '22-555', 'ul. Ciupapi 23');

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

--
-- Dumping data for table `Pielegniarki`
--

INSERT INTO `Pielegniarki` (`ID_Pielegniarki`, `Imie`, `Nazwisko`, `Telefon`, `ID_Oddzialu`) VALUES
(1, 'Teodozja', 'Żabińska', '841289368', 5),
(2, 'Sulibor', 'Mączka', '256048159', 32),
(3, 'Odon', 'Karbowiak', '600359173', 36),
(4, 'Konradyn', 'Leśniowski', '2713444', 43),
(5, 'Lilianna', 'Franke', '995048417', 24),
(6, 'Farida', 'Jóźwik', '797208801', 28),
(7, 'Jaromir', 'Kunc', '753591285', 15),
(8, 'Janina', 'Bator', '317347450', 13),
(9, 'Kordian', 'Skawiński', '25211785', 31),
(10, 'Przemysława', 'Pogorzelska', '420080177', 8),
(11, 'Miroda', 'Jędrychowska', '850811556', 43),
(12, 'Miłosz', 'Deptuła', '746959103', 43),
(13, 'Szczepan', 'Młynarski', '792290081', 45),
(14, 'Edward', 'Stefaniuk', '28598170', 16),
(15, 'Wanda', 'Mech', '579748502', 30),
(16, 'Filipa', 'Janczyk', '259777755', 11),
(17, 'Lucjola', 'Sówka', '4597933', 4),
(18, 'Weridiana', 'Łęcki', '731491235', 3),
(19, 'Jarema', 'Komosa', '583136199', 38),
(20, 'Oswald', 'Mazgaj', '261237653', 44),
(21, 'Tomiła', 'Ficek', '268478916', 28),
(22, 'Selma', 'Małolepsza', '790794698', 33),
(23, 'Zenobia', 'Ignaciuk', '358344821', 1),
(24, 'Bona', 'Dobrzyński', '233378666', 4),
(25, 'Julianda', 'Pindel', '534029852', 40),
(26, 'Maria', 'Witczak', '667587548', 36),
(27, 'Barbara', 'Karczmarczyk', '715984298', 20),
(28, 'Derwit', 'Paśnik', '598230587', 44),
(29, 'Lambert', 'Jakubowski', '400476430', 39),
(30, 'Siemowit', 'Magnuszewski', '219520467', 22),
(31, 'Stoigniew', 'Karolczyk', '770928757', 20),
(32, 'Juta', 'Gręda', '270647021', 30),
(33, 'Onufry', 'Jordan', '261017312', 22),
(34, 'Wespazjan', 'Kulak', '134331020', 45),
(35, 'Tacjana', 'Arciszewski', '613485367', 47),
(36, 'Leopold', 'Jałocha', '767199965', 18),
(37, 'Symplicjusz', 'Pluciński', '423370748', 11),
(38, 'Delfina', 'Głowiński', '316595601', 1),
(39, 'Adriana', 'Martyniak', '496884077', 38),
(40, 'Narcyz', 'Kolasa', '113579084', 23),
(41, 'Magda', 'Zarębski', '480392669', 4),
(42, 'Mariusz', 'Wierzbowski', '384895142', 35),
(43, 'Boguchwał', 'Auguścik', '142451553', 45),
(44, 'Richariusz', 'Kuśmirek', '356898627', 24),
(45, 'Tyberiusz', 'Borowa', '258088016', 5),
(46, 'Oliwia', 'Dołęga', '245287892', 45),
(47, 'Bodosław', 'Borowczak', '361637778', 2),
(48, 'Stamira', 'Rowicki', '621548310', 16),
(49, 'Pola', 'Prusaczyk', '522948170', 13),
(50, 'Roderyk', 'Kwiek', '154636561', 29);

-- --------------------------------------------------------

--
-- Stand-in structure for view `SpecjalizacjeLekarzy`
-- (See below for the actual view)
--
CREATE TABLE `SpecjalizacjeLekarzy` (
`Imie` varchar(50)
,`Nazwisko` varchar(50)
,`Specjalizacja` varchar(50)
);

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
-- Dumping data for table `Zabiegi`
--

INSERT INTO `Zabiegi` (`ID_Zabiegu`, `ID_Pacjenta`, `Rodzaj_Zabiegu`, `Data_Zabiegu`, `ID_Lekarza`) VALUES
(1, 1, 'PILNE', '2022-11-12', 41),
(2, 4, 'PILNE', '2022-11-15', 34),
(3, 1, 'PILNE', '2022-11-19', 37),
(4, 21, 'RUTYNA', '2022-12-01', 16),
(5, 21, 'RUTYNA', '2022-12-09', 25),
(6, 25, 'RUTYNA', '2022-12-17', 21),
(7, 20, 'PILNE', '2022-12-28', 25),
(8, 44, 'RUTYNA', '2023-01-26', 11),
(9, 24, 'PILNE', '2023-02-08', 26),
(10, 34, 'RUTYNA', '2023-02-09', 20),
(11, 36, 'PILNE', '2023-02-13', 29),
(12, 27, 'PILNE', '2023-02-19', 4),
(13, 30, 'RUTYNA', '2023-02-24', 40),
(14, 48, 'RUTYNA', '2023-02-27', 47),
(15, 8, 'RUTYNA', '2023-03-05', 40),
(16, 14, 'PILNE', '2023-03-07', 14),
(17, 36, 'PILNE', '2023-03-09', 37),
(18, 44, 'PILNE', '2023-03-13', 4),
(19, 43, 'PILNE', '2023-03-14', 29),
(20, 31, 'PILNE', '2023-03-16', 46),
(21, 49, 'RUTYNA', '2023-04-11', 16),
(22, 34, 'RUTYNA', '2023-04-12', 7),
(23, 32, 'RUTYNA', '2023-04-13', 33),
(24, 6, 'RUTYNA', '2023-04-21', 23),
(25, 5, 'PILNE', '2023-04-27', 1),
(26, 32, 'PILNE', '2022-11-10', 28),
(27, 27, 'RUTYNA', '2022-11-13', 28),
(28, 12, 'PILNE', '2022-11-16', 40),
(29, 1, 'PILNE', '2022-11-27', 20),
(30, 42, 'RUTYNA', '2022-11-28', 28),
(31, 9, 'RUTYNA', '2022-12-02', 2),
(32, 3, 'RUTYNA', '2022-12-14', 37),
(33, 35, 'RUTYNA', '2023-01-04', 14),
(34, 38, 'PILNE', '2023-01-06', 22),
(35, 40, 'RUTYNA', '2023-01-12', 44),
(36, 32, 'RUTYNA', '2023-01-17', 6),
(37, 6, 'PILNE', '2023-01-22', 42),
(38, 19, 'PILNE', '2023-01-30', 20),
(39, 23, 'PILNE', '2023-02-14', 32),
(40, 2, 'PILNE', '2023-02-19', 9),
(41, 20, 'RUTYNA', '2023-02-20', 13),
(42, 17, 'RUTYNA', '2023-02-24', 45),
(43, 17, 'PILNE', '2023-03-18', 27),
(44, 37, 'RUTYNA', '2023-03-22', 5),
(45, 46, 'RUTYNA', '2023-03-23', 31),
(46, 39, 'PILNE', '2023-03-24', 11),
(47, 22, 'RUTYNA', '2023-04-02', 47),
(48, 9, 'RUTYNA', '2023-04-11', 32),
(49, 23, 'PILNE', '2023-04-13', 31),
(50, 40, 'PILNE', '2023-04-21', 17);

-- --------------------------------------------------------

--
-- Structure for view `SpecjalizacjeLekarzy`
--
DROP TABLE IF EXISTS `SpecjalizacjeLekarzy`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `SpecjalizacjeLekarzy`  AS SELECT `Lekarze`.`Imie` AS `Imie`, `Lekarze`.`Nazwisko` AS `Nazwisko`, `Lekarze`.`Specjalizacja` AS `Specjalizacja` FROM `Lekarze` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Lekarze`
--
ALTER TABLE `Lekarze`
  ADD PRIMARY KEY (`ID_Lekarza`);

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
