-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 16, 2010 at 10:25 AM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `intranet`
--
CREATE DATABASE `intranet`;
USE `intranet`;
-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_name` varchar(100) NOT NULL,
  `album_description` text NOT NULL,
  `album_thumb` varchar(100) NOT NULL,
  `blArchive` tinyint(1) NOT NULL,
  `dtCreated` datetime NOT NULL,
  `dtUpdated` datetime NOT NULL,
  PRIMARY KEY (`album_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `album`
--


-- --------------------------------------------------------

--
-- Table structure for table `authteam`
--

CREATE TABLE IF NOT EXISTS `authteam` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `teamname` varchar(50) NOT NULL DEFAULT '',
  `teamlead` varchar(25) NOT NULL DEFAULT '',
  `status` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `teamname` (`teamname`,`teamlead`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `authteam`
--

INSERT INTO `authteam` (`id`, `teamname`, `teamlead`, `status`) VALUES
(1, 'Admin', '', 'active'),
(2, 'User Admin', '', 'active'),
(3, 'Contents Admin', '', 'active'),
(30, 'Category Admin', 'Administrator', 'active'),
(35, 'Super Admin', 'Administrator', 'active'),
(39, 'User Tracking Admin', '', 'active'),
(45, 'Members Admin', '', 'active'),
(59, 'Members Groups Admin', '', 'active'),
(60, 'Can Configure', '', 'active'),
(61, 'Can Manage Users', '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `authuser`
--

CREATE TABLE IF NOT EXISTS `authuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(25) NOT NULL DEFAULT '',
  `passwd` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `surname` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `mobile` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `team` varchar(25) NOT NULL DEFAULT '',
  `level` int(4) NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL DEFAULT '',
  `lastlogin` datetime DEFAULT NULL,
  `logincount` int(11) DEFAULT NULL,
  `prefix` varchar(10) NOT NULL,
  `department` varchar(200) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city` varchar(200) NOT NULL,
  `zip` varchar(100) NOT NULL,
  `country` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `authuser`
--

INSERT INTO `authuser` (`id`, `uname`, `passwd`, `name`, `surname`, `email`, `mobile`, `location`, `team`, `level`, `status`, `lastlogin`, `logincount`, `prefix`, `department`, `address`, `city`, `zip`, `country`) VALUES
(28, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'Prime Minister''s Office', '', '', '', '', 1, 'active', '2010-08-14 12:44:13', 118, '', '', '', 'Dar es salaam', '', 'Tanzania'),
(29, 'mukulu', 'ce61649168c4550c2f7acab92354dc6e', 'John', 'Mukulu', 'john.f.mukulu@gmail.com', '+255717154006', 'PUGU SEC. SCHOOL', '', 1, 'active', '2010-08-07 12:38:00', 11, '', 'IT Department', 'PUGU SEC SCHOOL', 'DAR ES SALAAM', '9090 DAR ES SALAAM', 'TANZANIA'),
(30, 'auson', '6b00ee1e8ebaf8e7b42957dcd8992d86', 'Auson', 'Kisanga', 'auson@kisanga.com', '', '', '', 1, 'active', '2010-08-07 11:18:04', 1, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `authuserteam_mapping`
--

CREATE TABLE IF NOT EXISTS `authuserteam_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teamID` int(11) NOT NULL DEFAULT '0',
  `userID` int(11) NOT NULL DEFAULT '0',
  `intPrivileges` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `teamID` (`teamID`,`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=417 ;

--
-- Dumping data for table `authuserteam_mapping`
--

INSERT INTO `authuserteam_mapping` (`id`, `teamID`, `userID`, `intPrivileges`) VALUES
(199, 45, 0, 7),
(200, 39, 0, 7),
(201, 53, 0, 7),
(202, 57, 0, 7),
(203, 59, 0, 7),
(204, 3, 0, 7),
(205, 4, 0, 7),
(206, 1, 0, 7),
(207, 15, 0, 7),
(208, 30, 0, 7),
(209, 2, 0, 7),
(210, 35, 0, 7),
(211, 45, 0, 7),
(212, 39, 0, 7),
(213, 59, 0, 7),
(214, 3, 0, 7),
(215, 1, 0, 7),
(216, 15, 0, 7),
(217, 30, 0, 7),
(218, 2, 0, 7),
(219, 35, 0, 7),
(220, 45, 0, 7),
(221, 39, 0, 7),
(222, 59, 0, 7),
(223, 3, 0, 7),
(224, 1, 0, 7),
(225, 15, 0, 7),
(226, 30, 0, 7),
(227, 2, 0, 7),
(228, 35, 0, 7),
(229, 45, 0, 7),
(230, 39, 0, 7),
(231, 59, 0, 7),
(232, 3, 0, 7),
(233, 1, 232, 7),
(234, 15, 232, 7),
(235, 30, 232, 7),
(236, 2, 232, 7),
(237, 35, 232, 7),
(238, 45, 232, 7),
(239, 39, 232, 7),
(240, 59, 232, 7),
(241, 3, 232, 7),
(242, 1, 0, 7),
(243, 15, 0, 7),
(244, 30, 0, 7),
(245, 2, 0, 7),
(246, 35, 0, 7),
(247, 45, 0, 7),
(248, 39, 0, 7),
(249, 59, 0, 7),
(250, 3, 0, 7),
(297, 1, 2, 7),
(298, 2, 2, 7),
(299, 3, 2, 7),
(300, 15, 2, 7),
(301, 30, 2, 7),
(302, 35, 2, 7),
(303, 39, 2, 7),
(304, 45, 2, 7),
(305, 59, 2, 7),
(306, 60, 2, 7),
(362, 1, 1, 7),
(363, 2, 1, 7),
(364, 3, 1, 7),
(365, 30, 1, 7),
(366, 39, 1, 7),
(367, 45, 1, 7),
(368, 59, 1, 7),
(369, 60, 1, 7),
(370, 61, 1, 7),
(389, 1, 28, 7),
(390, 2, 28, 7),
(391, 3, 28, 7),
(392, 30, 28, 7),
(393, 39, 28, 7),
(394, 45, 28, 7),
(395, 59, 28, 7),
(396, 60, 28, 7),
(397, 61, 28, 7),
(399, 2, 5, 7),
(400, 3, 5, 7),
(401, 30, 5, 7),
(402, 39, 5, 7),
(403, 45, 5, 7),
(404, 59, 5, 7),
(405, 60, 5, 7),
(406, 61, 5, 7),
(410, 1, 19, 6),
(412, 1, 21, 6),
(415, 1, 29, 7),
(416, 2, 29, 7);

-- --------------------------------------------------------

--
-- Table structure for table `chat_rooms`
--

CREATE TABLE IF NOT EXISTS `chat_rooms` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `numofuser` int(10) NOT NULL,
  `file` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `chat_rooms`
--

INSERT INTO `chat_rooms` (`id`, `name`, `numofuser`, `file`) VALUES
(7, 'Public', 100, 'chatroom-css.txt'),
(6, 'Tech assistance', 50, 'chatroom-html.txt'),
(8, 'Help & Assistance', 50, 'chatroom-javascript.txt'),
(19, 'private', 2, 'chatroom-private_temp.txt');

-- --------------------------------------------------------

--
-- Table structure for table `chat_users`
--

CREATE TABLE IF NOT EXISTS `chat_users` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `time_mod` int(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `chat_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `chat_users_rooms`
--

CREATE TABLE IF NOT EXISTS `chat_users_rooms` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `room` varchar(100) NOT NULL,
  `mod_time` int(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1574 ;

--
-- Dumping data for table `chat_users_rooms`
--


-- --------------------------------------------------------

--
-- Table structure for table `members_group`
--

CREATE TABLE IF NOT EXISTS `members_group` (
  `intMemGroupID` int(11) NOT NULL AUTO_INCREMENT,
  `szMemGroup` varchar(255) NOT NULL DEFAULT '',
  `intRank` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intMemGroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `members_group`
--


-- --------------------------------------------------------

--
-- Table structure for table `nabopoll_answers`
--

CREATE TABLE IF NOT EXISTS `nabopoll_answers` (
  `survey` int(11) NOT NULL DEFAULT '0',
  `question` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL DEFAULT '0',
  `answer` varchar(255) NOT NULL DEFAULT '',
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`survey`,`question`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nabopoll_answers`
--

INSERT INTO `nabopoll_answers` (`survey`, `question`, `id`, `answer`, `count`) VALUES
(1, 1, 1, 'Yes', 3),
(1, 1, 2, 'No', 0);

-- --------------------------------------------------------

--
-- Table structure for table `nabopoll_history`
--

CREATE TABLE IF NOT EXISTS `nabopoll_history` (
  `survey` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `instant` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `answers` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nabopoll_history`
--


-- --------------------------------------------------------

--
-- Table structure for table `nabopoll_ip`
--

CREATE TABLE IF NOT EXISTS `nabopoll_ip` (
  `survey` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(20) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nabopoll_ip`
--

INSERT INTO `nabopoll_ip` (`survey`, `ip`) VALUES
(1, '::1'),
(1, '::1'),
(1, '::1');

-- --------------------------------------------------------

--
-- Table structure for table `nabopoll_questions`
--

CREATE TABLE IF NOT EXISTS `nabopoll_questions` (
  `survey` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL DEFAULT '0',
  `question` varchar(255) NOT NULL DEFAULT '',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `votes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`survey`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nabopoll_questions`
--

INSERT INTO `nabopoll_questions` (`survey`, `id`, `question`, `type`, `votes`) VALUES
(1, 1, 'Do you support any political party?', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `nabopoll_surveys`
--

CREATE TABLE IF NOT EXISTS `nabopoll_surveys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `template` varchar(16) NOT NULL DEFAULT '',
  `single_vote` tinyint(4) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `log` tinyint(4) NOT NULL DEFAULT '0',
  `required` tinyint(4) NOT NULL DEFAULT '1',
  `closed` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `nabopoll_surveys`
--

INSERT INTO `nabopoll_surveys` (`id`, `title`, `url`, `template`, `single_vote`, `uid`, `log`, `required`, `closed`) VALUES
(1, 'CAMPAIGNS', '/intranet/modules/polls/index.php', 'classic', 1, 852960360, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `nabopoll_version`
--

CREATE TABLE IF NOT EXISTS `nabopoll_version` (
  `version` varchar(5) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nabopoll_version`
--

INSERT INTO `nabopoll_version` (`version`) VALUES
('1.2');

-- --------------------------------------------------------

--
-- Table structure for table `resource`
--

CREATE TABLE IF NOT EXISTS `resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `location` varchar(128) DEFAULT NULL,
  `owner` varchar(128) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `resource`
--

INSERT INTO `resource` (`id`, `name`, `location`, `owner`, `status`) VALUES
(1, 'VENUUE 1', 'LOCATION 1', 'OWNER 1', 1),
(2, 'VENUE 2', 'LOCATION 2', 'OWNER 2', 1),
(3, 'VENUE 3', 'LOCATION 3', 'OWNER 3', 0),
(4, 'VENUE 4', 'LOCATION 4', 'OWNER 4', 0),
(5, 'VENUE 5', 'LOCATION 5', 'OWNER 5', 0);

-- --------------------------------------------------------

--
-- Table structure for table `resource_user`
--

CREATE TABLE IF NOT EXISTS `resource_user` (
  `username` varchar(128) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `reserve_date` datetime DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resource_user`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_album`
--

CREATE TABLE IF NOT EXISTS `tbl_album` (
  `al_id` int(11) NOT NULL AUTO_INCREMENT,
  `al_name` varchar(64) NOT NULL DEFAULT '',
  `al_description` text NOT NULL,
  `al_image` varchar(64) NOT NULL DEFAULT '',
  `al_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`al_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_album`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_assignments`
--

CREATE TABLE IF NOT EXISTS `tbl_assignments` (
  `assignment_id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `assignment_date` datetime DEFAULT NULL,
  `assigned_by` varchar(8) DEFAULT NULL,
  `assigned_to` varchar(8) DEFAULT NULL,
  `task_viewable_by_id` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`assignment_id`),
  KEY `fi0` (`task_viewable_by_id`),
  KEY `fi1` (`task_id`),
  KEY `fi2` (`assigned_by`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_assignments`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_assignment_privileges`
--

CREATE TABLE IF NOT EXISTS `tbl_assignment_privileges` (
  `user_id` varchar(8) NOT NULL,
  `assignee_id` varchar(8) NOT NULL,
  PRIMARY KEY (`user_id`,`assignee_id`),
  KEY `fi0` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_assignment_privileges`
--

INSERT INTO `tbl_assignment_privileges` (`user_id`, `assignee_id`) VALUES
('25', 'G0000022'),
('25', 'G0000023'),
('3', 'G0000007'),
('5', '15'),
('5', '17'),
('5', 'G0000011'),
('5', 'G0000012'),
('5', 'G0000013'),
('5', 'G0000014'),
('5', 'G0000015'),
('6', '20'),
('6', 'G0000017'),
('6', 'G0000019'),
('8', '14'),
('8', '16'),
('8', '18'),
('8', '19'),
('8', 'G0000025'),
('8', 'G0000026'),
('8', 'G0000027');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_adminmenu`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_adminmenu` (
  `menuid` varchar(15) NOT NULL DEFAULT '',
  `menu` varchar(255) NOT NULL DEFAULT '',
  `langCode` varchar(15) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `mstatus` varchar(100) NOT NULL DEFAULT '',
  `image` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_christcms_adminmenu`
--

INSERT INTO `tbl_christcms_adminmenu` (`menuid`, `menu`, `langCode`, `url`, `mstatus`, `image`, `description`) VALUES
('MM1', 'Pages', 'en', 'modules/core/admin/pages/index.php', 'visible', 'pages.png', 'Page Manager'),
('MM3', 'Events', 'en', 'modules/core/admin/events/index.php', 'visible', 'events.png', 'Events Manager'),
('MM8', 'Photo Gallery', 'en', 'modules/core/admin/gallery/admin/index.php', 'visible', 'photo.png', 'Photo Gallery Manager'),
('MM12', 'News', 'en', 'modules/core/admin/news/index.php', 'visible', 'news.png', 'News Manager'),
('MM13', 'Language', 'en', 'modules/core/admin/guestbook/index.php', 'invisible', 'languages.png', 'Language Manager'),
('MM14', 'System Configuration', 'en', 'modules/core/admin/config/index.php', 'invisible', 'settings.png', 'System Configuration Manager'),
('MM15', 'FAQ', 'en', 'modules/core/admin/faq/index.php', 'visible', 'faq.png', 'FAQ Manager'),
('MM16', 'User Manager', 'en', 'modules/core/security/index.php', 'visible', 'user.gif', 'User Manager'),
('MM17', 'Groups', 'en', 'modules/core/security/group/index.php', 'visible', 'group.png', 'GroupManager'),
('MM18', 'Category', 'en', 'modules/core/admin/category/index.php', 'visible', 'category.png', 'Category Manager'),
('MM9', 'Staff Manager', 'en', 'modules/core/admin/staff/index.php', 'visible', 'staff.png', 'Staff Manager'),
('MM10', 'Link Manager', 'en', 'modules/core/admin/links/index.php', 'visible', 'link.png', 'Link Manager'),
('MM11', 'Training Manager', 'en', 'modules/core/admin/training1/index.php', 'visible', 'icon.gif', 'Training Manager'),
('MM19', 'Partners Manager', 'en', 'modules/core/admin/projects/index.php', 'visible', 'addpage.png', 'Manage Project and Programmes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_adminsub`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_adminsub` (
  `id` varchar(15) NOT NULL DEFAULT '',
  `menuid` varchar(15) NOT NULL DEFAULT '',
  `submenu` varchar(255) NOT NULL DEFAULT '',
  `langCode` varchar(15) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `mstatus` varchar(100) NOT NULL DEFAULT '',
  `image` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_christcms_adminsub`
--

INSERT INTO `tbl_christcms_adminsub` (`id`, `menuid`, `submenu`, `langCode`, `url`, `mstatus`, `image`, `description`) VALUES
('SM1', 'MM1', 'Add page', 'en', 'modules/core/admin/pages/add_page.php', 'visible', 'addpage.png', 'script to add page'),
('SM2', 'MM12', 'Add News', 'en', 'modules/core/admin/news/add_news.php', 'visible', 'addnews.png', 'script to add news'),
('SM3', 'MM3', 'Add Events', 'en', 'modules/core/admin/events/add_events.php', 'visible', 'addevent.png', 'Script to add events'),
('SM4', 'MM15', 'Add FAQ', 'en', 'modules/core/admin/faq/add_faq.php', 'visible', 'faqadd.pnq', 'Script to add FAQ'),
('SM5', 'MM16', 'Add User', 'en', 'modules/core/security/add_user.php', 'visible', 'adduser.png', 'Script to add user'),
('SM6', 'MM17', 'Add Group', 'en', 'modules/core/security/group/add_group.php', 'visible', 'group.png', 'Script to add group'),
('SM7', 'MM18', 'Add Category', 'en', 'modules/core/admin/category/add_cat.php', 'visible', 'addcat.png', 'Script to add category'),
('SM8', 'MM9', 'Add Staff', 'en', 'modules/core/admin/staff/add_staff.php', 'visible', 'addstaff.png', 'Script to add staff'),
('SM9', 'MM10', 'Add Link', 'en', 'modules/core/admin/links/add_link.php', 'visible', 'addlink.png', 'Script to add link'),
('SM10', 'MM11', 'Add Training', 'en', 'modules/core/admin/training/add.php', 'visible', 'addstaff.png', 'Script to add member'),
('SM11', 'MM19', 'Add Project', 'en', 'modules/core/admin/projects/add_project.php', 'visible', 'addpage.png', 'Add project');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_category`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_category` (
  `categoryID` int(11) NOT NULL AUTO_INCREMENT,
  `catTitle` varchar(100) NOT NULL DEFAULT '',
  `catDescription` text NOT NULL,
  `langCode` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`categoryID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_christcms_category`
--

INSERT INTO `tbl_christcms_category` (`categoryID`, `catTitle`, `catDescription`, `langCode`) VALUES
(1, 'Web Content', 'Web Content', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_cont_category`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_cont_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `langCode` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_christcms_cont_category`
--

INSERT INTO `tbl_christcms_cont_category` (`id`, `category`, `description`, `langCode`) VALUES
(1, 'Current', '', 'en'),
(5, 'Past', 'Vimepita', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_cont_status`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_cont_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL,
  `description` text,
  `langCode` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_christcms_cont_status`
--

INSERT INTO `tbl_christcms_cont_status` (`id`, `status`, `description`, `langCode`) VALUES
(1, 'Completed', '<font size="2" face="arial,helvetica,sans-serif">Have been finished</font><br />', 'en'),
(4, 'Not Completed', '', 'en'),
(5, 'Pending', '', 'en'),
(6, 'Cancelled', '', 'en'),
(7, 'On Progress', '', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_events`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventTitle` varchar(100) NOT NULL DEFAULT '',
  `eventSummary` text NOT NULL,
  `eventBody` text NOT NULL,
  `eventLocation` varchar(100) NOT NULL DEFAULT '',
  `categoryID` int(11) NOT NULL DEFAULT '0',
  `langCode` varchar(15) NOT NULL DEFAULT '',
  `startDt` date NOT NULL DEFAULT '0000-00-00',
  `endDt` date NOT NULL DEFAULT '0000-00-00',
  `dtCreated` date NOT NULL DEFAULT '0000-00-00',
  `eventArchive` varchar(15) NOT NULL DEFAULT '',
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_christcms_events`
--

INSERT INTO `tbl_christcms_events` (`id`, `eventTitle`, `eventSummary`, `eventBody`, `eventLocation`, `categoryID`, `langCode`, `startDt`, `endDt`, `dtCreated`, `eventArchive`, `status`) VALUES
(12, 'event  1', 'sdjfhasdjkflhadsf', 'fghfhfghfd', 'fghfdgh', 1, 'en', '2010-08-10', '2010-08-09', '2010-08-11', 'No', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_faq`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_faq` (
  `faqID` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `catID` int(11) NOT NULL DEFAULT '0',
  `langCode` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`faqID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_christcms_faq`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_links`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_links` (
  `LinkID` int(10) NOT NULL AUTO_INCREMENT,
  `CatID` int(10) NOT NULL DEFAULT '0',
  `Name` varchar(200) NOT NULL DEFAULT '',
  `Url` varchar(200) NOT NULL DEFAULT '',
  `Description` text NOT NULL,
  `langCode` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`LinkID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_christcms_links`
--

INSERT INTO `tbl_christcms_links` (`LinkID`, `CatID`, `Name`, `Url`, `Description`, `langCode`) VALUES
(2, 1, 'Prime minister''s office', 'www.pmo.go.tz', 'Prime minister''s office<br />', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_mainmenu`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_mainmenu` (
  `menuid` varchar(15) NOT NULL DEFAULT '',
  `menu` varchar(100) NOT NULL DEFAULT '',
  `langCode` varchar(10) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `mstatus` varchar(100) NOT NULL DEFAULT 'visible',
  `msection` varchar(100) NOT NULL DEFAULT 'Top',
  PRIMARY KEY (`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_christcms_mainmenu`
--

INSERT INTO `tbl_christcms_mainmenu` (`menuid`, `menu`, `langCode`, `url`, `mstatus`, `msection`) VALUES
('MM1', 'LBHome', 'en', 'modules/core/admin/index.php', 'visible', 'Top'),
('MM2', 'LBStaff', 'en', 'modules/core/admin/comm/staff/index.php', 'visible', 'Top'),
('MM3', 'LBProjects', 'en', 'modules/core/admin/projects/index.php', 'visible', 'Top'),
('MM10', 'LBTraining', 'en', 'modules/core/admin/training/index.php', 'visible', 'Top'),
('MM7', 'LBChat', 'en', 'modules/chat/index.php', 'visible', 'Top'),
('MM4', 'LBPhotoGallery', 'en', 'modules/info/gallery/index.php', 'visible', 'Top');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_menupage_mapping`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_menupage_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menuid` varchar(15) NOT NULL DEFAULT '',
  `pageID` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `tbl_christcms_menupage_mapping`
--

INSERT INTO `tbl_christcms_menupage_mapping` (`id`, `menuid`, `pageID`) VALUES
(1, 'MM1', 'PG1'),
(2, 'SM1', 'PG2'),
(3, 'SM2', 'PG3'),
(4, 'SM3', 'PG4'),
(5, 'MM3', 'PG5'),
(6, 'MM10', 'PG6'),
(7, 'SM13', 'PG7'),
(8, 'SM19', 'PG8'),
(9, 'SM19', 'PG9'),
(10, 'MM6', 'PG10'),
(11, 'SM10', 'PG11'),
(12, 'SM11', 'PG12'),
(13, 'SM12', 'PG13'),
(14, 'SM13', 'PG11'),
(15, 'SM14', 'PG15'),
(16, 'SM15', 'PG14'),
(17, 'SM16', 'PG15'),
(18, 'SM17', 'PG16'),
(19, 'SM18', 'PG17');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_news`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `newsTitle` varchar(100) NOT NULL DEFAULT '',
  `newsSummary` text NOT NULL,
  `newsBody` text NOT NULL,
  `categoryID` int(11) NOT NULL DEFAULT '0',
  `langCode` varchar(15) NOT NULL DEFAULT '',
  `dtCreated` date NOT NULL DEFAULT '0000-00-00',
  `newsArchive` varchar(15) NOT NULL DEFAULT '',
  `newsGroup` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tbl_christcms_news`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_pages`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_pages` (
  `pageID` varchar(15) NOT NULL DEFAULT '',
  `pageTitle` varchar(50) NOT NULL DEFAULT '',
  `pageContent` longtext NOT NULL,
  `langCode` varchar(50) NOT NULL DEFAULT '',
  `dtUpdated` date NOT NULL DEFAULT '0000-00-00',
  `pageStatus` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pageID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_christcms_pages`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_partner`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `partnerName` varchar(200) NOT NULL DEFAULT '',
  `partnerSummary` text NOT NULL,
  `partnerMission` text NOT NULL,
  `partnerVision` text NOT NULL,
  `langCode` varchar(15) NOT NULL DEFAULT '',
  `email` varchar(100) DEFAULT NULL,
  `contact` text,
  `website` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_christcms_partner`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_project`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryID` int(11) NOT NULL,
  `projectTitle` varchar(100) NOT NULL DEFAULT '',
  `projectSummary` text NOT NULL,
  `projectObjective` text NOT NULL,
  `langCode` varchar(15) NOT NULL DEFAULT '',
  `dtStarted` date NOT NULL DEFAULT '0000-00-00',
  `dtEnded` date NOT NULL DEFAULT '0000-00-00',
  `projectArchive` varchar(15) NOT NULL DEFAULT '',
  `projectResult` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_christcms_project`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_setuplang`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_setuplang` (
  `langCode` varchar(10) NOT NULL DEFAULT '',
  `langCaption` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`langCode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_christcms_setuplang`
--

INSERT INTO `tbl_christcms_setuplang` (`langCode`, `langCaption`) VALUES
('en', 'English'),
('sw', 'Swahili'),
('fr', 'French');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_staff`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_staff` (
  `StaffID` varchar(15) NOT NULL DEFAULT '',
  `StaffName` varchar(200) NOT NULL DEFAULT '',
  `StaffTitle` text NOT NULL,
  `Description` text NOT NULL,
  `PhotoName` varchar(100) NOT NULL DEFAULT '',
  `PhotoType` varchar(100) NOT NULL DEFAULT '',
  `PhotoSize` varchar(100) NOT NULL DEFAULT '',
  `PhotoPath` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`StaffID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_christcms_staff`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_submenu`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_submenu` (
  `id` varchar(15) NOT NULL DEFAULT '',
  `submenu` varchar(100) NOT NULL DEFAULT '',
  `langCode` varchar(10) NOT NULL DEFAULT '',
  `menuid` varchar(15) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `smstatus` varchar(50) NOT NULL DEFAULT 'visible',
  `smsection` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_christcms_submenu`
--

INSERT INTO `tbl_christcms_submenu` (`id`, `submenu`, `langCode`, `menuid`, `url`, `smstatus`, `smsection`) VALUES
('SM4', 'LBObjectives', 'en', 'MM2_N', 'modules/pages/aboutus/objectives.php', 'visible', ''),
('SM9', 'LBNews', 'en', 'MM8', 'modules/news/index.php', 'visible', ''),
('SM10', 'LBEvents', 'en', 'MM8', 'modules/events/index.php', 'visible', ''),
('SM11', 'LBReports', 'en', 'MM8', 'modules/pages/infocenter/docs/index.php', 'visible', ''),
('SM12', 'LBBronchures', 'en', 'MM8', 'modules/pages/infocenter/docs/bronchures.php', 'visible', ''),
('SM13', 'LBPostalAddress', 'en', 'MM5', 'modules/pages/contacts/index.php', 'visible', ''),
('SM14', 'LBFeedback', 'en', 'MM5', 'modules/pages/contacts/feedback.php', 'visible', ''),
('SM6', 'LBOrganization', 'en', 'MM2_N', 'modules/pages/aboutus/org.php', 'visible', ''),
('SM7', 'LBCore', 'en', 'MM2_N', 'modules/pages/aboutus/core.php', 'visible', ''),
('SM19', 'LBDocuments', 'en', 'MM8', 'modules/pages/infocenter/docs/documents.php', 'visible', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_trainings`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_trainings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tTitle` varchar(255) NOT NULL,
  `tDescription` text NOT NULL,
  `langCode` varchar(15) NOT NULL DEFAULT '',
  `dtCreated` date NOT NULL DEFAULT '0000-00-00',
  `tArchive` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `tbl_christcms_trainings`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_user`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_user` (
  `userID` varchar(15) NOT NULL DEFAULT '',
  `userName` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `FName` varchar(100) NOT NULL DEFAULT '',
  `LName` varchar(100) NOT NULL DEFAULT '',
  `OName` varchar(100) NOT NULL DEFAULT '',
  `Tel` varchar(100) NOT NULL DEFAULT '',
  `Mobile` varchar(100) NOT NULL DEFAULT '',
  `RoomNo` varchar(100) NOT NULL DEFAULT '',
  `userStatus` varchar(100) NOT NULL DEFAULT '',
  `dtCreated` date NOT NULL DEFAULT '0000-00-00',
  `lastLogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_christcms_user`
--

INSERT INTO `tbl_christcms_user` (`userID`, `userName`, `password`, `FName`, `LName`, `OName`, `Tel`, `Mobile`, `RoomNo`, `userStatus`, `dtCreated`, `lastLogin`) VALUES
('US3', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'Intranet', '', '', '', '', 'Active', '2010-06-14', '2010-06-14 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_usergroup`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_usergroup` (
  `groupID` int(10) NOT NULL AUTO_INCREMENT,
  `groupTitle` varchar(100) NOT NULL DEFAULT '',
  `groupDescription` text NOT NULL,
  `groupStatus` varchar(15) NOT NULL DEFAULT '',
  `langCode` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`groupID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_christcms_usergroup`
--

INSERT INTO `tbl_christcms_usergroup` (`groupID`, `groupTitle`, `groupDescription`, `groupStatus`, `langCode`) VALUES
(1, 'Super Admin', 'Administrator', 'Active', 'en'),
(2, 'Content Admin', 'Content Administrator', 'Active', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_christcms_user_group`
--

CREATE TABLE IF NOT EXISTS `tbl_christcms_user_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` varchar(10) NOT NULL DEFAULT '',
  `groupID` varchar(10) NOT NULL DEFAULT '',
  `intPermision` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `tbl_christcms_user_group`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_documents`
--

CREATE TABLE IF NOT EXISTS `tbl_documents` (
  `document_id` int(11) NOT NULL,
  `document_description` varchar(255) DEFAULT NULL,
  `document_keywords` varchar(255) DEFAULT NULL,
  `document_file_name` varchar(255) DEFAULT NULL,
  `document_classification_id` varchar(3) DEFAULT NULL,
  `primary_author_id` varchar(8) DEFAULT NULL,
  `uploaded_by` varchar(8) DEFAULT NULL,
  `date_uploaded` datetime DEFAULT NULL,
  `document_status` varchar(6) DEFAULT NULL,
  `document_viewable_by_id` varchar(3) DEFAULT NULL,
  `file_id` varchar(20) DEFAULT NULL,
  `document_date` datetime DEFAULT NULL,
  PRIMARY KEY (`document_id`),
  KEY `fi0` (`primary_author_id`),
  KEY `fi1` (`primary_author_id`),
  KEY `fi2` (`document_status`),
  KEY `fi3` (`document_viewable_by_id`),
  KEY `fi4` (`document_classification_id`),
  KEY `fi5` (`primary_author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_documents`
--

INSERT INTO `tbl_documents` (`document_id`, `document_description`, `document_keywords`, `document_file_name`, `document_classification_id`, `primary_author_id`, `uploaded_by`, `date_uploaded`, `document_status`, `document_viewable_by_id`, `file_id`, `document_date`) VALUES
(1, 'simple document', 'document simple', 'doc_0000001_examples.desktop', 'CMP', '29', '28', '2010-08-07 10:25:05', 'Draft', 'INT', NULL, '2002-03-02 00:00:00'),
(2, 'simple', 'sfadf', 'doc_0000002_ubiquity-gtkui.desktop', 'CMP', '28', '28', '2010-08-07 10:28:32', 'Draft', 'INT', NULL, '2009-10-19 00:00:00'),
(3, 'Simple document 2', 'very crucial', 'doc_0000003_cis.sql', 'CMP', '28', '29', '2010-08-07 10:34:15', NULL, 'PUB', NULL, '2008-11-17 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_document_subject_areas`
--

CREATE TABLE IF NOT EXISTS `tbl_document_subject_areas` (
  `document_id` int(11) NOT NULL,
  `subject_area_id` varchar(3) NOT NULL,
  PRIMARY KEY (`document_id`,`subject_area_id`),
  KEY `fi0` (`document_id`),
  KEY `fi1` (`subject_area_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_document_subject_areas`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_entities`
--

CREATE TABLE IF NOT EXISTS `tbl_entities` (
  `entity_id` varchar(8) NOT NULL,
  `entity_name` varchar(50) DEFAULT NULL,
  `entity_type_id` varchar(3) DEFAULT NULL,
  `postal_address` varchar(255) DEFAULT NULL,
  `physical_address` varchar(255) DEFAULT NULL,
  `phone_numbers` varchar(255) DEFAULT NULL,
  `email_addresses` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`entity_id`),
  KEY `fi0` (`entity_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_entities`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_groups`
--

CREATE TABLE IF NOT EXISTS `tbl_groups` (
  `group_id` varchar(8) NOT NULL,
  `group_name` varchar(100) DEFAULT NULL,
  `group_status` char(6) DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  KEY `fi0` (`group_status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_group_membership`
--

CREATE TABLE IF NOT EXISTS `tbl_group_membership` (
  `group_id` varchar(8) NOT NULL,
  `member_id` varchar(8) NOT NULL,
  `role_in_group_type` varchar(15) DEFAULT NULL,
  `role_in_group_description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`group_id`,`member_id`),
  KEY `fi0` (`group_id`),
  KEY `fi1` (`role_in_group_type`),
  KEY `fi2` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_group_membership`
--

INSERT INTO `tbl_group_membership` (`group_id`, `member_id`, `role_in_group_type`, `role_in_group_description`) VALUES
('G0000017', '4', 'Ordinary member', 'Nothing much'),
('G0000021', '4', 'Ordinary member', 'I''m not sure'),
('G0000024', '21', 'Leader', 'crucial importance'),
('G0000026', '24', 'Ordinary member', 'No body');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_image`
--

CREATE TABLE IF NOT EXISTS `tbl_image` (
  `im_id` int(11) NOT NULL AUTO_INCREMENT,
  `im_album_id` int(11) NOT NULL DEFAULT '0',
  `im_title` varchar(64) NOT NULL DEFAULT '',
  `im_description` text NOT NULL,
  `im_type` varchar(30) NOT NULL DEFAULT '',
  `im_image` varchar(60) NOT NULL DEFAULT '',
  `im_thumbnail` varchar(60) NOT NULL DEFAULT '',
  `im_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`im_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_image`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_list_document_status`
--

CREATE TABLE IF NOT EXISTS `tbl_list_document_status` (
  `document_status` varchar(6) NOT NULL,
  PRIMARY KEY (`document_status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_list_document_status`
--

INSERT INTO `tbl_list_document_status` (`document_status`) VALUES
('Draft'),
('Final');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_list_document_viewable_by`
--

CREATE TABLE IF NOT EXISTS `tbl_list_document_viewable_by` (
  `document_viewable_by_id` varchar(3) NOT NULL,
  `document_viewable_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`document_viewable_by_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 41984 kB';

--
-- Dumping data for table `tbl_list_document_viewable_by`
--

INSERT INTO `tbl_list_document_viewable_by` (`document_viewable_by_id`, `document_viewable_by`) VALUES
('INT', 'All internal staff'),
('PUB', 'General public'),
('REL', 'Internal staff working on related tasks');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_list_group_user_status`
--

CREATE TABLE IF NOT EXISTS `tbl_list_group_user_status` (
  `group_user_status` char(6) NOT NULL,
  PRIMARY KEY (`group_user_status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_list_group_user_status`
--

INSERT INTO `tbl_list_group_user_status` (`group_user_status`) VALUES
('Active'),
('Closed'),
('Void');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_list_notification_types`
--

CREATE TABLE IF NOT EXISTS `tbl_list_notification_types` (
  `notification_type_id` varchar(3) NOT NULL,
  `notification_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`notification_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_list_notification_types`
--

INSERT INTO `tbl_list_notification_types` (`notification_type_id`, `notification_type`) VALUES
('ASR', 'Assignment received'),
('RFR', 'Referral received'),
('TKC', 'Task closed'),
('TKD', 'Document attached to task'),
('TKE', 'Task edited');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_list_role_in_group_type`
--

CREATE TABLE IF NOT EXISTS `tbl_list_role_in_group_type` (
  `role_in_group_type` varchar(15) NOT NULL,
  PRIMARY KEY (`role_in_group_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_list_role_in_group_type`
--

INSERT INTO `tbl_list_role_in_group_type` (`role_in_group_type`) VALUES
('Leader'),
('Ordinary member');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_list_task_viewable_by`
--

CREATE TABLE IF NOT EXISTS `tbl_list_task_viewable_by` (
  `task_viewable_by_id` varchar(3) NOT NULL,
  `task_viewable_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`task_viewable_by_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 113664 kB';

--
-- Dumping data for table `tbl_list_task_viewable_by`
--

INSERT INTO `tbl_list_task_viewable_by` (`task_viewable_by_id`, `task_viewable_by`) VALUES
('GPA', 'All members of group'),
('GPL', 'Group leader only');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification_preferences`
--

CREATE TABLE IF NOT EXISTS `tbl_notification_preferences` (
  `user_id` varchar(8) NOT NULL,
  `notification_type_id` varchar(3) NOT NULL,
  PRIMARY KEY (`user_id`,`notification_type_id`),
  KEY `fi0` (`notification_type_id`),
  KEY `fi1` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_notification_preferences`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_photo`
--

CREATE TABLE IF NOT EXISTS `tbl_photo` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `photo_name` varchar(100) NOT NULL,
  `photo_type` varchar(100) NOT NULL,
  `photo_size` varchar(100) NOT NULL,
  `photo_description` text NOT NULL,
  `dtCreated` datetime NOT NULL,
  `dtUpdated` datetime NOT NULL,
  PRIMARY KEY (`photo_id`),
  KEY `fk_album` (`album_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `tbl_photo`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_referrals`
--

CREATE TABLE IF NOT EXISTS `tbl_referrals` (
  `referral_id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `referral_date` datetime DEFAULT NULL,
  `referred_by` varchar(8) DEFAULT NULL,
  `referred_to` varchar(8) DEFAULT NULL,
  `referral_classification_id` varchar(3) DEFAULT NULL,
  `task_viewable_by_id` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`referral_id`),
  KEY `fi0` (`referred_to`),
  KEY `fi1` (`task_viewable_by_id`),
  KEY `fi2` (`referral_classification_id`),
  KEY `fi3` (`task_id`),
  KEY `fi4` (`referred_by`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_referrals`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_document_classifications`
--

CREATE TABLE IF NOT EXISTS `tbl_setup_document_classifications` (
  `document_classification_id` varchar(3) NOT NULL,
  `document_classification` varchar(50) DEFAULT NULL,
  `status` char(6) NOT NULL,
  PRIMARY KEY (`document_classification_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_setup_document_classifications`
--

INSERT INTO `tbl_setup_document_classifications` (`document_classification_id`, `document_classification`, `status`) VALUES
('FLD', 'Field documents', 'Active'),
('CMP', 'Campaign Documents', 'Active'),
('OFD', 'Official Documents', 'Active'),
('JDY', 'Judiciary Documents', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_entity_types`
--

CREATE TABLE IF NOT EXISTS `tbl_setup_entity_types` (
  `entity_type_id` varchar(3) NOT NULL,
  `entity_type` varchar(50) DEFAULT NULL,
  `status` char(6) NOT NULL,
  PRIMARY KEY (`entity_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_setup_entity_types`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_files`
--

CREATE TABLE IF NOT EXISTS `tbl_setup_files` (
  `file_id` varchar(20) NOT NULL,
  `file` varchar(50) DEFAULT NULL,
  `file_type_id` varchar(3) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 11264 kB; InnoDB free: 11264 kB';

--
-- Dumping data for table `tbl_setup_files`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_file_types`
--

CREATE TABLE IF NOT EXISTS `tbl_setup_file_types` (
  `file_type_id` varchar(3) NOT NULL DEFAULT '',
  `file_type` varchar(50) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`file_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 11264 kB';

--
-- Dumping data for table `tbl_setup_file_types`
--

INSERT INTO `tbl_setup_file_types` (`file_type_id`, `file_type`, `status`) VALUES
('CON', 'Confidential', 'Active'),
('OPN', 'Open', 'Active'),
('SEC', 'Secret', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_priority_classifications`
--

CREATE TABLE IF NOT EXISTS `tbl_setup_priority_classifications` (
  `priority_classification_id` varchar(3) NOT NULL,
  `priority_classification` varchar(50) DEFAULT NULL,
  `status` char(6) NOT NULL,
  PRIMARY KEY (`priority_classification_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 113664 kB';

--
-- Dumping data for table `tbl_setup_priority_classifications`
--

INSERT INTO `tbl_setup_priority_classifications` (`priority_classification_id`, `priority_classification`, `status`) VALUES
('NIM', 'Not important', 'Active'),
('OIM', 'Ordinal importance', 'Active'),
('VIM', 'Very Important', 'Active'),
('EIM', 'Extremely Important', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_referral_classifications`
--

CREATE TABLE IF NOT EXISTS `tbl_setup_referral_classifications` (
  `referral_classification_id` varchar(3) NOT NULL,
  `referral_classification` varchar(50) DEFAULT NULL,
  `status` char(6) NOT NULL,
  PRIMARY KEY (`referral_classification_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_setup_referral_classifications`
--

INSERT INTO `tbl_setup_referral_classifications` (`referral_classification_id`, `referral_classification`, `status`) VALUES
('FAM', 'For ammendments', 'Active'),
('FRV', 'For review', 'Active'),
('FCM', 'For comments', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_subject_areas`
--

CREATE TABLE IF NOT EXISTS `tbl_setup_subject_areas` (
  `subject_area_id` varchar(3) NOT NULL,
  `subject_area` varchar(50) DEFAULT NULL,
  `status` char(6) NOT NULL,
  PRIMARY KEY (`subject_area_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_setup_subject_areas`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_task_classifications`
--

CREATE TABLE IF NOT EXISTS `tbl_setup_task_classifications` (
  `task_classification_id` varchar(3) NOT NULL,
  `task_classification` varchar(50) DEFAULT NULL,
  `status` char(6) NOT NULL,
  PRIMARY KEY (`task_classification_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_setup_task_classifications`
--

INSERT INTO `tbl_setup_task_classifications` (`task_classification_id`, `task_classification`, `status`) VALUES
('OFT', 'Office tasks', 'Active'),
('FTS', 'Field tasks', 'Active'),
('TRT', 'Training tasks', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_task_closure_classifications`
--

CREATE TABLE IF NOT EXISTS `tbl_setup_task_closure_classifications` (
  `task_closure_classification_id` varchar(3) NOT NULL,
  `task_closure_classification` varchar(50) DEFAULT NULL,
  `status` char(6) NOT NULL,
  PRIMARY KEY (`task_closure_classification_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_setup_task_closure_classifications`
--

INSERT INTO `tbl_setup_task_closure_classifications` (`task_closure_classification_id`, `task_closure_classification`, `status`) VALUES
('CAN', 'Cancelled', 'Active'),
('COM', 'Completed', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_task_outcome_classifications`
--

CREATE TABLE IF NOT EXISTS `tbl_setup_task_outcome_classifications` (
  `task_outcome_classification_id` varchar(3) NOT NULL,
  `task_outcome_classification` varchar(100) DEFAULT NULL,
  `task_classification_id` varchar(3) DEFAULT NULL,
  `status` char(6) NOT NULL,
  PRIMARY KEY (`task_outcome_classification_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_setup_task_outcome_classifications`
--

INSERT INTO `tbl_setup_task_outcome_classifications` (`task_outcome_classification_id`, `task_outcome_classification`, `task_classification_id`, `status`) VALUES
('AAP', 'Application approved', 'PRC', 'Active'),
('AFI', 'Incomplete application', 'PRC', 'Active'),
('ARJ', 'Application rejected', 'PRC', 'Active'),
('RFI', 'Further information required before recommendation can be made', 'CRC', 'Active'),
('RNR', 'Not recommended', 'CRC', 'Active'),
('RRC', 'Recommended', 'CRC', 'Active'),
('RRM', 'Recommended with modifications', 'CRC', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setup_workload_classifications`
--

CREATE TABLE IF NOT EXISTS `tbl_setup_workload_classifications` (
  `workload_classification_id` varchar(3) NOT NULL,
  `workload_classification` varchar(50) DEFAULT NULL,
  `status` char(6) NOT NULL,
  PRIMARY KEY (`workload_classification_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_setup_workload_classifications`
--

INSERT INTO `tbl_setup_workload_classifications` (`workload_classification_id`, `workload_classification`, `status`) VALUES
('L01', '10 - 20 Hours', 'Active'),
('L02', '20-30 Hours', 'Active'),
('L03', '30 - 40 Hours', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tasks`
--

CREATE TABLE IF NOT EXISTS `tbl_tasks` (
  `task_id` int(11) NOT NULL,
  `task_description` varchar(255) DEFAULT NULL,
  `task_classification_id` varchar(3) DEFAULT NULL,
  `workload_classification_id` varchar(3) DEFAULT NULL,
  `priority_classification_id` varchar(3) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `created_by` varchar(8) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `percent_completed` int(11) DEFAULT NULL,
  `date_closed` datetime DEFAULT NULL,
  `task_closure_classification_id` varchar(3) DEFAULT NULL,
  `task_outcome_classification_id` varchar(3) DEFAULT NULL,
  `assignee_can_close` int(11) DEFAULT NULL,
  PRIMARY KEY (`task_id`),
  KEY `fi0` (`priority_classification_id`),
  KEY `fi1` (`task_classification_id`),
  KEY `fi2` (`task_closure_classification_id`),
  KEY `fi3` (`task_outcome_classification_id`),
  KEY `fi4` (`workload_classification_id`),
  KEY `fi5` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tasks`
--

INSERT INTO `tbl_tasks` (`task_id`, `task_description`, `task_classification_id`, `workload_classification_id`, `priority_classification_id`, `deadline`, `created_by`, `date_created`, `percent_completed`, `date_closed`, `task_closure_classification_id`, `task_outcome_classification_id`, `assignee_can_close`) VALUES
(1, 'Task one', 'FTS', 'L01', 'EIM', NULL, '28', '2010-08-07 10:13:07', 0, NULL, NULL, NULL, 0),
(2, 'simpe task 4', 'FTS', 'L02', 'EIM', '2012-03-17 00:00:00', '28', '2010-08-07 12:11:00', 0, NULL, NULL, NULL, -1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_task_documents`
--

CREATE TABLE IF NOT EXISTS `tbl_task_documents` (
  `task_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  PRIMARY KEY (`task_id`,`document_id`),
  KEY `fi0` (`document_id`),
  KEY `fi1` (`task_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_task_documents`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_task_entities`
--

CREATE TABLE IF NOT EXISTS `tbl_task_entities` (
  `task_id` int(11) NOT NULL,
  `entity_id` varchar(8) NOT NULL,
  PRIMARY KEY (`task_id`,`entity_id`),
  KEY `fi0` (`entity_id`),
  KEY `fi1` (`task_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_task_entities`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_task_notes`
--

CREATE TABLE IF NOT EXISTS `tbl_task_notes` (
  `task_note_id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `user_id` varchar(8) DEFAULT NULL,
  `date_written` datetime DEFAULT NULL,
  `note_text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`task_note_id`),
  KEY `fi0` (`task_id`),
  KEY `fi1` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_task_notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_xxx`
--

CREATE TABLE IF NOT EXISTS `tbl_users_xxx` (
  `user_id` varchar(8) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `landline_phone` varchar(50) DEFAULT NULL,
  `mobile_phone` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `office_location` varchar(50) DEFAULT NULL,
  `can_manage_users` int(11) DEFAULT NULL,
  `can_configure` int(11) DEFAULT NULL,
  `user_status` char(6) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 113664 kB';

--
-- Dumping data for table `tbl_users_xxx`
--


-- --------------------------------------------------------

--
-- Table structure for table `tb_christcms_event_photo`
--

CREATE TABLE IF NOT EXISTS `tb_christcms_event_photo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(200) NOT NULL,
  `type` int(10) NOT NULL,
  `size` int(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tb_christcms_event_photo`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE IF NOT EXISTS `user_log` (
  `intUserLogID` int(11) NOT NULL DEFAULT '0',
  `intUserID` int(11) NOT NULL DEFAULT '0',
  `szSessionID` varchar(100) NOT NULL DEFAULT '',
  `szIPAddress` varchar(100) NOT NULL DEFAULT '',
  `intDocumentID` int(11) NOT NULL DEFAULT '0',
  `intItemID` int(11) NOT NULL DEFAULT '0',
  `intTypeID` int(11) NOT NULL DEFAULT '0',
  `intVariationID` int(11) NOT NULL DEFAULT '0',
  `intTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `szAction` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`intUserLogID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`intUserLogID`, `intUserID`, `szSessionID`, `szIPAddress`, `intDocumentID`, `intItemID`, `intTypeID`, `intVariationID`, `intTimeStamp`, `szAction`) VALUES
(0, 28, 'e2hfsaoo6it7g211fmfgnn35c5', '::1', 0, 0, 0, 0, '2010-07-30 08:20:32', 'User logs in');
