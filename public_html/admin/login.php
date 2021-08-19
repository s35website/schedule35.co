<?php
	/**
	* Login
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: login.php, v3.00 2014-06-05 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");
?>
<?php
	if ($user->hasAdminAccess()) {
		redirect_to("index");
	}
	
	if (isset($_POST['submit'])) {
		$result = $user->login($_POST['email'], $_POST['password']);
		
		//Login successful 
		if ($result) {
			redirect_to("index");
		}
	}
	
?>
<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<title>
		Admin | <?php echo $core->company;?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:400,100,300,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/login.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../assets/jquery.js"></script>
	<link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico" />
	<link rel="icon" type="image/png" href="../assets/img/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="../assets/img/favicon-32x32.png" sizes="32x32" />
</head>

<body>
	<div class="container">
		<form id="admin_form" name="admin_form" method="post" class="xform">
			<header>
				<?php if ($core->logo):?>
				<div>
					<a href="<?php echo SITEURL; ?>" class="logo">
						<img src="<?php echo UPLOADURL; ?>logo-alt-black.svg" alt="<?php echo $core->site_name; ?>" class="logo">
					</a>
				</div>
				<?php endif;?>
				Please sign in
			</header>
			<div id="error-box" class="error-box">
				<?php print Filter::$showMsg;?>
				<?php echo $_SESSION["isAdmin"]; ?>
				<?php session_unset(); ?>
			</div>
			<div class="row">
				<input type="text" placeholder="<?php echo Lang::$word->EMAIL;?>" name="email">
				<input type="password" placeholder="<?php echo Lang::$word->PASSWORD;?>" name="password">
			</div>
			<input type="submit" name="submit" value="Sign in">
			<footer> 
				&copy; <?php echo date('Y') . ' ' . $core->site_name . ' v' . $core->version;?>
			</footer>
		</form>
	</div>
</body>
</html>