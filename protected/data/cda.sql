-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2013 at 08:04 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cda`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_algorithm`
--

CREATE TABLE IF NOT EXISTS `tbl_algorithm` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_algorithm`
--

INSERT INTO `tbl_algorithm` (`id`, `name`, `description`) VALUES
(1, 'Markov', 'Morkov Clustering Algorithm'),
(2, 'Girvan-Newman', 'Girvan-Newman Clustering Algorithm.'),
(3, 'CNM', 'CNM Clustering Algorithm'),
(4, 'louvain', 'Louvain Algorithm'),
(5, 'oslom', 'OSLOM Algorithm');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cluster`
--

CREATE TABLE IF NOT EXISTS `tbl_cluster` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clustering` bigint(20) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `sup_cluster` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(255)),
  KEY `clustering` (`clustering`),
  KEY `deleted` (`deleted`),
  KEY `sup_cluster` (`sup_cluster`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_clustering`
--

CREATE TABLE IF NOT EXISTS `tbl_clustering` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `algorithm` bigint(20) NOT NULL,
  `score` double NOT NULL,
  `user` bigint(20) NOT NULL,
  `startTime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `algorithm` (`algorithm`),
  KEY `user` (`user`),
  KEY `startTime` (`startTime`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_friend`
--

CREATE TABLE IF NOT EXISTS `tbl_friend` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `cluster` bigint(20) DEFAULT NULL,
  `cor_cluster` bigint(20) DEFAULT NULL,
  `fbid` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`,`cluster`,`cor_cluster`),
  KEY `fbid` (`fbid`),
  KEY `tbl_friend_ibfk_1` (`cluster`),
  KEY `tbl_friend_ibfk_2` (`cor_cluster`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=957 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_link`
--

CREATE TABLE IF NOT EXISTS `tbl_link` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `friend_1` bigint(20) NOT NULL,
  `friend_2` bigint(20) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `user` (`user`,`friend_1`,`friend_2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fbid` bigint(20) NOT NULL,
  `createdAt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fbid` (`fbid`),
  KEY `createdAt` (`createdAt`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_cluster`
--
ALTER TABLE `tbl_cluster`
  ADD CONSTRAINT `tbl_cluster_ibfk_1` FOREIGN KEY (`clustering`) REFERENCES `tbl_clustering` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `tbl_clustering`
--
ALTER TABLE `tbl_clustering`
  ADD CONSTRAINT `tbl_clustering_ibfk_1` FOREIGN KEY (`algorithm`) REFERENCES `tbl_algorithm` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_clustering_ibfk_2` FOREIGN KEY (`user`) REFERENCES `tbl_user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `tbl_friend`
--
ALTER TABLE `tbl_friend`
  ADD CONSTRAINT `tbl_friend_ibfk_1` FOREIGN KEY (`cluster`) REFERENCES `tbl_cluster` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_friend_ibfk_2` FOREIGN KEY (`cor_cluster`) REFERENCES `tbl_cluster` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_friend_ibfk_3` FOREIGN KEY (`user`) REFERENCES `tbl_user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `tbl_link`
--
ALTER TABLE `tbl_link`
  ADD CONSTRAINT `tbl_link_ibfk_1` FOREIGN KEY (`user`) REFERENCES `tbl_user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
