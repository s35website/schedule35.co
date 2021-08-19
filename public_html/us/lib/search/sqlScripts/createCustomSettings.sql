CREATE TABLE `custom_settings` (
  `name` varchar(50) NOT NULL,
  `settings` text NOT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
