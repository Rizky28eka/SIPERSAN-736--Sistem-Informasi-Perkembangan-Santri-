-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: 127.0.0.1    Database: sipersan
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

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
-- Table structure for table `academic_years`
--

DROP TABLE IF EXISTS `academic_years`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `academic_years` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(20) NOT NULL,
  `semester` enum('1','2') NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `academic_years`
--

LOCK TABLES `academic_years` WRITE;
/*!40000 ALTER TABLE `academic_years` DISABLE KEYS */;
INSERT INTO `academic_years` VALUES (1,'2024/2025','1','active','2026-05-06 09:36:27','2026-05-06 09:36:27');
/*!40000 ALTER TABLE `academic_years` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `activity` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,1,'Tambah Pengumuman','Menerbitkan pengumuman baru: Masuk','2026-05-06 11:22:40'),(2,1,'Tambah Pengumuman','Menerbitkan pengumuman baru: Besok Razia','2026-05-06 11:23:29'),(3,1,'Tambah Pengumuman','Menerbitkan pengumuman baru: Perkumpulan Wali Santri','2026-05-06 11:24:13'),(4,1,'Update Kelas','Memperbarui data kelas: Paket C','2026-05-06 11:24:45');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `target_role` enum('all','guru','wali') NOT NULL DEFAULT 'all',
  `created_by` int(11) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (1,'Libur Menyambut Ramadhan 1446 H','Diberitahukan kepada seluruh wali santri bahwa kegiatan belajar mengajar akan diliburkan mulai tanggal 1 s/d 3 Ramadhan.','all',1,'2026-05-06 09:36:31',NULL),(2,'Pemeriksaan Kesehatan Rutin','Akan dilaksanakan pemeriksaan kesehatan gigi dan mulut bagi seluruh santri pada hari Sabtu depan. Harap santri sarapan terlebih dahulu.','all',1,'2026-05-04 09:36:31',NULL),(3,'Laporan Perkembangan Bulanan','Raport bulanan sudah dapat diakses melalui dashboard wali masing-masing mulai hari ini.','wali',1,'2026-05-01 09:36:31',NULL),(4,'Rapat Koordinasi Pengajar','Diharapkan kehadirannya untuk seluruh asatidz pada rapat bulanan hari Jumat ini pukul 13.00.','guru',1,'2026-05-05 09:36:31',NULL),(5,'libur','libur','all',1,'2026-05-06 09:39:19','2026-05-06 09:39:19'),(6,'Libur','Libur','all',1,'2026-05-06 10:59:11','2026-05-06 10:59:11'),(7,'Libur','Libur','all',1,'2026-05-06 11:10:11','2026-05-06 11:10:11'),(8,'Masuk','Besok Masuk Gaada Libur','all',1,'2026-05-06 11:22:40','2026-05-06 11:22:40'),(9,'Besok Razia','Besok Razia','guru',1,'2026-05-06 11:23:29','2026-05-06 11:23:29'),(10,'Perkumpulan Wali Santri','...','wali',1,'2026-05-06 11:24:13','2026-05-06 11:24:13');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `santri_id` int(11) unsigned NOT NULL,
  `academic_year_id` int(11) unsigned NOT NULL,
  `date` date NOT NULL,
  `status` enum('Hadir','Sakit','Izin','Alpa') NOT NULL DEFAULT 'Hadir',
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (1,1,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(2,1,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(3,1,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(4,1,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(5,1,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(6,1,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(7,1,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(8,2,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(9,2,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(10,2,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(11,2,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(12,2,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(13,2,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(14,2,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(15,3,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(16,3,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(17,3,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(18,3,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(19,3,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(20,3,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(21,3,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(22,4,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(23,4,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(24,4,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(25,4,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(26,4,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(27,4,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(28,4,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(29,5,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(30,5,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(31,5,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(32,5,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(33,5,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(34,5,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(35,5,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(36,6,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31','2026-05-06 09:40:10'),(37,6,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(38,6,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(39,6,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(40,6,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(41,6,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(42,6,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(43,7,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(44,7,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(45,7,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(46,7,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(47,7,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(48,7,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(49,7,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(50,8,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(51,8,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(52,8,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(53,8,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(54,8,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(55,8,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(56,8,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(57,9,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(58,9,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(59,9,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(60,9,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(61,9,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(62,9,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(63,9,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(64,10,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(65,10,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(66,10,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(67,10,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(68,10,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(69,10,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(70,10,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(71,11,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31','2026-05-06 09:40:10'),(72,11,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(73,11,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(74,11,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(75,11,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(76,11,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(77,11,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(78,12,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(79,12,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(80,12,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(81,12,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(82,12,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(83,12,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(84,12,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(85,13,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(86,13,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(87,13,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(88,13,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(89,13,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(90,13,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(91,13,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(92,14,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(93,14,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(94,14,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(95,14,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(96,14,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(97,14,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(98,14,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(99,15,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(100,15,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(101,15,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(102,15,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(103,15,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(104,15,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(105,15,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(106,16,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31','2026-05-06 09:40:10'),(107,16,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(108,16,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(109,16,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(110,16,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(111,16,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(112,16,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(113,17,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(114,17,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(115,17,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(116,17,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(117,17,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(118,17,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(119,17,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(120,18,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(121,18,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(122,18,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(123,18,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(124,18,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(125,18,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(126,18,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(127,19,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(128,19,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(129,19,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(130,19,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(131,19,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(132,19,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(133,19,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(134,20,1,'2026-05-06','Hadir','Hadir','2026-05-06 09:36:31',NULL),(135,20,1,'2026-05-05','Hadir','Hadir','2026-05-06 09:36:31',NULL),(136,20,1,'2026-05-04','Hadir','Hadir','2026-05-06 09:36:31',NULL),(137,20,1,'2026-05-03','Hadir','Hadir','2026-05-06 09:36:31',NULL),(138,20,1,'2026-05-02','Hadir','Hadir','2026-05-06 09:36:31',NULL),(139,20,1,'2026-05-01','Hadir','Hadir','2026-05-06 09:36:31',NULL),(140,20,1,'2026-04-30','Hadir','Hadir','2026-05-06 09:36:31',NULL),(141,22,1,'2026-05-06','Hadir','','2026-05-06 11:02:01','2026-05-06 11:02:01'),(142,23,1,'2026-05-06','Hadir','','2026-05-06 11:10:37','2026-05-06 11:10:37');
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `teacher_id` int(11) unsigned DEFAULT NULL,
  `spp_price` decimal(10,2) DEFAULT 200000.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,'Tahfidz - Al Jazar',2,50000000.00,'2026-05-06 09:36:31','2026-05-06 10:24:46'),(2,'Ibtidaiyah - Al Khawarizmi',3,2000000.00,'2026-05-06 09:36:31','2026-05-06 10:58:57'),(3,'Persiapan - Al Battani',4,20000000.00,'2026-05-06 09:36:31','2026-05-06 10:25:13'),(4,'Lanjutan - Ibn Sina',5,2000000.00,'2026-05-06 09:36:31','2026-05-06 10:25:16'),(5,'Khusus - Al Biruni',6,200000.00,'2026-05-06 09:36:31','2026-05-06 10:25:20'),(8,'Paket C',26,300000.00,'2026-05-06 11:08:41','2026-05-06 11:24:45');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `development`
--

DROP TABLE IF EXISTS `development`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `development` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `santri_id` int(11) unsigned NOT NULL,
  `academic_year_id` int(11) unsigned NOT NULL,
  `extracurricular` text DEFAULT NULL,
  `personality` text DEFAULT NULL,
  `teacher_notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `development`
--

LOCK TABLES `development` WRITE;
/*!40000 ALTER TABLE `development` DISABLE KEYS */;
INSERT INTO `development` VALUES (1,1,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(2,2,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(3,3,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(4,4,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(5,5,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(6,6,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(7,7,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(8,8,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(9,9,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(10,10,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(11,11,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(12,12,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(13,13,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(14,14,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(15,15,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(16,16,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(17,17,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(18,18,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(19,19,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL),(20,20,1,'Kaligrafi, Panahan','Sangat sopan dan disiplin.','Lanjutkan prestasimu!','2026-05-06 09:36:31',NULL);
/*!40000 ALTER TABLE `development` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grades` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `santri_id` int(11) unsigned NOT NULL,
  `academic_year_id` int(11) unsigned NOT NULL,
  `category` varchar(100) NOT NULL,
  `score_numeric` decimal(5,2) NOT NULL DEFAULT 0.00,
  `score_letter` varchar(5) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grades`
--

LOCK TABLES `grades` WRITE;
/*!40000 ALTER TABLE `grades` DISABLE KEYS */;
INSERT INTO `grades` VALUES (1,1,1,'Tahfidz',80.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(2,1,1,'Iqro',93.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(3,1,1,'Adab',86.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(4,1,1,'Doa',75.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(5,1,1,'Fiqih',81.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(6,1,1,'Bahasa Arab',77.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(7,2,1,'Tahfidz',78.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(8,2,1,'Iqro',85.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(9,2,1,'Adab',89.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(10,2,1,'Doa',76.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(11,2,1,'Fiqih',90.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(12,2,1,'Bahasa Arab',93.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(13,3,1,'Tahfidz',95.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(14,3,1,'Iqro',81.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(15,3,1,'Adab',91.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(16,3,1,'Doa',98.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(17,3,1,'Fiqih',92.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(18,3,1,'Bahasa Arab',89.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(19,4,1,'Tahfidz',75.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(20,4,1,'Iqro',87.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(21,4,1,'Adab',97.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(22,4,1,'Doa',87.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(23,4,1,'Fiqih',90.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(24,4,1,'Bahasa Arab',96.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(25,5,1,'Tahfidz',84.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(26,5,1,'Iqro',82.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(27,5,1,'Adab',88.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(28,5,1,'Doa',86.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(29,5,1,'Fiqih',96.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(30,5,1,'Bahasa Arab',78.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(31,6,1,'Tahfidz',96.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(32,6,1,'Iqro',81.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(33,6,1,'Adab',75.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(34,6,1,'Doa',92.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(35,6,1,'Fiqih',79.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(36,6,1,'Bahasa Arab',95.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(37,7,1,'Tahfidz',81.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(38,7,1,'Iqro',85.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(39,7,1,'Adab',90.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(40,7,1,'Doa',96.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(41,7,1,'Fiqih',85.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(42,7,1,'Bahasa Arab',78.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(43,8,1,'Tahfidz',88.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(44,8,1,'Iqro',83.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(45,8,1,'Adab',89.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(46,8,1,'Doa',86.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(47,8,1,'Fiqih',78.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(48,8,1,'Bahasa Arab',91.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(49,9,1,'Tahfidz',85.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(50,9,1,'Iqro',90.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(51,9,1,'Adab',79.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(52,9,1,'Doa',93.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(53,9,1,'Fiqih',94.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(54,9,1,'Bahasa Arab',87.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(55,10,1,'Tahfidz',98.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(56,10,1,'Iqro',77.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(57,10,1,'Adab',96.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(58,10,1,'Doa',95.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(59,10,1,'Fiqih',78.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(60,10,1,'Bahasa Arab',94.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(61,11,1,'Tahfidz',80.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(62,11,1,'Iqro',87.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(63,11,1,'Adab',96.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(64,11,1,'Doa',76.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(65,11,1,'Fiqih',96.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(66,11,1,'Bahasa Arab',75.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(67,12,1,'Tahfidz',86.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(68,12,1,'Iqro',79.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(69,12,1,'Adab',77.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(70,12,1,'Doa',75.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(71,12,1,'Fiqih',87.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(72,12,1,'Bahasa Arab',94.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(73,13,1,'Tahfidz',96.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(74,13,1,'Iqro',76.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(75,13,1,'Adab',77.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(76,13,1,'Doa',93.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(77,13,1,'Fiqih',85.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(78,13,1,'Bahasa Arab',88.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(79,14,1,'Tahfidz',76.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(80,14,1,'Iqro',88.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(81,14,1,'Adab',78.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(82,14,1,'Doa',81.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(83,14,1,'Fiqih',94.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(84,14,1,'Bahasa Arab',89.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(85,15,1,'Tahfidz',97.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(86,15,1,'Iqro',81.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(87,15,1,'Adab',92.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(88,15,1,'Doa',75.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(89,15,1,'Fiqih',87.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(90,15,1,'Bahasa Arab',98.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(91,16,1,'Tahfidz',84.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(92,16,1,'Iqro',96.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(93,16,1,'Adab',87.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(94,16,1,'Doa',94.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(95,16,1,'Fiqih',96.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(96,16,1,'Bahasa Arab',86.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(97,17,1,'Tahfidz',77.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(98,17,1,'Iqro',97.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(99,17,1,'Adab',97.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(100,17,1,'Doa',85.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(101,17,1,'Fiqih',94.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(102,17,1,'Bahasa Arab',87.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(103,18,1,'Tahfidz',90.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(104,18,1,'Iqro',86.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(105,18,1,'Adab',76.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(106,18,1,'Doa',87.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(107,18,1,'Fiqih',84.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(108,18,1,'Bahasa Arab',95.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(109,19,1,'Tahfidz',85.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(110,19,1,'Iqro',82.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(111,19,1,'Adab',88.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(112,19,1,'Doa',92.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(113,19,1,'Fiqih',97.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(114,19,1,'Bahasa Arab',82.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(115,20,1,'Tahfidz',90.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(116,20,1,'Iqro',97.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(117,20,1,'Adab',92.00,'A','Sangat baik','2026-05-06 09:36:31',NULL),(118,20,1,'Doa',77.00,'C','Sangat baik','2026-05-06 09:36:31',NULL),(119,20,1,'Fiqih',88.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(120,20,1,'Bahasa Arab',83.00,'B','Sangat baik','2026-05-06 09:36:31',NULL),(121,6,1,'Iqro/Tahsin',100.00,'A','','2026-05-06 09:39:52','2026-05-06 09:39:52'),(122,11,1,'Iqro/Tahsin',100.00,'A','','2026-05-06 09:39:52','2026-05-06 09:39:52'),(123,16,1,'Iqro/Tahsin',100.00,'A','','2026-05-06 09:39:52','2026-05-06 09:39:52'),(124,22,1,'Iqro/Tahsin',100.00,'A','','2026-05-06 11:01:54','2026-05-06 11:01:56'),(125,23,1,'Iqro/Tahsin',100.00,'A','','2026-05-06 11:10:33','2026-05-06 11:10:33'),(126,23,1,'Hafalan Surat',80.00,'B','','2026-05-06 11:11:37','2026-05-06 11:11:37'),(127,23,1,'Doa Sehari-hari',10.00,'E','','2026-05-06 11:11:43','2026-05-06 11:11:43'),(128,23,1,'Praktik Sholat',20.00,'E','','2026-05-06 11:11:48','2026-05-06 11:11:48'),(129,23,1,'Hadist',100.00,'A','','2026-05-06 11:11:55','2026-05-06 11:11:55'),(130,23,1,'Bahasa Arab',80.00,'B','','2026-05-06 11:12:00','2026-05-06 11:12:00'),(131,23,1,'Bahasa Inggris',75.00,'C','','2026-05-06 11:12:05','2026-05-06 11:12:05');
/*!40000 ALTER TABLE `grades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (9,'2026-05-05-104936','App\\Database\\Migrations\\CreateUsersTable','default','App',1778043906,1),(10,'2026-05-05-104945','App\\Database\\Migrations\\CreateAcademicYearsTable','default','App',1778043906,1),(11,'2026-05-05-104945','App\\Database\\Migrations\\CreateAnnouncementsTable','default','App',1778043906,1),(12,'2026-05-05-104945','App\\Database\\Migrations\\CreateAttendanceTable','default','App',1778043906,1),(13,'2026-05-05-104945','App\\Database\\Migrations\\CreateClassesTable','default','App',1778043906,1),(14,'2026-05-05-104945','App\\Database\\Migrations\\CreateDevelopmentTable','default','App',1778043906,1),(15,'2026-05-05-104945','App\\Database\\Migrations\\CreateGradesTable','default','App',1778043906,1),(16,'2026-05-05-104945','App\\Database\\Migrations\\CreateSantriTable','default','App',1778043906,1),(17,'2026-05-06-164421','App\\Database\\Migrations\\CreateSppPaymentsTable','default','App',1778060765,2),(18,'2026-05-06-165533','App\\Database\\Migrations\\UpdateSppPaymentsTable','default','App',1778061390,3),(19,'2026-05-06-165617','App\\Database\\Migrations\\CreateSppHistoryTable','default','App',1778061390,3),(20,'2026-05-06-170340','App\\Database\\Migrations\\AddSppPriceToClasses','default','App',1778061865,4),(21,'2026-05-06-105532','App\\Database\\Migrations\\MakeEmailNullableInUsers','default','App',1778064955,5),(22,'2026-05-06-111729','App\\Database\\Migrations\\CreateActivityLogsTable','default','App',1778066266,6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `santri`
--

DROP TABLE IF EXISTS `santri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `santri` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `class_id` int(11) unsigned NOT NULL,
  `wali_id` int(11) unsigned DEFAULT NULL,
  `gender` enum('L','P') NOT NULL,
  `address` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `santri`
--

LOCK TABLES `santri` WRITE;
/*!40000 ALTER TABLE `santri` DISABLE KEYS */;
INSERT INTO `santri` VALUES (2,'Annisa Rahmawati','2024002',2,8,'P','Jl. Pendidikan No. 2','2026-05-06 09:36:31',NULL),(3,'Hamzah bin Abdul Muthalib','2024003',3,9,'L','Jl. Pendidikan No. 3','2026-05-06 09:36:31',NULL),(4,'Zaidan Al-Ghifari','2024004',4,10,'P','Jl. Pendidikan No. 4','2026-05-06 09:36:31',NULL),(5,'Aisyah Humaira','2024005',5,11,'L','Jl. Pendidikan No. 5','2026-05-06 09:36:31',NULL),(6,'Bilal bin Rabah','2024006',1,12,'P','Jl. Pendidikan No. 6','2026-05-06 09:36:31',NULL),(7,'Yusuf Mansur Jr.','2024007',2,13,'L','Jl. Pendidikan No. 7','2026-05-06 09:36:31',NULL),(8,'Maryam Azzahra','2024008',3,14,'P','Jl. Pendidikan No. 8','2026-05-06 09:36:31',NULL),(9,'Ibrahim Khalil','2024009',4,15,'L','Jl. Pendidikan No. 9','2026-05-06 09:36:31',NULL),(10,'Sarah Sholiha','2024010',5,16,'P','Jl. Pendidikan No. 10','2026-05-06 09:36:31',NULL),(11,'Hasan Al-Banna','2024011',1,7,'L','Jl. Pendidikan No. 11','2026-05-06 09:36:31',NULL),(12,'Husain Al-Mujtaba','2024012',2,8,'P','Jl. Pendidikan No. 12','2026-05-06 09:36:31',NULL),(13,'Khairunnisa','2024013',3,9,'L','Jl. Pendidikan No. 13','2026-05-06 09:36:31',NULL),(14,'Raihan Ananda','2024014',4,10,'P','Jl. Pendidikan No. 14','2026-05-06 09:36:31',NULL),(15,'Thariq bin Ziyad','2024015',5,11,'L','Jl. Pendidikan No. 15','2026-05-06 09:36:31',NULL),(16,'Khalid bin Walid','2024016',1,12,'P','Jl. Pendidikan No. 16','2026-05-06 09:36:31',NULL),(17,'Sumayyah binti Khayyat','2024017',2,13,'L','Jl. Pendidikan No. 17','2026-05-06 09:36:31',NULL),(18,'Umar bin Abdul Aziz','2024018',3,14,'P','Jl. Pendidikan No. 18','2026-05-06 09:36:31',NULL),(19,'Abdurrahman bin Auf','2024019',4,15,'L','Jl. Pendidikan No. 19','2026-05-06 09:36:31',NULL),(20,'Usman bin Affan','2024020',5,16,'P','Jl. Pendidikan No. 20','2026-05-06 09:36:31',NULL),(23,'Santri 2','121212121',8,25,'P','Rumah','2026-05-06 11:08:59','2026-05-06 11:09:04');
/*!40000 ALTER TABLE `santri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spp_history`
--

DROP TABLE IF EXISTS `spp_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spp_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `spp_payment_id` int(11) unsigned NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_date` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spp_history_spp_payment_id_foreign` (`spp_payment_id`),
  CONSTRAINT `spp_history_spp_payment_id_foreign` FOREIGN KEY (`spp_payment_id`) REFERENCES `spp_payments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spp_history`
--

LOCK TABLES `spp_history` WRITE;
/*!40000 ALTER TABLE `spp_history` DISABLE KEYS */;
INSERT INTO `spp_history` VALUES (1,5,20000.00,'2026-05-06 10:26:05','2026-05-06 10:26:05','2026-05-06 10:26:05'),(2,13,200000.00,'2026-05-06 10:34:38','2026-05-06 10:34:38','2026-05-06 10:34:38'),(3,20,200000.00,'2026-05-06 11:11:03','2026-05-06 11:11:03','2026-05-06 11:11:03'),(4,20,100000.00,'2026-05-06 11:11:14','2026-05-06 11:11:14','2026-05-06 11:11:14');
/*!40000 ALTER TABLE `spp_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spp_payments`
--

DROP TABLE IF EXISTS `spp_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spp_payments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `santri_id` int(11) unsigned NOT NULL,
  `month` int(2) NOT NULL,
  `year` int(4) NOT NULL,
  `due_date` date DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 200000.00,
  `total_paid` decimal(10,2) DEFAULT 0.00,
  `status` enum('belum','lunas','nunggak','cicilan') DEFAULT 'belum',
  `payment_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spp_payments_santri_id_foreign` (`santri_id`),
  CONSTRAINT `spp_payments_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spp_payments`
--

LOCK TABLES `spp_payments` WRITE;
/*!40000 ALTER TABLE `spp_payments` DISABLE KEYS */;
INSERT INTO `spp_payments` VALUES (1,3,5,2026,NULL,200000.00,0.00,'lunas','2026-05-06 09:49:56','2026-05-06 09:49:50','2026-05-06 09:49:56'),(2,13,5,2026,NULL,200000.00,0.00,'lunas','2026-05-06 09:50:00','2026-05-06 09:49:50','2026-05-06 09:50:00'),(3,11,5,2026,NULL,200000.00,0.00,'lunas','2026-05-06 09:51:20','2026-05-06 09:51:19','2026-05-06 09:51:20'),(4,2,5,2026,'2026-05-10',2000000.00,0.00,'belum',NULL,'2026-05-06 09:57:05','2026-05-06 09:57:05'),(5,4,5,2026,'2026-05-10',2000000.00,20000.00,'cicilan',NULL,'2026-05-06 09:57:05','2026-05-06 10:26:05'),(6,5,5,2026,'2026-05-10',200000.00,0.00,'belum',NULL,'2026-05-06 09:57:05','2026-05-06 09:57:05'),(7,6,5,2026,'2026-05-10',50000000.00,0.00,'belum',NULL,'2026-05-06 09:57:05','2026-05-06 09:57:05'),(8,7,5,2026,'2026-05-10',2000000.00,0.00,'belum',NULL,'2026-05-06 09:57:05','2026-05-06 09:57:05'),(9,8,5,2026,'2026-05-10',20000000.00,0.00,'belum',NULL,'2026-05-06 09:57:05','2026-05-06 09:57:05'),(10,9,5,2026,'2026-05-10',2000000.00,0.00,'belum',NULL,'2026-05-06 09:57:05','2026-05-06 09:57:05'),(11,10,5,2026,'2026-05-10',200000.00,0.00,'belum',NULL,'2026-05-06 09:57:05','2026-05-06 09:57:05'),(12,12,5,2026,'2026-05-10',2000000.00,0.00,'belum',NULL,'2026-05-06 09:57:05','2026-05-06 09:57:05'),(13,14,5,2026,'2026-05-10',2000000.00,200000.00,'cicilan',NULL,'2026-05-06 09:57:05','2026-05-06 10:34:38'),(14,15,5,2026,'2026-05-10',200000.00,0.00,'belum',NULL,'2026-05-06 09:57:05','2026-05-06 09:57:05'),(15,16,5,2026,'2026-05-10',50000000.00,0.00,'belum',NULL,'2026-05-06 09:57:05','2026-05-06 09:57:05'),(16,17,5,2026,'2026-05-10',2000000.00,0.00,'belum',NULL,'2026-05-06 09:57:05','2026-05-06 09:57:05'),(17,18,5,2026,'2026-05-10',20000000.00,0.00,'belum',NULL,'2026-05-06 09:57:05','2026-05-06 09:57:05'),(18,19,5,2026,'2026-05-10',2000000.00,0.00,'belum',NULL,'2026-05-06 09:57:05','2026-05-06 09:57:05'),(19,20,5,2026,'2026-05-10',200000.00,0.00,'belum',NULL,'2026-05-06 09:57:05','2026-05-06 09:57:05'),(20,23,5,2026,'2026-05-10',300000.00,300000.00,'lunas','2026-05-06 11:11:14','2026-05-06 11:08:59','2026-05-06 11:11:14');
/*!40000 ALTER TABLE `spp_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('kepala','guru','wali') NOT NULL DEFAULT 'wali',
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@sipersan.com','$2y$12$HBQZTrnCQS8uf22IfO56COCX3lG/YXCMjk7CF/YtGv1BdZSc/HB.2','kepala','Drs. H. Ahmad Fauzi, M.Pd.I',NULL,'2026-05-06 09:36:28',NULL),(2,'mansur','mansur@pesantren.com','$2y$12$CcMC/bvLzp58Azw0NNYGZeskbkygzUk6Y/gkoMOIHmnRcxm.hNuY2','guru','Ustadz Mansur Al-Hafiz',NULL,'2026-05-06 09:36:28',NULL),(3,'maryam','maryam@pesantren.com','$2y$12$EcAbd77ZsOm/PQz0ypgj8.75VchC9aEHlxoTf3APEruVX3ncOA5hm','guru','Ustadzah Siti Maryam, S.Ag',NULL,'2026-05-06 09:36:28',NULL),(4,'zaki','zaki@pesantren.com','$2y$12$Nzg/M9I21xkS/up0/PtDeOuy7uQLoSh9Zo.UpLVifC.HIqZK93HG2','guru','Ustadz Zaki Mubarok',NULL,'2026-05-06 09:36:28',NULL),(5,'nurul','nurul@pesantren.com','$2y$12$eYNDeyK0lG3Z2KX0Eu2TguB4Hwpsocte0.CnmzKBFD9jh7AM6PhPC','guru','Ustadzah Nurul Hidayah',NULL,'2026-05-06 09:36:28',NULL),(6,'somad','somad@pesantren.com','$2y$12$127csBoT/uXCvK.kaY6eVeQHScJrlWBOvfNBRW7iZoynnNjp8w6NK','guru','Ustadz Abdul Somad',NULL,'2026-05-06 09:36:29',NULL),(7,'wali1','wali1@gmail.com','$2y$12$BCGYmJsZc0QO4k7yFCGqmOMrW.2vu.vzGagOLdBAqpe6zQg0D6y.a','wali','Ir. Bambang Susanto',NULL,'2026-05-06 09:36:29',NULL),(8,'wali2','wali2@gmail.com','$2y$12$PDpYHOBLEJVeTRcfcs6foOkxQucv.TJO.9KQpfZAoZFrZxnfUWWVK','wali','Dr. Ratna Sari',NULL,'2026-05-06 09:36:29',NULL),(9,'wali3','wali3@gmail.com','$2y$12$xRHjj1vHNsnJHJlIYtN9Xerxkb4vxqTW9ZYHz7pyJ2p2mlWzfDHOC','wali','H. Mulyadi, S.E',NULL,'2026-05-06 09:36:29',NULL),(10,'wali4','wali4@gmail.com','$2y$12$ldo6VtmqL7CENZVrPVZquuf.5w6pVgK/St9Az.83BH/NOW3wMHSyO','wali','Siti Aminah, M.Pd',NULL,'2026-05-06 09:36:30',NULL),(11,'wali5','wali5@gmail.com','$2y$12$IjeQIOGZaV4uraeiMYX.5OAbor2VqNcodbRejQjzV4I041W/zs/zS','wali','Budi Setiawan',NULL,'2026-05-06 09:36:30',NULL),(12,'wali6','wali6@gmail.com','$2y$12$y1eZR3HOBOANL2nkP9cNCuTKxfcZQnWglR2DPj8Qs6YbOo62WZmq2','wali','Ani Wijaya',NULL,'2026-05-06 09:36:30',NULL),(13,'wali7','wali7@gmail.com','$2y$12$M2PAUs9vn38VrXWLNhZ5I.0rmdB5MothZJIHdLdthTkasPMqXH8iy','wali','Hendra Kurniawan',NULL,'2026-05-06 09:36:30',NULL),(14,'wali8','wali8@gmail.com','$2y$12$Oe/Sp2v4g4gtgg8Vp94bWeZc/6ZiaCqnzSm6izEMveHRAV/nxVOYe','wali','Dewi Lestari',NULL,'2026-05-06 09:36:30',NULL),(15,'wali9','wali9@gmail.com','$2y$12$Stu/ylKYx91cN54ZxlLmn.05PfU.cv1e9FvhdvBhYA/dsfZyPHEOi','wali','Agus Saputra',NULL,'2026-05-06 09:36:31',NULL),(16,'wali10','wali10@gmail.com','$2y$12$PZOVGyqbkx3cZw8Q812DsOCibiVt/B0gbgKcCc4Bhy2zDeFsim/4W','wali','Rina Pratama',NULL,'2026-05-06 09:36:31',NULL),(23,'hasyim123',NULL,'$2y$12$I132.Otz.M4WZx2KR4323u0l5vVhgBzQl0lqhGIHB1H3eSSjFXr8G','guru','Haysim as',NULL,'2026-05-06 10:58:00','2026-05-06 10:58:07'),(25,'hasyim12345',NULL,'$2y$12$a2cAyl94vNOCme39hm/M7OQjqqIr4I.wd6zsACH8fWTk91ccF9Z.u','wali','Hasyim',NULL,'2026-05-06 11:08:12','2026-05-06 11:08:12'),(26,'Guru123',NULL,'$2y$12$uCAQUSqCK2iOauRZDqoyL.ma61RGL/5ROvjGgN1KpLvqgTAEkIFVa','guru','Guru 1',NULL,'2026-05-06 11:08:30','2026-05-06 11:08:30');
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

-- Dump completed on 2026-05-06 20:07:30
