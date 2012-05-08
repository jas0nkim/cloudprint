-- phpMyAdmin SQL Dump
-- version 3.4.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2011 at 08:49 PM
-- Server version: 5.1.58
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL DEFAULT '0',
  `username` varchar(25) NOT NULL,
  `password` varchar(64) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(8) NULL DEFAULT NULL,
  `age` tinyint(4) NULL DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` timestamp DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `username`, `password`, `first_name`, `last_name`, `email`, `status`) VALUES
(26, 0, 'normaldude', '7a0dd4cfae78b0386988d01fe6cb5db524adec83', 'John', 'Doe', 'normaldude@normaldude.com', 1),
(27, 0, 'admindude', '581000ca062386cc95a00ae66e3203ec409631e5', 'Tom', 'Sawyer', 'admindude@admindude.com', 1);

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
CREATE TABLE IF NOT EXISTS `assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL DEFAULT '0',
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `parent_asset_id` int(11) NULL DEFAULT NULL,
  `child_asset_id` int(11) NULL DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `extension` varchar(8) NOT NULL,
  `type` varchar(16) NOT NULL,
  `size` int(16) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` timestamp DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Table structure for table `print_jobs`
--

DROP TABLE IF EXISTS `print_jobs`;
CREATE TABLE IF NOT EXISTS `print_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL DEFAULT '0',
  `gcp_job_id` int(11) NOT NULL DEFAULT '0',
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `printer_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` timestamp DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Table structure for table `assets_print_jobs`
--

DROP TABLE IF EXISTS `assets_print_jobs`;
CREATE TABLE IF NOT EXISTS `assets_print_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL DEFAULT '0',
  `asset_id` int(11) NOT NULL DEFAULT '0',
  `print_job_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Table structure for table `printers`
--

DROP TABLE IF EXISTS `printers`;
CREATE TABLE IF NOT EXISTS `printers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL DEFAULT '0',
  `gcp_printer_id` int(11) NOT NULL DEFAULT '0',
  `location_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` timestamp DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL,
  `description` text NULL DEFAULT NULL,
  `address` varchar(64) NOT NULL,
  `city` varchar(16) NOT NULL,
  `province` varchar(16) NOT NULL,
  `country` varchar(16) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` timestamp DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Table structure for table `gcp_printers`
--

DROP TABLE IF EXISTS `gcp_printers`;
CREATE TABLE IF NOT EXISTS `gcp_printers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `printerid` varchar(255) NOT NULL DEFAULT '0',
  `printer_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) NULL DEFAULT NULL,
  `display_name` varchar(64) NULL DEFAULT NULL,
  `type` varchar(64) NULL DEFAULT NULL,
  `description` text NULL DEFAULT NULL,
  `proxy` varchar(255) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `caps_hash` varchar(32) NULL DEFAULT NULL,
  `create_time` int(16) NULL DEFAULT NULL,
  `update_time` int(16) NULL DEFAULT NULL,
  `access_time` int(16) NULL DEFAULT NULL,
  `number_of_documents` int(64) NULL DEFAULT NULL,
  `number_of_pages` int(64) NULL DEFAULT NULL,
  `caps_format` varchar(16) NULL DEFAULT NULL,
  `tags` text NULL DEFAULT NULL,
  `capabilities` text NULL DEFAULT NULL,
  `access` text NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Table structure for table `gcp_jobs`
--

DROP TABLE IF EXISTS `gcp_jobs`;
CREATE TABLE IF NOT EXISTS `gcp_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobid` varchar(255) NOT NULL DEFAULT '0',
  `printerid` varchar(255) NOT NULL DEFAULT '0',
  `job_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(64) NULL DEFAULT NULL,
  `content_type` varchar(64) NULL DEFAULT NULL,
  `file_url` varchar(255) NULL DEFAULT NULL,
  `ticket_url` varchar(255) NULL DEFAULT NULL,
  `create_time` int(16) NOT NULL DEFAULT '0',
  `update_time` int(16) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `error_code` varchar(16) NULL DEFAULT NULL,
  `message` text NULL DEFAULT NULL,
  `tags` text NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
