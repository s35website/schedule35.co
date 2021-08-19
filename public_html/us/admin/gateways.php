<?php
	/**
	* Main
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	*/
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
	
	if (!$user->is_Admin()) {
		$_SESSION["isAdmin"] = '<ul class="error list"><li><i class="fa fa-exclamation-triangle"></i>Oops! Looks like you do not have permission to access this part of the website.</li>
		</ul>';
		redirect_to("index");
	}
?>
<?php switch(Filter::$action): case "edit": ?>
<?php include("gateways/edit.php");?>
<?php break;?>

<?php default: ?>
<?php include("gateways/default.php");?>
<?php break;?>

<?php endswitch;?>