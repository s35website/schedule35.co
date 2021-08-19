<?php
  /**
   * news.php
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2014
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Filter::$action): case "edit": ?>
<?php include("comments/edit.php");?>
<?php break;?>

<?php case"add": ?>
<?php include("comments/add.php");?>
<?php break;?>

<?php case"edit": ?>
<?php include("comments/edit.php");?>
<?php break;?>

<?php default: ?>
<?php include("comments/default.php");?>
<?php break;?>

<?php endswitch;?>