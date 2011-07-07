# CodeGen Dump
# http://code.google.com/p/flex-codegen
#
# Host: @HOST
# Database: @DATABASE
# Generation Time: @DATETIME
# ************************************************************

# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(255) default 'none',
  `name` varchar(255) default 'Joe',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`,`email`,`name`)
VALUES
	(1,'ruby@gmail.com','Ruby'),
	(5,'jonniedollas@gmail.com','Jonnie');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

