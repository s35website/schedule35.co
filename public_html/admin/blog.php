<?php
  /**
   * blog.php
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2014
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Filter::$action): case "edit": ?>
<?php include("blog/edit.php");?>
<?php break;?>

<?php case"add": ?>
<?php include("blog/add.php");?>
<?php break;?>

<?php default: ?>
<?php include("blog/default.php");?>
<?php break;?>

<?php endswitch;?>