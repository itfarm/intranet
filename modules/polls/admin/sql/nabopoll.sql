# phpMyAdmin MySQL-Dump
# version 2.2.0rc4
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# Host: localhost
# Generation Time: January 26, 2002, 2:40 pm
# Server version: 3.23.40
# PHP Version: 4.0.6
# Database : `nabocorp`
# --------------------------------------------------------

#
# Table structure for table `nabopoll_answers`
#

DROP TABLE IF EXISTS nabopoll_answers;
CREATE TABLE nabopoll_answers (
  survey int(11) NOT NULL default '0',
  question int(11) NOT NULL default '0',
  id int(11) NOT NULL default '0',
  answer varchar(255) NOT NULL default '',
  count int(11) NOT NULL default '0',
  PRIMARY KEY  (survey,question,id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `nabopoll_ip`
#

DROP TABLE IF EXISTS nabopoll_ip;
CREATE TABLE nabopoll_ip (
  survey int(11) NOT NULL default '0',
  ip varchar(20) NOT NULL default ''
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `nabopoll_questions`
#

DROP TABLE IF EXISTS nabopoll_questions;
CREATE TABLE nabopoll_questions (
  survey int(11) NOT NULL default '0',
  id int(11) NOT NULL default '0',
  question varchar(255) NOT NULL default '',
  type tinyint NOT NULL DEFAULT '0',
  votes int(11) NOT NULL default '0',
  PRIMARY KEY  (survey,id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `nabopoll_surveys`
#

DROP TABLE IF EXISTS nabopoll_surveys;
CREATE TABLE nabopoll_surveys (
  id int(11) NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  url varchar(255) NOT NULL default '',
  template varchar(16) NOT NULL default '',
  single_vote tinyint(4) NOT NULL default '0',
  uid int(11) NOT NULL default '0',
  log tinyint(4) NOT NULL default '0',
  required tinyint(4) NOT NULL default '1',
  closed tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for `nabopoll_history`
#

DROP TABLE IF EXISTS nabopoll_history;
CREATE TABLE nabopoll_history (
  survey int(11) NOT NULL default '0',
  ip varchar(15) NOT NULL default '',
  instant datetime NOT NULL default '0000-00-00 00:00:00',
  answers varchar(255) NOT NULL default ''
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `nabopoll_version`
#

DROP TABLE IF EXISTS nabopoll_version;
CREATE TABLE nabopoll_version (
  version varchar(5) NOT NULL default ''
) TYPE=MyISAM;


INSERT INTO nabopoll_version VALUES ('1.2');
# --------------------------------------------------------
