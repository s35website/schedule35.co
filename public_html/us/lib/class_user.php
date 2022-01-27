<?php
/**
 * User Class
 *
 * @package FBC Studio
 * @author fbcstudio.com
 * @copyright 2010
 * @version $Id: class_user.php, v2.00 2011-07-10 10:12:05 gewa Exp $
 */

if (!defined("_VALID_PHP")) die('Direct access to this location is not allowed.');
class Users

{
	const uTable = "users";
	public $logged_in = null;
	public $uid = 0;
	public $userid = 0;
	public $username;
	public $sesid;
	public $email;
	public $name;
	public $fname;
	public $lname;
	public $avatar;
	public $country;
	public $state;
	public $userlevel;
	private $lastlogin = "NOW()";
	public $last;
	private static $db;
	public static $thumbfileext = array(
		"jpg",
		"jpeg",
		"png"
	);
	/**
	 * Users::__construct()
	 *
	 * @return
	 */
	function __construct() {
		self::$db = Registry::get("Database");
		$this->startSession();
		$this->autoLogin();
	}

	/**
	 * Users::startSession()
	 *
	 * @return
	 */
	private function startSession() {

		session_start();
		$this->logged_in = $this->loginCheck();
		if (!$this->logged_in) {
			$this->username = $_SESSION['USERNAME_US'] = "Guest";
			$this->sesid = sha1(session_id());
			$this->userlevel = 0;
		}
	}

	/**
	 * Users::loginCheck()
	 *
	 * @return
	 */
	private function loginCheck() {
		if (isset($_SESSION['USERNAME_US']) && $_SESSION['USERNAME_US'] != "Guest") {
			$row = $this->getUserInfo($_SESSION['USERNAME_US']);
			$this->uid = $row->id;
			$this->username = $row->username;
			$this->name = $row->fname . ' ' . $row->lname;
			$this->fname = $row->fname;
			$this->lname = $row->lname;
			$this->userlevel = $row->userlevel;
			$this->avatar = $row->avatar;
			$this->country = $row->country;
			$this->state = $row->state;
			$this->sesid = sha1(session_id());
			$this->lastlogin = $row->lastlogin;
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Users::is_Admin()
	 *
	 * @return
	 */
	public function is_Admin() {
		return ($this->userlevel == 9);
	}
	
	/**
	 * Users::is_Writer()
	 *
	 * @return
	 */
	public function is_Writer() {
		return ($this->userlevel == 7);
	}
	
	/**
	 * Users::is_Writer()
	 *
	 * @return
	 */
	public function is_Manager() {
		return ($this->userlevel == 6);
	}
	
	/**
	 * Users::is_Writer()
	 *
	 * @return
	 */
	public function is_Ambassador() {
		return ($this->userlevel >= 2);
	}

	/**
	 * Users::hasAdminAccess()
	 *
	 * @return
	 */
	public function hasAdminAccess() {
		return ($this->userlevel >= 6);
	}

	public function autoLoggedin($username, $remember) {
		if($remember==1) {
			$CookieExpire = 30; //The number of days after which the cookie would expire.
			$ctime = 60 * 60 * 24 * $CookieExpire;
			$time = time() + $ctime;
			$link = $this->stripHttp(Registry::get("Core")->site_url);
			setcookie("username", "$username", "$time", "/", "$link");
		}
	}
	
	
	public function autoLogin() {
		$this->logged_in = $this->loginCheck();
		if (!$this->logged_in) {
			if(isset($_COOKIE["username"]))
			{
				$cookieuser = $_COOKIE["username"];
				$row = $this->getUserInfo($cookieuser);
				$_SESSION['userid'] = $row->id;
				$_SESSION['USERNAME_US']= $row->username;
				$_SESSION['pageurl'] = "home";
			}
		}

	}



	/**
	 * Users::login()
	 *
	 * @param mixed $username
	 * @param mixed $pass
	 * @return
	 */
	public function login($username, $pass) {
		if ($username == "" && $pass == "") {
			Filter::$msgs['username'] = Lang::$word->LOGIN_R5;
		}
		else {
			$status = $this->checkStatus($username, $pass);
			switch ($status) {
			case 0:
				Filter::$msgs['username'] = Lang::$word->LOGIN_R1;
				break;

			case 1:
				Filter::$msgs['username'] = Lang::$word->LOGIN_R2;
				break;

//			case 2:
//				Filter::$msgs['username'] = Lang::$word->LOGIN_R3;
//				break;

			case 3:
				Filter::$msgs['username'] = Lang::$word->LOGIN_R4;
				break;
			}
		}
		
		if (empty(Filter::$msgs) && ($status == 2 OR $status == 5)) {
		
		
			
			$row = $this->getUserInfo($username);
			$this->uid = $_SESSION['userid'] = $row->id;
			$this->username = $_SESSION['USERNAME_US'] = $row->username;
			$this->name = $_SESSION['name'] = $row->fname . ' ' . $row->lname;
			$this->userlevel = $_SESSION['userlevel'] = $row->userlevel;
			$this->avatar = $_SESSION['avatar'] = $row->avatar;
			$this->lastlogin = $_SESSION['last'] = $row->lastlogin;
			
			
			
			$data = array(
				'lastlogin' => $this->lastlogin,
				'password_reset_key' => '',
				'password_reset_confirmed' => 'n',
				'password_reset_timestamp' => '0000-00-00 00:00:00',
				'lastip' => sanitize($_SERVER['REMOTE_ADDR'])
			);
			
			self::$db->update(self::uTable, $data, "username='" . $this->username . "'");
			return true;
		}
		else {
			
			$json['message'] = Filter::msgStatusSimple();
			$_SESSION['registererror'] = Filter::msgStatusSimple();
			Filter::$msgs['username'] = null;
			
		}
		
	}

	/**
	 * Users::logout()
	 *
	 * @return
	 */
	public function logout() {
		unset($_SESSION['USERNAME_US']);
		unset($_SESSION['name']);
		unset($_SESSION['userid']);
		unset($_SESSION['uid']);
		if(isset($_COOKIE["username"])) {
			$time = time() - 86400;
			$link = $this->stripHttp(Registry::get("Core")->site_url);
			setcookie("username", "", "$time", "/", "$link");
			setcookie("password", "", "$time", "/", "$link");
		}
		session_destroy();
		$this->logged_in = false;
		$this->username = "Guest";
		$this->userlevel = 0;
	}


	/**
	 * Users::getUserInfoWithID()
	 *
	 * @param mixed $userid
	 * @return
	 */
	public function getUserInfoWithID($userid) {
		$userid = sanitize($userid);
		$userid = self::$db->escape($userid);
		$sql = "SELECT *, CONCAT(fname,' ',lname) as fullname  FROM " . self::uTable . " WHERE id = '" . $userid . "'";
		$row = self::$db->first($sql);
		if (!$userid) return false;
		return ($row) ? $row : 0;
	}

	/**
	 * Users::getUserInfo()
	 *
	 * @param mixed $username
	 * @return
	 */
	private function getUserInfo($username) {
		$username = sanitize($username);
		$username = self::$db->escape($username);
		$sql = "SELECT *  FROM " . self::uTable . " WHERE username = '" . $username . "'";
		$row = self::$db->first($sql);
		if (!$username) return false;
		return ($row) ? $row : 0;
	}

	/**
	 * Users::checkStatus()
	 *
	 * @param mixed $username
	 * @param mixed $pass
	 * @return
	 */
	public function checkStatus($username, $pass) {
		$username = sanitize($username);
		$username = self::$db->escape($username);
		$pass = sanitize($pass);
		$sql = "SELECT password, active FROM " . self::uTable . "\n WHERE username = '" . $username . "'";
		$result = self::$db->query($sql);
		if (self::$db->numrows($result) == 0) return 0;
		$row = self::$db->fetch($result);
		$entered_pass = sha1($pass);
		switch ($row->active) {
		case "b":
			return 1;
			break;
				
		case "n" && $entered_pass == $row->password:
			return 2;
			break;

		case "t":
			return 3;
			break;

		case "y" && $entered_pass == $row->password:
			return 5;
			break;
		}
	}

	/**
	 * Users::getUsers()
	 *
	 * @param bool $from
	 * @return
	 */
	public function getUsers($from = false) {
		if (isset($_GET['letter']) and (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '')) {
			$enddate = date("Y-m-d");
			$letter = sanitize($_GET['letter'], 2);
			$fromdate = (empty($from)) ? $_POST['fromdate_submit'] : $from;
			if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
				$enddate = $_POST['enddate_submit'];
			}

			$q = "SELECT COUNT(*) FROM " . self::uTable . " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'" . "\n AND username REGEXP '^" . self::$db->escape($letter) . "'";
			$where = " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' AND username REGEXP '^" . self::$db->escape($letter) . "'";
		}
		elseif (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '') {
			$enddate = date("Y-m-d");
			$fromdate = (empty($from)) ? $_POST['fromdate_submit'] : $from;
			if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
				$enddate = $_POST['enddate_submit'];
			}

			$q = "SELECT COUNT(*) FROM " . self::uTable . " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
			$where = " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
		}
		elseif (isset($_GET['letter'])) {
			$letter = sanitize($_GET['letter'], 2);
			$where = "WHERE username REGEXP '^" . self::$db->escape($letter) . "'";
			$q = "SELECT COUNT(*) FROM " . self::uTable . " WHERE username REGEXP '^" . self::$db->escape($letter) . "' LIMIT 1";
		}
		else {
			$q = "SELECT COUNT(*) FROM " . self::uTable . " LIMIT 1";
			$where = null;
		}

		$record = self::$db->query($q);
		$total = self::$db->fetchrow($record);
		$counter = $total[0];
		$pager = Paginator::instance();
		$pager->items_total = $counter;
		$pager->default_ipp = Registry::get("Core")->perpage;
		$pager->paginate();
		$sql = "SELECT *, CONCAT(fname,' ',lname) as name," . " (SELECT COUNT(transactions.uid) FROM transactions WHERE transactions.uid = users.id) as totalitems FROM " . self::uTable . " $where" . " ORDER BY created DESC" . $pager->limit;
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}
	
