-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2013 at 06:20 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cda`
--
CREATE DATABASE IF NOT EXISTS `cda` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cda`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activity`
--

CREATE TABLE IF NOT EXISTS `tbl_activity` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_book`
--

CREATE TABLE IF NOT EXISTS `tbl_book` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cgroup`
--

CREATE TABLE IF NOT EXISTS `tbl_cgroup` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) DEFAULT NULL,
  `clus_mcl` bigint(20) DEFAULT NULL,
  `clus_louvain` bigint(20) DEFAULT NULL,
  `clus_oslom` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`,`clus_mcl`,`clus_louvain`,`clus_oslom`),
  KEY `clus_mcl` (`clus_mcl`),
  KEY `clus_louvain` (`clus_louvain`),
  KEY `clus_oslom` (`clus_oslom`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

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
  `level` int(11) DEFAULT NULL,
  `friendsCount` int(11) DEFAULT NULL,
  `corFriendsCount` int(11) DEFAULT NULL,
  `innerEdges` int(11) DEFAULT NULL,
  `outerEdges` int(11) DEFAULT NULL,
  `internalDensity` double DEFAULT NULL,
  `averageDegree` double DEFAULT NULL,
  `TPR` double DEFAULT NULL,
  `expansion` double DEFAULT NULL,
  `cutRation` double DEFAULT NULL,
  `conductance` double DEFAULT NULL,
  `innerEdgesB` int(11) DEFAULT NULL,
  `outerEdgesB` int(11) DEFAULT NULL,
  `internalDensityB` double DEFAULT NULL,
  `averageDegreeB` double DEFAULT NULL,
  `TPRB` double DEFAULT NULL,
  `expansionB` double DEFAULT NULL,
  `cutRationB` double DEFAULT NULL,
  `conductanceB` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(255)),
  KEY `clustering` (`clustering`),
  KEY `deleted` (`deleted`),
  KEY `sup_cluster` (`sup_cluster`),
  KEY `level` (`level`),
  KEY `innerEdges` (`innerEdges`,`outerEdges`),
  KEY `internalDensity` (`internalDensity`,`averageDegree`,`TPR`,`expansion`,`cutRation`),
  KEY `friendsCount` (`friendsCount`,`corFriendsCount`),
  KEY `innerEdgesB` (`innerEdgesB`,`outerEdgesB`,`internalDensityB`,`averageDegreeB`,`TPRB`,`expansionB`,`cutRationB`),
  KEY `conductance` (`conductance`),
  KEY `conductanceB` (`conductanceB`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13597 ;

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
  `precision` double DEFAULT NULL,
  `recall` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `algorithm` (`algorithm`),
  KEY `user` (`user`),
  KEY `startTime` (`startTime`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=664 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_education`
--

CREATE TABLE IF NOT EXISTS `tbl_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` varchar(20) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `school` bigint(20) DEFAULT NULL,
  `fb_info` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `school` (`school`),
  KEY `user` (`fb_info`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE IF NOT EXISTS `tbl_events` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `start_time` varchar(30) NOT NULL,
  `end_time` varchar(30) NOT NULL,
  `location` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_family`
--

CREATE TABLE IF NOT EXISTS `tbl_family` (
  `id` bigint(20) NOT NULL,
  `name` varchar(70) DEFAULT NULL,
  `relationship` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fb_info`
--

CREATE TABLE IF NOT EXISTS `tbl_fb_info` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fbid` bigint(20) NOT NULL,
  `createdAt` timestamp NULL DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middle_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `age_range` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hometown_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hometown_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `political` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `religion` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `relationship_status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fbid` (`fbid`),
  KEY `createdAt` (`createdAt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feed`
--

CREATE TABLE IF NOT EXISTS `tbl_feed` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `story` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_friend`
--

CREATE TABLE IF NOT EXISTS `tbl_friend` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `fbid` bigint(20) NOT NULL,
  `fb_info` bigint(20) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `fbid` (`fbid`),
  KEY `fb_info` (`fb_info`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=316373 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_friend_cluster`
--

CREATE TABLE IF NOT EXISTS `tbl_friend_cluster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `friend` bigint(20) DEFAULT NULL,
  `cluster` bigint(20) DEFAULT NULL,
  `cor_cluster` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `friend` (`friend`,`cluster`),
  KEY `cor_cluster` (`cor_cluster`),
  KEY `cluster` (`cluster`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=306335 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_language`
--

CREATE TABLE IF NOT EXISTS `tbl_language` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  KEY `user` (`user`,`friend_1`,`friend_2`),
  KEY `friend_1` (`friend_1`),
  KEY `friend_2` (`friend_2`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=702605 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_school`
--

CREATE TABLE IF NOT EXISTS `tbl_school` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fbid` bigint(20) NOT NULL,
  `createdAt` datetime DEFAULT NULL,
  `fb_info` bigint(20) DEFAULT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mcl_louvain` double DEFAULT NULL,
  `mcl_oslom` double DEFAULT NULL,
  `louvain_oslom` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fbid` (`fbid`),
  KEY `createdAt` (`createdAt`),
  KEY `fb_info` (`fb_info`),
  KEY `fb_info_2` (`fb_info`),
  KEY `fb_info_3` (`fb_info`),
  KEY `code` (`code`),
  KEY `mcl_louvain` (`mcl_louvain`,`mcl_oslom`,`louvain_oslom`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=325 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_activity`
--

CREATE TABLE IF NOT EXISTS `tbl_user_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fb_info` bigint(20) NOT NULL,
  `activity` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`fb_info`,`activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_language`
--

CREATE TABLE IF NOT EXISTS `tbl_user_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fb_info` bigint(20) NOT NULL,
  `language` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`fb_info`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_work`
--

CREATE TABLE IF NOT EXISTS `tbl_work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employer` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `start_date` varchar(20) DEFAULT NULL,
  `end_date` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_cgroup`
--
ALTER TABLE `tbl_cgroup`
  ADD CONSTRAINT `tbl_cgroup_ibfk_1` FOREIGN KEY (`clus_mcl`) REFERENCES `tbl_cluster` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_cgroup_ibfk_2` FOREIGN KEY (`clus_louvain`) REFERENCES `tbl_cluster` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_cgroup_ibfk_3` FOREIGN KEY (`clus_oslom`) REFERENCES `tbl_cluster` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_cgroup_ibfk_4` FOREIGN KEY (`user`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_cluster`
--
ALTER TABLE `tbl_cluster`
  ADD CONSTRAINT `tbl_cluster_ibfk_2` FOREIGN KEY (`clustering`) REFERENCES `tbl_clustering` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_clustering`
--
ALTER TABLE `tbl_clustering`
  ADD CONSTRAINT `tbl_clustering_ibfk_3` FOREIGN KEY (`algorithm`) REFERENCES `tbl_algorithm` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_clustering_ibfk_4` FOREIGN KEY (`user`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_friend`
--
ALTER TABLE `tbl_friend`
  ADD CONSTRAINT `tbl_friend_ibfk_4` FOREIGN KEY (`user`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_friend_cluster`
--
ALTER TABLE `tbl_friend_cluster`
  ADD CONSTRAINT `tbl_friend_cluster_ibfk_1` FOREIGN KEY (`friend`) REFERENCES `tbl_friend` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_friend_cluster_ibfk_2` FOREIGN KEY (`cluster`) REFERENCES `tbl_cluster` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_friend_cluster_ibfk_3` FOREIGN KEY (`cor_cluster`) REFERENCES `tbl_cluster` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_link`
--
ALTER TABLE `tbl_link`
  ADD CONSTRAINT `tbl_link_ibfk_4` FOREIGN KEY (`user`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
--
-- Dumping data for table `tbl_algorithm`
--

INSERT INTO `tbl_algorithm` (`id`, `name`, `description`) VALUES
(1, 'Markov', 'Morkov Clustering Algorithm'),
(2, 'Girvan-Newman', 'Girvan-Newman Clustering Algorithm.'),
(3, 'CNM', 'CNM Clustering Algorithm'),
(4, 'louvain', 'Louvain Algorithm'),
(5, 'oslom', 'OSLOM Algorithm');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
