<?php
	/**
	* Index
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: shop.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");

	$row = $content->getAllCategories();

	$pagename = "Shop";

	if (isset($_GET['sort'])) {
		$sort = sanitize($_GET['sort'],100);
	}
	else {
		$sort = "recent";
	}

	/** @var $db Database */
	//Pagination settings
	require_once  (__DIR__ . '/lib/paging/PagingSettings.php');
	require_once  (__DIR__ . '/lib/paging/Counter.php');
	$scrollSettings = \paging\PagingSettings::fromJson($db->loadCustomSettings(\paging\PagingSettings::SETTINGS_KEY));


	$sort = get('sort', 'featured');
	$page = get('page', '1');
	if (!is_numeric($page)) $page = 1;
	$perPage = get('perPage', $scrollSettings->perPage);

	/** @var $item Products */
	$productCount = $item->countProducts("WHERE active = 1");
	$counter = new \paging\Counter($productCount, $page, $perPage);
	$buttons = $counter->getButtons();

	require_once (THEMEDIR . "/shop.tpl.php");

?>