/*
 Navicat Premium Data Transfer

 Source Server         : local8
 Source Server Type    : MySQL
 Source Server Version : 80020
 Source Host           : localhost:3306
 Source Schema         : dbrab

 Target Server Type    : MySQL
 Target Server Version : 80020
 File Encoding         : 65001

 Date: 30/10/2020 06:08:11
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for building_type
-- ----------------------------
DROP TABLE IF EXISTS `building_type`;
CREATE TABLE `building_type`  (
  `bt_id` int NOT NULL AUTO_INCREMENT,
  `bt_building_type` varchar(255) CHARACTER SET utf16 COLLATE utf16_bin NULL DEFAULT NULL,
  `bt_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`bt_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of building_type
-- ----------------------------
INSERT INTO `building_type` VALUES (16, 'Type 45', 'Y', '1', '2020-10-25 10:04:29');
INSERT INTO `building_type` VALUES (17, 'Type 90', 'Y', '1', '2020-10-25 10:04:37');
INSERT INTO `building_type` VALUES (18, 'Type 105', 'Y', '1', '2020-10-25 10:05:28');

-- ----------------------------
-- Table structure for item_list
-- ----------------------------
DROP TABLE IF EXISTS `item_list`;
CREATE TABLE `item_list`  (
  `il_id` int NOT NULL AUTO_INCREMENT,
  `il_item_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `il_un_id` int NULL DEFAULT NULL,
  `il_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`il_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of item_list
-- ----------------------------
INSERT INTO `item_list` VALUES (8, 'Batu Bata', 1, 'Y', '1', '2020-10-22 01:47:47');
INSERT INTO `item_list` VALUES (9, 'Kerikil', 14, 'Y', '1', '2020-10-26 19:52:52');
INSERT INTO `item_list` VALUES (10, 'Semen', 15, 'Y', '1', '2020-10-26 19:57:08');
INSERT INTO `item_list` VALUES (11, 'Pasir Cor', 14, 'Y', '1', '2020-10-26 19:57:26');
INSERT INTO `item_list` VALUES (12, 'Besi 6', 5, 'Y', '1', '2020-10-26 19:57:36');
INSERT INTO `item_list` VALUES (13, 'Besi 10', 5, 'Y', '1', '2020-10-26 19:57:45');
INSERT INTO `item_list` VALUES (14, 'Pasir Pasang', 14, 'Y', '1', '2020-10-26 19:57:56');
INSERT INTO `item_list` VALUES (15, 'Kayu 5/7', 5, 'Y', '1', '2020-10-26 19:59:40');
INSERT INTO `item_list` VALUES (16, 'Besi 8', 5, 'Y', '1', '2020-10-26 19:59:50');

-- ----------------------------
-- Table structure for item_rab
-- ----------------------------
DROP TABLE IF EXISTS `item_rab`;
CREATE TABLE `item_rab`  (
  `ir_id` int NOT NULL AUTO_INCREMENT,
  `ir_item_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ir_un_id` int NULL DEFAULT NULL,
  `ir_seq` int NULL DEFAULT NULL,
  `ir_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`ir_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of item_rab
-- ----------------------------
INSERT INTO `item_rab` VALUES (9, 'Pondasi + Sloof', 12, 1, 'Y', '1', '2020-10-23 13:38:42');
INSERT INTO `item_rab` VALUES (10, 'Tapak Gajah + Kolom', 8, 2, 'Y', '1', '2020-10-23 12:28:07');
INSERT INTO `item_rab` VALUES (11, 'Ring Balok', 7, 3, 'Y', '1', '2020-10-23 12:28:15');
INSERT INTO `item_rab` VALUES (12, 'Plafon', 7, 8, 'Y', '1', '2020-10-23 12:29:16');
INSERT INTO `item_rab` VALUES (13, 'Dinding + Plester', 9, 4, 'Y', '1', '2020-10-23 12:29:23');
INSERT INTO `item_rab` VALUES (14, 'Talang Beton', 7, 5, 'Y', '1', '2020-10-23 12:29:51');
INSERT INTO `item_rab` VALUES (15, 'Dak', 10, 6, 'Y', '1', '2020-10-23 12:29:57');
INSERT INTO `item_rab` VALUES (16, 'Atap', 9, 7, 'Y', '1', '2020-10-23 14:38:41');

-- ----------------------------
-- Table structure for log_access_group
-- ----------------------------
DROP TABLE IF EXISTS `log_access_group`;
CREATE TABLE `log_access_group`  (
  `ag_id` int NOT NULL,
  `ag_ug_id` int NULL DEFAULT NULL,
  `ag_rm_id` int NULL DEFAULT NULL,
  `ag_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_access_group
-- ----------------------------
INSERT INTO `log_access_group` VALUES (1, 1, 1, 'Y', 1, '2020-09-26 10:46:30', 1, 'edit', '2020-09-26 10:46:30', 1);
INSERT INTO `log_access_group` VALUES (122, 1, 4, 'Y', 1, '2020-09-26 10:46:30', 1, 'edit', '2020-09-26 10:46:30', 2);
INSERT INTO `log_access_group` VALUES (5, 1, 5, 'Y', 1, '2020-09-26 10:46:30', 1, 'edit', '2020-09-26 10:46:30', 3);
INSERT INTO `log_access_group` VALUES (123, 1, 35, 'Y', 1, '2020-09-26 10:46:30', 1, 'edit', '2020-09-26 10:46:30', 4);
INSERT INTO `log_access_group` VALUES (124, 1, 40, 'Y', 1, '2020-09-26 10:46:30', 1, 'edit', '2020-09-26 10:46:30', 5);
INSERT INTO `log_access_group` VALUES (132, 1, 42, 'Y', 1, '2020-09-26 10:46:30', 1, 'add', '2020-09-26 10:46:30', 6);
INSERT INTO `log_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-09-26 10:46:30', 1, 'edit', '2020-09-26 10:46:30', 7);
INSERT INTO `log_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-09-26 10:46:30', 1, 'edit', '2020-09-26 10:46:30', 8);
INSERT INTO `log_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-09-26 10:46:30', 1, 'edit', '2020-09-26 10:46:30', 9);
INSERT INTO `log_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-09-26 10:46:30', 1, 'edit', '2020-09-26 10:46:30', 10);
INSERT INTO `log_access_group` VALUES (129, 1, 37, 'Y', 1, '2020-09-26 10:46:30', 1, 'edit', '2020-09-26 10:46:30', 11);
INSERT INTO `log_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-09-26 10:46:30', 1, 'edit', '2020-09-26 10:46:30', 12);
INSERT INTO `log_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-09-26 10:46:30', 1, 'edit', '2020-09-26 10:46:30', 13);
INSERT INTO `log_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-09-26 10:46:30', 1, 'edit', '2020-09-26 10:46:30', 14);

-- ----------------------------
-- Table structure for log_access_menu
-- ----------------------------
DROP TABLE IF EXISTS `log_access_menu`;
CREATE TABLE `log_access_menu`  (
  `am_id` int UNSIGNED NOT NULL,
  `am_user_id` int UNSIGNED NOT NULL,
  `am_menu_id` int UNSIGNED NOT NULL,
  `am_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y',
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime(0) NOT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_access_menu
-- ----------------------------

-- ----------------------------
-- Table structure for log_access_sub_group
-- ----------------------------
DROP TABLE IF EXISTS `log_access_sub_group`;
CREATE TABLE `log_access_sub_group`  (
  `asg_id` int NULL DEFAULT NULL,
  `asg_ug_id` int NULL DEFAULT NULL,
  `asg_usg_id` int NULL DEFAULT NULL,
  `asg_rm_id` int NULL DEFAULT NULL,
  `asg_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_access_sub_group
-- ----------------------------
INSERT INTO `log_access_sub_group` VALUES (7, 1, 1, 1, 'Y', 1, '2020-09-26 19:30:14', 1, 'add', '2020-09-26 19:30:14', 14);
INSERT INTO `log_access_sub_group` VALUES (8, 1, 1, 4, 'Y', 1, '2020-09-26 19:30:14', 1, 'add', '2020-09-26 19:30:14', 15);
INSERT INTO `log_access_sub_group` VALUES (9, 1, 1, 5, 'Y', 1, '2020-09-26 19:30:14', 1, 'add', '2020-09-26 19:30:14', 16);
INSERT INTO `log_access_sub_group` VALUES (10, 1, 1, 40, 'Y', 1, '2020-09-26 19:30:14', 1, 'add', '2020-09-26 19:30:14', 17);
INSERT INTO `log_access_sub_group` VALUES (11, 1, 1, 42, 'Y', 1, '2020-09-26 19:30:14', 1, 'add', '2020-09-26 19:30:14', 18);
INSERT INTO `log_access_sub_group` VALUES (12, 1, 1, 2, 'Y', 1, '2020-09-26 19:30:14', 1, 'add', '2020-09-26 19:30:14', 19);
INSERT INTO `log_access_sub_group` VALUES (13, 1, 1, 36, 'Y', 1, '2020-09-26 19:30:14', 1, 'add', '2020-09-26 19:30:14', 20);
INSERT INTO `log_access_sub_group` VALUES (14, 1, 1, 33, 'Y', 1, '2020-09-26 19:30:14', 1, 'add', '2020-09-26 19:30:14', 21);
INSERT INTO `log_access_sub_group` VALUES (15, 1, 1, 41, 'Y', 1, '2020-09-26 19:30:14', 1, 'add', '2020-09-26 19:30:14', 22);
INSERT INTO `log_access_sub_group` VALUES (16, 1, 1, 37, 'Y', 1, '2020-09-26 19:30:14', 1, 'add', '2020-09-26 19:30:14', 23);
INSERT INTO `log_access_sub_group` VALUES (17, 1, 1, 3, 'Y', 1, '2020-09-26 19:30:15', 1, 'add', '2020-09-26 19:30:15', 24);
INSERT INTO `log_access_sub_group` VALUES (18, 1, 1, 38, 'Y', 1, '2020-09-26 19:30:15', 1, 'add', '2020-09-26 19:30:15', 25);
INSERT INTO `log_access_sub_group` VALUES (19, 1, 1, 39, 'Y', 1, '2020-09-26 19:30:15', 1, 'add', '2020-09-26 19:30:15', 26);

-- ----------------------------
-- Table structure for log_building_type
-- ----------------------------
DROP TABLE IF EXISTS `log_building_type`;
CREATE TABLE `log_building_type`  (
  `bt_id` int NOT NULL,
  `bt_building_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `bt_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_building_type
-- ----------------------------
INSERT INTO `log_building_type` VALUES (13, NULL, 'Y', '1', '2020-10-25 09:55:21', 1, 'add', '2020-10-25 09:55:21', 24);
INSERT INTO `log_building_type` VALUES (14, '45', 'Y', '1', '2020-10-25 09:56:06', 1, 'add', '2020-10-25 09:56:06', 25);
INSERT INTO `log_building_type` VALUES (15, '45', 'Y', '1', '2020-10-25 09:59:09', 1, 'add', '2020-10-25 09:59:09', 26);
INSERT INTO `log_building_type` VALUES (16, '45', 'Y', '1', '2020-10-25 10:00:11', 1, 'add', '2020-10-25 10:00:11', 27);
INSERT INTO `log_building_type` VALUES (17, '90', 'Y', '1', '2020-10-25 10:01:43', 1, 'add', '2020-10-25 10:01:43', 28);
INSERT INTO `log_building_type` VALUES (18, '105', 'Y', '1', '2020-10-25 10:01:51', 1, 'add', '2020-10-25 10:01:51', 29);
INSERT INTO `log_building_type` VALUES (16, 'Type 45', 'Y', '1', '2020-10-25 10:04:29', 1, 'edit', '2020-10-25 10:04:29', 30);
INSERT INTO `log_building_type` VALUES (17, 'Type 90', 'Y', '1', '2020-10-25 10:04:37', 1, 'edit', '2020-10-25 10:04:37', 31);
INSERT INTO `log_building_type` VALUES (18, 'Type 105', 'Y', '1', '2020-10-25 10:05:28', 1, 'edit', '2020-10-25 10:05:28', 32);

-- ----------------------------
-- Table structure for log_item_list
-- ----------------------------
DROP TABLE IF EXISTS `log_item_list`;
CREATE TABLE `log_item_list`  (
  `il_id` int NOT NULL,
  `il_item_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `il_price` decimal(10, 2) NULL DEFAULT NULL,
  `il_un_id` int NULL DEFAULT NULL,
  `il_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_item_list
-- ----------------------------
INSERT INTO `log_item_list` VALUES (3, 'tes', 1000000.00, 1, 'Y', 1, '2020-10-22 01:14:35', 1, 'add', '2020-10-22 01:14:35', 1);
INSERT INTO `log_item_list` VALUES (4, 'asdasdsa', 1000000.00, 1, 'Y', 1, '2020-10-22 01:17:47', 1, 'add', '2020-10-22 01:17:47', 2);
INSERT INTO `log_item_list` VALUES (5, 'asdasd', 12312.00, 1, 'Y', 1, '2020-10-22 01:21:43', 1, 'add', '2020-10-22 01:21:43', 3);
INSERT INTO `log_item_list` VALUES (6, 'asada', 100000.00, 1, 'Y', 1, '2020-10-22 01:26:56', 1, 'add', '2020-10-22 01:26:56', 4);
INSERT INTO `log_item_list` VALUES (7, 'yer', 150000.00, 1, 'Y', 1, '2020-10-22 01:27:19', 1, 'add', '2020-10-22 01:27:19', 5);
INSERT INTO `log_item_list` VALUES (6, 'asada', 150000.00, 1, 'Y', 1, '2020-10-22 01:34:35', 1, 'edit', '2020-10-22 01:34:35', 6);
INSERT INTO `log_item_list` VALUES (5, 'toko', 150000.00, 1, 'Y', 1, '2020-10-22 01:34:45', 1, 'edit', '2020-10-22 01:34:45', 7);
INSERT INTO `log_item_list` VALUES (7, 'yer', 150000.00, 1, 'N', 1, '2020-10-22 01:47:13', 1, 'edit', '2020-10-22 01:47:13', 8);
INSERT INTO `log_item_list` VALUES (5, 'toko', 150000.00, 1, 'N', 1, '2020-10-22 01:47:15', 1, 'edit', '2020-10-22 01:47:15', 9);
INSERT INTO `log_item_list` VALUES (3, 'tes', 1000000.00, 1, 'N', 1, '2020-10-22 01:47:18', 1, 'edit', '2020-10-22 01:47:18', 10);
INSERT INTO `log_item_list` VALUES (8, 'Batu Bata', 400.00, 1, 'Y', 1, '2020-10-22 01:47:47', 1, 'add', '2020-10-22 01:47:47', 11);
INSERT INTO `log_item_list` VALUES (9, 'Kerikil', NULL, 14, 'Y', 1, '2020-10-26 19:52:52', 1, 'add', '2020-10-26 19:52:52', 12);
INSERT INTO `log_item_list` VALUES (10, 'Semen', NULL, 15, 'Y', 1, '2020-10-26 19:57:08', 1, 'add', '2020-10-26 19:57:08', 13);
INSERT INTO `log_item_list` VALUES (11, 'Pasir Cor', NULL, 14, 'Y', 1, '2020-10-26 19:57:26', 1, 'add', '2020-10-26 19:57:26', 14);
INSERT INTO `log_item_list` VALUES (12, 'Besi 6', NULL, 5, 'Y', 1, '2020-10-26 19:57:36', 1, 'add', '2020-10-26 19:57:36', 15);
INSERT INTO `log_item_list` VALUES (13, 'Besi 10', NULL, 5, 'Y', 1, '2020-10-26 19:57:45', 1, 'add', '2020-10-26 19:57:45', 16);
INSERT INTO `log_item_list` VALUES (14, 'Pasir Pasang', NULL, 14, 'Y', 1, '2020-10-26 19:57:56', 1, 'add', '2020-10-26 19:57:56', 17);
INSERT INTO `log_item_list` VALUES (15, 'Kayu 5/7', NULL, 5, 'Y', 1, '2020-10-26 19:59:40', 1, 'add', '2020-10-26 19:59:40', 18);
INSERT INTO `log_item_list` VALUES (16, 'Besi 8', NULL, 5, 'Y', 1, '2020-10-26 19:59:50', 1, 'add', '2020-10-26 19:59:50', 19);

-- ----------------------------
-- Table structure for log_item_rab
-- ----------------------------
DROP TABLE IF EXISTS `log_item_rab`;
CREATE TABLE `log_item_rab`  (
  `ir_id` int NOT NULL,
  `ir_item_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ir_un_id` int NULL DEFAULT NULL,
  `ir_seq` int NULL DEFAULT NULL,
  `ir_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_item_rab
-- ----------------------------
INSERT INTO `log_item_rab` VALUES (9, 'Pondasi + Sloof', 7, NULL, 'Y', 1, '2020-10-23 12:27:24', 1, 'add', '2020-10-23 12:27:24', 12);
INSERT INTO `log_item_rab` VALUES (10, 'Tapak Gajah + Kolom', 8, NULL, 'Y', 1, '2020-10-23 12:28:07', 1, 'add', '2020-10-23 12:28:07', 13);
INSERT INTO `log_item_rab` VALUES (11, 'Ring Balok', 7, NULL, 'Y', 1, '2020-10-23 12:28:15', 1, 'add', '2020-10-23 12:28:15', 14);
INSERT INTO `log_item_rab` VALUES (12, 'Ring Balok', 7, NULL, 'Y', 1, '2020-10-23 12:29:16', 1, 'add', '2020-10-23 12:29:16', 15);
INSERT INTO `log_item_rab` VALUES (13, 'Dinding + Plester', 9, NULL, 'Y', 1, '2020-10-23 12:29:23', 1, 'add', '2020-10-23 12:29:23', 16);
INSERT INTO `log_item_rab` VALUES (14, 'Talang Beton', 7, NULL, 'Y', 1, '2020-10-23 12:29:51', 1, 'add', '2020-10-23 12:29:51', 17);
INSERT INTO `log_item_rab` VALUES (15, 'Dak', 10, NULL, 'Y', 1, '2020-10-23 12:29:57', 1, 'add', '2020-10-23 12:29:57', 18);
INSERT INTO `log_item_rab` VALUES (16, 'Atap', 9, NULL, 'Y', 1, '2020-10-23 12:30:05', 1, 'add', '2020-10-23 12:30:05', 19);
INSERT INTO `log_item_rab` VALUES (17, 'km&amp;sup2;', NULL, NULL, 'Y', 1, '2020-10-23 12:37:04', 1, 'add', '2020-10-23 12:37:04', 20);
INSERT INTO `log_item_rab` VALUES (17, 'km&amp;sup2;', NULL, NULL, 'N', 1, '2020-10-23 12:49:00', 1, 'edit', '2020-10-23 12:49:00', 21);
INSERT INTO `log_item_rab` VALUES (18, 'wedasd', 5, 1, 'Y', 1, '2020-10-23 13:32:08', 1, 'add', '2020-10-23 13:32:08', 22);
INSERT INTO `log_item_rab` VALUES (19, 'ges', 4, 9, 'Y', 1, '2020-10-23 13:34:11', 1, 'add', '2020-10-23 13:34:11', 23);
INSERT INTO `log_item_rab` VALUES (20, 'Tapak Gajah + Kolom', 10, 2, 'Y', 1, '2020-10-23 13:36:11', 1, 'add', '2020-10-23 13:36:11', 24);
INSERT INTO `log_item_rab` VALUES (9, 'Pondasi + Sloof', 8, 1, 'Y', 1, '2020-10-23 13:38:30', 1, 'edit', '2020-10-23 13:38:30', 25);
INSERT INTO `log_item_rab` VALUES (9, 'Pondasi + Sloof', 12, 1, 'Y', 1, '2020-10-23 13:38:42', 1, 'edit', '2020-10-23 13:38:42', 26);
INSERT INTO `log_item_rab` VALUES (19, 'ges', 4, 9, 'N', 1, '2020-10-23 13:44:04', 1, 'edit', '2020-10-23 13:44:04', 27);
INSERT INTO `log_item_rab` VALUES (16, 'Atap', 9, 8, 'N', 1, '2020-10-23 14:38:41', 1, 'edit', '2020-10-23 14:38:41', 28);

-- ----------------------------
-- Table structure for log_menu_access_group
-- ----------------------------
DROP TABLE IF EXISTS `log_menu_access_group`;
CREATE TABLE `log_menu_access_group`  (
  `mag_id` int NOT NULL,
  `mag_ug_id` int NULL DEFAULT NULL,
  `mag_rm_id` int NULL DEFAULT NULL,
  `mag_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 286 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_menu_access_group
-- ----------------------------
INSERT INTO `log_menu_access_group` VALUES (1, 1, 1, 'Y', 1, '2020-10-12 22:33:28', 1, 'edit', '2020-10-12 22:33:28', 1);
INSERT INTO `log_menu_access_group` VALUES (122, 1, 4, 'Y', 1, '2020-10-12 22:33:28', 1, 'edit', '2020-10-12 22:33:28', 2);
INSERT INTO `log_menu_access_group` VALUES (5, 1, 5, 'Y', 1, '2020-10-12 22:33:28', 1, 'edit', '2020-10-12 22:33:28', 3);
INSERT INTO `log_menu_access_group` VALUES (132, 1, 42, 'Y', 1, '2020-10-12 22:33:28', 1, 'edit', '2020-10-12 22:33:28', 4);
INSERT INTO `log_menu_access_group` VALUES (135, 1, 43, 'Y', 1, '2020-10-12 22:33:28', 1, 'edit', '2020-10-12 22:33:28', 5);
INSERT INTO `log_menu_access_group` VALUES (138, 1, 46, 'Y', 1, '2020-10-12 22:33:28', 1, 'edit', '2020-10-12 22:33:28', 6);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-12 22:33:29', 1, 'edit', '2020-10-12 22:33:29', 7);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-12 22:33:29', 1, 'edit', '2020-10-12 22:33:29', 8);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-12 22:33:29', 1, 'edit', '2020-10-12 22:33:29', 9);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-12 22:33:29', 1, 'edit', '2020-10-12 22:33:29', 10);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-12 22:33:29', 1, 'edit', '2020-10-12 22:33:29', 11);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-12 22:33:29', 1, 'edit', '2020-10-12 22:33:29', 12);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-12 22:33:29', 1, 'edit', '2020-10-12 22:33:29', 13);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-12 22:33:29', 1, 'edit', '2020-10-12 22:33:29', 14);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-12 22:33:29', 1, 'edit', '2020-10-12 22:33:29', 15);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-12 22:33:29', 1, 'edit', '2020-10-12 22:33:29', 16);
INSERT INTO `log_menu_access_group` VALUES (1, 1, 1, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 17);
INSERT INTO `log_menu_access_group` VALUES (122, 1, 4, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 18);
INSERT INTO `log_menu_access_group` VALUES (5, 1, 5, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 19);
INSERT INTO `log_menu_access_group` VALUES (132, 1, 42, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 20);
INSERT INTO `log_menu_access_group` VALUES (135, 1, 43, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 21);
INSERT INTO `log_menu_access_group` VALUES (138, 1, 46, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 22);
INSERT INTO `log_menu_access_group` VALUES (140, 1, 47, 'Y', 1, '2020-10-12 23:06:59', 1, 'add', '2020-10-12 23:06:59', 23);
INSERT INTO `log_menu_access_group` VALUES (141, 1, 48, 'Y', 1, '2020-10-12 23:06:59', 1, 'add', '2020-10-12 23:06:59', 24);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 25);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 26);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 27);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 28);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 29);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 30);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 31);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 32);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 33);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-12 23:06:59', 1, 'edit', '2020-10-12 23:06:59', 34);
INSERT INTO `log_menu_access_group` VALUES (1, 1, 1, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 35);
INSERT INTO `log_menu_access_group` VALUES (122, 1, 4, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 36);
INSERT INTO `log_menu_access_group` VALUES (5, 1, 5, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 37);
INSERT INTO `log_menu_access_group` VALUES (132, 1, 42, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 38);
INSERT INTO `log_menu_access_group` VALUES (135, 1, 43, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 39);
INSERT INTO `log_menu_access_group` VALUES (138, 1, 46, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 40);
INSERT INTO `log_menu_access_group` VALUES (140, 1, 47, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 41);
INSERT INTO `log_menu_access_group` VALUES (141, 1, 48, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 42);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 43);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 44);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 45);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 46);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 47);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 48);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 49);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 50);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 51);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-12 23:07:00', 1, 'edit', '2020-10-12 23:07:00', 52);
INSERT INTO `log_menu_access_group` VALUES (1, 1, 1, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 53);
INSERT INTO `log_menu_access_group` VALUES (122, 1, 4, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 54);
INSERT INTO `log_menu_access_group` VALUES (5, 1, 5, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 55);
INSERT INTO `log_menu_access_group` VALUES (132, 1, 42, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 56);
INSERT INTO `log_menu_access_group` VALUES (135, 1, 43, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 57);
INSERT INTO `log_menu_access_group` VALUES (138, 1, 46, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 58);
INSERT INTO `log_menu_access_group` VALUES (140, 1, 47, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 59);
INSERT INTO `log_menu_access_group` VALUES (141, 1, 48, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 60);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 61);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 62);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 63);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 64);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 65);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 66);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 67);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 68);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 69);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-21 23:57:22', 1, 'edit', '2020-10-21 23:57:22', 70);
INSERT INTO `log_menu_access_group` VALUES (142, 1, 49, 'Y', 1, '2020-10-21 23:57:22', 1, 'add', '2020-10-21 23:57:22', 71);
INSERT INTO `log_menu_access_group` VALUES (1, 1, 1, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 72);
INSERT INTO `log_menu_access_group` VALUES (122, 1, 4, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 73);
INSERT INTO `log_menu_access_group` VALUES (5, 1, 5, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 74);
INSERT INTO `log_menu_access_group` VALUES (132, 1, 42, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 75);
INSERT INTO `log_menu_access_group` VALUES (135, 1, 43, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 76);
INSERT INTO `log_menu_access_group` VALUES (138, 1, 46, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 77);
INSERT INTO `log_menu_access_group` VALUES (140, 1, 47, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 78);
INSERT INTO `log_menu_access_group` VALUES (141, 1, 48, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 79);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 80);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 81);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 82);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 83);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 84);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 85);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 86);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 87);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 88);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 89);
INSERT INTO `log_menu_access_group` VALUES (142, 1, 49, 'Y', 1, '2020-10-21 23:57:24', 1, 'edit', '2020-10-21 23:57:24', 90);
INSERT INTO `log_menu_access_group` VALUES (1, 1, 1, 'Y', 1, '2020-10-21 23:58:42', 1, 'edit', '2020-10-21 23:58:42', 91);
INSERT INTO `log_menu_access_group` VALUES (122, 1, 4, 'Y', 1, '2020-10-21 23:58:42', 1, 'edit', '2020-10-21 23:58:42', 92);
INSERT INTO `log_menu_access_group` VALUES (5, 1, 5, 'Y', 1, '2020-10-21 23:58:42', 1, 'edit', '2020-10-21 23:58:42', 93);
INSERT INTO `log_menu_access_group` VALUES (132, 1, 42, 'Y', 1, '2020-10-21 23:58:42', 1, 'edit', '2020-10-21 23:58:42', 94);
INSERT INTO `log_menu_access_group` VALUES (135, 1, 43, 'Y', 1, '2020-10-21 23:58:42', 1, 'edit', '2020-10-21 23:58:42', 95);
INSERT INTO `log_menu_access_group` VALUES (138, 1, 46, 'Y', 1, '2020-10-21 23:58:42', 1, 'edit', '2020-10-21 23:58:42', 96);
INSERT INTO `log_menu_access_group` VALUES (140, 1, 47, 'Y', 1, '2020-10-21 23:58:42', 1, 'edit', '2020-10-21 23:58:43', 97);
INSERT INTO `log_menu_access_group` VALUES (141, 1, 48, 'Y', 1, '2020-10-21 23:58:43', 1, 'edit', '2020-10-21 23:58:43', 98);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-21 23:58:43', 1, 'edit', '2020-10-21 23:58:43', 99);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-21 23:58:43', 1, 'edit', '2020-10-21 23:58:43', 100);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-21 23:58:43', 1, 'edit', '2020-10-21 23:58:43', 101);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-21 23:58:43', 1, 'edit', '2020-10-21 23:58:43', 102);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-21 23:58:43', 1, 'edit', '2020-10-21 23:58:43', 103);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-21 23:58:43', 1, 'edit', '2020-10-21 23:58:43', 104);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-21 23:58:43', 1, 'edit', '2020-10-21 23:58:43', 105);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-21 23:58:43', 1, 'edit', '2020-10-21 23:58:43', 106);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-21 23:58:43', 1, 'edit', '2020-10-21 23:58:43', 107);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-21 23:58:43', 1, 'edit', '2020-10-21 23:58:43', 108);
INSERT INTO `log_menu_access_group` VALUES (142, 1, 49, 'Y', 1, '2020-10-21 23:58:43', 1, 'edit', '2020-10-21 23:58:43', 109);
INSERT INTO `log_menu_access_group` VALUES (143, 1, 50, 'Y', 1, '2020-10-21 23:58:43', 1, 'add', '2020-10-21 23:58:43', 110);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-22 01:51:42', 1, 'edit', '2020-10-22 01:51:42', 111);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-22 01:51:42', 1, 'edit', '2020-10-22 01:51:42', 112);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-22 01:51:42', 1, 'edit', '2020-10-22 01:51:42', 113);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-22 01:51:42', 1, 'edit', '2020-10-22 01:51:42', 114);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-22 01:51:42', 1, 'edit', '2020-10-22 01:51:42', 115);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-22 01:51:42', 1, 'edit', '2020-10-22 01:51:42', 116);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-22 01:51:42', 1, 'edit', '2020-10-22 01:51:42', 117);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-22 01:51:42', 1, 'edit', '2020-10-22 01:51:42', 118);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-22 01:51:42', 1, 'edit', '2020-10-22 01:51:42', 119);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-22 01:51:42', 1, 'edit', '2020-10-22 01:51:42', 120);
INSERT INTO `log_menu_access_group` VALUES (142, 1, 49, 'Y', 1, '2020-10-22 01:51:42', 1, 'edit', '2020-10-22 01:51:42', 121);
INSERT INTO `log_menu_access_group` VALUES (143, 1, 50, 'Y', 1, '2020-10-22 01:51:42', 1, 'edit', '2020-10-22 01:51:42', 122);
INSERT INTO `log_menu_access_group` VALUES (144, 1, 51, 'Y', 1, '2020-10-22 01:51:42', 1, 'add', '2020-10-22 01:51:42', 123);
INSERT INTO `log_menu_access_group` VALUES (145, 1, 52, 'Y', 1, '2020-10-23 11:31:22', 1, 'add', '2020-10-23 11:31:22', 124);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-23 11:31:22', 1, 'edit', '2020-10-23 11:31:22', 125);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-23 11:31:22', 1, 'edit', '2020-10-23 11:31:22', 126);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-23 11:31:22', 1, 'edit', '2020-10-23 11:31:22', 127);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-23 11:31:22', 1, 'edit', '2020-10-23 11:31:22', 128);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-23 11:31:22', 1, 'edit', '2020-10-23 11:31:22', 129);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-23 11:31:22', 1, 'edit', '2020-10-23 11:31:22', 130);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-23 11:31:22', 1, 'edit', '2020-10-23 11:31:22', 131);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-23 11:31:23', 1, 'edit', '2020-10-23 11:31:23', 132);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-23 11:31:23', 1, 'edit', '2020-10-23 11:31:23', 133);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-23 11:31:23', 1, 'edit', '2020-10-23 11:31:23', 134);
INSERT INTO `log_menu_access_group` VALUES (142, 1, 49, 'Y', 1, '2020-10-23 11:31:23', 1, 'edit', '2020-10-23 11:31:23', 135);
INSERT INTO `log_menu_access_group` VALUES (143, 1, 50, 'Y', 1, '2020-10-23 11:31:23', 1, 'edit', '2020-10-23 11:31:23', 136);
INSERT INTO `log_menu_access_group` VALUES (144, 1, 51, 'Y', 1, '2020-10-23 11:31:23', 1, 'edit', '2020-10-23 11:31:23', 137);
INSERT INTO `log_menu_access_group` VALUES (145, 1, 52, 'Y', 1, '2020-10-23 11:41:19', 1, 'edit', '2020-10-23 11:41:19', 138);
INSERT INTO `log_menu_access_group` VALUES (146, 1, 53, 'Y', 1, '2020-10-23 11:41:19', 1, 'add', '2020-10-23 11:41:19', 139);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-23 11:41:19', 1, 'edit', '2020-10-23 11:41:19', 140);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-23 11:41:19', 1, 'edit', '2020-10-23 11:41:19', 141);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-23 11:41:19', 1, 'edit', '2020-10-23 11:41:19', 142);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-23 11:41:19', 1, 'edit', '2020-10-23 11:41:19', 143);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-23 11:41:19', 1, 'edit', '2020-10-23 11:41:19', 144);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-23 11:41:19', 1, 'edit', '2020-10-23 11:41:19', 145);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-23 11:41:19', 1, 'edit', '2020-10-23 11:41:19', 146);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-23 11:41:20', 1, 'edit', '2020-10-23 11:41:20', 147);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-23 11:41:20', 1, 'edit', '2020-10-23 11:41:20', 148);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-23 11:41:20', 1, 'edit', '2020-10-23 11:41:20', 149);
INSERT INTO `log_menu_access_group` VALUES (142, 1, 49, 'Y', 1, '2020-10-23 11:41:20', 1, 'edit', '2020-10-23 11:41:20', 150);
INSERT INTO `log_menu_access_group` VALUES (143, 1, 50, 'Y', 1, '2020-10-23 11:41:20', 1, 'edit', '2020-10-23 11:41:20', 151);
INSERT INTO `log_menu_access_group` VALUES (144, 1, 51, 'Y', 1, '2020-10-23 11:41:20', 1, 'edit', '2020-10-23 11:41:20', 152);
INSERT INTO `log_menu_access_group` VALUES (145, 1, 52, 'Y', 1, '2020-10-23 12:10:53', 1, 'edit', '2020-10-23 12:10:53', 153);
INSERT INTO `log_menu_access_group` VALUES (146, 1, 53, 'Y', 1, '2020-10-23 12:10:54', 1, 'edit', '2020-10-23 12:10:54', 154);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-23 12:10:54', 1, 'edit', '2020-10-23 12:10:54', 155);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-23 12:10:54', 1, 'edit', '2020-10-23 12:10:54', 156);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-23 12:10:54', 1, 'edit', '2020-10-23 12:10:54', 157);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-23 12:10:54', 1, 'edit', '2020-10-23 12:10:54', 158);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-23 12:10:54', 1, 'edit', '2020-10-23 12:10:54', 159);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-23 12:10:54', 1, 'edit', '2020-10-23 12:10:54', 160);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-23 12:10:54', 1, 'edit', '2020-10-23 12:10:54', 161);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-23 12:10:54', 1, 'edit', '2020-10-23 12:10:54', 162);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-23 12:10:54', 1, 'edit', '2020-10-23 12:10:54', 163);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-23 12:10:55', 1, 'edit', '2020-10-23 12:10:55', 164);
INSERT INTO `log_menu_access_group` VALUES (142, 1, 49, 'Y', 1, '2020-10-23 12:10:55', 1, 'edit', '2020-10-23 12:10:55', 165);
INSERT INTO `log_menu_access_group` VALUES (143, 1, 50, 'Y', 1, '2020-10-23 12:10:55', 1, 'edit', '2020-10-23 12:10:55', 166);
INSERT INTO `log_menu_access_group` VALUES (144, 1, 51, 'Y', 1, '2020-10-23 12:10:55', 1, 'edit', '2020-10-23 12:10:55', 167);
INSERT INTO `log_menu_access_group` VALUES (147, 1, 54, 'Y', 1, '2020-10-23 12:10:55', 1, 'add', '2020-10-23 12:10:55', 168);
INSERT INTO `log_menu_access_group` VALUES (145, 1, 52, 'Y', 1, '2020-10-23 12:16:46', 1, 'edit', '2020-10-23 12:16:46', 169);
INSERT INTO `log_menu_access_group` VALUES (146, 1, 53, 'Y', 1, '2020-10-23 12:16:46', 1, 'edit', '2020-10-23 12:16:46', 170);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-23 12:16:46', 1, 'edit', '2020-10-23 12:16:46', 171);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-23 12:16:46', 1, 'edit', '2020-10-23 12:16:46', 172);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-23 12:16:47', 1, 'edit', '2020-10-23 12:16:47', 173);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-23 12:16:47', 1, 'edit', '2020-10-23 12:16:47', 174);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-23 12:16:47', 1, 'edit', '2020-10-23 12:16:47', 175);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-23 12:16:47', 1, 'edit', '2020-10-23 12:16:47', 176);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-23 12:16:47', 1, 'edit', '2020-10-23 12:16:47', 177);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-23 12:16:47', 1, 'edit', '2020-10-23 12:16:47', 178);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-23 12:16:47', 1, 'edit', '2020-10-23 12:16:47', 179);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-23 12:16:47', 1, 'edit', '2020-10-23 12:16:47', 180);
INSERT INTO `log_menu_access_group` VALUES (142, 1, 49, 'Y', 1, '2020-10-23 12:16:47', 1, 'edit', '2020-10-23 12:16:47', 181);
INSERT INTO `log_menu_access_group` VALUES (143, 1, 50, 'Y', 1, '2020-10-23 12:16:47', 1, 'edit', '2020-10-23 12:16:47', 182);
INSERT INTO `log_menu_access_group` VALUES (144, 1, 51, 'Y', 1, '2020-10-23 12:16:47', 1, 'edit', '2020-10-23 12:16:47', 183);
INSERT INTO `log_menu_access_group` VALUES (147, 1, 54, 'Y', 1, '2020-10-23 12:16:47', 1, 'edit', '2020-10-23 12:16:47', 184);
INSERT INTO `log_menu_access_group` VALUES (148, 1, 55, 'Y', 1, '2020-10-23 12:16:48', 1, 'add', '2020-10-23 12:16:48', 185);
INSERT INTO `log_menu_access_group` VALUES (145, 1, 52, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 186);
INSERT INTO `log_menu_access_group` VALUES (146, 1, 53, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 187);
INSERT INTO `log_menu_access_group` VALUES (147, 1, 54, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 188);
INSERT INTO `log_menu_access_group` VALUES (148, 1, 55, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 189);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 190);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 191);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 192);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 193);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 194);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 195);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 196);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 197);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 198);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 199);
INSERT INTO `log_menu_access_group` VALUES (142, 1, 49, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 200);
INSERT INTO `log_menu_access_group` VALUES (143, 1, 50, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 201);
INSERT INTO `log_menu_access_group` VALUES (144, 1, 51, 'Y', 1, '2020-10-25 08:41:16', 1, 'edit', '2020-10-25 08:41:16', 202);
INSERT INTO `log_menu_access_group` VALUES (149, 1, 56, 'Y', 1, '2020-10-25 08:41:16', 1, 'add', '2020-10-25 08:41:16', 203);
INSERT INTO `log_menu_access_group` VALUES (145, 1, 52, 'Y', 1, '2020-10-27 10:02:29', 1, 'edit', '2020-10-27 10:02:29', 204);
INSERT INTO `log_menu_access_group` VALUES (147, 1, 54, 'Y', 1, '2020-10-27 10:02:29', 1, 'edit', '2020-10-27 10:02:29', 205);
INSERT INTO `log_menu_access_group` VALUES (146, 1, 53, 'Y', 1, '2020-10-27 10:02:29', 1, 'edit', '2020-10-27 10:02:29', 206);
INSERT INTO `log_menu_access_group` VALUES (148, 1, 55, 'Y', 1, '2020-10-27 10:02:29', 1, 'edit', '2020-10-27 10:02:29', 207);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-27 10:02:29', 1, 'edit', '2020-10-27 10:02:29', 208);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-27 10:02:29', 1, 'edit', '2020-10-27 10:02:29', 209);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-27 10:02:29', 1, 'edit', '2020-10-27 10:02:29', 210);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-27 10:02:29', 1, 'edit', '2020-10-27 10:02:29', 211);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-27 10:02:29', 1, 'edit', '2020-10-27 10:02:29', 212);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-27 10:02:30', 1, 'edit', '2020-10-27 10:02:30', 213);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-27 10:02:30', 1, 'edit', '2020-10-27 10:02:30', 214);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-27 10:02:30', 1, 'edit', '2020-10-27 10:02:30', 215);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-27 10:02:30', 1, 'edit', '2020-10-27 10:02:30', 216);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-27 10:02:30', 1, 'edit', '2020-10-27 10:02:30', 217);
INSERT INTO `log_menu_access_group` VALUES (142, 1, 49, 'Y', 1, '2020-10-27 10:02:30', 1, 'edit', '2020-10-27 10:02:30', 218);
INSERT INTO `log_menu_access_group` VALUES (143, 1, 50, 'Y', 1, '2020-10-27 10:02:31', 1, 'edit', '2020-10-27 10:02:31', 219);
INSERT INTO `log_menu_access_group` VALUES (144, 1, 51, 'Y', 1, '2020-10-27 10:02:31', 1, 'edit', '2020-10-27 10:02:31', 220);
INSERT INTO `log_menu_access_group` VALUES (149, 1, 56, 'Y', 1, '2020-10-27 10:02:31', 1, 'edit', '2020-10-27 10:02:31', 221);
INSERT INTO `log_menu_access_group` VALUES (150, 1, 57, 'Y', 1, '2020-10-27 10:02:31', 1, 'add', '2020-10-27 10:02:31', 222);
INSERT INTO `log_menu_access_group` VALUES (145, 1, 52, 'Y', 1, '2020-10-27 10:08:14', 1, 'edit', '2020-10-27 10:08:14', 223);
INSERT INTO `log_menu_access_group` VALUES (147, 1, 54, 'Y', 1, '2020-10-27 10:08:14', 1, 'edit', '2020-10-27 10:08:14', 224);
INSERT INTO `log_menu_access_group` VALUES (146, 1, 53, 'Y', 1, '2020-10-27 10:08:15', 1, 'edit', '2020-10-27 10:08:15', 225);
INSERT INTO `log_menu_access_group` VALUES (148, 1, 55, 'Y', 1, '2020-10-27 10:08:15', 1, 'edit', '2020-10-27 10:08:15', 226);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-27 10:08:15', 1, 'edit', '2020-10-27 10:08:15', 227);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-27 10:08:15', 1, 'edit', '2020-10-27 10:08:15', 228);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-27 10:08:15', 1, 'edit', '2020-10-27 10:08:15', 229);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-27 10:08:15', 1, 'edit', '2020-10-27 10:08:15', 230);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-27 10:08:15', 1, 'edit', '2020-10-27 10:08:15', 231);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-27 10:08:15', 1, 'edit', '2020-10-27 10:08:15', 232);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-27 10:08:15', 1, 'edit', '2020-10-27 10:08:15', 233);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-27 10:08:15', 1, 'edit', '2020-10-27 10:08:15', 234);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-27 10:08:16', 1, 'edit', '2020-10-27 10:08:16', 235);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-27 10:08:16', 1, 'edit', '2020-10-27 10:08:16', 236);
INSERT INTO `log_menu_access_group` VALUES (142, 1, 49, 'Y', 1, '2020-10-27 10:08:16', 1, 'edit', '2020-10-27 10:08:16', 237);
INSERT INTO `log_menu_access_group` VALUES (143, 1, 50, 'Y', 1, '2020-10-27 10:08:16', 1, 'edit', '2020-10-27 10:08:16', 238);
INSERT INTO `log_menu_access_group` VALUES (144, 1, 51, 'Y', 1, '2020-10-27 10:08:16', 1, 'edit', '2020-10-27 10:08:16', 239);
INSERT INTO `log_menu_access_group` VALUES (149, 1, 56, 'Y', 1, '2020-10-27 10:08:16', 1, 'edit', '2020-10-27 10:08:16', 240);
INSERT INTO `log_menu_access_group` VALUES (150, 1, 57, 'Y', 1, '2020-10-27 10:08:16', 1, 'edit', '2020-10-27 10:08:16', 241);
INSERT INTO `log_menu_access_group` VALUES (151, 1, 58, 'Y', 1, '2020-10-27 10:08:17', 1, 'add', '2020-10-27 10:08:17', 242);
INSERT INTO `log_menu_access_group` VALUES (145, 1, 52, 'Y', 1, '2020-10-27 10:24:32', 1, 'edit', '2020-10-27 10:24:32', 243);
INSERT INTO `log_menu_access_group` VALUES (152, 1, 59, 'Y', 1, '2020-10-27 10:24:32', 1, 'add', '2020-10-27 10:24:32', 244);
INSERT INTO `log_menu_access_group` VALUES (147, 1, 54, 'Y', 1, '2020-10-27 10:24:32', 1, 'edit', '2020-10-27 10:24:32', 245);
INSERT INTO `log_menu_access_group` VALUES (146, 1, 53, 'Y', 1, '2020-10-27 10:24:32', 1, 'edit', '2020-10-27 10:24:32', 246);
INSERT INTO `log_menu_access_group` VALUES (148, 1, 55, 'Y', 1, '2020-10-27 10:24:32', 1, 'edit', '2020-10-27 10:24:32', 247);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-27 10:24:32', 1, 'edit', '2020-10-27 10:24:32', 248);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-27 10:24:32', 1, 'edit', '2020-10-27 10:24:32', 249);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-27 10:24:33', 1, 'edit', '2020-10-27 10:24:33', 250);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-27 10:24:33', 1, 'edit', '2020-10-27 10:24:33', 251);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-27 10:24:33', 1, 'edit', '2020-10-27 10:24:33', 252);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-27 10:24:33', 1, 'edit', '2020-10-27 10:24:33', 253);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-27 10:24:33', 1, 'edit', '2020-10-27 10:24:33', 254);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-27 10:24:33', 1, 'edit', '2020-10-27 10:24:33', 255);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-27 10:24:33', 1, 'edit', '2020-10-27 10:24:33', 256);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-27 10:24:33', 1, 'edit', '2020-10-27 10:24:33', 257);
INSERT INTO `log_menu_access_group` VALUES (142, 1, 49, 'Y', 1, '2020-10-27 10:24:33', 1, 'edit', '2020-10-27 10:24:33', 258);
INSERT INTO `log_menu_access_group` VALUES (143, 1, 50, 'Y', 1, '2020-10-27 10:24:33', 1, 'edit', '2020-10-27 10:24:33', 259);
INSERT INTO `log_menu_access_group` VALUES (144, 1, 51, 'Y', 1, '2020-10-27 10:24:33', 1, 'edit', '2020-10-27 10:24:33', 260);
INSERT INTO `log_menu_access_group` VALUES (149, 1, 56, 'Y', 1, '2020-10-27 10:24:34', 1, 'edit', '2020-10-27 10:24:34', 261);
INSERT INTO `log_menu_access_group` VALUES (150, 1, 57, 'Y', 1, '2020-10-27 10:24:34', 1, 'edit', '2020-10-27 10:24:34', 262);
INSERT INTO `log_menu_access_group` VALUES (151, 1, 58, 'Y', 1, '2020-10-27 10:24:34', 1, 'edit', '2020-10-27 10:24:34', 263);
INSERT INTO `log_menu_access_group` VALUES (145, 1, 52, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 264);
INSERT INTO `log_menu_access_group` VALUES (152, 1, 59, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 265);
INSERT INTO `log_menu_access_group` VALUES (147, 1, 54, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 266);
INSERT INTO `log_menu_access_group` VALUES (146, 1, 53, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 267);
INSERT INTO `log_menu_access_group` VALUES (148, 1, 55, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 268);
INSERT INTO `log_menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 269);
INSERT INTO `log_menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 270);
INSERT INTO `log_menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 271);
INSERT INTO `log_menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 272);
INSERT INTO `log_menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 273);
INSERT INTO `log_menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 274);
INSERT INTO `log_menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 275);
INSERT INTO `log_menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 276);
INSERT INTO `log_menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 277);
INSERT INTO `log_menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 278);
INSERT INTO `log_menu_access_group` VALUES (142, 1, 49, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 279);
INSERT INTO `log_menu_access_group` VALUES (143, 1, 50, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 280);
INSERT INTO `log_menu_access_group` VALUES (144, 1, 51, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 281);
INSERT INTO `log_menu_access_group` VALUES (149, 1, 56, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 282);
INSERT INTO `log_menu_access_group` VALUES (150, 1, 57, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 283);
INSERT INTO `log_menu_access_group` VALUES (151, 1, 58, 'Y', 1, '2020-10-30 01:24:23', 1, 'edit', '2020-10-30 01:24:23', 284);
INSERT INTO `log_menu_access_group` VALUES (153, 1, 60, 'Y', 1, '2020-10-30 01:24:23', 1, 'add', '2020-10-30 01:24:23', 285);

-- ----------------------------
-- Table structure for log_menu_access_sub_group
-- ----------------------------
DROP TABLE IF EXISTS `log_menu_access_sub_group`;
CREATE TABLE `log_menu_access_sub_group`  (
  `masg_id` int NULL DEFAULT NULL,
  `masg_ug_id` int NULL DEFAULT NULL,
  `masg_usg_id` int NULL DEFAULT NULL,
  `masg_rm_id` int NULL DEFAULT NULL,
  `masg_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_menu_access_sub_group
-- ----------------------------

-- ----------------------------
-- Table structure for log_menu_access_user
-- ----------------------------
DROP TABLE IF EXISTS `log_menu_access_user`;
CREATE TABLE `log_menu_access_user`  (
  `mau_id` int UNSIGNED NOT NULL,
  `mau_user_id` int UNSIGNED NOT NULL,
  `mau_menu_id` int UNSIGNED NOT NULL,
  `mau_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y',
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime(0) NOT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_menu_access_user
-- ----------------------------

-- ----------------------------
-- Table structure for log_projects
-- ----------------------------
DROP TABLE IF EXISTS `log_projects`;
CREATE TABLE `log_projects`  (
  `p_id` int NOT NULL,
  `p_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p_location` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_projects
-- ----------------------------
INSERT INTO `log_projects` VALUES (1, 'Srikandi', 'Jl Delima', 'Y', 1, '2020-10-29 00:41:11', 1, 'add', '2020-10-29 00:41:11', 1);
INSERT INTO `log_projects` VALUES (2, 'Srikandi', 'Jl Delima', 'Y', 1, '2020-10-29 00:41:20', 1, 'add', '2020-10-29 00:41:20', 2);
INSERT INTO `log_projects` VALUES (3, 'Perumahan Srikandi', 'Jl Srikandi No 1', 'Y', 1, '2020-10-29 00:41:50', 1, 'add', '2020-10-29 00:41:50', 3);
INSERT INTO `log_projects` VALUES (4, 'Perumahan Tapung Kampar', 'Kampar', 'Y', 1, '2020-10-29 01:37:31', 1, 'add', '2020-10-29 01:37:31', 4);
INSERT INTO `log_projects` VALUES (3, 'Perumahan Srikandi 1', 'Jl Srikandi No 1', 'Y', 1, '2020-10-29 02:52:58', 1, 'edit', '2020-10-29 02:52:58', 5);
INSERT INTO `log_projects` VALUES (3, 'Perumahan Srikandi 1asdasd', 'Jl Srikandi No 1', 'Y', 1, '2020-10-29 02:53:47', 1, 'edit', '2020-10-29 02:53:47', 6);
INSERT INTO `log_projects` VALUES (3, 'Perumahan Srikandi', 'Jl Srikandi No 1', 'Y', 1, '2020-10-29 03:04:53', 1, 'edit', '2020-10-29 03:04:53', 7);
INSERT INTO `log_projects` VALUES (5, 'tes', 'tes', 'Y', 1, '2020-10-29 22:53:51', 1, 'add', '2020-10-29 22:53:51', 8);
INSERT INTO `log_projects` VALUES (5, 'tes', 'tes', 'N', 1, '2020-10-29 22:53:56', 1, 'edit', '2020-10-29 22:53:56', 9);
INSERT INTO `log_projects` VALUES (5, 'tes', 'tes', 'N', 1, '2020-10-29 22:55:36', 1, 'edit', '2020-10-29 22:55:36', 10);

-- ----------------------------
-- Table structure for log_projects_sub
-- ----------------------------
DROP TABLE IF EXISTS `log_projects_sub`;
CREATE TABLE `log_projects_sub`  (
  `ps_id` int NOT NULL,
  `ps_p_id` int NULL DEFAULT NULL,
  `ps_bt_id` int NULL DEFAULT NULL,
  `ps_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ps_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_projects_sub
-- ----------------------------
INSERT INTO `log_projects_sub` VALUES (3, 3, 16, 'A1', 'Y', 1, '2020-10-29 01:45:21', 1, 'add', '2020-10-29 01:45:21', 3);
INSERT INTO `log_projects_sub` VALUES (4, 4, 16, 'Blok 1', 'Y', 1, '2020-10-29 02:34:50', 1, 'add', '2020-10-29 02:34:50', 4);
INSERT INTO `log_projects_sub` VALUES (5, 3, 16, 'A2', 'Y', 1, '2020-10-29 02:35:35', 1, 'add', '2020-10-29 02:35:35', 5);
INSERT INTO `log_projects_sub` VALUES (6, 3, 16, 'A4', 'Y', 1, '2020-10-29 02:37:52', 1, 'add', '2020-10-29 02:37:52', 6);
INSERT INTO `log_projects_sub` VALUES (7, 4, 17, 'Blok 1', 'Y', 1, '2020-10-29 02:38:06', 1, 'add', '2020-10-29 02:38:06', 7);
INSERT INTO `log_projects_sub` VALUES (4, 4, 16, 'Blok 1as', 'Y', 1, '2020-10-29 23:02:38', 1, 'edit', '2020-10-29 23:02:38', 8);
INSERT INTO `log_projects_sub` VALUES (4, 4, 16, 'Blok 1', 'Y', 1, '2020-10-29 23:02:48', 1, 'edit', '2020-10-29 23:02:48', 9);
INSERT INTO `log_projects_sub` VALUES (8, 3, 16, 'asdsadsa', 'Y', 1, '2020-10-29 23:03:53', 1, 'add', '2020-10-29 23:03:53', 10);
INSERT INTO `log_projects_sub` VALUES (8, 3, 16, 'asdsadsa', 'N', 1, '2020-10-29 23:03:56', 1, 'edit', '2020-10-29 23:03:56', 11);
INSERT INTO `log_projects_sub` VALUES (8, 3, 16, 'asdsadsa', 'N', 1, '2020-10-29 23:05:55', 1, 'edit', '2020-10-29 23:05:55', 12);
INSERT INTO `log_projects_sub` VALUES (8, 3, 16, 'asdsadsa', 'N', 1, '2020-10-29 23:07:13', 1, 'edit', '2020-10-29 23:07:13', 13);
INSERT INTO `log_projects_sub` VALUES (8, 3, 16, 'asdsadsa', 'N', 1, '2020-10-29 23:10:39', 1, 'edit', '2020-10-29 23:10:39', 14);
INSERT INTO `log_projects_sub` VALUES (8, 3, 16, 'asdsadsa', 'N', 1, '2020-10-29 23:11:55', 1, 'edit', '2020-10-29 23:11:55', 15);
INSERT INTO `log_projects_sub` VALUES (8, 3, 16, 'asdsadsa', 'N', 1, '2020-10-29 23:12:22', 1, 'edit', '2020-10-29 23:12:22', 16);
INSERT INTO `log_projects_sub` VALUES (8, 3, 16, 'asdsadsa', 'N', 1, '2020-10-29 23:13:40', 1, 'edit', '2020-10-29 23:13:40', 17);
INSERT INTO `log_projects_sub` VALUES (8, 3, 16, 'asdsadsa', 'N', 1, '2020-10-29 23:19:41', 1, 'edit', '2020-10-29 23:19:41', 18);
INSERT INTO `log_projects_sub` VALUES (8, 3, 16, 'asdsadsa', 'N', 1, '2020-10-29 23:36:37', 1, 'edit', '2020-10-29 23:36:37', 19);

-- ----------------------------
-- Table structure for log_rab_building
-- ----------------------------
DROP TABLE IF EXISTS `log_rab_building`;
CREATE TABLE `log_rab_building`  (
  `rb_id` int NOT NULL,
  `rb_bt_id` int NULL DEFAULT NULL,
  `rb_rl_id` int NULL DEFAULT NULL,
  `rb_il_id` int NULL DEFAULT NULL,
  `rb_measure` int NULL DEFAULT NULL,
  `rb_summary` int NULL DEFAULT NULL,
  `rb_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_rab_building
-- ----------------------------
INSERT INTO `log_rab_building` VALUES (5, 16, 4, NULL, 5454878, 2181951, 'Y', 1, '2020-10-28 00:18:48', 1, 'add', '2020-10-28 00:18:48', 1);
INSERT INTO `log_rab_building` VALUES (1, 16, 2, NULL, 10, 200, 'Y', 1, '2020-10-28 00:18:48', 1, 'edit', '2020-10-28 00:18:48', 2);
INSERT INTO `log_rab_building` VALUES (2, 16, 3, NULL, 15, 894464545, 'Y', 1, '2020-10-28 00:18:48', 1, 'edit', '2020-10-28 00:18:48', 3);
INSERT INTO `log_rab_building` VALUES (5, 16, 4, NULL, 54845, 21938, 'Y', 1, '2020-10-28 00:19:03', 1, 'edit', '2020-10-28 00:19:03', 4);
INSERT INTO `log_rab_building` VALUES (1, 16, 2, NULL, 10, 200, 'Y', 1, '2020-10-28 00:19:03', 1, 'edit', '2020-10-28 00:19:03', 5);
INSERT INTO `log_rab_building` VALUES (2, 16, 3, NULL, 15, 894464545, 'Y', 1, '2020-10-28 00:19:03', 1, 'edit', '2020-10-28 00:19:03', 6);
INSERT INTO `log_rab_building` VALUES (6, 17, 4, NULL, 54548, 21819, 'Y', 1, '2020-10-28 00:19:19', 1, 'add', '2020-10-28 00:19:19', 7);
INSERT INTO `log_rab_building` VALUES (7, 17, 2, NULL, 1254, 137940, 'Y', 1, '2020-10-28 00:19:19', 1, 'add', '2020-10-28 00:19:19', 8);
INSERT INTO `log_rab_building` VALUES (8, 17, 3, NULL, 215, 17200, 'Y', 1, '2020-10-28 00:19:19', 1, 'add', '2020-10-28 00:19:19', 9);
INSERT INTO `log_rab_building` VALUES (5, 16, 4, NULL, 54845, 21938, 'Y', 1, '2020-10-30 00:06:18', 1, 'edit', '2020-10-30 00:06:18', 10);
INSERT INTO `log_rab_building` VALUES (1, 16, 2, NULL, 10, 200, 'Y', 1, '2020-10-30 00:06:18', 1, 'edit', '2020-10-30 00:06:18', 11);
INSERT INTO `log_rab_building` VALUES (2, 16, 3, NULL, 12, 960, 'Y', 1, '2020-10-30 00:06:18', 1, 'edit', '2020-10-30 00:06:18', 12);
INSERT INTO `log_rab_building` VALUES (6, 17, 4, NULL, 54548, 21819, 'Y', 1, '2020-10-30 00:06:34', 1, 'edit', '2020-10-30 00:06:34', 13);
INSERT INTO `log_rab_building` VALUES (7, 17, 2, NULL, 150, 16500, 'Y', 1, '2020-10-30 00:06:34', 1, 'edit', '2020-10-30 00:06:34', 14);
INSERT INTO `log_rab_building` VALUES (8, 17, 3, NULL, 20, 1600, 'Y', 1, '2020-10-30 00:06:34', 1, 'edit', '2020-10-30 00:06:34', 15);
INSERT INTO `log_rab_building` VALUES (5, 16, 4, NULL, 54845, 21938, 'Y', 1, '2020-10-30 00:10:30', 1, 'edit', '2020-10-30 00:10:30', 16);
INSERT INTO `log_rab_building` VALUES (1, 16, 2, NULL, 10, 200, 'Y', 1, '2020-10-30 00:10:30', 1, 'edit', '2020-10-30 00:10:30', 17);
INSERT INTO `log_rab_building` VALUES (2, 16, 3, NULL, 12, 960, 'Y', 1, '2020-10-30 00:10:30', 1, 'edit', '2020-10-30 00:10:30', 18);
INSERT INTO `log_rab_building` VALUES (5, 16, 4, 10, 54845, 21938, 'Y', 1, '2020-10-30 00:11:12', 1, 'edit', '2020-10-30 00:11:12', 19);
INSERT INTO `log_rab_building` VALUES (1, 16, 2, 8, 10, 200, 'Y', 1, '2020-10-30 00:11:12', 1, 'edit', '2020-10-30 00:11:12', 20);
INSERT INTO `log_rab_building` VALUES (2, 16, 3, 8, 12, 960, 'Y', 1, '2020-10-30 00:11:12', 1, 'edit', '2020-10-30 00:11:12', 21);
INSERT INTO `log_rab_building` VALUES (5, 16, 4, 10, 54845, 21938, 'Y', 1, '2020-10-30 00:26:09', 1, 'edit', '2020-10-30 00:26:09', 22);
INSERT INTO `log_rab_building` VALUES (1, 16, 2, 8, 10, 200, 'Y', 1, '2020-10-30 00:26:09', 1, 'edit', '2020-10-30 00:26:09', 23);
INSERT INTO `log_rab_building` VALUES (9, 16, 5, 10, 120, 12, 'Y', 1, '2020-10-30 00:26:09', 1, 'add', '2020-10-30 00:26:09', 24);
INSERT INTO `log_rab_building` VALUES (10, 16, 6, 9, 120, 2, 'Y', 1, '2020-10-30 00:26:09', 1, 'add', '2020-10-30 00:26:09', 25);
INSERT INTO `log_rab_building` VALUES (2, 16, 3, 8, 12, 960, 'Y', 1, '2020-10-30 00:26:09', 1, 'edit', '2020-10-30 00:26:09', 26);
INSERT INTO `log_rab_building` VALUES (11, 16, 7, 10, 240, 96, 'Y', 1, '2020-10-30 00:26:09', 1, 'add', '2020-10-30 00:26:09', 27);
INSERT INTO `log_rab_building` VALUES (5, 16, 4, 10, 60, 24, 'Y', 1, '2020-10-30 00:26:44', 1, 'edit', '2020-10-30 00:26:44', 28);
INSERT INTO `log_rab_building` VALUES (1, 16, 2, 8, 10, 200, 'Y', 1, '2020-10-30 00:26:44', 1, 'edit', '2020-10-30 00:26:44', 29);
INSERT INTO `log_rab_building` VALUES (9, 16, 5, 10, 120, 12, 'Y', 1, '2020-10-30 00:26:44', 1, 'edit', '2020-10-30 00:26:44', 30);
INSERT INTO `log_rab_building` VALUES (10, 16, 6, 9, 120, 2, 'Y', 1, '2020-10-30 00:26:44', 1, 'edit', '2020-10-30 00:26:44', 31);
INSERT INTO `log_rab_building` VALUES (2, 16, 3, 8, 12, 960, 'Y', 1, '2020-10-30 00:26:44', 1, 'edit', '2020-10-30 00:26:44', 32);
INSERT INTO `log_rab_building` VALUES (11, 16, 7, 10, 240, 96, 'Y', 1, '2020-10-30 00:26:44', 1, 'edit', '2020-10-30 00:26:44', 33);

-- ----------------------------
-- Table structure for log_rab_list
-- ----------------------------
DROP TABLE IF EXISTS `log_rab_list`;
CREATE TABLE `log_rab_list`  (
  `rl_id` int NOT NULL,
  `rl_ir_id` int NULL DEFAULT NULL,
  `rl_il_id` int NULL DEFAULT NULL,
  `rl_un_id` int NULL DEFAULT NULL,
  `rl_volume` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rl_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_rab_list
-- ----------------------------
INSERT INTO `log_rab_list` VALUES (2, 9, 8, 13, '110', 'Y', 1, '2020-10-26 19:48:03', 1, 'add', '2020-10-26 19:48:03', 1);
INSERT INTO `log_rab_list` VALUES (3, 13, 8, 13, '80', 'Y', 1, '2020-10-26 19:48:46', 1, 'add', '2020-10-26 19:48:46', 2);
INSERT INTO `log_rab_list` VALUES (4, 9, 10, 15, '0.4', 'Y', 1, '2020-10-26 20:00:14', 1, 'add', '2020-10-26 20:00:14', 3);
INSERT INTO `log_rab_list` VALUES (2, 10, 8, 12, '110', 'Y', 1, '2020-10-26 20:20:30', 1, 'edit', '2020-10-26 20:20:30', 4);
INSERT INTO `log_rab_list` VALUES (2, 10, 8, 13, '110', 'Y', 1, '2020-10-26 20:20:40', 1, 'edit', '2020-10-26 20:20:40', 5);
INSERT INTO `log_rab_list` VALUES (2, 10, 8, 13, '110', 'Y', 1, '2020-10-26 20:20:57', 1, 'edit', '2020-10-26 20:20:57', 6);
INSERT INTO `log_rab_list` VALUES (2, 10, 8, 15, '110', 'Y', 1, '2020-10-26 20:21:09', 1, 'edit', '2020-10-26 20:21:09', 7);
INSERT INTO `log_rab_list` VALUES (2, 10, 8, 13, '110', 'Y', 1, '2020-10-26 20:36:11', 1, 'edit', '2020-10-26 20:36:11', 8);
INSERT INTO `log_rab_list` VALUES (4, 9, 10, 14, '0.4', 'Y', 1, '2020-10-26 20:36:16', 1, 'edit', '2020-10-26 20:36:16', 9);
INSERT INTO `log_rab_list` VALUES (5, 11, 10, 15, '0.1', 'Y', 1, '2020-10-30 00:21:41', 1, 'add', '2020-10-30 00:21:41', 10);
INSERT INTO `log_rab_list` VALUES (6, 11, 9, 14, '0.015', 'Y', 1, '2020-10-30 00:24:52', 1, 'add', '2020-10-30 00:24:52', 11);
INSERT INTO `log_rab_list` VALUES (7, 13, 10, 15, '0.4', 'Y', 1, '2020-10-30 00:25:33', 1, 'add', '2020-10-30 00:25:33', 12);

-- ----------------------------
-- Table structure for log_ref_menu
-- ----------------------------
DROP TABLE IF EXISTS `log_ref_menu`;
CREATE TABLE `log_ref_menu`  (
  `rm_id` int NOT NULL,
  `rm_parent_id` int UNSIGNED NULL DEFAULT NULL,
  `rm_caption` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `rm_description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `rm_url` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `rm_icon` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `rm_sequence` int UNSIGNED NOT NULL DEFAULT 1,
  `rm_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y',
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime(0) NOT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime(0) NULL DEFAULT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_ref_menu
-- ----------------------------
INSERT INTO `log_ref_menu` VALUES (1, NULL, 'Findings', 'Findings', 'trademark/invented_brand', 'fas fa-search', 1, 'Y', 1, '2020-10-12 22:32:29', 1, 'edit', '2020-10-12 22:32:29', 7);
INSERT INTO `log_ref_menu` VALUES (43, 4, 'Similar Letters and/or Numbers', 'Similar Letters and/or Numbers', 'trademark/similar_letters', 'fas fa-font', 4, 'Y', 1, '2020-10-12 22:35:35', 1, 'edit', '2020-10-12 22:35:35', 8);
INSERT INTO `log_ref_menu` VALUES (48, 4, 'BRM List', 'BRM List', 'trademark/brm_list', 'fas fa-list', 6, 'Y', 1, '2020-10-12 23:06:45', 1, 'add', '2020-10-12 23:06:45', 9);
INSERT INTO `log_ref_menu` VALUES (49, 2, 'Master Data', 'Master Data', NULL, 'fas fa-table', 3, 'Y', 1, '2020-10-21 23:57:12', 1, 'add', '2020-10-21 23:57:12', 10);
INSERT INTO `log_ref_menu` VALUES (50, 49, 'Item List', 'Item List', 'settings/item_list', 'fas fa-list', 1, 'Y', 1, '2020-10-21 23:58:26', 1, 'add', '2020-10-21 23:58:26', 11);
INSERT INTO `log_ref_menu` VALUES (51, 49, 'Item Unit', 'Item Unit', 'settings/item_unit', 'fas fa-boxes', 2, 'Y', 1, '2020-10-22 01:51:26', 1, 'add', '2020-10-22 01:51:26', 12);
INSERT INTO `log_ref_menu` VALUES (52, NULL, 'PROJECTS', 'DATA PROJECTS', NULL, 'fas fa-briefcase', 1, 'Y', 1, '2020-10-23 11:31:10', 1, 'add', '2020-10-23 11:31:10', 13);
INSERT INTO `log_ref_menu` VALUES (52, NULL, 'Projects', 'Data Projects', NULL, 'fas fa-briefcase', 1, 'Y', 1, '2020-10-23 11:31:38', 1, 'edit', '2020-10-23 11:31:38', 14);
INSERT INTO `log_ref_menu` VALUES (52, NULL, 'Master Data', 'Master Data', NULL, 'fas fa-briefcase', 1, 'Y', 1, '2020-10-23 11:40:02', 1, 'edit', '2020-10-23 11:40:02', 15);
INSERT INTO `log_ref_menu` VALUES (53, 52, 'RAB', 'RAB Data', 'master_data', 'fas fa-building', 1, 'Y', 1, '2020-10-23 11:41:11', 1, 'add', '2020-10-23 11:41:11', 16);
INSERT INTO `log_ref_menu` VALUES (53, 52, 'RAB', 'RAB Data', 'master_data/rab', 'fas fa-building', 1, 'Y', 1, '2020-10-23 11:43:51', 1, 'edit', '2020-10-23 11:43:51', 17);
INSERT INTO `log_ref_menu` VALUES (54, 49, 'Template RAB', 'Template RAB', 'settings/rab_template', 'fas fa-ruler-vertical', 3, 'Y', 1, '2020-10-23 12:10:43', 1, 'add', '2020-10-23 12:10:43', 18);
INSERT INTO `log_ref_menu` VALUES (54, 2, 'Template RAB', 'Template RAB', 'settings/rab_template', 'fas fa-ruler-vertical', 4, 'Y', 1, '2020-10-23 12:15:59', 1, 'edit', '2020-10-23 12:15:59', 19);
INSERT INTO `log_ref_menu` VALUES (55, 54, 'Item RAB', 'Item Data RAB', 'settings/item_rab', 'fas fa-pencil-ruler', 1, 'Y', 1, '2020-10-23 12:16:39', 1, 'add', '2020-10-23 12:16:39', 20);
INSERT INTO `log_ref_menu` VALUES (54, 52, 'Template RAB', 'Template RAB', 'settings/rab_template', 'fas fa-ruler-vertical', 4, 'Y', 1, '2020-10-25 08:38:07', 1, 'edit', '2020-10-25 08:38:07', 21);
INSERT INTO `log_ref_menu` VALUES (49, 2, 'RAB Config', 'Master Data', NULL, 'fas fa-table', 3, 'Y', 1, '2020-10-25 08:38:57', 1, 'edit', '2020-10-25 08:38:57', 22);
INSERT INTO `log_ref_menu` VALUES (49, 2, 'Master Data', 'Master Data', NULL, 'fas fa-table', 3, 'Y', 1, '2020-10-25 08:40:16', 1, 'edit', '2020-10-25 08:40:16', 23);
INSERT INTO `log_ref_menu` VALUES (52, NULL, 'RAB Config', 'RAB Config', NULL, 'fas fa-briefcase', 1, 'Y', 1, '2020-10-25 08:40:26', 1, 'edit', '2020-10-25 08:40:26', 24);
INSERT INTO `log_ref_menu` VALUES (56, 49, 'Building Type', 'Building Type', 'settings/building_type', 'fas fa-building', 3, 'Y', 1, '2020-10-25 08:41:03', 1, 'add', '2020-10-25 08:41:03', 25);
INSERT INTO `log_ref_menu` VALUES (53, 54, 'RAB', 'RAB Data', 'master_data/rab', 'fas fa-building', 1, 'Y', 1, '2020-10-26 17:38:56', 1, 'edit', '2020-10-26 17:38:56', 26);
INSERT INTO `log_ref_menu` VALUES (53, 54, 'RAB List Template', 'RAB List Template', 'master_data/rab_list', 'fas fa-building', 1, 'Y', 1, '2020-10-26 18:36:07', 1, 'edit', '2020-10-26 18:36:07', 27);
INSERT INTO `log_ref_menu` VALUES (53, 54, 'RAB List Template', 'RAB List Template', 'settings/rab_list', 'fas fa-building', 1, 'Y', 1, '2020-10-26 18:36:50', 1, 'edit', '2020-10-26 18:36:50', 28);
INSERT INTO `log_ref_menu` VALUES (53, 54, 'RAB List Template', 'RAB List Template', 'master_data/rab_list', 'fas fa-building', 1, 'Y', 1, '2020-10-26 18:38:39', 1, 'edit', '2020-10-26 18:38:39', 29);
INSERT INTO `log_ref_menu` VALUES (55, 54, 'Item RAB', 'Item Data RAB', 'master_data/item_rab', 'fas fa-pencil-ruler', 1, 'Y', 1, '2020-10-26 18:38:50', 1, 'edit', '2020-10-26 18:38:50', 30);
INSERT INTO `log_ref_menu` VALUES (57, NULL, 'Projects', 'Projects', NULL, 'fas fa-paint-roller', 3, 'Y', 1, '2020-10-27 10:02:22', 1, 'add', '2020-10-27 10:02:22', 31);
INSERT INTO `log_ref_menu` VALUES (58, 57, 'Projects Data', 'Projects Data', 'projects/projects_data', 'fas fa-hard-hat', 1, 'Y', 1, '2020-10-27 10:08:04', 1, 'add', '2020-10-27 10:08:04', 32);
INSERT INTO `log_ref_menu` VALUES (59, 52, 'RAB Building', 'RAB Building', 'master_data/rab_building', 'fas fa-ruler-combined', 3, 'Y', 1, '2020-10-27 10:24:24', 1, 'add', '2020-10-27 10:24:24', 33);
INSERT INTO `log_ref_menu` VALUES (60, 57, 'Material Consumption', 'Material Consumption', 'projects/material_consumption', 'fas fa-pencil-ruler', 2, 'Y', 1, '2020-10-30 01:24:12', 1, 'add', '2020-10-30 01:24:12', 34);

-- ----------------------------
-- Table structure for log_unit
-- ----------------------------
DROP TABLE IF EXISTS `log_unit`;
CREATE TABLE `log_unit`  (
  `un_id` int NOT NULL,
  `un_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `un_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_unit
-- ----------------------------
INSERT INTO `log_unit` VALUES (2, NULL, 'Y', '1', '2020-10-23 11:13:21', 1, 'add', '2020-10-23 11:13:21', 1);
INSERT INTO `log_unit` VALUES (3, 'TRUK', 'Y', '1', '2020-10-23 11:14:14', 1, 'add', '2020-10-23 11:14:14', 2);
INSERT INTO `log_unit` VALUES (2, 'KUBIK', 'Y', '1', '2020-10-23 11:15:17', 1, 'edit', '2020-10-23 11:15:17', 3);
INSERT INTO `log_unit` VALUES (2, 'KUBIK', 'N', '1', '2020-10-23 11:18:58', 1, 'edit', '2020-10-23 11:18:59', 4);
INSERT INTO `log_unit` VALUES (3, 'TRUK', 'N', '1', '2020-10-23 11:19:01', 1, 'edit', '2020-10-23 11:19:01', 5);
INSERT INTO `log_unit` VALUES (4, 'TRUK', 'Y', '1', '2020-10-23 11:27:25', 1, 'add', '2020-10-23 11:27:25', 6);
INSERT INTO `log_unit` VALUES (5, 'BATANG', 'Y', '1', '2020-10-23 11:27:38', 1, 'add', '2020-10-23 11:27:38', 7);
INSERT INTO `log_unit` VALUES (6, 'KG', 'Y', '1', '2020-10-23 11:28:51', 1, 'add', '2020-10-23 11:28:51', 8);
INSERT INTO `log_unit` VALUES (7, '/M LARI', 'Y', '1', '2020-10-23 12:27:01', 1, 'add', '2020-10-23 12:27:01', 9);
INSERT INTO `log_unit` VALUES (8, '/KOLOM', 'Y', '1', '2020-10-23 12:27:11', 1, 'add', '2020-10-23 12:27:11', 10);
INSERT INTO `log_unit` VALUES (9, 'M2', 'Y', '1', '2020-10-23 12:28:29', 1, 'add', '2020-10-23 12:28:29', 11);
INSERT INTO `log_unit` VALUES (10, 'M2 = LARI', 'Y', '1', '2020-10-23 12:28:42', 1, 'add', '2020-10-23 12:28:42', 12);
INSERT INTO `log_unit` VALUES (11, '/UNIT KM/WC', 'Y', '1', '2020-10-23 12:28:56', 1, 'add', '2020-10-23 12:28:56', 13);
INSERT INTO `log_unit` VALUES (12, '/UNIT RUMAH', 'Y', '1', '2020-10-23 12:29:00', 1, 'add', '2020-10-23 12:29:00', 14);
INSERT INTO `log_unit` VALUES (9, 'M&lt;SUP&gt;2&lt;/SUP&gt;', 'Y', '1', '2020-10-23 12:31:16', 1, 'edit', '2020-10-23 12:31:16', 15);
INSERT INTO `log_unit` VALUES (9, 'M&amp;SUP2;', 'Y', '1', '2020-10-23 12:34:20', 1, 'edit', '2020-10-23 12:34:20', 16);
INSERT INTO `log_unit` VALUES (9, 'M&amp;#178;', 'Y', '1', '2020-10-23 12:39:32', 1, 'edit', '2020-10-23 12:39:32', 17);
INSERT INTO `log_unit` VALUES (13, 'm$sup2;', 'Y', '1', '2020-10-23 12:40:52', 1, 'add', '2020-10-23 12:40:52', 18);
INSERT INTO `log_unit` VALUES (13, 'm&amp;sup2', 'Y', '1', '2020-10-23 12:41:10', 1, 'edit', '2020-10-23 12:41:10', 19);
INSERT INTO `log_unit` VALUES (13, 'm&amp;sup2', 'N', '1', '2020-10-23 12:46:07', 1, 'edit', '2020-10-23 12:46:07', 20);
INSERT INTO `log_unit` VALUES (9, 'M&amp;#178;', 'N', '1', '2020-10-23 12:46:09', 1, 'edit', '2020-10-23 12:46:09', 21);
INSERT INTO `log_unit` VALUES (14, 'm&amp;sup2;', 'Y', '1', '2020-10-23 12:46:19', 1, 'add', '2020-10-23 12:46:19', 22);
INSERT INTO `log_unit` VALUES (7, '/M LARI', 'N', '1', '2020-10-23 13:44:45', 1, 'edit', '2020-10-23 13:44:45', 23);
INSERT INTO `log_unit` VALUES (13, 'Bh', 'Y', '1', '2020-10-26 19:44:58', 1, 'add', '2020-10-26 19:44:58', 24);
INSERT INTO `log_unit` VALUES (15, 'ZAK', 'Y', '1', '2020-10-26 19:53:14', 1, 'add', '2020-10-26 19:53:14', 25);
INSERT INTO `log_unit` VALUES (16, 'Lembar', 'Y', '1', '2020-10-26 19:53:24', 1, 'add', '2020-10-26 19:53:24', 26);
INSERT INTO `log_unit` VALUES (17, 'pail', 'Y', '1', '2020-10-26 19:53:36', 1, 'add', '2020-10-26 19:53:36', 27);
INSERT INTO `log_unit` VALUES (18, 'set', 'Y', '1', '2020-10-26 19:53:38', 1, 'add', '2020-10-26 19:53:38', 28);
INSERT INTO `log_unit` VALUES (17, 'Pail', 'Y', '1', '2020-10-26 19:53:50', 1, 'edit', '2020-10-26 19:53:50', 29);
INSERT INTO `log_unit` VALUES (18, 'Set', 'Y', '1', '2020-10-26 19:53:57', 1, 'edit', '2020-10-26 19:53:57', 30);

-- ----------------------------
-- Table structure for log_user_detail
-- ----------------------------
DROP TABLE IF EXISTS `log_user_detail`;
CREATE TABLE `log_user_detail`  (
  `ud_id` int UNSIGNED NOT NULL,
  `ud_username` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ud_password` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ud_fullname` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ud_dob` date NOT NULL,
  `ud_pob` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ud_email` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ud_img_filename` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ud_img_ori` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ud_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y',
  `ud_sub_group` int UNSIGNED NOT NULL DEFAULT 3,
  `ud_notif_flag` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Y',
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime(0) NOT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_user_detail
-- ----------------------------
INSERT INTO `log_user_detail` VALUES (1, 'admin', '2b9d2a9db155ff51d4574bc2482b510e0946487b', 'Administrator', '2020-06-18', 'pekanbaru', 'admin@localhost.com', 'c084c8c887804ebde68e108f9fa560d1.png', 'logo.png', 'Y', 1, 'Y', 1, '2020-10-22 02:10:20', 1, 'edit', '2020-10-22 02:10:20', 5);

-- ----------------------------
-- Table structure for log_user_group
-- ----------------------------
DROP TABLE IF EXISTS `log_user_group`;
CREATE TABLE `log_user_group`  (
  `ug_id` int UNSIGNED NOT NULL,
  `ug_caption` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ug_description` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ug_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y',
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime(0) NOT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_user_group
-- ----------------------------

-- ----------------------------
-- Table structure for log_user_sub_group
-- ----------------------------
DROP TABLE IF EXISTS `log_user_sub_group`;
CREATE TABLE `log_user_sub_group`  (
  `usg_id` int UNSIGNED NOT NULL,
  `usg_caption` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `usg_description` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `usg_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y',
  `usg_group` int UNSIGNED NOT NULL,
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime(0) NOT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime(0) NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of log_user_sub_group
-- ----------------------------

-- ----------------------------
-- Table structure for menu_access_group
-- ----------------------------
DROP TABLE IF EXISTS `menu_access_group`;
CREATE TABLE `menu_access_group`  (
  `mag_id` int NOT NULL AUTO_INCREMENT,
  `mag_ug_id` int NULL DEFAULT NULL,
  `mag_rm_id` int NULL DEFAULT NULL,
  `mag_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`mag_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 154 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of menu_access_group
-- ----------------------------
INSERT INTO `menu_access_group` VALUES (3, 1, 3, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (92, 2, 1, 'Y', 1, '2020-09-23 18:05:01');
INSERT INTO `menu_access_group` VALUES (93, 2, 4, 'Y', 1, '2020-09-23 18:05:02');
INSERT INTO `menu_access_group` VALUES (94, 2, 5, 'Y', 1, '2020-09-23 18:05:02');
INSERT INTO `menu_access_group` VALUES (95, 2, 35, 'Y', 1, '2020-09-23 18:05:02');
INSERT INTO `menu_access_group` VALUES (96, 2, 40, 'Y', 1, '2020-09-23 18:05:02');
INSERT INTO `menu_access_group` VALUES (97, 2, 2, 'Y', 1, '2020-09-23 18:05:02');
INSERT INTO `menu_access_group` VALUES (109, 4, 1, 'Y', 1, '2020-09-24 08:18:27');
INSERT INTO `menu_access_group` VALUES (110, 4, 4, 'Y', 1, '2020-09-24 08:18:27');
INSERT INTO `menu_access_group` VALUES (111, 4, 5, 'Y', 1, '2020-09-24 08:18:27');
INSERT INTO `menu_access_group` VALUES (112, 4, 35, 'Y', 1, '2020-09-24 08:18:27');
INSERT INTO `menu_access_group` VALUES (113, 4, 40, 'Y', 1, '2020-09-24 08:18:28');
INSERT INTO `menu_access_group` VALUES (125, 1, 2, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (126, 1, 36, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (127, 1, 33, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (128, 1, 41, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (130, 1, 38, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (131, 1, 39, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (133, 1, 37, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (136, 1, 44, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (137, 1, 45, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (142, 1, 49, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (143, 1, 50, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (144, 1, 51, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (145, 1, 52, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (146, 1, 53, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (147, 1, 54, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (148, 1, 55, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (149, 1, 56, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (150, 1, 57, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (151, 1, 58, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (152, 1, 59, 'Y', 1, '2020-10-30 01:24:23');
INSERT INTO `menu_access_group` VALUES (153, 1, 60, 'Y', 1, '2020-10-30 01:24:23');

-- ----------------------------
-- Table structure for menu_access_sub_group
-- ----------------------------
DROP TABLE IF EXISTS `menu_access_sub_group`;
CREATE TABLE `menu_access_sub_group`  (
  `masg_id` int NOT NULL AUTO_INCREMENT,
  `masg_ug_id` int NULL DEFAULT NULL,
  `masg_usg_id` int NULL DEFAULT NULL,
  `masg_rm_id` int NULL DEFAULT NULL,
  `masg_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`masg_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of menu_access_sub_group
-- ----------------------------
INSERT INTO `menu_access_sub_group` VALUES (7, 1, 1, 1, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (8, 1, 1, 4, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (9, 1, 1, 5, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (10, 1, 1, 40, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (11, 1, 1, 42, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (12, 1, 1, 2, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (13, 1, 1, 36, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (14, 1, 1, 33, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (15, 1, 1, 41, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (17, 1, 1, 3, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (18, 1, 1, 38, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (19, 1, 1, 39, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (20, 1, 1, 43, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (21, 1, 1, 45, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (22, 1, 1, 37, 'Y', 1, '2020-09-27 00:03:50');
INSERT INTO `menu_access_sub_group` VALUES (23, 1, 2, 1, 'Y', 1, '2020-09-28 16:20:10');
INSERT INTO `menu_access_sub_group` VALUES (24, 1, 2, 4, 'Y', 1, '2020-09-28 16:20:10');
INSERT INTO `menu_access_sub_group` VALUES (25, 1, 2, 2, 'Y', 1, '2020-09-28 16:20:10');

-- ----------------------------
-- Table structure for menu_access_user
-- ----------------------------
DROP TABLE IF EXISTS `menu_access_user`;
CREATE TABLE `menu_access_user`  (
  `mau_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `mau_user_id` int UNSIGNED NOT NULL,
  `mau_menu_id` int UNSIGNED NOT NULL,
  `mau_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y',
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime(0) NOT NULL,
  PRIMARY KEY (`mau_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of menu_access_user
-- ----------------------------
INSERT INTO `menu_access_user` VALUES (1, 1, 1, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (2, 1, 2, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (4, 1, 4, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (5, 1, 5, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (39, 1, 33, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (40, 1, 36, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (45, 1, 40, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (46, 1, 41, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (47, 1, 43, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (48, 1, 45, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (49, 1, 42, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (50, 1, 37, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (51, 1, 3, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (52, 1, 38, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (53, 1, 39, 'Y', 1, '2020-09-27 00:04:51');
INSERT INTO `menu_access_user` VALUES (54, 2, 1, 'Y', 1, '2020-09-27 23:46:19');
INSERT INTO `menu_access_user` VALUES (55, 2, 4, 'Y', 1, '2020-09-27 23:46:19');
INSERT INTO `menu_access_user` VALUES (56, 2, 5, 'Y', 1, '2020-09-27 23:46:19');
INSERT INTO `menu_access_user` VALUES (57, 2, 40, 'Y', 1, '2020-09-27 23:46:19');
INSERT INTO `menu_access_user` VALUES (58, 2, 42, 'Y', 1, '2020-09-27 23:46:19');

-- ----------------------------
-- Table structure for projects
-- ----------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects`  (
  `p_id` int NOT NULL AUTO_INCREMENT,
  `p_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p_location` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`p_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of projects
-- ----------------------------
INSERT INTO `projects` VALUES (3, 'Perumahan Srikandi', 'Jl Srikandi No 1', 'Y', 1, '2020-10-29 03:04:53');
INSERT INTO `projects` VALUES (4, 'Perumahan Tapung Kampar', 'Kampar', 'Y', 1, '2020-10-29 01:37:31');
INSERT INTO `projects` VALUES (5, 'tes', 'tes', 'N', 1, '2020-10-29 22:55:36');

-- ----------------------------
-- Table structure for projects_sub
-- ----------------------------
DROP TABLE IF EXISTS `projects_sub`;
CREATE TABLE `projects_sub`  (
  `ps_id` int NOT NULL AUTO_INCREMENT,
  `ps_p_id` int NULL DEFAULT NULL,
  `ps_bt_id` int NULL DEFAULT NULL,
  `ps_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ps_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`ps_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of projects_sub
-- ----------------------------
INSERT INTO `projects_sub` VALUES (3, 3, 16, 'A1', 'Y', 1, '2020-10-29 01:45:21');
INSERT INTO `projects_sub` VALUES (4, 4, 16, 'Blok 1', 'Y', 1, '2020-10-29 23:02:48');
INSERT INTO `projects_sub` VALUES (5, 3, 16, 'A2', 'Y', 1, '2020-10-29 02:35:35');
INSERT INTO `projects_sub` VALUES (6, 3, 16, 'A4', 'Y', 1, '2020-10-29 02:37:52');
INSERT INTO `projects_sub` VALUES (7, 4, 17, 'Blok 1', 'Y', 1, '2020-10-29 02:38:06');

-- ----------------------------
-- Table structure for rab_building
-- ----------------------------
DROP TABLE IF EXISTS `rab_building`;
CREATE TABLE `rab_building`  (
  `rb_id` int NOT NULL AUTO_INCREMENT,
  `rb_bt_id` int NULL DEFAULT NULL,
  `rb_rl_id` int NULL DEFAULT NULL,
  `rb_il_id` int NULL DEFAULT NULL,
  `rb_measure` int NULL DEFAULT NULL,
  `rb_summary` int NULL DEFAULT NULL,
  `rb_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`rb_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of rab_building
-- ----------------------------
INSERT INTO `rab_building` VALUES (1, 16, 2, 8, 10, 200, 'Y', 1, '2020-10-30 00:26:44');
INSERT INTO `rab_building` VALUES (2, 16, 3, 8, 12, 960, 'Y', 1, '2020-10-30 00:26:44');
INSERT INTO `rab_building` VALUES (5, 16, 4, 10, 60, 24, 'Y', 1, '2020-10-30 00:26:44');
INSERT INTO `rab_building` VALUES (6, 17, 4, NULL, 54548, 21819, 'Y', 1, '2020-10-30 00:06:34');
INSERT INTO `rab_building` VALUES (7, 17, 2, NULL, 150, 16500, 'Y', 1, '2020-10-30 00:06:34');
INSERT INTO `rab_building` VALUES (8, 17, 3, NULL, 20, 1600, 'Y', 1, '2020-10-30 00:06:34');
INSERT INTO `rab_building` VALUES (9, 16, 5, 10, 120, 12, 'Y', 1, '2020-10-30 00:26:44');
INSERT INTO `rab_building` VALUES (10, 16, 6, 9, 120, 2, 'Y', 1, '2020-10-30 00:26:44');
INSERT INTO `rab_building` VALUES (11, 16, 7, 10, 240, 96, 'Y', 1, '2020-10-30 00:26:44');

-- ----------------------------
-- Table structure for rab_list
-- ----------------------------
DROP TABLE IF EXISTS `rab_list`;
CREATE TABLE `rab_list`  (
  `rl_id` int NOT NULL AUTO_INCREMENT,
  `rl_ir_id` int NULL DEFAULT NULL,
  `rl_il_id` int NULL DEFAULT NULL,
  `rl_un_id` int NULL DEFAULT NULL,
  `rl_volume` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rl_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`rl_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of rab_list
-- ----------------------------
INSERT INTO `rab_list` VALUES (2, 10, 8, 13, '110', 'Y', 1, '2020-10-26 20:36:11');
INSERT INTO `rab_list` VALUES (3, 13, 8, 13, '80', 'Y', 1, '2020-10-26 19:48:46');
INSERT INTO `rab_list` VALUES (4, 9, 10, 14, '0.4', 'Y', 1, '2020-10-26 20:36:16');
INSERT INTO `rab_list` VALUES (5, 11, 10, 15, '0.1', 'Y', 1, '2020-10-30 00:21:41');
INSERT INTO `rab_list` VALUES (6, 11, 9, 14, '0.015', 'Y', 1, '2020-10-30 00:24:52');
INSERT INTO `rab_list` VALUES (7, 13, 10, 15, '0.4', 'Y', 1, '2020-10-30 00:25:33');

-- ----------------------------
-- Table structure for ref_code
-- ----------------------------
DROP TABLE IF EXISTS `ref_code`;
CREATE TABLE `ref_code`  (
  `rfc_id` int NOT NULL AUTO_INCREMENT,
  `rfc_group` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rfc_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rfc_value` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rfc_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'Y',
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime(0) NOT NULL,
  PRIMARY KEY (`rfc_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of ref_code
-- ----------------------------
INSERT INTO `ref_code` VALUES (1, 'FINDINGS', 'N', 'None', 'Y', 1, '2020-10-13 09:53:52');
INSERT INTO `ref_code` VALUES (2, 'FINDINGS', 'H', 'Hold', 'Y', 1, '2020-10-13 09:54:33');
INSERT INTO `ref_code` VALUES (3, 'FINDINGS', 'S', 'Skipped', 'Y', 1, '2020-10-13 09:56:33');
INSERT INTO `ref_code` VALUES (4, 'FINDINGS', 'A', 'All', 'Y', 1, '2020-10-13 09:57:02');

-- ----------------------------
-- Table structure for ref_menu
-- ----------------------------
DROP TABLE IF EXISTS `ref_menu`;
CREATE TABLE `ref_menu`  (
  `rm_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `rm_parent_id` int UNSIGNED NULL DEFAULT NULL,
  `rm_caption` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `rm_description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `rm_url` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `rm_icon` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `rm_sequence` int UNSIGNED NOT NULL DEFAULT 1,
  `rm_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y',
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime(0) NOT NULL,
  PRIMARY KEY (`rm_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 61 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of ref_menu
-- ----------------------------
INSERT INTO `ref_menu` VALUES (1, NULL, 'Findings', 'Findings', 'trademark/invented_brand', 'fas fa-search', 1, 'N', 1, '2020-10-12 22:32:29');
INSERT INTO `ref_menu` VALUES (2, NULL, 'Settings', 'Settings', NULL, 'fas fa-cogs', 3, 'Y', 1, '2020-09-24 07:12:10');
INSERT INTO `ref_menu` VALUES (3, 37, 'User Detail', 'User Detail', 'settings/user', 'fas fa-user-alt', 1, 'Y', 1, '2020-09-16 23:15:29');
INSERT INTO `ref_menu` VALUES (4, NULL, 'Control Center', 'Control Center', NULL, 'trademark-icon icon-control', 2, 'N', 1, '2020-10-11 10:11:22');
INSERT INTO `ref_menu` VALUES (5, 4, 'Client&rsquo;s Trademarks', 'Client&rsquo;s Trademarks', 'trademark/brand', 'fas fa-tags', 1, 'N', 1, '2020-10-11 10:12:29');
INSERT INTO `ref_menu` VALUES (33, 36, 'Menu', 'Menu', 'settings/menu', 'fas fa-clipboard-list', 1, 'Y', 1, '2020-09-28 16:15:22');
INSERT INTO `ref_menu` VALUES (35, 4, 'Dictionary', 'Dictionary', 'trademark/dictionary', 'fas fa-spell-check', 2, 'N', 1, '2020-09-24 07:12:23');
INSERT INTO `ref_menu` VALUES (36, 2, 'Master Menu', 'Menu', NULL, 'fas fa-cog', 1, 'Y', 1, '2020-09-16 23:11:14');
INSERT INTO `ref_menu` VALUES (37, 2, 'Master User', 'Master User', NULL, 'fas fa-user-cog', 2, 'Y', 1, '2020-09-24 07:12:49');
INSERT INTO `ref_menu` VALUES (38, 37, 'User Group', 'User Group', 'settings/user_group', 'fas fa-users', 1, 'Y', 1, '2020-09-16 23:16:45');
INSERT INTO `ref_menu` VALUES (39, 37, 'User Sub Group', 'User Sub Group Template', 'settings/user_sub_group', 'fas fa-users', 1, 'Y', 1, '2020-09-17 07:17:18');
INSERT INTO `ref_menu` VALUES (40, 4, 'Finding', 'Finding', 'trademark/invented_brand', 'far fa-copyright', 3, 'N', 1, '2020-10-06 10:54:08');
INSERT INTO `ref_menu` VALUES (41, 36, 'Menu Access Group', 'Menu Access Group', 'settings/menu_access_group', 'fas fa-th', 2, 'Y', 1, '2020-09-28 16:16:35');
INSERT INTO `ref_menu` VALUES (42, 4, 'Similar Words', 'Similar Words', 'trademark/similar_words', 'fas fa-spell-check', 3, 'N', 1, '2020-09-26 10:45:03');
INSERT INTO `ref_menu` VALUES (43, 4, 'Similar Letters and/or Numbers', 'Similar Letters and/or Numbers', 'trademark/similar_letters', 'fas fa-font', 4, 'N', 1, '2020-10-12 22:35:35');
INSERT INTO `ref_menu` VALUES (44, 36, 'Menu Access Sub Group', 'Menu Access Sub Group', 'settings/menu_access_sub_group', 'fas fa-layer-group', 3, 'Y', 1, '2020-09-28 16:14:42');
INSERT INTO `ref_menu` VALUES (45, 36, 'Menu Access User', 'Menu Access User', 'settings/menu_access_user', 'fas fa-user', 4, 'Y', 1, '2020-09-28 16:13:36');
INSERT INTO `ref_menu` VALUES (46, 4, 'Brand Gov', 'Brand Gov', 'trademark/brand_gov', 'fas fa-server', 5, 'N', 1, '2020-09-29 11:23:50');
INSERT INTO `ref_menu` VALUES (47, 4, 'Ignored Words', 'Ignored Words', 'trademark/ignored_words', 'fas fa-list', 6, 'N', 1, '2020-10-02 13:19:07');
INSERT INTO `ref_menu` VALUES (48, 4, 'BRM List', 'BRM List', 'trademark/brm_list', 'fas fa-list', 6, 'N', 1, '2020-10-12 23:06:45');
INSERT INTO `ref_menu` VALUES (49, 2, 'Master Data', 'Master Data', NULL, 'fas fa-table', 3, 'Y', 1, '2020-10-25 08:40:16');
INSERT INTO `ref_menu` VALUES (50, 49, 'Item List', 'Item List', 'settings/item_list', 'fas fa-list', 1, 'Y', 1, '2020-10-21 23:58:26');
INSERT INTO `ref_menu` VALUES (51, 49, 'Item Unit', 'Item Unit', 'settings/item_unit', 'fas fa-boxes', 2, 'Y', 1, '2020-10-22 01:51:26');
INSERT INTO `ref_menu` VALUES (52, NULL, 'RAB Config', 'RAB Config', NULL, 'fas fa-briefcase', 1, 'Y', 1, '2020-10-25 08:40:26');
INSERT INTO `ref_menu` VALUES (53, 54, 'RAB List Template', 'RAB List Template', 'master_data/rab_list', 'fas fa-building', 1, 'Y', 1, '2020-10-26 18:38:39');
INSERT INTO `ref_menu` VALUES (54, 52, 'Template RAB', 'Template RAB', 'settings/rab_template', 'fas fa-ruler-vertical', 4, 'Y', 1, '2020-10-25 08:38:07');
INSERT INTO `ref_menu` VALUES (55, 54, 'Item RAB', 'Item Data RAB', 'master_data/item_rab', 'fas fa-pencil-ruler', 1, 'Y', 1, '2020-10-26 18:38:50');
INSERT INTO `ref_menu` VALUES (56, 49, 'Building Type', 'Building Type', 'settings/building_type', 'fas fa-building', 3, 'Y', 1, '2020-10-25 08:41:03');
INSERT INTO `ref_menu` VALUES (57, NULL, 'Projects', 'Projects', NULL, 'fas fa-paint-roller', 3, 'Y', 1, '2020-10-27 10:02:22');
INSERT INTO `ref_menu` VALUES (58, 57, 'Projects Data', 'Projects Data', 'projects/projects_data', 'fas fa-hard-hat', 1, 'Y', 1, '2020-10-27 10:08:04');
INSERT INTO `ref_menu` VALUES (59, 52, 'RAB Building', 'RAB Building', 'master_data/rab_building', 'fas fa-ruler-combined', 3, 'Y', 1, '2020-10-27 10:24:24');
INSERT INTO `ref_menu` VALUES (60, 57, 'Material Consumption', 'Material Consumption', 'projects/material_consumption', 'fas fa-pencil-ruler', 2, 'Y', 1, '2020-10-30 01:24:12');

-- ----------------------------
-- Table structure for unit
-- ----------------------------
DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit`  (
  `un_id` int NOT NULL AUTO_INCREMENT,
  `un_name` varchar(255) CHARACTER SET utf16 COLLATE utf16_bin NULL DEFAULT NULL,
  `un_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`un_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of unit
-- ----------------------------
INSERT INTO `unit` VALUES (1, 'PCS', 'Y', '1', '2020-10-22 00:38:26');
INSERT INTO `unit` VALUES (2, 'KUBIK', 'N', '1', '2020-10-23 11:18:58');
INSERT INTO `unit` VALUES (3, 'TRUK', 'N', '1', '2020-10-23 11:19:01');
INSERT INTO `unit` VALUES (4, 'TRUK', 'Y', '1', '2020-10-23 11:27:25');
INSERT INTO `unit` VALUES (5, 'BATANG', 'Y', '1', '2020-10-23 11:27:38');
INSERT INTO `unit` VALUES (6, 'KG', 'Y', '1', '2020-10-23 11:28:51');
INSERT INTO `unit` VALUES (7, '/M LARI', 'Y', '1', '2020-10-23 13:44:45');
INSERT INTO `unit` VALUES (8, '/KOLOM', 'Y', '1', '2020-10-23 12:27:11');
INSERT INTO `unit` VALUES (9, 'M&#178;', 'Y', '1', '2020-10-23 12:46:09');
INSERT INTO `unit` VALUES (10, 'M&#178; = LARI', 'Y', '1', '2020-10-23 12:28:42');
INSERT INTO `unit` VALUES (11, '/UNIT KM/WC', 'Y', '1', '2020-10-23 12:28:56');
INSERT INTO `unit` VALUES (12, '/UNIT RUMAH', 'Y', '1', '2020-10-23 12:29:00');
INSERT INTO `unit` VALUES (13, 'Bh', 'Y', '1', '2020-10-26 19:44:58');
INSERT INTO `unit` VALUES (14, 'M&sup3;', 'Y', '1', '2020-10-26 19:52:15');
INSERT INTO `unit` VALUES (15, 'ZAK', 'Y', '1', '2020-10-26 19:53:14');
INSERT INTO `unit` VALUES (16, 'Lembar', 'Y', '1', '2020-10-26 19:53:24');
INSERT INTO `unit` VALUES (17, 'Pail', 'Y', '1', '2020-10-26 19:53:50');
INSERT INTO `unit` VALUES (18, 'Set', 'Y', '1', '2020-10-26 19:53:57');

-- ----------------------------
-- Table structure for user_detail
-- ----------------------------
DROP TABLE IF EXISTS `user_detail`;
CREATE TABLE `user_detail`  (
  `ud_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ud_username` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ud_password` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ud_fullname` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ud_dob` date NOT NULL,
  `ud_pob` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ud_email` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ud_img_filename` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ud_img_ori` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ud_notif_flag` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Y',
  `ud_sub_group` int UNSIGNED NOT NULL DEFAULT 3,
  `ud_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y',
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime(0) NOT NULL,
  PRIMARY KEY (`ud_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of user_detail
-- ----------------------------
INSERT INTO `user_detail` VALUES (1, 'admin', '2b9d2a9db155ff51d4574bc2482b510e0946487b', 'Administrator', '2020-06-18', 'pekanbaru', 'admin@localhost.com', 'c084c8c887804ebde68e108f9fa560d1.png', 'logo.png', 'Y', 1, 'Y', 1, '2020-10-22 02:10:20');

-- ----------------------------
-- Table structure for user_group
-- ----------------------------
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group`  (
  `ug_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ug_caption` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ug_description` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ug_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y',
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime(0) NOT NULL,
  PRIMARY KEY (`ug_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of user_group
-- ----------------------------
INSERT INTO `user_group` VALUES (1, 'Administrators', 'Administrator', 'Y', 1, '2020-10-11 10:03:12');

-- ----------------------------
-- Table structure for user_sub_group
-- ----------------------------
DROP TABLE IF EXISTS `user_sub_group`;
CREATE TABLE `user_sub_group`  (
  `usg_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `usg_caption` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `usg_description` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `usg_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y',
  `usg_group` int UNSIGNED NOT NULL,
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime(0) NOT NULL,
  PRIMARY KEY (`usg_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of user_sub_group
-- ----------------------------
INSERT INTO `user_sub_group` VALUES (1, 'Super Administrators', 'Super Administrators', 'Y', 1, 1, '2019-11-05 14:19:50');

SET FOREIGN_KEY_CHECKS = 1;
