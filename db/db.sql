-- MySQL dump 10.14  Distrib 5.5.65-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: ipmac
-- ------------------------------------------------------
-- Server version	5.5.65-MariaDB

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
-- Table structure for table `IPMAC`
--

DROP TABLE IF EXISTS `IPMAC`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `IPMAC` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `IP` varchar(50) DEFAULT NULL,
  `MAC` char(13) DEFAULT NULL,
  `FirstSee` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastSee` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `RouterIP` char(16) DEFAULT NULL,
  `RIndex` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IPMAC_IP_LastSee` (`IP`,`LastSee`),
  KEY `IPMAC_MAC_LastSee` (`MAC`,`LastSee`),
  KEY `IPMAC_LastSee` (`LastSee`)
) ENGINE=MyISAM AUTO_INCREMENT=172954 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `IPMAC_IP_last`
--

DROP TABLE IF EXISTS `IPMAC_IP_last`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `IPMAC_IP_last` (
  `IP` varchar(50) NOT NULL DEFAULT '',
  `LastSee` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`IP`),
  KEY `key_lastsee` (`LastSee`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `IPMAC_MAC_last`
--

DROP TABLE IF EXISTS `IPMAC_MAC_last`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `IPMAC_MAC_last` (
  `MAC` char(13) NOT NULL,
  `LastSee` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`MAC`),
  KEY `key_lastsee` (`LastSee`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `IPMAC_cur`
--

DROP TABLE IF EXISTS `IPMAC_cur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `IPMAC_cur` (
  `IP` varchar(50) NOT NULL DEFAULT '',
  `MAC` char(13) DEFAULT NULL,
  `FirstSee` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastSee` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `RouterIP` char(16) DEFAULT NULL,
  PRIMARY KEY (`IP`),
  KEY `IPV6MAC_LastSee` (`LastSee`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `MACPort`
--

DROP TABLE IF EXISTS `MACPort`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MACPort` (
  `id` bigint(21) NOT NULL AUTO_INCREMENT,
  `MAC` char(13) NOT NULL DEFAULT '',
  `JHJIP` char(20) NOT NULL DEFAULT '',
  `Port` char(20) NOT NULL DEFAULT '',
  `Vlan` char(20) NOT NULL DEFAULT '',
  `FirstSee` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastSee` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `MACPORT_Last` (`LastSee`),
  KEY `MACPORT_JHJPORT` (`JHJIP`,`Port`),
  KEY `MACPORT_MJPVL` (`MAC`,`JHJIP`,`Port`,`Vlan`,`LastSee`)
) ENGINE=MyISAM AUTO_INCREMENT=203873 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `UplinkPort`
--

DROP TABLE IF EXISTS `UplinkPort`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UplinkPort` (
  `JHJIP` char(20) NOT NULL DEFAULT '',
  `Port` char(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-27  8:31:50
