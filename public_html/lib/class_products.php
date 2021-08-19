<?php
/**
 * Products Class
 *
 * @package FBC Studio
 * @author fbcstudio.com
 * @copyright 2010
 * @version $Id: class_products.php, v2.00 2011-07-10 10:12:05 gewa Exp $
 */

if (!defined("_VALID_PHP")) die('Direct access to this location is not allowed.');

class Products
{
	const pTable = "products";
	const pvTable = "product_variants";
	const tTable = "transactions";
	const inTable = "invoices";
	const phTable = "photos";
	const fTable = "files";
	const rTable = "recent";
	const sTable = "stats";
	public $itemslug = null;

	private static $db;

	public static $gfileext = array(
		"jpg",
		"jpeg",
		"png"
	);
	/**
	 * Products::__construct()
	 *
	 * @return
	 */
	public function __construct()
	{
		self::$db = Registry::get("Database");
		$this->getProductSlug();
	}

    /**
     * @param $productID
     * @return integer
     */
	public function checkProductStock($productID)
    {
        $query = "SELECT stock FROM " . self::pTable ." WHERE id = " . $productID;

        $record = self::$db->query($query);
        $total = self::$db->fetchrow($record);
        $stock = $total[0];

        return (integer) $stock;
    }

	/**
	 * Products::getProductSlug()
	 *
	 * @return
	 */
	private function getProductSlug()
	{
		if (isset($_GET['itemname'])) {
			$this->itemslug = sanitize($_GET['itemname'], 100);
			return self::$db->escape($this->itemslug);
		}
	}

    /**
     * Products::getProducts()
     *
     * @param string $from
     * @return int
     */
	public function getProducts($from = '')
	{
		if (isset($_GET['letter']) and (isset($_POST['fromdate']) && $_POST['fromdate'] <> "" || isset($from) && $from != '')) {
			$enddate = date("Y-m-d");
			$letter = sanitize($_GET['letter'], 2);
			$fromdate = (empty($from)) ? $_POST['fromdate'] : $from;
			if (isset($_POST['enddate']) && $_POST['enddate'] <> "") {
				$enddate = $_POST['enddate'];
			}

			$q = "SELECT COUNT(*) FROM " . self::pTable . " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' AND title REGEXP '^" . self::$db->escape($letter) . "'";
			$where = " WHERE p.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' AND title REGEXP '^" . self::$db->escape($letter) . "'";
		} elseif (isset($_POST['fromdate']) && $_POST['fromdate'] <> "" || isset($from) && $from != '') {
			$enddate = date("Y-m-d");
			$fromdate = (empty($from)) ? $_POST['fromdate'] : $from;

			if (isset($_POST['enddate']) && $_POST['enddate'] <> "") {
				$enddate = $_POST['enddate'];
			}

			$q = "SELECT COUNT(*) FROM " . self::pTable . " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
			$where = " WHERE p.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
		} elseif (isset($_GET['letter'])) {
			$letter = sanitize($_GET['letter'], 2);
			$where = "WHERE title REGEXP '^" . self::$db->escape($letter) . "'";
			$q = "SELECT COUNT(*) FROM " . self::pTable . " WHERE title REGEXP '^" . self::$db->escape($letter) . "' LIMIT 1";
		} else {
			$q = "SELECT COUNT(*) FROM " . self::pTable . " LIMIT 1";
			$where = null;
		}

		$record = self::$db->query($q);
		$total = self::$db->fetchrow($record);
		$counter = $total[0];
		$pager = Paginator::instance();
		$pager->items_total = $counter;
		$pager->default_ipp = Registry::get("Core")->perpage;
		$pager->paginate();
		$sql = "SELECT p.*, p.id as pid, c.name, c.id as cid, (SELECT SUM(item_qty) FROM " . self::tTable . " WHERE pid = p.id) as sales FROM " . self::pTable . " as p LEFT JOIN " . Content::cTable . " as c ON c.id = p.cid $where ORDER BY p.created DESC" . $pager->limit;
		$row = self::$db->fetch_all($sql);

		return ($row) ? $row : 0;
	}

