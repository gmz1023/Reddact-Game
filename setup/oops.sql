-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Aug 20, 2017 at 11:36 PM
-- Server version: 5.6.35-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `reddact`
--

-- --------------------------------------------------------

--
-- Table structure for table `encounters`
--

DROP TABLE IF EXISTS `encounters`;
CREATE TABLE IF NOT EXISTS `encounters` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('text','audio','video') NOT NULL,
  `mapY` int(11) DEFAULT '0',
  `mapX` int(11) DEFAULT '0',
  `text` text NOT NULL,
  `acceptText` text NOT NULL,
  `acceptButton` varchar(128) NOT NULL,
  `denyText` text NOT NULL,
  `denyButton` varchar(128) NOT NULL,
  PRIMARY KEY (`eid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_catagories`
--

DROP TABLE IF EXISTS `forum_catagories`;
CREATE TABLE IF NOT EXISTS `forum_catagories` (
  `catID` int(11) NOT NULL AUTO_INCREMENT,
  `catName` varchar(128) NOT NULL,
  PRIMARY KEY (`catID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_name`
--

DROP TABLE IF EXISTS `forum_name`;
CREATE TABLE IF NOT EXISTS `forum_name` (
  `forumID` int(11) NOT NULL AUTO_INCREMENT,
  `catID` int(11) NOT NULL,
  `forumName` varchar(128) NOT NULL,
  PRIMARY KEY (`forumID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_replies`
--

DROP TABLE IF EXISTS `forum_replies`;
CREATE TABLE IF NOT EXISTS `forum_replies` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `bodyText` text NOT NULL,
  `postedOn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_topics`
--

DROP TABLE IF EXISTS `forum_topics`;
CREATE TABLE IF NOT EXISTS `forum_topics` (
  `topicID` int(11) NOT NULL AUTO_INCREMENT,
  `forumID` int(11) NOT NULL,
  `topicTitle` varchar(128) NOT NULL,
  `topicOwner` int(11) NOT NULL,
  `postType` int(11) NOT NULL DEFAULT '1',
  `posted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`topicID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `game_variables`
--

DROP TABLE IF EXISTS `game_variables`;
CREATE TABLE IF NOT EXISTS `game_variables` (
  `vid` int(11) NOT NULL AUTO_INCREMENT,
  `variable_info` text NOT NULL,
  `variable_name` varchar(128) NOT NULL,
  UNIQUE KEY `vid` (`vid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `map`
--

DROP TABLE IF EXISTS `map`;
CREATE TABLE IF NOT EXISTS `map` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `homeworld` tinyint(1) NOT NULL,
  `ssid` int(11) NOT NULL,
  `mapX` int(11) NOT NULL,
  `mapY` int(11) NOT NULL,
  `starType` int(11) NOT NULL,
  `habitablePlanets` int(11) NOT NULL,
  `currentOwner` int(11) NOT NULL,
  `nextOwner` int(11) NOT NULL,
  `previousOwner` int(11) NOT NULL,
  `population` int(11) NOT NULL DEFAULT '0',
  `resource` int(11) DEFAULT NULL,
  `lastMine` datetime DEFAULT '0000-00-00 00:00:00',
  `underAttack` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CapturedOn` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wifi` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`sid`),
  UNIQUE KEY `starco` (`mapX`,`mapY`,`ssid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6406 ;

--
-- Triggers `map`
--
DROP TRIGGER IF EXISTS `star_systems`;
DELIMITER //
CREATE TRIGGER `star_systems` AFTER INSERT ON `map`
 FOR EACH ROW insert into `system_upgrades`(sid) VALUES(new.ssid)
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `text` text NOT NULL,
  `unread` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=607 ;

-- --------------------------------------------------------

--
-- Table structure for table `privatemessages`
--

DROP TABLE IF EXISTS `privatemessages`;
CREATE TABLE IF NOT EXISTS `privatemessages` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `toUser` int(11) NOT NULL,
  `fromUser` int(11) NOT NULL,
  `body` text NOT NULL,
  `subject` varchar(128) NOT NULL,
  `unread` tinyint(1) NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
CREATE TABLE IF NOT EXISTS `resources` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `resourceName` varchar(128) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=221 ;

-- --------------------------------------------------------

--
-- Table structure for table `ships`
--

DROP TABLE IF EXISTS `ships`;
CREATE TABLE IF NOT EXISTS `ships` (
  `shipID` int(11) NOT NULL AUTO_INCREMENT,
  `ship_name` int(11) NOT NULL,
  PRIMARY KEY (`shipID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `system_upgrades`
--

DROP TABLE IF EXISTS `system_upgrades`;
CREATE TABLE IF NOT EXISTS `system_upgrades` (
  `suid` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse` int(11) NOT NULL DEFAULT '1',
  `hospital` int(11) NOT NULL DEFAULT '1',
  `refineries` int(11) NOT NULL DEFAULT '1',
  `defense` int(11) NOT NULL DEFAULT '1',
  `banks` int(11) NOT NULL DEFAULT '1',
  `sid` int(11) NOT NULL,
  `current_owner` int(11) NOT NULL,
  PRIMARY KEY (`suid`),
  KEY `map_sid` (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6406 ;

-- --------------------------------------------------------

--
-- Table structure for table `userfeats`
--

DROP TABLE IF EXISTS `userfeats`;
CREATE TABLE IF NOT EXISTS `userfeats` (
  `uid` int(11) NOT NULL,
  `feat` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  UNIQUE KEY `unlocked` (`uid`,`feat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(32) NOT NULL AUTO_INCREMENT,
  `permissions` varchar(8) NOT NULL DEFAULT '0,0,0,0',
  `email` varchar(128) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `homeX` int(11) NOT NULL DEFAULT '0',
  `homeY` int(11) NOT NULL DEFAULT '0',
  `first_time` tinyint(1) NOT NULL,
  `lastLogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `avatar` varchar(128) NOT NULL,
  `joinDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `firstTime` tinyint(1) NOT NULL DEFAULT '1',
  `accountType` int(11) NOT NULL DEFAULT '1',
  `homeworld` int(11) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `userscores`
--

DROP TABLE IF EXISTS `userscores`;
CREATE TABLE IF NOT EXISTS `userscores` (
  `uid` int(11) NOT NULL,
  `lastLogin` datetime NOT NULL,
  `starsCapturedCurrent` int(11) NOT NULL,
  `starsLost` int(11) NOT NULL,
  `starsCapturedMax` int(11) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_coffers`
--

DROP TABLE IF EXISTS `user_coffers`;
CREATE TABLE IF NOT EXISTS `user_coffers` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `balance` bigint(200) NOT NULL,
  `energyCell` varchar(128) NOT NULL,
  `fuelCell` varchar(128) NOT NULL,
  `exp` float(10,2) NOT NULL DEFAULT '1.00',
  `uid` int(11) NOT NULL,
  `userLevel` int(11) NOT NULL,
  `nextLevel` float(10,2) NOT NULL DEFAULT '250.00',
  `alliance` int(11) NOT NULL DEFAULT '0',
  `currentShip` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cid`),
  KEY `bankaccount` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_inventory`
--

DROP TABLE IF EXISTS `user_inventory`;
CREATE TABLE IF NOT EXISTS `user_inventory` (
  `invId` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_count` int(11) NOT NULL DEFAULT '1',
  `item_type` enum('resource','item') NOT NULL,
  PRIMARY KEY (`invId`),
  UNIQUE KEY `userHasItem` (`uid`,`item_id`,`item_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=326 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_relays`
--

DROP TABLE IF EXISTS `user_relays`;
CREATE TABLE IF NOT EXISTS `user_relays` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `mapX` int(11) NOT NULL,
  `mapY` int(11) NOT NULL,
  `mapZ` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_upgrades`
--

DROP TABLE IF EXISTS `user_upgrades`;
CREATE TABLE IF NOT EXISTS `user_upgrades` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `technology` int(11) NOT NULL DEFAULT '1',
  `economy` int(11) NOT NULL DEFAULT '1',
  `medicine` int(11) NOT NULL DEFAULT '1',
  `offense` int(11) NOT NULL DEFAULT '1',
  `defense` int(11) NOT NULL DEFAULT '1',
  `biology` int(11) NOT NULL DEFAULT '1',
  `seven` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
