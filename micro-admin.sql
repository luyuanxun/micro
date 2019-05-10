/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.23 : Database - phalcon
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`phalcon` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `phalcon`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` char(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '账号名',
  `password` char(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态：#1正常 #2禁用 ',
  `is_deleted` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '删除：#1是 #2否',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登录时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `admin` */

insert  into `admin`(`id`,`name`,`password`,`status`,`is_deleted`,`create_time`,`update_time`) values (1,'admin','$2y$08$TFFtSkRIeENOZ0psSXFRe.FLe4eBQU53PnNNHdO47.Gd68lJuorwi',1,2,'2019-05-05 07:50:52','2019-05-05 07:50:52'),(2,'super_admin','$2y$08$TFFtSkRIeENOZ0psSXFRe.FLe4eBQU53PnNNHdO47.Gd68lJuorwi',1,2,'2019-05-05 07:50:52','2019-05-05 07:50:52');

/*Table structure for table `article` */

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) CHARACTER SET utf8 NOT NULL,
  `addedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `editedDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '2' COMMENT '是否删除：#1是 #2否',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：#1正常 #2停用',
  PRIMARY KEY (`id`),
  KEY `addedDate` (`addedDate`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

/*Data for the table `article` */

insert  into `article`(`id`,`title`,`addedDate`,`editedDate`,`is_deleted`,`status`) values (1,'安全升级，蝉知2.5.2发布','2014-08-21 13:55:00','2014-08-25 15:17:30',2,1),(2,'推荐空间','2014-08-25 14:17:00','2014-08-25 14:18:11',2,2),(3,'ZUI文档更新','2014-06-09 14:30:00','2014-08-25 15:27:00',2,1),(4,'多处改进，蝉知2.5.1正式版发布','2014-08-19 15:15:00','2014-10-16 14:11:52',2,1),(5,'蝉知企业门户2.5beta版本发布','2014-08-06 11:10:00','2014-08-25 15:18:38',2,1),(6,'蝉知企业门户2.4正式版发布','2014-06-25 14:10:00','2014-08-25 15:19:43',2,1),(7,'蝉知企业门户2.3正式版发布','2014-05-16 10:10:00','2014-08-25 15:20:58',2,1),(8,'蝉知企业门户2.2.1版本发布','2014-04-01 10:40:00','2014-08-25 15:22:03',2,1),(9,'蝉知企业门户2.2版本发布，全面集成微信！','2014-03-24 16:00:00','2014-08-25 15:24:48',2,1),(10,'蝉知企业门户系统2.1正式版发布','2014-03-03 09:50:00','2014-08-25 15:26:45',2,1),(11,'关于我们','2014-10-08 14:38:00','2014-10-08 17:40:23',2,1),(12,'明天还是明天','2014-10-08 17:44:00','2014-10-08 17:44:59',2,1),(13,'测试666','2019-05-09 03:04:32','2019-05-09 03:04:32',2,1);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `username` char(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态：#1正常 #2禁用 ',
  `is_deleted` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '删除：#1是 #2否',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登录时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`password`,`status`,`is_deleted`,`create_time`,`update_time`) values (1,'test','$2y$08$U1B5bFFCVE42RzNaQlJmM.tUrwqreFq72JIR9zwtsUPqM8PADoOtS',1,2,'2019-04-06 14:31:30','2019-04-06 14:31:30'),(2,'test1av','$2y$08$MStadTdYamxNWVlpVXNGUuSzxrejwQi0qWjE2XpYOIwf1unDInEe.',1,2,'2019-04-06 14:31:38','2019-04-08 00:10:44'),(16,'test2','$2y$08$MzJQVWxhdVRDOE1SN2RpWeF62pVqC.5qCIP1NxhdVEQC..mDHoF26',1,2,'2019-04-06 15:11:29','2019-04-06 15:11:29'),(17,'test3','$2y$08$U2d1bW4rL09BZ0QyNDhKS.eH8xjB9KMq8pfOqxQ0quFcKzluNuDMC',1,2,'2019-04-06 15:11:50','2019-04-06 15:11:50'),(18,'test4','$2y$08$cFlZZm53RXVCcW00THlMOOLKRGgcH1.qGastfbEoPGyRoIY/D.1sq',1,2,'2019-04-06 15:12:05','2019-04-06 15:12:05'),(19,'test5','$2y$08$TTYyWkxwRXNrSVEwQmJXT.u5QpCQHRA6GesnOR9XgC99MHj0c8kHe',1,2,'2019-04-06 15:43:40','2019-04-06 15:43:40'),(20,'test6','$2y$08$VUdRUzM2S2NlMVpwcGxjTezqcO339zrcdxFU87TjT5ECbRkfadDTO',1,2,'2019-04-06 15:44:02','2019-04-06 15:44:02'),(21,'test7','$2y$08$czF3WjQxa3ZMT3QrMnVFUeK.QdQNMBYYzsDgRgsOJseBKNm43o3nO',1,2,'2019-04-06 18:08:59','2019-04-06 18:08:59'),(22,'test8','$2y$08$SVdOc0Faa0d0UzZMWC9hKupbcPWPjzob0a/FEbsPrgUBezo6hTbz6',1,2,'2019-04-07 13:00:20','2019-04-07 13:00:20'),(23,'test9','$2y$08$ckEwRXljWnNDck9BUTBncOT8RyHXKkFDAGnyk7sPRhIeIyikf7Pxe',1,2,'2019-04-07 15:42:29','2019-04-07 15:42:29');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
