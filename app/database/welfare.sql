-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: welfare
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_urlAddress` varchar(65) NOT NULL,
  `username` varchar(60) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `user_address` varchar(200) NOT NULL,
  `user_cin` varchar(15) NOT NULL,
  `user_birth_date` date NOT NULL,
  `user_password` text NOT NULL,
  `join_date` datetime NOT NULL,
  `rank` varchar(8) NOT NULL,
  `validation` varchar(10) NOT NULL,
  `verification_key` text NOT NULL,
  `verification_number` int(6) NOT NULL,
  `profile_picture` text NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_urlAddress_2` (`user_urlAddress`,`username`,`user_email`,`user_cin`),
  KEY `user_urlAddress` (`user_urlAddress`,`username`,`user_email`,`phone_number`,`user_address`,`user_cin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'jkT#n9D2y:lm:|<_zD8Q|J}e(nI5cziO>UzCFnslSuy*KW| 5yQxX8hWiM3F:auP','Abdallah Ismaili','aismaili@gmail.com','no phone','no address','df1234','2008-12-14','15dff613fffc0d4086484185859c486cbe080e6e','2022-12-06 09:11:00','costumer','1','b828b170b10b40b02b3037e543c71fe4',0,'no-profile.webp'),(2,'^tE~GLntNHd]mBvYS19D9W`tzzKaJ:@$P3a?0:e#Ic)BMk','Abdallah Ismaili','aismaili690@gmail.com','no phone','no address','df1234','2002-12-15','bc40c0285e644553833ab67ac6e491b2a6868553','2022-12-06 10:04:05','costumer','1','5818350eb49e2329f7c3faa3137f2066',0,'no-profile.webp');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-06  9:15:57
