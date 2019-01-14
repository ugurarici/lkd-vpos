-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 07, 2017 at 01:41 AM
-- Server version: 5.5.38
-- PHP Version: 5.5.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lkd_vpos`
--

-- --------------------------------------------------------

--
-- Table structure for table `payment_attempts`
--

CREATE TABLE `payment_attempts` (
`id` int(11) unsigned NOT NULL,
  `transaction_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Sanal pos''a da gönderilen ödeme ID''si',
  `user_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ödeme yapan kişinin adı',
  `user_surname` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ödeme yapan kişinin soyadı',
  `user_phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ödeme yapan kişinin telefon numarası',
  `user_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ödeme yapan kişinin e-posta adresi',
  `user_address` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ödeme yapan kişinin açık adresi',
  `user_ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ödeme yapan kişinin IP adresi',
  `payment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Ödemenin yapıldığı tarih',
  `payment_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ödeme tipi (bagis, aidat)',
  `payment_description` text COLLATE utf8_unicode_ci COMMENT 'Ödeme yapan kişinin ödeme için girdiği açıklama',
  `amount` float NOT NULL COMMENT 'Ödeme tutarı',
  `user_card_info` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ödeme yapılan kart numarasının kısmi sansürlenmiş hali',
  `is_success` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Ödeme başarılı olmuş mu?',
  `payment_result_description` text COLLATE utf8_unicode_ci COMMENT 'Ödeme denemesinin sanal postan dönen sonucu',
  `is_mail_to_user_sent` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'İşlem sonucu ödemeyi deneyen kullancıya e-posta ile gönderildi mi?',
  `is_mail_to_admin_sent` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'İşlem sonucu dernek yöneticilerine e-posta ile gönderildi mi?'
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tüm ödeme denemeleri buraya kaydedilir, başarılı olanlar güncellenir';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payment_attempts`
--
ALTER TABLE `payment_attempts`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `payment_id` (`transaction_id`), ADD KEY `payment_type` (`payment_type`,`is_success`), ADD KEY `is_mail_to_user_sent` (`is_mail_to_user_sent`,`is_mail_to_admin_sent`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payment_attempts`
--
ALTER TABLE `payment_attempts`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
