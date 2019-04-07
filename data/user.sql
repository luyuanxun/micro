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

 Date: 08/04/2019 00:13:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `username` char(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(100) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态：#1正常 #2禁用 ',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登录时间',
  `is_deleted` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '删除：#1是 #2否',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of user
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES (1, 'test', '$2y$08$U1B5bFFCVE42RzNaQlJmM.tUrwqreFq72JIR9zwtsUPqM8PADoOtS', 1, '2019-04-06 14:31:30', '2019-04-06 14:31:30', 2);
INSERT INTO `user` VALUES (2, 'test1av', '$2y$08$MStadTdYamxNWVlpVXNGUuSzxrejwQi0qWjE2XpYOIwf1unDInEe.', 1, '2019-04-06 14:31:38', '2019-04-08 00:10:44', 2);
INSERT INTO `user` VALUES (16, 'test2', '$2y$08$MzJQVWxhdVRDOE1SN2RpWeF62pVqC.5qCIP1NxhdVEQC..mDHoF26', 1, '2019-04-06 15:11:29', '2019-04-06 15:11:29', 2);
INSERT INTO `user` VALUES (17, 'test3', '$2y$08$U2d1bW4rL09BZ0QyNDhKS.eH8xjB9KMq8pfOqxQ0quFcKzluNuDMC', 1, '2019-04-06 15:11:50', '2019-04-06 15:11:50', 2);
INSERT INTO `user` VALUES (18, 'test4', '$2y$08$cFlZZm53RXVCcW00THlMOOLKRGgcH1.qGastfbEoPGyRoIY/D.1sq', 1, '2019-04-06 15:12:05', '2019-04-06 15:12:05', 2);
INSERT INTO `user` VALUES (19, 'test5', '$2y$08$TTYyWkxwRXNrSVEwQmJXT.u5QpCQHRA6GesnOR9XgC99MHj0c8kHe', 1, '2019-04-06 15:43:40', '2019-04-06 15:43:40', 2);
INSERT INTO `user` VALUES (20, 'test6', '$2y$08$VUdRUzM2S2NlMVpwcGxjTezqcO339zrcdxFU87TjT5ECbRkfadDTO', 1, '2019-04-06 15:44:02', '2019-04-06 15:44:02', 2);
INSERT INTO `user` VALUES (21, 'test7', '$2y$08$czF3WjQxa3ZMT3QrMnVFUeK.QdQNMBYYzsDgRgsOJseBKNm43o3nO', 1, '2019-04-06 18:08:59', '2019-04-06 18:08:59', 2);
INSERT INTO `user` VALUES (22, 'test8', '$2y$08$SVdOc0Faa0d0UzZMWC9hKupbcPWPjzob0a/FEbsPrgUBezo6hTbz6', 1, '2019-04-07 13:00:20', '2019-04-07 13:00:20', 2);
INSERT INTO `user` VALUES (23, 'test9', '$2y$08$ckEwRXljWnNDck9BUTBncOT8RyHXKkFDAGnyk7sPRhIeIyikf7Pxe', 1, '2019-04-07 15:42:29', '2019-04-07 15:42:29', 2);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