	/**
	 * Products:::addProduct()
	 *
	 * @return
	 */
	public function addProduct()
	{
		// Sanity checks
		Filter::checkPost('title', Lang::$word->PRD_NAME);
		Filter::checkPost('price', Lang::$word->PRD_PRICE);
		Filter::checkPost('slug', Lang::$word->PRD_PRICE);

		if (!empty($_FILES['thumb']['name'])) {
			if (!preg_match("/(\.jpg|\.png)$/i", $_FILES['thumb']['name'])) $core->msgs['thumb'] = Lang::$word->PRD_IMG_R;
		}

		if (empty(Filter::$msgs)) {

			$data = array(
				'title' => sanitize($_POST['title']),
				'brand' => sanitize($_POST['brand']),
				'slug' => sanitize($_POST['slug']),
				'cid' => intval($_POST['cid'][0]),
				'price' => floatval($_POST['price']),
				'sale_price' => floatval($_POST['sale_price']),
				'dosage' => intval($_POST['dosage']),
				'pieces' => intval($_POST['pieces']),
				'weight' => intval($_POST['weight']),
				'size' => intval($_POST['size']),
				'points' => intval($_POST['points']),
				'nickname' => sanitize($_POST['nickname']),
				'description' => sanitize($_POST['description']),
				'metakeys' => sanitize($_POST['metakeys']),
				'body' => $_POST['body'],
				'stock' => intval($_POST['stock']),
				'soldflag' => intval($_POST['soldflag']),
				'flag_limited' => intval($_POST['flag_limited']),
				'flag_sale' => intval($_POST['flag_sale']),
				'flag_meltable' => intval($_POST['flag_meltable']),
				'flag_multiple' => intval($_POST['hdn_product_type']),
				'active' => intval($_POST['active']),
				'flag_vegan' => intval($_POST['flag_vegan']),
				'flag_organic' => intval($_POST['flag_organic']),
				'flag_blacklabel' => intval($_POST['flag_blacklabel'])
			);

			if (!Filter::$id) {
				$data['created'] = "NOW()";
			}

			// Process Thumb
			if (!empty($_FILES['thumb']['name'])) {
				$thumbdir = UPLOADS . "prod_images/";
				$tName = "img_" . sanitize($_POST['slug']);
				$text = substr($_FILES['thumb']['name'], strrpos($_FILES['thumb']['name'], '.') + 1);
				$thumbName = $thumbdir . $tName . "." . strtolower($text);
				if (Filter::$id && $thumb = getValueById("thumb", self::pTable, Filter::$id)) {
					@unlink($thumbdir . $thumb);
				}

				move_uploaded_file($_FILES['thumb']['tmp_name'], $thumbName);
				$data['thumb'] = $tName . "." . strtolower($text);
			}

			// Add to database
			(Filter::$id) ? self::$db->update(self::pTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::pTable, $data);
			$message = (Filter::$id) ? Lang::$word->PRD_UPDATED : Lang::$word->PRD_ADDED;

			if (Filter::$id) {
				$lastid = Filter::$id;
			}

			if ($lastid && intval($_POST['hdn_product_type'])) {
			  for( $i=0; $i<count($_POST['title_multi']); $i++ ){
							// (Filter::$id) ? self::$db->update(self::pTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::pTable, $data);
			      $var_data = array(
			          'pid' => $lastid,
			          'title' => sanitize($_POST['title_multi'][$i]),
			          'price' => floatval($_POST['price_multi'][$i]),
			          'weight' => floatval($_POST['weight_multi'][$i]),
			          'dosage' => floatval($_POST['dosage_multi'][$i]),
			          'sale_price' => floatval($_POST['sale_price_multi'][$i])
			      );
			      $varid = self::$db->insert(self::pvTable, $var_data);
			  }
			}
			
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);
			} else {
				$json['type'] = 'success';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
			

		} else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}


	/**
	 * Products:::updateProduct()
	 *
	 * @return
	 */
	public function updateProduct()
	{
		// Sanity checks
		Filter::checkPost('title', Lang::$word->PRD_NAME);
		Filter::checkPost('price', Lang::$word->PRD_PRICE);
		Filter::checkPost('slug', Lang::$word->PRD_SLUG);

		if (!empty($_FILES['thumb']['name'])) {
			if (!preg_match("/(\.jpg|\.png)$/i", $_FILES['thumb']['name'])) $core->msgs['thumb'] = Lang::$word->PRD_IMG_R;
		}

		if ($this->slugExists($slug) && !Filter::$id) Filter::$msgs['slug'] = Lang::$word->PRD_SLUG_R4;

		// If no error messages
		if (empty(Filter::$msgs)) {

			$data = array(
				'title' => sanitize($_POST['title']),
				'brand' => sanitize($_POST['brand']),
				'slug' => sanitize($_POST['slug']),
				'cid' => intval($_POST['cid'][0]),
				'price' => floatval($_POST['price']),
				'sale_price' => floatval($_POST['sale_price']),
				'dosage' => intval($_POST['dosage']),
				'pieces' => intval($_POST['pieces']),
				'weight' => intval($_POST['weight']),
				'size' => intval($_POST['size']),
				'points' => intval($_POST['points']),
				'nickname' => sanitize($_POST['nickname']),
				'description' => sanitize($_POST['description']),
				'metakeys' => sanitize($_POST['metakeys']),
				'body' => $_POST['body'],
				'stock' => intval($_POST['stock']),
				'soldflag' => intval($_POST['soldflag']),
				'flag_limited' => intval($_POST['flag_limited']),
				'flag_sale' => intval($_POST['flag_sale']),
				'flag_meltable' => intval($_POST['flag_meltable']),
				'flag_multiple' => intval($_POST['hdn_product_type']),
				'active' => intval($_POST['active']),
				'flag_vegan' => intval($_POST['flag_vegan']),
				'flag_organic' => intval($_POST['flag_organic']),
				'flag_blacklabel' => intval($_POST['flag_blacklabel'])
			);

			// If doesn't exist, created date is current date
			if (!Filter::$id) {
				$data['created'] = "NOW()";
			}

			// Process Thumb
			if (!empty($_FILES['thumb']['name'])) {
				$thumbdir = UPLOADS . "prod_images/";
				$tName = "img_" . sanitize($_POST['slug']);
				$text = substr($_FILES['thumb']['name'], strrpos($_FILES['thumb']['name'], '.') + 1);
				$thumbName = $thumbdir . $tName . "." . strtolower($text);
				if (Filter::$id && $thumb = getValueById("thumb", self::pTable, Filter::$id)) {
					@unlink($thumbdir . $thumb);
				}

				move_uploaded_file($_FILES['thumb']['tmp_name'], $thumbName);
				$data['thumb'] = $tName . "." . strtolower($text);
			}

			// Add to database
			(Filter::$id) ? self::$db->update(self::pTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::pTable, $data);
			$message = (Filter::$id) ? Lang::$word->PRD_UPDATED : Lang::$word->PRD_ADDED;
			if (Filter::$id) {
				$lastid = Filter::$id;
			}
			
			
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);
			}
			else {
				$json['type'] = 'success';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);

			// Add variants
			if($lastid && intval($_POST['hdn_product_type'])){
			
				$arr_edited_ids = array();
			
				foreach( $_POST['title_multi'] as $pvk => $pvv ) {
					// (Filter::$id) ? self::$db->update(self::pTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::pTable, $data);
					$var_data = array(
						'pid' => $lastid,
						'title' => sanitize($_POST['title_multi'][$pvk]),
						'price' => floatval($_POST['price_multi'][$pvk]),
						'weight' => floatval($_POST['weight_multi'][$pvk]),
						'dosage' => floatval($_POST['dosage_multi'][$pvk]),
						'sale_price' => floatval($_POST['sale_price_multi'][$pvk])
					);
					$edit_id = self::checkProductVariant( $pvk, $lastid );
					
					if( $edit_id == 0 ){
						$varid = self::$db->insert(self::pvTable, $var_data);
						$arr_edited_ids[] = $varid;
					} else {
						$varid = self::$db->update( self::pvTable, $var_data, "id=" . $pvk );
						$arr_edited_ids[] = $pvk;
					}
					
					if (self::$db->affected()) {
						$json['type'] = 'success';
						$json['message'] = Filter::msgOk($message, false);
					}
					
				}
				self::deleteProductVariant( Filter::$id, $arr_edited_ids);
			}


		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}
	
	
	
	/**
	*
	* @param type $id
	* @param type $pid
	* @return type
	*/
	public function checkProductVariant( $id, $pid ){
	  $sql = "SELECT id, pid, title, price, dosage, sale_price "
	          . "FROM " . self::pvTable . " "
	          . "WHERE id = " . $id . " AND pid = " . $pid;
	  $row = self::$db->fetch_all($sql);
	  return ($row) ? $row : 0;
	}
	
	/**
	*
	* @param type $id
	* @param type $pid
	* @return type
	*/
	public function deleteProductVariant( $pid, $edited_id ){
	  $sql = "DELETE "
	          . "FROM " . self::pvTable . " "
	          . "WHERE pid = " . $pid . " "
	          . "AND id NOT IN ( " . implode( ',', $edited_id ) ." ) ";
	
	  $row = self::$db->fetch_all($sql);
	  return ($row) ? $row : 0;
	}

    /**
     *
     * @param type $id
     * @param int $pvid
     * @return type
     */
	public function getProductVariants($id, $pvid = 0)
    {
	  $whr_pv = '';
	  if( $pvid > 0 ){
	      $whr_pv = ' AND id = ' . $pvid . ' ';
	  }
	  $sql = "SELECT id, pid, title, price, dosage, weight, sale_price "
	          . "FROM " . self::pvTable . " "
	          . "WHERE pid = " . $id . $whr_pv . " ORDER BY price ASC ";
	  $row = self::$db->fetch_all($sql);

	  return ($row) ? $row : 0;
	}
  
    /**
     *
     * @param type $id
     * @param int $pvid
     * @return type
     */
	public static function getProductVariantsStatic($id, $pvid = 0)
    {
	  $whr_pv = '';
	  if( $pvid > 0 ){
	      $whr_pv = ' AND id = ' . $pvid . ' ';
	  }
	  $sql = "SELECT id, pid, title, price, dosage, weight, sale_price "
	          . "FROM " . self::pvTable . " "
	          . "WHERE pid = " . $id . $whr_pv . " ORDER BY price ASC ";
	  $row = self::$db->fetch_all($sql);

	  return ($row) ? $row : 0;
	}

	/**
	*
	* @param type $id
	* @param type $pvid
	* @return type
	*/
	public function getVariantsPrice( $id, $pvid = 0 ){
	  $whr_pv = '';
	  if( $pvid > 0 ){
	      $whr_pv = ' AND id = ' . $pvid . ' ';
	  }
	  $sql = "SELECT MIN(price) as min_price, MAX(price) as max_price, MIN(sale_price) as sale_min_price, MAX(sale_price) as sale_max_price "
	          . "FROM " . self::pvTable . " "
	          . "WHERE pid = " . $id . $whr_pv;
	  $row = self::$db->fetch_all($sql);
	  return ($row) ? $row[0] : 0;
	}


	/**
	* User::slugExists()
	*
	* @param mixed $email
	* @return
	*/
	private function slugExists($slug)
	{
	  $sql = self::$db->query("SELECT slug"
	  . "\n FROM " . self::pTable
	  . "\n WHERE slug = '" . sanitize($slug) . "'"
	  . "\n LIMIT 1");
	
	  if (self::$db->numrows($sql) == 1) {
	      return true;
	  } else
	      return false;
	}
	
	/**
	* User::invoiceExists()
	*
	* @param mixed $invid
	* @return
	*/
	private function invoiceExists($invid)
	{
	  $sql = self::$db->query("SELECT invid FROM " . self::inTable . " WHERE invid = '" . sanitize($invid) . "' LIMIT 1");
	
	  if (self::$db->numrows($sql) == 1) {
	      return true;
	  } else
	      return false;
	}
	
  	
	/**
	 * Products::doStats()
	 *
	 * @return
	 */
	private function doStats($pid)
	{
		if (@getenv("HTTP_CLIENT_IP")) {
			$vInfo['ip'] = getenv("HTTP_CLIENT_IP");
		}
		elseif (@getenv("HTTP_X_FORWARDED_FOR")) {
			$vInfo['ip'] = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (@getenv('REMOTE_ADDR')) {
			$vInfo['ip'] = getenv('REMOTE_ADDR');
		}
		elseif (isset($_SERVER['REMOTE_ADDR'])) {
			$vInfo['ip'] = $_SERVER['REMOTE_ADDR'];
		}
		else {
			$vInfo['ip'] = "Unknown";
		}
	
		if (!preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/i", $vInfo['ip']) && $vInfo['ip'] != "Unknown") {
			$pos = strpos($vInfo['ip'], ",");
			$vInfo['ip'] = substr($vInfo['ip'], 0, $pos);
			if ($vInfo['ip'] == "") $vInfo['ip'] = "Unknown";
		}
	
		$vInfo['ip'] = str_replace("[^0-9\.]", "", $vInfo['ip']);
		setcookie("DDP_hitcookie", time(), time() + 3600);
		$vCookie['is_cookie'] = (isset($_COOKIE['DDP_hitcookie'])) ? 1 : 0;
		$date = date('Y-m-d');
		$sql = "SELECT * FROM " . self::sTable . " WHERE day='" . $date . "' AND pid = $pid";
		$row = self::$db->first($sql);
		if ($row) {
			$hid = intval($row->id);
			$stats['hits'] = "INC(1)";
			self::$db->update(self::sTable, $stats, "id='" . $hid . "'");
			if (!isset($_COOKIE['DDP_unique']) && $vCookie['is_cookie']) {
				setcookie("DDP_unique", time(), time() + 3600);
				$stats['uhits'] = "INC(1)";
				self::$db->update(self::sTable, $stats, "id='" . $hid . "'");
			}
		}
		else {
			$data = array(
				'pid' => $pid,
				'day' => $date,
				'hits' => 1,
				'uhits' => 1,
			);
			self::$db->insert(self::sTable, $data);
		}
	}

	/**
	 * Products::renderProduct()
	 *
	 * @return
	 */
	public function renderProduct()
	{
		$is_admin = Registry::get("Users")->is_Admin() ? null : "AND p.active = 1";
		$sql = "SELECT p.*, p.id as pid, c.name, c.id as cid, c.slug as cslug," . " (SELECT COUNT(pid) FROM " . self::tTable . " WHERE pid = p.id) as purchased," . " (SELECT SUM(hits) FROM " . self::sTable . " WHERE pid = p.id) as hits" . " FROM " . self::pTable . " as p" . " LEFT JOIN " . Content::cTable . " as c ON c.id = p.cid" . " WHERE p.slug = '" . $this->itemslug . "'" . " $is_admin";
		$row = self::$db->first($sql);
		if ($row) {
			//$this->updateRecentViews($row->pid);
			$this->doStats($row->pid);
			return $row;
		}
		else return 0;
	}
	

	/**
	 * Products::renderRecentViews()
	 *
	 * @return
	 */
	public function renderRecentViews()
	{
		$sql = "SELECT r.*, p.id as pid, p.title, p.slug, p.thumb, p.price FROM " . self::rTable . " as r LEFT JOIN " . self::pTable . " as p ON p.id = r.pid WHERE r.user_id = '" . self::$db->escape(Registry::get("Users")->username) . "' GROUP BY r.pid ORDER BY p.title LIMIT 10";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Products::renderOtherProducts()
	 *
	 * @return
	 */
	public function renderOtherProducts($current)
	{
		$sql = "SELECT p.*, p.id as pid, c.name, c.id as cid FROM " . self::pTable . " as p LEFT JOIN " . Content::cTable . " as c ON c.id = p.cid WHERE p.id != '" . $current . "' AND p.active = '1' ORDER BY p.title LIMIT 10";
		
		
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Products::getLatestProducts()
	 *
	 * @return
	 */
	public function getLatestProducts()
	{
		$sql = "SELECT p.*, p.id as pid, c.name, c.slug as catslug, c.id as cid, (SELECT SUM(hits) FROM " . self::sTable . " WHERE pid = p.id) as hits FROM " . self::pTable . " as p LEFT JOIN categories as c ON c.id = p.cid WHERE p.active = 1 ORDER BY p.created DESC LIMIT 0," . Registry::get('Core')->featured;
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}


        /**
	 * Products::addTempFiles()
	 *
	 * @return
	 */
	public function addTempFiles()
	{
		$i = 0;
		foreach($_POST['tempfiles'] as $file) {
			$i++;
			$data = array(
				'alias' => $file,
				'name' => $file,
				'filesize' => filesize(Registry::get("Core")->file_dir . $file),
				'created' => "NOW()"
			);
			self::$db->insert(self::fTable, $data);
		}

		if (self::$db->affected()):
			$json['type'] = 'success';
			$json['title'] = Lang::$word->SUCCESS;
			$json['message'] = str_replace("FILES", $i, Lang::$word->FLM_UADDED_OK);
		else:
			$json['type'] = 'warning';
			$json['title'] = Lang::$word->ALERT;
			$json['message'] = Lang::$word->NOPROCCESS;
		endif;
		print json_encode($json);
	}

	/**
	 * Products::getPayments()
	 *
	 * @param bool $where
	 * @param bool $from
	 * @return
	 */
	public function getPayments($from = false)
	{
		if (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '') {
			$enddate = date("Y-m-d");
			$fromdate = (empty($from)) ? $_POST['fromdate_submit'] : $from;
			if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
				$enddate = $_POST['enddate_submit'];
			}

			$q = "SELECT COUNT(*) FROM " . self::tTable . " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
			$where = " WHERE t.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
		}
		else {
			$q = "SELECT COUNT(*) FROM " . self::tTable . " LIMIT 1";
			$where = null;
		}

		$record = self::$db->query($q);
		$total = self::$db->fetchrow($record);
		$counter = $total[0];
		$pager = Paginator::instance();
		$pager->items_total = $counter;
		$pager->default_ipp = Registry::get("Core")->perpage;
		$pager->paginate();
		$sql = "SELECT t.*, t.id as id, u.id as uid, u.username, p.id as pid, p.title FROM " . self::tTable . " as t LEFT JOIN " . Users::uTable . " as u ON u.id = t.uid LEFT JOIN " . self::pTable . " as p ON p.id = t.pid " . $where . " ORDER BY t.created DESC" . $pager->limit;
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}




	/**
	 * Products::processTransaction()
	 *
	 * @return
	 */
	public function processTransaction()
	{
		if (!Filter::$id) {
			Filter::checkPost('pid', Lang::$word->TXN_SELP);
			Filter::checkPost('uid', Lang::$word->TXN_SELUSER);
			Filter::checkPost('created', Lang::$word->TXN_DATE);
		}

		if (empty(Filter::$msgs)) {
			if (!Filter::$id) {
				$row = Registry::get("Core")->getRowById(self::pTable, intval($_POST['pid']));
				$email = getValueById("username", Users::uTable, intval($_POST['uid']));
				$data = array(
					'txn_id' => "MAN_" . time(),
					'pid' => intval($row->id),
					'uid' => intval($_POST['uid']),
					'created' => sanitize($_POST['created_submit']) . ' ' . date('H:i:s'),
					'payer_email' => sanitize($email),
					'payer_status' => "verified",
					'item_qty' => intval($_POST['item_qty']),
					'price' => floatval($row->price),
					'currency' => Registry::get("Core")->currency,
					'pp' => sanitize($_POST['pp']),
					'memo' => sanitize($_POST['memo']),
					'status' => 1,
					'active' => 1
				);
			}

			if (Filter::$id) {
				$edata = array(
					'price' => intval($_POST['price']),
					'item_qty' => intval($_POST['item_qty']),
					'currency' => Registry::get("Core")->currency,
					'pp' => sanitize($_POST['pp']),
					'status' => floatval($_POST['status']),
					'active' => intval($_POST['active']),
					'memo' => sanitize($_POST['memo'])
				);
			}

			(Filter::$id) ? self::$db->update(self::tTable, $edata, "id=" . Filter::$id) : self::$db->insert(self::tTable, $data);
			$message = (Filter::$id) ? Lang::$word->TXN_UPDATED : Lang::$word->TXN_ADDED;
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);
			}
			else {
				$json['type'] = 'info';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
			if (isset($_POST['notify']) && intval($_POST['notify']) == 1) {
				$username = getValueById("username", Users::uTable, $data['uid']);
				require_once (BASEPATH . "lib/class_mailer.php");

				$mailer = Mailer::sendMail();
				$row2 = Registry::get("Core")->getRowById("email_templates", 9);
				$body = str_replace(array(
					'[USERNAME]',
					'[ITEMNAME]',
					'[PRICE]',
					'[QTY]',
					'[SITE_NAME]',
					'[URL]'
				), array(
					$username,
					$row->title,
					$row->price,
					$data['item_qty'],
					Registry::get("Core")->site_name,
					SITEURL
				), $row2->body);
				$message = Swift_Message::newInstance()->setSubject($row2->subject)->setTo(array(
					$email => $username
				))->setFrom(array(
					Registry::get("Core")->site_email => Registry::get("Core")->company
				))->setBody(cleanOut($body), 'text/html');
				$mailer->send($message);
			}
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}





	/**
	 * Products::updateInvoice()
	 *
	 * @return
	 */
	public function updateInvoice()
	{

		$receiptProducts = $this->getReceiptProducts($_POST['invid']);
		
		$data = array(
			'name' => sanitize($_POST['name']),
			'address' => sanitize($_POST['address_1']),
			'address2' => sanitize($_POST['address_2']),
			'phone' => sanitize($_POST['phone']),
			'city' => sanitize($_POST['city']),
			'state' => sanitize($_POST['state']),
			'zip' => sanitize($_POST['zip']),
			'status' => floatval($_POST['status']),
			'trackingnum' => sanitize($_POST['trackingnum']),
			'note' => sanitize($_POST['note'])
		);

		self::$db->update(self::inTable, $data, "id=" . Filter::$id);
		$message = Lang::$word->TXN_UPDATED;
		
		
		if (!$this->invoiceExists($_POST['invid-new'])) {
			// Up[date invoice table with new invoice id
			$data['invid'] = sanitize($_POST['invid-new']);
			self::$db->update(self::inTable, $data, "id=" . Filter::$id);
			// Update transaction table
			$xdata['txn_id'] = sanitize($_POST['invid-new']);
			self::$db->update(self::tTable, $xdata, "txn_id = '" . $_POST['invid'] . "'");
		}else {
			$data['invid'] = $_POST['invid'];
		}
		
		
		if (self::$db->affected()) {
			$json['type'] = 'success';
			$json['message'] = Filter::msgOk($message, false);
			
			// check if points added to account from etransfer update
			$receiptInvoice = $this->getReceiptInvoice($_POST['invid']);
			if ($receiptInvoice->pp == 'eTransfer' && $receiptInvoice->points_transferred == 0 && floatval($_POST['status']) == 1) {
				$usersql = "SELECT * FROM users WHERE id = '" . $receiptInvoice->user_id . "'";
				$user_row = self::$db->first($usersql);
				
				$udata = array(
					'points_current' => $user_row->points_current + $receiptInvoice->points,
					'points_lifetime' => $user_row->points_lifetime + $receiptInvoice->points
				);
				self::$db->update(Users::uTable, $udata, "id='" . $receiptInvoice->user_id . "'");
				
				$data['points_transferred'] = 1;
				self::$db->update(self::inTable, $data, "id=" . Filter::$id);
			}

			
			// If notification is set to 1
			if (isset($_POST['notify']) && intval($_POST['notify']) == 1) {
				// Send email
				require_once (BASEPATH . "lib/class_mailer.php");

				if (sanitize($_POST['trackingnum'])) {
					$template = file_get_contents('../templates_email/email_shipped.html');
					$subjectLine = "Your order has shipped!";

				}else {
					$template = file_get_contents('../templates_email/email_shipped2.html');
					$subjectLine = "Your order is on its way";
				}

				$items_purchased = '';
				foreach ($receiptProducts as $rpRow) {

					if ($rpRow->flag_multiple) {
						$ptitle = $rpRow->title . " (" . $rpRow->variantTitle . ")";
					}else {
						$ptitle = $rpRow->title;
					}
					
					if ($receiptInvoice->pp == "Points") {
						$items_purchased .= '<tr style="font-size: 12px;">';
						$items_purchased .= '<td align="left" valign="middle"><p style="font-size: 14px; margin: 0 0 6px; line-height: 1;">' . $ptitle . '</p><p style="letter-spacing: 1px;color: #a2a2a2;">' . $rpRow->item_qty . ' x ' . number_format($rpRow->price, 0, '.', '') . ' pts</p></td>';
						$items_purchased .= '<td align="right" valign="middle"><p style="letter-spacing: 1px;">' . number_format($rpRow->price * $rpRow->item_qty, 0, '.', '') . ' pts</p></td>';
						$items_purchased .= '</tr>';
						$items_purchased .= '<tr><td colspan="2" bgcolor="#E6E6E6" width="100%" height="1" style="font-size:1px;line-height:1px">&nbsp;</td></tr>';
						$items_purchased .= '<tr><td colspan="2" width="100%" style="font-size:1px;line-height:12px">&nbsp;</td></tr>';
					}else {
						$items_purchased .= '<tr style="font-size: 12px;">';
						$items_purchased .= '<td align="left" valign="middle"><p style="font-size: 14px; margin: 0 0 6px; line-height: 1;">' . $ptitle . '</p><p style="letter-spacing: 1px;color: #a2a2a2;">' . $rpRow->item_qty . ' x $' . number_format($rpRow->price, 2, '.', '') . '</p></td>';
						$items_purchased .= '<td align="right" valign="middle"><p style="letter-spacing: 1px;">$' . number_format($rpRow->price * $rpRow->item_qty, 2, '.', '') . '</p></td>';
						$items_purchased .= '</tr>';
						$items_purchased .= '<tr><td colspan="2" bgcolor="#E6E6E6" width="100%" height="1" style="font-size:1px;line-height:1px">&nbsp;</td></tr>';
						$items_purchased .= '<tr><td colspan="2" width="100%" style="font-size:1px;line-height:12px">&nbsp;</td></tr>';
					}

					
				}
				
				
				
				// Create address field with unit/suite // create address field without unit/suite
				if ($receiptInvoice->address2) {
					$address = ucwords(strtolower($receiptInvoice->address2)) . ' - ' . ucwords(strtolower($receiptInvoice->address)) . ', <br>' . ucwords(strtolower($receiptInvoice->city)) . ', ' . ucwords(strtolower($receiptInvoice->state)) . ' ' . strtoupper($receiptInvoice->zip);
				}else {
					$address = ucwords(strtolower($receiptInvoice->address)) . ', <br>' . ucwords(strtolower($receiptInvoice->city)) . ', ' . ucwords(strtolower($receiptInvoice->state)) . ' ' . strtoupper($receiptInvoice->zip);
				}
				
				if ($receiptInvoice->heatflag) {
					$address = "Post Office near: <br>" . $address;
				}
				


				$template = str_replace(array(
					'[TRACKINGNUM]',
					'[ITEMSPURCHASED]',
					'[SITEURL]',
					'[SITE_NAME]',
					'[COMPANY]',
					'[EMAIL]',
					'[LOCATION]',
					'[ADDRESS1]',
					'[POINTS]',
					'[RECEIPT_ID]'
				), array(
					sanitize($_POST['trackingnum']),
					$items_purchased,
					Registry::get("Core")->site_url,
					Registry::get("Core")->site_name,
					Registry::get("Core")->company,
					sanitize($_POST['username']),
					'Vancouver, British Columbia',
					$address,
					$receiptInvoice->points,
					$_POST['invid']
				), $template);


				$mailer = Mailer::sendMail();
				$message = Swift_Message::newInstance()->setSubject($subjectLine)
				->setTo(array(sanitize($_POST['username']) => sanitize($_POST['fname'])))
				->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
				->setBody($template, 'text/html');
				$mailer->send($message);
			}

		}
		else {
			$json['type'] = 'info';
			$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
		}

		print json_encode($json);

	}



	/**
	 * Products::updateInvoiceShipped()
	 *
	 * @return
	 */
	public function updateInvoiceShipped()
	{

		$sql = "SELECT * FROM invoices WHERE status = '2'";

		$result = self::$db->fetch_all($sql);

		foreach($result as $row) {

			$receiptProducts = $this->getReceiptProducts($row->invid);


			$usersql = "SELECT * FROM users WHERE id = '" . $row->user_id . "'";
			$user_row = self::$db->first($usersql);

			$data = array(
				'status' => '3'
			);

			self::$db->update(self::inTable, $data, "id=" . $row->id);


			$message = Lang::$word->TXN_UPDATED;
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);


				// Send email
				require_once (BASEPATH . "lib/class_mailer.php");

				$template = file_get_contents('../templates_email/email_shipped.html');
				$subjectLine = "Your order has shipped!";

				$items_purchased = '';
				foreach ($receiptProducts as $rpRow) {

					if ($rpRow->flag_multiple) {
						$ptitle = $rpRow->title . " (" . $rpRow->variantTitle . ")";
					}else {
						$ptitle = $rpRow->title;
					}

					$items_purchased .= '<tr style="font-size: 12px;">';
					$items_purchased .= '<td align="left" valign="middle"><p style="font-size: 14px; margin: 0 0 6px; line-height: 1;">' . $ptitle . '</p><p style="letter-spacing: 1px;color: #a2a2a2;">' . $rpRow->item_qty . ' x $' . number_format($rpRow->price, 2, '.', '') . '</p></td>';
					$items_purchased .= '<td align="right" valign="middle"><p style="letter-spacing: 1px;">$' . number_format($rpRow->price * $rpRow->item_qty, 2, '.', '') . '</p></td>';
					$items_purchased .= '</tr>';
					$items_purchased .= '<tr><td colspan="2" bgcolor="#E6E6E6" width="100%" height="1" style="font-size:1px;line-height:1px">&nbsp;</td></tr>';
					$items_purchased .= '<tr><td colspan="2" width="100%" style="font-size:1px;line-height:12px">&nbsp;</td></tr>';
				}

				$template = str_replace(array(
					'[TRACKINGNUM]',
					'[ITEMSPURCHASED]',
					'[SITEURL]',
					'[SITE_NAME]',
					'[COMPANY]',
					'[EMAIL]',
					'[LOCATION]',
					'[TOKEN]',
					'[RECEIPT_ID]'
				), array(
					sanitize($row->trackingnum),
					$items_purchased,
					Registry::get("Core")->site_url,
					Registry::get("Core")->site_name,
					Registry::get("Core")->company,
					sanitize($user_row->username),
					'Vancouver, British Columbia',
					$token,
					$row->invid
				), $template);


				$mailer = Mailer::sendMail();
				$message = Swift_Message::newInstance()->setSubject($subjectLine)
				->setTo(array(sanitize($user_row->username) => sanitize($user_row->fname)))
				->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
				->setBody($template, 'text/html');
				$mailer->send($message);



			}
			else {
				$json['type'] = 'info';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);

		}

		unset($row);


	}



	/**
	 * Products::updateInvoiceLabeled()
	 *
	 * @return
	 */
	public function updateInvoiceLabeled()
	{

		$sql = "SELECT * FROM invoices WHERE status = '1.5'";

		$result = self::$db->fetch_all($sql);

		foreach($result as $row) {

			$receiptProducts = $this->getReceiptProducts($row->invid);


			$usersql = "SELECT * FROM users WHERE id = '" . $row->user_id . "'";
			$user_row = self::$db->first($usersql);

			$data = array(
					'status' => '2'
				);

			self::$db->update(self::inTable, $data, "id=" . $row->id);


			$message = Lang::$word->TXN_UPDATED;
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

		unset($row);


	}





	/**
	 * Products::getPaymentRecord()
	 *
	 * @return
	 */
	public function getPaymentRecord()
	{
		$sql = "SELECT t.*, p.id as pid, p.title, u.id as uid, u.username FROM " . self::tTable . " as t LEFT JOIN " . self::pTable . " as p ON p.id = t.pid LEFT JOIN " . Users::uTable . " as u ON u.id = t.uid WHERE t.id = '" . Filter::$id . "'";
		$row = self::$db->first($sql);
		return ($row) ? $row : Filter::error("You have selected an Invalid Id - #" . Filter::$id, "Products::getPaymentRecord()");
	}

	/**
	 * Products::getGallery()
	 *
	 * @return
	 */
	public function getGallery($pid = false)
	{
		$id = ($pid) ? $pid : Filter::$id;
		$sql = "SELECT * FROM " . self::phTable . "\n WHERE pid = " . (int)$id . "\n ORDER BY id";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Products::galleryUpload()
	 *
	 * @return
	 */
	public function galleryUpload($filename)
	{
		if (isset($_FILES[$filename]) && $_FILES[$filename]['error'] == 0) {
			$path = PRODGALPATH;
			$extension = pathinfo($_FILES[$filename]['name'], PATHINFO_EXTENSION);
			if (!in_array(strtolower($extension), self::$gfileext)) {
				$json['status'] = "error";
				$json['msg'] = Lang::$word->GAL_ERR;
				print json_encode($json);
				exit;
			}

			/*
			if (file_exists($path . $_FILES[$filename]['name'])) {
				$json['status'] = "error";
				$json['msg'] = Lang::$word->GAL_ERR1;
				print json_encode($json);
				exit;
			}
			*/

			if (!is_writeable($path)) {
				$json['status'] = "error";
				$json['msg'] = Lang::$word->GAL_ERR2;
				print json_encode($json);
				exit;
			}

			if (!is_dir($path)) {
				$json['status'] = "error";
				$json['msg'] = Lang::$word->GAL_ERR4;
				print json_encode($json);
				exit;
			}

			$newName = Filter::$id . "_" . $_FILES[$filename]['name'];
			$newName = pathinfo($newName, PATHINFO_FILENAME);
			$ext = substr($_FILES[$filename]['name'], strrpos($_FILES[$filename]['name'], '.') + 1);
			$fullname = $path . $newName . "." . strtolower($ext);
			if (move_uploaded_file($_FILES[$filename]['tmp_name'], $fullname)) {
				$data['caption'] = $newName;
				$data['pid'] = Filter::$id;
				$data['thumb'] = $newName . "." . strtolower($ext);
				$last_id = self::$db->insert(self::phTable, $data);
				$url = PRODGALURL . $data['thumb'];
				$html = '
						<div class="col-md-4 col-lg-3 item">
							<div class="panel panel-default">
								<div class="panel-title">
									<div contenteditable="true" data-path="false" data-edit-type="gallery" data-id="' . $last_id . '" data-key="title" class="editable">' . $newName . '</div>
									<ul class="panel-tools">
										<li>
											<a class="icon imgdelete" data-id="172" data-name="As You Are">
												<i class="fa fa-times"></i>
											</a>
										</li>
									</ul>
								</div>

								<div class="panel-body">
									<img src="' . $url . '" alt="" class="gallery_image">
								</div>
							</div>

						</div>';
				$json['status'] = "success";
				$json['msg'] = $html;
				print json_encode($json);
				exit;
			}
		}

		$json['status'] = "error";
		exit;
	}

	/**
	 * Products::loadGallery()
	 *
	 * @return
	 */
	public function loadGallery()
	{
		if ($galrow = $this->getGallery()) {
			foreach($galrow as $row) {
				$thumb = ($row->thumb) ? $row->thumb : "blank.png?v=1";
				print '
				  <li id="fileid_' . $row->id . '" class="file-data" data-name="' . $row->caption . '">
					<figure> <img src="../thumbmaker.php?src=/uploads/prod_gallery/' . $thumb . '&amp;w=' . Registry::get("Core")->thumb_w . '&amp;h=' . Registry::get("Core")->thumb_h . '&amp;s=1&amp;a=t1" alt=""/>
					  <p class="filetitle"> ' . $row->caption . ' </p>
					  <figcaption> <a><i class="icon-info-sign icon-3x"></i></a> </figcaption>
					</figure>
				  </li>';
			}
		}
	}

	/**
	 * Products::getUserTransactions()
	 *
	 * @return
	 */
	public function getUserTransactions()
	{
		$sql = "SELECT t.*, p.id as pid, p.title, p.slug, p.thumb FROM " . self::tTable . " as t LEFT JOIN " . self::pTable . " as p ON p.id = t.pid WHERE t.uid = " . Registry::get("Users")->uid . "\n AND t.status = 1 AND t.active = 1 AND p.active = 1 GROUP BY t.pid ORDER BY t.created DESC";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}


	/**
	 * Products::getUserReceipt()
	 *
	 * @return
	 */
	public function getReceiptInvoice($receiptid)
	{
		$sql = "SELECT * FROM " . self::inTable . " WHERE invid = '" . $receiptid . "'";
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
	/**
	 * Products::getWholesaleReceiptInvoice()
	 *
	 * @return
	 */
	public function getWholesaleReceiptInvoice($receiptid)
	{
		$sql = "SELECT * FROM " . Content::wsiTable . " WHERE invid = '" . $receiptid . "'";
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
	

	/**
	 * Products::getReceiptProducts()
	 *
	 * @return
	 */
	public function getReceiptProducts($receiptid)
	{
		$sql = "SELECT t.*, p.id as pid, p.cid, p.title, p.slug, p.flag_multiple as flag_multiple, p.dosage as dosage, p.weight, p.size, p.thumb, p.description as description, pv.title as variantTitle, pv.dosage as variantDosage, pv.weight as variantWeight FROM " . self::tTable . " as t LEFT JOIN " . self::pTable . " as p ON p.id = t.pid LEFT JOIN " . self::pvTable . " as pv ON pv.id=t.pvid WHERE t.txn_id = '" . $receiptid . "' AND t.status = 1 AND t.active = 1 AND p.active = 1 GROUP BY t.pid, t.pvid ORDER BY t.created DESC";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	/**
	 * Products::getWholesaleReceiptProducts()
	 *
	 * @return
	 */
	public function getWholesaleReceiptProducts($receiptid)
	{
		$sql = "SELECT t.*, p.id as pid, p.cid, p.title, p.slug, p.flag_multiple as flag_multiple, p.dosage as dosage, p.weight, p.size, p.thumb, p.description as description, pv.title as variantTitle, pv.dosage as variantDosage, pv.weight as variantWeight FROM wholesale_transactions as t LEFT JOIN " . self::pTable . " as p ON p.id = t.pid LEFT JOIN " . self::pvTable . " as pv ON pv.id=t.pvid \n WHERE t.txn_id = '" . $receiptid . "' AND t.status = 1 AND t.active = 1 AND p.active = 1 GROUP BY t.pid, t.pvid ORDER BY t.created DESC";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	/**
	 * Products::getUserInvoices()
	 *
	 * @return
	 */
	public function getUserInvoices()
	{
		$sql = "SELECT * FROM " . self::inTable . "\n WHERE user_id = " . Registry::get("Users")->uid . "\n ORDER BY created DESC";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Products::getInvoices()
	 *
	 * @param bool $where
	 * @param bool $from
	 * @return
	 */
	public function getInvoices($fromdate = null, $status = null, $code = false, $limit = false)
	{
		$enddate = date("Y-m-d");
		
		$where = "created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
		// If only want invoices with specific status
		if ($status) {
			$where .= " AND status = " . $status;
		}
		
		if ($code) {
			$where .= " AND discount_code = '" . $code . "'";
		}
		
		if ($limit) {
			$limit = " LIMIT $limit";
		}
		
		
		$sql = "SELECT * FROM " . self::inTable . " WHERE " . $where . " ORDER BY created DESC $limit";
		
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
  
   /**
	* Products::getInvoicesA()
	*
	* @param String $where
	* @param String $paginationData
	* @return
	 */
	public function getInvoicesA($where, $orderBy, &$paginationData = array())
	{
		$sql = "SELECT * FROM " . self::inTable . " AS i " . " INNER JOIN users AS u ON u.id=i.user_id WHERE $where ORDER BY $orderBy";
		
		$rows = self::$db->paginated_query($sql, $paginationData);
			return ($rows) ? $rows : 0;
	}
	
	/**
	 * Products::getInvoices()
	 *
	 * @param bool $where
	 * @param bool $from
	 * @return
	 */
	public function getAmbassadorInvoices($fromdate = null, $status = null, $code = false, $limit = false)
	{
		$enddate = date("Y-m-d");
		
		$where = "created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
		// If only want invoices with specific status
		if ($status) {
			$where .= " AND status = " . $status;
		}
		
		if ($code) {
			$where .= " AND discount_code = '" . $code . "'";
		}
		
		$where .= " AND pp <> 'Points'";
		
		if ($limit) {
			$limit = " LIMIT $limit";
		}
		
		
		$sql = "SELECT * FROM " . self::inTable . " WHERE " . $where . " ORDER BY created DESC $limit";
		
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	
	
	/**
	 * Products::getBulkOrders()
	 *
	 * @param bool $where
	 * @param bool $from
	 * @return
	 */
	public function getBulkOrders($fromdate = null)
	{
		$enddate = date("Y-m-d");
		
		if ($fromdate) {
			$sql = "SELECT * FROM " . Content::wsiTable . " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' ORDER BY created DESC";
		}else {
			$sql = "SELECT * FROM " . Content::wsiTable . " ORDER BY created DESC";
			
		}
		
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	
	
	
	/**
	 * Products::getInventory()
	 *
	 * @param bool $where
	 * @param bool $from
	 * @return
	 */
	public function getInventory($status = null)
	{
	
		if ($status) {
			$sql = "SELECT * FROM " . self::inTable . " WHERE status = " . $status . " ORDER BY created DESC";
		}else {
			$sql = "SELECT * FROM " . self::inTable . " WHERE status = 1 OR status = 1.5 ORDER BY created DESC";
		}
		
		
		
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	
	/**
	 * Products::getItemInventory()
	 *
	 * @param bool $where
	 * @param bool $from
	 * @return
	 */
	public function getItemInventory($status, $item)
	{
		$sql = "SELECT sum(transactions.item_qty) as total FROM invoices LEFT JOIN transactions ON invoices.invid=transactions.txn_id WHERE invoices.status = " . $status . " AND transactions.pid = " . $item;
		
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
	

	/**
	 * Products::getFileToDownload()
	 *
	 * @return
	 */
	public function getFileToDownload()
	{
		$sql = "SELECT t.*, SUM(t.item_qty) as count, t.created, t.status, t.ip, t.active as tactive,
		  SUM(t.downloads) as file_downloads, FROM_UNIXTIME(t.file_date,'%M %e %Y, %H:%i') as registered, t.id as tid, MAX(t.file_date) as file_date," . " \n p.id as pid, p.title, p.description, p.expiry, p.active as pactive, p.price, p.slug, p.metakeys," . " \n f.id AS fid, f.alias, f.filesize, f.name" . " \n FROM transactions as t" . " \n LEFT JOIN " . self::pTable . " as p ON t.pid = p.id" . " \n LEFT JOIN " . self::fTable . " as f ON p.file_id = f.id" . " \n WHERE t.pid = '" . Filter::$id . "'" . " \n AND t.uid =  " . Registry::get("Users")->uid . " \n AND t.status = 1" . " \n AND t.active = 1" . " \n AND p.active = 1" . " \n GROUP BY p.id";
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Products::featuredProducts()
	 *
	 * @return
	 */
	public function featuredProducts()
	{
		$sql = "SELECT *, id as pid FROM " . self::pTable . " WHERE active = 1 AND feat > 0 ORDER BY RAND() LIMIT 4";
		$row = self::$db->fetch_all($sql);

		if (self::$db->numrows(self::$db->query($sql)) < 4) {
			return 0;
		} else {
			return $row;
		}
	}

	/** Gets products per category.
	 * @param $catId int The category ID
	 * @param $sort string The value to sort on. Supports 'popular', 'highest', 'featured' and 'recent'.
	 * @param $page int Which page you're viewing
	 * @param $perPage int The number of results per page
	 * @return array The products
	 */
	public function getCategoryPage($catId, $sort, $page, $perPage)
	{
		if (!is_numeric($page)) return false;
		if (!is_numeric($perPage)) return false;
		if (!is_numeric($catId)) return false;

		$offset = ($page - 1) * $perPage;

		if ($sort == "popular") {
			$sorting = "sales + hits DESC, hits DESC, p.hits DESC";
		} elseif ($sort == "featured") {
			$sorting = "p.feat DESC, hits DESC, p.hits DESC";
		} else { /* Default */
			$sorting = " p.created DESC";
		}

		$sql = "SELECT p.*, p.id as pid, c.name, c.slug as catslug, c.id as cid, (SELECT SUM(item_qty) FROM " . self::tTable . "  WHERE pid = p.id) as sales, (SELECT SUM(hits) FROM " . self::sTable . " WHERE pid = p.id) as hits FROM " . self::pTable . " as p JOIN categories_related cr on p.id = cr.pid  JOIN categories c on cr.cid = c.id WHERE p.active = 1 AND c.id = $catId" . " ORDER BY $sorting";
		$sql.= " LIMIT $perPage OFFSET $offset";
		$row = self::$db->fetch_all($sql);

		return ($row) ? $row : array();
	}

	/** Returns the number of products in a collection
	 * @param $where string the SQL WHERE clause
	 * @return int The number of rows
	 */
	public function countProducts($where)
	{
		$sql = "SELECT count(id) count FROM products $where";
		$row = self::$db->first($sql);
		return ($row) ? $row->count : 0;
	}

	/** Returns the number of products in a category
	 * @param $catId int The category ID
	 * @return int The number of rows
	 */
	public function countCategoryProducts($catId)
	{
		$sql = "SELECT count(p.id) count " . "FROM products p" . " JOIN categories_related cr on p.id = cr.pid " . " JOIN categories c on cr.cid = c.id " . "WHERE c.id = $catId";
		$row = self::$db->first($sql);
		return ($row) ? $row->count : 0;
	}

	/** Gets products per page. Used in the All page.
	 * @param $sort string The value to sort on. Supports 'popular', 'highest', 'featured' and 'recent'.
	 * @param $page int Which page you're viewing
	 * @param $perPage int The number of results per page
	 * @return array The products
	 */
	public function getProductsPage($sort, $page, $perPage)
	{
		if (!is_numeric($page)) return false;
		if (!is_numeric($perPage)) return false;
		
		
		$offset = ($page - 1) * $perPage;

		$sql = "SELECT * FROM " . self::pTable . " WHERE active = 1";
		
		if ($perPage != 0) {
			$sql.= " LIMIT $perPage OFFSET $offset";
		}
		
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : array();
	}
	/** Gets products with category and cart infomation per page. 
	 * @param $sort string The value to sort on. Supports 'popular', 'highest', 'featured' and 'recent'.
	 * @param $page int Which page you're viewing
	 * @param $perPage int The number of results per page
	 * @return array The products
	 */
	public function getProductsInfo($sort, $page, $perPage)
	{
		if (!is_numeric($page)) return false;
		if (!is_numeric($perPage)) return false;
		
		
		$offset = ($page - 1) * $perPage;
		$uid = Registry::get("Users")->username;
		$sql = "SELECT products.id as id, products.title, products.stock, products.soldflag, products.slug, products.thumb,products.pieces, categories.name as cname, wholesale_cart.price as cartPrice, wholesale_cart.qty as qty FROM products inner join categories on products.cid = categories.id left join  wholesale_cart on products.id = wholesale_cart.pid and wholesale_cart.user_id='" . sanitize($uid) . "' WHERE products.active = 1";
		//file_put_contents('./logs/log_'.date("j.n.Y").'.log', $sql .' - '.date("F j, Y, g:i a").PHP_EOL, FILE_APPEND);
		if ($perPage != 0) {
			$sql.= " LIMIT $perPage OFFSET $offset";
		}
		
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : array();
	}
	
	/** Gets products per page. Used in the All page.
	 * @param $sort string The value to sort on. Supports 'popular', 'highest', 'featured' and 'recent'.
	 * @param $page int Which page you're viewing
	 * @param $perPage int The number of results per page
	 * @return array The products
	 */
	public function getAllProducts()
	{

		$sql = "SELECT * FROM " . self::pTable . " WHERE active = 1 ORDER BY cid";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : array();
	}

	/**
	 * Products::trendingProducts()
	 *
	 * @return array
	 */
	public function trendingProducts()
	{
		if (isset($_GET['sort'])) {
			$sort = sanitize($_GET['sort'], 100);
		} else {
			// Set a default to avoid PHP warnings

			$sort = 'recent';
		}

		if ($sort == "popular") {
			$sorting = "sales + hits DESC, hits DESC, p.hits DESC";
		} elseif ($sort == "featured") {
			$sorting = "p.feat DESC, hits DESC, p.hits DESC";
		} else { /**Default**/
			$sorting = " p.created DESC";
		}

		$sql = "SELECT p.*, p.id as pid, c.name, c.slug as catslug, c.id as cid, (SELECT SUM(item_qty) FROM " . self::tTable . "  WHERE pid = p.id) as sales, (SELECT SUM(hits) FROM " . self::sTable . " WHERE pid = p.id) as hits FROM " . self::pTable . " as p LEFT JOIN categories as c ON c.id = p.cid WHERE p.active = 1 ORDER BY $sorting ";
		$row = self::$db->fetch_all($sql);

		return ($row) ? $row : 0;
	}

	/**
	 * Products::mostPopProducts()
	 *
	 * @return
	 */
	public function mostPopProducts()
	{
		$sql = "SELECT p.id as pid, p.title, p.slug, p.thumb FROM transactions as t LEFT JOIN " . self::pTable . " as p ON p.id = t.pid GROUP BY t.pid LIMIT 0," . Registry::get("Core")->popular;
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	
	
		/**
	 * Products::mostSold()
	 *
	 * @return
	 */
	public function mostSold()
	{
		$sql = "SELECT p.title,p.id as pid, p.slug, COUNT(t.pid) as total FROM transactions as t LEFT JOIN " . self::pTable . " as p ON p.id = t.pid WHERE t.status = '1' GROUP BY t.pid LIMIT 0,5";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Products::getProductList()
	 *
	 * @return
	 */
	public function getProductList()
	{
		$row = self::$db->fetch_all("SELECT id, title, slug FROM " . self::pTable . " WHERE active = 1 ORDER BY title");
		return $row ? $row : 0;
	}
	
	/**
	 * Products::updateRecentViews()
	 *
	 * @return
	 */
	private function updateRecentViews($pid)
	{
		if (!self::$db->first("SELECT pid FROM " . self::rTable . " WHERE user_id = '" . self::$db->escape(Registry::get("Users")->username) . "' AND pid = '" . $pid . "'")) {
			$data['pid'] = $pid;
			$data['user_id'] = Registry::get("Users")->username;
			self::$db->insert(self::rTable, $data);
		}
	}
	
	/**
	 * Products::exportTransactionsXLS()
	 *
	 * @return
	 */
	public function exportTransactionsXLS()
	{
		$sql = "SELECT t.*, t.id as id, u.id as uid, u.username, p.id as pid, p.title, t.created as cdate FROM " . self::tTable . " as t LEFT JOIN " . Users::uTable . " as u ON u.id = t.uid LEFT JOIN " . self::pTable . "  as p ON p.id = t.pid ORDER BY t.created";
		$result = self::$db->fetch_all($sql);
		$type = "vnd.ms-excel";
		$date = date('m-d-Y H:i');
		$title = "Exported from the " . Registry::get("Core")->site_name . " on $date";
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Type: application/$type");
		header("Content-Disposition: attachment;filename=temp_" . time() . ".xls");
		header("Content-Transfer-Encoding: binary ");
		print '
		  <table width="100%" cellpadding="1" cellspacing="2" border="1">
		  <caption>' . $title . '</caption>
			<tr>
			  <td>#</th>
			  <td>' . Lang::$word->PRD_NAME . '</td>
			  <td>' . Lang::$word->USERNAME . '</td>
			  <td>' . Lang::$word->TXN_AMT . '</td>
			  <td>' . Lang::$word->CREATED . '</td>
			  <td>' . Lang::$word->TXN_PP . '</td>
			  <td>IP</td>
			  <td>#' . Lang::$word->PRD_DOWNS . '</td>
			  <td>' . Lang::$word->STATUS . '</td>
			</tr>';
		foreach($result as $row) {
			$status = ($row->status) ? 'Completed' : 'Pending';
			print '<tr>
				  <td>' . $row->txn_id . '</td>
				  <td>' . $row->title . '</td>
				  <td>' . $row->username . '</td>
				  <td>' . $row->price . '</td>
				  <td>' . $row->cdate . '</td>
				  <td>' . $row->pp . '</td>
				  <td>' . $row->ip . '</td>
				  <td>' . $row->downloads . '</td>
				  <td>' . $status . '</td>
				</tr>';
		}

		print '</table>';
		unset($row);
		exit();
	}

	/**
	 * Products::exportTransactionsPDF()
	 *
	 * @return
	 */
	public function exportTransactionsPDF()
	{
		$sql = "SELECT t.*, t.id as id, u.id as uid, u.username, p.id as pid, p.title, t.created as cdate FROM " . self::tTable . " as t LEFT JOIN " . Users::uTable . " as u ON u.id = t.uid LEFT JOIN " . self::pTable . "  as p ON p.id = t.pid ORDER BY t.created";
		$result = self::$db->fetch_all($sql);
		$date = date('m-d-Y H:i');
		$title = "Exported from the " . Registry::get("Core")->site_name . " on $date";
		$html = '
		  <div style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
		  <table style="background:#F4F4F4;border:2px solid #bbb;width:100%" border="0" cellpadding="10" cellspacing="0">
		  <caption>' . $title . '</caption>
		  <tr>
		   <th colspan="7" style="background-color:#c1c1c1;font-size:16px;padding:5px;border-bottom-width:2px;border-bottom-color:#bbb;border-bottom-style:solid">' . Lang::$word->TXN_SREP . '</th>
		   </tr>
			<tr style="background-color:#dddddd;">
			  <td>' . Lang::$word->PRD_NAME . '</td>
			  <td>' . Lang::$word->USERNAME . '</td>
			  <td>' . Lang::$word->TXN_AMT . '</td>
			  <td>' . Lang::$word->CREATED . '</td>
			  <td>' . Lang::$word->TXN_PP . '</td>
			  <td>#' . Lang::$word->PRD_DOWNS . '</td>
			  <td>' . Lang::$word->STATUS . '</td>
			</tr>';
		foreach($result as $row) {
			$status = ($row->status) ? 'Completed' : 'Pending';
			$html.= '<tr>
				  <td style="border-top-width:1px; border-top-color:#ddd; border-top-style:solid">' . $row->title . '</td>
				  <td style="border-top-width:1px; border-top-color:#ddd; border-top-style:solid">' . $row->username . '</td>
				  <td style="border-top-width:1px; border-top-color:#ddd; border-top-style:solid">' . $row->price . '</td>
				  <td style="border-top-width:1px; border-top-color:#ddd; border-top-style:solid">' . $row->cdate . '</td>
				  <td style="border-top-width:1px; border-top-color:#ddd; border-top-style:solid">' . $row->pp . '</td>
				  <td style="border-top-width:1px; border-top-color:#ddd; border-top-style:solid">' . $row->downloads . '</td>
				  <td style="border-top-width:1px; border-top-color:#ddd; border-top-style:solid">' . $status . '</td>
				</tr>';
		}

		$html.= '</table></div>';
		require_once (BASEPATH . 'lib/mPdf/mpdf.php');

		$mpdf = new mPDF('utf-8');
		$mpdf->SetTitle($title);
		$mpdf->SetAutoFont();
		$mpdf->WriteHTML($html);
		$mpdf->Output($title . ".pdf", "D");
		unset($row);
		exit();
	}

	/**
     * @param $productID
     * @return array
     */
	public function getProductbyIdList($productIDList)
    {
		$names = array();
		$result = self::$db->fetch_all("SELECT title FROM " . self::pTable ." WHERE id in (" . $productIDList . ") ORDER BY FIND_IN_SET(id, '" . $productIDList ."')");
		foreach($result as $row) {
			array_push($names, $row->title);
				
		}
        return $names;
    }
}
