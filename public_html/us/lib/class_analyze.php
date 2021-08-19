<?php
/**
 * Products Class
 *
 * @package FBC Studio
 * @author fbcstudio.com
 * @copyright 2010
 * @version $Id: class_analyze.php, v2.00 2011-07-10 10:12:05 gewa Exp $
 */

if (!defined("_VALID_PHP")) die('Direct access to this location is not allowed.');
class Analyze

{
	const pTable = "products";
	const pvTable = "product_variants";
	const tTable = "transactions";
	const inTable = "invoices";
	const bTable = "blog";
	const phTable = "photos";
	const tagTable = "tags";
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
	 * Analysis::__construct()
	 *
	 * @return
	 */
	public function __construct()
	{
		self::$db = Registry::get("Database");
		$this->getProductSlug();
	}

	/**
	 * Analysis::getProductSlug()
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
	 * Analysis::mostSoldChart()
	 *
	 * @return
	 */
	public function mostSoldChart()
	{
		$sql = "SELECT COUNT(pid) as total, p.title, p.id as pid, SUM(t.price) as price, p.thumb FROM " . self::tTable . " as t LEFT JOIN " . self::pTable . " as p ON p.id = t.pid WHERE t.status = 1 AND YEAR(t.created) = '" . Registry::get("Core")->year . "' AND MONTH(t.created) = '" . Registry::get("Core")->month . "' GROUP BY pid ORDER BY total DESC LIMIT 6";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	
	/**
	 * Analysis::totalSold()
	 *
	 * @return
	 */
	public function totalSold()
	{
		$sql = "SELECT SUM(t.item_qty) as total, p.id as pid, SUM(t.item_qty * (t.price + t.tax)) as price FROM " . self::tTable . " as t LEFT JOIN " . self::pTable . " as p ON p.id = t.pid WHERE t.status = 1";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Analysis::totalSoldSpecific()
	 *
	 * @return
	 */
	public function totalSoldSpecific()
	{
		$sql = "SELECT SUM(t.item_qty) as total, p.id as pid, SUM(t.item_qty * t.price) as price FROM " . self::tTable . " as t LEFT JOIN " . self::pTable . " as p ON p.id = t.pid WHERE t.status = 1 AND MONTH(t.created) = '" . Registry::get("Core")->month . "' AND YEAR(t.created) = '" . Registry::get("Core")->year . "'";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Analysis::totalSoldPrevious()
	 *
	 */
	public function totalSoldPrevious()
	{

		// $sql = "SELECT SUM(t.item_qty) as total, p.id as pid, SUM(t.item_qty * (t.price + t.tax)) as price"

		if (Registry::get("Core")->month - 1 == 0) {
			$sql = "SELECT SUM(t.item_qty) as total, p.id as pid, SUM(t.item_qty * (t.price)) as price FROM " . self::tTable . " as t LEFT JOIN " . self::pTable . " as p ON p.id = t.pid WHERE t.status = 1 AND MONTH(t.created) = '12' AND YEAR(t.created) = '" . Registry::get("Core")->year . "'";
		}
		else {
			$sql = "SELECT SUM(t.item_qty) as total, p.id as pid, SUM(t.item_qty * (t.price)) as price FROM " . self::tTable . " as t LEFT JOIN " . self::pTable . " as p ON p.id = t.pid WHERE t.status = 1 AND MONTH(t.created) = '" . (Registry::get("Core")->month - 1) . "' AND YEAR(t.created) = '" . Registry::get("Core")->year . "'";
		}

		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Analysis::totalSoldPreviousSpecific()
	 *
	 * @return
	 */
	public function totalSoldPreviousSpecific()
	{

		// $sql = "SELECT SUM(t.item_qty) as total, p.id as pid, SUM(t.item_qty * (t.price + t.tax)) as price"

		if (Registry::get("Core")->month - 1 == 0) {
			$sql = "SELECT SUM(t.item_qty) as total, p.id as pid, SUM(t.item_qty * (t.price)) as price FROM transactions as t LEFT JOIN products as p ON p.id = t.pid WHERE t.status = 1 AND MONTH(t.created) = '12' AND YEAR(t.created) = '" . Registry::get("Core")->year . "'";
		}
		else {
			$sql = "SELECT SUM(t.item_qty) as total, p.id as pid, SUM(t.item_qty * (t.price)) as price FROM transactions as t LEFT JOIN products as p ON p.id = t.pid WHERE t.status = 1 AND MONTH(t.created) = '" . (Registry::get("Core")->month - 1) . "' AND YEAR(t.created) = '" . Registry::get("Core")->year . "'";
		}

		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	
	
	
	/**
	 * Analysis::dayRevenue($day)
	 *
	 * @return
	 */
	public function dayRevenue($year, $month, $day, $code = false) {
	
		if (!$code) {
			$sql = "SELECT SUM(totalprice) as total FROM " . self::inTable . " WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " AND DAY(created) =" . $day . " AND status > 0 AND pp <> 'Points'";
		}else {
			$sql = "SELECT SUM(originalprice * payout / 100) as total FROM " . self::inTable . " WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " AND DAY(created) =" . $day . " AND status > 0 AND pp <> 'Points' AND discount_code = '" . $code . "'";
		}
		
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
	/**
	 * Analysis::dayRevenue($day)
	 *
	 * @return
	 */
	public function dayRevenueUnpaid($year, $month, $day, $code = false) {
	
		if (!$code) {
			$sql = "SELECT SUM(totalprice) as total FROM " . self::inTable . " WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " AND DAY(created) =" . $day . " AND status = 0 AND pp <> 'Points'";
		}else {
			$sql = "SELECT SUM(originalprice * payout / 100) as total FROM " . self::inTable . " WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " AND DAY(created) =" . $day . " AND status = 0 AND pp <> 'Points' AND discount_code = '" . $code . "'";
		}
		
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
	/**
	 * Analysis::dayRevenue($day)
	 *
	 * @return
	 */
	public function dayRevenueCombined($year, $month, $day, $code = false) {
	
		if (!$code) {
			$sql = "SELECT SUM(totalprice) as total FROM " . self::inTable . " WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " AND DAY(created) =" . $day . " AND pp <> 'Points'";
		}else {
			$sql = "SELECT SUM(originalprice * payout / 100) as total FROM " . self::inTable . " WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " AND DAY(created) =" . $day . " AND pp <> 'Points' AND discount_code = '" . $code . "'";
		}
		
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
	
	
	/**
	 * Analysis::daySales($year, $month, $day)
	 *
	 * @return
	 */
	public function daySales($year, $month, $day, $code = false)
	{
		$wherecode = "";
		if ($code) {
			$wherecode = " AND discount_code = '" . $code . "'";
		}
		
		$sql = "SELECT COUNT(invid) as total FROM " . self::inTable . " WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " AND DAY(created) =" . $day . " AND status > 0 AND pp <> 'Points'" . $wherecode;
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
	
	
	/**
	 * Analysis::dayInventory($year, $month, $day)
	 *
	 * @return
	 */
	public function dayInventory($year, $month, $day)
	{
		$sql = "SELECT SUM(item_qty) as total FROM " . self::tTable . " WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " AND DAY(created) =" . $day;
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
	
	
	/**
	 * Analysis::daySignup($year, $month, $day)
	 *
	 * @return
	 */
	public function daySignup($year, $month, $day)
	{
		$sql = "SELECT COUNT(id) as total FROM users WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " AND DAY(created) =" . $day;
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
	
	
	/**
	 * Analysis::monthRevenue($year, $month)
	 *
	 * @return
	 */
	public function monthRevenue($year, $month, $code = false) {
		if (!$code) {
			$sql = "SELECT SUM(totalprice) as total FROM " . self::inTable . " WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " AND status > 0 AND pp <> 'Points'";
		}else {
			$sql = "SELECT SUM(originalprice * payout / 100) as total FROM " . self::inTable . " WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " AND status > 0 AND pp <> 'Points' AND discount_code = '" . $code . "'";
		}
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
  
	/**
	 * Analysis::monthlyRevenue($where)
	 *
	 * @return
	 */
	public function monthlyRevenue($options) {
    $startDate = '"' . sanitize(self::$db->escape($options['startDate']. ' 00:00:00')). '"';
    $endDate = '"' . sanitize(self::$db->escape($options['endDate']. ' 23:59:59')). '"';
    
    $provinceWhere = '';
    if (isset($options['province']))
    {
      if ($options['province'] == 'na')
        $provinceWhere = ' AND (state IS NULL OR LENGTH(state)<=0)';
      else
        $provinceWhere = ' AND state=' . '"' . sanitize(self::$db->escape($options['province'])). '"';
    }
    
    $where = "created>=$startDate"
    . " AND created<=$endDate"
    . " AND status > 0"
    . " AND pp <> 'Points'"
    . $provinceWhere;
    $sql = " SELECT DATE_FORMAT(created, '%Y-%m') AS aggOpt, "
          . " SUM(totalprice) as total "
        . " FROM invoices"
        . " WHERE $where"
        . " GROUP BY aggOpt "
        . " ORDER BY aggOpt ASC";
    
		$rows = self::$db->fetch_all($sql);
		return ($rows) ? $rows : 0;
	}
  
	/**
	 * Analysis::dailyRevenue($where)
	 *
	 * @return
	 */
	public function dailyRevenue($options) {
    $startDate = '"' . sanitize(self::$db->escape($options['startDate']. ' 00:00:00')). '"';
    $endDate = '"' . sanitize(self::$db->escape($options['endDate']. ' 23:59:59')). '"';
    
    $provinceWhere = '';
    if (isset($options['province']))
    {
      if ($options['province'] == 'na')
        $provinceWhere = ' AND (state IS NULL OR LENGTH(state)<=0)';
      else
        $provinceWhere = ' AND state=' . '"' . sanitize(self::$db->escape($options['province'])). '"';
    }
    
    $where = "created>=$startDate"
    . " AND created<=$endDate"
    . " AND status > 0"
    . " AND pp <> 'Points'"
    . $provinceWhere;
    $sql = " SELECT DATE_FORMAT(created, '%Y-%m-%d') AS aggOpt, "
          . " SUM(totalprice) as total "
        . " FROM invoices"
        . " WHERE $where"
        . " GROUP BY aggOpt "
        . " ORDER BY aggOpt ASC";

		$rows = self::$db->fetch_all($sql);
		return ($rows) ? $rows : 0;
	}
  
	/**
	 * Analysis::annualRevenue($where)
	 *
	 * @return
	 */
	public function annualRevenue($options) {
    $startDate = '"' . sanitize(self::$db->escape($options['startDate']. ' 00:00:00')). '"';
    $endDate = '"' . sanitize(self::$db->escape($options['endDate']. ' 23:59:59')). '"';
    
    $provinceWhere = '';
    if (isset($options['province']))
    {
      if ($options['province'] == 'na')
        $provinceWhere = ' AND (state IS NULL OR LENGTH(state)<=0)';
      else
        $provinceWhere = ' AND state=' . '"' . sanitize(self::$db->escape($options['province'])). '"';
    }
    
    $where = "created>=$startDate"
    . " AND created<=$endDate"
    . " AND status > 0"
    . " AND pp <> 'Points'"
    . $provinceWhere;
    $sql = " SELECT DATE_FORMAT(created, '%Y') AS aggOpt, "
          . " SUM(totalprice) as total "
        . " FROM invoices"
        . " WHERE $where"
        . " GROUP BY aggOpt "
        . " ORDER BY aggOpt ASC";

		$rows = self::$db->fetch_all($sql);
		return ($rows) ? $rows : 0;
	}
  
  /**
	 * Analysis::dailySignup($options)
	 *
	 * @return
	 */
	public function dailySignup($options)
	{
    $startDate = '"' . sanitize(self::$db->escape($options['startDate']. ' 00:00:00')). '"';
    $endDate = '"' . sanitize(self::$db->escape($options['endDate']. ' 23:59:59')). '"';
    
    $provinceWhere = '';
    if (isset($options['province']))
    {
      if ($options['province'] == 'na')
        $provinceWhere = ' AND (state IS NULL OR LENGTH(state)<=0)';
      else
        $provinceWhere = ' AND state=' . '"' . sanitize(self::$db->escape($options['province'])). '"';
    }
    
    $where = "created>=$startDate"
    . " AND created<=$endDate"
    . $provinceWhere;
    
		$sql = "SELECT DATE_FORMAT(created, '%Y-%m-%d') AS aggOpt, "
          . "COUNT(id) as total FROM users "
          . "WHERE $where"
          . " GROUP BY aggOpt "
          . " ORDER BY aggOpt ASC";
    
		$rows = self::$db->fetch_all($sql);
		return ($rows) ? $rows : 0;
	}
  
  /**
	 * Analysis::monthlySignup($options)
	 *
	 * @return
	 */
	public function monthlySignup($options)
	{
    $startDate = '"' . sanitize(self::$db->escape($options['startDate']. ' 00:00:00')). '"';
    $endDate = '"' . sanitize(self::$db->escape($options['endDate']. ' 23:59:59')). '"';
    
    $provinceWhere = '';
    if (isset($options['province']))
    {
      if ($options['province'] == 'na')
        $provinceWhere = ' AND (state IS NULL OR LENGTH(state)<=0)';
      else
        $provinceWhere = ' AND state=' . '"' . sanitize(self::$db->escape($options['province'])). '"';
    }
    
    $where = "created>=$startDate"
    . " AND created<=$endDate"
    . $provinceWhere;
    
		$sql = "SELECT DATE_FORMAT(created, '%Y-%m') AS aggOpt, "
          . "COUNT(id) as total FROM users "
          . "WHERE $where"
          . " GROUP BY aggOpt "
          . " ORDER BY aggOpt ASC";
    
		$rows = self::$db->fetch_all($sql);
		return ($rows) ? $rows : 0;
	}
  /**
	 * Analysis::annualSignup($options)
	 *
	 * @return
	 */
	public function annualSignup($options)
	{
    $startDate = '"' . sanitize(self::$db->escape($options['startDate']. ' 00:00:00')). '"';
    $endDate = '"' . sanitize(self::$db->escape($options['endDate']. ' 23:59:59')). '"';
    
    $provinceWhere = '';
    if (isset($options['province']))
    {
      if ($options['province'] == 'na')
        $provinceWhere = ' AND (state IS NULL OR LENGTH(state)<=0)';
      else
        $provinceWhere = ' AND state=' . '"' . sanitize(self::$db->escape($options['province'])). '"';
    }
    
    $where = "created>=$startDate"
    . " AND created<=$endDate"
    . $provinceWhere;
    
		$sql = "SELECT DATE_FORMAT(created, '%Y') AS aggOpt, "
          . "COUNT(id) as total FROM users "
          . "WHERE $where"
          . " GROUP BY aggOpt "
          . " ORDER BY aggOpt ASC";
    
		$rows = self::$db->fetch_all($sql);
		return ($rows) ? $rows : 0;
	}
	
	
	/**
	 * Analysis::monthSales($year, $month, $code = false)
	 *
	 * @return
	 */
	public function monthSales($year, $month, $code = false)
	{
		$wherecode = "";
		if ($code) {
			$wherecode = " AND discount_code = '" . $code . "'";
		}
		
		$sql = "SELECT COUNT(invid) as total FROM " . self::inTable . " WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " AND status > 0 AND pp <> 'Points'" . $wherecode;
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
	
	
	
	/**
	 * Analysis::countSales($code)
	 *
	 * @return
	 */
	public function countSales($code)
	{
		
		$sql = "SELECT COUNT(invid) as total FROM " . self::inTable . " WHERE discount_code = '" . $code . "' AND status > 0 AND pp <> 'Points'";
		
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
	
	/**
	 * Analysis::inventoryTransactions($year, $month, $code = false)
	 *
	 * @return
	 */
	public function inventoryTransactions($year, $month, $code = false)
	{
		$wherecode = "";
		if ($code) {
			$wherecode = " AND discount_code = '" . $code . "'";
		}
		$sql = "SELECT SUM(items) as total FROM " . self::inTable . " WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " AND status > 0 AND pp <> 'Points'" . $wherecode;
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
	
	
	
	/**
	 * Analysis::inventoryTransactionsSpecific($year, $month, $product)
	 *
	 * @return
	 */
	public function inventoryTransactionsSpecific($year, $month, $product)
	{
		$sql = "SELECT SUM(item_qty) as total FROM " . self::tTable . " WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " AND pid = " . $product;
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}
  
	/**
	 * Analysis::inventoryTransactionsSpecificMonthly($options)
	 *
	 * @return
	 */
	public function inventoryTransactionsSpecificMonthly($options)
	{
    $startDate = '"' . sanitize(self::$db->escape($options['startDate']. ' 00:00:00')). '"';
    $endDate = '"' . sanitize(self::$db->escape($options['endDate']. ' 23:59:59')). '"';
    $province = strlen($options['province'])>0 ? '"' . sanitize(self::$db->escape($options['province'])). '"' : null;
    
    $where = "t.created>=$startDate"
    . " AND t.created<=$endDate";
    
    $joins = '';
    if ($province)
    {
      $joins = "INNER JOIN invoices AS i ON i.invid=t.txn_id";
      $where .= " AND i.state=" . $province;
    }
    
		$sql = "SELECT DATE_FORMAT(t.created, '%Y-%m') AS aggOpt, t.pid, SUM(t.item_qty) as total FROM " . self::tTable . " AS t $joins WHERE $where GROUP BY aggOpt, t.pid";

		$rows = self::$db->fetch_all($sql);
		return ($rows) ? $rows : 0;
	}
  
	/**
	 * Analysis::inventoryTransactionsSpecificDaily($options)
	 *
	 * @return
	 */
	public function inventoryTransactionsSpecificDaily($options)
	{
    $startDate = '"' . sanitize(self::$db->escape($options['startDate']. ' 00:00:00')). '"';
    $endDate = '"' . sanitize(self::$db->escape($options['endDate']. ' 23:59:59')). '"';
    $province = strlen($options['province'])>0 ? '"' . sanitize(self::$db->escape($options['province'])). '"' : null;
    
    $where = "t.created>=$startDate"
    . " AND t.created<=$endDate";
    
    $joins = '';
    if ($province)
    {
      $joins = "INNER JOIN invoices AS i ON i.invid=t.txn_id";
      $where .= " AND i.state=" . $province;
    }
    
		$sql = "SELECT DATE_FORMAT(t.created, '%Y-%m-%d') AS aggOpt, t.pid, SUM(t.item_qty) as total FROM " . self::tTable . " AS t $joins WHERE $where GROUP BY aggOpt, t.pid";
    
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
  
	/**
	 * Analysis::inventoryTransactionsSpecificAnnual($options)
	 *
	 * @return
	 */
	public function inventoryTransactionsSpecificAnnual($options)
	{
    $startDate = '"' . sanitize(self::$db->escape($options['startDate']. ' 00:00:00')). '"';
    $endDate = '"' . sanitize(self::$db->escape($options['endDate']. ' 23:59:59')). '"';
    $province = strlen($options['province'])>0 ? '"' . sanitize(self::$db->escape($options['province'])). '"' : null;
    
    $where = "t.created>=$startDate"
    . " AND t.created<=$endDate";
    
    $joins = '';
    if ($province)
    {
      $joins = "INNER JOIN invoices AS i ON i.invid=t.txn_id";
      $where .= " AND i.state=" . $province;
    }
    
		$sql = "SELECT DATE_FORMAT(t.created, '%Y') AS aggOpt, t.pid, SUM(t.item_qty) as total FROM " . self::tTable . " AS t $joins WHERE $where GROUP BY aggOpt, pid";
    
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	
	
	/**
	 * Analysis::inventoryTransactionsSpecificFlavour($product, $nummonths)
	 *
	 * @return
	 */
	public function inventoryTransactionsSpecificFlavour($product, $nummonths)
	{
		
		$monthnum[0] = date("n");
		$monthname[0] = date("M");
		$yearnum[0] = date("Y");
		
		$monthFlavourRevenue[0] = $this->inventoryTransactionsSpecific($yearnum[0], $monthnum[0], $product)->total;
		if ($monthFlavourRevenue[0] == 0 || !$monthFlavourRevenue[0]) {
			$monthFlavourRevenue[0] = "0";
		}
		
		$labels = '"'. $monthname[0] . '"';
		$dataFlavourRev = $monthFlavourRevenue[0];
		
		for ($i = 1; $i <= $nummonths; $i++) {
			$monthnum[$i] = date("n", strtotime( date( 'Y-m-01' )." -$i months")) . " ";
			$monthname[$i] = date("M", strtotime( date( 'Y-m-01' )." -$i months")) . " ";
			$yearnum[$i] = date("Y", strtotime( date( 'Y-m-01' )." -$i months")) . " ";
			$monthFlavourRevenue[$i] = $this->inventoryTransactionsSpecific($yearnum[$i], $monthnum[$i], $product)->total;
			if ($monthFlavourRevenue[$i] == 0 || !$monthFlavourRevenue[$i]) {
				$monthFlavourRevenue[$i] = "0";
			}
			
			$labels = '"' . $monthname[$i] . '", ' . $labels; 
			$dataFlavourRev = $monthFlavourRevenue[$i] . ', ' . $dataFlavourRev; 
		}
		
		return $dataFlavourRev;
		
	}
	
	
	/**
	 * Analysis::monthRevenue($day)
	 *
	 * @return
	 */
	public function transactionsByProvince($year, $month)
	{
		$sql = "SELECT state, COUNT(state) as STATEQTY FROM " . self::inTable . " WHERE YEAR(created) = " . $year . " AND MONTH(created) = " . $month . " GROUP BY state HAVING COUNT(state) > 1";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	
	
	
	
}

?>
