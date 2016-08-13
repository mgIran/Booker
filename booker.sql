/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : booker

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-08-13 14:41:15
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
-- Table structure for ym_city_names
-- ----------------------------
DROP TABLE IF EXISTS `ym_city_names`;
CREATE TABLE `ym_city_names` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `city_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام شهر (به فارسی)',
  `country_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام کشور (به فارسی)',
  `city_key` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'شهر مورد نظر',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_city_names
-- ----------------------------
INSERT INTO `ym_city_names` VALUES ('1', 'دبی', 'امارات متحده عربی', '18edc');
INSERT INTO `ym_city_names` VALUES ('2', 'استانبول', 'ترکیه', '19064');
INSERT INTO `ym_city_names` VALUES ('3', 'رم', 'ایتالیا', '1c11e');
INSERT INTO `ym_city_names` VALUES ('4', 'پاریس', 'فرانسه', '161cf');
INSERT INTO `ym_city_names` VALUES ('5', 'مسکو', 'روسیه', '10588');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_contact
-- ----------------------------
INSERT INTO `ym_contact` VALUES ('1', 'مسعود قراگوزلو', 'gharagozlu.masoud@gmail.com', 'شکایت', 'سلام من شکایت دارم.\r\nلطفا رسیدگی کنید.', null);

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
INSERT INTO `ym_counter_save` VALUES ('counter', '128');
INSERT INTO `ym_counter_save` VALUES ('day_time', '2457614');
INSERT INTO `ym_counter_save` VALUES ('max_count', '5');
INSERT INTO `ym_counter_save` VALUES ('max_time', '1457598600');
INSERT INTO `ym_counter_save` VALUES ('yesterday', '0');

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
INSERT INTO `ym_counter_users` VALUES ('837ec5754f503cfaaee0929fd48974e7', '1471082994');

