<?php
  /**
   * View Item
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2014
   * @version $Id: account.php, v3.00 2014-07-10 10:12:05 gewa Exp $
   */
  define("_VALID_PHP", true);
  require_once("init.php");
  
  if (!$user->logged_in)
      redirect_to("home");
	  
  $row = $item->getFileToDownload();
?>
<?php require_once (THEMEDIR . "/view.tpl.php");?>