/*
 Navicat Premium Data Transfer

 Source Server         : local8
 Source Server Type    : MySQL
 Source Server Version : 80020
 Source Host           : localhost:3306
 Source Schema         : dbkargo

 Target Server Type    : MySQL
 Target Server Version : 80020
 File Encoding         : 65001

 Date: 15/01/2022 16:26:32
*/

SET NAMES latin1;
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
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`bt_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for cash_in
-- ----------------------------
DROP TABLE IF EXISTS `cash_in`;
CREATE TABLE `cash_in`  (
  `ci_id` int NOT NULL AUTO_INCREMENT,
  `ci_rad_id` int NULL DEFAULT NULL,
  `ci_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ci_keterangan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ci_total` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ci_created_date` date NULL DEFAULT NULL,
  `ci_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`ci_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cash_in_detail
-- ----------------------------
DROP TABLE IF EXISTS `cash_in_detail`;
CREATE TABLE `cash_in_detail`  (
  `cid_id` int NOT NULL AUTO_INCREMENT,
  `cid_ci_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cid_key_lock` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cid_rad_id` int NULL DEFAULT NULL,
  `cid_keterangan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cid_total` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cid_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`cid_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 58 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cash_out
-- ----------------------------
DROP TABLE IF EXISTS `cash_out`;
CREATE TABLE `cash_out`  (
  `co_id` int NOT NULL AUTO_INCREMENT,
  `co_rad_id` int NULL DEFAULT NULL,
  `co_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `co_keterangan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `co_total` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `co_created_date` date NULL DEFAULT NULL,
  `co_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`co_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cash_out_detail
-- ----------------------------
DROP TABLE IF EXISTS `cash_out_detail`;
CREATE TABLE `cash_out_detail`  (
  `cod_id` int NOT NULL AUTO_INCREMENT,
  `cod_co_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod_key_lock` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod_rad_id` int NULL DEFAULT NULL,
  `cod_keterangan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod_total` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`cod_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `c_id` int NOT NULL AUTO_INCREMENT,
  `c_district_id` int NULL DEFAULT NULL,
  `c_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `c_address` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `c_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `c_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `c_shipping_area` int NULL DEFAULT NULL,
  `c_shipping_area_transfer` int NULL DEFAULT NULL,
  `c_distance_area` double NULL DEFAULT NULL,
  `c_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`c_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 355 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for customer_copy1
-- ----------------------------
DROP TABLE IF EXISTS `customer_copy1`;
CREATE TABLE `customer_copy1`  (
  `c_id` int NOT NULL AUTO_INCREMENT,
  `c_district_id` int NULL DEFAULT NULL,
  `c_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `c_address` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `c_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `c_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `c_shipping_area` int NULL DEFAULT NULL,
  `c_shipping_area_transfer` int NULL DEFAULT NULL,
  `c_distance_area` double NULL DEFAULT NULL,
  `c_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`c_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 282 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for delivery_order_cost
-- ----------------------------
DROP TABLE IF EXISTS `delivery_order_cost`;
CREATE TABLE `delivery_order_cost`  (
  `doc_id` int NOT NULL AUTO_INCREMENT,
  `doc_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `doc_so_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `doc_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `doc_created_date` datetime NULL DEFAULT NULL,
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`doc_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 45 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for delivery_order_cost_detail
-- ----------------------------
DROP TABLE IF EXISTS `delivery_order_cost_detail`;
CREATE TABLE `delivery_order_cost_detail`  (
  `docd_id` int NOT NULL AUTO_INCREMENT,
  `docd_vehicle_id` int NULL DEFAULT NULL,
  `docd_doc_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `docd_lock_ref` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `docd_rad_id` int NULL DEFAULT NULL,
  `docd_amount` int NULL DEFAULT NULL,
  `docd_keterangan` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `docd_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`docd_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 87 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for delivery_order_detail
-- ----------------------------
DROP TABLE IF EXISTS `delivery_order_detail`;
CREATE TABLE `delivery_order_detail`  (
  `dod_id` int NOT NULL AUTO_INCREMENT,
  `dod_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dod_sod_id` int NULL DEFAULT NULL,
  `dod_driver_id` int NULL DEFAULT NULL,
  `dod_customer_id` int NULL DEFAULT NULL,
  `dod_vehicle_id` int NULL DEFAULT NULL,
  `dod_shipping_qty` int NULL DEFAULT NULL,
  `dod_ongkir` decimal(10, 0) NULL DEFAULT NULL,
  `dod_created_date` date NULL DEFAULT NULL,
  `dod_is_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dod_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`dod_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 127 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for delivery_order_status
-- ----------------------------
DROP TABLE IF EXISTS `delivery_order_status`;
CREATE TABLE `delivery_order_status`  (
  `dos_id` int NOT NULL AUTO_INCREMENT,
  `dos_dod_id` int NULL DEFAULT NULL,
  `dos_filled` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `dos_ongkir` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `dos_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dos_keterangan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dos_created_date` datetime NULL DEFAULT NULL,
  `dos_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime NOT NULL,
  PRIMARY KEY (`dos_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 73 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for delivery_order_transfer_detail
-- ----------------------------
DROP TABLE IF EXISTS `delivery_order_transfer_detail`;
CREATE TABLE `delivery_order_transfer_detail`  (
  `dotd_id` int NOT NULL AUTO_INCREMENT,
  `dotd_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dotd_sod_id` int NULL DEFAULT NULL,
  `dotd_driver_id` int NULL DEFAULT NULL,
  `dotd_customer_id_from` int NULL DEFAULT NULL,
  `dotd_customer_id_to` int NULL DEFAULT NULL,
  `dotd_vehicle_id` int NULL DEFAULT NULL,
  `dotd_shipping_qty` int NULL DEFAULT NULL,
  `dotd_ongkir` decimal(10, 0) NULL DEFAULT NULL,
  `dotd_created_date` datetime NULL DEFAULT NULL,
  `dotd_is_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dotd_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`dotd_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 121 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for delivery_order_transfer_status
-- ----------------------------
DROP TABLE IF EXISTS `delivery_order_transfer_status`;
CREATE TABLE `delivery_order_transfer_status`  (
  `dots_id` int NOT NULL AUTO_INCREMENT,
  `dots_dotd_id` int NULL DEFAULT NULL,
  `dots_filled` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `dots_ongkir` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `dots_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dots_keterangan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dots_created_date` date NULL DEFAULT NULL,
  `dots_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime NOT NULL,
  PRIMARY KEY (`dots_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 78 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for driver
-- ----------------------------
DROP TABLE IF EXISTS `driver`;
CREATE TABLE `driver`  (
  `d_id` int NOT NULL AUTO_INCREMENT,
  `d_district_id` int NULL DEFAULT NULL,
  `d_ud_id` int NULL DEFAULT NULL,
  `d_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `d_address` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `d_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `d_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `d_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`d_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for item_list
-- ----------------------------
DROP TABLE IF EXISTS `item_list`;
CREATE TABLE `item_list`  (
  `il_id` int NOT NULL AUTO_INCREMENT,
  `il_item_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `il_item_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `il_vendor_id` int NULL DEFAULT NULL,
  `il_un_id` int NULL DEFAULT NULL,
  `il_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`il_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`ir_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NOT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for log_building_type
-- ----------------------------
DROP TABLE IF EXISTS `log_building_type`;
CREATE TABLE `log_building_type`  (
  `bt_id` int NOT NULL,
  `bt_building_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `bt_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for log_cash_in
-- ----------------------------
DROP TABLE IF EXISTS `log_cash_in`;
CREATE TABLE `log_cash_in`  (
  `ci_id` int NOT NULL,
  `ci_rad_id` int NULL DEFAULT NULL,
  `ci_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ci_keterangan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ci_total` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ci_created_date` date NULL DEFAULT NULL,
  `ci_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_cash_in_detail
-- ----------------------------
DROP TABLE IF EXISTS `log_cash_in_detail`;
CREATE TABLE `log_cash_in_detail`  (
  `cid_id` int NOT NULL,
  `cid_ci_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cid_key_lock` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cid_rad_id` int NULL DEFAULT NULL,
  `cid_keterangan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cid_total` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cid_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 73 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_cash_out
-- ----------------------------
DROP TABLE IF EXISTS `log_cash_out`;
CREATE TABLE `log_cash_out`  (
  `co_id` int NOT NULL,
  `co_rad_id` int NULL DEFAULT NULL,
  `co_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `co_keterangan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `co_total` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `co_created_date` date NULL DEFAULT NULL,
  `co_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_cash_out_detail
-- ----------------------------
DROP TABLE IF EXISTS `log_cash_out_detail`;
CREATE TABLE `log_cash_out_detail`  (
  `cod_id` int NOT NULL,
  `cod_co_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod_key_lock` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod_rad_id` int NULL DEFAULT NULL,
  `cod_keterangan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod_total` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cod_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 124 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_customer
-- ----------------------------
DROP TABLE IF EXISTS `log_customer`;
CREATE TABLE `log_customer`  (
  `c_id` int NOT NULL,
  `c_district_id` int NULL DEFAULT NULL,
  `c_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `c_address` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `c_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `c_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `c_shipping_area` int NULL DEFAULT NULL,
  `c_shipping_area_transfer` int NULL DEFAULT NULL,
  `c_distance_area` double NULL DEFAULT NULL,
  `c_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 54 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_delivery_order_cost
-- ----------------------------
DROP TABLE IF EXISTS `log_delivery_order_cost`;
CREATE TABLE `log_delivery_order_cost`  (
  `doc_id` int NOT NULL,
  `doc_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `doc_so_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `doc_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `doc_created_date` datetime NULL DEFAULT NULL,
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 47 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_delivery_order_cost_detail
-- ----------------------------
DROP TABLE IF EXISTS `log_delivery_order_cost_detail`;
CREATE TABLE `log_delivery_order_cost_detail`  (
  `docd_id` int NOT NULL,
  `docd_vehicle_id` int NULL DEFAULT NULL,
  `docd_doc_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `docd_lock_ref` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `docd_rad_id` int NULL DEFAULT NULL,
  `docd_amount` int NULL DEFAULT NULL,
  `docd_keterangan` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `docd_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 121 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_delivery_order_detail
-- ----------------------------
DROP TABLE IF EXISTS `log_delivery_order_detail`;
CREATE TABLE `log_delivery_order_detail`  (
  `dod_id` int NOT NULL,
  `dod_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dod_sod_id` int NULL DEFAULT NULL,
  `dod_driver_id` int NULL DEFAULT NULL,
  `dod_vehicle_id` int NULL DEFAULT NULL,
  `dod_customer_id` int NULL DEFAULT NULL,
  `dod_ongkir` decimal(10, 0) NULL DEFAULT NULL,
  `dod_is_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dod_created_date` datetime NULL DEFAULT NULL,
  `dod_shipping_qty` int NULL DEFAULT NULL,
  `dod_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 309 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_delivery_order_status
-- ----------------------------
DROP TABLE IF EXISTS `log_delivery_order_status`;
CREATE TABLE `log_delivery_order_status`  (
  `dos_id` int NULL DEFAULT NULL,
  `dos_dod_id` int NULL DEFAULT NULL,
  `dos_filled` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dos_ongkir` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dos_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dos_keterangan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dos_created_date` datetime NULL DEFAULT NULL,
  `dos_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` int UNSIGNED NOT NULL,
  `last_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 149 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_delivery_order_transfer_detail
-- ----------------------------
DROP TABLE IF EXISTS `log_delivery_order_transfer_detail`;
CREATE TABLE `log_delivery_order_transfer_detail`  (
  `dotd_id` int NOT NULL,
  `dotd_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dotd_sod_id` int NULL DEFAULT NULL,
  `dotd_driver_id` int NULL DEFAULT NULL,
  `dotd_customer_id_from` int NULL DEFAULT NULL,
  `dotd_customer_id_to` int NULL DEFAULT NULL,
  `dotd_vehicle_id` int NULL DEFAULT NULL,
  `dotd_shipping_qty` int NULL DEFAULT NULL,
  `dotd_ongkir` decimal(10, 0) NULL DEFAULT NULL,
  `dotd_created_date` date NULL DEFAULT NULL,
  `dotd_is_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dotd_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `log_datetime` datetime NULL DEFAULT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 144 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_delivery_order_transfer_status
-- ----------------------------
DROP TABLE IF EXISTS `log_delivery_order_transfer_status`;
CREATE TABLE `log_delivery_order_transfer_status`  (
  `dots_id` int NOT NULL,
  `dots_dotd_id` int NULL DEFAULT NULL,
  `dots_filled` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `dots_ongkir` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `dots_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dots_keterangan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `dots_created_date` datetime NULL DEFAULT NULL,
  `dots_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` int UNSIGNED NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `log_datetime` datetime NULL DEFAULT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 91 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_driver
-- ----------------------------
DROP TABLE IF EXISTS `log_driver`;
CREATE TABLE `log_driver`  (
  `d_id` int NOT NULL,
  `d_district_id` int NULL DEFAULT NULL,
  `d_ud_id` int NULL DEFAULT NULL,
  `d_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `d_address` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `d_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `d_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `d_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_item_list
-- ----------------------------
DROP TABLE IF EXISTS `log_item_list`;
CREATE TABLE `log_item_list`  (
  `il_id` int NOT NULL,
  `il_item_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `il_item_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `il_vendor_id` int NULL DEFAULT NULL,
  `il_un_id` int NULL DEFAULT NULL,
  `il_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for log_material_consumption
-- ----------------------------
DROP TABLE IF EXISTS `log_material_consumption`;
CREATE TABLE `log_material_consumption`  (
  `mc_id` int NOT NULL,
  `mc_il_id` int NULL DEFAULT NULL,
  `mc_ps_id` int NULL DEFAULT NULL,
  `mc_price` decimal(10, 2) NULL DEFAULT NULL,
  `mc_quantity` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `mc_total` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `mc_date_order` datetime NULL DEFAULT NULL,
  `mc_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1086 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NOT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for log_partner
-- ----------------------------
DROP TABLE IF EXISTS `log_partner`;
CREATE TABLE `log_partner`  (
  `pr_id` int NOT NULL,
  `pr_ud_id` int NULL DEFAULT NULL,
  `pr_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pr_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pr_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pr_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pr_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_partner_detail
-- ----------------------------
DROP TABLE IF EXISTS `log_partner_detail`;
CREATE TABLE `log_partner_detail`  (
  `prd_id` int NOT NULL,
  `prd_pr_id` int NULL DEFAULT NULL,
  `prd_vehicle_id` int NULL DEFAULT NULL,
  `prd_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for log_ref_akun_detail
-- ----------------------------
DROP TABLE IF EXISTS `log_ref_akun_detail`;
CREATE TABLE `log_ref_akun_detail`  (
  `rad_id` int NOT NULL,
  `rad_parent_id` int NULL DEFAULT NULL,
  `rad_akun_header_id` int NOT NULL,
  `rad_kode_akun` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rad_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rad_seq` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `rad_type` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rad_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `rad_is_bank` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'N',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NULL DEFAULT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 44 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_ref_akun_header
-- ----------------------------
DROP TABLE IF EXISTS `log_ref_akun_header`;
CREATE TABLE `log_ref_akun_header`  (
  `rah_id` int NOT NULL,
  `rah_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rah_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rah_seq` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rah_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NULL DEFAULT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_ref_company
-- ----------------------------
DROP TABLE IF EXISTS `log_ref_company`;
CREATE TABLE `log_ref_company`  (
  `rc_id` int NOT NULL,
  `rc_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rc_owner` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rc_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rc_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rc_logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rc_icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rc_is_active` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NULL DEFAULT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_ref_district
-- ----------------------------
DROP TABLE IF EXISTS `log_ref_district`;
CREATE TABLE `log_ref_district`  (
  `rd_id` int NOT NULL,
  `rd_province_id` int NULL DEFAULT NULL,
  `rd_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rd_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NULL DEFAULT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1315 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

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
  `last_datetime` datetime NOT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NULL DEFAULT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 116 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for log_ref_province
-- ----------------------------
DROP TABLE IF EXISTS `log_ref_province`;
CREATE TABLE `log_ref_province`  (
  `rp_id` int NOT NULL,
  `rp_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rp_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NULL DEFAULT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 98 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_ref_status
-- ----------------------------
DROP TABLE IF EXISTS `log_ref_status`;
CREATE TABLE `log_ref_status`  (
  `rs_id` int NOT NULL,
  `rs_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rs_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NULL DEFAULT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_ref_sub_district
-- ----------------------------
DROP TABLE IF EXISTS `log_ref_sub_district`;
CREATE TABLE `log_ref_sub_district`  (
  `rsd_id` int NOT NULL,
  `rsd_district_id` int NULL DEFAULT NULL,
  `rsd_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rsd_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NULL DEFAULT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17437 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_ref_transaksi
-- ----------------------------
DROP TABLE IF EXISTS `log_ref_transaksi`;
CREATE TABLE `log_ref_transaksi`  (
  `trx_id` int NOT NULL,
  `trx_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `trx_key_lock` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `trx_rad_id_from` int NULL DEFAULT NULL,
  `trx_rad_id_to` int NULL DEFAULT NULL,
  `trx_total` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `trx_created_date` date NULL DEFAULT NULL,
  `trx_is_active` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NULL DEFAULT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 128 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_sales_order
-- ----------------------------
DROP TABLE IF EXISTS `log_sales_order`;
CREATE TABLE `log_sales_order`  (
  `so_id` int NOT NULL,
  `so_vendor_id` int NULL DEFAULT NULL,
  `so_district_id` int NULL DEFAULT NULL,
  `so_total_amount` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `so_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `so_is_receive` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `so_created_date` date NULL DEFAULT NULL,
  `so_is_pay` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `so_tipe` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `so_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `so_is_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 300 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_sales_order_detail
-- ----------------------------
DROP TABLE IF EXISTS `log_sales_order_detail`;
CREATE TABLE `log_sales_order_detail`  (
  `sod_id` int NOT NULL,
  `sod_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sod_item_id` int NULL DEFAULT NULL,
  `sod_qty` int NULL DEFAULT NULL,
  `sod_realisasi` int NULL DEFAULT NULL,
  `sod_flag` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'N',
  `sod_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 269 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_sales_order_payment
-- ----------------------------
DROP TABLE IF EXISTS `log_sales_order_payment`;
CREATE TABLE `log_sales_order_payment`  (
  `sop_id` int NOT NULL,
  `sop_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sop_so_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sop_key_lock` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sop_created_date` date NULL DEFAULT NULL,
  `sop_total_pay` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sop_type_pay` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sop_is_active` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_shipping
-- ----------------------------
DROP TABLE IF EXISTS `log_shipping`;
CREATE TABLE `log_shipping`  (
  `sh_id` int NOT NULL,
  `sh_rd_id` int NULL DEFAULT NULL,
  `sh_rsd_id` int NULL DEFAULT NULL,
  `sh_cost` decimal(50, 0) NULL DEFAULT NULL,
  `sh_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_template_laporan
-- ----------------------------
DROP TABLE IF EXISTS `log_template_laporan`;
CREATE TABLE `log_template_laporan`  (
  `tl_id` int NOT NULL,
  `tl_vendor_id` int NULL DEFAULT NULL,
  `tl_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tl_file_template` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tl_so_tipe` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tl_is_active` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NULL DEFAULT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_unit
-- ----------------------------
DROP TABLE IF EXISTS `log_unit`;
CREATE TABLE `log_unit`  (
  `un_id` int NOT NULL,
  `un_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `un_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int NULL DEFAULT NULL,
  `log_action` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NOT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NOT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NOT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for log_vehicle
-- ----------------------------
DROP TABLE IF EXISTS `log_vehicle`;
CREATE TABLE `log_vehicle`  (
  `ve_id` int NOT NULL,
  `ve_license_plate` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ve_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `ve_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ve_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for log_vendor
-- ----------------------------
DROP TABLE IF EXISTS `log_vendor`;
CREATE TABLE `log_vendor`  (
  `v_id` int NOT NULL,
  `v_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `v_vendor_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `v_vendor_add` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `v_vendor_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `v_vendor_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `v_user_access` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `v_unique_access_key` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `v_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  `log_user_id` int UNSIGNED NOT NULL,
  `log_action` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for material_consumption
-- ----------------------------
DROP TABLE IF EXISTS `material_consumption`;
CREATE TABLE `material_consumption`  (
  `mc_id` int NOT NULL AUTO_INCREMENT,
  `mc_il_id` int NULL DEFAULT NULL,
  `mc_ps_id` int NULL DEFAULT NULL,
  `mc_price` decimal(10, 2) NULL DEFAULT NULL,
  `mc_quantity` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `mc_total` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `mc_date_order` datetime NULL DEFAULT NULL,
  `mc_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` int NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`mc_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`mag_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 197 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`masg_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NOT NULL,
  PRIMARY KEY (`mau_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for partner
-- ----------------------------
DROP TABLE IF EXISTS `partner`;
CREATE TABLE `partner`  (
  `pr_id` int NOT NULL AUTO_INCREMENT,
  `pr_ud_id` int NULL DEFAULT NULL,
  `pr_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pr_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pr_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pr_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pr_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`pr_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for partner_detail
-- ----------------------------
DROP TABLE IF EXISTS `partner_detail`;
CREATE TABLE `partner_detail`  (
  `prd_id` int NOT NULL AUTO_INCREMENT,
  `prd_pr_id` int NULL DEFAULT NULL,
  `prd_vehicle_id` int NULL DEFAULT NULL,
  `prd_is_active` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`prd_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for pelanggan
-- ----------------------------
DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE `pelanggan`  (
  `p_id` int NOT NULL AUTO_INCREMENT,
  `p_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `p_address` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `p_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `p_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `p_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`p_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`p_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`ps_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`rb_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`rl_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for ref_akun_detail
-- ----------------------------
DROP TABLE IF EXISTS `ref_akun_detail`;
CREATE TABLE `ref_akun_detail`  (
  `rad_id` int NOT NULL AUTO_INCREMENT,
  `rad_parent_id` int NULL DEFAULT NULL,
  `rad_akun_header_id` int NULL DEFAULT NULL,
  `rad_kode_akun` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rad_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rad_seq` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '1',
  `rad_type` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rad_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `rad_is_bank` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'N',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`rad_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for ref_akun_header
-- ----------------------------
DROP TABLE IF EXISTS `ref_akun_header`;
CREATE TABLE `ref_akun_header`  (
  `rah_id` int NOT NULL AUTO_INCREMENT,
  `rah_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rah_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rah_seq` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rah_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`rah_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

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
  `last_datetime` datetime NOT NULL,
  PRIMARY KEY (`rfc_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for ref_company
-- ----------------------------
DROP TABLE IF EXISTS `ref_company`;
CREATE TABLE `ref_company`  (
  `rc_id` int NOT NULL AUTO_INCREMENT,
  `rc_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rc_owner` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rc_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rc_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rc_logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rc_icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `rc_is_active` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`rc_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for ref_district
-- ----------------------------
DROP TABLE IF EXISTS `ref_district`;
CREATE TABLE `ref_district`  (
  `rd_id` int NOT NULL AUTO_INCREMENT,
  `rd_province_id` int NULL DEFAULT NULL,
  `rd_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rd_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`rd_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 814 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

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
  `last_datetime` datetime NOT NULL,
  PRIMARY KEY (`rm_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 92 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for ref_province
-- ----------------------------
DROP TABLE IF EXISTS `ref_province`;
CREATE TABLE `ref_province`  (
  `rp_id` int NOT NULL AUTO_INCREMENT,
  `rp_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rp_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`rp_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for ref_status
-- ----------------------------
DROP TABLE IF EXISTS `ref_status`;
CREATE TABLE `ref_status`  (
  `rs_id` int NOT NULL AUTO_INCREMENT,
  `rs_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rs_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`rs_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for ref_sub_district
-- ----------------------------
DROP TABLE IF EXISTS `ref_sub_district`;
CREATE TABLE `ref_sub_district`  (
  `rsd_id` int NOT NULL AUTO_INCREMENT,
  `rsd_district_id` int NULL DEFAULT NULL,
  `rsd_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rsd_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`rsd_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10589 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for ref_transaksi
-- ----------------------------
DROP TABLE IF EXISTS `ref_transaksi`;
CREATE TABLE `ref_transaksi`  (
  `trx_id` int NOT NULL AUTO_INCREMENT,
  `trx_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `trx_key_lock` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `trx_rad_id_from` int NULL DEFAULT NULL,
  `trx_rad_id_to` int NULL DEFAULT NULL,
  `trx_total` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `trx_created_date` date NULL DEFAULT NULL,
  `trx_is_active` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`trx_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 76 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for sales_order
-- ----------------------------
DROP TABLE IF EXISTS `sales_order`;
CREATE TABLE `sales_order`  (
  `so_id` int NOT NULL AUTO_INCREMENT,
  `so_vendor_id` int NULL DEFAULT NULL,
  `so_district_id` int NULL DEFAULT NULL,
  `so_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `so_total_amount` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `so_created_date` date NULL DEFAULT NULL,
  `so_is_pay` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'BL',
  `so_is_status` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'ORDER',
  `so_tipe` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `so_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`so_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for sales_order_detail
-- ----------------------------
DROP TABLE IF EXISTS `sales_order_detail`;
CREATE TABLE `sales_order_detail`  (
  `sod_id` int NOT NULL AUTO_INCREMENT,
  `sod_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sod_item_id` int NULL DEFAULT NULL,
  `sod_qty` int NULL DEFAULT 0,
  `sod_realisasi` int NULL DEFAULT 0,
  `sod_flag` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'N',
  `sod_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`sod_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 101 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for sales_order_payment
-- ----------------------------
DROP TABLE IF EXISTS `sales_order_payment`;
CREATE TABLE `sales_order_payment`  (
  `sop_id` int NOT NULL AUTO_INCREMENT,
  `sop_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sop_so_no_trx` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sop_key_lock` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sop_created_date` date NULL DEFAULT NULL,
  `sop_total_pay` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sop_type_pay` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sop_is_active` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`sop_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for shipping
-- ----------------------------
DROP TABLE IF EXISTS `shipping`;
CREATE TABLE `shipping`  (
  `sh_id` int NOT NULL AUTO_INCREMENT,
  `sh_rd_id` int NULL DEFAULT NULL,
  `sh_rsd_id` int NULL DEFAULT NULL,
  `sh_cost` decimal(50, 0) NULL DEFAULT NULL,
  `sh_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`sh_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for template_laporan
-- ----------------------------
DROP TABLE IF EXISTS `template_laporan`;
CREATE TABLE `template_laporan`  (
  `tl_id` int NOT NULL AUTO_INCREMENT,
  `tl_vendor_id` int NULL DEFAULT NULL,
  `tl_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tl_file_template` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tl_so_tipe` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tl_is_active` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`tl_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for unit
-- ----------------------------
DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit`  (
  `un_id` int NOT NULL AUTO_INCREMENT,
  `un_name` varchar(255) CHARACTER SET utf16 COLLATE utf16_bin NULL DEFAULT NULL,
  `un_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`un_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NOT NULL,
  PRIMARY KEY (`ud_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NOT NULL,
  PRIMARY KEY (`ug_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

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
  `last_datetime` datetime NOT NULL,
  PRIMARY KEY (`usg_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Table structure for vehicle
-- ----------------------------
DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE `vehicle`  (
  `ve_id` int NOT NULL AUTO_INCREMENT,
  `ve_license_plate` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ve_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `ve_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ve_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`ve_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for vendor
-- ----------------------------
DROP TABLE IF EXISTS `vendor`;
CREATE TABLE `vendor`  (
  `v_id` int NOT NULL AUTO_INCREMENT,
  `v_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `v_vendor_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `v_vendor_add` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `v_vendor_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `v_vendor_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `v_user_access` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `v_unique_access_key` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `v_is_active` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Y',
  `last_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_datetime` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`v_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
