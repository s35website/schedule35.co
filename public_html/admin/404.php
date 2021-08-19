<?php
	/**
	* Index
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: index.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");
	
	
	if (!$user->hasAdminAccess()) {
		$_SESSION["isAdmin"] = '<ul class="error list"><li><i class="fa fa-exclamation-triangle"></i>Oops! Looks like you do not have permission to access this part of the website.</li>
		</ul>';
		redirect_to("login");
	}
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="The easiest most convenient way to sell your sheet music online.">
	<meta name="keywords" content="freebird notes, sheet music" />
	<title>404 - Page Not Found</title>

	<!-- ========== Css Files ========== -->
	<link href="assets/css/root.css" rel="stylesheet">
	<style type="text/css">
		body {
			background: #F5F5F5;
		}
	</style>
</head>

<body>

	<div class="error-pages">

		<img src="assets/img/404.png" alt="404" class="icon" width="400" height="260">
		<h1>Sorry but we couldn't find this page</h1>
		<h4>It seems that this page doesn't exist or has been removed</h4>
		<form style="display: none;">
			<input type="text" class="form-control" placeholder="Search for Page">
			<i class="fa fa-search"></i>
		</form>

		<div class="bottom-links">
			<a onclick="goBack()" class="btn btn-default">Go Back</a>
			<a href="dashboard" class="btn btn-light">Go Homepage</a>
		</div>
		
		<script>
		function goBack() {
		    window.history.back();
		}
		</script>

</body>

</html>