<?php
  /**
   * Logout
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2014
   * @version $Id: logout.php, v3.00 2014-04-20 10:12:05 gewa Exp $
   */
  define("_VALID_PHP", true);
  
  require_once("init.php");
?>
<?php
if ($user->logged_in) {
	$user->logout();
}
redirect_to("home");
?>