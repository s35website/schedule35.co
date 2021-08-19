<?php
	/**
	 * Controller
	 *
	 * @package FBC Studio
	 * @author fbcstudio.com
	 * @copyright 2010
	 * @version $Id: controller.php, v2.00 2011-07-10 10:12:05 gewa Exp $
	 */
	define("_VALID_PHP", true);

	require_once ("init.php");
	if (!$user->hasAdminAccess())
		redirect_to("redirect_to('login');");

	$delete = (isset($_POST['delete']))	? $_POST['delete'] : null;

	$checkoption = (isset($_POST['checkoption']))	? $_POST['checkoption'] : null;
?>
<?php


	switch ($checkoption):
	
		/* == Update Box == */
		case "updateFeature":
		
		$data['feat'] = cleanOut($_POST['val']);
		$result = $db->update(Products::pTable, $data, "id=" . Filter::$id);
		
		if ($result):
			$json['type'] = 'success';
			$json['title'] = Lang::$word->SUCCESS;
			$json['message'] = Lang::$word->CMT_UPDATED;
		else:
			$json['type'] = 'warning';
			$json['title'] = Lang::$word->ALERT;
			$json['message'] = Lang::$word->NOPROCCESS;
		endif;
		print json_encode($json);
	
	endswitch;



	switch ($delete):
	
		/* == Delete Page == */
		case "deletePage":
			$res	 = $db->delete(Content::pTable, "id=" . Filter::$id);
			$title = sanitize($_POST['title']);
			if ($res):
				$json['type']	= 'success';
				$json['title']	 = Lang::$word->SUCCESS;
				$json['message'] = str_replace("-ITEM-", $title, Lang::$word->PAG_DELETED);
			else:
				$json['type']	= 'warning';
				$json['title']	 = Lang::$word->ALERT;
				$json['message'] = Lang::$word->NOPROCCESS;
			endif;
	
			print json_encode($json);
			break;
			
		/* == Delete Article == */
		case "deleteArticle":
			$res	 = $db->delete(Content::bTable, "id=" . Filter::$id);
			$title = sanitize($_POST['title']);
			if ($res):
				$json['type']	= 'success';
				$json['title']	 = Lang::$word->SUCCESS;
				$json['message'] = str_replace("-ITEM-", $title, Lang::$word->PAG_DELETED);
			else:
				$json['type']	= 'warning';
				$json['title']	 = Lang::$word->ALERT;
				$json['message'] = Lang::$word->NOPROCCESS;
			endif;
	
			print json_encode($json);
			break;
			
		/* == Delete Comment == */
		case "deleteComment":
			$res	 = $db->delete(Content::cmTable, "id=" . Filter::$id);
			$title = sanitize($_POST['title']);
			if ($res):
				$json['type']	= 'success';
				$json['title']	 = Lang::$word->SUCCESS;
				$json['message'] = str_replace("-ITEM-", $title, Lang::$word->PAG_DELETED);
			else:
				$json['type']	= 'warning';
				$json['title']	 = Lang::$word->ALERT;
				$json['message'] = Lang::$word->NOPROCCESS;
			endif;
	
			print json_encode($json);
			break;
	
		/* == Delete Coupon == */
		case "deleteCoupon":
			$res	 = $db->delete(Content::cpTable, "id=" . Filter::$id);
			$title = sanitize($_POST['title']);
			if ($res):
				$json['type']	= 'success';
				$json['title']	 = Lang::$word->SUCCESS;
				$json['message'] = str_replace("-ITEM-", $title, Lang::$word->CPN_DELETED);
			else:
				$json['type']	= 'warning';
				$json['title']	 = Lang::$word->ALERT;
				$json['message'] = Lang::$word->NOPROCCESS;
			endif;
	
			print json_encode($json);
			break;
	
		/* == Delete F.A.Q. == */
		case "deleteFaq":
			$res	 = $db->delete(Content::fqTable, "id=" . Filter::$id);
			$title = sanitize($_POST['title']);
			if ($res):
				$json['type']	= 'success';
				$json['title']	 = Lang::$word->SUCCESS;
				$json['message'] = str_replace("-ITEM-", $title, Lang::$word->FAQ_DELETED);
			else:
				$json['type']	= 'warning';
				$json['title']	 = Lang::$word->ALERT;
				$json['message'] = Lang::$word->NOPROCCESS;
			endif;
	
			print json_encode($json);
			break;
	
		/* == Delete User == */
		case "deleteUser":
			if (Filter::$id == 1):
				$json['type']	= 'error';
				$json['title']	 = Lang::$word->_ERROR;
				$json['message'] = Lang::$word->USR_DELUSER_ERR1;
			else:
				if ($avatar = getValueById("avatar", Users::uTable, Filter::$id)):
					unlink(UPLOADS . 'avatars/' . $avatar);
				endif;
				$db->delete(Users::uTable, "id=" . Filter::$id);
	
				$title = sanitize($_POST['title']);
				if ($db->affected()):
					$json['type']	= 'success';
					$json['title']	 = Lang::$word->_SUCCESS;
					$json['message'] = str_replace("-ITEM-", $title, Lang::$word->USR_DELUSER_OK);
				else:
					$json['type']	= 'warning';
					$json['title']	 = Lang::$word->_ALERT;
					$json['message'] = Lang::$word->NOPROCCESS;
				endif;
			endif;
			print json_encode($json);
			break;
	
		/* == Delete Product == */
		case "deleteProduct":
			if ($thumb = getValueById("thumb", Products::pTable, Filter::$id)):
				unlink(UPLOADS . "prod_images/" . $thumb);
			endif;
	
			$res = $db->delete(Products::pTable, "id=" . Filter::$id);
			$db->delete(Content::cmTable, "pid=" . Filter::$id);
	
			$title = sanitize($_POST['title']);
	
			if ($getphotos = $db->fetch_all("SELECT thumb FROM " . Products::phTable . " WHERE pid = " . Filter::$id)):
				foreach ($getphotos as $prow):
					@unlink(UPLOADS . '/prod_gallery/' . $prow->thumb);
				endforeach;
			endif;
	
			$db->delete(Products::phTable, "pid=" . Filter::$id);
			$db->delete(Products::pvTable, "pid=" . Filter::$id);
	
			//Remove index
			global $searcher;
			$productId = (int)Filter::$id;
			if (!$searcher->removeIndex($productId)) {
				//todo: Something went wrong.
			}
	
	
			if ($res):
				$json['type']	= 'success';
				$json['title']	 = Lang::$word->SUCCESS;
				$json['message'] = str_replace("-ITEM-", $title, Lang::$word->PRD_DELETED);
			else:
				$json['type']	= 'warning';
				$json['title']	 = Lang::$word->ALERT;
				$json['message'] = Lang::$word->NOPROCCESS;
			endif;
	
			print json_encode($json);
			break;
	
		/* == Delete Gallery Image == */
		case "deleteGalleryImage":
			if ($thumb = getValueById("thumb", Products::phTable, Filter::$id)):
				unlink(UPLOADS . "prod_gallery/" . $thumb);
			endif;
	
			$res	 = $db->delete(Products::phTable, "id=" . Filter::$id);
			$title = sanitize($_POST['title']);
			if ($res):
				$json['type']	= 'success';
				$json['title']	 = Lang::$word->SUCCESS;
				$json['message'] = str_replace("-ITEM-", $title, Lang::$word->GAL_DELETED);
			else:
				$json['type']	= 'warning';
				$json['title']	 = Lang::$word->ALERT;
				$json['message'] = Lang::$word->NOPROCCESS;
			endif;
	
			print json_encode($json);
			break;
	
		/* == Delete Transaction == */
		case "deleteTransaction":
			$res	 = $db->delete(Products::tTable, "id=" . Filter::$id);
			$title = sanitize($_POST['title']);
	
			if ($res):
				$json['type']	= 'success';
				$json['title']	 = Lang::$word->SUCCESS;
				$json['message'] = str_replace("-ITEM-", $title, Lang::$word->TXN_DELETED);
			else:
				$json['type']	= 'warning';
				$json['title']	 = Lang::$word->ALERT;
				$json['message'] = Lang::$word->NOPROCCESS;
			endif;
	
			print json_encode($json);
			break;
	
		/* == Delete Invoice == */
		case "deleteInvoice":
			$res	 = $db->delete(Content::inTable, "id=" . Filter::$id);
			$title = sanitize($_POST['title']);

			if ($res):
				$json['type']	= 'success';
				$json['title']	 = Lang::$word->SUCCESS;
				$json['message'] = str_replace("-ITEM-", $title, Lang::$word->TXN_DELETED);
			else:
				$json['type']	= 'warning';
				$json['title']	 = Lang::$word->ALERT;
				$json['message'] = Lang::$word->NOPROCCESS;
			endif;

			print json_encode($json);
			break;
	
	
		/* == Delete File == */
		case "deleteFile":
			$action = false;
			$title	= sanitize($_POST['title']);
			if ($_POST['extra'] == "temp"):
				@unlink(Registry::get("Core")->file_dir . $title);
				$action = true;
			elseif ($_POST['extra'] == "live"):
				$thumb = getValueByID("name", Products::fTable, Filter::$id);
				$db->delete(Products::fTable, "id=" . Filter::$id);
				@unlink(Registry::get("Core")->file_dir . $thumb);
				$action = true;
			endif;
	
			if ($action):
				$json['type']	= 'success';
				$json['title']	 = Lang::$word->SUCCESS;
				$json['message'] = str_replace("-ITEM-", $title, Lang::$word->FLM_DELETED);
			else:
				$json['type']	= 'warning';
				$json['title']	 = Lang::$word->ALERT;
				$json['message'] = Lang::$word->NOPROCCESS;
			endif;
	
			print json_encode($json);
			break;
	
		/* == Delete Backup == */
		case "deleteBackup":
			$title = sanitize($_POST['title']);
			$action = false;
	
			if(file_exists(BASEPATH . 'admin/backups/'.sanitize($_POST['file']))) :
				$action = unlink(BASEPATH . 'admin/backups/'.sanitize($_POST['file']));
			endif;
	
			if($action) :
				$json['type'] = 'success';
				$json['title'] = Lang::$word->SUCCESS;
				$json['message'] = str_replace("-ITEM-", $title, Lang::$word->DBM_DEL_OK);
			else :
				$json['type'] = 'warning';
				$json['title'] = Lang::$word->ALERT;
				$json['message'] = Lang::$word->NOPROCCESS;
			endif;
			print json_encode($json);
		 break;
	
		/* == Delete Category == */
		case "deleteCategory":
			$res = $db->delete(Content::cTable, "id=" . Filter::$id);
			$db->delete(Content::cTable, "parent_id=" . Filter::$id);
			$title = sanitize($_POST['title']);
	
			if ($res):
				$json['type']	= 'success';
				$json['title']	 = Lang::$word->SUCCESS;
				$json['message'] = str_replace("-ITEM-", $title, Lang::$word->CAT_DELETED);
			else:
				$json['type']	= 'warning';
				$json['title']	 = Lang::$word->ALERT;
				$json['message'] = Lang::$word->NOPROCCESS;
			endif;
	
			print json_encode($json);
			break;
			
		/* == Delete News Category == */
			case "deleteBlogCat":
				$res = $db->delete(Content::bcTable, "id=" . Filter::$id);
				$db->delete(Content::bcTable, "parent_id=" . Filter::$id);
				$title = sanitize($_POST['title']);
		
				if ($res):
					$json['type']	= 'success';
					$json['title']	 = Lang::$word->SUCCESS;
					$json['message'] = str_replace("-ITEM-", $title, Lang::$word->CAT_DELETED);
				else:
					$json['type']	= 'warning';
					$json['title']	 = Lang::$word->ALERT;
					$json['message'] = Lang::$word->NOPROCCESS;
				endif;
		
				print json_encode($json);
				break;
	
	endswitch;

	/* Get Content Type */
	if (isset($_POST['contenttype'])):
		$type = sanitize($_POST['contenttype']);
		$html = "";
		switch ($type):
			case "page":
				$sql = "SELECT id, title FROM " . Content::pTable . " WHERE active = '1' ORDER BY title ASC";
				$result = $db->fetch_all($sql);
	
				if ($result):
					foreach ($result as $row):
						$html .= "<option value=\"" . $row->id . "\">" . $row->title . "</option>\n";
					endforeach;
					$json['type'] = 'page';
					$json['message'] = $html;
				endif;
				break;
	
			default:
				$html .= "<input name=\"page_id\" type=\"hidden\" value=\"0\" />";
				$json['type'] = 'web';
				$json['message'] = $html;
		endswitch;
	
		print json_encode($json);
	endif;

	/* == Process Category == */
	if (isset($_POST['processCategory'])):
		$content->processCategory();
	endif;
	
	/* == Sort Category == */
	if (isset($_POST['doCatSort'])):
		$i = 0;
		foreach ($_POST['list'] as $k => $v):
			$i++;
			$data['parent_id'] = intval($v);
			$data['position'] = intval($i);
			$res = $db->update(Content::cTable, $data, "id=" . (int)$k);
		endforeach;
		print ($res) ? Filter::msgSingleOk(Lang::$word->CAT_SORTED) : Filter::msgSingleAlert(Lang::$word->NOPROCCESS);
	endif;
	
	/* == Process News Category == */
	if (isset($_POST['processBlogCat'])):
		$content->processBlogCat();
	endif;
	
	/* == Sort Category == */
	if (isset($_POST['doNewsCatSort'])):
		$i = 0;
		foreach ($_POST['list'] as $k => $v):
			$i++;
			$data['parent_id'] = intval($v);
			$data['position'] = intval($i);
			$res = $db->update(Content::bcTable, $data, "id=" . (int)$k);
		endforeach;
		print ($res) ? Filter::msgSingleOk(Lang::$word->CAT_SORTED) : Filter::msgSingleAlert(Lang::$word->NOPROCCESS);
	endif;
	
	
	

	/* == Add Product == */
	if (isset($_POST['addProduct'])):
		$item->addProduct();
	endif;

	/* == Update Product == */
	if (isset($_POST['updateProduct'])):
		$item->updateProduct();
	endif;
	

	/* == Product Live Search == */
	if (isset($_POST['productSearch'])):
		$string = sanitize($_POST['productSearch'], 15);
		if (strlen($string) > 3):
			$sql = "SELECT id, title, thumb, body, created"
			. "\n FROM " . Products::pTable
			. "\n WHERE MATCH (title) AGAINST ('" . $db->escape($string) . "*' IN BOOLEAN MODE)"
			. "\n ORDER BY title LIMIT 10";
	
			$html = '';
			if ($result = $db->fetch_all($sql)):
				$html .= '<div id="search-results" class="wojo segment celled list">';
				foreach ($result as $row):
					$thumb = ($row->thumb) ? '<img src="' . UPLOADURL . 'prod_images/' . $row->thumb . '" alt="" class="wojo small image"/>' : '<img src="' . UPLOADURL . 'prod_images/blank.png?v=1" alt="" class="wojo small image"/>';
					$link = 'index.php?do=products&amp;action=edit&amp;id=' . $row->id;
					$html .= '<div class="item">' . $thumb;
					$html .= '<div class="items">';
					$html .= '<div class="header"><a href="' . $link . '">' . $row->title . '</a></div>';
					$html .= '<p>' . Filter::dodate('short_date', $row->created) . '</p>';
					$html .= '<p><small>' . cleanSanitize($row->body, 150). '</small></p>';
					$html .= '</div>';
					$html .= '</div>';
				endforeach;
				$html .= '</div>';
				print $html;
			endif;
		endif;
	endif;

	/* == Rename File Alias == */
	if (isset($_POST['quickedit']) and $_POST['type'] == "file"):
		if (empty($_POST['title'])):
			print '-/-';
			exit;
		endif;
	
			$title = cleanOut($_POST['title']);
			$title = strip_tags($title);
	
		if($_POST['key'] == "title"):
			$data['alias'] = $title;
			$db->update(Products::fTable, $data, "id = " . Filter::$id);
			endif;
	
		print $title;
	endif;

	/* == Add All Temp Files */
	if (isset($_POST['addAllTempFiles'])):
		$item->addTempFiles();
	endif;
	
	/* == Upload Files == */
	if (isset($_POST['uploadMainFiles'])):
		Registry::get('FM')->filesUpload('mainfile');
	endif;
	
	
	/* == Upload Gallery Image == */
	if (isset($_POST['uploadGalleryImages'])):
		$item->galleryUpload('mainfile');
	endif;

	/* == Edit Gallery == */
	if (isset($_POST['quickedit']) and $_POST['type'] == "gallery"):
		if (empty($_POST['title'])):
			print '-/-';
			exit;
		endif;
	
			$title = cleanOut($_POST['title']);
			$title = strip_tags($title);
	
		if($_POST['key'] == "title"):
			$data['caption'] = $title;
			$db->update(Products::phTable, $data, "id = " . Filter::$id);
			endif;
	
		print $title;
	endif;
	
	/* == Rename File Alias == */
	if (isset($_POST['quickedit']) and $_POST['type'] == "language"):
		if (empty($_POST['title'])):
			print '-/-';
			exit;
		endif;
	
			$title = cleanOut($_POST['title']);
			$title = strip_tags($title);
	
		if (file_exists(BASEPATH . Lang::langdir . Core::$language . "/" . $_POST['path'] . ".xml")):
		$xmlel = simplexml_load_file(BASEPATH . Lang::langdir . Core::$language . "/" . $_POST['path'] . ".xml");
			$node = $xmlel->xpath("/language/phrase[@data = '" . $_POST['key'] . "']");
			$node[0][0] = $title;
			$xmlel->asXML(BASEPATH . Lang::langdir . Core::$language . "/" . $_POST['path'] . ".xml");
		endif;
	
		print $title;
	endif;
	
	/* == Process Configuration == */
	if (isset($_POST['processConfig'])):
		$core->processConfig();
	endif;
	/* == Process Configuration == */
	if (isset($_POST['processConfigSocial'])):
		$core->processConfigSocial();
	endif;
	
	/* == Process Gateway == */
	if (isset($_POST['processGateway'])):
		$content->processGateway();
	endif;

	/* == Restore SQL Backup == */
	if (isset($_POST['restoreBackup'])):
		require_once(BASEPATH . "lib/class_dbtools.php");
		Registry::set('dbTools',new dbTools());
		$tools = Registry::get("dbTools");
	
		if($tools->doRestore($_POST['restoreBackup'])) :
			$json['type'] = 'success';
			$json['title'] = Lang::$word->SUCCESS;
			$json['message'] = str_replace("-ITEM-", $_POST['restoreBackup'], Lang::$word->DBM_RES_OK);
			else :
			$json['type'] = 'warning';
			$json['title'] = Lang::$word->ALERT;
			$json['message'] = Lang::$word->NOPROCCESS;
		endif;
		print json_encode($json);
	endif;
	
	
	/* == Add News == */
	if (isset($_POST['processArticle'])):
		$content->processArticle();
	endif;
	/* == Add News == */
	if (isset($_POST['updateComment'])):
		$content->updateComment();
	endif;
	
	/* == Process F.A.Q == */
	if (isset($_POST['processFaq'])):
		$content->processFaq();
	endif;
	
	/* == Update faq order == */
	if (isset($_GET['sortfaq'])):
		foreach ($_POST['node'] as $k => $v):
			$p = $k + 1;
			$data['position'] = $p;
			$db->update(Content::fqTable, $data, "id=" . intval($v));
		endforeach;
	endif;
	
	/* == Process Email Template == */
	if (isset($_POST['processEmailTemplate'])):
		$content->processEmailTemplate();
	endif;
	
	/* == Process Comment Configuration == */
	if (isset($_POST['processCommentConfig'])):
		$content->processCommentConfig();
	endif;
	
	/* == Comments Actions == */
	if (isset($_POST['comproccess']) && intval($_POST['comproccess']) == 1):
		$action = '';
		if (empty($_POST['comid'])):
			$json['type'] = 'warning';
			$json['message'] = Filter::msgAlert(Lang::$word->CMT_ACT_1, false);
		endif;
	
		if (!empty($_POST['comid'])):
			foreach ($_POST['comid'] as $val):
				$id = intval($val);
				if (isset($_POST['action']) && $_POST['action'] == "disapprove"):
					$data['active'] = 0;
					$action = Lang::$word->CMT_ACT_2;
				elseif (isset($_POST['action']) && $_POST['action'] == "approve"):
					$data['active'] = 1;
					$action = Lang::$word->CMT_ACT_3;
				endif;
	
				if (isset($_POST['action']) && $_POST['action'] == "delete"):
					$db->delete(Content::cmTable, "id=" . $id);
					$action = Lang::$word->CMT_ACT_4;
				else:
					$db->update(Content::cmTable, $data, "id=" . $id);
				endif;
				endforeach;
	
			if ($db->affected()):
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($action, false);
			else:
				$json['type'] = 'warning';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			endif;
	
		endif;
		print json_encode($json);
	endif;
	
	
	/* == Update Comment == */
	if (isset($_POST['processComment'])):
		$data['body'] = cleanOut($_POST['content']);
		$result = $db->update(Content::cmTable, $data, "id=" . Filter::$id);
	
		if ($result):
			$json['type'] = 'success';
			$json['title'] = Lang::$word->SUCCESS;
			$json['message'] = Lang::$word->CMT_UPDATED;
		else:
			$json['type'] = 'warning';
			$json['title'] = Lang::$word->ALERT;
			$json['message'] = Lang::$word->NOPROCCESS;
		endif;
		print json_encode($json);
	endif;
	
	/* == Process Coupons == */
	if (isset($_POST['addDiscount'])):
		$content->addDiscount();
	endif;
	if (isset($_POST['updateDiscount'])):
		$content->updateDiscount();
	endif;
	
	/* == Process Invites == */
	if (isset($_POST['processInvite'])):
		$content->processInvite();
	endif;
	
	

	/* == Process User == */
	if (isset($_POST['processUser'])):
		$user->processUser();
	endif;
	
	/* == User Search == */
	if (isset($_POST['userSearch'])):
		$string = sanitize($_POST['userSearch'], 15);
		if (strlen($string) > 3):
			$sql = "SELECT id, username, created, avatar, CONCAT(fname,' ',lname) as name"
			. "\n FROM " . Users::uTable
			. "\n WHERE MATCH (username) AGAINST ('" . $db->escape($string) . "*' IN BOOLEAN MODE)"
			. "\n ORDER BY username LIMIT 10";
	
			$html = '';
			if ($result = $db->fetch_all($sql)):
				$html .= '<div id="search-results" class="segment celled list">';
				foreach ($result as $row):
					$thumb = ($row->avatar) ? '<img src="' . UPLOADURL . 'avatars/' . $row->avatar . '" alt="" class="image avatar"/>' : '<img src="' . UPLOADURL . 'avatars/blank.png?v=1" alt="" class="wojo image avatar"/>';
					$link = 'index.php?do=users&amp;action=edit&amp;id=' . $row->id;
					$html .= '<div class="item">' . $thumb;
					$html .= '<div class="items">';
					$html .= '<div class="header"><a href="' . $link . '">' . $row->name . '</a> <small>(' . $row->username . ')</small></div>';
					$html .= '<p>' . Filter::dodate('short_date', $row->created) . '</p>';
					$html .= '<p><a href="index.php?do=newsletter&amp;emailid=' . urlencode($row->username) . '">' . $row->username . '</a></p>';
					$html .= '</div>';
					$html .= '</div>';
				endforeach;
				$html .= '</div>';
				print $html;
			endif;
		endif;
	endif;
	
	/* == Site Maintenance == */
	if (isset($_POST['processMaintenance'])):
	switch ($_POST['do']):
		case "inactive":
				$now = date('Y-m-d H:i:s');
				$diff = intval($_POST['days']);
				$expire = date("Y-m-d H:i:s", strtotime($now . -$diff . " days"));
				$db->delete(Users::uTable, "lastlogin < '" . $expire . "' AND active = 'y' AND userlevel !=9");
				if ($db->affected()):
					$json['type'] = 'success';
					$json['message'] = Filter::msgOk(str_replace("[NUMBER]", $db->affected(), Lang::$word->MTN_DELINCT_OK), false);
				else:
					$json['type'] = 'success';
					$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
				endif;
			print json_encode($json);
		 break;
	
		case "banned":
		$db->delete(Users::uTable, "active = 'b'");
		if ($db->affected()):
			$json['type'] = 'success';
			$json['message'] = Filter::msgOk(str_replace("[NUMBER]", $db->affected(), Lang::$word->MTN_DELBND_OK), false);
		else:
			$json['type'] = 'success';
			$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
		endif;
		print json_encode($json);
		 break;
	
		case "recent":
		$db->query("TRUNCATE TABLE recent");
		if ($db->affected()):
			$json['type'] = 'success';
			$json['message'] = Filter::msgOk(str_replace("[NUMBER]", $db->affected(), Lang::$word->MTN_DELRCT_OK), false);
		else:
			$json['type'] = 'success';
			$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
		endif;
		print json_encode($json);
		 break;
		 
	
	endswitch;
	
	endif;
	
	/* == Process Transaction == */
	if (isset($_POST['processTransaction'])):
		$item->processTransaction();
	endif;
	
	/* == Transaction Live Search == */
	if (isset($_POST['transactionSearch'])):
		$string = sanitize($_POST['transactionSearch'], 15);
		if (strlen($string) > 3):
			$sql = "SELECT t.*, t.id as id, u.id as uid, u.username, p.id as pid, p.title, p.thumb"
			. "\n FROM " . Products::tTable . " as t"
			. "\n LEFT JOIN " . Users::uTable . " as u ON u.id = t.uid"
			. "\n LEFT JOIN " . Products::pTable . " as p ON p.id = t.pid"
			. "\n WHERE MATCH (p.title, t.txn_id, u.username) AGAINST ('" . $db->escape($string) . "*' IN BOOLEAN MODE)"
			. "\n ORDER BY t.created DESC LIMIT 5";
	
			$html = '';
			if ($result = $db->fetch_all($sql)):
				$html .= '<div id="search-results" class="wojo segment celled list">';
				foreach ($result as $row):
					$thumb = ($row->thumb) ? '<img src="' . UPLOADURL . 'prod_images/' . $row->thumb . '" alt="" class="wojo small image"/>' : '<img src="' . UPLOADURL . 'prod_images/blank.png?v=1" alt="" class="wojo small image"/>';
					$link = 'index.php?do=transactions&amp;action=edit&amp;id=' . $row->id;
					$html .= '<div class="item">' . $thumb;
					$html .= '<div class="items">';
					$html .= '<div class="header"><a href="' . $link . '">' . $row->title . '</a></div>';
					$html .= '<p> Email: ' . $row->username . '</p>';
					$html .= '<p>' . Lang::$word->TXN_AMT . ': ' . $core->formatMoney($row->price) . '</p>';
					$html .= '<p><small>' . Lang::$word->CREATED . ': ' . $row->created . '</small></p>';
					$html .= '</div>';
					$html .= '</div>';
				endforeach;
				$html .= '</div>';
				print $html;
			endif;
		endif;
	endif;
	
	/* == Latest Sales Stats == */
	if (isset($_GET['getSaleStats'])):
	$range = (isset($_GET['timerange'])) ? sanitize($_GET['timerange']) : 'month';
	$data = array();
	$data['order'] = array();
	$data['xaxis'] = array();
	$data['order']['label'] = Lang::$word->TXN_TOTALR;
	
	switch ($range) {
		case 'day':
		$date = date('Y-m-d');
			for ($i = 0; $i < 24; $i++) {
				$query = $db->first("SELECT COUNT(*) AS total FROM " . Products::tTable
				. "\n WHERE DATE(created) = '" . $db->escape($date) . "'"
				. "\n AND HOUR(created) = '" . (int)$i . "'"
				. "\n AND status = 1 AND active = 1"
				. "\n GROUP BY HOUR(created) ORDER BY created ASC");
	
				($query) ? $data['order']['data'][] = array($i, (int)$query->total) : $data['order']['data'][] = array($i, 0);
				$data['xaxis'][] = array($i, date('H', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
			}
			break;
		case 'week':
			$date_start = strtotime('-' . date('w') . ' days');
	
			for ($i = 0; $i < 7; $i++) {
				$date = date('Y-m-d', $date_start + ($i * 86400));
				$query = $db->first("SELECT COUNT(*) AS total FROM " . Products::tTable
				. "\n WHERE DATE(created) = '" . $db->escape($date) . "'"
				. "\n AND status = 1 AND active = 1"
				. "\n GROUP BY DATE(created)");
	
				($query) ? $data['order']['data'][] = array($i, (int)$query->total) : $data['order']['data'][] = array($i, 0);
				$data['xaxis'][] = array($i, date('D', strtotime($date)));
			}
	
			break;
		default:
		case 'month':
			for ($i = 1; $i <= date('t'); $i++) {
				$date = date('Y') . '-' . date('m') . '-' . $i;
				$query = $db->first("SELECT COUNT(*) AS total FROM " . Products::tTable
				. "\n WHERE (DATE(created) = '" . $db->escape($date) . "')"
				. "\n AND status = 1 AND active = 1"
				. "\n GROUP BY DAY(created)");
	
				($query) ? $data['order']['data'][] = array($i, (int)$query->total) : $data['order']['data'][] = array($i, 0);
				$data['xaxis'][] = array($i, date('j', strtotime($date)));
			}
			break;
		case 'year':
			for ($i = 1; $i <= 12; $i++) {
				$query = $db->first("SELECT COUNT(*) AS total FROM " . Products::tTable
				. "\n WHERE YEAR(created) = '" . date('Y') . "'"
				. "\n AND MONTH(created) = '" . $i . "'"
				. "\n AND status = 1 AND active = 1"
				. "\n GROUP BY MONTH(created)");
	
				($query) ? $data['order']['data'][] = array($i, (int)$query->total) : $data['order']['data'][] = array($i, 0);
				$data['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i, 1, date('Y'))));
			}
			break;
	}
	
	 print json_encode($data);
	 exit();
	endif;
	
	/* == Latest Product Stats == */
	if (isset($_GET['getProductStats'])):
	
		$data = array();
		$data['hits'] = array();
		$data['xaxis'] = array();
		$data['hits']['label'] = Lang::$word->ADM_PVIEWS;
		$data['uhits']['label'] = Lang::$word->ADM_UVIEWS;
	
		$and = (Filter::$id) ? "AND pid = " . Filter::$id : null;
	
		for ($i = 1; $i <= 12; $i++):
			$row = $db->first("SELECT SUM(hits) AS hits,"
			. "\n SUM(uhits) as uhits"
			. "\n FROM stats"
			. "\n WHERE YEAR(day) = '" . date('Y') . "'"
			. "\n AND MONTH(day) = '" . $i . "'"
			. "\n $and"
			. "\n GROUP BY MONTH(day)");
	
			$data['hits']['data'][] = ($row) ? array($i, (int)$row->hits) : array($i, 0);
			$data['uhits']['data'][] = ($row) ? array($i, (int)$row->uhits) : array($i, 0);
			$data['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i, 1, date('Y'))));
		endfor;
	
		print json_encode($data);
	endif;
	
	if(isset($_POST['notifyMultipleUsers'])):
		$user_emails = $db->fetch_all("SELECT DISTINCT user_email from " . Content::nmTable);
		
		if($user_emails){
			// Setup email and variables for email
			require_once(BASEPATH . "lib/class_mailer.php");
			
			foreach ($user_emails as $key => $value) {
				
				$user_email = $value->user_email;
				$user_products = $db->fetch_all("SELECT pid from " . Content::nmTable ." WHERE user_email='{$user_email}'");
				$notifications = $db->fetch_all("SELECT * FROM " . Users::uTable . " WHERE username ='{$user_email}' AND notifications = 1");
				
				if($user_products && $notifications){
					
					$products_restocked = 0;
					
					$product_tr = '';
				
					foreach ($user_products as $ups => $single_product) {
						$product_id = $single_product->pid;
						$product_detail = Core::getRowById(Products::pTable, $product_id);
						if($product_detail->stock > 0){
							
							$products_restocked ++;
							
							if ($product_detail->thumb):
								$produt_image_m = UPLOADURL . 'prod_images/'. $product_detail->thumb;
							else:
								$produt_image_m = UPLOADURL . 'prod_images/blank.png';
							endif;
							$product_name = $product_detail->title;
							$product_link = Registry::get("Core")->site_url.'/item?itemname='.$product_detail->slug;
							$product_tr .= '<tr>
								<td style="vertical-align:middle; padding: 20px 0">
									<a style="color:#222222!important;text-decoration:none!important;font-weight: bold;" href="'. $product_link .'">'. $product_name .'</a>
								</td>
								<td>
									<img style="height: 120px; width: auto" src="'.$produt_image_m.'" />
								</td>
							</tr>';
							
							$nmId = $db->first("SELECT * FROM " . Content::nmTable . " WHERE pid = " . $product_id . " AND user_email = '" . sanitize($user_email) . "'");
							
							$res = $db->delete(Content::nmTable, "id=" . $nmId->id);
						}
						
					}
					
					//Send mail
					$mailer = Mailer::sendMail();
					
					if($products_restocked == 1 || count($user_products) == 1){
						$s_pid = $user_products[0]->pid;
						$product_detail = Core::getRowById(Products::pTable, $s_pid);
						
						if($product_detail->stock > 0){
							if ($product_detail->thumb):
								$produt_image_m = UPLOADURL . 'prod_images/'. $product_detail->thumb;
							else:
								$produt_image_m = UPLOADURL . 'prod_images/blank.png';
							endif;
	
							//Product title and link
							$product_name = $product_detail->title;
							$product_link = $product_detail->slug;
							
							//Mail subject
							$mailsubject = $product_name . ' are available';
							
							//Mail body
							$template = file_get_contents('../templates_email/email_productavailable.html');
							
							$template = str_replace(array(
								'[SITEURL]',
								'[SITE_NAME]',
								'[COMPANY]',
								'[EMAIL]',
								'[LOCATION]',
								'[PRODUCT]',
								'[PRODUCT_IMG]',
								'[PRODUCT_LINK]'
							), array(
								Registry::get("Core")->site_url,
								Registry::get("Core")->site_name,
								Registry::get("Core")->company,
								$data['username'],
								'Vancouver, British Columbia',
								$product_name,
								$produt_image_m,
								$product_link
							), $template);
							
							$message = Swift_Message::newInstance()
								->setSubject($mailsubject)
								->setTo(array ($user_email))
								->setFrom(array($core->site_email => $core->site_name))
								->setBody($template, 'text/html');
							$mailer->send($message);
						}
						
					}
					else if( $product_tr != '' ){
						$mailsubject = 'Products available again.';
						$template = file_get_contents('../templates_email/email_productavailable_multiple.html');
						$template = str_replace(array(
							'[SITEURL]',
							'[SITE_NAME]',
							'[COMPANY]',
							'[EMAIL]',
							'[LOCATION]',
							'[PRODUCTS]',
						), array(
							Registry::get("Core")->site_url,
							Registry::get("Core")->site_name,
							Registry::get("Core")->company,
							$data['username'],
							'Vancouver, British Columbia',
							$product_tr,
						), $template);
						
						$message = Swift_Message::newInstance()
							->setSubject($mailsubject)
							->setTo(array ($user_email))
							->setFrom(array($core->site_email => $core->site_name))
							->setBody($template, 'text/html');
						$mailer->send($message);
					}
					
					
				}
			}
		}
		$json['type'] = 'success';
		$json['message'] = 'Mail sent successfully';
		print json_encode($json);
	endif;
	
	/* == Process Transaction == */
	if (isset($_POST['updateInvoice'])):
		$item->updateInvoice();
	endif;

	/* == Process Wholesale Invoice == */
	if (isset($_POST['updateWholesaleInvoice'])):
		$item->updateWholesaleInvoice();
	endif;
	
	/* == Process Wholesale Transaction == */
	if (isset($_POST['updateWholesaleTransactions'])):
		$item->updateWholesaleTransactions();
	endif;

	/* == Process Transaction == */
	if (isset($_POST['updateInvoiceShipped'])):
		$item->updateInvoiceShipped();
	endif;
	
	/* == Process Transaction == */
	if (isset($_POST['updateInvoiceLabeled'])):
		$item->updateInvoiceLabeled();
	endif;
	
	/* == Process Configuration == */
	if (isset($_POST['processInvoiceTracking'])):
		$data['trackingnum'] = cleanOut($_POST['trackingnum']);
		$result = $db->update(Content::inTable, $data, "id=" . Filter::$id);
		
		if ($result):
			$json['type'] = 'success';
			$json['title'] = Lang::$word->SUCCESS;
			$json['message'] = Lang::$word->CMT_UPDATED;
		else:
			$json['type'] = 'warning';
			$json['title'] = Lang::$word->ALERT;
			$json['message'] = Lang::$word->NOPROCCESS;
		endif;
		print json_encode($json);
		
		
	endif;
	/* == Process Configuration == */
	if (isset($_POST['exportOrdersToShipStation'])):
		
		$result = true;
		$first_id = "";
		$data =array();
		foreach ($_POST['txIDs'] as $key => $value) {
			$export_result = exportShippingtoShipStation($value['tx'], $item, $core);
			array_push($data, array($value['tx'] => array('id' => $value['id'], 'result' => $export_result)));
		}
		if ($result):
			$json['type'] = 'success';
			$json['title'] = Lang::$word->SUCCESS;
			$json['message'] = $data;
		else:
			$json['type'] = 'warning';
			$json['title'] = Lang::$word->ALERT;
			$json['message'] = Lang::$word->NOPROCCESS;
		endif;
		print json_encode($json);
		
		
	endif;
  
	/* == Invoice bulk update == */
	if ($_POST['action'] == 'invoice-bulk-update'):
		$invoiceStatuses = array(
      'Error' => '4',
      'Shipped' => '3',
      'Packaged' => '2',
      'Label Printed' => '1.5',
      'Exported' => '1.2',
      'Paid' => '1',
      'Unpaid' => '0',
    );
    $invids = array();
    foreach ($_POST['invids'] as $invid)
    {
      $invids[] = '"' . sanitize($invid) . '"';
    }
    $where = 'invid IN (' . implode($invids, ",") . ')';
    $data = array('status' => $invoiceStatuses[$_POST['status']]);
    $db->update(Content::inTable, $data, $where);
    $json = array('debug' => $data, 'debug1' => $where);
		print json_encode($json);
	endif;
  
	/* == Process exportOrdersToShipStationA == */
	if (isset($_POST['exportOrdersToShipStationA'])):
		
		$query = "SELECT * FROM invoices WHERE status=1";
    	$invoices = $db->fetch_all($query);
    
    
		$result = true;
		$first_id = "";
		$data =array();
		
		foreach ($invoices as $invoice) {
			$export_result = exportShippingtoShipStation($invoice->invid, $item, $core);
			array_push($data, array($invoice->invid => array('id' => $invoice->id, 'result' => $export_result)));
		}
		if ($result):
			$json['type'] = 'success';
			$json['title'] = Lang::$word->SUCCESS;
			$json['message'] = $data;
		else:
			$json['type'] = 'warning';
			$json['title'] = Lang::$word->ALERT;
			$json['message'] = Lang::$word->NOPROCCESS;
		endif;
		print json_encode($json);
	endif;

	
?>