-- ----------------------------
-- Table structure for ym_countries
-- ----------------------------
DROP TABLE IF EXISTS `ym_countries`;
CREATE TABLE `ym_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_countries
-- ----------------------------
INSERT INTO `ym_countries` VALUES ('1', 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', '4', '93');
INSERT INTO `ym_countries` VALUES ('2', 'AL', 'ALBANIA', 'Albania', 'ALB', '8', '355');
INSERT INTO `ym_countries` VALUES ('3', 'DZ', 'ALGERIA', 'Algeria', 'DZA', '12', '213');
INSERT INTO `ym_countries` VALUES ('4', 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', '16', '1684');
INSERT INTO `ym_countries` VALUES ('5', 'AD', 'ANDORRA', 'Andorra', 'AND', '20', '376');
INSERT INTO `ym_countries` VALUES ('6', 'AO', 'ANGOLA', 'Angola', 'AGO', '24', '244');
INSERT INTO `ym_countries` VALUES ('7', 'AI', 'ANGUILLA', 'Anguilla', 'AIA', '660', '1264');
INSERT INTO `ym_countries` VALUES ('8', 'AQ', 'ANTARCTICA', 'Antarctica', null, null, '0');
INSERT INTO `ym_countries` VALUES ('9', 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', '28', '1268');
INSERT INTO `ym_countries` VALUES ('10', 'AR', 'ARGENTINA', 'Argentina', 'ARG', '32', '54');
INSERT INTO `ym_countries` VALUES ('11', 'AM', 'ARMENIA', 'Armenia', 'ARM', '51', '374');
INSERT INTO `ym_countries` VALUES ('12', 'AW', 'ARUBA', 'Aruba', 'ABW', '533', '297');
INSERT INTO `ym_countries` VALUES ('13', 'AU', 'AUSTRALIA', 'Australia', 'AUS', '36', '61');
INSERT INTO `ym_countries` VALUES ('14', 'AT', 'AUSTRIA', 'Austria', 'AUT', '40', '43');
INSERT INTO `ym_countries` VALUES ('15', 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', '31', '994');
INSERT INTO `ym_countries` VALUES ('16', 'BS', 'BAHAMAS', 'Bahamas', 'BHS', '44', '1242');
INSERT INTO `ym_countries` VALUES ('17', 'BH', 'BAHRAIN', 'Bahrain', 'BHR', '48', '973');
INSERT INTO `ym_countries` VALUES ('18', 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', '50', '880');
INSERT INTO `ym_countries` VALUES ('19', 'BB', 'BARBADOS', 'Barbados', 'BRB', '52', '1246');
INSERT INTO `ym_countries` VALUES ('20', 'BY', 'BELARUS', 'Belarus', 'BLR', '112', '375');
INSERT INTO `ym_countries` VALUES ('21', 'BE', 'BELGIUM', 'Belgium', 'BEL', '56', '32');
INSERT INTO `ym_countries` VALUES ('22', 'BZ', 'BELIZE', 'Belize', 'BLZ', '84', '501');
INSERT INTO `ym_countries` VALUES ('23', 'BJ', 'BENIN', 'Benin', 'BEN', '204', '229');
INSERT INTO `ym_countries` VALUES ('24', 'BM', 'BERMUDA', 'Bermuda', 'BMU', '60', '1441');
INSERT INTO `ym_countries` VALUES ('25', 'BT', 'BHUTAN', 'Bhutan', 'BTN', '64', '975');
INSERT INTO `ym_countries` VALUES ('26', 'BO', 'BOLIVIA', 'Bolivia', 'BOL', '68', '591');
INSERT INTO `ym_countries` VALUES ('27', 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', '70', '387');
INSERT INTO `ym_countries` VALUES ('28', 'BW', 'BOTSWANA', 'Botswana', 'BWA', '72', '267');
INSERT INTO `ym_countries` VALUES ('29', 'BV', 'BOUVET ISLAND', 'Bouvet Island', null, null, '0');
INSERT INTO `ym_countries` VALUES ('30', 'BR', 'BRAZIL', 'Brazil', 'BRA', '76', '55');
INSERT INTO `ym_countries` VALUES ('31', 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', null, null, '246');
INSERT INTO `ym_countries` VALUES ('32', 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', '96', '673');
INSERT INTO `ym_countries` VALUES ('33', 'BG', 'BULGARIA', 'Bulgaria', 'BGR', '100', '359');
INSERT INTO `ym_countries` VALUES ('34', 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', '854', '226');
INSERT INTO `ym_countries` VALUES ('35', 'BI', 'BURUNDI', 'Burundi', 'BDI', '108', '257');
INSERT INTO `ym_countries` VALUES ('36', 'KH', 'CAMBODIA', 'Cambodia', 'KHM', '116', '855');
INSERT INTO `ym_countries` VALUES ('37', 'CM', 'CAMEROON', 'Cameroon', 'CMR', '120', '237');
INSERT INTO `ym_countries` VALUES ('38', 'CA', 'CANADA', 'Canada', 'CAN', '124', '1');
INSERT INTO `ym_countries` VALUES ('39', 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', '132', '238');
INSERT INTO `ym_countries` VALUES ('40', 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', '136', '1345');
INSERT INTO `ym_countries` VALUES ('41', 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', '140', '236');
INSERT INTO `ym_countries` VALUES ('42', 'TD', 'CHAD', 'Chad', 'TCD', '148', '235');
INSERT INTO `ym_countries` VALUES ('43', 'CL', 'CHILE', 'Chile', 'CHL', '152', '56');
INSERT INTO `ym_countries` VALUES ('44', 'CN', 'CHINA', 'China', 'CHN', '156', '86');
INSERT INTO `ym_countries` VALUES ('45', 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', null, null, '61');
INSERT INTO `ym_countries` VALUES ('46', 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', null, null, '672');
INSERT INTO `ym_countries` VALUES ('47', 'CO', 'COLOMBIA', 'Colombia', 'COL', '170', '57');
INSERT INTO `ym_countries` VALUES ('48', 'KM', 'COMOROS', 'Comoros', 'COM', '174', '269');
INSERT INTO `ym_countries` VALUES ('49', 'CG', 'CONGO', 'Congo', 'COG', '178', '242');
INSERT INTO `ym_countries` VALUES ('50', 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', '180', '242');
INSERT INTO `ym_countries` VALUES ('51', 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', '184', '682');
INSERT INTO `ym_countries` VALUES ('52', 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', '188', '506');
INSERT INTO `ym_countries` VALUES ('53', 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', '384', '225');
INSERT INTO `ym_countries` VALUES ('54', 'HR', 'CROATIA', 'Croatia', 'HRV', '191', '385');
INSERT INTO `ym_countries` VALUES ('55', 'CU', 'CUBA', 'Cuba', 'CUB', '192', '53');
INSERT INTO `ym_countries` VALUES ('56', 'CY', 'CYPRUS', 'Cyprus', 'CYP', '196', '357');
INSERT INTO `ym_countries` VALUES ('57', 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', '203', '420');
INSERT INTO `ym_countries` VALUES ('58', 'DK', 'DENMARK', 'Denmark', 'DNK', '208', '45');
INSERT INTO `ym_countries` VALUES ('59', 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', '262', '253');
INSERT INTO `ym_countries` VALUES ('60', 'DM', 'DOMINICA', 'Dominica', 'DMA', '212', '1767');
INSERT INTO `ym_countries` VALUES ('61', 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', '214', '1809');
INSERT INTO `ym_countries` VALUES ('62', 'EC', 'ECUADOR', 'Ecuador', 'ECU', '218', '593');
INSERT INTO `ym_countries` VALUES ('63', 'EG', 'EGYPT', 'Egypt', 'EGY', '818', '20');
INSERT INTO `ym_countries` VALUES ('64', 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', '222', '503');
INSERT INTO `ym_countries` VALUES ('65', 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', '226', '240');
INSERT INTO `ym_countries` VALUES ('66', 'ER', 'ERITREA', 'Eritrea', 'ERI', '232', '291');
INSERT INTO `ym_countries` VALUES ('67', 'EE', 'ESTONIA', 'Estonia', 'EST', '233', '372');
INSERT INTO `ym_countries` VALUES ('68', 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', '231', '251');
INSERT INTO `ym_countries` VALUES ('69', 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', '238', '500');
INSERT INTO `ym_countries` VALUES ('70', 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', '234', '298');
INSERT INTO `ym_countries` VALUES ('71', 'FJ', 'FIJI', 'Fiji', 'FJI', '242', '679');
INSERT INTO `ym_countries` VALUES ('72', 'FI', 'FINLAND', 'Finland', 'FIN', '246', '358');
INSERT INTO `ym_countries` VALUES ('73', 'FR', 'FRANCE', 'France', 'FRA', '250', '33');
INSERT INTO `ym_countries` VALUES ('74', 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', '254', '594');
INSERT INTO `ym_countries` VALUES ('75', 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', '258', '689');
INSERT INTO `ym_countries` VALUES ('76', 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', null, null, '0');
INSERT INTO `ym_countries` VALUES ('77', 'GA', 'GABON', 'Gabon', 'GAB', '266', '241');
INSERT INTO `ym_countries` VALUES ('78', 'GM', 'GAMBIA', 'Gambia', 'GMB', '270', '220');
INSERT INTO `ym_countries` VALUES ('79', 'GE', 'GEORGIA', 'Georgia', 'GEO', '268', '995');
INSERT INTO `ym_countries` VALUES ('80', 'DE', 'GERMANY', 'Germany', 'DEU', '276', '49');
INSERT INTO `ym_countries` VALUES ('81', 'GH', 'GHANA', 'Ghana', 'GHA', '288', '233');
INSERT INTO `ym_countries` VALUES ('82', 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', '292', '350');
INSERT INTO `ym_countries` VALUES ('83', 'GR', 'GREECE', 'Greece', 'GRC', '300', '30');
INSERT INTO `ym_countries` VALUES ('84', 'GL', 'GREENLAND', 'Greenland', 'GRL', '304', '299');
INSERT INTO `ym_countries` VALUES ('85', 'GD', 'GRENADA', 'Grenada', 'GRD', '308', '1473');
INSERT INTO `ym_countries` VALUES ('86', 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', '312', '590');
INSERT INTO `ym_countries` VALUES ('87', 'GU', 'GUAM', 'Guam', 'GUM', '316', '1671');
INSERT INTO `ym_countries` VALUES ('88', 'GT', 'GUATEMALA', 'Guatemala', 'GTM', '320', '502');
INSERT INTO `ym_countries` VALUES ('89', 'GN', 'GUINEA', 'Guinea', 'GIN', '324', '224');
INSERT INTO `ym_countries` VALUES ('90', 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', '624', '245');
INSERT INTO `ym_countries` VALUES ('91', 'GY', 'GUYANA', 'Guyana', 'GUY', '328', '592');
INSERT INTO `ym_countries` VALUES ('92', 'HT', 'HAITI', 'Haiti', 'HTI', '332', '509');
INSERT INTO `ym_countries` VALUES ('93', 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', null, null, '0');
INSERT INTO `ym_countries` VALUES ('94', 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', '336', '39');
INSERT INTO `ym_countries` VALUES ('95', 'HN', 'HONDURAS', 'Honduras', 'HND', '340', '504');
INSERT INTO `ym_countries` VALUES ('96', 'HK', 'HONG KONG', 'Hong Kong', 'HKG', '344', '852');
INSERT INTO `ym_countries` VALUES ('97', 'HU', 'HUNGARY', 'Hungary', 'HUN', '348', '36');
INSERT INTO `ym_countries` VALUES ('98', 'IS', 'ICELAND', 'Iceland', 'ISL', '352', '354');
INSERT INTO `ym_countries` VALUES ('99', 'IN', 'INDIA', 'India', 'IND', '356', '91');
INSERT INTO `ym_countries` VALUES ('100', 'ID', 'INDONESIA', 'Indonesia', 'IDN', '360', '62');
INSERT INTO `ym_countries` VALUES ('101', 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', '364', '98');
INSERT INTO `ym_countries` VALUES ('102', 'IQ', 'IRAQ', 'Iraq', 'IRQ', '368', '964');
INSERT INTO `ym_countries` VALUES ('103', 'IE', 'IRELAND', 'Ireland', 'IRL', '372', '353');
INSERT INTO `ym_countries` VALUES ('104', 'IL', 'ISRAEL', 'Israel', 'ISR', '376', '972');
INSERT INTO `ym_countries` VALUES ('105', 'IT', 'ITALY', 'Italy', 'ITA', '380', '39');
INSERT INTO `ym_countries` VALUES ('106', 'JM', 'JAMAICA', 'Jamaica', 'JAM', '388', '1876');
INSERT INTO `ym_countries` VALUES ('107', 'JP', 'JAPAN', 'Japan', 'JPN', '392', '81');
INSERT INTO `ym_countries` VALUES ('108', 'JO', 'JORDAN', 'Jordan', 'JOR', '400', '962');
INSERT INTO `ym_countries` VALUES ('109', 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', '398', '7');
INSERT INTO `ym_countries` VALUES ('110', 'KE', 'KENYA', 'Kenya', 'KEN', '404', '254');
INSERT INTO `ym_countries` VALUES ('111', 'KI', 'KIRIBATI', 'Kiribati', 'KIR', '296', '686');
INSERT INTO `ym_countries` VALUES ('112', 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', '408', '850');
INSERT INTO `ym_countries` VALUES ('113', 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', '410', '82');
INSERT INTO `ym_countries` VALUES ('114', 'KW', 'KUWAIT', 'Kuwait', 'KWT', '414', '965');
INSERT INTO `ym_countries` VALUES ('115', 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', '417', '996');
INSERT INTO `ym_countries` VALUES ('116', 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', '418', '856');
INSERT INTO `ym_countries` VALUES ('117', 'LV', 'LATVIA', 'Latvia', 'LVA', '428', '371');
INSERT INTO `ym_countries` VALUES ('118', 'LB', 'LEBANON', 'Lebanon', 'LBN', '422', '961');
INSERT INTO `ym_countries` VALUES ('119', 'LS', 'LESOTHO', 'Lesotho', 'LSO', '426', '266');
INSERT INTO `ym_countries` VALUES ('120', 'LR', 'LIBERIA', 'Liberia', 'LBR', '430', '231');
INSERT INTO `ym_countries` VALUES ('121', 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', '434', '218');
INSERT INTO `ym_countries` VALUES ('122', 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', '438', '423');
INSERT INTO `ym_countries` VALUES ('123', 'LT', 'LITHUANIA', 'Lithuania', 'LTU', '440', '370');
INSERT INTO `ym_countries` VALUES ('124', 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', '442', '352');
INSERT INTO `ym_countries` VALUES ('125', 'MO', 'MACAO', 'Macao', 'MAC', '446', '853');
INSERT INTO `ym_countries` VALUES ('126', 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', '807', '389');
INSERT INTO `ym_countries` VALUES ('127', 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', '450', '261');
INSERT INTO `ym_countries` VALUES ('128', 'MW', 'MALAWI', 'Malawi', 'MWI', '454', '265');
INSERT INTO `ym_countries` VALUES ('129', 'MY', 'MALAYSIA', 'Malaysia', 'MYS', '458', '60');
INSERT INTO `ym_countries` VALUES ('130', 'MV', 'MALDIVES', 'Maldives', 'MDV', '462', '960');
INSERT INTO `ym_countries` VALUES ('131', 'ML', 'MALI', 'Mali', 'MLI', '466', '223');
INSERT INTO `ym_countries` VALUES ('132', 'MT', 'MALTA', 'Malta', 'MLT', '470', '356');
INSERT INTO `ym_countries` VALUES ('133', 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', '584', '692');
INSERT INTO `ym_countries` VALUES ('134', 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', '474', '596');
INSERT INTO `ym_countries` VALUES ('135', 'MR', 'MAURITANIA', 'Mauritania', 'MRT', '478', '222');
INSERT INTO `ym_countries` VALUES ('136', 'MU', 'MAURITIUS', 'Mauritius', 'MUS', '480', '230');
INSERT INTO `ym_countries` VALUES ('137', 'YT', 'MAYOTTE', 'Mayotte', null, null, '269');
INSERT INTO `ym_countries` VALUES ('138', 'MX', 'MEXICO', 'Mexico', 'MEX', '484', '52');
INSERT INTO `ym_countries` VALUES ('139', 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', '583', '691');
INSERT INTO `ym_countries` VALUES ('140', 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', '498', '373');
INSERT INTO `ym_countries` VALUES ('141', 'MC', 'MONACO', 'Monaco', 'MCO', '492', '377');
INSERT INTO `ym_countries` VALUES ('142', 'MN', 'MONGOLIA', 'Mongolia', 'MNG', '496', '976');
INSERT INTO `ym_countries` VALUES ('143', 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', '500', '1664');
INSERT INTO `ym_countries` VALUES ('144', 'MA', 'MOROCCO', 'Morocco', 'MAR', '504', '212');
INSERT INTO `ym_countries` VALUES ('145', 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', '508', '258');
INSERT INTO `ym_countries` VALUES ('146', 'MM', 'MYANMAR', 'Myanmar', 'MMR', '104', '95');
INSERT INTO `ym_countries` VALUES ('147', 'NA', 'NAMIBIA', 'Namibia', 'NAM', '516', '264');
INSERT INTO `ym_countries` VALUES ('148', 'NR', 'NAURU', 'Nauru', 'NRU', '520', '674');
INSERT INTO `ym_countries` VALUES ('149', 'NP', 'NEPAL', 'Nepal', 'NPL', '524', '977');
INSERT INTO `ym_countries` VALUES ('150', 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', '528', '31');
INSERT INTO `ym_countries` VALUES ('151', 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', '530', '599');
INSERT INTO `ym_countries` VALUES ('152', 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', '540', '687');
INSERT INTO `ym_countries` VALUES ('153', 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', '554', '64');
INSERT INTO `ym_countries` VALUES ('154', 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', '558', '505');
INSERT INTO `ym_countries` VALUES ('155', 'NE', 'NIGER', 'Niger', 'NER', '562', '227');
INSERT INTO `ym_countries` VALUES ('156', 'NG', 'NIGERIA', 'Nigeria', 'NGA', '566', '234');
INSERT INTO `ym_countries` VALUES ('157', 'NU', 'NIUE', 'Niue', 'NIU', '570', '683');
INSERT INTO `ym_countries` VALUES ('158', 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', '574', '672');
INSERT INTO `ym_countries` VALUES ('159', 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', '580', '1670');
INSERT INTO `ym_countries` VALUES ('160', 'NO', 'NORWAY', 'Norway', 'NOR', '578', '47');
INSERT INTO `ym_countries` VALUES ('161', 'OM', 'OMAN', 'Oman', 'OMN', '512', '968');
INSERT INTO `ym_countries` VALUES ('162', 'PK', 'PAKISTAN', 'Pakistan', 'PAK', '586', '92');
INSERT INTO `ym_countries` VALUES ('163', 'PW', 'PALAU', 'Palau', 'PLW', '585', '680');
INSERT INTO `ym_countries` VALUES ('164', 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', null, null, '970');
INSERT INTO `ym_countries` VALUES ('165', 'PA', 'PANAMA', 'Panama', 'PAN', '591', '507');
INSERT INTO `ym_countries` VALUES ('166', 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', '598', '675');
INSERT INTO `ym_countries` VALUES ('167', 'PY', 'PARAGUAY', 'Paraguay', 'PRY', '600', '595');
INSERT INTO `ym_countries` VALUES ('168', 'PE', 'PERU', 'Peru', 'PER', '604', '51');
INSERT INTO `ym_countries` VALUES ('169', 'PH', 'PHILIPPINES', 'Philippines', 'PHL', '608', '63');
INSERT INTO `ym_countries` VALUES ('170', 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', '612', '0');
INSERT INTO `ym_countries` VALUES ('171', 'PL', 'POLAND', 'Poland', 'POL', '616', '48');
INSERT INTO `ym_countries` VALUES ('172', 'PT', 'PORTUGAL', 'Portugal', 'PRT', '620', '351');
INSERT INTO `ym_countries` VALUES ('173', 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', '630', '1787');
INSERT INTO `ym_countries` VALUES ('174', 'QA', 'QATAR', 'Qatar', 'QAT', '634', '974');
INSERT INTO `ym_countries` VALUES ('175', 'RE', 'REUNION', 'Reunion', 'REU', '638', '262');
INSERT INTO `ym_countries` VALUES ('176', 'RO', 'ROMANIA', 'Romania', 'ROM', '642', '40');
INSERT INTO `ym_countries` VALUES ('177', 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', '643', '70');
INSERT INTO `ym_countries` VALUES ('178', 'RW', 'RWANDA', 'Rwanda', 'RWA', '646', '250');
INSERT INTO `ym_countries` VALUES ('179', 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', '654', '290');
INSERT INTO `ym_countries` VALUES ('180', 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', '659', '1869');
INSERT INTO `ym_countries` VALUES ('181', 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', '662', '1758');
INSERT INTO `ym_countries` VALUES ('182', 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', '666', '508');
INSERT INTO `ym_countries` VALUES ('183', 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', '670', '1784');
INSERT INTO `ym_countries` VALUES ('184', 'WS', 'SAMOA', 'Samoa', 'WSM', '882', '684');
INSERT INTO `ym_countries` VALUES ('185', 'SM', 'SAN MARINO', 'San Marino', 'SMR', '674', '378');
INSERT INTO `ym_countries` VALUES ('186', 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', '678', '239');
INSERT INTO `ym_countries` VALUES ('187', 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', '682', '966');
INSERT INTO `ym_countries` VALUES ('188', 'SN', 'SENEGAL', 'Senegal', 'SEN', '686', '221');
INSERT INTO `ym_countries` VALUES ('189', 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', null, null, '381');
INSERT INTO `ym_countries` VALUES ('190', 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', '690', '248');
INSERT INTO `ym_countries` VALUES ('191', 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', '694', '232');
INSERT INTO `ym_countries` VALUES ('192', 'SG', 'SINGAPORE', 'Singapore', 'SGP', '702', '65');
INSERT INTO `ym_countries` VALUES ('193', 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', '703', '421');
INSERT INTO `ym_countries` VALUES ('194', 'SI', 'SLOVENIA', 'Slovenia', 'SVN', '705', '386');
INSERT INTO `ym_countries` VALUES ('195', 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', '90', '677');
INSERT INTO `ym_countries` VALUES ('196', 'SO', 'SOMALIA', 'Somalia', 'SOM', '706', '252');
INSERT INTO `ym_countries` VALUES ('197', 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', '710', '27');
INSERT INTO `ym_countries` VALUES ('198', 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', null, null, '0');
INSERT INTO `ym_countries` VALUES ('199', 'ES', 'SPAIN', 'Spain', 'ESP', '724', '34');
INSERT INTO `ym_countries` VALUES ('200', 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', '144', '94');
INSERT INTO `ym_countries` VALUES ('201', 'SD', 'SUDAN', 'Sudan', 'SDN', '736', '249');
INSERT INTO `ym_countries` VALUES ('202', 'SR', 'SURINAME', 'Suriname', 'SUR', '740', '597');
INSERT INTO `ym_countries` VALUES ('203', 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', '744', '47');
INSERT INTO `ym_countries` VALUES ('204', 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', '748', '268');
INSERT INTO `ym_countries` VALUES ('205', 'SE', 'SWEDEN', 'Sweden', 'SWE', '752', '46');
INSERT INTO `ym_countries` VALUES ('206', 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', '756', '41');
INSERT INTO `ym_countries` VALUES ('207', 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', '760', '963');
INSERT INTO `ym_countries` VALUES ('208', 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', '158', '886');
INSERT INTO `ym_countries` VALUES ('209', 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', '762', '992');
INSERT INTO `ym_countries` VALUES ('210', 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', '834', '255');
INSERT INTO `ym_countries` VALUES ('211', 'TH', 'THAILAND', 'Thailand', 'THA', '764', '66');
INSERT INTO `ym_countries` VALUES ('212', 'TL', 'TIMOR-LESTE', 'Timor-Leste', null, null, '670');
INSERT INTO `ym_countries` VALUES ('213', 'TG', 'TOGO', 'Togo', 'TGO', '768', '228');
INSERT INTO `ym_countries` VALUES ('214', 'TK', 'TOKELAU', 'Tokelau', 'TKL', '772', '690');
INSERT INTO `ym_countries` VALUES ('215', 'TO', 'TONGA', 'Tonga', 'TON', '776', '676');
INSERT INTO `ym_countries` VALUES ('216', 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', '780', '1868');
INSERT INTO `ym_countries` VALUES ('217', 'TN', 'TUNISIA', 'Tunisia', 'TUN', '788', '216');
INSERT INTO `ym_countries` VALUES ('218', 'TR', 'TURKEY', 'Turkey', 'TUR', '792', '90');
INSERT INTO `ym_countries` VALUES ('219', 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', '795', '7370');
INSERT INTO `ym_countries` VALUES ('220', 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', '796', '1649');
INSERT INTO `ym_countries` VALUES ('221', 'TV', 'TUVALU', 'Tuvalu', 'TUV', '798', '688');
INSERT INTO `ym_countries` VALUES ('222', 'UG', 'UGANDA', 'Uganda', 'UGA', '800', '256');
INSERT INTO `ym_countries` VALUES ('223', 'UA', 'UKRAINE', 'Ukraine', 'UKR', '804', '380');
INSERT INTO `ym_countries` VALUES ('224', 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', '784', '971');
INSERT INTO `ym_countries` VALUES ('225', 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', '826', '44');
INSERT INTO `ym_countries` VALUES ('226', 'US', 'UNITED STATES', 'United States', 'USA', '840', '1');
INSERT INTO `ym_countries` VALUES ('227', 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', null, null, '1');
INSERT INTO `ym_countries` VALUES ('228', 'UY', 'URUGUAY', 'Uruguay', 'URY', '858', '598');
INSERT INTO `ym_countries` VALUES ('229', 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', '860', '998');
INSERT INTO `ym_countries` VALUES ('230', 'VU', 'VANUATU', 'Vanuatu', 'VUT', '548', '678');
INSERT INTO `ym_countries` VALUES ('231', 'VE', 'VENEZUELA', 'Venezuela', 'VEN', '862', '58');
INSERT INTO `ym_countries` VALUES ('232', 'VN', 'VIET NAM', 'Viet Nam', 'VNM', '704', '84');
INSERT INTO `ym_countries` VALUES ('233', 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', '92', '1284');
INSERT INTO `ym_countries` VALUES ('234', 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', '850', '1340');
INSERT INTO `ym_countries` VALUES ('235', 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', '876', '681');
INSERT INTO `ym_countries` VALUES ('236', 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', '732', '212');
INSERT INTO `ym_countries` VALUES ('237', 'YE', 'YEMEN', 'Yemen', 'YEM', '887', '967');
INSERT INTO `ym_countries` VALUES ('238', 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', '894', '260');
INSERT INTO `ym_countries` VALUES ('239', 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', '716', '263');

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
-- Table structure for ym_order
-- ----------------------------
DROP TABLE IF EXISTS `ym_order`;
CREATE TABLE `ym_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `buyer_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام',
  `buyer_family` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام خانوادگی',
  `buyer_mobile` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تلفن همراه',
  `buyer_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'پست الکترونیکی',
  `date` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تاریخ رزرو',
  `order_id` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'شماره سفارش',
  `travia_id` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'شناسه تراویا',
  `price` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'مبلغ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_order
