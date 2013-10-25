-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 25, 2013 at 09:30 PM
-- Server version: 5.5.34
-- PHP Version: 5.3.10-1ubuntu3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `FreshersTV`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_created` int(11) NOT NULL,
  `name` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `main_logo` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `secondary_logo` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `participation_type` int(1) NOT NULL COMMENT 'Live = 0, VT = 1',
  `participation_time` int(11) DEFAULT NULL,
  `resolution` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bitrate` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stream_url` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stream_extra` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `overlay_details` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cinebeat` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vt` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `email_verification_hash` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_hash` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_hash_creation_time` int(11) DEFAULT NULL,
  `email_verified` tinyint(1) NOT NULL,
  `application_accepted` tinyint(1) NOT NULL,
  `host` tinyint(1) NOT NULL DEFAULT '0',
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `logo_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Filename of logo stored in relevant img subfolders with extension.',
  `ready` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Set to 1 when station is ready to appear on relevant parts of front end site.',
  `live_time` int(11) DEFAULT NULL COMMENT 'Unix timestamp when station going live.',
  `username` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'General username. Used for irc, comms etc',
  `pass_sha256` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Automatically updated to the pass hash as stored in the db hashed with sha256 using the first 32 characters only. used for other systems authentication like irc',
  `sip_pass` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'The plaintext password for this users comms sip password.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_verification_hash` (`email_verification_hash`),
  UNIQUE KEY `password_reset_hash` (`password_reset_hash`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `sip_pass` (`sip_pass`),
  KEY `email` (`email`(255)),
  KEY `password` (`password`),
  KEY `email_verified` (`email_verified`),
  KEY `application_accepted` (`application_accepted`),
  KEY `password_reset_hash_creation_time` (`password_reset_hash_creation_time`),
  KEY `time_created` (`time_created`),
  KEY `ready` (`ready`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
