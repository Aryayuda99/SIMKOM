-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: simkom
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `anggota`
--

DROP TABLE IF EXISTS `anggota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `anggota` (
  `id_anggota` varchar(20) NOT NULL,
  `id_user` varchar(10) DEFAULT NULL,
  `id_organisasi` varchar(10) DEFAULT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `program_studi` varchar(100) DEFAULT NULL,
  `status_keanggotaan` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_anggota`),
  KEY `fk_anggota_user` (`id_user`),
  KEY `fk_anggota_organisasi` (`id_organisasi`),
  CONSTRAINT `fk_anggota_organisasi` FOREIGN KEY (`id_organisasi`) REFERENCES `data_organisasi` (`id_organisasi`),
  CONSTRAINT `fk_anggota_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anggota`
--

LOCK TABLES `anggota` WRITE;
/*!40000 ALTER TABLE `anggota` DISABLE KEYS */;
INSERT INTO `anggota` VALUES ('O01U03','U03','O01','2400','mahasiswa03','084','SI','aktif'),('O01U21','U21','O01','2400','Anggota 01','0821','SI','aktif'),('O01U22','U22','O01','2400','Anggota 02','0822','SI','aktif'),('O01U41','U41','O01','2400','Pengurus 01','0841','SI','aktif'),('O02U23','U23','O02','2400','Anggota 03','0823','SI','aktif'),('O02U24','U24','O02','2400','Anggota 04','0824','SI','aktif'),('O02U42','U42','O02','2400','Pengurus 02','0842','SI','aktif'),('O03U25','U25','O03','2400','Anggota 05','0825','SI','aktif'),('O03U26','U26','O03','2400','Anggota 06','0826','SI','aktif'),('O03U43','U43','O03','2400','Pengurus 03','0843','SI','aktif'),('O04U27','U27','O04','2400','Anggota 07','0827','SI','aktif'),('O04U28','U28','O04','2400','Anggota 08','0828','SI','aktif'),('O04U44','U44','O04','2400','Pengurus 04','0844','SI','aktif'),('O05U29','U29','O05','2400','Anggota 09','0829','SI','aktif'),('O05U30','U30','O05','2400','Anggota 10','0830','SI','aktif'),('O05U45','U45','O05','2400','Pengurus 05','0845','SI','aktif'),('O06U31','U31','O06','2400','Anggota 11','0831','SI','aktif'),('O06U32','U32','O06','2400','Anggota 12','0832','SI','aktif'),('O06U46','U46','O06','2400','Pengurus 06','0846','SI','aktif'),('O07U33','U33','O07','2400','Anggota 13','0833','SI','aktif'),('O07U34','U34','O07','2400','Anggota 14','0834','SI','aktif'),('O07U47','U47','O07','2400','Pengurus 07','0847','SI','aktif'),('O08U35','U35','O08','2400','Anggota 15','0835','SI','aktif'),('O08U36','U36','O08','2400','Anggota 16','0836','SI','aktif'),('O08U48','U48','O08','2400','Pengurus 08','0848','SI','aktif'),('O09U37','U37','O09','2400','Anggota 17','0837','SI','aktif'),('O09U38','U38','O09','2400','Anggota 18','0838','SI','aktif'),('O09U49','U49','O09','2400','Pengurus 09','0849','SI','aktif'),('O10U39','U39','O10','2400','Anggota 19','0839','SI','aktif'),('O10U40','U40','O10','2400','Anggota 20','0840','SI','aktif'),('O10U50','U50','O10','2400','Pengurus 10','0850','SI','aktif');
/*!40000 ALTER TABLE `anggota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_organisasi`
--

DROP TABLE IF EXISTS `data_organisasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_organisasi` (
  `id_organisasi` varchar(10) NOT NULL,
  `nama_organisasi` varchar(100) DEFAULT NULL,
  `periode_kepengurusan` varchar(50) DEFAULT NULL,
  `visi` text,
  `misi` text,
  `struktur_kepengurusan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_organisasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_organisasi`
--

LOCK TABLES `data_organisasi` WRITE;
/*!40000 ALTER TABLE `data_organisasi` DISABLE KEYS */;
INSERT INTO `data_organisasi` VALUES ('O01','BEM','2025/2026','Maju Bersama','maju','Ketua, Wakil 1, Wakil 2, Sekretaris'),('O02','Futsal','2025/2026','Membangun Kreativitas','Mahasiswa inovatif','Ketua, Wakil Ketua, Sekretaris'),('O03','Teater','2024/2025','Fokus Berlatih','Selalu juara','Ketua, Wakil Ketua, Sekretaris'),('O04','Basket','2025/2026','Membangun tim basket yang solid dan berprestasi','Mengembangkan kemampuan olahraga basket mahasiswa','Ketua, Wakil Ketua, Sekretaris, Bendahara'),('O05','Mapala','2025/2026','Menumbuhkan kepedulian terhadap alam','Melaksanakan kegiatan pecinta alam yang edukatif','Ketua, Wakil Ketua, Sekretaris, Koordinator Lapangan'),('O06','PMK','2025/2026','Meningkatkan kualitas kerohanian mahasiswa','Menyelenggarakan kegiatan pembinaan iman','Ketua, Wakil Ketua, Sekretaris, Bendahara'),('O07','English Club','2025/2026','Meningkatkan kemampuan bahasa Inggris mahasiswa','Menyediakan wadah belajar dan praktik bahasa Inggris','Ketua, Wakil Ketua, Sekretaris, Koordinator Program'),('O08','KSR','2025/2026','Mewujudkan relawan mahasiswa yang tanggap dan peduli','Menyelenggarakan kegiatan kemanusiaan dan kesehatan','Ketua, Wakil Ketua, Sekretaris, Koordinator Relawan'),('O09','DPM','2025/2026','Satukan Suara','Satukan Tekad','Ketua, Wakil 1, Wakil 2, Sekretaris'),('O10','Badminton','2025/2026','Terus Berlatih','Jaga Sportivitas','Ketua, Wakil 1, Wakil 2, Sekretaris'),('O11','ukm budi','2025/2026','a',NULL,NULL),('O12','h',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `data_organisasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dokumen_kegiatan`
--

DROP TABLE IF EXISTS `dokumen_kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dokumen_kegiatan` (
  `id_dokumen` varchar(10) NOT NULL,
  `id_kegiatan` varchar(10) DEFAULT NULL,
  `nama_dokumen` varchar(255) DEFAULT NULL,
  `jenis` enum('proposal','lpj','dokumentasi') DEFAULT NULL,
  `deskripsi` text,
  `tanggal_upload` date DEFAULT NULL,
  `file_dokumen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_dokumen`),
  KEY `fk_dokumen_kegiatan` (`id_kegiatan`),
  CONSTRAINT `fk_dokumen_kegiatan` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dokumen_kegiatan`
--

LOCK TABLES `dokumen_kegiatan` WRITE;
/*!40000 ALTER TABLE `dokumen_kegiatan` DISABLE KEYS */;
INSERT INTO `dokumen_kegiatan` VALUES ('D001','K01','Proposal LKM','proposal','selesai','2026-06-17','1781706374_Proposal.pdf'),('D002','K01','LPJ LKM','lpj','selesai','2026-06-17','1781706397_LPJ.pdf'),('D003','K01','Dokumentasi LKM','dokumentasi','selesai','2026-06-17','1781706415_dokumentasi kegiatan.jpeg');
/*!40000 ALTER TABLE `dokumen_kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kegiatan`
--

DROP TABLE IF EXISTS `kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kegiatan` (
  `id_kegiatan` varchar(5) NOT NULL,
  `id_organisasi` varchar(5) NOT NULL,
  `nama_kegiatan` varchar(100) NOT NULL,
  `tanggal_pelaksanaan` date NOT NULL,
  `kuota_peserta` varchar(50) DEFAULT NULL,
  `deskripsi` text,
  `lokasi` varchar(100) DEFAULT NULL,
  `biaya_pendaftaran` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_kegiatan`),
  KEY `fk_kegiatan_organisasi` (`id_organisasi`),
  CONSTRAINT `fk_kegiatan_organisasi` FOREIGN KEY (`id_organisasi`) REFERENCES `data_organisasi` (`id_organisasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kegiatan`
--

LOCK TABLES `kegiatan` WRITE;
/*!40000 ALTER TABLE `kegiatan` DISABLE KEYS */;
INSERT INTO `kegiatan` VALUES ('K01','O01','Latihan Kepemimpinan Mahasiswa','2026-06-17','100','Pelatihan kepemimpinan mahasiswa','Aula',60000.00),('K02','O01','Seminar Nasional Kepemudaan','2026-02-10','1 orang','Seminar pengembangan karakter mahasiswa','Auditorium',75000.00),('K03','O01','Dialog Aspirasi Mahasiswa','2026-03-05','100 orang','Forum diskusi mahasiswa dan kampus','Ruang Sidang',25000.00),('K04','O01','Pelatihan Public Speaking','2026-04-12','120 orang','Pelatihan komunikasi efektif','Aula Utama',50000.00),('K05','O01','Festival Organisasi Mahasiswa','2026-05-18','300 orang','Pameran dan promosi organisasi mahasiswa','Lapangan Kampus',100000.00),('K06','O01','Workshop Manajemen Organisasi','2026-06-20','80 orang','Pelatihan pengelolaan organisasi','Ruang Seminar',60000.00),('K07','O02','Turnamen Futsal Internal','2026-01-20','100 orang','Kompetisi futsal antar mahasiswa','GOR Kampus',50000.00),('K08','O02','Coaching Clinic Futsal','2026-02-14','80 orang','Pelatihan teknik futsal','Lapangan Futsal',75000.00),('K09','O02','Liga Futsal Mahasiswa','2026-03-22','200 orang','Kompetisi futsal tingkat kampus','GOR Kampus',100000.00),('K10','O02','Seminar Sport Science','2026-04-08','120 orang','Pengenalan ilmu olahraga modern','Aula Utama',50000.00),('K11','O02','Pelatihan Kebugaran Atlet','2026-05-11','90 orang','Pelatihan fisik dan stamina','Gym Kampus',60000.00),('K12','O02','Fun Match Futsal','2026-06-25','150 orang','Pertandingan persahabatan futsal','Lapangan Futsal',25000.00),('K13','O03','Pelatihan Dasar Teater','2026-01-12','80 orang','Pelatihan dasar seni peran','Studio Teater',30000.00),('K14','O03','Workshop Akting','2026-02-15','100 orang','Pelatihan teknik akting','Aula Seni',50000.00),('K15','O03','Pentas Monolog','2026-03-20','150 orang','Pertunjukan monolog mahasiswa','Gedung Kesenian',40000.00),('K16','O03','Pelatihan Tata Panggung','2026-04-10','70 orang','Pelatihan tata panggung dan properti','Studio Teater',35000.00),('K17','O03','Festival Drama Kampus','2026-05-18','250 orang','Festival drama mahasiswa','Auditorium',100000.00),('K18','O03','Lomba Teater Antar Fakultas','2026-06-22','200 orang','Kompetisi teater kampus','Gedung Kesenian',75000.00),('K19','O04','Turnamen Basket Internal','2026-01-25','120 orang','Kompetisi basket mahasiswa','Lapangan Basket',50000.00),('K20','O04','Coaching Clinic Basket','2026-02-17','100 orang','Pelatihan teknik basket','GOR Kampus',60000.00),('K21','O04','Liga Basket Mahasiswa','2026-03-28','250 orang','Liga basket antar mahasiswa','GOR Kampus',100000.00),('K22','O04','Pelatihan Shooting Skill','2026-04-13','80 orang','Pelatihan akurasi tembakan','Lapangan Basket',40000.00),('K23','O04','Basket Fun Game','2026-05-15','150 orang','Pertandingan persahabatan basket','GOR Kampus',25000.00),('K24','O04','Seminar Sport Leadership','2026-06-20','100 orang','Seminar kepemimpinan atlet','Aula Utama',50000.00),('K25','O05','Pelatihan Survival','2026-01-18','70 orang','Pelatihan bertahan hidup di alam','Bumi Perkemahan',75000.00),('K26','O05','Pendakian Bersama','2026-02-22','100 orang','Kegiatan pendakian gunung','Gunung Batur',100000.00),('K27','O05','Pelatihan Navigasi Darat','2026-03-15','80 orang','Pelatihan kompas dan peta','Lapangan Kampus',50000.00),('K28','O05','Aksi Bersih Pantai','2026-04-21','150 orang','Kegiatan lingkungan hidup','Pantai Sanur',25000.00),('K29','O05','Kemah Pendidikan','2026-05-24','120 orang','Kemah edukatif mahasiswa','Bumi Perkemahan',80000.00),('K30','O05','Pelatihan Vertical Rescue','2026-06-28','60 orang','Pelatihan penyelamatan vertikal','Tebing Buatan',120000.00),('K31','O06','Retret Mahasiswa','2026-01-20','100 orang','Pembinaan iman mahasiswa','Villa Rohani',100000.00),('K32','O06','Seminar Kerohanian','2026-02-14','200 orang','Seminar pengembangan spiritual','Aula Utama',30000.00),('K33','O06','Persekutuan Doa','2026-03-12','80 orang','Kegiatan doa bersama','Ruang Ibadah',25000.00),('K34','O06','Pelayanan Sosial','2026-04-18','150 orang','Pengabdian kepada masyarakat','Desa Binaan',50000.00),('K35','O06','Pelatihan Kepemimpinan Rohani','2026-05-20','90 orang','Pelatihan pemimpin rohani','Aula PMK',60000.00),('K36','O06','Perayaan Hari Besar','2026-06-25','250 orang','Perayaan keagamaan mahasiswa','Auditorium',40000.00),('K37','O07','English Conversation Class','2026-01-15','100 orang','Latihan percakapan bahasa Inggris','Language Center',30000.00),('K38','O07','English Debate Competition','2026-02-18','120 orang','Kompetisi debat bahasa Inggris','Ruang Sidang',75000.00),('K39','O07','Public Speaking in English','2026-03-22','150 orang','Pelatihan presentasi bahasa Inggris','Aula Utama',50000.00),('K40','O07','TOEFL Preparation','2026-04-16','80 orang','Persiapan tes TOEFL','Language Center',100000.00),('K41','O07','English Camp','2026-05-25','200 orang','Kemah bahasa Inggris','Bumi Perkemahan',125000.00),('K42','O07','International Culture Day','2026-06-19','250 orang','Pengenalan budaya internasional','Auditorium',50000.00),('K43','O08','Pelatihan Pertolongan Pertama','2026-01-17','120 orang','Pelatihan P3K dasar','Lab Kesehatan',50000.00),('K44','O08','Donor Darah Mahasiswa','2026-02-20','300 orang','Kegiatan donor darah','Gedung Serbaguna',25000.00),('K45','O08','Simulasi Bencana','2026-03-18','150 orang','Pelatihan tanggap darurat','Lapangan Kampus',75000.00),('K46','O08','Pelatihan Relawan','2026-04-22','100 orang','Pelatihan relawan kemanusiaan','Aula KSR',60000.00),('K47','O08','Bakti Sosial','2026-05-16','250 orang','Kegiatan sosial masyarakat','Desa Binaan',40000.00),('K48','O08','Seminar Kesehatan','2026-06-21','200 orang','Edukasi kesehatan mahasiswa','Auditorium',50000.00),('K49','O09','Sidang Aspirasi Mahasiswa','2026-01-19','100 orang','Penyaluran aspirasi mahasiswa','Ruang Sidang',25000.00),('K50','O09','Seminar Demokrasi Kampus','2026-02-24','200 orang','Pendidikan demokrasi mahasiswa','Auditorium',50000.00),('K51','O09','Forum Legislasi Mahasiswa','2026-03-14','120 orang','Pembahasan regulasi organisasi','Ruang Sidang',30000.00),('K52','O09','Pelatihan Advokasi','2026-04-20','80 orang','Pelatihan advokasi mahasiswa','Aula DPM',60000.00),('K53','O09','Rapat Kerja DPM','2026-05-12','70 orang','Perencanaan program kerja','Ruang Rapat',25000.00),('K54','O09','Dialog Kampus Terbuka','2026-06-26','250 orang','Diskusi terbuka mahasiswa','Auditorium',50000.00),('K55','O10','Turnamen Badminton Internal','2026-01-21','120 orang','Kompetisi badminton mahasiswa','GOR Kampus',50000.00),('K56','O10','Coaching Clinic Badminton','2026-02-16','100 orang','Pelatihan teknik badminton','GOR Kampus',75000.00),('K57','O10','Liga Badminton Mahasiswa','2026-03-23','200 orang','Liga badminton kampus','GOR Kampus',100000.00),('K58','O10','Pelatihan Footwork','2026-04-15','80 orang','Pelatihan pergerakan lapangan','GOR Kampus',50000.00),('K59','O10','Fun Match Badminton','2026-05-17','150 orang','Pertandingan persahabatan','GOR Kampus',25000.00),('K60','O10','Kejuaraan Badminton Kampus','2026-06-29','300 orang','Kejuaraan badminton tingkat kampus','GOR Kampus',150000.00);
/*!40000 ALTER TABLE `kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keuangan`
--

DROP TABLE IF EXISTS `keuangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `keuangan` (
  `id_transaksi` varchar(10) NOT NULL,
  `id_kegiatan` varchar(10) DEFAULT NULL,
  `jenis_transaksi` enum('pemasukan','pengeluaran') DEFAULT NULL,
  `jumlah` decimal(15,2) DEFAULT NULL,
  `tanggal_transaksi` date DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id_transaksi`),
  KEY `fk_keuangan_kegiatan` (`id_kegiatan`),
  CONSTRAINT `fk_keuangan_kegiatan` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keuangan`
--

LOCK TABLES `keuangan` WRITE;
/*!40000 ALTER TABLE `keuangan` DISABLE KEYS */;
INSERT INTO `keuangan` VALUES ('TR001','K01','pemasukan',150000.00,'2026-06-17','sponsor LPBA'),('TR002','K01','pengeluaran',50000.00,'2026-06-17','beli garam rukyah');
/*!40000 ALTER TABLE `keuangan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'0001_01_01_000002_create_jobs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembina`
--

DROP TABLE IF EXISTS `pembina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembina` (
  `id_pembina` varchar(10) NOT NULL,
  `id_organisasi` varchar(10) DEFAULT NULL,
  `id_user` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_pembina`),
  KEY `fk_pembina_organisasi` (`id_organisasi`),
  KEY `fk_pembina_user` (`id_user`),
  CONSTRAINT `fk_pembina_organisasi` FOREIGN KEY (`id_organisasi`) REFERENCES `data_organisasi` (`id_organisasi`),
  CONSTRAINT `fk_pembina_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembina`
--

LOCK TABLES `pembina` WRITE;
/*!40000 ALTER TABLE `pembina` DISABLE KEYS */;
INSERT INTO `pembina` VALUES ('O01PM01','O01','PM01','pembina1@gmail.com','Pembina BEM','081111111001'),('O02PM02','O02','PM02','pembina2@gmail.com','Pembina Futsal','081111111002'),('O03PM03','O03','PM03','pembina3@gmail.com','Pembina Teater','081111111003'),('O04PM04','O04','PM04','pembina4@gmail.com','Pembina Basket','081111111004'),('O05PM05','O05','PM05','pembina5@gmail.com','Pembina Mapala','081111111005'),('O06PM06','O06','PM06','pembina6@gmail.com','Pembina PMK','081111111006'),('O07PM07','O07','PM07','pembina7@gmail.com','Pembina English Club','081111111007'),('O08PM08','O08','PM08','pembina8@gmail.com','Pembina KSR','081111111008'),('O09PM09','O09','PM09','pembina9@gmail.com','Pembina DPM','081111111009'),('O10PM10','O10','PM10','pembina10@gmail.com','Pembina Badminton','081111111010');
/*!40000 ALTER TABLE `pembina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pendaftaran_anggota_online`
--

DROP TABLE IF EXISTS `pendaftaran_anggota_online`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pendaftaran_anggota_online` (
  `id_pendaftaranA` varchar(10) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `id_organisasi` varchar(10) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `program_studi` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `kartu_identitas` varchar(255) NOT NULL,
  PRIMARY KEY (`id_pendaftaranA`),
  KEY `id_user` (`id_user`),
  KEY `id_organisasi` (`id_organisasi`),
  CONSTRAINT `pendaftaran_anggota_online_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `pendaftaran_anggota_online_ibfk_2` FOREIGN KEY (`id_organisasi`) REFERENCES `data_organisasi` (`id_organisasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pendaftaran_anggota_online`
--

LOCK TABLES `pendaftaran_anggota_online` WRITE;
/*!40000 ALTER TABLE `pendaftaran_anggota_online` DISABLE KEYS */;
INSERT INTO `pendaftaran_anggota_online` VALUES ('PA001','U01','O01','2400','mahasiswa01','SI','0823','1781842854_ktm.jpg');
/*!40000 ALTER TABLE `pendaftaran_anggota_online` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pendaftaran_kegiatan`
--

DROP TABLE IF EXISTS `pendaftaran_kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pendaftaran_kegiatan` (
  `id_pendaftaran` varchar(10) NOT NULL,
  `id_user` varchar(10) DEFAULT NULL,
  `id_kegiatan` varchar(10) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `NIM` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `program_studi` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_pendaftaran`),
  KEY `id_user` (`id_user`),
  KEY `id_kegiatan` (`id_kegiatan`),
  CONSTRAINT `pendaftaran_kegiatan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `pendaftaran_kegiatan_ibfk_2` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pendaftaran_kegiatan`
--

LOCK TABLES `pendaftaran_kegiatan` WRITE;
/*!40000 ALTER TABLE `pendaftaran_kegiatan` DISABLE KEYS */;
INSERT INTO `pendaftaran_kegiatan` VALUES ('PK002','U01','K02','1780968060_konsum.png','2400','mahasiswa01','SI','mahasiswa01@gmail.com','081'),('PK004','U01','K01','1781703954_biaya pendaftaran valid.jpeg','2400','mahasiswa01','SI','mahasiswa01@gmail.com','082');
/*!40000 ALTER TABLE `pendaftaran_kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengurus`
--

DROP TABLE IF EXISTS `pengurus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengurus` (
  `id_pengurus` varchar(20) NOT NULL,
  `id_anggota` varchar(20) DEFAULT NULL,
  `id_user` varchar(10) DEFAULT NULL,
  `id_organisasi` varchar(10) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `periode_kepengurusan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_pengurus`),
  KEY `fk_pengurus_anggota` (`id_anggota`),
  KEY `fk_pengurus_organisasi` (`id_organisasi`),
  CONSTRAINT `fk_pengurus_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`),
  CONSTRAINT `fk_pengurus_organisasi` FOREIGN KEY (`id_organisasi`) REFERENCES `data_organisasi` (`id_organisasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengurus`
--

LOCK TABLES `pengurus` WRITE;
/*!40000 ALTER TABLE `pengurus` DISABLE KEYS */;
INSERT INTO `pengurus` VALUES ('O01P41','O01U41','U41','O01','Pengurus 01','Ketua','2025/2026'),('O02P42','O02U42','U42','O02','Pengurus 02','Ketua','2025/2026'),('O03P43','O03U43','U43','O03','Pengurus 03','Ketua','2025/2026'),('O04P44','O04U44','U44','O04','Pengurus 04','Ketua','2025/2026'),('O05P45','O05U45','U45','O05','Pengurus 05','Ketua','2025/2026'),('O06P46','O06U46','U46','O06','Pengurus 06','Ketua','2025/2026'),('O07P47','O07U47','U47','O07','Pengurus 07','Ketua','2025/2026'),('O08P48','O08U48','U48','O08','Pengurus 08','Ketua','2025/2026'),('O09P49','O09U49','U49','O09','Pengurus 09','Ketua','2025/2026'),('O10P50','O10U50','U50','O10','Pengurus 10','Ketua','2025/2026');
/*!40000 ALTER TABLE `pengurus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `riwayat_kegiatan`
--

DROP TABLE IF EXISTS `riwayat_kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `riwayat_kegiatan` (
  `id_riwayat` varchar(10) NOT NULL,
  `id_kegiatan` varchar(5) DEFAULT NULL,
  `jumlah_peserta` varchar(20) DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `evaluasi` text,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_riwayat`),
  KEY `fk_riwayat_kegiatan` (`id_kegiatan`),
  CONSTRAINT `fk_riwayat_kegiatan` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `riwayat_kegiatan`
--

LOCK TABLES `riwayat_kegiatan` WRITE;
/*!40000 ALTER TABLE `riwayat_kegiatan` DISABLE KEYS */;
INSERT INTO `riwayat_kegiatan` VALUES ('R01','K01','2 orang','2026-06-11','sudah berjalan dengan baik','Selesai'),('R02','K01','0 orang','2026-06-17','kok 0 pesertanyaaaa','Selesai');
/*!40000 ALTER TABLE `riwayat_kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_user` varchar(10) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` enum('admin','mahasiswa','anggota','pengurus','pembina') DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('A01','admin1@gmail.com','123','admin'),('A02','admin2@gmail.com','123','admin'),('PM01','pembina1@gmail.com','123','pembina'),('PM02','pembina2@gmail.com','123','pembina'),('PM03','pembina3@gmail.com','123','pembina'),('PM04','pembina4@gmail.com','123','pembina'),('PM05','pembina5@gmail.com','123','pembina'),('PM06','pembina6@gmail.com','123','pembina'),('PM07','pembina7@gmail.com','123','pembina'),('PM08','pembina8@gmail.com','123','pembina'),('PM09','pembina9@gmail.com','123','pembina'),('PM10','pembina10@gmail.com','123','pembina'),('U01','mahasiswa01@gmail.com','123','mahasiswa'),('U02','mahasiswa02@gmail.com','123','mahasiswa'),('U03','mahasiswa03@gmail.com','123','anggota'),('U04','mahasiswa04@gmail.com','123','mahasiswa'),('U05','mahasiswa05@gmail.com','123','mahasiswa'),('U06','mahasiswa06@gmail.com','123','mahasiswa'),('U07','mahasiswa07@gmail.com','123','mahasiswa'),('U08','mahasiswa08@gmail.com','123','mahasiswa'),('U09','mahasiswa09@gmail.com','123','mahasiswa'),('U10','mahasiswa10@gmail.com','123','mahasiswa'),('U11','mahasiswa11@gmail.com','123','mahasiswa'),('U12','mahasiswa12@gmail.com','123','mahasiswa'),('U13','mahasiswa13@gmail.com','123','mahasiswa'),('U14','mahasiswa14@gmail.com','123','mahasiswa'),('U15','mahasiswa15@gmail.com','123','mahasiswa'),('U16','mahasiswa16@gmail.com','123','mahasiswa'),('U17','mahasiswa17@gmail.com','123','mahasiswa'),('U18','mahasiswa18@gmail.com','123','mahasiswa'),('U19','mahasiswa19@gmail.com','123','mahasiswa'),('U20','mahasiswa20@gmail.com','123','mahasiswa'),('U21','anggota01@gmail.com','124','anggota'),('U22','anggota02@gmail.com','123','anggota'),('U23','anggota03@gmail.com','123','anggota'),('U24','anggota04@gmail.com','123','anggota'),('U25','anggota05@gmail.com','123','anggota'),('U26','anggota06@gmail.com','123','anggota'),('U27','anggota07@gmail.com','123','anggota'),('U28','anggota08@gmail.com','123','anggota'),('U29','anggota09@gmail.com','123','anggota'),('U30','anggota10@gmail.com','123','anggota'),('U31','anggota11@gmail.com','123','anggota'),('U32','anggota12@gmail.com','123','anggota'),('U33','anggota13@gmail.com','123','anggota'),('U34','anggota14@gmail.com','123','anggota'),('U35','anggota15@gmail.com','123','anggota'),('U36','anggota16@gmail.com','123','anggota'),('U37','anggota17@gmail.com','123','anggota'),('U38','anggota18@gmail.com','123','anggota'),('U39','anggota19@gmail.com','123','anggota'),('U40','anggota20@gmail.com','123','anggota'),('U41','pengurus01@gmail.com','123','pengurus'),('U42','pengurus02@gmail.com','123','pengurus'),('U43','pengurus03@gmail.com','123','pengurus'),('U44','pengurus04@gmail.com','123','pengurus'),('U45','pengurus05@gmail.com','123','pengurus'),('U46','pengurus06@gmail.com','123','pengurus'),('U47','pengurus07@gmail.com','123','pengurus'),('U48','pengurus08@gmail.com','123','pengurus'),('U49','pengurus09@gmail.com','123','pengurus'),('U50','pengurus10@gmail.com','123','pengurus');
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

-- Dump completed on 2026-06-21 18:41:38
