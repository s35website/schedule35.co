<?php
/**
 * Content Class
 *
 * @package FBC Studio
 * @author fbcstudio.com
 * @copyright 2010
 * @version $Id: class_core.php, v2.00 2011-07-10 10:12:05 gewa Exp $
 */

if (!defined("_VALID_PHP")) die('Direct access to this location is not allowed.');
class Content

{
	const cTable = "categories";
	const rTable = "categories_related";
	const muTable = "menus";
	const gTable = "gateways";
	const pTable = "pages";
	const fqTable = "faq";
	const bTable = "blog";
	const bcTable = "blog_cat";
	const brTable = "blog_cat_related";
	const cmTable = "comments";
	const eTable = "email_templates";
	const cpTable = "coupons";
	const invTable = "invites";
	const crTable = "cart";
	const exTable = "extras";
	const slTable = "slider";
	const cnTable = "countries";
	const provTable = "provinces";
	const inTable = "invoices";
	const blkTable = "bulk_orders";
	const nmTable = "notify_me";
	const wsiTable = "wholesale_invoices";

	private static $db;
	
	/**
	 * Content::__construct()
	 *
	 * @return
	 */
	function __construct()
	{
		self::$db = Registry::get("Database");
		$this->cattree = $this->getCatTree();
		$this->blogcattree = $this->getBlogCatTree();
		$this->getContentSlug();
		$this->getCategorySlug();
		$this->getBlogSlug();
		$this->getBlogCatSlug();
		$this->getTag();
		$this->getAmbassadorCode();
		$this->getAmbassadorDiscount();
	}

	/**
	 * Content::getCategorySlug()
	 *
	 * @return
	 */
	private function getCategorySlug()
	{
		if (isset($_GET['catname'])) {
			$this->catslug = sanitize($_GET['catname'], 100);

			// $this->catslug = rtrim($this->catslug,"/");

			return self::$db->escape($this->catslug);
		}
	}
	
	/**
	 * Content::getAmbassadorCode()
	 *
	 * @return
	 */
	public function getAmbassadorCode()
	{
		$this->ambcode = null;
		
		if (isset($_GET['amb'])) {
			$this->ambcode = sanitize($_GET['amb'], 100);
		}elseif (isset($_SESSION["ambcode"])) {
			$this->ambcode = $_SESSION["ambcode"];
		}
		return self::$db->escape($this->ambcode);
	}
	
	/**
	 * Content::getAmbassadorCode()
	 *
	 * @return
	 */
	public function getAmbassadorDiscount()
	{
		$this->ambdiscount = null;
		$ambcode = null;
		
		if (isset($_GET['amb'])) {
			$ambcode = sanitize($_GET['amb'], 100);
		}elseif (isset($_SESSION["ambcode"])) {
			$ambcode = $_SESSION["ambcode"];
			
		}
		
		if ($ambcode) {
			$sql = "SELECT payout FROM " . Users::uTable . " WHERE invite_code = '" . $ambcode . "'";
			$row = self::$db->first($sql);
		}
		
		if ($row) {
			$this->ambdiscount = (Registry::get('Core')->payout - $row->payout) / 100;
		}
		
		return self::$db->escape($this->ambdiscount);
	}
	
	/**
	 * Products::getBlogSlug()
	 *
	 * @return
	 */
	private function getBlogSlug()
	{
		if (isset($_GET['blog'])) {
			$this->blogslug = sanitize($_GET['blog'], 100);
			return self::$db->escape($this->blogslug);
		}
	}
	
	/**
	 * Content::getBlogCatSlug()
	 *
	 * @return
	 */
	private function getBlogCatSlug()
	{
		if (isset($_GET['catname'])) {
			$this->blogcatslug = sanitize($_GET['catname'], 100);

			// $this->catslug = rtrim($this->catslug,"/");

			return self::$db->escape($this->blogcatslug);
		}
	}

	/**
	 * Content::getContentSlug()
	 *
	 * @return
	 */
	private function getContentSlug()
	{
		if (isset($_GET['pagename'])) {
			$this->pageslug = sanitize($_GET['pagename'], 100);
			return self::$db->escape($this->pageslug);
		}
	}

	/**
	 * Content::getTag()
	 *
	 * @return
	 */
	private function getTag()
	{
		if (isset($_GET['tagname'])) {
			$this->tag = sanitize($_GET['tagname'], 60, false);
			return self::$db->escape($this->tag);
		}
	}

