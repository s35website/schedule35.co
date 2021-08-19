<?php
	/**
	* Product
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: item.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");

	$row = $item->renderProduct();
	$galrow = $item->getGallery($row->pid);

	$pagename = $row->title;
	$pagenameModifier = "Shop";
	$productVariants = $item->getProductVariants($row->pid);
?>
<?php require_once (THEMEDIR . "/item.tpl.php");?>
