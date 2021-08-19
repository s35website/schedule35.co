<?php
	/**
	 * User
	 *
	 * @package FBC Studio
	 * @author fbcstudio.com
	 * @copyright 2010
	 * @version $Id: user.php, v2.00 2011-04-20 10:12:05 gewa Exp $
	 */
	define("_VALID_PHP", true);
	require_once("../init.php");
?>
<?php

/* Update Notifications */
if (isset($_POST['addComment'])):
	$content->addComment();
endif;


if (isset($_POST['removeComment'])):
	$content->removeComment();
endif;

?>
