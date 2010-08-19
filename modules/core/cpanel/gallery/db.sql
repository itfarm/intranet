DROP TABLE IF EXISTS `album`;
CREATE TABLE `album` (
  `album_id` int(11) NOT NULL auto_increment,
  `album_name` varchar(100) NOT NULL,
  `album_description` text NOT NULL,
  `album_thumb` varchar(100) NOT NULL,
  `blArchive` tinyint(1) NOT NULL,
  `dtCreated` datetime NOT NULL,
  `dtUpdated` datetime NOT NULL,
  PRIMARY KEY  (`album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `photo_id` int(11) NOT NULL auto_increment,
  `album_id` int(11) NOT NULL,
  `photo_name` varchar(100) NOT NULL,
  `photo_type` varchar(100) NOT NULL,
  `photo_size` varchar(100) NOT NULL,
  `photo_description` text NOT NULL,
  `dtCreated` datetime NOT NULL,
  `dtUpdated` datetime NOT NULL,
  PRIMARY KEY  (`photo_id`),
  KEY `fk_album` (`album_id`),
  CONSTRAINT `fk_album` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
