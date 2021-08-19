<?php
	/**
	* Main
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	*/
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
		
	if (!$user->is_Admin() && !$user->is_Manager()) {
		$_SESSION["isAdmin"] = '<ul class="error list"><li><i class="fa fa-exclamation-triangle"></i>Oops! Looks like you do not have permission to access this part of the website.</li>
		</ul>';
		redirect_to("index");
	}
	
	
	
	
	
	$dateRangeStr = date("m/d/Y", strtotime("-6 months")) . ' - ' . date("m/d/Y", time());
	
	if ($_GET['date']) {
		$dates = explode('-', $_GET['date']);
		$dateRangeStr = implode(" - ", $dates);
		$startDate = date("Y-m-d", strtotime($dates[0]));
		$endDate = date("Y-m-d", strtotime($dates[1]));
	}
	else {
		$dateRangeStr = '';
	}
	
	$search = '';
	
	if ($_GET['search']) {
		$search = urldecode($_GET['search']);
	}
	
	$invoiceStatuses = array(
		'4' => 'Error',
		'3' => 'Shipped',
		'2' => 'Packaged',
		'1.5' => 'Label Printed',
		'1.2' => 'Exported',
		'1' => 'Paid',
		'0' => 'Unpaid'
	);
	
	$status = '';
	
	if (isset($_GET['status'])) {
		$status = $_GET['status'];
	}
	
	
?>

<?php switch(Filter::$action): case "edit": ?>
<?php include("invoices/edit.php");?>
<?php break;?>

<?php case"add": ?>
<?php include("invoices/add.php");?>
<?php break;?>

<?php case"table": ?>
<?php include("invoices/table.php");?>
<?php break;?>

<?php case"tracking": ?>
<?php include("invoices/tracking.php");?>
<?php break;?>

<?php default: ?>
<?php include("invoices/default-a.php");?>
<?php break;?>

<?php endswitch;?>
