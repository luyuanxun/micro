/*
 Navicat Premium Data Transfer

 Source Server         : 192.168.31.13
 Source Server Type    : MySQL
 Source Server Version : 50721
 Source Host           : 192.168.31.13:3306
 Source Schema         : phalcon

 Target Server Type    : MySQL
 Target Server Version : 50721
 File Encoding         : 65001

 Date: 14/04/2019 16:05:42
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `content` varchar(255) DEFAULT NULL COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of news
-- ----------------------------
BEGIN;
INSERT INTO `news` VALUES (4, 'title2', 'content22222');
INSERT INTO `news` VALUES (5, 'title3', 'content6666');
INSERT INTO `news` VALUES (6, 'title4', 'content6666');
INSERT INTO `news` VALUES (7, '哈哈哈哈', 'content6666');
INSERT INTO `news` VALUES (8, '新标题', 'content22222');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
