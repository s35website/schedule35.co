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
?>
<?php switch(Filter::$action): case "edit": ?>
<?php include("menus/edit.php");?>
<?php break;?>

<?php default: ?>
<?php include("menus/default.php");?>
<?php break;?>

<?php endswitch;?>