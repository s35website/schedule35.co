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
	
	
	
	$fromdate = date("Y-m-d H:i:s", strtotime("-4 month"));
	$statusDisplay = "All Invoices";
	
	if (isset($_GET['status'])) {
	
		$status = $_GET['status'];
		$status = number_format((float)$status, 1, '.', '');
		
		$inrow = $item->getInvoices($fromdate, $status);
	
		// Shipped
		if ($_GET['status'] == 5) {
			$statusDisplay = "All Invoices";
			$_SESSION['invoiceSession'] = 5;
			$inrow = $item->getInvoices($fromdate, null);
		}
		// Shipped
		elseif ($_GET['status'] == 4) {
			$statusDisplay = "Error Invoice";
			$_SESSION['invoiceSession'] = 4;
		}
		// Shipped
		elseif ($_GET['status'] == 3) {
			$statusDisplay = "Shipped Invoice";
			$_SESSION['invoiceSession'] = 3;
		}
		// Packaged
		elseif ($_GET['status'] == 2) {
			$statusDisplay = "Packaged Invoice";
			$_SESSION['invoiceSession'] = 2;
		}
		// Labelled
		elseif ($_GET['status'] == 1.5) {
			$statusDisplay = "Labelled Invoice";
			$_SESSION['invoiceSession'] = 1.5;
		}
		// Exported
		elseif ($_GET['status'] == 1.2) {
			$statusDisplay = "Exported Invoice";
			$_SESSION['invoiceSession'] = 1.2;
		}
		// Paid
		elseif ($_GET['status'] == 1) {
			$statusDisplay = "Paid Invoice";
			$_SESSION['invoiceSession'] = 1;
		}
		// Waiting
		elseif ($_GET['status'] == 0) {
			$statusDisplay = "Unpaid Invoice";
			$_SESSION['invoiceSession'] = 0;
		}
	}elseif (!isset($_SESSION['invoiceSession'])) {
		$statusDisplay = "All Invoices";
		$_SESSION['invoiceSession'] = 5;
		$inrow = $item->getInvoices($fromdate, null);
	}
	
	
	if (is_dir("../setup"))
		: die("<div style='text-align:center'>" 
			. "<span style='padding: 5px; border: 1px solid #999; background-color:#EFEFEF;" 
			. "font-family: Verdana; font-size: 11px; margin-left:auto; margin-right:auto'>" 
			. "<b>Warning:</b> Please delete setup directory!</div>");
	endif;
	
	if ($_GET['checkuser'] == "yes"){
		$_SESSION["editurl"] = $_GET['id'];
	}
	
	if (!$user->logged_in) {
		redirect_to("login");
	}elseif (!$user->hasAdminAccess()) {
		$_SESSION["isAdmin"] = '<ul class="error list"><li><i class="fa fa-exclamation-triangle"></i>Oops! Looks like you do not have permission to access this part of the website.</li>
		</ul>';
		redirect_to("login");
	}
	elseif ($_SESSION["editurl"]) {
		$editurl = $_SESSION["editurl"];
		unset($_SESSION['editurl']);
		header("Location: ../admin/index.php?do=users&action=edit&id=" . $editurl);
	}
  
?>

<?php $trans_limit = '5'; ?>
<?php $page = Filter::$do;?>
<?php $action = Filter::$action;?>

<?php require_once('components/stats.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include("components/header.php");?>
</head>

<body>
	<!-- Start Page Loading -->
	<div class="loading"><img src="assets/img/loading.gif" alt="loading-img"></div>
	<!-- End Page Loading -->
	
	<!-- START TOP -->
	<?php include("components/topbar.php"); ?>
	<!-- END TOP -->
	
	<!-- START SIDEBAR -->
	<?php include("components/sidebar.php"); ?>
	<!-- END SIDEBAR -->

	<!-- START CONTENT -->
	<?php (Filter::$do && file_exists(Filter::$do.".php")) ? include(Filter::$do.".php") : include("dashboard.php");?>
	<!-- End Content -->

</body>

</html>