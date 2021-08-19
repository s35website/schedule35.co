<?php
  /**
   * Init
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2014
   * @version $Id: init.php, v3.00 2014-06-05 10:12:05 gewa Exp $
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php //error_reporting(E_ALL);
	
	if (substr(PHP_OS, 0, 3) == "WIN") {
		$BASEPATH = str_replace("admin\\init.php", "", realpath(__FILE__));
	} else {
		$BASEPATH = str_replace("admin/init.php", "", realpath(__FILE__));
	}
	define("BASEPATH", $BASEPATH);
	
	$configFile = BASEPATH . "lib/config.ini.php";
	if (file_exists($configFile)) {
		require_once($configFile);
	} else {
		header("Location: setup/");
	}
	
	//include_once(BASEPATH . "language.php");
	require_once(BASEPATH . "lib/class_db.php");
	
	require_once(BASEPATH . "lib/class_registry.php");
	Registry::set('Database',new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE));
	$db = Registry::get("Database");
	$db->connect();
	
	
	//Include Functions
	require_once(BASEPATH . "lib/functions.php");
	require_once(BASEPATH . "lib/fn_seo.php");
	
	require_once(BASEPATH . "lib/class_filter.php");
	$request = new Filter();  
	
	//Start Core Class 
	require_once(BASEPATH . "lib/class_core.php");
	Registry::set('Core',new Core());
	$core = Registry::get("Core");
	
	//Start Language Class 
	require_once(BASEPATH . "lib/class_language.php");
	Registry::set('Lang',new Lang());
	$lang = Registry::get("Lang");
	
	//StartUser Class 
	require_once(BASEPATH . "lib/class_user.php");
	Registry::set('Users',new Users());
	$user = Registry::get("Users");
	
	//Load Content Class
	require_once(BASEPATH . "lib/class_content.php");
	Registry::set('Content',new Content());
	$content = Registry::get("Content");
	
	//Load Product Class
	require_once(BASEPATH . "lib/class_products.php");
	Registry::set('Products',new Products());
	$item = Registry::get("Products");
	
	//Load Analyze Class
	require_once(BASEPATH . "lib/class_analyze.php");
	Registry::set('Analyze',new Analyze());
	$analytics = Registry::get("Analyze");
	
	//Start Uploader Class 
	require_once(BASEPATH . "lib/class_fm.php");
	Registry::set('FM',new FM());
	
	//Start Paginator Class 
	require_once(BASEPATH . "lib/class_paginate.php");
	$pager = Paginator::instance();
	
	if (isset($_SERVER['HTTPS'])) {
	  $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
	} else {
	  $protocol = 'http';
	}
	
	$dir = (Registry::get("Core")->site_dir) ? '/' . Registry::get("Core")->site_dir : '';
	$url = preg_replace("#/+#", "/", $_SERVER['HTTP_HOST'] . $dir);
	$site_url = $protocol . "://" . $url;
	
	define("SITEURL", $site_url);
	define("ADMINURL", $site_url."/admin");
	define("UPLOADS", BASEPATH . "uploads/");
	define("UPLOADURL", SITEURL . "/uploads/");
	define("PRODIMGPATH", BASEPATH . "uploads/prod_images/");
	define("PRODIMGURL", SITEURL . "/uploads/prod_images/");
	define("PRODGALPATH", BASEPATH . "uploads/prod_gallery/");
	define("PRODGALURL", SITEURL . "/uploads/prod_gallery/");
	
	define("THEMEDIR", BASEPATH . "themes/" . $core->theme);
	define("THEMEURL", SITEURL . "/themes/" . $core->theme);
	define("THEME", BASEPATH . "themes/" . $core->theme);
	
	setlocale(LC_TIME, $core->setLocale());
	
	
	/** @var $db Database */
	//Pagination settings
	require_once  (BASEPATH . "lib/paging/PagingSettings.php");
	require_once  (BASEPATH . "lib/paging/Counter.php");
	
	//Infinite scroll settings
	$scrollSettings = \paging\PagingSettings::fromJson($db->loadCustomSettings(\paging\PagingSettings::SETTINGS_KEY));

?>