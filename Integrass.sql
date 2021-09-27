-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.17-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6338
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for integrass
CREATE DATABASE IF NOT EXISTS `integrass` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `integrass`;

-- Dumping structure for table integrass.events
CREATE TABLE IF NOT EXISTS `events` (
  `event_sno` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_code` varchar(128) NOT NULL,
  `event_user_code` varchar(128) NOT NULL,
  `event_title` varchar(200) NOT NULL,
  `event_desc` text DEFAULT NULL,
  `event_startdate` date NOT NULL,
  `event_starttime` varchar(50) DEFAULT NULL,
  `event_enddate` date DEFAULT NULL,
  `event_endtime` varchar(50) DEFAULT NULL,
  `event_privacy` enum('Public','Private') NOT NULL DEFAULT 'Public',
  `event_status` enum('Pending','Approved','Rejected','Deleted') NOT NULL DEFAULT 'Pending',
  `event_created` datetime(6) DEFAULT NULL,
  `event_updated` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`event_sno`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table integrass.events: ~11 rows (approximately)
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` (`event_sno`, `event_code`, `event_user_code`, `event_title`, `event_desc`, `event_startdate`, `event_starttime`, `event_enddate`, `event_endtime`, `event_privacy`, `event_status`, `event_created`, `event_updated`) VALUES
	(1, 'event1', 'user1', 'Event 1 : Demo Title', 'Event 1 : Demo Description', '2021-09-02', '11:00', '2021-09-28', '12:00', 'Public', 'Approved', '2021-09-27 01:04:25.000000', '2021-09-27 23:30:40.381400'),
	(2, 'event2', 'user1', 'Demo Title', 'Demo Description', '2021-09-02', '11:00', '2021-09-28', '12:00', 'Public', 'Approved', '2021-09-27 11:55:47.776900', '2021-09-27 23:20:31.805900'),
	(3, 'event3', 'user1', 'Demo Title', 'Demo Description', '2021-09-02', '11:00', '2021-09-28', '12:00', 'Public', 'Approved', '2021-09-27 11:57:59.903300', '2021-09-27 23:10:17.180000'),
	(4, 'event4', 'user1', 'Demo Title', 'Demo Description', '2021-09-02', '11:00', '2021-09-28', '12:00', 'Public', 'Approved', '2021-09-27 12:00:48.669100', '2021-09-27 23:24:40.667400'),
	(5, 'event5', 'user1', 'Demo Title', 'Demo Description', '2021-09-02', '11:00', '2021-09-28', '12:00', 'Private', 'Pending', '2021-09-27 12:05:09.781700', '2021-09-27 15:59:14.137000'),
	(6, 'event6', 'user1', 'Demo Title', 'Demo Description', '2021-09-02', '11:00', '2021-09-28', '12:00', 'Private', 'Pending', '2021-09-27 12:06:31.218500', '2021-09-27 15:59:14.137000'),
	(7, 'event7', 'user1', 'Alter Title', 'Alter Description', '2021-10-02', '09:00', '2021-10-28', '11:00', 'Private', 'Deleted', '2021-09-27 12:08:01.180300', '2021-09-27 17:55:58.193500'),
	(8, 'event8', 'user1', 'Demo Title', 'Demo Description', '2021-09-02', '11:00', '2021-09-28', '12:00', 'Private', 'Pending', '2021-09-27 12:15:24.018100', '2021-09-27 15:59:14.137000'),
	(9, 'event9', 'user1', 'Demo Title', 'Demo Description', '2021-09-02', '11:00', '2021-09-28', '12:00', 'Private', 'Pending', '2021-09-27 12:15:54.981700', '2021-09-27 15:59:14.137000'),
	(10, 'event10', 'user1', 'Demo Title', 'Demo Description', '2021-10-02', '11:00', '2021-10-28', '12:00', 'Private', 'Pending', '2021-09-27 12:24:29.199700', '2021-09-27 15:59:14.137000'),
	(11, 'event11', 'user1', 'Demo Title', 'Demo Description', '2021-09-02', '11:00', '2021-09-28', '12:00', 'Private', 'Deleted', '2021-09-27 13:13:33.548700', '2021-09-27 17:41:54.193700'),
	(12, 'event12', 'user1', 'Test', 'Test', '2021-10-01', '11:00', '2021-11-01', '12:00', 'Private', 'Pending', '2021-09-27 21:05:56.059500', NULL);
/*!40000 ALTER TABLE `events` ENABLE KEYS */;

-- Dumping structure for table integrass.profile_admin
CREATE TABLE IF NOT EXISTS `profile_admin` (
  `admin_sno` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_code` varchar(128) NOT NULL,
  `admin_username` varchar(300) NOT NULL,
  `admin_password` varchar(200) NOT NULL,
  `admin_emailid` varchar(200) NOT NULL,
  `admin_mobile` bigint(10) unsigned DEFAULT NULL,
  `admin_token` text DEFAULT NULL,
  `admin_firstname` bigint(10) unsigned DEFAULT NULL,
  `admin_created` datetime(6) DEFAULT NULL,
  `admin_updated` datetime(6) DEFAULT NULL,
  `admin_currentlogin` datetime(6) DEFAULT NULL,
  `admin_lastlogin` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`admin_sno`),
  UNIQUE KEY `admin_code` (`admin_code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table integrass.profile_admin: ~1 rows (approximately)
/*!40000 ALTER TABLE `profile_admin` DISABLE KEYS */;
INSERT INTO `profile_admin` (`admin_sno`, `admin_code`, `admin_username`, `admin_password`, `admin_emailid`, `admin_mobile`, `admin_token`, `admin_firstname`, `admin_created`, `admin_updated`, `admin_currentlogin`, `admin_lastlogin`) VALUES
	(1, 'admin1', 'siva', 'b79465edbb2036fa2cb1f488c01747ab1b808939ac2973d275968c38b00254d2', 'sivaprakash3.lingam@gmail.com', 8012886959, 'j1cRf8Tvl5bGKJ18NMIJyJgBINYYKZC4fFTZXIGMg44/vtHz6aCE4f13SBZoE9HYaSAJB3tEZy5IEIjaD8RATpRku5P70nAx5AHhrAtj5a+dd5FKw8APnE5YFlObt+VUp9uwqbXZjZevZjbPtwsvdnwtAI8dlSu65E2XbEqsyUyw30ZNI4qVdRolo5zaPWnxnw==', 0, '2021-09-26 00:24:45.000000', '2021-09-26 11:42:25.911373', '2021-09-27 21:28:32.599054', '2021-09-27 21:28:32.599054');
/*!40000 ALTER TABLE `profile_admin` ENABLE KEYS */;

-- Dumping structure for table integrass.profile_users
CREATE TABLE IF NOT EXISTS `profile_users` (
  `user_sno` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_code` varchar(128) NOT NULL,
  `user_username` varchar(300) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_emailid` varchar(200) NOT NULL,
  `user_mobile` bigint(10) unsigned DEFAULT NULL,
  `user_token` text DEFAULT NULL,
  `user_firstname` varchar(200) NOT NULL,
  `user_created` datetime(6) DEFAULT NULL,
  `user_updated` datetime(6) DEFAULT NULL,
  `user_currentlogin` datetime(6) DEFAULT NULL,
  `user_lastlogin` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`user_sno`) USING BTREE,
  UNIQUE KEY `admin_code` (`user_code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Dumping data for table integrass.profile_users: ~0 rows (approximately)
/*!40000 ALTER TABLE `profile_users` DISABLE KEYS */;
INSERT INTO `profile_users` (`user_sno`, `user_code`, `user_username`, `user_password`, `user_emailid`, `user_mobile`, `user_token`, `user_firstname`, `user_created`, `user_updated`, `user_currentlogin`, `user_lastlogin`) VALUES
	(1, 'user1', 'siva', 'b79465edbb2036fa2cb1f488c01747ab1b808939ac2973d275968c38b00254d2', 'sivaprakash3.lingam@gmail.com', 8012886959, 'usk878onzuAAUV3HRb9UhLg5kl9JBE/6SniMvlC5hqVQdseV97E1mGsp77Fv2wPJJ7wa+lKqERfx1W5OxbeKxm6t6GXmsFLEQ3slkBhbyLXDmGh0c5FKtO7wHDUZGPtEFd1wkrx6GUJgWE1WrksMrGVTIZgjWifwAeYYbcQTXawLG8FDg9vwgdTs6cufsEMb', 'Siva', '2021-09-26 00:24:45.000000', '2021-09-26 11:42:25.911373', '2021-09-27 21:05:29.122970', '2021-09-27 21:05:29.122970');
/*!40000 ALTER TABLE `profile_users` ENABLE KEYS */;

-- Dumping structure for trigger integrass.Event_uniquecode
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `Event_uniquecode` BEFORE INSERT ON `events` FOR EACH ROW SET NEW.event_code = (SELECT CONCAT('event', (IFNULL((SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = (SELECT DATABASE() FROM DUAL) AND TABLE_NAME = 'events'),1))))//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