	/**
	 * Content::getCountryList()
	 *
	 * @return
	 */
	public function getCountryList()
	{
		$sql = "SELECT * FROM " . self::cnTable . " ORDER BY sorting DESC";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content:::processCountry()
	 *
	 * @return
	 */
	public function processCountry()
	{
		Filter::checkPost('name', Lang::$word->CNT_NAME);
		Filter::checkPost('abbr', Lang::$word->CNT_ABBR);
		if (empty(Filter::$msgs)) {
			$data = array(
				'name' => sanitize($_POST['name']),
				'abbr' => sanitize($_POST['abbr']),
				'active' => intval($_POST['active']),
				'home' => intval($_POST['home']),
				'vat' => floatval($_POST['vat']),
				'sorting' => intval($_POST['sorting']),
			);
			if ($data['home'] == 1) {
				self::$db->query("UPDATE `" . self::cnTable . "` SET `home`= DEFAULT(home);");
			}

			Registry::get("Database")->update(self::cnTable, $data, "id=" . Filter::$id);
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk(Lang::$word->CNT_UPDATED, false);
			}
			else {
				$json['type'] = 'info';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}

	/**
	 * Content::getMenuList()
	 *
	 * @return
	 */
	public function getMenuList($save = true)
	{
		if ($menurow = self::$db->fetch_all("SELECT * FROM " . self::muTable . " ORDER BY position")) {
			print "<ul class=\"sortMenu\">\n";
			foreach($menurow as $row) {
				print '<li class="dd-item" id="list_' . $row->id . '">' . '<div class="dd-handle"><a data-id="' . $row->id . '" data-name="' . $row->name . '" data-title="' . Lang::$word->MNU_DELETE . '" data-option="deleteMenu" class="delete">' . '<i class="icon red remove sign"></i></a><i class="icon reorder"></i>' . '<a href="index.php?do=menus&amp;action=edit&amp;id=' . $row->id . '" class="parent">' . $row->name . '</a></div>';
				print "</li>\n";
			}
		}

		unset($row);
		print "</ul>\n";
	}

	/**
	 * Content::getMenu()
	 *
	 * @return
	 */
	public function getMenu()
	{
		$sql = "SELECT m.*, p.id, p.home_page,p.slug" . "\n FROM menus as m" . "\n LEFT JOIN pages AS p ON p.id = m.page_id" . "\n WHERE m.active = '1'" . "\n ORDER BY m.position";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content::processMenu()
	 *
	 * @return
	 */
	public function processMenu()
	{
		Filter::checkPost('name', Lang::$word->MNU_NAME);
		Filter::checkPost('content_type', Lang::$word->MNU_TYPE_S);
		if (empty(Filter::$msgs)) {
			$data = array(
				'name' => sanitize($_POST['name']),
				'page_id' => intval($_POST['page_id']),
				'content_type' => sanitize($_POST['content_type']),
				'link' => (isset($_POST['web'])) ? sanitize($_POST['web']) : "NULL",
				'target' => (isset($_POST['target'])) ? sanitize($_POST['target']) : "DEFAULT(target)",
				'active' => intval($_POST['active'])
			);
			(Filter::$id) ? self::$db->update(self::muTable, $data, "id=" . Filter::$id) : self::$db->insert(self::muTable, $data);
			$message = (Filter::$id) ? Lang::$word->MNU_UPDATED : Lang::$word->MNU_ADDED;
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);
			}
			else {
				$json['type'] = 'info';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}

	/**
	 * Content::getSingleCategory()
	 *
	 * @return
	 */
	public function getSingleCategory()
	{
		$sql = "SELECT * FROM " . self::cTable . " WHERE slug = '" . sanitize($this->catslug) . "'";
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content::getAllCategories()
	 *
	 * @return
	 */
	public function getAllCategories()
	{
		$sql = "SELECT *" . "\n FROM " . self::cTable . " ORDER BY position";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content::getCatTree()
	 *
	 * @return
	 */
	protected function getCatTree()
	{
		$query = self::$db->query("SELECT * FROM " . self::cTable . " ORDER BY parent_id, position");
		while ($row = self::$db->fetch($query, true)) {
			$this->cattree[$row['id']] = array(
				'id' => $row['id'],
				'name' => $row['name'],
				'parent_id' => $row['parent_id']
			);
		}

		return $this->cattree;
	}

	/**
	 * Content::getCatList()
	 *
	 * @return
	 */
	public function getCatList()
	{
		$query = self::$db->query("SELECT * FROM " . self::cTable . "\n WHERE active = 1" . "\n ORDER BY parent_id, position");
		while ($row = self::$db->fetch($query, true)) {
			$catlist[$row['id']] = array(
				'id' => $row['id'],
				'name' => $row['name'],
				'parent_id' => $row['parent_id'],
				'active' => $row['active'],
				'slug' => $row['slug']
			);
		}

		return $catlist;
	}

	/**
	 * Content::getSortCatList()
	 *
	 * @param integer $parent_id
	 * @return
	 */
	public function getSortCatList($parent_id = 0)
	{
		$subcat = false;
		$class = ($parent_id == 0) ? "parent" : "child";
		foreach($this->cattree as $key => $row) {
			if ($row['parent_id'] == $parent_id) {
				if ($subcat === false) {
					$subcat = true;
					print "<ul class=\"sortMenu\">\n";
				}

				print '<li class="dd-item" id="list_' . $row['id'] . '">' . '<div class="dd-handle"><a data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-title="' . Lang::$word->CAT_DELETE . '" data-option="deleteCategory" class="deleteBtn">' . '<i class="fa fa-remove red"></i></a><i class="icon reorder"></i>' . '<a href="index.php?do=categories&amp;action=edit&amp;id=' . $row['id'] . '" class="' . $class . '">' . $row['name'] . '</a></div>';
				$this->getSortCatList($key);
				print "</li>\n";
			}
		}

		unset($row);
		if ($subcat === true) print "</ul>\n";
	}

    /**
     * Content::getCatCheckList()
     * @param $parent_id
     * @param int $level
     * @param $spacer
     * @param bool $selected
     */
	public function getCatCheckList($parent_id, $level = 0, $spacer, $selected = false)
	{
		if ($this->cattree) {
			$class = 'odd';
			if ($selected) {
				$arr = explode(",", $selected);
				reset($arr);
			}

			foreach($this->cattree as $key => $row) {
				if ($selected) {
					$sel = (in_array($row['id'], $arr)) ? " checked=\"checked\"" : "";
					$hsel = (in_array($row['id'], $arr)) ? " active" : "";
				}
				else {
					$sel = '';
					$hsel = '';
				}

				$class = ($class == 'even' ? 'odd' : 'even');
				if ($parent_id == $row['parent_id']) {
					print "<div class=\"" . $class . $hsel . "\"> <div class=\"checkbox checkbox-primary\"><input type=\"checkbox\" name=\"cid[]\" id=\"cat_" . $row['id'] . "\" value=\"" . $row['id'] . "\"" . $sel . " />";
					for ($i = 0; $i < $level; $i++) print $spacer;
					print "<label for=\"cat_" . $row['id'] . "\">" . $row['name'] . "</label></div></div>\n";
					$level++;
					$this->getCatCheckList($key, $level, $spacer, $selected);
					$level--;
				}
			}

			unset($row);
		}
	}
	
	
	
	
	/**
     * Content::getCatRadioList()
     * @param $parent_id
     * @param int $level
     * @param $spacer
     * @param bool $selected
     */
	public function getCatRadioList($parent_id, $level = 0, $spacer, $selected = false)
	{
		if ($this->cattree) {
			$class = 'odd';
			if ($selected) {
				$arr = explode(",", $selected);
				reset($arr);
			}

			foreach($this->cattree as $key => $row) {
				if ($selected) {
					$sel = (in_array($row['id'], $arr)) ? " checked=\"checked\"" : "";
					$hsel = (in_array($row['id'], $arr)) ? " active" : "";
				}
				else {
					$sel = '';
					$hsel = '';
				}

				$class = ($class == 'even' ? 'odd' : 'even');
				if ($parent_id == $row['parent_id']) {
					print "<div class=\"" . $class . $hsel . "\"> <div class=\"radio radio-primary\"><input type=\"radio\" name=\"cid[]\" id=\"cat_" . $row['id'] . "\" value=\"" . $row['id'] . "\"" . $sel . " />";
					for ($i = 0; $i < $level; $i++) print $spacer;
					print "<label for=\"cat_" . $row['id'] . "\">" . $row['name'] . "</label></div></div>\n";
					$level++;
					$this->getCatCheckList($key, $level, $spacer, $selected);
					$level--;
				}
			}

			unset($row);
		}
	}

	/**
	 * Content::fetchProductCategories()
	 *
	 * @return
	 */
	public function fetchProductCategories()
	{
		if ($result = self::$db->fetch_all("SELECT cid FROM " . self::rTable . " WHERE pid = " . Filter::$id)) {
			$cids = array();
			foreach($result as $row) {
				$cids[] = $row->cid;
			}

			unset($row);
			$cids = implode(",", $cids);
		}
		else {
			$cids = "";
		}

		return $cids;
	}

    /**
     * Content::getCategories()
     *
     * @param mixed $array
     * @param integer $parent_id
     * @param string $menuid
     * @param string $class
     * @return void
     */
	 public function getCategories($array, $parent_id = 0, $menuid = 'main-menu', $class = 'top-menu')
     {
 		$subcat = false;
 		$attr = (!$parent_id) ? ' class="' . $class . '" id="' . $menuid . '"' : ' class="menu-submenu"';
 		$attr2 = (!$parent_id) ? ' class="nav-item"' : ' class="nav-submenu-item"';
 		foreach($array as $key => $row) {
 			if ($row['parent_id'] == $parent_id) {
 				if ($subcat === false) {
 					$subcat = true;
 					print "<ul" . $attr . ">\n";
 				}

 				$active = ($row['slug'] == $this->catslug) ? " class=\"active\"" : "";
 				if (isset($_GET['sort'])) {
 					$sortpath = '&sort=' . sanitize($_GET['sort'], 100);
 				}
				else {
					$sortpath = '';
				}

 				$url = (Registry::get('Core')->seo == 1) ? SITEURL . '/category/' . sanitize($row['slug']) . '/' : SITEURL . '/category?catname=' . sanitize($row['slug'] . $sortpath);
 				$link = '<a href="' . $url . '"' . $active . '>' . $row['name'] . '</a>';
 				print '<li' . $attr2 . '>';
 				print $link;
 				$this->getCategories($array, $key);
 				print "</li>\n";
 			}
 		}

 		unset($row);
 		if ($subcat === true) {
 			if (isset($_GET['sort'])) {
 				$sortpath = '?sort=' . sanitize($_GET['sort'], 100);
 			}
			print '<li class="nav-item"> <a href="' . SITEURL . '/shop' . $sortpath . '">' . 'Shop All </a></li>';
 			print '</ul>';
 		}
 	}

	/**
	 * Content::getCategoryFilter()
	 *
	 * @param mixed $array
	 * @param integer $parent_id
	 * @return
	 */
	 public function getCategoryFilter($array, $parent_id = 0, $menuid = 'main-menu', $class = 'top-menu') {

		if (isset($_GET['sort'])) {
			$sortpath = '&sort=' . sanitize($_GET['sort'], 100);
		}
		else {
			$sortpath = '';
		}

		$link = SITEURL . '/shop' . $sortpath;
		print '<div class="filters-button-group">';
		print '<div class="btn-filter"><a href="' . $link . '">Shop All</a></div>';

		foreach($array as $key => $row) {
			if ($row['parent_id'] == $parent_id) {

			$active = ($row['slug'] == $this->catslug) ? " class=\"active\"" : "";

				$url = (Registry::get('Core')->seo == 1) ? SITEURL . '/category/' . sanitize($row['slug']) . '/' : SITEURL . '/category?catname=' . sanitize($row['slug'] . $sortpath);
			$link = '<a href="' . $url . '"' . $active . '>' . $row['name'] . '</a>';

				print '<div class="btn-filter">' . $link . '</div>';
			}
		}

		unset($row);
		print '</div>';
 	}

	/**
	 * Content::getCatDropList()
	 *
	 * @param mixed $parent_id
	 * @param integer $level
	 * @param mixed $spacer
	 * @param bool $selected
	 * @return
	 */
	public function getCatDropList($parent_id, $level = 0, $spacer, $selected = false)
	{
		if ($this->cattree) {
			foreach($this->cattree as $key => $row) {
				$sel = ($row['id'] == $selected) ? " selected=\"selected\"" : "";
				if ($parent_id == $row['parent_id']) {
					print "<option value=\"" . $row['id'] . "\"" . $sel . ">";
					for ($i = 0; $i < $level; $i++) print $spacer;
					print $row['name'] . "</option>\n";
					$level++;
					$this->getCatDropList($key, $level, $spacer, $selected);
					$level--;
				}
			}

			unset($row);
		}
	}

	/**
	 * Content::processCategory()
	 *
	 * @return
	 */
	public function processCategory()
	{
		Filter::checkPost('name', Lang::$word->CAT_NAME);
		if (empty(Filter::$msgs)) {
			$data = array(
				'name' => sanitize($_POST['name']),
				'parent_id' => intval($_POST['parent_id']),
				'slug' => (empty($_POST['slug'])) ? doSeo($_POST['name']) : doSeo($_POST['slug']),
				'description' => sanitize($_POST['description']),
				'metakeys' => sanitize($_POST['metakeys']),
				'metadesc' => sanitize($_POST['metadesc']),
				'active' => intval($_POST['active'])
			);
			if (empty($_POST['metakeys']) or empty($_POST['metadesc'])) {
				include (BASEPATH . 'lib/class_meta.php');

				parseMeta::instance($_POST['description']);
				if (empty($_POST['metakeys'])) {
					$data['metakeys'] = parseMeta::get_keywords();
				}

				if (empty($_POST['metadesc'])) {
					$data['metadesc'] = parseMeta::metaText($_POST['description']);
				}
			}

			(Filter::$id) ? self::$db->update(self::cTable, $data, "id=" . Filter::$id) : self::$db->insert(self::cTable, $data);
			$message = (Filter::$id) ? Lang::$word->CAT_UPDATED : Lang::$word->CAT_ADDED;
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);
			}
			else {
				$json['type'] = 'info';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}

	/**
	 * Content::renderCategories()
	 *
	 * @return
	 */
	public function renderCategories($catname, $cid)
	{
		$pager = Paginator::instance();
		$counter = countEntries(Products::pTable, "cid", $cid);
		$pager->path = (Registry::get("Core")->seo) ? SITEURL . '/category/' . $catname . '/' : false;
		$pager->items_total = $counter;
		$pager->default_ipp = Registry::get("Core")->perpage;
		$pager->paginate();
		if (isset($_GET['sort'])) {
			$val = explode("-", $_GET['sort']);
			if (count($val) == 2) {
				$sort = sanitize($val[0]);
				$order = sanitize($val[1]);
				if (in_array($sort, array(
					"title",
					"price",
					"created"
				))) {
					$ord = ($order == 'DESC') ? " DESC" : " ASC";
					$sorting = $sort . $ord;
				}
				else {
					$sorting = " created DESC";
				}
			}
			else {
				$sorting = " created DESC";
			}
		}
		else {
			$sorting = " created ASC";
		}

		$sql = "SELECT *, id as pid FROM " . Products::pTable . " WHERE cid = " . (int)$cid . " AND active = '1'" . " ORDER BY $sorting " . $pager->limit;
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content::getFileTree()
	 *
	 * @return
	 */
	public function getFileTree()
	{
		global $db, $core;
		$sql = "SELECT *, created as cdate FROM files ORDER BY name";
		$row = $db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content::getGateways()
	 *
	 * @return
	 */
	public function getGateways($active = false)
	{
		global $db;
		$where = ($active) ? "WHERE active = '1'" : null;
		$sql = "SELECT * FROM " . self::gTable . "\n " . $where . "\n ORDER BY name";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content::processGateway()
	 *
	 * @return
	 */
	public function processGateway()
	{
		Filter::checkPost('displayname', Lang::$word->GTW_NAME);
		if (empty(Filter::$msgs)) {
			$data = array(
				'displayname' => sanitize($_POST['displayname']),
				'extra' => sanitize($_POST['extra']),
				'extra2' => sanitize($_POST['extra2']),
				'extra3' => sanitize($_POST['extra3']),
				'demo' => intval($_POST['demo']),
				'active' => intval($_POST['active'])
			);
			self::$db->update(self::gTable, $data, "id=" . Filter::$id);
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk(Lang::$word->GTW_UPDATED, false);
			}
			else {
				$json['type'] = 'success';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}


	

	/**
	 * Content::getEmailTemplates()
	 *
	 * @return
	 */
	public function getEmailTemplates()
	{
		$sql = "SELECT * FROM email_templates ORDER BY name ASC";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content:::processEmailTemplate()
	 *
	 * @return
	 */
	public function processEmailTemplate()
	{
		Filter::checkPost('name', Lang::$word->ETP_NAME);
		Filter::checkPost('subject', Lang::$word->ETP_SUBJECT);
		Filter::checkPost('body', Lang::$word->ETP_BODY);
		if (empty(Filter::$msgs)) {
			$data = array(
				'name' => sanitize($_POST['name']),
				'subject' => sanitize($_POST['subject']),
				'body' => $_POST['body'],
				'help' => sanitize($_POST['help'])
			);
			self::$db->update(self::eTable, $data, "id=" . Filter::$id);
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk(Lang::$word->ETP_UPDATED, false);
			}
			else {
				$json['type'] = 'success';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}

	/**
	 * Content::getBlog()
	 *
	 * @return
	 */
	public function getBlog()
	{
		$sql = "SELECT * FROM " . self::bTable . " ORDER BY title ASC";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	
	
	/**
	 * Content::getComments()
	 *
	 * @return
	 */
	public function getComments($big = false)
	{
		$id = ($big) ? $big : Filter::$id;
		
		if ($id) {
			$sql = "SELECT c.*, n.title, n.active, c.id as cid FROM " . self::cmTable . " as c LEFT JOIN " . self::bTable . " as n ON n.id = c.nid WHERE n.id = " . (int)$id . " ORDER BY created DESC";
		}else {
			$sql = "SELECT c.*, n.title, n.active, c.id as cid FROM " . self::cmTable . " as c LEFT JOIN " . self::bTable . " as n ON n.id = c.nid ORDER BY created DESC";
		}
		
		
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	
	/**
	 * Content::renderBlog()
	 *
	 * @return
	 */
	public function renderBlog()
	{
		if (Registry::get("Users")->is_Admin()) {
			$sql = "SELECT * FROM " . self::bTable . " WHERE slug = '" . $this->blogslug . "'";
		}else {
			$sql = "SELECT * FROM " . self::bTable . " WHERE active = 1 AND slug = '" . $this->blogslug . "'";
		}
		
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content::processArticle()
	 *
	 * @return
	 */
	public function processArticle()
	{
		Filter::checkPost('title', Lang::$word->NWS_NAME);
		Filter::checkPost('created', Lang::$word->CREATED);
		
		if (!empty($_FILES['file-image']['name'])) {
			if (!preg_match("/(\.jpg|\.png)$/i", $_FILES['file-image']['name'])) $core->msgs['file-image'] = Lang::$word->PRD_IMG_R;
		}
		
		$created = date("Y-m-d", strtotime($_POST['created']));
		$big = intval($_POST['article_id']);
		$slug = seoUrl($_POST['title']);
		
		if ($this->articleSlugExists($slug, $big)) Filter::$msgs['slug'] = 'slug ';
		
		if (empty(Filter::$msgs)) {
			$data = array(
				'title' => sanitize($_POST['title']),
				'author' => sanitize($_POST['author']),
				'herovideo' => sanitize($_POST['herovideo']),
				'slug' => sanitize($slug),
				'cid' => intval($_POST['cid'][0]),
				'body' => $_POST['body'],
				'created' => $created,
				'active' => intval($_POST['active'])
			);
			
			// Process Thumb
			if (!empty($_FILES['file-image']['name'])) {
				$thumbdir = UPLOADS . "news_images/";
				$tName = "img_" . cleanSanitize($slug);
				$text = substr($_FILES['file-image']['name'], strrpos($_FILES['file-image']['name'], '.') + 1);
				$thumbName = $thumbdir . $tName . "." . strtolower($text);
				if ($big && $thumb = getValueById("image", self::bTable, $big)) {
					@unlink($thumbdir . $thumb);
				}
	
				move_uploaded_file($_FILES['file-image']['tmp_name'], $thumbName);
				$data['image'] = $tName . "." . strtolower($text);
			}
			
			// Add to database
			($big) ? self::$db->update(self::bTable, $data, "id='" . $big . "'") : self::$db->insert(self::bTable, $data);
						
			$message = ($big) ? Lang::$word->NWS_UPDATED : Lang::$word->NWS_ADDED;
			
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);
			}
			else {
				$json['type'] = 'success';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
			
			// Process Categories
			if ($big) {
				if (isset($_POST['cid'])) {
					self::$db->delete(Content::brTable, "nid = " . $big);
					foreach($_POST['cid'] as $cid) {
						$cdata['nid'] = $big;
						$cdata['cid'] = intval($cid);
						self::$db->insert(Content::brTable, $cdata);
					}
				}
			} else {
				if (isset($_POST['cid'])) {
					foreach($_POST['cid'] as $cid) {
						$cdata['nid'] = $big;
						$cdata['cid'] = intval($cid);
						self::$db->insert(Content::brTable, $cdata);
					}
				}
			}
			
		}
		else {
			$json['type'] = 'success';
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}
	
	
	/**
	 * Content::addComment()
	 *
	 * @return
	 */
	public function addComment() {
		Filter::checkPost('uid', Lang::$word->CAT_NAME);
		Filter::checkPost('nid', Lang::$word->ETP_NAME);
		Filter::checkPost('captcha', Lang::$word->ETP_NAME);
		
		if ($_SESSION['captchacode'] != $_POST['captcha']) {
			$json['captchastatus'] = 0;
			Filter::$msgs['code'] = Lang::$word->CAPTCHA_E2;
		}else {
			$json['captchastatus'] = 1;
		}
		
		$created = date("Y-m-d H:i:s");
		$uid = intval($_POST['uid']);
		$big = intval($_POST['nid']);
		
		$sql = "SELECT * FROM " . Users::uTable . " WHERE id = '" . $uid . "'";
		$urow = self::$db->first($sql);
		$fullname = sanitize($urow->fname . " " . $urow->lname[0]);
		$json['user_name'] = $fullname;
		$json['user_date'] = date("F j, Y, g:i a", strtotime($created));
		
		
		if (empty(Filter::$msgs)) {
			$commdata = array(
				'nid' => $big,
				'uid' => $uid,
				'fullname' => $fullname,
				'body' => sanitize($_POST['body']),
				'private' => intval($_POST['private']),
				'created' => $created,
				'active' => 1
			);
			
			// Add to database
			$lastid = self::$db->insert(self::cmTable, $commdata);
			
			//Add points to users account
			$points_earned = 5;
			$udata['points_current'] = $urow->points_current + $points_earned;
			$udata['points_lifetime'] = $urow->points_lifetime + $points_earned;
			self::$db->update(Users::uTable, $udata, "id=" . $uid);
			
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['affected'] = 1;
				$json['points_current'] = $urow->points_current + $points_earned;
				$json['lastid'] = $lastid;
				$json['message'] = Filter::msgSingleOkPopup(Lang::$word->PLG_C_SENDOK1, false);
			}
			else {
				$json['type'] = 'success';
				$json['affected'] = 0;
				$json['message'] = Filter::msgSingleAlertPopup(Lang::$word->NOPROCCESS, false);
			}
			unset($_SESSION['captchacode']);
			
			print json_encode($json);
			
		}
		else {
			$json['message'] = Filter::msgStatus();
			unset($_SESSION['captchacode']);
			print json_encode($json);
		}
	}
	
	
	/**
	 * Content::updateComment()
	 *
	 * @return
	 */
	public function updateComment()
	{
		
		$created = date("Y-m-d", strtotime($_POST['created']));
		$commid = intval($_POST['comment_id']);
		
		if (empty(Filter::$msgs)) {
			$commdata = array(
				'body' => sanitize($_POST['body']),
				'created' => $created,
				'private' => intval($_POST['private']),
				'active' => intval($_POST['active'])
			);
			
			// Add to database
			($commid) ? self::$db->update(self::cmTable, $commdata, "id='" . $commid . "'") : self::$db->insert(self::cmTable, $commdata);
			
			$message = ($big) ? Lang::$word->NWS_UPDATED : Lang::$word->NWS_ADDED;
			
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);
			}
			else {
				$json['type'] = 'success';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
			
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}
	
	
	
	/**
	 * Content::removeComment()
	 *
	 * @return
	 */
	public function removeComment() {
		$commid = intval($_POST['comment_id']);
		
		if (empty(Filter::$msgs)) {
			self::$db->delete(self::cmTable, "id = " . $commid);
			
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);
			}
			else {
				$json['type'] = 'success';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
			
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}
	
	
	
	/**
	 * Content::getSingleBlogCat()
	 *
	 * @return
	 */
	public function getSingleBlogCat()
	{
		$sql = "SELECT * FROM " . self::bcTable . " WHERE slug = '" . sanitize($this->blogcatslug) . "'";
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
	
	
	
	/**
	 * Content::getAllBlogCat()
	 *
	 * @return
	 */
	public function getAllBlogCat()
	{
		$sql = "SELECT *" . " FROM " . self::bcTable . " ORDER BY id";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	
	
	/**
	 * Content::getBlogCatTree()
	 *
	 * @return
	 */
	protected function getBlogCatTree()
	{
		$query = self::$db->query("SELECT * FROM " . self::bcTable . " ORDER BY parent_id, position");
		while ($row = self::$db->fetch($query, true)) {
			$this->blogcattree[$row['id']] = array(
				'id' => $row['id'],
				'name' => $row['name'],
				'parent_id' => $row['parent_id']
			);
		}

		return $this->blogcattree;
	}
	
	/**
	 * Content::getBlogCatList()
	 *
	 * @return
	 */
	public function getBlogCatList()
	{
		$query = self::$db->query("SELECT * FROM " . self::bcTable . " WHERE active = 1 ORDER BY parent_id, position");
		while ($row = self::$db->fetch($query, true)) {
			$blogcatlist[$row['id']] = array(
				'id' => $row['id'],
				'name' => $row['name'],
				'parent_id' => $row['parent_id'],
				'active' => $row['active'],
				'slug' => $row['slug']
			);
		}

		return $blogcatlist;
	}
	
	
	/**
	 * Content::getBlogSortCatList()
	 *
	 * @param integer $parent_id
	 * @return
	 */
	public function getBlogSortCatList($parent_id = 0)
	{
		$subcat = false;
		$class = ($parent_id == 0) ? "parent" : "child";
		foreach($this->blogcattree as $key => $row) {
			if ($row['parent_id'] == $parent_id) {
				if ($subcat === false) {
					$subcat = true;
					print "<ul class=\"sortMenu\">\n";
				}

				print '<li class="dd-item" id="list_' . $row['id'] . '">' . '<div class="dd-handle"><a data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-title="' . Lang::$word->CAT_DELETE . '" data-option="deleteBlogCat" class="deleteBtn">' . '<i class="fa fa-remove red"></i></a><i class="icon reorder"></i>' . '<a href="index.php?do=blog-cat&amp;action=edit&amp;id=' . $row['id'] . '" class="' . $class . '">' . $row['name'] . '</a></div>';
				$this->getBlogSortCatList($key);
				print "</li>\n";
			}
		}

		unset($row);
		if ($subcat === true) print "</ul>\n";
	}
	
	
	/**
     * Content::getBlogCatCheckList()
     * @param $parent_id
     * @param int $level
     * @param $spacer
     * @param bool $selected
     */
	public function getBlogCatCheckList($parent_id, $level = 0, $spacer, $selected = false)
	{
		if ($this->blogcattree) {
			$class = 'odd';
			if ($selected) {
				$arr = explode(",", $selected);
				reset($arr);
			}

			foreach($this->blogcattree as $key => $row) {
				if ($selected) {
					$sel = (in_array($row['id'], $arr)) ? " checked=\"checked\"" : "";
					$hsel = (in_array($row['id'], $arr)) ? " active" : "";
				}
				else {
					$sel = '';
					$hsel = '';
				}

				$class = "check-item";
				if ($parent_id == $row['parent_id']) {
					print "<div class=\"" . $class . $hsel . "\"> <div class=\"checkbox checkbox-primary\"><input type=\"checkbox\" name=\"cid[]\" id=\"cat_" . $row['id'] . "\" value=\"" . $row['id'] . "\"" . $sel . " />";
					for ($i = 0; $i < $level; $i++) print $spacer;
					print "<label for=\"cat_" . $row['id'] . "\">" . $row['name'] . "</label></div></div>\n";
					$level++;
					$this->getBlogCatCheckList($key, $level, $spacer, $selected);
					$level--;
				}
			}

			unset($row);
		}
	}
	
	
	/**
	 * Content::fetchBlogCat()
	 *
	 * @return
	 */
	public function fetchBlogCat()
	{
		if ($result = self::$db->fetch_all("SELECT cid FROM " . self::brTable . " WHERE nid = " . Filter::$id)) {
			$cids = array();
			foreach($result as $row) {
				$cids[] = $row->cid;
			}

			unset($row);
			$cids = implode(",", $cids);
		}
		else {
			$cids = "";
		}

		return $cids;
	}
	
	
	/**
     * Content::getBlogCat()
     *
     * @param mixed $array
     * @param integer $parent_id
     * @param string $menuid
     * @param string $class
     * @return void
     */
	 public function getBlogCat($array, $parent_id = 0, $menuid = 'main-menu', $class = 'top-menu')
     {
 		$subcat = false;
 		$attr = (!$parent_id) ? ' class="' . $class . '" id="' . $menuid . '"' : ' class="menu-submenu"';
 		$attr2 = (!$parent_id) ? ' class="nav-item"' : ' class="nav-submenu-item"';
 		foreach($array as $key => $row) {
 			if ($row['parent_id'] == $parent_id) {
 				if ($subcat === false) {
 					$subcat = true;
 					print "<ul" . $attr . ">\n";
 				}

 				$active = ($row['slug'] == $this->blogcatslug) ? " class=\"active\"" : "";
 				if (isset($_GET['sort'])) {
 					$sortpath = '&sort=' . sanitize($_GET['sort'], 100);
 				}
				else {
					$sortpath = '';
				}

 				$url = (Registry::get('Core')->seo == 1) ? SITEURL . '/blog-cat/' . sanitize($row['slug']) . '/' : SITEURL . '/blog-cat?catname=' . sanitize($row['slug'] . $sortpath);
 				$link = '<a href="' . $url . '"' . $active . '>' . $row['name'] . '</a>';
 				print '<li' . $attr2 . '>';
 				print $link;
 				$this->getBlogCat($array, $key);
 				print "</li>\n";
 			}
 		}

 		unset($row);
 		if ($subcat === true) {
 			if (isset($_GET['sort'])) {
 				$sortpath = '?sort=' . sanitize($_GET['sort'], 100);
 			}
			print '<li class="nav-item"> <a href="' . SITEURL . '/blog' . $sortpath . '">' . 'All Articles </a></li>';
 			print '</ul>';
 		}
 	}
 	
 	/** Returns the number of products in a collection
 	 * @param $where string the SQL WHERE clause
 	 * @return int The number of rows
 	 */
 	public function countBlog($where)
 	{
 		$sql = "SELECT count(id) count FROM blog $where";
 		$row = self::$db->first($sql);
 		return ($row) ? $row->count : 0;
 	}
 	
 	
 	/** Gets products per page. Used in the All page.
	 * @param $sort string The value to sort on. Supports 'popular', 'highest', 'featured' and 'recent'.
	 * @param $page int Which page you're viewing
	 * @param $perPage int The number of results per page
	 * @return array The products
	 */
	public function getBlogPage($page, $perPage)
	{
		if (!is_numeric($page)) return false;
		if (!is_numeric($perPage)) return false;
		$offset = ($page - 1) * $perPage;

		$sql = "SELECT n.*, n.id as nid, c.name, c.slug as catslug, c.id as cid FROM " . self::bTable . " as n LEFT JOIN " . self::bcTable . " as c ON c.id = n.cid WHERE n.active = '1' ORDER BY n.created DESC";
		$sql.= " LIMIT $perPage OFFSET $offset";
		
		
		$row = self::$db->fetch_all($sql);

		return ($row) ? $row : array();
	}
 	
 	
 	/**
	 * Content::getBlogCatFilter()
	 *
	 * @param mixed $array
	 * @param integer $parent_id
	 * @return
	 */
	 public function getBlogCatFilter($array, $parent_id = 0, $menuid = 'main-menu', $class = 'top-menu') {

		if (isset($_GET['sort'])) {
			$sortpath = '&sort=' . sanitize($_GET['sort'], 100);
		}
		else {
			$sortpath = '';
		}

		$link = SITEURL . '/shop' . $sortpath;
		print '<div class="filters-button-group">';
		print '<div class="btn-filter"><a href="' . $link . '">Read All</a></div>';

		foreach($array as $key => $row) {
			if ($row['parent_id'] == $parent_id) {

			$active = ($row['slug'] == $this->blogcatslug) ? " class=\"active\"" : "";

				$url = (Registry::get('Core')->seo == 1) ? SITEURL . '/blog-cat/' . sanitize($row['slug']) . '/' : SITEURL . '/blog-cat?catname=' . sanitize($row['slug'] . $sortpath);
			$link = '<a href="' . $url . '"' . $active . '>' . $row['name'] . '</a>';

				print '<div class="btn-filter">' . $link . '</div>';
			}
		}

		unset($row);
		print '</div>';
 	}
 	
 	
 	/**
	 * Content::getBlogCatDropList()
	 *
	 * @param mixed $parent_id
	 * @param integer $level
	 * @param mixed $spacer
	 * @param bool $selected
	 * @return
	 */
	public function getBlogCatDropList($parent_id, $level = 0, $spacer, $selected = false)
	{
		if ($this->blogcattree) {
			foreach($this->blogcattree as $key => $row) {
				$sel = ($row['id'] == $selected) ? " selected=\"selected\"" : "";
				if ($parent_id == $row['parent_id']) {
					print "<option value=\"" . $row['id'] . "\"" . $sel . ">";
					for ($i = 0; $i < $level; $i++) print $spacer;
					print $row['name'] . "</option>\n";
					$level++;
					$this->getBlogCatDropList($key, $level, $spacer, $selected);
					$level--;
				}
			}

			unset($row);
		}
	}
	
	
	
	
	/**
	 * Content::processBlogCat()
	 *
	 * @return
	 */
	public function processBlogCat()
	{
		Filter::checkPost('name', Lang::$word->CAT_NAME);
		
		if (empty(Filter::$msgs)) {
			$data = array(
				'name' => sanitize($_POST['name']),
				'parent_id' => intval($_POST['parent_id']),
				'slug' => (empty($_POST['slug'])) ? doSeo($_POST['name']) : doSeo($_POST['slug']),
				'description' => sanitize($_POST['description']),
				'metakeys' => sanitize($_POST['metakeys']),
				'metadesc' => sanitize($_POST['metadesc']),
				'active' => intval($_POST['active'])
			);
			if (empty($_POST['metakeys']) or empty($_POST['metadesc'])) {
				include (BASEPATH . 'lib/class_meta.php');

				parseMeta::instance($_POST['description']);
				if (empty($_POST['metakeys'])) {
					$data['metakeys'] = parseMeta::get_keywords();
				}

				if (empty($_POST['metadesc'])) {
					$data['metadesc'] = parseMeta::metaText($_POST['description']);
				}
			}

			(Filter::$id) ? self::$db->update(self::bcTable, $data, "id=" . Filter::$id) : self::$db->insert(self::bcTable, $data);
			$message = (Filter::$id) ? Lang::$word->CAT_UPDATED : Lang::$word->CAT_ADDED;
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);
			}
			else {
				$json['type'] = 'info';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}
	
	
	/**
	 * Content::renderBlogCat()
	 *
	 * @return
	 */
	public function renderBlogCat($catname, $cid)
	{
		$pager = Paginator::instance();
		$counter = countEntries(self::bTable, "cid", $cid);
		$pager->path = (Registry::get("Core")->seo) ? SITEURL . '/blog-cat/' . $catname . '/' : false;
		$pager->items_total = $counter;
		$pager->default_ipp = Registry::get("Core")->perpage;
		$pager->paginate();
		if (isset($_GET['sort'])) {
			$val = explode("-", $_GET['sort']);
			if (count($val) == 2) {
				$sort = sanitize($val[0]);
				$order = sanitize($val[1]);
				if (in_array($sort, array(
					"title",
					"author",
					"created"
				))) {
					$ord = ($order == 'DESC') ? " DESC" : " ASC";
					$sorting = "n." . $sort . $ord;
				}
				else {
					$sorting = " n.created DESC";
				}
			}
			else {
				$sorting = " n.created DESC";
			}
		}
		else {
			$sorting = " n.created ASC";
		}

		$sql = "SELECT n.*, n.id as nid, (SELECT COUNT(nid) FROM " . self::cmTable . " WHERE nid = n.id) as comments FROM " . self::bTable . " as n INNER JOIN " . self::brTable . " rc ON n.id = nrc.nid WHERE nrc.cid = " . (int)$cid . " AND p.active = '1' ORDER BY $sorting " . $pager->limit;
		
		
		
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	
	
	

	/**
	 * Content::getFaq()
	 *
	 * @return
	 */
	public function getFaq()
	{
		$sql = "SELECT * FROM " . self::fqTable . " ORDER BY position";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content::processFaq()
	 *
	 * @return
	 */
	public function processFaq()
	{
		Filter::checkPost('question', Lang::$word->FAQ_QUEST);
		Filter::checkPost('answer', Lang::$word->FAQ_ANSW);
		if (empty(Filter::$msgs)) {
			$data = array(
				'question' => sanitize($_POST['question']),
				'answer' => $_POST['answer']
			);
			(Filter::$id) ? self::$db->update(self::fqTable, $data, "id='" . Filter::$id . "'") : self::$db->insert(self::fqTable, $data);
			$message = (Filter::$id) ? Lang::$word->FAQ_UPDATED : Lang::$word->FAQ_ADDED;
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);
			}
			else {
				$json['type'] = 'info';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}

	/**
	 * Content::getCommentsConfig()
	 *
	 * @return
	 */
	public function getCommentsConfig()
	{
		$sql = "SELECT * FROM comments_config";
		return $row = self::$db->first($sql);
	}

	/**
	 * Comments::processCommentConfig()
	 *
	 * @return
	 */
	public function processCommentConfig()
	{
		Filter::checkPost('dateformat', Lang::$word->CMT_DATEF);
		if (empty(Filter::$msgs)) {
			$data = array(
				'username_req' => intval($_POST['username_req']),
				'email_req' => intval($_POST['email_req']),
				'show_captcha' => intval($_POST['show_captcha']),
				'show_www' => intval($_POST['show_www']),
				'show_username' => intval($_POST['show_username']),
				'show_email' => intval($_POST['show_email']),
				'auto_approve' => intval($_POST['auto_approve']),
				'notify_new' => intval($_POST['notify_new']),
				'public_access' => intval($_POST['public_access']),
				'sorting' => sanitize($_POST['sorting'], 4),
				'blacklist_words' => trim($_POST['blacklist_words']),
				'char_limit' => intval($_POST['char_limit']),
				'perpage' => intval($_POST['perpage']),
				'dateformat' => sanitize($_POST['dateformat'])
			);
			self::$db->update("comments_config", $data);
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk(Lang::$word->CMT_UPDATEDC, false);
			}
			else {
				$json['type'] = 'info';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}

	/**
	 * Content::keepTags()
	 *
	 * @param mixed $str
	 * @return
	 */
	public function keepTags($string, $allowtags = null, $allowattributes = null)
	{
		$string = strip_tags($string, $allowtags);
		if (!is_null($allowattributes)) {
			if (!is_array($allowattributes)) $allowattributes = explode(",", $allowattributes);
			if (is_array($allowattributes)) $allowattributes = implode(")(?<!", $allowattributes);
			if (strlen($allowattributes) > 0) $allowattributes = "(?<!" . $allowattributes . ")";
			$string = preg_replace_callback("/<[^>]*>/i", create_function('$matches', 'return preg_replace("/ [^ =]*' . $allowattributes . '=(\"[^\"]*\"|\'[^\']*\')/i", "", $matches[0]);'), $string);
		}

		return $string;
	}

	/**
	 * Content::censored()
	 *
	 * @param mixed $string
	 * @param mixed $words
	 * @return
	 */
	public function censored($string, $words)
	{
		$array = explode("\r\n", $words);
		reset($array);
		foreach($array as $row) {
			$string = preg_replace("`$row`", "***", $string);
		}

		unset($row);
		return $string;
	}

	/**
	 * Content::getDiscounts()
	 *
	 * @return
	 */
	public function getDiscounts()
	{
		$sql = "SELECT * FROM " . self::cpTable;
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content::addDiscount()
	 *
	 * @return
	 */
	public function addDiscount()
	{
		Filter::checkPost('code', Lang::$word->CPN_CODE);
		Filter::checkPost('discount', Lang::$word->CPN_DISC);
		$valid = date("Y-m-d", strtotime($_POST['validuntil']));
        $product_list = '';
        
        if(!empty($_POST['product_list'])){
            $product_list = $_POST['product_list'];
        }
        
        if ($this->discountExists($_POST['code'])) Filter::$msgs['code'] = Lang::$word->CPN_EXISTS;
        
		if (empty(Filter::$msgs)) {
			$data = array(
				'title' => sanitize($_POST['code']),
				'code' => sanitize($_POST['code']),
				'discount' => intval($_POST['discount']),
				'type' => intval($_POST['type']),
				'validuntil' => $valid,
				'minval' => (empty($_POST['minval'])) ? 0.00 : floatval($_POST['minval']),
				'maxusage' => intval($_POST['maxusage']),
				'used' => intval($_POST['used']),
				'active' => intval($_POST['active']),
		        'coupon_applied_on' => intval($_POST['coupon_applied_on']),
		        'product_list' => $product_list
			);
			if (!Filter::$id) {
				$data['created'] = "NOW()";
			}
			(Filter::$id) ? self::$db->update(self::cpTable, $data, "id=" . Filter::$id) : self::$db->insert(self::cpTable, $data);
			$message = (Filter::$id) ? Lang::$word->CPN_UPDATED : Lang::$word->CPN_ADDED;
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);
			}
			else {
				$json['type'] = 'success';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}
	
	/**
	 * Content::updateDiscount()
	 *
	 * @return
	 */
	public function updateDiscount()
	{
		Filter::checkPost('code', Lang::$word->CPN_CODE);
		Filter::checkPost('discount', Lang::$word->CPN_DISC);
		$valid = date("Y-m-d", strtotime($_POST['validuntil']));
        $product_list = '';
        
        if(!empty($_POST['product_list'])){
            $product_list = $_POST['product_list'];
        }
        
		if (empty(Filter::$msgs)) {
			$data = array(
				'title' => sanitize($_POST['code']),
				'code' => sanitize($_POST['code']),
				'discount' => intval($_POST['discount']),
				'type' => intval($_POST['type']),
				'validuntil' => $valid,
				'minval' => (empty($_POST['minval'])) ? 0.00 : floatval($_POST['minval']),
				'maxusage' => intval($_POST['maxusage']),
				'used' => intval($_POST['used']),
				'active' => intval($_POST['active']),
		        'coupon_applied_on' => intval($_POST['coupon_applied_on']),
		        'product_list' => $product_list
			);
			if (!Filter::$id) {
				$data['created'] = "NOW()";
			}
			(Filter::$id) ? self::$db->update(self::cpTable, $data, "id=" . Filter::$id) : self::$db->insert(self::cpTable, $data);
			$message = (Filter::$id) ? Lang::$word->CPN_UPDATED : Lang::$word->CPN_ADDED;
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);
			}
			else {
				$json['type'] = 'success';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}



	/**
	 * Content::getInvites()
	 *
	 * @return
	 */
	public function getInvites()
	{
		$sql = "SELECT * FROM " . self::invTable;
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content::processInvite()
	 *
	 * @return
	 */
	public function processInvite()
	{
		Filter::checkPost('code', Lang::$word->INV_CODE);

		$valid = date("Y-m-d", strtotime($_POST['validuntil']));

		if (empty(Filter::$msgs)) {
			$data = array(
				'code' => sanitize($_POST['code']),
				'validuntil' => $valid,
				'maxusage' => intval($_POST['maxusage']),
				'used' => intval($_POST['used']),
				'active' => intval($_POST['active'])
			);
			if (!Filter::$id) {
				$data['created'] = "NOW()";
			}

			(Filter::$id) ? self::$db->update(self::invTable, $data, "id=" . Filter::$id) : self::$db->insert(self::invTable, $data);
			$message = (Filter::$id) ? Lang::$word->INV_UPDATED : Lang::$word->INV_ADDED;
			
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);
			}
			else {
				$json['type'] = 'success';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}

	

	/**
	 * Content::getContentType()
	 *
	 * @param bool $selected
	 * @return
	 */
	public static function getContentType($selected = false)
	{
		$arr = array(
			'page' => Lang::$word->MNU_TYPE_PG,
			'web' => Lang::$word->MNU_TYPE_EL
		);
		$html = '';
		foreach($arr as $key => $val) {
			if ($key == $selected) {
				$html.= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
			}
			else $html.= "<option value=\"" . $key . "\">" . $val . "</option>\n";
		}

		unset($val);
		return $html;
	}

	/**
	 * Content::getTagName()
	 *
	 * @return
	 */
	public function getTagName()
	{
		$sql = "SELECT tag FROM " . Products::tagTable . " WHERE tag = '" . self::$db->escape($this->tag) . "'";
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content::getProductList()
	 *
	 * @return
	 */
	public static function getProductList($id, $selected = false)
	{
		$sql = "SELECT id, slug, title FROM " . Products::pTable;
		$result = self::$db->fetch_all($sql);
		$display = '';
		if ($result) {
			$display.= "<select name=\"page_id\">";
			foreach($result as $row) {
				$sel = ($row->$id == $selected) ? ' selected="selected"' : null;
				$display.= "<option value=\"" . $row->$id . "\"" . $sel . ">" . $row->title . "</option>\n";
			}

			$display.= "</select>\n";
		}

		return $display;
	}

	/**
	 * Content::renderPages()
	 *
	 * @return
	 */
	public function renderPages()
	{
		$sql = "SELECT * FROM pages " . self::pTable . "\n WHERE slug = '" . $this->pageslug . "'" . "\n AND active = '1'";
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content::getCartCounterBasic()
	 *
	 * @return
	 */
	public function getCartCounterBasic()
	{
		if ($row = self::$db->first("SELECT sum(qty) as qtotal, COUNT(*) as itotal FROM " . self::crTable . " WHERE user_id = '" . Registry::get("Users")->username . "' GROUP BY user_id")) {
			$itotal = ($row->itotal == 0) ? '/' : $row->itotal;
			$qtotal = ($row->qtotal == 0) ? '/' : $row->qtotal;
			return $qtotal;
		}
		else {
			return 0;
		}
	}

	/**
	 * Content::getCartCounterCost()
	 *
	 * @return
	 */
	public function getCartCounterCost() {
		
		if ($this->ambdiscount > 0) {
			$sql = "SELECT sum((price - price * " . $this->ambdiscount . ") * qty) as ptotal FROM " . self::crTable . " WHERE user_id = '" . Registry::get("Users")->username . "' GROUP BY user_id";
		}else {
			$sql = "SELECT sum(price * qty) as ptotal FROM " . self::crTable . " WHERE user_id = '" . Registry::get("Users")->username . "' GROUP BY user_id";
		}
	
		if ($row = self::$db->first($sql)) {
			return Registry::get("Core")->formatMoney($row->ptotal);
		}
		else {
			return Registry::get("Core")->cur_symbol . '0.00';
		}
	}

	/**
	 * Content::getCartCounter()
	 *
	 * @return
	 */
	public function getCartCounter()
	{
		if ($row = self::$db->first("SELECT sum(price) as ptotal, COUNT(*) as itotal FROM " . self::crTable . " WHERE user_id = '" . Registry::get("Users")->username . "' GROUP BY user_id")) {
			$itotal = ($row->itotal == 0) ? '/' : $row->itotal;
			$ptotal = ($row->ptotal == 0) ? '/' : Registry::get("Core")->formatMoney($row->ptotal);
			print $itotal . ' item(s) / ' . $ptotal;
		}
		else {
			print '0 ' . Lang::$word->ITEMS . ' / ' . Registry::get("Core")->cur_symbol . '0.00';
		}
	}

	public

	function getCartCounterFull()
	{
		if ($row = self::$db->first("SELECT sum(price) as ptotal, COUNT(*) as itotal FROM " . self::crTable . " WHERE user_id = '" . Registry::get("Users")->username . "' GROUP BY user_id")) {
			$itotal = ($row->itotal == 0) ? '/' : $row->itotal;
			$ptotal = ($row->ptotal == 0) ? '/' : Registry::get("Core")->formatMoney($row->ptotal);
			print $itotal . ' item(s) / ' . $ptotal;
		}
		else {
			print '0 ' . Lang::$word->ITEMS . ' / ' . Registry::get("Core")->cur_symbol . '0.00';
		}
	}

	/**
	 * Content::getCartContent()
	 *
	 * @param mixed $username
	 * @return
	 */
	public function getCartContent($username = false)
	{
		$uid = ($username) ? $username : Registry::get("Users")->username;
		$sql = "SELECT c.*, p.id as pid, p.description as description, p.slug, p.title, p.price, p.nickname,p.dosage,pv.title as var_title,pv.dosage as var_dosage,pv.price as var_price, c.qty as qty, p.price * c.qty as productprice, p.thumb, COUNT(c.pid) as total" . "\n FROM " . self::crTable . " as c" .
            "\n LEFT JOIN " . Products::pTable . " as p ON p.id = c.pid" .
            "\n LEFT JOIN ". Products::pvTable . " as pv ON pv.id = c.pvid".
            "\n WHERE c.user_id = '" . self::$db->escape($uid) . "' " . "\n GROUP BY c.pid, c.pvid ORDER BY c.id DESC";
		$row = self::$db->fetch_all($sql);

		return ($row) ? $row : 0;
	}
	
	/**
	 * Content::getProvinces()
	 *
	 * @return
	 */
	public function getProvinces()
	{
		$sql = "SELECT * FROM provinces";
		$row = self::$db->fetch_all($sql);

		return ($row) ? $row : 0;
	}

	/**
	 * @param $pid
	 * @param $dosage
	 */
    public function decreaseStock($pid, $dosage)
    {
        $sql = "SELECT stock FROM products WHERE id = ".$pid;
    	$row = self::$db->first($sql);
		$stock = $row->stock;
		$stock = $stock - $dosage;
		$data = array('stock' => $stock);

		self::$db->update(Products::pTable, $data, "id=" .$pid);
  	}

	/**
	 * Content::getCartTotal()
	 *
	 * @param mixed $username
	 * @return
	 */
	public function getCartTotal($username = false)
	{
		global $db, $user;
		$uid = ($username) ? $username : $user->username;
		$sql = "SELECT sum(c.price) as total, COUNT(c.pid) as titems, e.coupon, sum(p.price) as ptotal" . "\n FROM cart as c" . "\n LEFT JOIN extras as e ON e.user_id = c.user_id" . "\n LEFT JOIN products as p ON p.id = c.pid" . "\n WHERE c.user_id = '" . $db->escape($uid) . "' AND p.price = c.price" . "\n GROUP BY c.user_id";
		$row = $db->first($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Content::getCart()
	 *
	 * @param bool $uid
	 * @return
	 */
	public static function getCart($uid = false)
	{
		$id = ($uid) ? sanitize($uid) : Registry::get("Users")->username;
		$row = Registry::get("Database")->first("SELECT * FROM " . Content::exTable . " WHERE user_id = '" . $id . "'");
		return ($row) ? $row : 0;
	}

	/**
	 * Content::getMeltable()
	 *
	 * @param mixed $username
	 * @return
	 */
	public function getMeltable($username = false)
	{
		global $db, $user;
		$uid = ($username) ? $username : $user->username;
		$sql = "SELECT c.pid as product_id, e.coupon, sum(p.price) as ptotal FROM cart as c LEFT JOIN extras as e ON e.user_id = c.user_id LEFT JOIN products as p ON p.id = c.pid WHERE c.user_id = '" . $db->escape($uid) . "' AND p.flag_meltable = 1 GROUP BY c.user_id";
		$row = $db->first($sql);
		if ($row && Registry::get("Core")->meltable_warning) {
			return 1;
		} else {
			return 0;
		}
	}

	/**
	 * Content::renderCart()
	 *
	 * @return
	 */
	public function renderCart()
	{
		//$sql = "SELECT p.id as pid, p.title, p.slug, p.price, p.thumb, p.description, c.qty as qty," . "\n COUNT(c.pid) as total" . "\n FROM " . Products::pTable . " as p" . "\n LEFT JOIN " . self::crTable . " as c ON p.id = c.pid" . "\n WHERE c.user_id = '" . self::$db->escape(Registry::get("Users")->username) . "' AND p.price = c.price" . "\n GROUP BY c.pid ORDER BY c.id DESC";
                $sql = "SELECT p.id as pid, p.title, p.slug, p.price, p.thumb, p.description, pv.title as pvtitle , pv.price as pvprice , c.qty as qty, c.pvid," . "\n COUNT(c.pid) as total" . "\n FROM " . Products::pTable . " as p" .
                        "\n LEFT JOIN " . self::crTable . " as c ON p.id = c.pid" .
                        "\n LEFT JOIN " . Products::pvTable . " as pv ON pv.id = c.pvid".
                        "\n WHERE c.user_id = '" . self::$db->escape(Registry::get("Users")->username) . "' " . "\n GROUP BY c.pid,c.pvid ORDER BY c.id DESC";
                //echo $sql;
		$row = self::$db->fetch_all($sql);
		if ($row) {
			return $row;
		}
		else {
			return 0;
		}
	}
	
	
	/**
	 * Content::calculateInvoice()
	 *
	 * @return
	 */
	public static function calculateInvoice($state = null, $shipping_type = 0, $couponCode = null)
	{
	
		$sql = "SELECT sum(price * qty) as ptotal, sum(points) as totalpoints, COUNT(*) as itotal FROM " . self::crTable . " WHERE user_id = '" . Registry::get("Users")->username . "'";
		
		$row = self::$db->first($sql);
		
		
		// if user has cart information
		if ($row) {
			
			// assign variables
			$state = null;
			$tax = 0;
			$couponAmount = 0;
			$points = $row->totalpoints;
			$payout = 0;
			
			// Get extra rows
			$exrow = self::$db->first("SELECT * FROM " . Content::exTable . " WHERE user_id = '" . Registry::get("Users")->username . "'");
			
			// If extra row exists
			if ($exrow) {
				// define variables
				$state = $exrow->state;
				$shipping_type = $exrow->shipping_type;
				$tax = self::calculateTax($state);
				
				if ($couponCode == null) {
					$couponCode = $exrow->discount_code;
				}
			}
			
			// Check if coupon code is not null
			if ($couponCode != null) {
				$coupon_row = self::$db->first("SELECT discount, type, minval, code, coupon_applied_on, product_list FROM " . self::cpTable . " WHERE code = '" . self::$db->escape($couponCode) . "' AND active = '1'");
				// payout
				$ucoupon_row = self::$db->first("SELECT payout FROM " . Users::uTable . " WHERE invite_code = '" . self::$db->escape($couponCode) . "'");
				if ($ucoupon_row->payout != null) {
					$payout = $ucoupon_row->payout;
				}
				
			}
			
			// Calculate coupon
			if ($coupon_row) {
				// if coupon is only for certain applied on
				if($coupon_row->coupon_applied_on == 1) {
					$product_list = !empty($coupon_row->product_list) ? explode(',', $coupon_row->product_list) : array();
					$cart_product_ids = self::$db->fetch_all("SELECT pid, price, qty FROM " . self::crTable . " WHERE user_id = '" . Registry::get("Users")->username . "'");
					$couponAmount = 0;
					$appliedTotal = 0;
					foreach ($cart_product_ids as $cart_product_id) {
						if(in_array($cart_product_id->pid, $product_list)){
							
							$qty = $cart_product_id->qty;
							
							// if coupon is percentage
							if ($coupon_row->type == 0) {
								$product_discount = $qty * (number_format($cart_product_id->price / 100 * $coupon_row->discount, 2));
								$couponAmount = $couponAmount + $product_discount;
								$points = $row->totalpoints - ($row->totalpoints * $coupon_row->discount / 100);
							}
							// if coupon is dollar based
							else {
							
								$appliedTotal = $appliedTotal + $cart_product_id->price;
								
								if($coupon_row->discount >= $appliedTotal ){
									$couponAmount = $appliedTotal;
									$points = $row->totalpoints - $appliedTotal;
								}else{
									$couponAmount = number_format($coupon_row->discount, 2);
									$points = $row->totalpoints - $coupon_row->discount;
								}
							}
						}
					}
				}
				
				// if coupon is percentage
				elseif ($coupon_row->type == 0) {
					$couponAmount = number_format($row->ptotal / 100 * $coupon_row->discount, 2);
					$points = $row->totalpoints - ($row->totalpoints * $coupon_row->discount / 100);
				}
				// if coupon is dollar based
				else {
					if ($coupon_row->discount >= $row->ptotal) {
						$couponAmount = number_format($row->ptotal, 2);
						$points = $row->totalpoints - $row->ptotal;
					}else {
						$couponAmount = number_format($coupon_row->discount, 2);
						$points = $row->totalpoints - $coupon_row->discount;
					}
				}
			}
			// check if ambassador code
			elseif ($ucoupon_row->payout != null) {
				$couponAmount = number_format($row->ptotal * (Registry::get("Core")->payout - $ucoupon_row->payout) / 100, 2);
				$points = $row->totalpoints - ($row->totalpoints * (Registry::get("Core")->payout - $ucoupon_row->payout) / 100);
			}
			
			
			
			// Calculate shipping costs (0 = standard, 1 = express)
			if ($shipping_type == 1) {
				$shipping_cost = self::calculateExpressShipping($state);
			}else {
				$shipping_cost = self::calculateStandardShipping($state);
			}
			
			
			$gtotal = number_format($row->ptotal, 2);
	
			$total = max($row->ptotal - $couponAmount,0) + $shipping_cost;
			$totaltax = $total * $tax;
			$totalprice = $total + $totaltax;
			
			
			$xdata = array(
				'user_id' => Registry::get("Users")->username,
				'discount_code' => $couponCode,
				'coupon' => $couponAmount,
				'originalprice' => $row->ptotal,
				'shipping' => $shipping_cost,
				'shipping_type' => $shipping_type,
				'tax' => $tax,
				'totaltax' => max($totaltax, 0),
				'total' => max($total, 0),
				'totalprice' => max($totalprice, 0),
				'points' => max($points, 0),
				'payout' => $payout,
				'created' => "NOW()"
			);
			
			// If extra row exists
			if ($exrow) {
				self::$db->update(self::exTable, $xdata, "user_id = '" . Registry::get("Users")->username . "'");
			}else {
				self::$db->delete(self::exTable, "user_id = '" . Registry::get("Users")->username . "'");
				self::$db->insert(self::exTable, $xdata);
			}
			
			return $xdata;
		}
		
	}
	
	

	/**
	 * Content::calculateTax()
	 *
	 * @param bool $uid
	 * @return
	 */
	public static function calculateTax($state = null)
	{
		if ($state) {
			$row = Registry::get("Database")->first("SELECT vat FROM " . Content::provTable . " WHERE abbr = '" . $state . "'");
			
			if ($row->vat > 0) {
				return ($row->vat / 100);
			}else {
				return 0.13;
			}
			
		}elseif (Registry::get("Users")->logged_in) {
			$state = Registry::get("Database")->first("SELECT state FROM " . Users::uTable . " WHERE id = " . Registry::get("Users")->uid);
			$row = Registry::get("Database")->first("SELECT vat FROM " . Content::provTable . " WHERE abbr = '" . $state->state . "'");
			
			if ($row->vat > 0) {
				return ($row->vat / 100);
			}else {
				return 0.13;
			}
			
		}
		else {
			return 0.13;
		}
	}
	
	
	/**
	 * Content::calculateStandardShipping()
	 *
	 * @param bool $uid
	 * @return
	 */
	public static function calculateStandardShipping($state = null)
	{
		
		$sql = "SELECT sum(price * qty) as ptotal FROM " . self::crTable . " WHERE user_id = '" . Registry::get("Users")->username . "' GROUP BY user_id";

		if ($row = self::$db->first($sql)) {
			
			if ($row->ptotal > Registry::get("Core")->shipping_free_flag) {
				return 0;
			}
			elseif ($state) {
				$row = Registry::get("Database")->first("SELECT shipping_cost FROM " . Content::provTable . " WHERE abbr = '" . $state . "'");
				
				//1.10 is the default
				if ($row->shipping_cost == null) {
					return (1.10 + Registry::get("Core")->shipping_standard);
				}
				return ($row->shipping_cost + Registry::get("Core")->shipping_standard);
			}
			else {
				return (Registry::get("Core")->shipping_standard);
			}
			
		}
		
	}
	
	
	/**
	 * Content::calculateExpressShipping()
	 *
	 * @param bool $uid
	 * @return
	 */
	public static function calculateExpressShipping($state = null)
	{
	
		$sql = "SELECT sum(price * qty) as ptotal FROM " . self::crTable . " WHERE user_id = '" . Registry::get("Users")->username . "' GROUP BY user_id";

		if ($row = self::$db->first($sql)) {
			
			if ($state) {
				$row = Registry::get("Database")->first("SELECT shipping_cost FROM " . Content::provTable . " WHERE abbr = '" . $state . "'");
				
				//1.10 is the default
				if ($row->shipping_cost == null) {
					return (1.10 + Registry::get("Core")->shipping_express);
				}
				return ($row->shipping_cost + Registry::get("Core")->shipping_express);
			}
			else {
				return (Registry::get("Core")->shipping_express);
			}
			
		}
		
	}
	
	
	/**
	* Content::countUserOrders()
	*
	* @param mixed $user_id
	* @return
	*/
	public function countUserOrders($user_id)
	{
		$sql = self::$db->query("SELECT invid FROM " . self::inTable . " WHERE user_id = '" . $user_id . "'");
		
		return self::$db->numrows($sql);
	}
	
	

	/**
	 * Content::renderMetaData()
	 *
	 * @return
	 */
	public function renderMetaData($row)
	{

		// $row = isset($row) ? $row : null;

		$sep = " | ";
		$meta = "<meta charset=\"utf-8\">\n";
		$meta.= "<title>" . Registry::get("Core")->site_name;
		if ($this->catslug and $row) {
			$meta.= $sep . $row->name;
		}
		elseif (Registry::get("Products")->itemslug and $row) {
			$meta.= $sep . $row->title;
		}
		elseif ($this->pageslug and $row) {
			$meta.= $sep . $row->title;
		}
		elseif ($this->tag and $row) {
			$meta.= $sep . $row->tag;
		}

		$meta.= "</title>\n";
		$meta.= "<meta name=\"keywords\" content=\"";
		if ($this->catslug and $row) {
			if ($row->metakeys) {
				$meta.= $row->metakeys;
			}
			else {
				$meta.= Registry::get("Core")->metakeys;
			}
		}
		elseif (Registry::get("Products")->itemslug and $row) {
			if ($row->metakeys) {
				$meta.= $row->metakeys;
			}
			else {
				$meta.= Registry::get("Core")->metakeys;
			}
		}
		else {
			$meta.= Registry::get("Core")->metakeys;
		}

		$meta.= "\" />\n";
		$meta.= "<meta name=\"description\" content=\"";
		if ($this->catslug and $row) {
			if ($row->metadesc) {
				$meta.= $row->metadesc;
			}
			else {
				$meta.= Registry::get("Core")->metakeys;
			}
		}
		elseif (Registry::get("Products")->itemslug and $row) {
			if ($row->metadesc and $row) {
				$meta.= $row->metadesc;
			}
			else {
				$meta.= Registry::get("Core")->metakeys;
			}
		}
		else {
			$meta.= Registry::get("Core")->metakeys;
		}

		$meta.= "\" />\n";
		$meta.= "<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"" . SITEURL . "/assets/favicon.ico\" />\n";
		$meta.= "<meta name=\"dcterms.rights\" content=\"" . Registry::get("Core")->company . " &copy; All Rights Reserved\" >\n";
		$meta.= "<meta name=\"robots\" content=\"index, follow\" />\n";
		$meta.= "<meta name=\"revisit-after\" content=\"1 day\" />\n";
		$meta.= "<meta name=\"generator\" content=\"Powered by DDP v" . Registry::get("Core")->version . "\" />\n";
		$meta.= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\" />\n";
		return $meta;
	}
	
	/**
	* Content::articleSlugExists()
	*
	* @param mixed $email
	* @return
	*/
	private function articleSlugExists($slug, $big)
	{
	  $sql = self::$db->query("SELECT slug FROM " . self::bTable . " WHERE slug = '" . sanitize($slug) . "' AND id != '" . sanitize($big) . "' LIMIT 1");
	
	  if (self::$db->numrows($sql) == 1) {
	      return true;
	  } else
	      return false;
	}
	
	/**
	* Content::discountExists()
	*
	* @param mixed $discount
	* @return
	*/
	private function discountExists($discount)
	{
	  $sql = self::$db->query("SELECT title FROM " . self::cpTable . " WHERE title = '" . sanitize($discount) . "' LIMIT 1");
	
	  if (self::$db->numrows($sql) == 1) {
	      return true;
	  } else
	      return false;
	}
	
	
}