	/** Returns the number of products in a collection
	 * @param $where string the SQL WHERE clause
	 * @return int The number of rows
	 */
	public function countUsers() {
		$sql = "SELECT count(id) count FROM " . self::uTable;
		$row = self::$db->first($sql);
		return ($row) ? $row->count : 0;
	}
	
	/** Returns the number of products in a collection
	 * @param $where string the SQL WHERE clause
	 * @return int The number of rows
	 */
	public function countAmbassadors() {
		$sql = "SELECT count(id) count FROM " . self::uTable . " WHERE userlevel = '2'";
		$row = self::$db->first($sql);
		return ($row) ? $row->count : 0;
	}
	
	
	/**
	 * Users::getUserByChar()
	 *
	 * @param bool $from
	 * @return
	 */
	public function getUserByChar($char)
	{
		if ($char) {
			$sql = "SELECT *, CONCAT(fname,' ',lname) as name, (SELECT COUNT(transactions.uid) FROM transactions WHERE transactions.uid = users.id) as totalitems FROM " . self::uTable . " WHERE username LIKE '" . $char . "%'";
		}else {
			$sql = "SELECT *, CONCAT(fname,' ',lname) as name, (SELECT COUNT(transactions.uid) FROM transactions WHERE transactions.uid = users.id) as totalitems FROM " . self::uTable . " WHERE username LIKE '1%' or username LIKE '2%' or username LIKE '3%' or username LIKE '4%' or username LIKE '5%' or username LIKE '6%' or username LIKE '7%' or username LIKE '8%' or username LIKE '9%' or username LIKE '0%'";
		}
		
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : array();
	}
	
	/**
	 * Users::getAllUsers()
	 *
	 * @param bool $from
	 * @return
	 */
	public function getAllUsers($page, $perPage)
	{
		if (!is_numeric($page)) return false;
		if (!is_numeric($perPage)) return false;
		
		
		$offset = ($page - 1) * $perPage;

		$sql = "SELECT * FROM " . self::uTable . " ORDER BY username";
		
		if ($perPage != 0) {
			$sql.= " LIMIT $perPage OFFSET $offset";
		}
		
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : array();
	}
	
	/**
		 * Users::getAllAmbassadors()
		 *
		 * @param bool $from
		 * @return
		 */
		public function getAllAmbassadors($page, $perPage)
		{
			if (!is_numeric($page)) return false;
			if (!is_numeric($perPage)) return false;
			
			
			$offset = ($page - 1) * $perPage;
	
			$sql = "SELECT * FROM " . self::uTable . " WHERE userlevel = 2 ORDER BY username";
			
			if ($perPage != 0) {
				$sql.= " LIMIT $perPage OFFSET $offset";
			}
			
			$row = self::$db->fetch_all($sql);
			return ($row) ? $row : array();
		}

