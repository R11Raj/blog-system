-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.30-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for blog_system
CREATE DATABASE IF NOT EXISTS `blog_system` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `blog_system`;

-- Dumping structure for table blog_system.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission` varchar(50) NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table blog_system.permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table blog_system.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `likes` int(11) DEFAULT NULL,
  `post_header` varchar(120) NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table blog_system.posts: ~2 rows (approximately)
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`post_id`, `user_id`, `content`, `likes`, `post_header`) VALUES
	(1, 1, 'Hello how are you guys', 3, 'Chilling'),
	(2, 1, 'A great day ahead', 2, 'Good Morning'),
	(3, 1, 'About last night,Had a blast with the gang', 14, 'Success party');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Dumping structure for table blog_system.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(90) NOT NULL,
  `display_name` varchar(90) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table blog_system.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `NAME`, `display_name`, `email`, `password`) VALUES
	(3, 'amit', 'amit123', 'xyz@abc.com', '$2y$10$BKsLeo5z0wbpkZ1n.5HSi.C/W5VRj/CYxdcTFa06K9lpLi/t5hPKC'),
	(4, 'RAJ', 'R1234', 'abc@xyz.com', '$2y$10$V2lwnZGbLLYjKvHzR9QiqOHvqIMU2bsliBLGNZl/1F9VR3DizoolO');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table blog_system.user_sessions
CREATE TABLE IF NOT EXISTS `user_sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `session_ip` varchar(100) NOT NULL,
  `session_code` varchar(255) NOT NULL,
  `is_valid` tinyint(4) NOT NULL,
  `create_time` int(11) NOT NULL,
  `expire_time` int(11) NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table blog_system.user_sessions: ~14 rows (approximately)
/*!40000 ALTER TABLE `user_sessions` DISABLE KEYS */;
INSERT INTO `user_sessions` (`session_id`, `user_id`, `session_ip`, `session_code`, `is_valid`, `create_time`, `expire_time`) VALUES
	(1, 4, '::1', 'Jzdb1p8PmQY1FgnlTzZnH7pUlvXyoZjXHHGxvPhG1zDAyWAvxuw2TV90ADSZ36gErnUKpZXyY8Y4FUcGi0uySz7zN1MK0ZbUTBZL', 0, 1553010147, 1584546147),
	(2, 4, '::1', 'keG1LVTGCfRUdsQkhIscME824ZZmhwjvP5nqRtzCsbbMh8Nhzy5r2LXMebzWrv2TO4bcKh1EdLDsAbjtvhNSE7uVfwtZ1hsAxjXc', 0, 1553013820, 1584549820),
	(3, 4, '::1', '0wtURbBB48qtPm6SCbrlMHrEEV0jMr1X4d3ttLjh1IEmeiVahxZTcssAzaCVCA83Zl4VVzYDpYEBFpoym99Ov0mALk54ZNQDBgcH', 0, 1553018930, 1584554930),
	(4, 4, '::1', '3DEZHRh3BGTfPM4965tTW9EeUIvS1MJdr6jeu2dhVjJIcpUCb0TxRLK8QgpT9BhCClXzP48Qm0KpGTb5GWawQPzRHYgQOrtrLPW2', 0, 1553051302, 1584587302),
	(5, 4, '::1', 'H0arDqHjHBNb5VTOI1a7pl4cqZ32GBBzTzqb1sWxhgXogqRTYRx6KUxvTWpjYXXAXb8QAT94DStXDwLNf4p6EiWkjY2mYbKd44Wb', 0, 1553051558, 1584587558),
	(6, 4, '::1', 'unMgsGXzhdGuM7MakJLOLOjvVUP2s59V9U62ln0gOvQzkpkg310zI4JjSDSDziefjtklsbHv0y6D9AL4u6deFDT1tZOTOSSxwwei', 0, 1553053706, 1584589706),
	(7, 4, '::1', 'rgbSj4cAispLMqqrGUawKLIltjnKkQ7PA1e9oErv6xz7trpSGMUBT7eOinLGSZSHH2HMQJu8ePmHvOsTg01ujmQSreu0Zj8INAol', 0, 1553058285, 1584594285),
	(8, 4, '::1', 'IrJoecE0dV9azyARnXvuJY97sT5oi9dEFBpmOcInrbuzlzHBuiFzwqgtwSScbosgTDsDYugBWKyTrzP7sdHQyxra3G03UiD9j0k7', 0, 1553058729, 1584594729),
	(9, 4, '::1', 'eDNO99sUg1OiIKdEvJi5WE5Fh9GDpCyEMaqb0DIyjbMFjbyBnd64Iu2r4100iCWGR09VKkktP7ToeNH2Ju6m1wD1PmuV723sU8Y7', 0, 1553058797, 1584594797),
	(10, 4, '::1', 'YxqoDMRd5pTSe9cJUhTLpfTxDqsccb2Q94iw0JfGSfj1k14LuGRjcasbZjrG4kx62lvLfmWsr0I1mWon4DObUkCkqFwIhR9WAIbk', 0, 1553058911, 1584594911),
	(11, 4, '::1', 'jmbX46W2pF3wCpl9lLNd574KbDvKkZpkphce5P4x65p2wiDBfwzTWiLakHdWA9ELkVHelaT9GbZtJxSktBJ0Sr6SuhyfvYrAgYBP', 0, 1553058980, 1584594980),
	(12, 4, '::1', '1yXFHHJIMFcEgx2mbeIdmULRLWtczh7Mj7ackdtFT4gRozKa4gDHMk5A9i4R4VD3Jvsm1KEVpI00kYxsltgAwlLQiUwNEa494QVG', 0, 1553059134, 1584595134),
	(13, 4, '::1', '7zdnEc72OKpgwIhJ1tOvHVmrsJqss7yQFnE3L8TaDDrvAK68jHzcCNTh3bcIB9Df1jrit01IhNn9xsvVyL2yrANQfDtWqjba1wTA', 0, 1553060036, 1584596036),
	(14, 4, '::1', 'ztrJVDHecJMMWT5rwHJwdQyJcdmAgwKxFC1heceKHG1WwgOvbo4ybnssXeeZSTPRTlmhwbGnSfJTbZuTKolXn4Kk0MUyiOKI5Jpf', 0, 1553060421, 1584596421);
/*!40000 ALTER TABLE `user_sessions` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
