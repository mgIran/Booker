-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2016 at 12:24 PM
-- Server version: 5.6.33-cll-lve
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bookerne_ymdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ym_admins`
--

CREATE TABLE IF NOT EXISTS `ym_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT 'پست الکترونیک',
  `role_id` int(11) unsigned NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `ym_admins`
--

INSERT INTO `ym_admins` (`id`, `username`, `password`, `email`, `role_id`) VALUES
(24, 'admin', '$2a$12$92HG95rnUS5MYLFvDjn2cOU4O4p64mpH9QnxFYzVnk9CjQIPrcTBC', 'admin@gmial.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ym_admin_roles`
--

CREATE TABLE IF NOT EXISTS `ym_admin_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'عنوان نقش',
  `role` varchar(255) NOT NULL COMMENT 'نقش',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ym_admin_roles`
--

INSERT INTO `ym_admin_roles` (`id`, `name`, `role`) VALUES
(1, 'مدیر', 'admin'),
(2, 'ناظر', 'validator');

-- --------------------------------------------------------

--
-- Table structure for table `ym_bookings`
--

CREATE TABLE IF NOT EXISTS `ym_bookings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `order_id` int(10) unsigned DEFAULT NULL COMMENT 'سفارش',
  `hotel` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'هتل',
  `star` varchar(2) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تعداد ستاره های هتل',
  `address` varchar(1024) CHARACTER SET utf8 DEFAULT NULL COMMENT 'آدرس',
  `phone` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تلفن',
  `zipCode` varchar(20) DEFAULT NULL COMMENT 'کد پستی',
  `checkinFrom` varchar(10) CHARACTER SET utf8 DEFAULT NULL COMMENT 'ساعت ورود',
  `checkoutTo` varchar(10) CHARACTER SET utf8 DEFAULT NULL COMMENT 'ساعت خروج',
  `latitude` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT 'lat',
  `longitude` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT 'lng',
  `desciption` text CHARACTER SET utf8 COMMENT 'توضیحات',
  `country` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'کشور',
  `city` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'شهر',
  `passenger` varchar(10) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تعداد مسافرین',
  `traviaId` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'شناسه تراویا',
  `createdAt` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تاریخ ثبت',
  `checkIn` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تاریخ ورود',
  `checkOut` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تاریخ خروج',
  `nationality` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'ملیت',
  `currency` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'واحد ارز',
  `meal` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'پذیرایی',
  `price` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'قیمت',
  `status` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'وضعیت',
  `nonrefundable` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'قابلیت استرداد',
  `cancelRules` text CHARACTER SET utf8 COMMENT 'شرایط کنسلی',
  `confirmationDetails` text CHARACTER SET utf8 COMMENT 'جزئیات تاییده',
  `orderId` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'شناسه سفارش',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `ym_bookings`
--

INSERT INTO `ym_bookings` (`id`, `order_id`, `hotel`, `star`, `address`, `phone`, `zipCode`, `checkinFrom`, `checkoutTo`, `latitude`, `longitude`, `desciption`, `country`, `city`, `passenger`, `traviaId`, `createdAt`, `checkIn`, `checkOut`, `nationality`, `currency`, `meal`, `price`, `status`, `nonrefundable`, `cancelRules`, `confirmationDetails`, `orderId`) VALUES
(6, 23, 'Taksim Green House Hostel', '0', 'Cumhuriyet caddesi paparoncalli sok No 15 Elmadag/Taksim', '+37410510000', '0015', '15:00', '13:00', '40.173266201117', '44.5061212777', 'We have been in the creative process while opening the Hotel. Since we live in a very materialistic world, it is difficult to remain creative. But we tried to be more result, oriented, play and imagine in our work.', 'Turkey', 'Sisli', '1', 'Ln7mNXTkxa', '2016-10-27 12:21:55.905221+00:00', '2016-11-17', '2016-11-18', 'Iran', 'IRR', 'Room Only', '327600', 'succeeded', '0', '[{"ratio":"1.00","remainDays":8}]', '[{"confirmNumber":"274531179|133495628920","name":["masoud gharagozlu"],"rooms":[{"description":"6-Bed Female Dormitory","type":"1"}]}]', '3359'),
(7, 42, 'World House Apartments', '0', 'Galipdede 85 Sahkulu Mahallesi Beyoglu', '+902122935520', '34420', '14:00', '11:00', '41.026465073232', '28.974518571164', ' ', 'Turkey', 'Beyoglu', '1', 'vbPEyrVTdr', '2016-11-05 15:07:53.171929+00:00', '2016-11-21', '2016-11-22', 'Iran', 'IRR', 'Room Only', '393400', 'succeeded', '0', '[{"ratio":"1.00","remainDays":4}]', '[{"confirmNumber":"274966814|133684228848","name":["behnam haddadi"],"rooms":[{"description":"Standard 14-bed Mixed Dorm, Shared Bathroom","type":"1"}]}]', '3363'),
(8, 43, 'Taksim Green House Hostel', '0', 'Cumhuriyet caddesi paparoncalli sok No 15 Elmadag/Taksim', '+905324869064', '34437', '12:00', '11:30', '41.042702997683', '28.985420465469', '<p><b>Property Location</b> <br />A stay at Taksim Green House Hostel places you in the heart of Istanbul, convenient to Taksim Gezi Park and Topkapi Palace. This hostel is close to Suleymaniye Mosque and Grand Bazaar.</p><p><b>Rooms</b> <br />Make yourself at home in one of the 9 guestrooms. Prepare your meals in the shared/communal kitchen. Complimentary wireless Internet access is available to keep you connected. Bathrooms have showers and hair dryers.</p><p><b>Rec, Spa, Premium Amenities</b> <br />Make use of convenient amenities such as complimentary wireless Internet access, gift shops/newsstands, and tour/ticket assistance. Getting to nearby attractions is a breeze with the area shuttle (surcharge).</p><p><b>Dining</b> <br />Enjoy a meal at a restaurant or in a coffee shop/café. Or stay in and take advantage of the hostel''s room service (during limited hours). Quench your thirst with your favorite drink at a bar/lounge.</p><p><b>Business, Other Amenities</b> <br />Featured amenities include a computer station, dry cleaning/laundry services, and a 24-hour front desk. A roundtrip airport shuttle is provided for a surcharge (available on request), and free valet parking is available onsite.</p>', 'Turkey', 'Sisli', '1', 'y0fK32JfHz', '2016-11-05 15:33:19.366360+00:00', '2016-11-21', '2016-11-22', 'Iran', 'IRR', 'Room Only', '338800', 'succeeded', '0', '[{"ratio":"1.00","remainDays":8}]', '[{"confirmNumber":"274967648|133684646368","name":["behnam haddadi"],"rooms":[{"description":" 6-Bed Female Dormitory","type":"1"}]}]', '3364');

-- --------------------------------------------------------

--
-- Table structure for table `ym_city_names`
--

CREATE TABLE IF NOT EXISTS `ym_city_names` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `city_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام شهر (به فارسی)',
  `country_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام کشور (به فارسی)',
  `city_key` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'شهر مورد نظر',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=121 ;

--
-- Dumping data for table `ym_city_names`
--

INSERT INTO `ym_city_names` (`id`, `city_name`, `country_name`, `city_key`) VALUES
(7, 'استانبول', 'تركيه', '19064'),
(8, 'آنتاليا', 'تركيه', '1913b'),
(9, 'سان میگل د آلنده', 'مكزيك', '14e63'),
(10, 'بريستول', 'بريتانياي كبير', '116d2'),
(11, 'دوبلين', 'ايرلند', '154f0'),
(12, 'دوحه', 'قطر', '18ecf'),
(13, 'دبي', 'امارت متحده عربي', '18edc'),
(14, 'ميستي', 'يونان', '18bd8'),
(15, 'سنت كريستيانا', 'اسپانيا', '1a7a1'),
(16, 'فرانكفورت', 'آلمان', '148dd'),
(17, 'فرانكفورت، سيتي سنتر', 'آلمان', '20904'),
(18, 'پونتادلگادا', 'پرتغال', '126ce'),
(19, 'پورتو مونيز', 'پرتغال', '126bc'),
(20, 'واشنگتن', 'آمريكا', '1dce2'),
(21, 'باكو', 'آذربايجان', '10a57'),
(22, 'آنكارا', 'تركيه', '1913d'),
(23, 'نخجوان', 'آذربايجان', '10a4d'),
(24, 'ايروان', 'ارمنستان', '12489'),
(25, 'مسكو', 'روسيه', '10588'),
(26, 'ازمير', 'تركيه', '19063'),
(27, 'ترابزون', 'تركيه', '18faa'),
(28, 'ارزروم', 'تركيه', '190a9'),
(29, 'آدانا', 'تركيه', '1915d'),
(30, 'نجف', 'عراق', '103be'),
(31, 'بغداد', 'عراق', '103bb'),
(32, 'كربلا', 'عراق', '103b8'),
(33, 'سنت پترزبورگ', 'روسيه', '104d9'),
(34, 'دوبلينو', 'ايتاليا', '1c8ec'),
(35, 'كوش آداسي', 'تركيه', '1901d'),
(36, 'اربيل', 'عراق', '103b9'),
(37, 'باتومي', 'گرجستان', '1fc6f'),
(38, 'كوالالانپور', 'مالزي', '20755'),
(39, 'سنگاپور', 'سنگاپور', '1d336'),
(40, 'بيروت', 'لبنان', '18e8e'),
(41, 'بانكوك', 'تايلند', '100cb'),
(42, 'بيجني', 'هندوستان', '12f83'),
(43, 'پوكت', 'تايلند', '1018c'),
(44, 'رم', 'ايتاليا', '1c11e'),
(45, 'ميلان', 'ايتاليا', '1c56f'),
(46, 'فلورانس', 'ايتاليا', '1c88f'),
(47, 'ونيز', 'ايتاليا', '1bcde'),
(48, 'تورين', 'ايتاليا', '1bdbc'),
(49, 'پالرمو', 'ايتاليا', '1c371'),
(50, 'جنوا', 'ايتاليا', '1c7da'),
(51, 'ناپل', 'ايتاليا', '1c435'),
(52, 'بارسلونا', 'اسپانيا', '1b3b6'),
(53, 'مادريد', 'اسپانيا', '1ac3a'),
(54, 'سويا', 'اسپانيا', '1a705'),
(55, 'گرانادا', 'اسپانيا', '1aed7'),
(56, 'ساراگوسا', 'اسپانيا', '1a42e'),
(57, 'شارجه', 'امارت متحده عربي', '18edf'),
(58, 'ابوظبي', 'امارت متحده عربي', '18ee7'),
(59, 'دهلي نو', 'هندوستان', '12e5c'),
(60, 'آگرا', 'هندوستان', '12fcb'),
(61, 'بمبئي', 'هندوستان', '12f7b'),
(62, 'جيپور', 'هندوستان', '12efc'),
(63, 'دوشنبه', 'تاجيكستان', '234c2'),
(64, 'آلماتي', 'قزاقستان', '12456'),
(65, 'هنگ كنگ', 'هنگ كنگ', '17a7a'),
(66, 'سئول', 'كره جنوبي', '19191'),
(67, 'توكيو', 'ژاپن', '1ba3f'),
(68, 'اوساكا', 'ژاپن', '1baa3'),
(69, 'ملبورن', 'استراليا', '1514d'),
(70, 'بلونيا', 'ايتاليا', '1cd21'),
(71, 'كاتانيا', 'ايتاليا', '1cabc'),
(72, 'كاتانيا', 'ايتاليا', '2331e'),
(73, 'كوردوويلا', 'اسپانيا', '1a53d'),
(74, 'كلكته', 'هندوستان', '12f75'),
(75, 'تفليس', 'گرجستان', '1f7d8'),
(76, 'برجومي', 'گرجستان', '12481'),
(77, 'روستاوي', 'گرجستان', '12466'),
(78, 'لنكران', 'آذربايجان', '10a52'),
(79, 'سوچي', 'روسيه', '104b2'),
(80, 'كازان', 'روسيه', '10620'),
(81, 'كيف', 'اكراين', '18161'),
(82, 'اودسا', 'اكراين', '18130'),
(83, 'پاريس', 'فرانسه', '161cf'),
(84, 'ليون', 'فرانسه', '1663b'),
(85, 'نايس', 'فرانسه', '162cb'),
(86, 'مارسي', 'فرانسه', '1658e'),
(87, 'سائوپالو', 'برزيل', '1926e'),
(88, 'برازيليا', 'برزيل', '1951a'),
(89, 'استكهلم', 'سوئد', '11dc0'),
(90, 'برلین', 'المان', '14bc7'),
(91, 'هامبورگ', 'المان', '1472a'),
(92, 'مونیخ', 'المان', '142aa'),
(93, 'سیدنی', 'استرالیا', '15048'),
(94, 'ملبورن', 'استرالیا', '1514d'),
(95, 'آدلاید', 'استرالیا', '1532e'),
(96, 'استانه', 'قزاقستان', '12455'),
(97, 'شانگهای', 'چین', '13957'),
(98, 'گوانگجو', 'چین', '13a2b'),
(99, 'تورنتو', 'کانادا', '196c9'),
(100, 'اتاوا', 'کانادا', '19807'),
(101, 'اتن', 'یونان', '18df3'),
(102, 'پاترا', 'یونان', '18b57'),
(103, 'لندن', 'انگلیس', '11260'),
(104, 'منچستر', 'انگلیس', '11222'),
(105, 'بیرمنگام', 'انگلیس', '11736'),
(106, 'لیورپول', 'انگلیس', '11299'),
(107, 'لیسبون', 'پرتغال', '1277a'),
(108, 'بوئنوس آیرس', 'ارژانتین', '18369'),
(109, 'روزاریو', 'ارژانتین', '18284'),
(110, 'نیکوزیا', 'قبرس', '10a00'),
(111, 'لارناکا', 'قبرس', '10a12'),
(112, 'قاهره', 'مصر', '1b627'),
(113, 'اسکندریه', 'مصر', '1b62d'),
(114, 'تفلیس', 'گرجستان', '1f7d8'),
(115, 'مستیا', 'گرجستان', '1246f'),
(116, 'گنجه', 'اذربایجان', '10a55'),
(117, 'امستردام', 'هلند', '12d83'),
(118, 'روتردام', 'هلند', '12a79'),
(119, 'ایندهوون', 'هلند', '12c8d'),
(120, 'اوترخت', 'هلند', '129d5');

-- --------------------------------------------------------

--
-- Table structure for table `ym_contact`
--

CREATE TABLE IF NOT EXISTS `ym_contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام و نام خانوادگی',
  `email` varchar(100) DEFAULT NULL COMMENT 'پست الکترونیکی',
  `subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'موضوع',
  `body` text CHARACTER SET utf8 COLLATE utf8_persian_ci COMMENT 'متن پیام',
  `date` varchar(20) DEFAULT NULL COMMENT 'تاریخ ارسال',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ym_contact`
--

INSERT INTO `ym_contact` (`id`, `name`, `email`, `subject`, `body`, `date`) VALUES
(1, 'قبادیان', 'info@dayoffer.ir', 'تبلیغات اینترنتی رایگان', 'با سلام خدمت مدیر محترم سایت\nگروه تبلیغاتی دی آفر پیشنهاد ویژه ای برای شما دارد: ثبت آگهی رایگان و دریافت بک لینک دائمی به تعداد آگهی ها  شما.\nبهبود سئو و افزایش بازدید با خدمات گروه دی آفر: http://dayoffer.ir\n\nاین فرصت برای مدت زمان کوتاهی فراهم شده است، پس همین امروز آگهی خود راثبت کنید.', '1474120269');

-- --------------------------------------------------------

--
-- Table structure for table `ym_counter_save`
--

CREATE TABLE IF NOT EXISTS `ym_counter_save` (
  `save_name` varchar(10) NOT NULL,
  `save_value` int(10) unsigned NOT NULL,
  PRIMARY KEY (`save_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ym_counter_save`
--

INSERT INTO `ym_counter_save` (`save_name`, `save_value`) VALUES
('counter', 3539),
('day_time', 2457710),
('max_count', 183),
('max_time', 1478939400),
('yesterday', 176);

-- --------------------------------------------------------

--
-- Table structure for table `ym_counter_users`
--

CREATE TABLE IF NOT EXISTS `ym_counter_users` (
  `user_ip` varchar(255) NOT NULL,
  `user_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ym_counter_users`
--

INSERT INTO `ym_counter_users` (`user_ip`, `user_time`) VALUES
('01e6691163867dfdc1e58cf939d3a37e', 1479357221),
('02ba548d78bbc8fc50abaa5d6569ebeb', 1479356565),
('0457a75e088323cd9ac1090ce197ae10', 1479365706),
('0526d98c369c1d2743f116e50c72f33c', 1479359041),
('0637744786525b9043174d5675dcebd6', 1479367117),
('06a5ed2a1fa88d78e288436feb9c0545', 1479354835),
('17099b5e9a3437392c6a3f3c4c2f1d9e', 1479367166),
('1dc9e41c37ae9841920e55b29c24c657', 1479371541),
('249caedbbf11a05d191fb7248b605b44', 1479340953),
('276865a5d4d52f5b59b930767847234c', 1479361635),
('28440f1cb73574b942038c9866c5eaf5', 1479370910),
('290fc3243c1b4e7d5b4c6021152ce1a7', 1479335522),
('32be03b4acc69a92c1b9b424f6db7468', 1479343695),
('3c9a635069c9784af73f81986540e3a9', 1479372412),
('3df8fd6d1af8699560c2bc2cd0362984', 1479369576),
('462d13083df5bd393a76be228366750f', 1479369466),
('4a477a040e798998efddca3cff8c3748', 1479336509),
('4d25c99c5b716e1454cc95f83c760516', 1479339220),
('4de58f3e3025793e2973bd3dbcf5be5e', 1479367291),
('5501595311e07ad92978ce388d85d94f', 1479340838),
('56abe5df4f6647d38f8692118c43d67a', 1479369289),
('5ac28e5f44fa5dbabe671ced9bff21f8', 1479367812),
('5d6643a8ab1cbbb750f4b3c485dac882', 1479347083),
('6d17447d4b8f7c2c118b062d49ff0556', 1479367445),
('71fa58bdc1e98f377461f6786cfc2380', 1479353173),
('768c7eac3862200ac7f2a3bfa67f5564', 1479366171),
('7abfb5dcdd5993dc7a001ccb06c102f3', 1479367389),
('9683ecb0fe5d7f03df691c7d31e0772c', 1479367118),
('99bc43b68ec62e5d90b178b550da7b56', 1479359037),
('a8a7b4376495fa51dbd0ee23323605b0', 1479367223),
('a9adbfcbcffbc8c598e469ba690eb1a3', 1479371212),
('ce801646cd895e2266f69f69e1aeac41', 1479351642),
('dd654211079f937f04134cd3a0f7d6ce', 1479367356),
('de1d613d4c4c5ab83c996ca93e2af3d8', 1479340839),
('deaa19bb7e037cdb31405447a80b55f9', 1479356166),
('e3d4dd7e47bf868317c29e3ca4fdb798', 1479350470),
('e563b4f73b75f51dcefdb59ca0bb32a3', 1479356168),
('e91ec5a02c3714d030c7114405fa7cc6', 1479368653),
('f521982eefe6d4072df83e1eeda2cc8c', 1479340013),
('f7b00a067467e711ee77683c6cb57368', 1479340951),
('fd29eed1ffbdb7527b61661edeece57f', 1479357312);

-- --------------------------------------------------------

--
-- Table structure for table `ym_countries`
--

CREATE TABLE IF NOT EXISTS `ym_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=240 ;

--
-- Dumping data for table `ym_countries`
--

INSERT INTO `ym_countries` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506),
(53, 'CI', 'COTE D''IVOIRE', 'Cote D''Ivoire', 'CIV', 384, 225),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE''S REPUBLIC OF', 'Korea, Democratic People''s Republic of', 'PRK', 408, 850),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996),
(116, 'LA', 'LAO PEOPLE''S DEMOCRATIC REPUBLIC', 'Lao People''s Democratic Republic', 'LAO', 418, 856),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, 234),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263);

-- --------------------------------------------------------

--
-- Table structure for table `ym_google_maps`
--

CREATE TABLE IF NOT EXISTS `ym_google_maps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `map_lat` varchar(30) NOT NULL DEFAULT '34.6327505',
  `map_lng` varchar(30) NOT NULL DEFAULT '50.8644157',
  `map_zoom` varchar(5) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ym_google_maps`
--

INSERT INTO `ym_google_maps` (`id`, `title`, `map_lat`, `map_lng`, `map_zoom`) VALUES
(1, '', '38.24489605422391', '48.284957349387696', '17');

-- --------------------------------------------------------

--
-- Table structure for table `ym_order`
--

CREATE TABLE IF NOT EXISTS `ym_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `buyer_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام',
  `buyer_family` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام خانوادگی',
  `buyer_mobile` varchar(11) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تلفن همراه',
  `buyer_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'پست الکترونیکی',
  `date` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تاریخ رزرو',
  `order_id` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'شماره سفارش',
  `travia_id` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'شناسه تراویا',
  `price` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'مبلغ',
  `payment_tracking_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'کد رهگیری پرداخت',
  `search_id` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'شناسه جستجو',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `ym_order`
--

INSERT INTO `ym_order` (`id`, `buyer_name`, `buyer_family`, `buyer_mobile`, `buyer_email`, `date`, `order_id`, `travia_id`, `price`, `payment_tracking_code`, `search_id`) VALUES
(28, 'masoud', 'gharagozlu', '09373252746', 'gharagozlu.masoud@gmail.com', '1477556663', NULL, 'kPrzdQFW-7', '400400', '87562076', 'ONQ9mr3-zd78Y0_RzvjA'),
(29, 'masoud', 'gharagozlu', '09373252746', 'gharagozlu.masoud@gmail.com', '1477563969', NULL, '45Emstg4St', '400750', NULL, 'hZe3OIpB9DpQh1wHQM_G'),
(30, 'masoud', 'gharagozlu', '09373252746', 'gharagozlu.masoud@gmail.com', '1477564971', NULL, 'ob_B0ddjAn', '343350', NULL, 'AdLK198IKKZM1V6hyYmv'),
(31, 'masoud', 'gharagozlu', '09373252746', 'gharagozlu.masoud@gmail.com', '1477570732', '3359', 'Ln7mNXTkxa', '327600', NULL, 'Wv5LWb4U-FiHMw08-SLH'),
(32, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478341506', NULL, 'D7edOcYg_D', '277550', NULL, 'FuEDuy8JbhQ068axXS0L'),
(33, 'masoud', 'gharagozlu', '09373252746', 'gharagozlu.masoud@gmail.com', '1478341826', NULL, 'QQzzoErbmJ', '2099300', NULL, '7S4ksjip01FyJ2xa16bw'),
(34, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478342238', NULL, 'mR01gMkyor', '338800', NULL, 'DA3FIyVwm5ix6xNSP6kC'),
(35, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478355595', NULL, 'pKEX6-jaZ9', '350350', NULL, 'zwEjAXkLvZXOcrGslJyd'),
(36, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478355794', NULL, 'BQonCNzEb-', '350350', NULL, 'MmDZYyQBsZiFfpva_wnY'),
(37, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478355989', NULL, 's0LyqjlZqK', '350350', NULL, 'pYag_9VIhKVzlJ28bxzy'),
(38, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478356208', NULL, 'fXk5MIomH2', '504350', NULL, '6pNxEaRJfHiaEloo6g_r'),
(39, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478356306', NULL, 'rQ37VT60_d', '427000', NULL, 'faHha3mZC0ecmVwZTRTM'),
(40, 'masoud', 'gharagozlu', '09373252746', 'gharagozlu.masoud@gmail.com', '1478356374', NULL, 'Q1l1HyJhbh', '1963150', NULL, 'd0taBrD61RQuH6SthQ_z'),
(41, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478357246', NULL, 'WIATiAK2wP', '427000', '87845602', 'm0Gngmih-x86LQdbk3fP'),
(42, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478358361', '3363', 'vbPEyrVTdr', '393400', '87846018', 'cN_c06U3hCutQ6OM4DHe'),
(43, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478359885', '3364', 'y0fK32JfHz', '338800', '87846931', 'KR8oJjH4uLRkgLYhE6n1'),
(44, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478361012', NULL, 'ttRo4ZORrU', '1144150', NULL, 'YYuT7YovjKWXPWwFU5sN'),
(45, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478361395', NULL, 'Lqai9m27j8', '2428650', NULL, '4AAHFVten7nNRvnjO-9n'),
(46, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478362636', NULL, '1fm_sd0fSJ', '1144150', NULL, 'OiJN7utNjTIc2dGEhgsJ'),
(47, 'بهنام', 'حدادی', '۰۹۱۴۱۵۲۰۶۳۳', 'behnam_haddadi@yahoo.com', '1478375935', NULL, 'SDtZJR9s6j', '1506750', NULL, '6C4NszbgrI3RKvBgBkGD'),
(48, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478420679', NULL, 'ILjV7kLffW', '1706950', NULL, '2k0PBDjrNjSHVJESRS3-'),
(49, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478422688', NULL, 'ncFyE5ng4n', '1143450', NULL, 'OgAoCEtEkErTKriurWL9'),
(50, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478434810', NULL, 'bxZF-T67zg', '277550', NULL, 'kayOfimLX5ERH3ogHixf'),
(51, 'للب', 'لبلا', 'افافاا', 'behnma@yahhoo.com', '1478435959', NULL, 'b09mBiIw0g', '338800', NULL, 'H-dVj3zqQHQ8bSDHUf2Z'),
(52, 'بب', 'ببب', '0265654', 'behnam_haddadi@yahoo.com', '1478436127', NULL, '-u5OEE3T3R', '1202950', NULL, '-KTYw1ZK6Bzls7WL4qt6'),
(53, 'masoud', 'gharagozlu', '09373252746', 'gharagozlu.masoud@gmail.com', '1478436294', NULL, 'UTy6LPFQbB', '985600', NULL, '_ftuAlGuWmOZRHFp1yly'),
(54, 'لثلث', 'لااافاف', '09141520633', 'behnam_haddadi@yahoo.com', '1478436754', NULL, 'X1sHi1swQD', '1064350', NULL, 'ab3aRSZlJa1GegmgAZXx'),
(55, 'بهنام ', 'حدادی', '09141520633', 'behnam_haddadi@yahoo.com', '1478436800', NULL, 'qJnCeP32_X', '317800', NULL, 'abXcICL_Lv4XJkDxXMZo'),
(56, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478438452', NULL, 'GqRx2shRgV', '350000', NULL, 'ztCDP4wweRtp2nLsHqbt'),
(57, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478439170', NULL, 'ikzaHbBV6h', '4823350', NULL, 'PPAn_-pbIv7cK37dY_Dc'),
(58, 'بهنام', 'حدادي', '09141520633', 'behnam_haddadi@yahoo.com', '1478439402', NULL, 'I8o7LKaHS-', '2425500', NULL, 'Q_2k5lSb-UTbSRgQkuGB'),
(59, 'hfd', 'hfhd', '5756765', 'gdfsgsg@yahoo.com', '1478439552', NULL, '8DqGCww257', '2492350', NULL, 'Fmf0dZ7fJZU0S8aH2Kgz'),
(60, 'yrt', 'لgbdf', 'ghjtgj', 'behnmaj@yahhoo.com', '1478439842', NULL, 'ieTi14MDFZ', '2387700', NULL, 'Sw4Xp_6l1Z7sXnoGwf6q'),
(61, 'masoud', 'gharagozlu', '09373252746', 'gharagozlu.masoud@gmail.com', '1478506573', NULL, 'Vylm2cPiMq', NULL, NULL, 'woQVALU08HfUGXEr__cc'),
(62, 'masoud', 'gharagozlu', '09373252746', 'gharagozlu.masoud@gmail.com', '1478509298', NULL, 'qNo2IwRKWI', '4701900', NULL, '-0Ubn4epmorTpdrVwLo1');

-- --------------------------------------------------------

--
-- Table structure for table `ym_pages`
--

CREATE TABLE IF NOT EXISTS `ym_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `summary` text COMMENT 'متن',
  `category_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ym_pages`
--

INSERT INTO `ym_pages` (`id`, `title`, `summary`, `category_id`) VALUES
(1, 'درباره ما', '<p>پروژه بوكر24 دات نت كه با صاحب امتيازي آقاي بهنام حدادي به عنوان مدير عامل دفتر خدمات مسافرتي و جهانگردي ميراث سفربا كد فعاليت 2401210139300173 صادر شده از سازمان ميراث فرهنگي ، صنايع دستي و گردشگري است . اين سايت مختص به رزرواسیون آنلاین هتل است که قابلیت رزرو آنی اتاق در بیش از 250 هزار هتل و هتل آپارتمان را با قیمتهای باور نکردنی به کاربران می دهد.<br />\r\nگروه ما متشکل از متخصصین ایرانی و بومي كه از فارغ التخصيلان رشته هاي صنعت گردشگري و هتلداري , که سالها تجربه در صنعت وب و گردشگری را برای ایجاد هتل&nbsp; به کار برده اند. برآن هسستيم بتوانيم به صورت كاملا تخصصي رو راحت فرايند رزرو هتل در سراسر جهان را به شما عرضه كنيم</p>\r\n\r\n<h2>&nbsp;خدمات ما</h2>\r\n\r\n<p>شما می توانید در هر ساعتی و از هر کجایی که باشید محل اقامت سفرتان را از بیش از&nbsp;250 هزار هتل وهتل آپارتمان در سر تا سر دنیا انتخاب کنید و کلیه مراحل رزرواسیون هتل را با پرداخت آنلاین کامل کنید.<br />\r\nواچر و مدرک رزرواسیون آنی پس از اتمام مرحله پرداخت به ایمیل شما ارسال می شود. هر جای دنیا که باشد از شمالي ترين نقطه دنيا تا جنوبي ترين نقطه دنيا از شرق تا غرب همه و همه تنها با چند كليك و برای هر سلیقه از هتل های کوچک و ارزان تا هتل های مجلل و پنج ستاره بوكر24 جوابگوی سلیقه ها خواهد بود.</p>\r\n\r\n<h2>&nbsp;اهداف</h2>\r\n\r\n<p>با توجه به افزايش ارتباطات جهاني لزوم توجه فناوري هاي نو در عرصه صنعت گردشگري بوكر24 دات نت با هدف سهولت و راحتي و سادگي در رزرواسيون را براي شما به ارمغان آورده و با هدف ايجاد بستر نوين در سنعت گردشگري در خدمت گردشگران خواهد بود</p>\r\n\r\n<h2>&nbsp; به ما اعتماد کنید</h2>\r\n\r\n<p>برای اعتماد به یک تجارت آنلاین نکات مختلفی را در نظر بگیرید. مهمتر از همه خود سایت و محتوای آن می باشد. ایجاد یک سایت جدی با کیفیت بالا کم هزینه که نیست هیچ بلکه از بسیاری از تجارت های معمولی دیگر می تواند پرکارتر و هزینه برتر باشد. با کمی گردش و کار کردن در سایت ما می توانید به جدی بودن ما برای ارائه بهترین خدمات رزرو آنلاین هتل پی ببرید. این سایت با سرمایه گذاری بالا و تلاش بسیاری توسط گروهی از بهترین های این صنعت راه اندازی شده و همواره توانسته است که اعتبار کاری خود را برای هزاران کاربر سایت اثبات کند.</p>\r\n\r\n<p>دفتر خدمات مسافرتي ميراث سفر به عنوان دارنده نماد اعتماد الكترونيكي از وزارت صنعت ، معدن و تجارت&nbsp; مجري اين سايت بوده و همواره پاسخگويي نظرات ، انتقادات و شكايات شما مي باشد .</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', 1),
(2, 'تماس با ما', '<p>آدرس : اردبيل -خيابان نايبي نبش كوچه 21 پلاك 305 - دفتر خدمات مسافرتي و جهانگردي ميراث سفر</p>\r\n\r\n<p>تلفن تماس : 04533243543</p>\r\n\r\n<p>پشتيباني رزرواسيون : 09141520633</p>\r\n', 1),
(3, 'راهنما', '<p>عملیاتی که در این سایت برای انجام رزرو در نظر گرفته شده است بسیار ساده طراحی شده است و کافیست مراحل سایت را پیگیری نموده و تا در نهایت هتل مورد نظر خود را رزرو و <a href="http://www.berimsafar.com/InstantConfirmation.aspx" id="ctl00_ContentPlaceHolder1_HyperLink4" tabindex="-1">واچر (تاییدیه رزرو) </a> را به زبان انگلیسی دریافت نمایید. مراحل رزرو هتل و دریافت واچر کاملا آنلاین بوده و نیاز به انتظار جهت تایید توسط آژانس و یا پیگیری رزرو از سوی شما کاربر گرامی ندارد.<br />\r\n<br />\r\n<strong>مراحل رزرو هتل در سایت Booker24.Net :</strong></p>\r\n\r\n<p><strong>(قبل از اقدام به رزرو پيشنهاد ميشود در سايت ثبت نام كنيد) </strong></p>\r\n\r\n<p>۱- جستجوی هتل<br />\r\n۲- انتخاب هتل<br />\r\n۳- انتخاب اتاق و وعده غذایی<br />\r\n۴- اطلاعات مسافرها<br />\r\n۵- پرداخت الکترونیک<br />\r\n۶- دریافت <a href="http://www.berimsafar.com/InstantConfirmation.aspx" id="ctl00_ContentPlaceHolder1_HyperLink1" tabindex="-1">واچر (تاییدیه رزرو) </a></p>\r\n\r\n<p>مرحله اول:&nbsp; شهر يا كشور مورد نظر خود جهت رزرو هتل وارد نمائيد</p>\r\n\r\n<p>مرحله دوم : تاريخ ورود و خروج خودتان را مشخص كنيد</p>\r\n\r\n<p>مرحله سوم : تعداد اتاق خود را بر حسب تعداد نفرات بزرگسال و كودك را وارد كنيد</p>\r\n\r\n<p>و در آخر كليد جستجو را كليك نمائيد .</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', 1),
(4, 'شرایط استفاده از خدمات', '<ol dir="rtl">\r\n	<li>وب&zwnj;سایت بوكر24دات نت به نشانی اینترنتی بوكر24دات نت بستری برای رزرو آنلاین هتل&zwnj; هاي خارجي<span dir="LTR"> </span>و سایر مکان&zwnj;های اقامتی موقتي است. با انجام رزرو در این وب&zwnj;سایت، شما با هتلی که در آن اتاق رزرو کرده&zwnj;اید ؛ قراردادی قانونی می&zwnj;بندید. در این قرارداد، ما تنها نقش واسطه را ایفا می&zwnj;کنیم؛ اطلاعات رزرو شما را برای هتل فرستاده و ایمیل تاییدیه نهایی را از طرف هتل برای شما ارسال می&zwnj;کنیم<span dir="LTR">. </span></li>\r\n	<li>بخش رزرو وب&zwnj;سایت بوكر24دات نت طوری طراحی شده تا به شما در دسترسی به اطلاعات موجود درباره&zwnj;ی هتل&zwnj;ها و همچنین قانونی کردن ثبت این قرارداد کمک کند. تسهیلات رزرو موجود بر روی وب&zwnj;سایت، تنها برای قانونی کردن قرارداد بین شما و هتل طراحی شده و مسئولیت هرگونه سوء استفاده و عواقب ناشی از استفاده&zwnj;ی نادرست از آن، بر عهده&zwnj;ی شخص خواهد بود. در صورت مشاهده&zwnj;ی تخلف، دسترسی کاربر به اطلاعات قطع خواهد شد</li>\r\n	<li>در صورت رعایت نکردن مورد فوق، مسئولیت هرگونه جریمه&zwnj;ی احتمالی، ضرر مالی و یا سوء استفاده&zwnj;های احتمالی اشخاص دیگر، بر عهده&zwnj;ی کاربر خواهد بود<span dir="LTR">.</span></li>\r\n	<li>اطلاعات مربوط به هتل&zwnj;ها که در این وب&zwnj;سایت بوكر24دات نت قرار گرفته، توسط هتل&zwnj;ها تولید می&zwnj;شود. این اطلاعات شامل قیمت&zwnj;های به&zwnj;روز شده، خالی بودن اتاق&zwnj;ها و... است و مسئولیت صحت آن، بر عهده&zwnj;ی هتل می&zwnj;باشد. با وجود ما تلاش خواهيم كرد این اطلاعات را به بهترین شکل ممکن ارائه شود، اما نمی&zwnj;تواند صحت و جامع بودن آن&zwnj;ها را تایید یا رد کند</li>\r\n	<li>قیمت&zwnj;های ارائه شده در این وب&zwnj;سایت بوكر24دات نت، مبلغی است که کاربر باید برای کل مدت اقامت و برای یک اتاق بپردازد؛ مگر در قسمت&zwnj;هایی که خلاف این مطلب ذکر می&zwnj;گردد&nbsp;</li>\r\n	<li>قیمت&zwnj;های نمایش&zwnj;داده شده روی سایت بوكر24دات نت به ارز ايران و مبلغ پرداختی توسط کاربر از طریق بانک به ریال می&zwnj;باشند</li>\r\n	<li>برای انجام رزرو، کاربر با انتخاب مقصد كه در نظر دارد، می&zwnj;تواند به بررسی هتل&zwnj;ها&nbsp; موجود بپردازد و در صورت نیاز؛ اطلاعات تکمیلی را از دفتر بخواهد به کمک مجموعه اطلاعاتی که از طريق دفتر فراهم می&zwnj;شود، کاربران می&zwnj;توانند با توجه به نیازهای سفر، هتل بهتری هم انتخاب کنند. بعد از انتخاب و اقدام برای رزرو هتل ، از کاربر تایید نهایی گرفته می&zwnj;شود&nbsp;رزرو هتل فقط در برگیرنده&zwnj;ی رزرو هتل است و شامل مواردی چون حمل و نقل، پارکینگ، اجاره&zwnj;ی خودرو و...نیست؛ مگر آنکه در قرارداد ذکر شده باشد<span dir="LTR">.</span></li>\r\n	<li>اگر در جریان پرداخت پول، ارتباط با شبکه قطع شود، وظیفه&zwnj;ی حل مشکلات احتمالی بر عهده&zwnj;ی بانک می&zwnj;باشد و هزینه&zwnj;ی کم شده از حساب، طبق قوانین بانکی به حساب مشتری برخواهد گشت. وب&zwnj;سایت بوكر24دات نت&nbsp; در این روند مسؤولیتی ندارد؛ چون این عمل مستقیما توسط بانک انجام می&zwnj;گیرد؛ اما در تسهیل آن تلاش خواهد کرد<span dir="LTR">.</span></li>\r\n	<li>بعد از انجام رزرو و صدور رسید یا واچر، وب&zwnj;سایت بوكر24دات نت&nbsp; تعهد می&zwnj;کند که هتل در آن تاریخ رزرو شده است؛ اما متضمن ارائه&zwnj;ی سرویس مناسب از طرف هتل یا به مسافر نیست<span dir="LTR">.</span></li>\r\n	<li>ارائه&zwnj;ی اطلاعات شخصی صحیح، نظیر نام مطابق با نام مندرج در پاسپورت، تعداد مسافران، سن و... بر عهده&zwnj;ی کاربر می&zwnj;باشد. مشکلات ناشی از ورود اطلاعات نادرست توسط کاربر، بر عهده&zwnj;ی وب&zwnj;سایت زورق&zwnj;دات&zwnj;کام نخواهد بود<span dir="LTR">.</span></li>\r\n	<li>وب&zwnj;سایت بوكر24دات نت تلاش می&zwnj;کند درخواست&zwnj;های ویژه&zwnj;ی مشتریان در زمان انجام رزرو را به هتل&nbsp; منتقل کرده و آن&zwnj;ها را انجام دهد؛ اما چون پاسخ نهایی این درخواست&zwnj;ها از جانب هتل&nbsp; خواهد بود، تعهدی نسبت به آن&zwnj;ها ندارد<span dir="LTR">.</span></li>\r\n	<li>استفاده از امکاناتی نظیر خوراکی و نوشیدنی، سونا، جکوزی، استخر، اینترنت و... که در قرارداد هتل ذکر نشده&zwnj;اند، هزینه&zwnj;ی اضافی در بر دارد. این هزینه&zwnj;ها به عهده&zwnj;ی وب&zwnj;سایت&nbsp; نبوده و مسافر موظف است آن&zwnj;ها را مستقیما به هتل پرداخت کند<span dir="LTR">.</span></li>\r\n	<li>با تایید هتل بابت رزرو اتاق از یک هتل، کاربر با قوانین و مقررات مربوط به فسخ رزرو هم موافقت می&zwnj;کند. این قوانین در بخش اطلاعات هتل، بخش رزرو و ای&zwnj;میل تایید رزرواسیون قابل مشاهده&zwnj;اند. دقت داشته باشید که ممکن است کاربر مجبور شود به خاطر فسخ قرارداد هزینه&zwnj;ای بپردازد. این هزینه&zwnj;ها طبق مقررات هر هتل متفاوت&zwnj;اند؛ به همین دلیل به کاربران محترم توصیه می&zwnj;کنیم که قبل از قطعی کردن هر قرارداد، مفاد آن را به دقت مطالعه فرمایند<span dir="LTR">.</span></li>\r\n	<li>اگر قرارداد توسط مسافر لغو شود، بازپرداخت آن تنها از طریق شماره&zwnj;ی حساب یا کارت بانکی که پیش از این توسط وی اعلام شده، خواهد بود. روند بازپرداخت وجه ممکن است تا یک هفته به طول انجامد<span dir="LTR">.</span></li>\r\n	<li>زمان ورود/خروج مسافر به/از هتل، در بخش اطلاعات هتل، بخش رزرواسیون و ایمیل تایید رزرواسیون ذکر شده و مسافر موظف است طبق آن زمان&zwnj;بندی عمل کند. در غیر این&zwnj;صورت، هزینه&zwnj;ی آن بر عهده&zwnj;ی مشتری بوده و از تعهدات وب&zwnj;سایت بوكر24دات نت نیست</li>\r\n</ol>\r\n', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ym_page_categories`
--

CREATE TABLE IF NOT EXISTS `ym_page_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'عنوان',
  `slug` varchar(255) DEFAULT NULL COMMENT 'آدرس',
  `multiple` tinyint(1) unsigned DEFAULT '1' COMMENT 'چند صحفه ای',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ym_page_categories`
--

INSERT INTO `ym_page_categories` (`id`, `name`, `slug`, `multiple`) VALUES
(1, 'صفحات استاتیک', 'base', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ym_passengers`
--

CREATE TABLE IF NOT EXISTS `ym_passengers` (
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
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

--
-- Dumping data for table `ym_passengers`
--

INSERT INTO `ym_passengers` (`id`, `name`, `family`, `gender`, `passport_num`, `type`, `age`, `room_num`, `order_id`) VALUES
(35, 'masoud', 'gharagozlu', 'male', '1234567890', 'adult', '-', 0, 28),
(36, 'masoud', 'gharagozlu', 'male', '1234567890', 'adult', '-', 0, 29),
(37, 'masoud', 'gharagozlu', 'male', '1234567890', 'adult', '-', 0, 30),
(38, 'masoud', 'gharagozlu', 'male', '1234567890', 'adult', '-', 0, 31),
(39, 'behnam', 'haddadi', 'male', '1456875697', 'adult', '-', 0, 32),
(40, 'masoud', 'gharagozlu', 'male', '1234567890', 'adult', '-', 0, 33),
(41, 'behnam', 'haddadi', 'male', 'q123456897', 'adult', '-', 0, 34),
(42, 'behnam', 'haddadi', 'male', 'q123456897', 'adult', '-', 0, 35),
(43, 'behnam', 'haddadi', 'male', '1456875697', 'adult', '-', 0, 36),
(44, 'behnam', 'haddadi', 'male', 'q123456897', 'adult', '-', 0, 37),
(45, 'behnam', 'haddadi', 'male', '1456875697', 'adult', '-', 0, 38),
(46, 'behnam', 'haddadi', 'male', 'q123456897', 'adult', '-', 0, 39),
(47, 'masoud', 'gharagozlu', 'male', '123456', 'adult', '-', 0, 40),
(48, 'behnam', 'haddadi', 'male', '1456875697', 'adult', '-', 0, 41),
(49, 'behnam', 'haddadi', 'male', 'q123456897', 'adult', '-', 0, 42),
(50, 'behnam', 'haddadi', 'male', '1456875697', 'adult', '-', 0, 43),
(51, 'behnam', 'haddadi', 'male', '1456875697', 'adult', '-', 0, 44),
(52, 'masoud', 'ali', 'male', '4589785645', 'adult', '-', 0, 44),
(53, 'ali', 'reza', 'male', '12345678952', 'adult', '-', 1, 44),
(54, 'akbar', 'reza', 'male', '89875563547', 'adult', '-', 1, 44),
(55, 'behnam', 'haddadi', 'male', '1456875697', 'adult', '-', 0, 45),
(56, 'masoud', 'ali', 'male', '4589785645', 'adult', '-', 0, 45),
(57, 'ali', 'reza', 'male', '12345678952', 'adult', '-', 1, 45),
(58, 'akbar', 'reza', 'male', '89875563547', 'adult', '-', 1, 45),
(59, 'behnam', 'haddadi', 'male', '1456875697', 'adult', '-', 0, 46),
(60, 'masoud', 'ali', 'male', '4589785645', 'adult', '-', 0, 46),
(61, 'ali', 'reza', 'male', '12345678952', 'adult', '-', 1, 46),
(62, 'akbar', 'reza', 'male', '89875563547', 'adult', '-', 1, 46),
(63, 'behnam', 'h', 'male', '1234567', 'adult', '-', 0, 47),
(64, 'soni', 'az', 'female', '45678843', 'adult', '-', 0, 47),
(65, 'ffd', 'hgfs', 'male', '55789544', 'adult', '-', 1, 47),
(66, 'cfdz', 'ggfxx', 'male', '5677', 'adult', '-', 1, 47),
(67, 'behnam', 'haddadi', 'male', '1456875697', 'adult', '-', 0, 48),
(68, 'masoud', 'ali', 'male', '4589785645', 'adult', '-', 0, 48),
(69, 'ali', 'reza', 'male', '12345678952', 'adult', '-', 1, 48),
(70, 'akbar', 'reza', 'male', '89875563547', 'adult', '-', 1, 48),
(71, 'juooo', 'fhtrr', 'male', '527577575', 'child', '7', 1, 48),
(72, 'behnam', 'haddadi', 'male', '1456875697', 'adult', '-', 0, 49),
(73, 'masoud', 'ali', 'male', '4589785645', 'adult', '-', 0, 49),
(74, 'ali', 'reza', 'male', '12345678952', 'adult', '-', 1, 49),
(75, 'akbar', 'reza', 'female', '89875563547', 'adult', '-', 1, 49),
(76, 'behnam', 'haddadi', 'male', '1456875697', 'adult', '-', 0, 50),
(77, 'gbfgg', 'gfgedg', 'male', '54549454', 'adult', '-', 0, 51),
(78, 'thr', 'jhtrr', 'male', '26554', 'adult', '-', 0, 52),
(79, 'ghjgrft', 'tryjhr', 'male', '52497897', 'adult', '-', 0, 52),
(80, 'masoud', 'gharagozlu', 'male', '1234567890', 'adult', '-', 0, 53),
(81, 'thr', 'jhtrr', 'male', '26554', 'adult', '-', 0, 54),
(82, 'rtrtrte', 'etetety', 'male', '1254454', 'adult', '-', 0, 55),
(83, 'behnam', 'haddadi', 'male', '1456875697', 'adult', '-', 0, 56),
(84, 'behnam', 'haddadi', 'male', '1456875697', 'adult', '-', 0, 57),
(85, 'masoud', 'ali', 'male', '4589785645', 'adult', '-', 0, 57),
(86, 'ali', 'reza', 'male', '12345678952', 'adult', '-', 1, 57),
(87, 'akbar', 'reza', 'male', '89875563547', 'adult', '-', 1, 57),
(88, 'fedfef', 'fh', 'male', '41545994', 'adult', '-', 0, 58),
(89, 'yjyjjys', 'grehhj', 'female', '2654', 'adult', '-', 0, 58),
(90, 'kuykuyouo', 'jyjtrjtrj', 'male', '487897987', 'adult', '-', 1, 58),
(91, 'gjryhr', 'gertewr', 'female', '44546', 'adult', '-', 1, 58),
(92, 'gdfsgsdt', 'htfryeryr', 'male', '8987', 'adult', '-', 0, 59),
(93, 'gdsgsd', 'gfhfh', 'male', '576767', 'adult', '-', 0, 59),
(94, 'hfdhdfhd', 'hdfhfhy', 'male', '5676786', 'adult', '-', 1, 59),
(95, 'hnfgjhfgru', 'xvxdgvsdh', 'male', '2345324532', 'adult', '-', 1, 59),
(96, 'yrty', 'yhtre', 'male', '7575', 'adult', '-', 0, 60),
(97, 'kuyjk', 'ykyk', 'female', '54485', 'adult', '-', 0, 60),
(98, 'kyuk', 'ytuk', 'male', '587474988', 'adult', '-', 1, 60),
(99, 'ikyuiki', 'kyukyt', 'male', '787', 'adult', '-', 1, 60),
(100, 'masoud', 'gharagozlu', 'male', '1234567890', 'adult', '-', 0, 61),
(101, 'masoud', 'gharagozlu', 'male', '1234567890', 'adult', '-', 0, 62);

-- --------------------------------------------------------

--
-- Table structure for table `ym_site_setting`
--

CREATE TABLE IF NOT EXISTS `ym_site_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `ym_site_setting`
--

INSERT INTO `ym_site_setting` (`id`, `name`, `title`, `value`) VALUES
(1, 'site_title', 'عنوان سایت', 'رزرو آنلاین هتل های خارجی'),
(2, 'default_title', 'عنوان پیش فرض صفحات', 'بوکر'),
(3, 'keywords', 'کلمات کلیدی سایت', 'رزرو، هتل، رزرواسیون هتل ، آنلاين ، دريافت واچر آني، هتل خارجي ، پرداخت آني ، پشتيباني 24 ساعته ، مقايسه ، جستجو ،'),
(4, 'site_description', 'شرح وبسایت', 'رزرو آنلاین هتل های خارجی '),
(5, 'commission', 'کمیسیون سایت (درصد)', '9'),
(6, 'tax', 'مالیات (درصد)', '1');

-- --------------------------------------------------------

--
-- Table structure for table `ym_transactions`
--

CREATE TABLE IF NOT EXISTS `ym_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'شناسه',
  `tracking_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'کد رهگیری',
  `amount` varchar(10) CHARACTER SET utf8 DEFAULT NULL COMMENT 'مبلغ',
  `order_id` int(10) unsigned DEFAULT NULL COMMENT 'سفارش',
  `date` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'تاریخ',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ym_transactions`
--

INSERT INTO `ym_transactions` (`id`, `tracking_code`, `amount`, `order_id`, `date`) VALUES
(1, '87559123', '337050', NULL, '1477552854'),
(2, '87562076', '400400', 28, '1477556721'),
(3, '87845602', '427000', 41, '1478357762'),
(4, '87846018', '393400', 42, '1478358450'),
(5, '87846931', '338800', 43, '1478359977');

-- --------------------------------------------------------

--
-- Table structure for table `ym_users`
--

CREATE TABLE IF NOT EXISTS `ym_users` (
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
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `ym_users`
--

INSERT INTO `ym_users` (`id`, `username`, `password`, `email`, `role_id`, `create_date`, `status`, `verification_token`, `change_password_request_count`) VALUES
(47, '', '$2a$12$tRHKnT/Wh5MXFyGUrEtFhuW/ZAY3Snk2cjLmIm8oUfNNdJwuWaj..', 'gharagozlu.masoud@gmail.com', 1, '1462784196', 'active', 'eac9fcd08ccad47f2c256245a1f07a6f', 0),
(48, '', '$2a$12$wKo1.YdHYvAxfda1AcvlheXCRgiR/geA3Gnfox/qi1MPh11e12mw2', 'yusef.mobasheri@gmail.com', 1, '1462789435', 'deleted', 'ce40fd692f75746906e7c7176c2d4232', 3),
(49, '', '$2a$12$ZP/VIEMsZcdU7/.6yjmOOu3RjWsh79yyJMz35vo/QktNHi9HOs2Py', 'simas888888@gmail.com', 1, '1463457969', 'pending', 'e98ee3cdce8ec13e60d999e80289e42c', 0),
(50, '', '$2a$12$V5zdNhxpX5zaA/x6RnTi9.voUCqrWHbFTtQu78FItUpY/pZiOrCKS', 'ddsd@fd.vc', 1, '1465484669', 'deleted', '3e8a28446d2f40324079b1f52fbe85b2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ym_user_details`
--

CREATE TABLE IF NOT EXISTS `ym_user_details` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'کاربر',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام',
  `avatar` varchar(20) DEFAULT NULL COMMENT 'تصویر پروفایل',
  `national_code` varchar(20) DEFAULT NULL COMMENT 'کد ملی',
  `phone` varchar(11) DEFAULT NULL COMMENT 'شماره تماس',
  `address` varchar(1000) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'آدرس',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ym_user_details`
--

INSERT INTO `ym_user_details` (`user_id`, `name`, `avatar`, `national_code`, `phone`, `address`) VALUES
(47, NULL, NULL, NULL, NULL, NULL),
(48, NULL, NULL, NULL, NULL, NULL),
(49, NULL, NULL, NULL, NULL, NULL),
(50, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ym_user_roles`
--

CREATE TABLE IF NOT EXISTS `ym_user_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ym_user_roles`
--

INSERT INTO `ym_user_roles` (`id`, `name`, `role`) VALUES
(1, 'کاربر معمولی', 'user');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ym_admins`
--
ALTER TABLE `ym_admins`
  ADD CONSTRAINT `ym_admins_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_admin_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_bookings`
--
ALTER TABLE `ym_bookings`
  ADD CONSTRAINT `ym_bookings_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `ym_order` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_pages`
--
ALTER TABLE `ym_pages`
  ADD CONSTRAINT `ym_pages_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ym_page_categories` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_passengers`
--
ALTER TABLE `ym_passengers`
  ADD CONSTRAINT `ym_passengers_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `ym_order` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_transactions`
--
ALTER TABLE `ym_transactions`
  ADD CONSTRAINT `ym_transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `ym_order` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `ym_users`
--
ALTER TABLE `ym_users`
  ADD CONSTRAINT `ym_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `ym_user_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ym_user_details`
--
ALTER TABLE `ym_user_details`
  ADD CONSTRAINT `ym_user_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ym_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
