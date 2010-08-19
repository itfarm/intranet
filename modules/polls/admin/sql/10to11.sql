#
# Modifs de la table nabopoll_answers
#

ALTER TABLE nabopoll_surveys
	ADD template VARCHAR(16) NOT NULL AFTER `url`;

UPDATE nabopoll_surveys
	SET template="classic";

#
# Ajout de la table nabopoll_version
#

DROP TABLE IF EXISTS nabopoll_version;
CREATE TABLE nabopoll_version (
  version varchar(5) NOT NULL
) TYPE=MyISAM;

INSERT INTO nabopoll_version VALUES ('1.1');
