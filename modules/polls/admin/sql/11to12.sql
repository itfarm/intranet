#
# Table structure for `nabopoll_history`
#

DROP TABLE IF EXISTS nabopoll_history;
CREATE TABLE nabopoll_history (
  survey int(11) NOT NULL default '0',
  ip varchar(15) NOT NULL default '',
  instant datetime NOT NULL default '0000-00-00 00:00:00',
  answers varchar(255) NOT NULL default ''
);
# --------------------------------------------------------

#
# Modifs des tables
#

ALTER TABLE nabopoll_surveys
	CHANGE test_ip single_vote tinyint(4) DEFAULT '0' NOT NULL;
	
ALTER TABLE nabopoll_surveys
	ADD uid INT DEFAULT '0' NOT NULL AFTER single_vote;

ALTER TABLE nabopoll_surveys
	ADD log TINYINT DEFAULT '0' NOT NULL AFTER uid;  

ALTER TABLE nabopoll_surveys
	ADD required TINYINT DEFAULT '1' NOT NULL AFTER log;

ALTER TABLE nabopoll_questions
	ADD type TINYINT DEFAULT '0' NOT NULL;

ALTER TABLE nabopoll_questions
	ADD votes int(11) DEFAULT '0' NOT NULL;

UPDATE nabopoll_surveys
	SET uid=RAND()*1e9;

#
# Modifs de la table nabopoll_version
#

DELETE FROM nabopoll_version;
INSERT INTO nabopoll_version VALUES ('1.2');
