<?php
  /**
   * Crumbs Navigation
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2014
   * @version $Id: footer.php, v3.00 2014-05-08 10:12:05 gewa Exp $
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php
  $sname = $_SERVER["SCRIPT_NAME"];
  $pages = array(
      'account',
      'activate',
      'category',
      'checkout',
      'content',
      'item',
      'login',
      'profile',
      'register',
      'search',
      'summary',
      'tags',
      'view',
      );
  $regexp = '#' . implode('|', $pages) . '#';
  $pages = preg_match($regexp, $sname, $matches) ? $matches[0] : '';
  $html = '';

  switch ($pages) {

      case "account":
          $html =  Lang::$word->_UA_MYACC;
          break;

      case "activate":
          print Lang::$word->_UA_TITLE3;
          break;

      case "category":
          $html = ($row) ? $row->name : "";
          break;

      case "checkout":
          $html = Lang::$word->CKO_TITLE;
          break;

      case "content":
          $html = ($row) ? $row->title : "";
          break;

      case "item":
          $html = ($row) ? $row->title : "";
          break;

      case "login":
          $html = Lang::$word->_UA_TITLE;
          break;

      case "profile":
          $html = Lang::$word->_UA_TITLE4;
          break;

      case "register":
          $html = Lang::$word->_UA_TITLE2;
          break;

      case "search":
          $html = Lang::$word->FSRC_TITLE;
          break;

      case "summary":
          $html = Lang::$word->SMY_TITLE;
          break;

      case "tags":
          $html = ($row) ? $row->tag : "";
          break;

      case "view":
          $html = Lang::$word->_UA_TITLE5;
          break;
		  
      default:
		  $html = '';
          break;

  }
  
  print '<div class="active section">' . $html . '</div>';
?> 