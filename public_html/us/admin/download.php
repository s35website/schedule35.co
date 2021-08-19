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
	if (isset($_GET['fid']) && $user->logged_in) {
	
		$fid = intval($_GET['fid']);
		$frow = $db->first("SELECT alias, name FROM " . Products::fTable . " WHERE id = '" . intval($fid) . "'");
		
		if ($frow) {
			$fext = strtolower(substr(strrchr($frow->name, ".") , 1));
			if ($user->is_Admin) {
				downloadFile(BASE_DIR . $frow->name, $frow->name);
			}
		
			downloadFile(BASE_DIR . $frow->name, $frow->name);
		}
		else {
			redirect_to(SITEURL . "/admin/index.php?do=products&action=edit&id=" . $fid . "&msg3");
		}
	}
	else {
		redirect_to(SITEURL . "/admin/index.php?do=products&action=edit&id=" . $fid . "&msg5");
		die();
	}
?>
