<?php
	/**
	* Index
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: index.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");

	$row = $content->getAllBlogCat();

	$pagename = "Blog";

	/** @var $db Database */
	//Pagination settings
	require_once  (__DIR__ . '/lib/paging/PagingSettings.php');
	require_once  (__DIR__ . '/lib/paging/Counter.php');
	$scrollSettings = \paging\PagingSettings::fromJson($db->loadCustomSettings(\paging\PagingSettings::SETTINGS_KEY));


	$page = get('page', '1');
	if (!is_numeric($page)) $page = 1;
	$perPage = get('perPage', $scrollSettings->perPage);

	/** @var $item Products */
	$newsCount = $content->countBlog("WHERE active = 1");
	$counter = new \paging\Counter($newsCount, $page, $perPage);
	$buttons = $counter->getButtons();

	$blogrow = $content->getBlogPage($page, $perPage);

	require_once (THEMEDIR . "/blog.tpl.php");

?>