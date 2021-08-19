<?php

  define("_VALID_PHP", true);

  $BASEPATH = str_replace("upgrade.php", "", realpath(__file__));
  define("BASEPATH", $BASEPATH);

  $configFile = BASEPATH . "lib/config.ini.php";
  if (file_exists($configFile)) {
      require_once ($configFile);
  } else {
      exit("Configuration file is missing. Upgrade can not continue");
  }
  
  function redirect_to($location)
  {
      if (!headers_sent()) {
          header('Location: ' . $location);
		  exit;
	  } else
          echo '<script type="text/javascript">';
          echo 'window.location.href="' . $location . '";';
          echo '</script>';
          echo '<noscript>';
          echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
          echo '</noscript>';
  }

  require_once (BASEPATH . "lib/class_registry.php");

  require_once (BASEPATH . "lib/class_db.php");
  Registry::set('Database', new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE));
  $db = Registry::get("Database");
  $db->connect();
  
  $ver = $db->first("SELECT version FROM settings");

  
  if (isset($_POST['submit'])) {
      $db->query("
			CREATE TABLE `countries`(
				`id` smallint(6) NULL  , 
				`abbr` varchar(6) COLLATE utf8_general_ci NULL  , 
				`name` varchar(210) COLLATE utf8_general_ci NULL  , 
				`active` tinyint(1) NULL  , 
				`home` tinyint(1) NULL  , 
				`vat` decimal(7,0) NULL  , 
				`sorting` smallint(6) NULL  , 
				KEY `idx`(`abbr`) 
			) ENGINE=MyISAM DEFAULT CHARSET='utf8' COLLATE='utf8_general_ci';
	  ");

      $db->query("
			INSERT INTO `countries` (`id`, `abbr`, `name`, `active`, `home`, `vat`, `sorting`) VALUES
			(1, 'AF', 'Afghanistan', 1, NULL, '0', 0),
			(2, 'AL', 'Albania', 1, NULL, '0', 0),
			(3, 'DZ', 'Algeria', 1, NULL, '0', 0),
			(4, 'AS', 'American Samoa', 1, NULL, '0', 0),
			(5, 'AD', 'Andorra', 1, NULL, '0', 0),
			(6, 'AO', 'Angola', 1, NULL, '0', 0),
			(7, 'AI', 'Anguilla', 1, NULL, '0', 0),
			(8, 'AQ', 'Antarctica', 1, NULL, '0', 0),
			(9, 'AG', 'Antigua and Barbuda', 1, NULL, '0', 0),
			(10, 'AR', 'Argentina', 1, NULL, '0', 0),
			(11, 'AM', 'Armenia', 1, NULL, '0', 0),
			(12, 'AW', 'Aruba', 1, NULL, '0', 0),
			(13, 'AU', 'Australia', 1, NULL, '0', 0),
			(14, 'AT', 'Austria', 1, NULL, '0', 0),
			(15, 'AZ', 'Azerbaijan', 1, NULL, '0', 0),
			(16, 'BS', 'Bahamas', 1, NULL, '0', 0),
			(17, 'BH', 'Bahrain', 1, NULL, '0', 0),
			(18, 'BD', 'Bangladesh', 1, NULL, '0', 0),
			(19, 'BB', 'Barbados', 1, NULL, '0', 0),
			(20, 'BY', 'Belarus', 1, NULL, '0', 0),
			(21, 'BE', 'Belgium', 1, NULL, '0', 0),
			(22, 'BZ', 'Belize', 1, NULL, '0', 0),
			(23, 'BJ', 'Benin', 1, NULL, '0', 0),
			(24, 'BM', 'Bermuda', 1, NULL, '0', 0),
			(25, 'BT', 'Bhutan', 1, NULL, '0', 0),
			(26, 'BO', 'Bolivia', 1, NULL, '0', 0),
			(27, 'BA', 'Bosnia and Herzegowina', 1, NULL, '0', 0),
			(28, 'BW', 'Botswana', 1, NULL, '0', 0),
			(29, 'BV', 'Bouvet Island', 1, NULL, '0', 0),
			(30, 'BR', 'Brazil', 1, NULL, '0', 0),
			(31, 'IO', 'British Indian Ocean Territory', 1, NULL, '0', 0),
			(32, 'VG', 'British Virgin Islands', 1, NULL, '0', 0),
			(33, 'BN', 'Brunei Darussalam', 1, NULL, '0', 0),
			(34, 'BG', 'Bulgaria', 1, NULL, '0', 0),
			(35, 'BF', 'Burkina Faso', 1, NULL, '0', 0),
			(36, 'BI', 'Burundi', 1, NULL, '0', 0),
			(37, 'KH', 'Cambodia', 1, NULL, '0', 0),
			(38, 'CM', 'Cameroon', 1, NULL, '0', 0),
			(39, 'CA', 'Canada', 1, 1, '13', 1000),
			(40, 'CV', 'Cape Verde', 1, NULL, '0', 0),
			(41, 'KY', 'Cayman Islands', 1, NULL, '0', 0),
			(42, 'CF', 'Central African Republic', 1, NULL, '0', 0),
			(43, 'TD', 'Chad', 1, NULL, '0', 0),
			(44, 'CL', 'Chile', 1, NULL, '0', 0),
			(45, 'CN', 'China', 1, NULL, '0', 0),
			(46, 'CX', 'Christmas Island', 1, NULL, '0', 0),
			(47, 'CC', 'Cocos (Keeling) Islands', 1, NULL, '0', 0),
			(48, 'CO', 'Colombia', 1, NULL, '0', 0),
			(49, 'KM', 'Comoros', 1, NULL, '0', 0),
			(50, 'CG', 'Congo', 1, NULL, '0', 0),
			(51, 'CK', 'Cook Islands', 1, NULL, '0', 0),
			(52, 'CR', 'Costa Rica', 1, NULL, '0', 0),
			(53, 'CI', 'Cote D&#39;ivoire', 1, NULL, '0', 0),
			(54, 'HR', 'Croatia', 1, NULL, '0', 0),
			(55, 'CU', 'Cuba', 1, NULL, '0', 0),
			(56, 'CY', 'Cyprus', 1, NULL, '0', 0),
			(57, 'CZ', 'Czech Republic', 1, NULL, '0', 0),
			(58, 'DK', 'Denmark', 1, NULL, '0', 0),
			(59, 'DJ', 'Djibouti', 1, NULL, '0', 0),
			(60, 'DM', 'Dominica', 1, NULL, '0', 0),
			(61, 'DO', 'Dominican Republic', 1, NULL, '0', 0),
			(62, 'TP', 'East Timor', 1, NULL, '0', 0),
			(63, 'EC', 'Ecuador', 1, NULL, '0', 0),
			(64, 'EG', 'Egypt', 1, NULL, '0', 0),
			(65, 'SV', 'El Salvador', 1, NULL, '0', 0),
			(66, 'GQ', 'Equatorial Guinea', 1, NULL, '0', 0),
			(67, 'ER', 'Eritrea', 1, NULL, '0', 0),
			(68, 'EE', 'Estonia', 1, NULL, '0', 0),
			(69, 'ET', 'Ethiopia', 1, NULL, '0', 0),
			(70, 'FK', 'Falkland Islands (Malvinas)', 1, NULL, '0', 0),
			(71, 'FO', 'Faroe Islands', 1, NULL, '0', 0),
			(72, 'FJ', 'Fiji', 1, NULL, '0', 0),
			(73, 'FI', 'Finland', 1, NULL, '0', 0),
			(74, 'FR', 'France', 1, NULL, '0', 0),
			(75, 'GF', 'French Guiana', 1, NULL, '0', 0),
			(76, 'PF', 'French Polynesia', 1, NULL, '0', 0),
			(77, 'TF', 'French Southern Territories', 1, NULL, '0', 0),
			(78, 'GA', 'Gabon', 1, NULL, '0', 0),
			(79, 'GM', 'Gambia', 1, NULL, '0', 0),
			(80, 'GE', 'Georgia', 1, NULL, '0', 0),
			(81, 'DE', 'Germany', 1, NULL, '0', 0),
			(82, 'GH', 'Ghana', 1, NULL, '0', 0),
			(83, 'GI', 'Gibraltar', 1, NULL, '0', 0),
			(84, 'GR', 'Greece', 1, NULL, '0', 0),
			(85, 'GL', 'btn primaryland', 1, NULL, '0', 0),
			(86, 'GD', 'Grenada', 1, NULL, '0', 0),
			(87, 'GP', 'Guadeloupe', 1, NULL, '0', 0),
			(88, 'GU', 'Guam', 1, NULL, '0', 0),
			(89, 'GT', 'Guatemala', 1, NULL, '0', 0),
			(90, 'GN', 'Guinea', 1, NULL, '0', 0),
			(91, 'GW', 'Guinea-Bissau', 1, NULL, '0', 0),
			(92, 'GY', 'Guyana', 1, NULL, '0', 0),
			(93, 'HT', 'Haiti', 1, NULL, '0', 0),
			(94, 'HM', 'Heard and McDonald Islands', 1, NULL, '0', 0),
			(95, 'HN', 'Honduras', 1, NULL, '0', 0),
			(96, 'HK', 'Hong Kong', 1, NULL, '0', 0),
			(97, 'HU', 'Hungary', 1, NULL, '0', 0),
			(98, 'IS', 'Iceland', 1, NULL, '0', 0),
			(99, 'IN', 'India', 1, NULL, '0', 0),
			(100, 'ID', 'Indonesia', 1, NULL, '0', 0),
			(101, 'IQ', 'Iraq', 1, NULL, '0', 0),
			(102, 'IE', 'Ireland', 1, NULL, '0', 0),
			(103, 'IR', 'Islamic Republic of Iran', 1, NULL, '0', 0),
			(104, 'IL', 'Israel', 1, NULL, '0', 0),
			(105, 'IT', 'Italy', 1, NULL, '0', 0),
			(106, 'JM', 'Jamaica', 1, NULL, '0', 0),
			(107, 'JP', 'Japan', 1, NULL, '0', 0),
			(108, 'JO', 'Jordan', 1, NULL, '0', 0),
			(109, 'KZ', 'Kazakhstan', 1, NULL, '0', 0),
			(110, 'KE', 'Kenya', 1, NULL, '0', 0),
			(111, 'KI', 'Kiribati', 1, NULL, '0', 0),
			(112, 'KP', 'Korea, Dem. Peoples Rep of', 1, NULL, '0', 0),
			(113, 'KR', 'Korea, Republic of', 1, NULL, '0', 0),
			(114, 'KW', 'Kuwait', 1, NULL, '0', 0),
			(115, 'KG', 'Kyrgyzstan', 1, NULL, '0', 0),
			(116, 'LA', 'Laos', 1, NULL, '0', 0),
			(117, 'LV', 'Latvia', 1, NULL, '0', 0),
			(118, 'LB', 'Lebanon', 1, NULL, '0', 0),
			(119, 'LS', 'Lesotho', 1, NULL, '0', 0),
			(120, 'LR', 'Liberia', 1, NULL, '0', 0),
			(121, 'LY', 'Libyan Arab Jamahiriya', 1, NULL, '0', 0),
			(122, 'LI', 'Liechtenstein', 1, NULL, '0', 0),
			(123, 'LT', 'Lithuania', 1, NULL, '0', 0),
			(124, 'LU', 'Luxembourg', 1, NULL, '0', 0),
			(125, 'MO', 'Macau', 1, NULL, '0', 0),
			(126, 'MK', 'Macedonia', 1, NULL, '0', 0),
			(127, 'MG', 'Madagascar', 1, NULL, '0', 0),
			(128, 'MW', 'Malawi', 1, NULL, '0', 0),
			(129, 'MY', 'Malaysia', 1, NULL, '0', 0),
			(130, 'MV', 'Maldives', 1, NULL, '0', 0),
			(131, 'ML', 'Mali', 1, NULL, '0', 0),
			(132, 'MT', 'Malta', 1, NULL, '0', 0),
			(133, 'MH', 'Marshall Islands', 1, NULL, '0', 0),
			(134, 'MQ', 'Martinique', 1, NULL, '0', 0),
			(135, 'MR', 'Mauritania', 1, NULL, '0', 0),
			(136, 'MU', 'Mauritius', 1, NULL, '0', 0),
			(137, 'YT', 'Mayotte', 1, NULL, '0', 0),
			(138, 'MX', 'Mexico', 1, NULL, '0', 0),
			(139, 'FM', 'Micronesia', 1, NULL, '0', 0),
			(140, 'MD', 'Moldova, Republic of', 1, NULL, '0', 0),
			(141, 'MC', 'Monaco', 1, NULL, '0', 0),
			(142, 'MN', 'Mongolia', 1, NULL, '0', 0),
			(143, 'MS', 'Montserrat', 1, NULL, '0', 0),
			(144, 'MA', 'Morocco', 1, NULL, '0', 0),
			(145, 'MZ', 'Mozambique', 1, NULL, '0', 0),
			(146, 'MM', 'Myanmar', 1, NULL, '0', 0),
			(147, 'NA', 'Namibia', 1, NULL, '0', 0),
			(148, 'NR', 'Nauru', 1, NULL, '0', 0),
			(149, 'NP', 'Nepal', 1, NULL, '0', 0),
			(150, 'NL', 'Netherlands', 1, NULL, '0', 0),
			(151, 'AN', 'Netherlands Antilles', 1, NULL, '0', 0),
			(152, 'NC', 'New Caledonia', 1, NULL, '0', 0),
			(153, 'NZ', 'New Zealand', 1, NULL, '0', 0),
			(154, 'NI', 'Nicaragua', 1, NULL, '0', 0),
			(155, 'NE', 'Niger', 1, NULL, '0', 0),
			(156, 'NG', 'Nigeria', 1, NULL, '0', 0),
			(157, 'NU', 'Niue', 1, NULL, '0', 0),
			(158, 'NF', 'Norfolk Island', 1, NULL, '0', 0),
			(159, 'MP', 'Northern Mariana Islands', 1, NULL, '0', 0),
			(160, 'NO', 'Norway', 1, NULL, '0', 0),
			(161, 'OM', 'Oman', 1, NULL, '0', 0),
			(162, 'PK', 'Pakistan', 1, NULL, '0', 0),
			(163, 'PW', 'Palau', 1, NULL, '0', 0),
			(164, 'PA', 'Panama', 1, NULL, '0', 0),
			(165, 'PG', 'Papua New Guinea', 1, NULL, '0', 0),
			(166, 'PY', 'Paraguay', 1, NULL, '0', 0),
			(167, 'PE', 'Peru', 1, NULL, '0', 0),
			(168, 'PH', 'Philippines', 1, NULL, '0', 0),
			(169, 'PN', 'Pitcairn', 1, NULL, '0', 0),
			(170, 'PL', 'Poland', 1, NULL, '0', 0),
			(171, 'PT', 'Portugal', 1, NULL, '0', 0),
			(172, 'PR', 'Puerto Rico', 1, NULL, '0', 0),
			(173, 'QA', 'Qatar', 1, NULL, '0', 0),
			(174, 'RE', 'Reunion', 1, NULL, '0', 0),
			(175, 'RO', 'Romania', 1, NULL, '0', 0),
			(176, 'RU', 'Russian Federation', 1, NULL, '0', 0),
			(177, 'RW', 'Rwanda', 1, NULL, '0', 0),
			(178, 'LC', 'Saint Lucia', 1, NULL, '0', 0),
			(179, 'WS', 'Samoa', 1, NULL, '0', 0),
			(180, 'SM', 'San Marino', 1, NULL, '0', 0),
			(181, 'ST', 'Sao Tome and Principe', 1, NULL, '0', 0),
			(182, 'SA', 'Saudi Arabia', 1, NULL, '0', 0),
			(183, 'SN', 'Senegal', 1, NULL, '0', 0),
			(184, 'RS', 'Serbia', 1, NULL, '0', 0),
			(185, 'SC', 'Seychelles', 1, NULL, '0', 0),
			(186, 'SL', 'Sierra Leone', 1, NULL, '0', 0),
			(187, 'SG', 'Singapore', 1, NULL, '0', 0),
			(188, 'SK', 'Slovakia', 1, NULL, '0', 0),
			(189, 'SI', 'Slovenia', 1, NULL, '0', 0),
			(190, 'SB', 'Solomon Islands', 1, NULL, '0', 0),
			(191, 'SO', 'Somalia', 1, NULL, '0', 0),
			(192, 'ZA', 'South Africa', 1, NULL, '0', 0),
			(193, 'ES', 'Spain', 1, NULL, '0', 0),
			(194, 'LK', 'Sri Lanka', 1, NULL, '0', 0),
			(195, 'SH', 'St. Helena', 1, NULL, '0', 0),
			(196, 'KN', 'St. Kitts and Nevis', 1, NULL, '0', 0),
			(197, 'PM', 'St. Pierre and Miquelon', 1, NULL, '0', 0),
			(198, 'VC', 'St. Vincent and the Grenadines', 1, NULL, '0', 0),
			(199, 'SD', 'Sudan', 1, NULL, '0', 0),
			(200, 'SR', 'Suriname', 1, NULL, '0', 0),
			(201, 'SJ', 'Svalbard and Jan Mayen Islands', 1, NULL, '0', 0),
			(202, 'SZ', 'Swaziland', 1, NULL, '0', 0),
			(203, 'SE', 'Sweden', 1, NULL, '0', 0),
			(204, 'CH', 'Switzerland', 1, NULL, '0', 0),
			(205, 'SY', 'Syrian Arab Republic', 1, NULL, '0', 0),
			(206, 'TW', 'Taiwan', 1, NULL, '0', 0),
			(207, 'TJ', 'Tajikistan', 1, NULL, '0', 0),
			(208, 'TZ', 'Tanzania, United Republic of', 1, NULL, '0', 0),
			(209, 'TH', 'Thailand', 1, NULL, '0', 0),
			(210, 'TG', 'Togo', 1, NULL, '0', 0),
			(211, 'TK', 'Tokelau', 1, NULL, '0', 0),
			(212, 'TO', 'Tonga', 1, NULL, '0', 0),
			(213, 'TT', 'Trinidad and Tobago', 1, NULL, '0', 0),
			(214, 'TN', 'Tunisia', 1, NULL, '0', 0),
			(215, 'TR', 'Turkey', 1, NULL, '0', 0),
			(216, 'TM', 'Turkmenistan', 1, NULL, '0', 0),
			(217, 'TC', 'Turks and Caicos Islands', 1, NULL, '0', 0),
			(218, 'TV', 'Tuvalu', 1, NULL, '0', 0),
			(219, 'UG', 'Uganda', 1, NULL, '0', 0),
			(220, 'UA', 'Ukraine', 1, NULL, '0', 0),
			(221, 'AE', 'United Arab Emirates', 1, NULL, '0', 0),
			(222, 'GB', 'United Kingdom (GB)', 1, NULL, '23', 999),
			(224, 'US', 'United States', 1, NULL, '8', 998),
			(225, 'VI', 'United States Virgin Islands', 1, NULL, '0', 0),
			(226, 'UY', 'Uruguay', 1, NULL, '0', 0),
			(227, 'UZ', 'Uzbekistan', 1, NULL, '0', 0),
			(228, 'VU', 'Vanuatu', 1, NULL, '0', 0),
			(229, 'VA', 'Vatican City State', 1, NULL, '0', 0),
			(230, 'VE', 'Venezuela', 1, NULL, '0', 0),
			(231, 'VN', 'Vietnam', 1, NULL, '0', 0),
			(232, 'WF', 'Wallis And Futuna Islands', 1, NULL, '0', 0),
			(233, 'EH', 'Western Sahara', 1, NULL, '0', 0),
			(234, 'YE', 'Yemen', 1, NULL, '0', 0),
			(235, 'ZR', 'Zaire', 1, NULL, '0', 0),
			(236, 'ZM', 'Zambia', 1, NULL, '0', 0),
			(237, 'ZW', 'Zimbabwe', 1, NULL, '0', 0);
	  ");
	  
      $db->query("
			CREATE TABLE `invoices`(
				`id` int(11) NOT NULL  auto_increment , 
				`invid` int(11) NOT NULL  DEFAULT 0 , 
				`items` varchar(250) COLLATE utf8_general_ci NULL  , 
				`user_id` int(11) NOT NULL  DEFAULT 0 , 
				`tax` decimal(10,2) NOT NULL  DEFAULT 0.00 , 
				`totaltax` decimal(10,2) NOT NULL  DEFAULT 0.00 , 
				`coupon` decimal(10,2) NOT NULL  DEFAULT 0.00 , 
				`total` decimal(10,2) NOT NULL  DEFAULT 0.00 , 
				`originalprice` decimal(10,2) NOT NULL  DEFAULT 0.00 , 
				`totalprice` decimal(10,2) NOT NULL  DEFAULT 0.00 , 
				`currency` varchar(6) COLLATE utf8_general_ci NULL  , 
				`created` datetime NULL  DEFAULT '0000-00-00 00:00:00' , 
				PRIMARY KEY (`id`) 
			) ENGINE=MyISAM DEFAULT CHARSET='utf8' COLLATE='utf8_general_ci';
	  ");

      $db->query("
			ALTER TABLE `extras` 
				ADD COLUMN `tax` decimal(10,2)   NOT NULL DEFAULT 0.00 after `user_id` , 
				ADD COLUMN `totaltax` decimal(10,2)   NOT NULL DEFAULT 0.00 after `tax` , 
				CHANGE `coupon` `coupon` decimal(10,2)   NOT NULL DEFAULT 0.00 after `totaltax` , 
				ADD COLUMN `total` decimal(10,2)   NOT NULL DEFAULT 0.00 after `coupon` , 
				ADD COLUMN `originalprice` decimal(10,2)   NOT NULL DEFAULT 0.00 after `total` , 
				ADD COLUMN `totalprice` decimal(10,2)   NOT NULL DEFAULT 0.00 after `originalprice` , 
				ADD COLUMN `created` datetime   NOT NULL DEFAULT '0000-00-00 00:00:00' after `totalprice` ;
	  ");

      $db->query("
			ALTER TABLE `settings` 
				ADD COLUMN `tax` tinyint(1)   NOT NULL DEFAULT 0 after `theme` , 
				ADD COLUMN `psize` varchar(10)  COLLATE utf8_general_ci NULL after `tax` , 
				ADD COLUMN `inv_note` text  COLLATE utf8_general_ci NULL after `psize` , 
				ADD COLUMN `inv_info` text  COLLATE utf8_general_ci NULL after `inv_note` , 
				CHANGE `lang` `lang` varchar(10)  COLLATE utf8_general_ci NULL after `inv_info` ;
	  ");

      $db->query("
			ALTER TABLE `transactions` 
				ADD COLUMN `coupon` decimal(9,2)   NOT NULL DEFAULT 0.00 after `mc_fee` , 
				ADD COLUMN `tax` decimal(9,2)   NOT NULL DEFAULT 0.00 after `coupon`;
	  ");

      $db->query("
			ALTER TABLE `users` 
				ADD COLUMN `address` varchar(150)  COLLATE utf8_general_ci NULL after `avatar` , 
				ADD COLUMN `city` varchar(100)  COLLATE utf8_general_ci NULL after `address` , 
				ADD COLUMN `state` varchar(100)  COLLATE utf8_general_ci NULL after `city` , 
				ADD COLUMN `zip` varchar(20)  COLLATE utf8_general_ci NULL after `state` , 
				ADD COLUMN `country` varchar(4)  COLLATE utf8_general_ci NULL after `zip`;
	  ");
	  
      $db->query("
			INSERT INTO `gateways` (`id`, `name`, `displayname`, `dir`, `demo`, `extra_txt`, `extra_txt2`, `extra_txt3`, `extra`, `extra2`, `extra3`, `info`, `active`) VALUES
			(5, 'anet', 'Authorize Net', 'anet', 1, 'API Login Id', 'MD5 Hash Key', 'Transaction Key', '9KDgMm2mw46V', '', '5wek3X3DX5e39YAQ', '&lt;p&gt;&lt;a href=&quot;http://www.authorize.net/&quot; title=&quot;http://www.authorize.net//&quot; rel=&quot;nofollow&quot;&gt;Click here to setup an account with Authorize.Net&lt;/a&gt;&lt;/p&gt;\r\n			&lt;p&gt;&lt;strong&gt;Gateway Name&lt;/strong&gt; - Enter the name of the payment provider here.&lt;/p&gt;\r\n			&lt;p&gt;&lt;strong&gt;Active&lt;/strong&gt; - Select Yes to make this payment provider active. &lt;br/&gt;\r\n			  If this box is not checked, the payment provider will not show up in the payment provider list during checkout.&lt;/p&gt;\r\n			&lt;p&gt;&lt;strong&gt;Set Live Mode&lt;/strong&gt; - If you would like to test the payment provider settings, please select No. &lt;/p&gt;\r\n			&lt;p&gt;&lt;strong&gt;Login ID&lt;/strong&gt; - To obtain your API Login ID:&lt;/p&gt;\r\n			&lt;ol type=&quot;1&quot;&gt;\r\n			  &lt;li&gt; Log into the Merchant Interface at &lt;a href=&quot;https://secure.authorize.net&quot; target=&quot;_blank&quot;&gt;https://secure.authorize.net&lt;/a&gt;&lt;/li&gt;\r\n			  &lt;li&gt; Select Settings under Account in the main menu on the left &lt;/li&gt;\r\n			  &lt;li&gt; Click API Login ID and Transaction Key in the Security Settings section &lt;/li&gt;\r\n			  &lt;li&gt; If you have not already obtained an API Login ID and Transaction Key for your account,&lt;br/&gt;\r\n				you will need to enter the secret answer to the secret question you configured at account activation. &lt;/li&gt;\r\n			  &lt;li&gt; Click Submit. &lt;/li&gt;\r\n			&lt;/ol&gt;\r\n			&lt;p&gt;&lt;strong&gt;MD5 Hash&lt;/strong&gt; - To obtain your MD5 Hash:&lt;/p&gt;\r\n			&lt;ol type=&quot;1&quot;&gt;\r\n			  &lt;li&gt; Log into the Merchant Interface at &lt;a href=&quot;https://secure.authorize.net&quot; target=&quot;_blank&quot;&gt;https://secure.authorize.net&lt;/a&gt;&lt;/li&gt;\r\n			  &lt;li&gt; Select Settings under Account in the main menu on the left &lt;/li&gt;\r\n			  &lt;li&gt; Click MD5 Hash in the Security Settings section &lt;/li&gt;\r\n			  &lt;li&gt;Enter a secret word, phrase, or value and remember this.&lt;/li&gt;\r\n			  &lt;li&gt; Click Submit. &lt;/li&gt;\r\n			&lt;/ol&gt;\r\n			&lt;strong&gt;Transaction Key&lt;/strong&gt; - To obtain a Transaction Key:\r\n			&lt;ol type=&quot;1&quot;&gt;\r\n			  &lt;li&gt; Log on to the Merchant Interface at &lt;a href=&quot;https://secure.authorize.net&quot; target=&quot;_blank&quot;&gt;https://secure.authorize.net&lt;/a&gt;&lt;/li&gt;\r\n			  &lt;li&gt; Select Settings under Account in the main menu on the left &lt;/li&gt;\r\n			  &lt;li&gt; Click API Login ID and Transaction Key in the Security Settings section &lt;/li&gt;\r\n			  &lt;li&gt; Enter the secret answer to the secret question you configured when you activated your user account &lt;/li&gt;\r\n			  &lt;li&gt; Click Submit &lt;/li&gt;\r\n			&lt;/ol&gt;\r\n			&lt;p&gt;The Transaction Key for your account is displayed on a confirmation page.&lt;/p&gt;\r\n			&lt;p&gt;&lt;strong&gt;IPN Url&lt;/strong&gt; - This option it\\&#039;s not being used.&lt;/p&gt;', 1);
	  ");

	  
	  $setdata['theme'] = 'master';
	  $setdata['version'] = '3.10';
      $db->update("settings", $setdata);

      redirect_to("upgrade.php?update=done");
  }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>DDP Upgrade</title>
<style type="text/css">
@import url(http://fonts.googleapis.com/css?family=Raleway:400,100,300,600,700);
body {
  font-family: Raleway, Arial, Helvetica, sans-serif;
  font-size: 14px;
  line-height: 1.3em;
  color: #FFF;
  background-color: #222;
  font-weight: 300;
  margin: 0;
  padding: 0
}
#wrap {
  width: 800px;
  margin-top: 150px;
  margin-right: auto;
  margin-left: auto;
  background-color: #862b27;
  box-shadow: 2px 2px 2px 2px rgba(0,0,0,0.1);
  border: 2px solid #270d0c;
  border-radius: 3px
}
header {
  background-color: #5e1f1c;
  font-size: 26px;
  font-weight: 200;
  padding: 35px
}
.line {
  height: 2px;
  background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.5) 50%, rgba(255,255,255,0) 100%)
}
.line2 {
  position: absolute;
  left: 200px;
  height: 360px;
  width: 2px;
  background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,0.5) 50%, rgba(255,255,255,0) 100%);
  display: block
}
#content {
  position: relative;
  padding: 45px 20px
}
#content .left {
  float: left;
  width: 200px;
  height: 400px;
  background-image: url(assets/installer.png);
  background-repeat: no-repeat;
  background-position: 10px center
}
#content .right {
  margin-left: 200px
}
h4 {
  font-size: 18px;
  font-weight: 300;
  margin: 0 0 40px;
  padding: 0
}
p.info {
  background-color: #270d0c;
  border-radius: 3px;
  box-shadow: 1px 1px 1px 1px rgba(0,0,0,0.1);
  padding: 10px
}
p.info span {
  display: block;
  float: left;
  padding: 10px;
  background: rgba(255,255,255,0.1);
  margin-left: -10px;
  margin-top: -10px;
  border-radius: 3px 0 0 3px;
  margin-right: 5px;
  border-right: 1px solid rgba(255,255,255,0.05)
}
footer {
  background-color: #270d0c;
  padding: 20px
}
form {
  display: inline-block;
  float: right;
  margin: 0;
  padding: 0
}
.button {
  border: 2px solid #9f322d;
  font-family: Raleway, Arial, Helvetica, sans-serif;
  font-size: 14px;
  color: #FFF;
  background-color: #270d0c;
  text-align: center;
  cursor: pointer;
  font-weight: 500;
  -webkit-transition: all .35s ease;
  -moz-transition: all .35s ease;
  -o-transition: all .35s ease;
  transition: all .35s ease;
  outline: none;
  border-radius: 2px;
  margin: 0;
  padding: 5px 20px
}
.button:hover {
  background-color: #9f322d;
  -webkit-transition: all .55s ease;
  -moz-transition: all .55s ease;
  -o-transition: all .35s ease;
  transition: all .55s ease;
  outline: none
}
.clear {
  font-size: 0;
  line-height: 0;
  clear: both;
  height: 0
}
.clearfix:after {
  content: ".";
  display: block;
  height: 0;
  clear: both;
  visibility: hidden;
}
a {
  text-decoration: none;
  float: right
}
</style>
</head>
<body>
<div id="wrap">
  <header>Welcome to DDP Upgrade Wizard</header>
  <div class="line"></div>
  <div id="content">
    <div class="left">
      <div class="line2"></div>
    </div>
    <div class="right">
      <h4>Digital Downloads Pro Upgrade v3.10</h4>
      <?php if(isset($_GET['update']) && $_GET['update'] == "done"):?>
      <p class="info"><span>Success!</span>Installation Completed. Please delete upgrade.php</p>
      <?php else:?>
      <?php if($ver->version != 3.00):?>
      <p class="info"><span>Warning!</span>You need at least DDP v2.3.00 in order to continue.</p>
      <?php else:?>
      <p class="info"><span>Warning!</span>Please make sure you have performed database backup!!!</p>
      <p style="margin-top:60px">When ready click Install button.</p>
      <p><span>Please be patient, and<strong> DO NOT</strong> Refresh your browser.<br>
        This process might take a while</span>.</p>
      <?php endif;?>
      <?php endif;?>
    </div>
  </div>
  <div class="clear"></div>
  <footer class="clearfix"> <small>current <b>ddp v.<?php echo $ver->version;?></b></small>
    <?php if(isset($_GET['update']) && $_GET['update'] == "done"):?>
    <a href="admin/index.php" class="button">Back to admin panel</a>
    <?php else:?>
    <form method="post" name="upgrade_form">
      <?php if($ver->version == 3.00):?>
      <input name="submit" type="submit" class="button" value="Upgrade DDP" id="submit" />
      <?php endif;?>
    </form>
    <?php endif;?>
  </footer>
</div>
</body>
</html>