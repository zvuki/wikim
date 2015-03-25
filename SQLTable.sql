
CREATE TABLE `currency` (
  `code` char(3) NOT NULL,
  `date` datetime NOT NULL,
  `value` decimal(18,9) unsigned NOT NULL,
  PRIMARY KEY (`code`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;