CREATE TABLE `searchterms` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`term` varchar(255) NOT NULL,
`soundex` varchar(255) NOT NULL,
`metaphone` varchar(255) NOT NULL,
`product_id` int(11) NOT NULL,
`category` varchar(50) NOT NULL,
PRIMARY KEY (`id`),
KEY `idx_searchterms_metaphone` (`metaphone`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
