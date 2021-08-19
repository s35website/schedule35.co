<?php
  /**
   * Download
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2010
   * @version $Id: download.php, v2.00 2011-04-20 10:12:05 gewa Exp $ 
   */
  define("_VALID_PHP", true);
  
  require_once("init.php");
  define('BASE_DIR', $core->file_dir);
  
  $allowed_ext = array(
		'zip' => 'application/zip', 
		'rar' => 'application/x-rar-compressed', 
		'pdf' => 'application/pdf', 
		'doc' => 'application/msword', 
		'xls' => 'application/vnd.ms-excel', 
		'ppt' => 'application/vnd.ms-powerpoint', 
		'exe' => 'application/octet-stream', 
		'gif' => 'image/gif', 
		'png' => 'image/png', 
		'jpg' => 'image/jpeg', 
		'jpeg' => 'image/jpeg', 
		'mp3' => 'audio/mpeg', 
		'wav' => 'audio/x-wav', 
		'mpeg' => 'video/mpeg', 
		'mpg' => 'video/mpeg', 
		'mpe' => 'video/mpeg', 
		'mov' => 'video/quicktime', 
		'avi' => 'video/x-msvideo'
  );
  
  set_time_limit(0);
  
  if (ini_get('zlib.output_compression')) {
      ini_set('zlib.output_compression', 'Off');
  }
?>
<?php
  if (isset($_GET['fid'])) {
      $fid = intval($_GET['fid']);
      
      $row = $db->first("SELECT f.alias, f.name, p.id as pid, p.file_id, p.price, p.active" 
	  . " \n FROM " . Products::pTable . " as p" 
	  . " \n LEFT JOIN " . Products::fTable . " as f ON f.id = p.file_id " 
	  . " \n WHERE p.id = '" . intval($fid) . "'" 
	  . " \n AND p.price = 0" 
	  . " \n AND p.active = 1");
      
      if ($row) {
          $fext = strtolower(substr(strrchr($row->name, "."), 1));

          if (!is_file(BASE_DIR . $row->name)) {
              redirect_to(SITEURL . "/index.php?msg=1");
              die();
          }

          if (!array_key_exists($fext, $allowed_ext)) {
              redirect_to(SITEURL . "/index.php?msg=2");
              die();
          }

          if ($core->free_allowed == 0 && !$user->logged_in) {
              redirect_to(SITEURL . "/index.php?msg=3");
              die();
          }

          downloadFile(BASE_DIR . $row->name, $row->name);

      } else {
          redirect_to(SITEURL . "/index.php");
      }
  } elseif (isset($_GET['pid']) && $user->logged_in) {
      $pid = intval($_GET['pid']);
      
      $row = $db->first("SELECT t.*, t.id as tid, COUNT(t.item_qty) as count, t.active as tactive, t.status as tstatus," 
	  . " \n p.id as pid, p.expiry, p.file_id as fid, p.price as prodprice," 
	  . " \n u.id as uid" 
	  . " \n FROM " . Products::tTable . " as t" 
	  . " \n LEFT JOIN " . Products::pTable . " as p ON t.pid = p.id" 
	  . " \n LEFT JOIN " . Users::uTable . " as u ON t.uid = u.id" 
	  . " \n WHERE t.pid = '" .  intval($pid) . "'" 
	  . " \n AND t.status = 1 AND t.active = 1" 
	  . " \n AND p.active = 1 AND t.uid = '" . $user->uid . "'" 
	  . " \n GROUP BY p.id");
      
      if ($row) {
          if ($row->expiry != 0 && $row->tactive == 1) {
              if (substr_count($row->expiry, 'D') != 0) {
                  $expiry = substr($row->expiry, 1) * $row->count;

                  $current_time = time();
                  $expiry_time = $row->count + ($expiry * 24 * 60 * 60);
                  if ($current_time > $expiry_time) {
                      $expired = true;
                  }
              } else {
                  if ($row->downloads >= ($row->expiry * $row->count)) {
                      $expired = true;
                  }
              }
          }
		  
          if (isset($expired)) {
              redirect_to(SITEURL . "/account.php?msg=4");
              die();
          }
          
		  $frow = $db->first("SELECT alias, name FROM " . Products::fTable . " WHERE id = '" . (int)$row->fid . "'");
          $fext = strtolower(substr(strrchr($frow->name, "."), 1));

          if (!is_file(BASE_DIR . $frow->name)) {
              redirect_to(SITEURL . "/index.php?msg=1");
              die();
          }

          if (!array_key_exists($fext, $allowed_ext)) {
              redirect_to(SITEURL . "/index.php?msg=2");
              die();
          }
		  
		  downloadFile(BASE_DIR . $frow->name, $frow->name, true, $row->tid);
      } else {
          redirect_to(SITEURL . "/index.php");
      }
  } else {
      redirect_to(SITEURL . "/index.php?msg=5");
      die();
  }
?>
