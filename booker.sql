/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : booker

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-05-17 13:18:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ym_admins
-- ----------------------------
DROP TABLE IF EXISTS `ym_admins`;
CREATE TABLE `ym_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(11) unsigned NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `ym_admins_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_admin_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admins
-- ----------------------------
INSERT INTO `ym_admins` VALUES ('24', 'admin', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'admin@gmial.com', '1');

-- ----------------------------
-- Table structure for ym_admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_admin_roles`;
CREATE TABLE `ym_admin_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'عنوان نقش',
  `role` varchar(255) NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_admin_roles
-- ----------------------------
INSERT INTO `ym_admin_roles` VALUES ('1', 'مدیر', 'admin');
INSERT INTO `ym_admin_roles` VALUES ('2', 'ناظر', 'validator');

-- ----------------------------
-- Table structure for ym_contact
-- ----------------------------
DROP TABLE IF EXISTS `ym_contact`;
CREATE TABLE `ym_contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام و نام خانوادگی',
  `email` varchar(100) DEFAULT NULL COMMENT 'پست الکترونیکی',
  `subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'موضوع',
  `body` text CHARACTER SET utf8 COLLATE utf8_persian_ci COMMENT 'متن پیام',
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ ارسال',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_contact
-- ----------------------------

-- ----------------------------
-- Table structure for ym_counter_save
-- ----------------------------
DROP TABLE IF EXISTS `ym_counter_save`;
CREATE TABLE `ym_counter_save` (
  `save_name` varchar(10) NOT NULL,
  `save_value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`save_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_counter_save
-- ----------------------------
INSERT INTO `ym_counter_save` VALUES ('counter', '82');
INSERT INTO `ym_counter_save` VALUES ('day_time', '2457526');
INSERT INTO `ym_counter_save` VALUES ('max_count', '5');
INSERT INTO `ym_counter_save` VALUES ('max_time', '1457598600');
INSERT INTO `ym_counter_save` VALUES ('yesterday', '1');

-- ----------------------------
-- Table structure for ym_counter_users
-- ----------------------------
DROP TABLE IF EXISTS `ym_counter_users`;
CREATE TABLE `ym_counter_users` (
  `user_ip` varchar(255) NOT NULL,
  `user_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_counter_users
-- ----------------------------
INSERT INTO `ym_counter_users` VALUES ('837ec5754f503cfaaee0929fd48974e7', '1463474456');

-- ----------------------------
-- Table structure for ym_google_maps
-- ----------------------------
DROP TABLE IF EXISTS `ym_google_maps`;
CREATE TABLE `ym_google_maps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `map_lat` varchar(30) NOT NULL DEFAULT '34.6327505',
  `map_lng` varchar(30) NOT NULL DEFAULT '50.8644157',
  `map_zoom` varchar(5) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_google_maps
-- ----------------------------
INSERT INTO `ym_google_maps` VALUES ('1', '', '35.72781914695719', '51.41998856328428', '19');

-- ----------------------------
-- Table structure for ym_pages
-- ----------------------------
DROP TABLE IF EXISTS `ym_pages`;
CREATE TABLE `ym_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `summary` text COMMENT 'متن',
  `category_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `ym_pages_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ym_page_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_pages
-- ----------------------------
INSERT INTO `ym_pages` VALUES ('1', 'درباره ما', 'متن صفحه درباره ما', '1');
INSERT INTO `ym_pages` VALUES ('2', 'تماس با ما', 'متن صفحه تماس با ما', '1');
INSERT INTO `ym_pages` VALUES ('3', 'راهنما', 'متن صفحه راهنما', '1');
INSERT INTO `ym_pages` VALUES ('4', 'شرایط استفاده از خدمات', 'متن صفحه شرایط استفاده از خدمات', '1');

-- ----------------------------
-- Table structure for ym_page_categories
-- ----------------------------
DROP TABLE IF EXISTS `ym_page_categories`;
CREATE TABLE `ym_page_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `slug` varchar(255) DEFAULT NULL COMMENT 'آدرس',
  `multiple` tinyint(1) unsigned DEFAULT '1' COMMENT 'چند صحفه ای',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_page_categories
-- ----------------------------
INSERT INTO `ym_page_categories` VALUES ('1', 'صفحات استاتیک', 'base', '1');

-- ----------------------------
-- Table structure for ym_site_setting
-- ----------------------------
DROP TABLE IF EXISTS `ym_site_setting`;
CREATE TABLE `ym_site_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_site_setting
-- ----------------------------
INSERT INTO `ym_site_setting` VALUES ('1', 'site_title', 'عنوان سایت', 'رزرو آنلاین هتل های خارجی');
INSERT INTO `ym_site_setting` VALUES ('2', 'default_title', 'عنوان پیش فرض صفحات', 'بوکر');
INSERT INTO `ym_site_setting` VALUES ('3', 'keywords', 'کلمات کلیدی سایت', 'رزرو، هتل، رزرواسیون هتل');
INSERT INTO `ym_site_setting` VALUES ('4', 'site_description', 'شرح وبسایت', 'رزرو آنلاین هتل های خارجی');

-- ----------------------------
-- Table structure for ym_users
-- ----------------------------
DROP TABLE IF EXISTS `ym_users`;
CREATE TABLE `ym_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(10) unsigned DEFAULT NULL,
  `create_date` varchar(20) DEFAULT NULL,
  `status` enum('pending','active','blocked','deleted') DEFAULT 'pending',
  `verification_token` varchar(100) DEFAULT NULL,
  `change_password_request_count` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `ym_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_user_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ym_users
-- ----------------------------
INSERT INTO `ym_users` VALUES ('45', '', '$2a$12$.jA2p7skErfyCSiHWA5QHOix0Zsks2iogvTYchYFeI3shPm.KKeNO', 'gharagozlu.masoud@gmail.com', '1', '1462680947', 'active', '7f7fe1063bbab5e64dc32115dd9293e0', '0');
INSERT INTO `ym_users` VALUES ('46', '', '$2a$12$RyLpBw/l8829WDpIwh0Rrut5PgNiqpcWd9Cj.hnsAdtP.CgKNpI3q', 'mr.m.gharagozlu@gmail.com', '1', '1462734385', 'pending', '06a66aecc07a153e28c562b86e4eefdb', '0');

-- ----------------------------
-- Table structure for ym_user_details
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_details`;
CREATE TABLE `ym_user_details` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'کاربر',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام',
  `avatar` varchar(20) DEFAULT NULL COMMENT 'تصویر پروفایل',
  `national_code` varchar(20) DEFAULT NULL COMMENT 'کد ملی',
  `phone` varchar(11) DEFAULT NULL COMMENT 'شماره تماس',
  `address` varchar(1000) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آدرس',
  PRIMARY KEY (`user_id`),
  CONSTRAINT `ym_user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_user_details
-- ----------------------------
INSERT INTO `ym_user_details` VALUES ('45', null, null, null, null, null);
INSERT INTO `ym_user_details` VALUES ('46', null, null, null, null, null);

-- ----------------------------
-- Table structure for ym_user_roles
-- ----------------------------
DROP TABLE IF EXISTS `ym_user_roles`;
CREATE TABLE `ym_user_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- ----------------------------
-- Records of ym_user_roles
-- ----------------------------
INSERT INTO `ym_user_roles` VALUES ('1', 'کاربر معمولی', 'user');