	/**
	 * Users::processUser()
	 *
	 * @return
	 */
	public function processUser() {
		if (!Filter::$id) {
			Filter::checkPost('email', Lang::$word->USERNAME);
			if ($value = $this->usernameExists($_POST['email'])) {
				if ($value == 1) Filter::$msgs['username'] = Lang::$word->USERNAME_R2;
//				if ($value == 2) Filter::$msgs['username'] = Lang::$word->USERNAME_R3;
				if ($value == 3) Filter::$msgs['username'] = Lang::$word->USERNAME_R4;
			}
		}

		Filter::checkPost('fname', Lang::$word->FNAME);

		if (!Filter::$id) {
			Filter::checkPost('password', Lang::$word->PASSWORD);
		}

		Filter::checkPost('email', Lang::$word->EMAIL);
		if (!Filter::$id) {
			if ($this->emailExists($_POST['email'])) Filter::$msgs['email'] = Lang::$word->EMAIL_R2;
		}

		if (!$this->isValidEmail($_POST['email'])) Filter::$msgs['email'] = Lang::$word->EMAIL_R3;
		if (!empty($_FILES['avatar']['name'])) {
			if (!preg_match("/(\.jpg|\.png)$/i", $_FILES['avatar']['name'])) {
				Filter::$msgs['avatar'] = Lang::$word->CONF_LOGO_R;
			}

			$file_info = getimagesize($_FILES['avatar']['tmp_name']);
			if (empty($file_info)) Filter::$msgs['avatar'] = Lang::$word->CONF_LOGO_R;
		}

		if (empty(Filter::$msgs)) {
			$data = array(
				'username' => sanitize($_POST['email']),
				'lname' => sanitize($_POST['lname']),
				'fname' => sanitize($_POST['fname']),
				'notes' => sanitize($_POST['notes']),
				'newsletter' => intval($_POST['newsletter']),
				'notifications' => intval($_POST['notifications']),
				'purchase_receipts' => intval($_POST['purchase_receipts']),
				
				'points_current' => intval($_POST['points_current']),
				'points_lifetime' => intval($_POST['points_lifetime']),
				'invites' => intval($_POST['invites']),
				'invite_code' => sanitize($_POST['invite_code']),
				'payout' => intval($_POST['payout']),
				
				
				'fullname_shipping' => sanitize($_POST['fullname_shipping']),
				'phone' => sanitize($_POST['phone']),
				'address' => sanitize($_POST['address']),
				'address2' => sanitize($_POST['address2']),
				'city' => sanitize($_POST['city']),
				'zip' => sanitize($_POST['zip']),
				'country' => sanitize($_POST['country']),
				'state' => sanitize($_POST['state']),
				
				
				'userlevel' => intval($_POST['userlevel']),
				'active' => sanitize($_POST['active'])
			);
			if (!Filter::$id) $data['created'] = "NOW()";
			if (Filter::$id) $userrow = Registry::get("Core")->getRowById(self::uTable, Filter::$id);
			if ($_POST['password'] != "") {
				$data['password'] = sha1($_POST['password']);
			}
			else {
				$data['password'] = $userrow->password;
			}

			// Procces Avatar

			if (!empty($_FILES['avatar']['name'])) {
				$thumbdir = UPLOADS . "avatars/";
				$tName = "AVT_" . randName();
				$text = substr($_FILES['avatar']['name'], strrpos($_FILES['avatar']['name'], '.') + 1);
				$thumbName = $thumbdir . $tName . "." . strtolower($text);
				if (Filter::$id && $thumb = getValueById("avatar", self::uTable, Filter::$id)) {
					@unlink($thumbdir . $thumb);
				}

				move_uploaded_file($_FILES['avatar']['tmp_name'], $thumbName);
				$data['avatar'] = $tName . "." . strtolower($text);
			}

			(Filter::$id) ? self::$db->update(self::uTable, $data, "id=" . Filter::$id) : self::$db->insert(self::uTable, $data);
			$message = (Filter::$id) ? Lang::$word->USR_UPDATED : Lang::$word->USR_ADDED;
			if (self::$db->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk($message, false);
				print json_encode($json);
				if (isset($_POST['notify']) && intval($_POST['notify']) == 1) {
					require_once (BASEPATH . "lib/class_mailer.php");

					$mailer = Mailer::sendMail();
					$row = Registry::get("Core")->getRowById(Content::eTable, 3);
					$body = str_replace(array(
						'[USERNAME]',
						'[PASSWORD]',
						'[NAME]',
						'[SITE_NAME]',
						'[URL]'
					), array(
						$data['username'],
						$_POST['password'],
						$data['fname'] . ' ' . $data['lname'],
						Registry::get("Core")->site_name,
						SITEURL
					), $row->body);
					$msg = Swift_Message::newInstance()->setSubject($row->subject)->setTo(array(
						$data['username'] => $data['fname'] . ' ' . $data['lname']
					))->setFrom(array(
						Registry::get("Core")->site_email => Registry::get("Core")->company
					))->setBody(cleanOut($body), 'text/html');
					$mailer->send($msg);
				}
			}
			else {
				$json['type'] = 'success';
				$json['message'] = Filter::msgAlert(Lang::$word->NOPROCCESS, false);
				print json_encode($json);
			}
		}
		else {
			$json['message'] = Filter::msgStatus();
			print json_encode($json);
		}
	}