-- ----------------------------

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
INSERT INTO `ym_pages` VALUES ('1', 'درباره ما', '<p>پروژه بوكر24 دات نت كه با صاحب امتيازي آقاي بهنام حدادي به عنوان مدير عامل دفتر خدمات مسافرتي و جهانگردي ميراث سفربا كد فعاليت 2401210139300173 صادر شده از سازمان ميراث فرهنگي ، صنايع دستي و گردشگري است . اين سايت&nbsp; سایت مختص به رزرواسیون آنلاین هتل است که قابلیت رزرو آنی اتاق در بیش از ۱۰۰ هزار هتل و هتل آپارتمان را با قیمتهای باور نکردنی به کاربران می دهد.<br />\r\nگروه ما متشکل از متخصصین ایرانی و بومي كه از فارغ التخصيلان رشته هاي صنعت گردشگري و هتلداري و با همكاري با متخصصان خارجي که سالها تجربه در صنعت وب و گردشگری را برای ایجاد هتل با ما به کار برده اند. برآن هسستيم بتوانيم به صورت كاملا تخصصي رو راحت فرايند رزرو هتل در سراسر جهان را به شما عرضه كنيم</p>\r\n\r\n<h2>&nbsp;خدمات ما</h2>\r\n\r\n<p>شما می توانید در هر ساعتی و از هر کجایی که باشید محل اقامت سفرتان را از بیش از ۱۰۰ هزار هتل وهتل آپارتمان در سر تا سر دنیا انتخاب کنید و کلیه مراحل رزرواسیون هتل را با پرداخت آنلاین کامل کنید.<br />\r\nواچر و مدرک رزرواسیون آنی پس از اتمام مرحله پرداخت به ایمیل شما ارسال می شود. هر جای دنیا که باشد از شمالي ترين نقطه دنيا تا جنوبي ترين نقطه دنيا از شرق تا غرب همه و همهتنها با چند كليك و برای هر سلیقه از هتل های کوچک و ارزان تا هتل های مجلل و پنج ستاره هتل با ما جوابگوی سلیقه ها خواهد بود.</p>\r\n\r\n<h2>&nbsp;اهداف</h2>\r\n\r\n<p>با توجه به افزايش ارتباطات جهاني لزوم توجه فناوري هاي نو در عرصه صنعت گردشگري بوكر دات نت با هدف سهولت و راحتي و سادگي در رزرواسيون را براي شما به ارمغان آورده و با هدف ايجاد بستر نوين در سنعت گردشگري در خدمت گردشگران خواهد بود</p>\r\n\r\n<h2>&nbsp; به ما اعتماد کنید</h2>\r\n\r\n<p>برای اعتماد به یک تجارت آنلاین نکات مختلفی را در نظر بگیرید. مهمتر از همه خود سایت و محتوای آن می باشد. ایجاد یک سایت جدی با کیفیت بالا کم هزینه که نیست هیچ بلکه از بسیاری از تجارت های معمولی دیگر می تواند پرکارتر و هزینه برتر باشد. با کمی گردش و کار کردن در سایت ما می توانید به جدی بودن ما برای ارائه بهترین خدمات رزرو آنلاین هتل پی ببرید. این سایت با سرمایه گذاری بالا و تلاش بسیاری توسط گروهی از بهترین های این صنعت راه اندازی شده و همواره توانسته است که اعتبار کاری خود را برای هزاران کاربر سایت اثبات کند.</p>\r\n\r\n<p>دفتر خدمات مسافرتي ميراث سفر به عنوان مجري اين سايت همواره پاسخگويي نظرات ، انتقادات و شكايات شما مي باشد .</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', '1');
INSERT INTO `ym_pages` VALUES ('2', 'تماس با ما', '<p>آدرس : اردبيل -خيابان نايبي نبش كوچه 21 پلاك 305 - دفتر خدمات مسافرتي و جهانگردي ميراث سفر</p>\r\n\r\n<p>تلفن تماس : 04533243543</p>\r\n\r\n<p>پشتيباني رزرواسيون : 09141520633</p>\r\n', '1');
INSERT INTO `ym_pages` VALUES ('3', 'راهنما', '<p>عملیاتی که در این سایت برای انجام رزرو در نظر گرفته شده است بسیار ساده طراحی شده است و کافیست مراحل سایت را پیگیری نموده و تا در نهایت هتل مورد نظر خود را رزرو و <a href=\"http://www.berimsafar.com/InstantConfirmation.aspx\" id=\"ctl00_ContentPlaceHolder1_HyperLink4\" tabindex=\"-1\">واچر (تاییدیه رزرو) </a> را به زبان انگلیسی دریافت نمایید. مراحل رزرو هتل و دریافت واچر کاملا آنلاین بوده و نیاز به انتظار جهت تایید توسط آژانس و یا پیگیری رزرو از سوی شما کاربر گرامی ندارد.<br />\r\n<br />\r\n<strong>مراحل رزرو هتل در سایت Booker24.Net :</strong></p>\r\n\r\n<p><strong>(قبل از اقدام به رزرو پيشنهاد ميشود در سايت ثبت نام كنيد) </strong></p>\r\n\r\n<p>۱- جستجوی هتل<br />\r\n۲- انتخاب هتل<br />\r\n۳- انتخاب اتاق و وعده غذایی<br />\r\n۴- اطلاعات مسافرها<br />\r\n۵- پرداخت الکترونیک<br />\r\n۶- دریافت <a href=\"http://www.berimsafar.com/InstantConfirmation.aspx\" id=\"ctl00_ContentPlaceHolder1_HyperLink1\" tabindex=\"-1\">واچر (تاییدیه رزرو) </a></p>\r\n\r\n<p>مرحله اول:&nbsp; شهر يا كشور مورد نظر خود جهت رزرو هتل وارد نمائيد</p>\r\n\r\n<p>مرحله دوم : تاريخ ورود و خروج خودتان را مشخص كنيد</p>\r\n\r\n<p>مرحله سوم : تعداد اتاق خود را بر حسب تعداد نفرات بزرگسال و كودك را وارد كنيد</p>\r\n\r\n<p>و در آخر كليد جستجو را كليك نمائيد .</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', '1');
INSERT INTO `ym_pages` VALUES ('4', 'شرایط استفاده از خدمات', '<ol dir=\"rtl\">\r\n	<li>وب&zwnj;سایت بوكر24دات نت به نشانی اینترنتی&nbsp; بستری برای رزرو آنلاین هتل&zwnj; هاي خارجي<span dir=\"LTR\"> (</span>و سایر مکان&zwnj;های اقامتی موقت) است. با انجام رزرو در این وب&zwnj;سایت، شما با هتلی که در آن اتاق رزرو کرده&zwnj;اید ؛ قراردادی قانونی می&zwnj;بندید. در این قرارداد، ما تنها نقش واسطه را ایفا می&zwnj;کنیم؛ اطلاعات رزرو شما را برای هتل فرستاده و ایمیل تاییدیه نهایی را از طرف هتل برای شما ارسال می&zwnj;کنیم<span dir=\"LTR\">. </span></li>\r\n	<li>بخش رزرو وب&zwnj;سایت بوكر24دات نت طوری طراحی شده تا به شما در دسترسی به اطلاعات موجود درباره&zwnj;ی هتل&zwnj;ها و همچنین قانونی کردن ثبت این قرارداد کمک کند. تسهیلات رزرو موجود بر روی وب&zwnj;سایت، تنها برای قانونی کردن قرارداد بین شما و هتل طراحی شده و مسئولیت هرگونه سوء استفاده و عواقب ناشی از استفاده&zwnj;ی نادرست از آن، بر عهده&zwnj;ی شخص خواهد بود. در صورت مشاهده&zwnj;ی تخلف، دسترسی کاربر به اطلاعات قطع خواهد شد</li>\r\n	<li>در صورت رعایت نکردن مورد فوق، مسئولیت هرگونه جریمه&zwnj;ی احتمالی، ضرر مالی و یا سوء استفاده&zwnj;های احتمالی اشخاص دیگر، بر عهده&zwnj;ی کاربر خواهد بود<span dir=\"LTR\">.</span></li>\r\n	<li>اطلاعات مربوط به هتل&zwnj;ها که در این وب&zwnj;سایت بوكر24دات نت قرار گرفته، توسط هتل&zwnj;ها تولید می&zwnj;شود. این اطلاعات شامل قیمت&zwnj;های به&zwnj;روز شده، خالی بودن اتاق&zwnj;ها و... است و مسئولیت صحت آن، بر عهده&zwnj;ی هتل می&zwnj;باشد. با وجود ما تلاش خواهيم كرد این اطلاعات را به بهترین شکل ممکن ارائه شود، اما نمی&zwnj;تواند صحت و جامع بودن آن&zwnj;ها را تایید یا رد کند</li>\r\n	<li>قیمت&zwnj;های ارائه شده در این وب&zwnj;سایت بوكر24دات نت، مبلغی است که کاربر باید برای کل مدت اقامت و برای یک اتاق بپردازد؛ مگر در قسمت&zwnj;هایی که خلاف این مطلب ذکر می&zwnj;گردد&nbsp;</li>\r\n	<li>قیمت&zwnj;های نمایش&zwnj;داده شده روی سایت بوكر24دات نت به ارز ايران و مبلغ پرداختی توسط کاربر از طریق بانک به ریال می&zwnj;باشند</li>\r\n	<li>برای انجام رزرو، کاربر با انتخاب مقصد كه در نظر دارد، می&zwnj;تواند به بررسی هتل&zwnj;ها&nbsp; موجود بپردازد و در صورت نیاز؛ اطلاعات تکمیلی را از دفتر بخواهد به کمک مجموعه اطلاعاتی که از طريق دفتر فراهم می&zwnj;شود، کاربران می&zwnj;توانند با توجه به نیازهای سفر، هتل بهتری هم انتخاب کنند. بعد از انتخاب و اقدام برای رزرو هتل ، از کاربر تایید نهایی گرفته می&zwnj;شود&nbsp;رزرو هتل فقط در برگیرنده&zwnj;ی رزرو هتل است و شامل مواردی چون حمل و نقل، پارکینگ، اجاره&zwnj;ی خودرو و...نیست؛ مگر آنکه در قرارداد ذکر شده باشد<span dir=\"LTR\">.</span></li>\r\n	<li>اگر در جریان پرداخت پول، ارتباط با شبکه قطع شود، وظیفه&zwnj;ی حل مشکلات احتمالی بر عهده&zwnj;ی بانک می&zwnj;باشد و هزینه&zwnj;ی کم شده از حساب، طبق قوانین بانکی به حساب مشتری برخواهد گشت. وب&zwnj;سایت بوكر24دات نت&nbsp; در این روند مسؤولیتی ندارد؛ چون این عمل مستقیما توسط بانک انجام می&zwnj;گیرد؛ اما در تسهیل آن تلاش خواهد کرد<span dir=\"LTR\">.</span></li>\r\n	<li>بعد از انجام رزرو و صدور رسید یا واچر، وب&zwnj;سایت بوكر24دات نت&nbsp; تعهد می&zwnj;کند که هتل در آن تاریخ رزرو شده است؛ اما متضمن ارائه&zwnj;ی سرویس مناسب از طرف هتل یا به مسافر نیست<span dir=\"LTR\">.</span></li>\r\n	<li>ارائه&zwnj;ی اطلاعات شخصی صحیح، نظیر نام مطابق با نام مندرج در پاسپورت، تعداد مسافران، سن و... بر عهده&zwnj;ی کاربر می&zwnj;باشد. مشکلات ناشی از ورود اطلاعات نادرست توسط کاربر، بر عهده&zwnj;ی وب&zwnj;سایت زورق&zwnj;دات&zwnj;کام نخواهد بود<span dir=\"LTR\">.</span></li>\r\n	<li>وب&zwnj;سایت بوكر24دات نت تلاش می&zwnj;کند درخواست&zwnj;های ویژه&zwnj;ی مشتریان در زمان انجام رزرو را به هتل&nbsp; منتقل کرده و آن&zwnj;ها را انجام دهد؛ اما چون پاسخ نهایی این درخواست&zwnj;ها از جانب هتل&nbsp; خواهد بود، تعهدی نسبت به آن&zwnj;ها ندارد<span dir=\"LTR\">.</span></li>\r\n	<li>استفاده از امکاناتی نظیر خوراکی و نوشیدنی، سونا، جکوزی، استخر، اینترنت و... که در قرارداد هتل ذکر نشده&zwnj;اند، هزینه&zwnj;ی اضافی در بر دارد. این هزینه&zwnj;ها به عهده&zwnj;ی وب&zwnj;سایت&nbsp; نبوده و مسافر موظف است آن&zwnj;ها را مستقیما به هتل پرداخت کند<span dir=\"LTR\">.</span></li>\r\n	<li>با تایید هتل بابت رزرو اتاق از یک هتل، کاربر با قوانین و مقررات مربوط به فسخ رزرو هم موافقت می&zwnj;کند. این قوانین در بخش اطلاعات هتل، بخش رزرو و ای&zwnj;میل تایید رزرواسیون قابل مشاهده&zwnj;اند. دقت داشته باشید که ممکن است کاربر مجبور شود به خاطر فسخ قرارداد هزینه&zwnj;ای بپردازد. این هزینه&zwnj;ها طبق مقررات هر هتل متفاوت&zwnj;اند؛ به همین دلیل به کاربران محترم توصیه می&zwnj;کنیم که قبل از قطعی کردن هر قرارداد، مفاد آن را به دقت مطالعه فرمایند<span dir=\"LTR\">.</span></li>\r\n	<li>اگر قرارداد توسط مسافر لغو شود، بازپرداخت آن تنها از طریق شماره&zwnj;ی حساب یا کارت بانکی که پیش از این توسط وی اعلام شده، خواهد بود. روند بازپرداخت وجه ممکن است تا یک هفته به طول انجامد<span dir=\"LTR\">.</span></li>\r\n	<li>زمان ورود/خروج مسافر به/از هتل، در بخش اطلاعات هتل، بخش رزرواسیون و ایمیل تایید رزرواسیون ذکر شده و مسافر موظف است طبق آن زمان&zwnj;بندی عمل کند. در غیر این&zwnj;صورت، هزینه&zwnj;ی آن بر عهده&zwnj;ی مشتری بوده و از تعهدات وب&zwnj;سایت بوكر24دات نت نیست</li>\r\n</ol>\r\n', '1');

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
-- Table structure for ym_passengers
-- ----------------------------
DROP TABLE IF EXISTS `ym_passengers`;
CREATE TABLE `ym_passengers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام',
  `family` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام خانوادگی',
  `gender` varchar(6) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'جنسیت',
  `passport_num` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'شماره گذرنامه',
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نوع',
  `age` varchar(3) CHARACTER SET utf8 DEFAULT NULL COMMENT 'سن',
  `room_num` int(11) DEFAULT NULL COMMENT 'شماره اتاق',
  `order_id` int(10) unsigned DEFAULT NULL COMMENT 'سفارش',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `ym_passengers_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `ym_order` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ym_passengers
-- ----------------------------

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
INSERT INTO `ym_site_setting` VALUES ('5', 'commission', 'کمیسیون سایت', '5000');

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
