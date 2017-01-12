-- MySQL dump 10.13  Distrib 5.7.12, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: ep
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.20-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `artikel`
--

DROP TABLE IF EXISTS `artikel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `artikel` (
  `SIFRA_ARTIKLA` bigint(20) NOT NULL,
  `ID_SKUPINE` bigint(20) NOT NULL,
  `ID_NAROCILA` bigint(20) DEFAULT NULL,
  `NAZIV_ARTIKLA` varchar(50) NOT NULL,
  `CENA` float(10,2) NOT NULL,
  `PROIZVAJALEC` varchar(25) DEFAULT NULL,
  `ENOTA_MER` char(5) NOT NULL,
  PRIMARY KEY (`SIFRA_ARTIKLA`),
  KEY `FK_SPADA_POD` (`ID_SKUPINE`),
  KEY `FK_VSEBUJE` (`ID_NAROCILA`),
  CONSTRAINT `FK_SPADA_POD` FOREIGN KEY (`ID_SKUPINE`) REFERENCES `komercialna_skupina` (`ID_SKUPINE`),
  CONSTRAINT `FK_VSEBUJE` FOREIGN KEY (`ID_NAROCILA`) REFERENCES `narocilo` (`ID_NAROCILA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artikel`
--

LOCK TABLES `artikel` WRITE;
/*!40000 ALTER TABLE `artikel` DISABLE KEYS */;
INSERT INTO `artikel` VALUES (122,1,1,'Teleskop',500.17,'Celsteron','1'),(125,1,1,'Optična cev',123.17,'Leo','3'),(127,2,2,'Zaščitna očala',87.21,'Ray','1');
/*!40000 ALTER TABLE `artikel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dnevnik_prijav`
--

DROP TABLE IF EXISTS `dnevnik_prijav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dnevnik_prijav` (
  `ID_PRIJAVE` bigint(20) NOT NULL,
  `IP` varchar(20) DEFAULT NULL,
  `CAS_PRIJAVE` datetime NOT NULL,
  `CAS_ODJAVE` datetime NOT NULL,
  `USPESNOST` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_PRIJAVE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dnevnik_prijav`
--

LOCK TABLES `dnevnik_prijav` WRITE;
/*!40000 ALTER TABLE `dnevnik_prijav` DISABLE KEYS */;
INSERT INTO `dnevnik_prijav` VALUES (1,'69.123.21.22','2015-07-06 22:23:11','2016-07-06 22:25:01',1),(2,'52.98.223.1','2015-08-08 09:45:45','2015-08-08 09:50:32',1),(3,'123.99.50.21','2016-11-11 14:25:01','2016-11-11 14:25:01',0);
/*!40000 ALTER TABLE `dnevnik_prijav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `komercialna_skupina`
--

DROP TABLE IF EXISTS `komercialna_skupina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `komercialna_skupina` (
  `ID_SKUPINE` bigint(20) NOT NULL,
  `NAZIV_SKUPINE` varchar(25) NOT NULL,
  PRIMARY KEY (`ID_SKUPINE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `komercialna_skupina`
--

LOCK TABLES `komercialna_skupina` WRITE;
/*!40000 ALTER TABLE `komercialna_skupina` DISABLE KEYS */;
INSERT INTO `komercialna_skupina` VALUES (1,'Skupina 1'),(2,'Skupina 2'),(3,'Skupina 3');
/*!40000 ALTER TABLE `komercialna_skupina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `narocilo`
--

DROP TABLE IF EXISTS `narocilo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `narocilo` (
  `ID_NAROCILA` bigint(20) NOT NULL,
  `ID_UPORABNIK` bigint(20) NOT NULL,
  `DATUM_NAROCILA` datetime NOT NULL,
  `STATUS_NAROCILA` int(11) NOT NULL,
  `ZAPOREDNA_STEVILKA` bigint(20) NOT NULL,
  `KOLICIN_ARTIKLA` int(11) NOT NULL,
  PRIMARY KEY (`ID_NAROCILA`),
  KEY `FK_RELATIONSHIP_3` (`ID_UPORABNIK`),
  CONSTRAINT `FK_RELATIONSHIP_3` FOREIGN KEY (`ID_UPORABNIK`) REFERENCES `uporabnik` (`ID_UPORABNIK`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `narocilo`
--

LOCK TABLES `narocilo` WRITE;
/*!40000 ALTER TABLE `narocilo` DISABLE KEYS */;
INSERT INTO `narocilo` VALUES (1,1,'2015-12-12 17:43:15',1,224,2),(2,1,'2015-11-27 18:00:17',1,225,4),(3,3,'2017-01-02 22:17:28',1,226,1);
/*!40000 ALTER TABLE `narocilo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slika`
--

DROP TABLE IF EXISTS `slika`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slika` (
  `ID_SLIKE` bigint(20) NOT NULL,
  `SIFRA_ARTIKLA` bigint(20) NOT NULL,
  `IME_SLIKE` varchar(100) NOT NULL,
  `POT_SLIKE` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_SLIKE`),
  KEY `FK_RELATIONSHIP_5` (`SIFRA_ARTIKLA`),
  CONSTRAINT `FK_RELATIONSHIP_5` FOREIGN KEY (`SIFRA_ARTIKLA`) REFERENCES `artikel` (`SIFRA_ARTIKLA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slika`
--

LOCK TABLES `slika` WRITE;
/*!40000 ALTER TABLE `slika` DISABLE KEYS */;
INSERT INTO `slika` VALUES (1,122,'teleksop','../slike/teleskop.jpg'),(2,127,'očala za sonce','../slike/varnostna ocala.jpg'),(3,125,'optična cev','../slike/cev.jpg');
/*!40000 ALTER TABLE `slika` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uporabnik`
--

DROP TABLE IF EXISTS `uporabnik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uporabnik` (
  `ID_UPORABNIK` bigint(20) NOT NULL,
  `ID_PRIJAVE` bigint(20) NOT NULL,
  `TIP` int(11) NOT NULL,
  `IME` varchar(25) NOT NULL,
  `PRIIMEK` varchar(25) NOT NULL,
  `ELEKTRONSKI_NASLOV` varchar(30) NOT NULL,
  `GESLO` varchar(32) NOT NULL,
  `TELEFONSKA_STEVILKA` varchar(15) NOT NULL,
  `NASLOV` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_UPORABNIK`),
  KEY `FK_RELATIONSHIP_4` (`ID_PRIJAVE`),
  CONSTRAINT `FK_RELATIONSHIP_4` FOREIGN KEY (`ID_PRIJAVE`) REFERENCES `dnevnik_prijav` (`ID_PRIJAVE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uporabnik`
--

LOCK TABLES `uporabnik` WRITE;
/*!40000 ALTER TABLE `uporabnik` DISABLE KEYS */;
INSERT INTO `uporabnik` VALUES (1,1,1,'Jernej','Rejc','rejcjernej94@gmail.com','fbe46ae0ca687ab0267be5cca10a248b','041692842','Ljubljanska cesta 1'),(2,2,1,'Matevž','Šubic','matevz.subic@gmail.com','f96e423c863054834065a2ed536c4f50','051682771','Dunajska cesta 23b'),(3,3,2,'Vito','Simič','vito.simic@gmail.com','334c4a4c42fdb79d7ebc3e73b517e6f8','071291888','Šmarješka ulica 22c');
/*!40000 ALTER TABLE `uporabnik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'ep'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-09 20:25:56
