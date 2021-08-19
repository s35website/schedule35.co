<?php
	/**
	* Header
	*
	* @package CMS Pro
	* @author buudabomb.com
	* @copyright 2014
	* @version $Id: header.tpl.php, v4.00 2014-04-20 10:12:05 gewa Exp $
	*/
	
	if (!defined("_VALID_PHP"))
	  die('Direct access to this location is not allowed.');
	
	$menu = $content->getMenu();
	$urow = $user->getUserData();
	
	ini_set('display_errors', '0');     # don't show any errors...
	error_reporting(E_ALL | E_STRICT);  # ...but do log them
	
	$notification = 0;
	
	
	
	if(isset($_GET['amb'])) {
		$ambassador_code = sanitize($_GET['amb'],100);
		$_SESSION["ambcode"] = $ambassador_code;
		
	}elseif (isset($_SESSION["ambcode"])) {
		$ambassador_code = $_SESSION["ambcode"];
	}
	else {
		$ambassador_code = null;
	}
	
	if ($ambassador_code) {
		$ambassador_discount = $content->getAmbassadorDiscount();
	}else {
		$ambassador_discount = null;
	}
	
	if ($ambassador_discount > 0) {
		$ambinfo = $db->first("SELECT fname, lname FROM " . Users::uTable . " WHERE invite_code = '" . $ambassador_code . "'");
		$ambassador_name = $ambinfo->fname . " " . $ambinfo->lname;
		
		if(isset($_GET['amb'])) {
			$_SESSION["ambmodal"] = 1;
		}
		
	}
	
?>

<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php if(isset($pagename) && $pagename):?>
	<title><?php echo($pagename); ?> - <?php echo $core->company; ?></title>
	<?php else:?>
	<title><?php echo $core->company; ?></title>
	<?php endif;?>
	<meta name="description" content="<?php echo $core->metadesc; ?>" />
	<meta name="keywords" content="<?php echo $core->metakeys; ?>" />



	<link rel="canonical" href="<?php echo SITEURL; ?>" />
	<link rel="icon" type="image/png" href="<?php echo SITEURL; ?>/assets/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="<?php echo SITEURL; ?>/assets/favicon-32x32.png" sizes="32x32" />
	
	<link href="https://fonts.googleapis.com/css?family=Oswald:400,500,700|Roboto+Mono:400,400i" rel="stylesheet">

	<link rel="stylesheet" media="screen" href="<?php echo THEMEURL;?>/assets/css/styles.css?rs=<?php echo(date("Ymd")); ?>v17" />

	<!-- For print -->
	<link rel="stylesheet" media="print" href="<?php echo THEMEURL;?>/assets/css/print.css?r=<?php echo(date("Ymd")); ?>" />

	<script type="text/javascript">
		var SITEURL = "<?php echo SITEURL; ?>";
		/* == Ambassador code == */
		var ambcode = "<?php echo($ambassador_code); ?>";
		var ambdiscount = "<?php echo($ambassador_discount); ?>";
		
	</script>

	<?php if($core->analytics):?>
	<!-- Google Analytics -->
	<?php echo cleanOut($core->analytics);?>
	<!-- Google Analytics /-->
	<?php endif;?>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	
	<script type="text/javascript">
	    window._mfq = window._mfq || [];
	    (function() {
	        var mf = document.createElement("script");
	        mf.type = "text/javascript"; mf.async = true;
	        mf.src = "//cdn.mouseflow.com/projects/982b0d26-5c28-4211-ba03-a9a2d64739e3.js";
	        document.getElementsByTagName("head")[0].appendChild(mf);
	    })();
	</script>
</head>
