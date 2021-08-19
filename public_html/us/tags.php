<?php
  /**
   * Tags
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2014
   * @version $Id: tags.php, v3.00 2014-07-10 10:12:05 gewa Exp $
   */
  define("_VALID_PHP", true);
  require_once("init.php");
  
  $tagrow = $item->rendertProducstByTags();
  $row = $content->getTagName();
?>
<!-- Start Tags-->
<?php require_once (THEMEDIR . "/tags.tpl.php");?>
<!-- End Tags/-->
