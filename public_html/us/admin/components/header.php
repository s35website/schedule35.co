<?php
  /**
   * Header
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2014
   * @version $Id: header.php, v3.00 2014-07-10 10:12:05 gewa Exp $
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php if (!$page) {
	$page = "dashboard";
} ?>
<title><?php echo(ucwords($page)); ?> <?php echo(ucwords($action)); ?> | <?php echo $core->site_name;?></title>

<meta name="description" content="FBC Studio admin panel">
<meta name="keywords" content="fbc studio, commerce, dashboard, admin" />

<!-- ========== Css Files ========== -->
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' media="screen" rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,600,700,800,300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">


<link href="assets/css/root.css?v=<?php echo(date("Ymd")); ?>1" rel="stylesheet">
<link href="assets/css/animate.css" rel="stylesheet">



<link href="assets/css/style.css?v=<?php echo(date("Ymd")); ?>1" rel="stylesheet">
<link href="assets/css/responsive.css?v=1" rel="stylesheet">
<link href="assets/css/shortcuts.css" rel="stylesheet">

<link rel="apple-touch-icon" sizes="57x57" href="<?php echo SITEURL; ?>/assets/img/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo SITEURL; ?>/assets/img/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo SITEURL; ?>/assets/img/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo SITEURL; ?>/assets/img/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo SITEURL; ?>/assets/img/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo SITEURL; ?>/assets/img/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo SITEURL; ?>/assets/img/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo SITEURL; ?>/assets/img/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo SITEURL; ?>/assets/img/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo SITEURL; ?>/assets/img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo SITEURL; ?>/assets/img/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo SITEURL; ?>/assets/img/favicon-16x16.png">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo SITEURL; ?>/assets/img/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">