	/**
	 * Users::updateProfile()
	 *
	 * @return
	 */
	public function updateProfile() {
		Filter::checkPost('fname', Lang::$word->FNAME);
		Filter::checkPost('lname', Lang::$word->LNAME);
		Filter::checkPost('email', Lang::$word->EMAIL);
		Filter::checkPost('address', Lang::$word->_UA_ADDRESS);
		Filter::checkPost('city', Lang::$word->_UA_CITY);
		Filter::checkPost('state', Lang::$word->_UA_STATE);
		Filter::checkPost('zip', Lang::$word->_UA_ZIP);
		Filter::checkPost('country', Lang::$word->_UA_COUNTRY);
		if (!$this->isValidEmail($_POST['email'])) Filter::$msgs['email'] = Lang::$word->EMAIL_R3;
		if (!empty($_FILES['avatar']['name'])) {
			if (!preg_match("/(\.jpg|\.png)$/i", $_FILES['avatar']['name'])) {
				Filter::$msgs['avatar'] = Lang::$word->CONF_LOGO_R;
			}

			$file_info = getimagesize($_FILES['avatar']['tmp_name']);
			if (empty($file_info)) Filter::$msgs['avatar'] = Lang::$word->CONF_LOGO_R;
		}

		if (empty(Filter::$msgs)) {
			$data = array(
				'username' => sanitize($_POST['email']),
				'lname' => sanitize($_POST['lname']),
				'fname' => sanitize($_POST['fname']),
				'address' => sanitize($_POST['address']),
				'city' => sanitize($_POST['city']),
				'country' => sanitize($_POST['country']),
				'state' => sanitize($_POST['state']),
				'zip' => sanitize($_POST['zip']),
				'newsletter' => intval($_POST['newsletter'])
			);
			$userpass = getValueById("password", self::uTable, $this->uid);
			if ($_POST['password'] != "") {
				$data['password'] = sha1($_POST['password']);
			}
			else $data['password'] = $userpass;

			// Procces Avatar

			if (!empty($_FILES['avatar']['name'])) {
				$thumbdir = UPLOADS . "avatars/";
				$tName = "AVT_" . randName();
				$text = substr($_FILES['avatar']['name'], strrpos($_FILES['avatar']['name'], '.') + 1);
				$thumbName = $thumbdir . $tName . "." . strtolower($text);
				if (Filter::$id && $thumb = getValueById("avatar", self::uTable, Filter::$id)) {
					@unlink($thumbdir . $thumb);
				}

				move_uploaded_file($_FILES['avatar']['tmp_name'], $thumbName);
				$data['avatar'] = $tName . "." . strtolower($text);
			}

			self::$db->update(self::uTable, $data, "id=" . $this->uid);
			if (self::$db->affected()) {
				$json['status'] = 'success';
				$json['message'] = Filter::msgOk(Lang::$word->_UA_PROFILE_OK, false);
			}
			else {
				$json['status'] = 'info';
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
	 * Users::updateName()
	 *
	 * @return
	 */
	public function updateName() {
		Filter::checkPost('fname', Lang::$word->FNAME_R1);
		if (empty(Filter::$msgs)) {
			$data = array(
				'fname' => sanitize($_POST['fname']),
				'lname' => sanitize($_POST['lname'])
			);
			self::$db->update(self::uTable, $data, "id=" . $this->uid);
			if (self::$db->affected()) {
				$json['status'] = 'success';
				$json['section'] = sanitize($_POST['section']);
				$json['fullname'] = sanitize($_POST['fname'] . " " . $_POST['lname']);
				$json['message'] = Filter::msgSingleOkPopup(Lang::$word->_UA_PROFILE_OK, false);

				// Update session variables

				$this->username = $_SESSION['name'] = $_POST['fname'] . ' ' . $_POST['lname'];
			}
			else {
				$json['status'] = 'success';
				$json['section'] = sanitize($_POST['section']);
				$json['fullname'] = sanitize($_POST['fname'] . " " . $_POST['lname']);
				$json['message'] = Filter::msgSingleAlertPopup(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['status'] = 'info';
			$json['message'] = Filter::msgStatusPopup();
			print json_encode($json);
		}
	}
	
	
	/**
	 * Users::updateNotes()
	 *
	 * @return
	 */
	public function updateNotes() {
	
		if (empty(Filter::$msgs)) {
			$data = array(
				'notes' => sanitize($_POST['notes'])
			);
			self::$db->update(self::uTable, $data, "id=" . $this->uid);
			if (self::$db->affected()) {
				$json['status'] = 'success';
				$json['message'] = Filter::msgSingleOkPopup(Lang::$word->_UA_PROFILE_OK, false);
			}
			else {
				$json['status'] = 'success';
				$json['message'] = Filter::msgSingleAlertPopup(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['status'] = 'info';
			$json['message'] = Filter::msgStatusPopup();
			print json_encode($json);
		}
	}
	
	
	/**
	 * Users::updateNotes()
	 *
	 * @return
	 */
	public function updatePayout() {
	
		if (empty(Filter::$msgs)) {
			$data = array(
				'payout' => sanitize($_POST['payout'])
			);
			self::$db->update(self::uTable, $data, "id=" . $this->uid);
			if (self::$db->affected()) {
				$json['status'] = 'success';
				$json['message'] = Filter::msgSingleOkPopup(Lang::$word->_UA_PROFILE_OK, false);
			}
			else {
				$json['status'] = 'success';
				$json['message'] = Filter::msgSingleAlertPopup(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['status'] = 'info';
			$json['message'] = Filter::msgStatusPopup();
			print json_encode($json);
		}
	}

	/**
	 * Users::updateEmail()
	 *
	 * @return
	 */
	public function updateEmail() {
		Filter::checkPost('email', Lang::$word->EMAIL);
		if ($_POST['email'] != $_SESSION['email']) {
			if ($this->emailExists($_POST['email'])) {
				Filter::$msgs['email'] = Lang::$word->EMAIL_R2;
			}
			elseif (!$this->isValidEmail($_POST['email'])) {
				Filter::$msgs['email'] = Lang::$word->EMAIL_R3;
			}
		}

		if (empty(Filter::$msgs)) {
			$data = array(
				'username' => sanitize($_POST['email'])
			);
			self::$db->update(self::uTable, $data, "id=" . $this->uid);
			if (self::$db->affected()) {
				$this->login($_POST['email'], $_POST['pass']);
				$json['status'] = 'success';
				$json['section'] = sanitize($_POST['section']);
				$json['email'] = sanitize($_POST['email']);
				$json['message'] = Filter::msgSingleOkPopup(Lang::$word->_UA_PROFILE_OK, false);

				// Update session variables

				$row = $this->getUserInfo(sanitize($_POST['email']));
				$this->uid = $_SESSION['userid'] = $row->id;
				$this->username = $_SESSION['USERNAME_US'] = $row->username;
				$this->lastlogin = $_SESSION['last'] = $row->lastlogin;
			}
			else {
				$json['status'] = 'success';
				$json['section'] = sanitize($_POST['section']);
				$json['email'] = sanitize($_POST['email']);
				$json['message'] = Filter::msgSingleAlertPopup(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['status'] = 'info';
			$json['message'] = Filter::msgStatusPopup();
			print json_encode($json);
		}
	}

	/**
	 * Users::updatePassword()
	 *
	 * @return
	 */
	public function updatePassword() {
		Filter::checkPost('verifyPW', Lang::$word->PASSWORD_R2);
		Filter::checkPost('newPW', Lang::$word->PASSWORD_R2);
		Filter::checkPost('confirmPW', Lang::$word->PASSWORD_R2);

		// Grab variables

		$verify_password = $_POST['verifyPW'];
		$new_password = $_POST['newPW'];
		$confirm_password = $_POST['confirmPW'];
		$verify_password = sha1($verify_password);
		$current_password = getValueById("password", self::uTable, $this->uid);
		if (!($verify_password == $current_password)) {
			Filter::$msgs['password'] = Lang::$word->PASSWORD_R;
		}

		if (strlen($new_password) < 5) {
			Filter::$msgs['password'] = Lang::$word->PASSWORD_T2;
		}

		if ($new_password != $confirm_password) {
			Filter::$msgs['password'] = Lang::$word->PASSWORD_T1;
		}

		if (empty(Filter::$msgs)) {
			$data['password'] = sha1($new_password);
			self::$db->update(self::uTable, $data, "id=" . $this->uid);
			if (self::$db->affected()) {
				$json['status'] = 'success';
				$json['section'] = sanitize($_POST['section']);
				$json['message'] = Filter::msgSingleOkPopup(Lang::$word->_UA_PROFILE_OK, false);
			}
			else {
				$json['status'] = 'success';
				$json['section'] = sanitize($_POST['section']);
				$json['message'] = Filter::msgSingleAlertPopup(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['status'] = 'info';
			$json['message'] = Filter::msgStatusPopup();
			print json_encode($json);
		}
	}

	/**
	 * Users::updateThumb()
	 *
	 * @return
	 */
	public function updateThumb() {
		if (!empty($_FILES['thumb']['name'])) {
			$thumbExtension = pathinfo($_FILES['thumb']['name'], PATHINFO_EXTENSION);
			if (!in_array(strtolower($thumbExtension), self::$thumbfileext)) {
				Filter::$msgs['thumb'] = Lang::$word->THUMB_R1;
			}
		}
		else {
			Filter::$msgs['thumb'] = "Please upload a photo of your drivers license.";
		}

		if (empty(Filter::$msgs)) {
			$fname = getValueById("fname", self::uTable, $this->uid);
			$lname = getValueById("lname", self::uTable, $this->uid);

			// Process Avatar
			require_once (BASEPATH . "lib/ImageManipulator.php");

			$thumbdir = UPLOADS . "avatars/";
			$tName = "AVT_" . $this->uid . "_" . $fname . "_" . $lname;
			$tName = str_replace(' ', '_', $tName);

			$text = substr($_FILES['thumb']['name'], strrpos($_FILES['thumb']['name'], '.') + 1);
			$destination = $thumbdir . $tName . "." . strtolower($text);


			$manipulator = new ImageManipulator($_FILES['thumb']['tmp_name']);
			$width = $manipulator->getWidth();
			$height = $manipulator->getHeight();

			// setup variables to hold the new height/width;
			$mediumHeight = 0;
			$mediumWidth = 600;

			if($width > 800) {
			    // setup height to be proportional to the original so we don't get stretching.
			    $mediumHeight = ($mediumWidth * $height) / $width;

			    // resize the image in the manipulator class.
			    $manipulator->resample($mediumWidth, $mediumHeight);
			}

			// saving file to uploads folder

			$manipulator->save($destination);
			$data['avatar'] = $tName . "." . strtolower($text);


			self::$db->update(self::uTable, $data, "id=" . $this->uid);
			if (self::$db->affected()) {
				$json['status'] = 'success';
				$json['message'] = Filter::msgSingleOkPopup(Lang::$word->_UA_PROFILE_OK, false);
			}
			else {
				$json['status'] = 'success';
				$json['message'] = Filter::msgSingleAlertPopup(Lang::$word->NOPROCCESS, false);
			}

			$json['status'] = 'success';
			$json['message'] = Filter::msgSingleOkPopup(Lang::$word->_UA_PROFILE_OK, false);
			print json_encode($json);
		}
		else {
			$json['status'] = 'info';
			$json['message'] = Filter::msgStatusPopup();
			print json_encode($json);
		}
	}

	/**
	 * Users::updateShipping()
	 *
	 * @return
	 */
	public function updateShipping() {
		Filter::checkPost('fullname', Lang::$word->FULLNAME_R1);
		Filter::checkPost('address', Lang::$word->ADDRESS_R1);
		Filter::checkPost('city', Lang::$word->CITY_R1);
		Filter::checkPost('state', Lang::$word->STATE_R1);
		Filter::checkPost('zip', Lang::$word->ZIP_R1);
		if (empty(Filter::$msgs)) {
			$data = array(
				'fullname_shipping' => sanitize($_POST['fullname']),
				'address' => sanitize($_POST['address']),
				'address2' => sanitize($_POST['address2']),
				'city' => sanitize($_POST['city']),
				'state' => sanitize($_POST['state']),
				'zip' => sanitize($_POST['zip']),
				'phone' => intval($_POST['telephone'])
			);
			self::$db->update(self::uTable, $data, "id=" . $this->uid);
			if (self::$db->affected()) {
				$json['status'] = 'success';
				$json['section'] = sanitize($_POST['section']);
				$json['fullname'] = sanitize($_POST['fullname']);
				$json['address'] = sanitize($_POST['address']);
				$json['address2'] = sanitize($_POST['address2']);
				$json['city'] = sanitize($_POST['city']);
				$json['state'] = sanitize($_POST['state']);
				$json['zip'] = sanitize($_POST['zip']);
				$json['telephone'] = sanitize($_POST['telephone']);
				$json['message'] = Filter::msgSingleOkPopup(Lang::$word->_UA_PROFILE_OK, false);

				// Update session variables

				$this->username = $_SESSION['name'] = $_POST['fname'] . ' ' . $_POST['lname'];
			}
			else {
				$json['status'] = 'success';
				$json['section'] = sanitize($_POST['section']);
				$json['fullname'] = sanitize($_POST['fullname']);
				$json['address'] = sanitize($_POST['address']);
				$json['address2'] = sanitize($_POST['address2']);
				$json['city'] = sanitize($_POST['city']);
				$json['state'] = sanitize($_POST['state']);
				$json['zip'] = sanitize($_POST['zip']);
				$json['telephone'] = sanitize($_POST['telephone']);
				$json['message'] = Filter::msgSingleAlertPopup(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['status'] = 'info';
			$json['message'] = Filter::msgStatusPopup();
			print json_encode($json);
		}
	}
	
	
	
	
	/**
	 * Users::updateProfileSettings()
	 *
	 * @return
	 */
	public function updateProfileSettings() {
		Filter::checkPost('fname', Lang::$word->FNAME_R1);
		if (empty(Filter::$msgs)) {
			$data = array(
				'fname' => sanitize($_POST['fname']),
				'lname' => sanitize($_POST['lname']),
				'phone' => sanitize($_POST['phone'])
			);
			self::$db->update(self::uTable, $data, "id=" . $this->uid);
			if (self::$db->affected()) {
				$json['status'] = 'success';
				$json['message'] = Filter::msgSingleOkPopup(Lang::$word->_UA_PROFILE_OK, false);

				// Update session variables
				$this->username = $_SESSION['name'] = $_POST['fname'] . ' ' . $_POST['lname'];
			}
			else {
				$json['status'] = 'success';
				$json['fullname'] = sanitize($_POST['fname'] . " " . $_POST['lname']);
				$json['message'] = Filter::msgSingleAlertPopup(Lang::$word->NOPROCCESS, false);
			}

			print json_encode($json);
		}
		else {
			$json['status'] = 'info';
			$json['message'] = Filter::msgStatusPopup();
			print json_encode($json);
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * Users::updateShipping()
	 *
	 * @return
	 */
	public function updateShippingAddress() {
		Filter::checkPost('fullname', Lang::$word->FULLNAME_R1);
		Filter::checkPost('address', Lang::$word->ADDRESS_R1);
		Filter::checkPost('city', Lang::$word->CITY_R1);
		Filter::checkPost('state', Lang::$word->STATE_R1);
		Filter::checkPost('zip', Lang::$word->ZIP_R1);
		if (empty(Filter::$msgs)) {
			$data = array(
				'fullname_shipping' => sanitize($_POST['fullname']),
				'address' => sanitize($_POST['address']),
				'address2' => sanitize($_POST['address2']),
				'city' => sanitize($_POST['city']),
				'state' => sanitize($_POST['state']),
				'zip' => sanitize($_POST['zip'])
			);
			self::$db->update(self::uTable, $data, "id=" . $this->uid);
			if (self::$db->affected()) {
				$this->username = $_SESSION['name'] = $_POST['fullname'];
			}
			else {
				$json['message'] = Filter::msgSingleAlertPopup(Lang::$word->NOPROCCESS, false);
			}
			print json_encode($json);
		}
		else {
			$json['status'] = 'info';
			$json['message'] = Filter::msgStatusPopup();
			print json_encode($json);
		}
	}


	/**
	 * Users::updateNotifications()
	 *
	 * @return
	 */
	public function updateNotifications() {
		$data = array(
			'newsletter' => intval($_POST['newsletter']),
			'notifications' => intval($_POST['notifications']),
			'purchase_receipts' => intval($_POST['purchase_receipts'])
		);
		self::$db->update(self::uTable, $data, "id=" . $this->uid);
		if (self::$db->affected()) {
			$json['status'] = 'success';
		}
		else {
			$json['status'] = 'success';
			$json['message'] = Filter::msgSingleAlertPopup(Lang::$word->NOPROCCESS, false);
		}

		print json_encode($json);
	}
	
	
	
	/**
	 * Users::updateNewsletterFlag()
	 *
	 * @return
	 */
	public function updateNewsletterFlag() {

		$data['newsletter'] = 1;
		self::$db->update(self::uTable, $data, "id=" . $this->uid);
		if (self::$db->affected()) {
			$json['status'] = 'success';
		}
		else {
			$json['status'] = 'success';
			$json['message'] = Filter::msgSingleAlertPopup(Lang::$word->NOPROCCESS, false);
		}

		print json_encode($json);
	}


	/**
	 * User::registerSimple()
	 *
	 * @return
	 */
	public function registerSimple() {
		Filter::checkPost('fullname', Lang::$word->FULLNAME);
		Filter::checkPost('pass', Lang::$word->PASSWORD);
		Filter::checkPost('age_very', Lang::$word->AGE_R1);

		if (Registry::get("Core")->invite_only == 1) {
			Filter::checkPost('inviteCode', Lang::$word->INVITE_ERROR0);
		}

		if (!ctype_alpha(str_replace(' ', '', sanitize($_POST['fullname'])))) {
			Filter::$msgs['fullname'] = 'Name must contain letters and spaces only';
		}
		
		// Send email
		require_once (BASEPATH . "lib/class_mailer.php");

		/*
		if (!empty($_FILES['thumb']['name'])) {
			$thumbExtension = pathinfo($_FILES['thumb']['name'], PATHINFO_EXTENSION);
			if (!in_array(strtolower($thumbExtension), self::$thumbfileext)) {
				Filter::$msgs['thumb'] = Lang::$word->THUMB_R1;
			}
		}
		else {
			Filter::$msgs['thumb'] = "Please upload a photo of your drivers license or passport.";
		}
		*/

		if (strlen($_POST['pass']) < 6) Filter::$msgs['pass'] = Lang::$word->PASSWORD_T2;
		Filter::checkPost('email', Lang::$word->EMAIL);
		if ($this->emailExists($_POST['email'])) Filter::$msgs['email'] = Lang::$word->EMAIL_R2;
		if (!$this->isValidEmail($_POST['email'])) Filter::$msgs['email'] = Lang::$word->EMAIL_R3;


		if (empty(Filter::$msgs)) {
		
			$_SESSION['fullname'] = sanitize($_POST['fullname']);
			$_SESSION['USERNAME_US'] = sanitize($_POST['email']);
			$_SESSION['age_very'] = sanitize($_POST['age_very']);
		
			$pass = sanitize($_POST['pass']);
			if (Registry::get("Core")->reg_verify == 1) {
				$active = "n";
			}
			else {
				$active = "y";
			}

			// Get first and last name
			$fullname = sanitize($_POST['fullname']);
			$name_holder = explode(' ', $fullname);
			$fname = $name_holder[0];
			$lname = ltrim($fullname, $fname . ' ');
			$key = $this->generateKey(sanitize($_POST['email']));
			
			$data = array(
				'username' => sanitize($_POST['email']),
				'password' => sha1($_POST['pass']),
				'fname' => $fname,
				'lname' => $lname,
				'active' => $active,
				'hash' => $key,
				'country' => 'CA',
				'invites' => 1,
				'points_current' => 100,
				'points_lifetime' => 100,
				'payout' => 10,
				'newsletter' => intval($_POST['newsletter']),
				'created' => "NOW()"
			);
			$last_id = self::$db->insert(self::uTable, $data);

			// Create invite code and put in Database
			$data['invite_code'] = "U" . $last_id . "CA" . date("ymd");
			self::$db->update(self::uTable, $data, "id=" . $last_id);

			if (Registry::get("Core")->invite_only == 1) {

				// Update referral users invite code so they have 1 less
				$inviteCode = sanitize($_POST['inviteCode']);
				// check if invite code was filled out
				if ($inviteCode) {
				
					// find invite code in Database
					$row2 = self::$db->first("SELECT * FROM " . Content::invTable . " WHERE code = '" . $inviteCode . "'");

					$row3 = self::$db->first("SELECT * FROM " . Users::uTable . " WHERE invite_code = '" . $inviteCode . "'");

					// Add a counter to how many invites
					if ($row2) {
						$sql = "SELECT * FROM " . Content::invTable . " WHERE code = '" . $inviteCode . "'";
						$urow = self::$db->first($sql);
						$invdata['used'] = $urow->used + 1;
						self::$db->update(Content::invTable, $invdata, "code = '" . $inviteCode . "'");
					}
					// Remove 1 invite code from user invites
					elseif ($row3) {
						$points_earned = 25;
						$sql = "SELECT * FROM " . self::uTable . " WHERE invite_code = '" . $inviteCode . "'";
						$urow = self::$db->first($sql);
						$udata['invites'] = $urow->invites - 1;
						$udata['points_current'] = $urow->points_current + $points_earned;
						$udata['points_lifetime'] = $urow->points_lifetime + $points_earned;
						self::$db->update(self::uTable, $udata, "invite_code = '" . $inviteCode . "'");
						
						
						// Send email to new user
						$template = file_get_contents('../templates_email/email_usedinvitecode.html');
						$template = str_replace(array(
							'[SITEURL]',
							'[SITE_NAME]',
							'[COMPANY]',
							'[FRIEND]',
							'[POINTS]',
							'[LOCATION]'
						), array(
							Registry::get("Core")->site_url,
							Registry::get("Core")->site_name,
							Registry::get("Core")->company,
							$fullname,
							$points_earned,
							'Vancouver, British Columbia'
						), $template);
						$mailer = Mailer::sendMail();
						$message = Swift_Message::newInstance()
						->setSubject('You just earned Points')
						->setTo(array($urow->username => $urow->fname))
						->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
						->setBody($template, 'text/html');
						$mailer->send($message);
						
					}
				}
			}
			
			// Send email to new user
			if (Registry::get("Core")->reg_verify == 1) {
				$template = file_get_contents('../templates_email/email_welcome_withverification.html');
				$subject = "Please verify your email address";
				
			}else {
				$template = file_get_contents('../templates_email/email_welcome.html');
				$subject = 'Welcome to ' . Registry::get("Core")->company;
			}
			$link = Registry::get("Core")->site_url . Registry::get("Core")->site_dir . "/verify?k=" . $key;
			$template = str_replace(array(
				'[SITEURL]',
				'[SITE_NAME]',
				'[COMPANY]',
				'[EMAIL]',
				'[LOCATION]',
				'[LINK]'
			), array(
				Registry::get("Core")->site_url,
				Registry::get("Core")->site_name,
				Registry::get("Core")->company,
				$data['username'],
				'Vancouver, British Columbia',
				$link
			), $template);
			$mailer = Mailer::sendMail();
			$message = Swift_Message::newInstance()
			->setSubject($subject)
			->setTo(array($data['username'] => $data['fname'] . ' ' . $data['lname']))
			->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
			->setBody($template, 'text/html');
			$mailer->send($message);
			
			
			
			
			
			
			// Notify Admin
			if (Registry::get("Core")->notify_admin) {

				$templateAdmin = file_get_contents('../templates_email/notify_welcome.html');
				$templateAdmin = str_replace(array(
					'[NAME]',
					'[SITEURL]',
					'[SITE_NAME]',
					'[COMPANY]',
					'[EMAIL]',
					'[LOCATION]',
					'[USERID]',
					'[IP]'
				), array(
					$data['fname'] . ' ' . $data['lname'],
					Registry::get("Core")->site_url,
					Registry::get("Core")->site_name,
					Registry::get("Core")->company,
					$data['username'],
					'Vancouver, British Columbia',
					$last_id,
					$_SERVER['REMOTE_ADDR']
				), $templateAdmin);
				$mailerAdmin = Mailer::sendMail();


				$messageAdmin = Swift_Message::newInstance()
				->setSubject('New User Registration ' . Registry::get("Core")->company)
				->setTo(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
				->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
				->setBody($templateAdmin, 'text/html');
				$mailerAdmin->send($messageAdmin);

			}
			
			
			
			

			if (self::$db->affected()) {
				$this->login($_POST['email'], $_POST['pass']);

				if ($_SESSION['pageurl'] == 'shipping') {
					$url = "cart";
				}
				else {
					$url = "profile";
				}

				header("Location: ../" . $url);
				
				//header("Location: ../profile");

			}
			else {
				$json['message'] = Filter::msgAlert(Lang::$word->_UA_PASSR_ERR, false);
				$_SESSION['registererror'] = Filter::msgAlert(Lang::$word->_UA_PASSR_ERR, false);
				header("Location: ../register");
			}
		}
		else {
			$json['message'] = Filter::msgStatusSimple();

			// print json_encode($json);

			$_SESSION['registererror'] = Filter::msgStatusSimple();
			header("Location: ../register");
		}
	}


	/**
	 * User::passResetWithEmail()
	 *
	 * @return
	 */
	public function passResetWithEmail() {

		$_SESSION['reset_email'] = $_POST['reset_email'];

		// Check if email exists

		if (!$this->emailExists($_POST['reset_email'])) {
			Filter::$msgs['email'] = 'No account was found for that Email address.';
			$_SESSION['resetstatus'] = Filter::msgStatusSimple();
			header("Location: ../forgot-password");
		}

		// If no errors

		if (empty(Filter::$msgs)) {
			$user = $this->getUserInfo($_POST['reset_email']);

			$key = $this->generateKey($_POST['reset_email']);
			$data = array(
				'password_reset_key' => $key,
				'password_reset_confirmed' => 'y',
				'password_reset_timestamp' => date('Y-m-d H:i:s')
			);
			self::$db->update(self::uTable, $data, "username = '" . $user->username . "'");

			require_once (BASEPATH . "lib/class_mailer.php");

			$link = Registry::get("Core")->site_url . Registry::get("Core")->site_dir . "/reset-password?k=" . $key;

			$template = file_get_contents('../templates_email/email_resetpassword.html');
			$template = str_replace(array(
				'[NAME]',
				'[COMPANY]',
				'[SITEURL]',
				'[LINK]'
			), array(
				$user->fname,
				Registry::get("Core")->company,
				SITEURL,
				$link
			), $template);

			$template = cleanOut($template);
			$mailer = Mailer::sendMail();


			$message = Swift_Message::newInstance()
						->setSubject('Your ' . Registry::get("Core")->company . ' password')
						->setTo(array($user->username => $user->fname))
						->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
						->setBody($template, 'text/html');

			if (self::$db->affected() && $mailer->send($message)) {
				$_SESSION['resetstatus'] = Filter::msgOkSimple(Lang::$word->_UA_PASSR_OK, false);
			}
			else {
				Filter::$msgs['email'] = Lang::$word->_UA_PASSR_ERR;
				$_SESSION['resetstatus'] = Filter::msgStatusSimple();
			}

			header("Location: ../forgot-password");
		}
		else {
			$_SESSION['resetstatus'] = Filter::msgStatusSimple();
			header("Location: ../forgot-password");
		}
	}



	/**
	 * User::confirmEmail()
	 * Check if email key is valid.
	 * @param $key Key to be validated.
	 * @return  boolean TRUE if key is valid, FALSE otherwise
	 */
	public function confirmEmail($key) {

		// since it is md5 hash, it has to be 32 characters long

		if (strlen($key) != 32) {
			$_SESSION['confirmstatus'] = 'Email verification key is invalid.';
			return FALSE;
		}

		$sql = "SELECT * FROM " . self::uTable . " WHERE hash = '" . $key . "'";
		$result = self::$db->fetch_all($sql);
		
		// if key doesn't exist in db or it somehow exists more than once, it is not valid key
		if (count($result) !== 1) {
			$_SESSION['confirmstatus'] = 'Email verification key is invalid or expired.';
			return FALSE;
		}
		
		$row = $result[0];
		
		// Update database
		$data = array(
			'active' => 'y',
			'hash' => null
		);
		self::$db->update(self::uTable, $data, "username = '" . $row->username . "'");
		
		
		// Send user welcome email
		/* commented out for duplicate emails sent to users already signed up
		require_once (BASEPATH . "lib/class_mailer.php");
		
		$template = file_get_contents(Registry::get("Core")->site_url . '/templates_email/email_welcome.html');
		$subject = 'Welcome to ' . Registry::get("Core")->company;
		
		$template = str_replace(array(
			'[SITEURL]',
			'[SITE_NAME]',
			'[COMPANY]',
			'[EMAIL]',
			'[LOCATION]'
		), array(
			Registry::get("Core")->site_url,
			Registry::get("Core")->site_name,
			Registry::get("Core")->company,
			$row->username,
			'Vancouver, British Columbia'
		), $template);
		
		$mailer = Mailer::sendMail();
		$message = Swift_Message::newInstance()
		->setSubject($subject)
		->setTo(array($row->username => $row->fname))
		->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
		->setBody($template, 'text/html');
		$mailer->send($message);
		*/
		
		
		
		return ($row) ? $row : 0;
	}
	
	/**
	 * Users::generateKey()
	 * Generate key used for confirmation and password reset.
	 * @return string Generated key.
	 */
	public function generateKey($email) {
		return md5(time() . PASSWORD_SALT . $email);
	}


	/**
	 * User::prKeyValid()
	 * Check if password reset key is valid.
	 * @param $key Key to be validated.
	 * @return  boolean TRUE if key is valid, FALSE otherwise
	 */
	public function prKeyValid($key) {

		// since it is md5 hash, it has to be 32 characters long

		if (strlen($key) != 32) {
			$_SESSION['resetstatus'] = 'Password reset key is invalid.';
			return FALSE;
		}

		$sql = "SELECT id, password_reset_key, password_reset_confirmed, password_reset_timestamp FROM " . self::uTable . " WHERE password_reset_key = '" . $key . "'";
		$result = self::$db->fetch_all($sql);

		// if key doesn't exist in db or it somehow exists more than once, it is not valid key

		if (count($result) !== 1) {
			$_SESSION['resetstatus'] = 'Password reset key is invalid or expired.';
			return FALSE;
		}

		$result = $result[0];

		// check if key is already used

		if ($result->password_reset_confirmed == 'n') {
			$_SESSION['resetstatus'] = 'Password has already been reset.';
			return FALSE;
		}

		// check if key is expired

		$now = date('Y-m-d H:i:s');
		$requestedAt = $result->password_reset_timestamp;
		$expires = strtotime($now . ' - 60 minutes');
		$requested = strtotime($requestedAt);
		if ($expires > $requested) {
			$_SESSION['resetstatus'] = 'Password reset key is expired.';
			return FALSE;
		}

		return TRUE;
	}
	



	/**
	 * User::createNewPass()
	 */
	public function createNewPass() {
		Filter::checkPost('new_password', Lang::$word->PASSWORD);
		$newpass = $_POST['new_password'];
		$confirmpass = $_POST['confirm_password'];
		$passwordResetKey = $_POST['password_ResetKey'];
		if (strlen($newpass) < 6) {
			Filter::$msgs['pass'] = Lang::$word->PASSWORD_T2;
			$_SESSION['resetstatus'] = Filter::msgStatus();
			header("Location: ../reset-password?k=" . $passwordResetKey);
		}
//		elseif ($newpass != $confirmpass) {
//			Filter::$msgs['pass'] = 'Passwords must match.';
//			$_SESSION['resetstatus'] = Filter::msgStatus();
//			header("Location: ../reset-password?k=" . $passwordResetKey);
//		}
		elseif (!$this->prKeyValid($passwordResetKey)) {
			Filter::$msgs['pass'] = 'Invalid password reset key.';
			$_SESSION['resetstatus'] = Filter::msgStatus();
			header("Location: ../reset-password?k=" . $passwordResetKey);
		}
		else {
			$sql = "SELECT username, password_reset_key FROM " . self::uTable . " WHERE password_reset_key = '" . $passwordResetKey . "'";
			$row = self::$db->first($sql);
			$data = array(
				'password' => sha1($newpass),
				'password_reset_confirmed' => 'n',
				'password_reset_key' => '',
				'password_reset_timestamp' => '0000-00-00 00:00:00'
			);
			self::$db->update(self::uTable, $data, "username = '" . $row->username . "'");
			if (self::$db->affected()) {
				$row = $this->getUserInfo($row->username);
				$this->uid = $_SESSION['userid'] = $row->id;
				$this->username = $_SESSION['USERNAME_US'] = $row->username;
				$this->name = $_SESSION['name'] = $row->fname . ' ' . $row->lname;
				$this->userlevel = $_SESSION['userlevel'] = $row->userlevel;
				$this->avatar = $_SESSION['avatar'] = $row->avatar;
				$this->lastlogin = $_SESSION['last'] = $row->lastlogin;
				$_SESSION['resetstatus'] = 'reset';
				header("Location: ../profile");
			}
			else {
				$_SESSION['resetstatus'] = 'Could not update password. Please contact our support team at <a href="mailto:' . Registry::get("Core")->support_email .'">'. Registry::get("Core")->support_email .'</a>';
				header("Location: ../reset-password?k=" . $passwordResetKey);
			}
		}
	}

	/**
	 * Users::getUserList()
	 *
	 * @return
	 */
	public function getUserList() {
		$sql = "SELECT id, username, CONCAT(fname,' ',lname) as name FROM " . self::uTable . "\n WHERE active = 'y'";
		$row = self::$db->fetch_all($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Users::getUserData()
	 *
	 * @return
	 */
	public function getUserData() {
		$sql = "SELECT * FROM " . self::uTable . "\n WHERE id = '" . $this->uid . "'";
		$row = self::$db->first($sql);
		return ($row) ? $row : 0;
	}

	/**
	 * Users::usernameExists()
	 *
	 * @param mixed $username
	 * @return
	 */
	private function usernameExists($username) {
		$username = sanitize($username);
		if (strlen(self::$db->escape($username)) < 4) return 1;

		// Username should contain only alphabets, numbers, underscores or hyphens.Should be between 4 to 15 characters long

		$valid_uname = "/^[a-zA-Z0-9_-]{4,15}$/";
		if (!preg_match($valid_uname, $username)) return 2;
		$sql = self::$db->query("SELECT username" . " FROM " . self::uTable . "\n WHERE username = '" . $username . "'" . "\n LIMIT 1");
		$count = self::$db->numrows($sql);
		return ($count > 0) ? 3 : false;
	}

	/**
	 * User::emailExists()
	 *
	 * @param mixed $email
	 * @return
	 */
	private function emailExists($email) {
		$sql = self::$db->query("SELECT username FROM " . self::uTable . " WHERE username = '" . sanitize($email) . "' LIMIT 1");
		if (self::$db->numrows($sql) == 1) {
			return true;
		}
		else return false;
	}

	/**
	 * User::isValidEmail()
	 *
	 * @param mixed $email
	 * @return
	 */
	private function isValidEmail($email) {
		if (function_exists('filter_var')) {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return true;
			}
			else return false;
		}
		else return preg_match('/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', $email);
	}

	/**
	 * User::confirmCookie()
	 *
	 * @param mixed $username
	 * @param mixed $cookie_id
	 * @return
	 */
	private function confirmCookie($username, $cookie_id) {
		$sql = "SELECT cookie_id FROM " . self::uTable . " WHERE username = '" . self::$db->escape($username) . "'";
		$row = self::$db->first($sql);
		$row->cookie_id = sanitize($row->cookie_id);
		$cookie_id = sanitize($cookie_id);
		if ($cookie_id == $row->cookie_id) {
			return true;
		}
		else return false;
	}

	/**
	 * Users::getUniqueCode()
	 *
	 * @param string $length
	 * @return
	 */
	private function getUniqueCode($length = "") {
		$code = sha1(uniqid(rand(), true));
		if ($length != "") {
			return substr($code, 0, $length);
		}
		else return $code;
	}

	/**
	 * Users::generateRandID()
	 *
	 * @return
	 */
	private function generateRandID() {
		return sha1($this->getUniqueCode(24));
	}

	/**
	 * Users::levelCheck()
	 *
	 * @param string $levels
	 * @return
	 */
	public function levelCheck($levels) {
		$m_arr = explode(",", $levels);
		reset($m_arr);
		if ($this->logged_in and in_array($this->userlevel, $m_arr)) return true;
	}

	/**
	 * Users::getUserLevels()
	 *
	 * @return
	 */
	public function getUserLevels($level = false) {
		$arr = array(
			9 => 'Super Admin',
			1 => 'Registered User',
			2 => 'User Level 2',
			3 => 'User Level 3',
			4 => 'User Level 4',
			5 => 'User Level 5',
			6 => 'User Level 6',
			7 => 'User Level 7'
		);
		$list = '';
		foreach($arr as $key => $val) {
			if ($key == $level) {
				$list.= "<option selected=\"selected\" value=\"$key\">$val</option>\n";
			}
			else $list.= "<option value=\"$key\">$val</option>\n";
		}

		unset($val);
		return $list;
	}
	
	
	public function stripHttp($url) {
		//Get domain name without http, https, wwww
		$plainUrl = implode(array_slice(explode('/', preg_replace('/https?:\/\/(www\.)?/', '', $url)), 0, 1));

		return $plainUrl;
	}


}

?>
