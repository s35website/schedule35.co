<?php
  /**
   * Maintenance
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2014
   * @version $Id: index.php, v3.00 2014-04-20 10:12:05 gewa Exp $
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
	  if($core->offline == 0)
	     redirect_to(SITEURL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Back Soon...</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo SITEURL;?>/assets/uc/css/bootstrap.min.css">
	
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
	
	<link rel="stylesheet" type="text/css" href="<?php echo SITEURL;?>/assets/uc/css/animate/animate.css">
	
	<link rel="stylesheet" type="text/css" href="<?php echo SITEURL;?>/assets/uc/css/select2.min.css">
	
	<link rel="stylesheet" type="text/css" href="<?php echo SITEURL;?>/assets/uc/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITEURL;?>/assets/uc/css/main.css?v=4">

</head>
<body>
<div class="bg-2 size1 flex-w flex-col-c-sb p-l-15 p-r-15 p-t-55 p-b-35 respon1" style="background: #222;">
	
	<div class="flex-col-c p-t-50 p-b-50" style="max-width: 680px;">
		<span class="logo">
			<img src="<?php echo SITEURL;?>/assets/img/logo-white.png?v=2" />
		</span>
		
		<h3 class="l1-txt1 txt-center p-b-10">
		We'll be up soon.
		</h3>
		<p class="txt-center l1-txt2 p-b-60">
		While our website is under maintenance you can follow us for updates on Instagram.
		</p>
	
		
		<!--<a class="flex-c-m s1-txt2 size3 how-btn" target="_blank" href="https://www.instagram.com/schedule.35/">
		Follow us for update now!
		</a>-->
	</div>
	<span class="s1-txt3 txt-center">
	@ 2020 Schedule35.com
	</span>
</div>

<div class="modal fade" id="subscribe" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document" data-dismiss="modal">
		<div class="modal-subscribe where1-parent bg0 bor2 size4 p-t-54 p-b-100 p-l-15 p-r-15">
				<button class="btn-close-modal how-btn2 fs-26 where1 trans-04">
						<i class="zmdi zmdi-close"></i>
				</button>
				<div class="wsize1 m-lr-auto">
						<h3 class="m1-txt1 txt-center p-b-36">
							<span class="bor1 p-b-6">Subscribe</span>
						</h3>
						<p class="m1-txt2 txt-center p-b-40">
						Follow us for update now!
						</p>
	
						<form class="contact100-form validate-form">
							<div class="wrap-input100 m-b-10 validate-input" data-validate="Name is required">
								<input class="s1-txt4 placeholder0 input100" type="text" name="name" placeholder="Name">
								<span class="focus-input100"></span>
							</div>
							<div class="wrap-input100 m-b-20 validate-input" data-validate="Email is required: ex@abc.xyz">
								<input class="s1-txt4 placeholder0 input100" type="text" name="email" placeholder="Email">
								<span class="focus-input100"></span>
							</div>
							<div class="w-full">
								<a class="flex-c-m s1-txt2 size5 how-btn1 trans-04" href="https://www.instagram.com/schedule_35/">
									Get Updates
								</a>
							</div>
						</form>
						<p class="s1-txt5 txt-center wsize2 m-lr-auto p-t-20">
							And don’t worry, we hate spam too! You can unsubcribe at anytime.
						</p>
				</div>
		</div>
	</div>
</div>

<script src="vendor/jquery/jquery-3.2.1.min.js" type="41502f68d8c7dc238c75ab5b-text/javascript"></script>

<script src="vendor/bootstrap/js/popper.js" type="41502f68d8c7dc238c75ab5b-text/javascript"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js" type="41502f68d8c7dc238c75ab5b-text/javascript"></script>

<script src="vendor/select2/select2.min.js" type="41502f68d8c7dc238c75ab5b-text/javascript"></script>

<script src="vendor/countdowntime/moment.min.js" type="41502f68d8c7dc238c75ab5b-text/javascript"></script>
<script src="vendor/countdowntime/moment-timezone.min.js" type="41502f68d8c7dc238c75ab5b-text/javascript"></script>
<script src="vendor/countdowntime/moment-timezone-with-data.min.js" type="41502f68d8c7dc238c75ab5b-text/javascript"></script>
<script src="vendor/countdowntime/countdowntime.js" type="41502f68d8c7dc238c75ab5b-text/javascript"></script>
<script type="41502f68d8c7dc238c75ab5b-text/javascript">
		$('.cd100').countdown100({
			// Set Endtime here
			// Endtime must be > current time
			endtimeYear: 0,
			endtimeMonth: 0,
			endtimeDate: 35,
			endtimeHours: 18,
			endtimeMinutes: 0,
			endtimeSeconds: 0,
			timeZone: "" 
			// ex:  timeZone: "America/New_York", can be empty
			// go to " http://momentjs.com/timezone/ " to get timezone
		});
	</script>

<script src="vendor/tilt/tilt.jquery.min.js" type="41502f68d8c7dc238c75ab5b-text/javascript"></script>
<script type="41502f68d8c7dc238c75ab5b-text/javascript">
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>

<script src="js/main.js" type="41502f68d8c7dc238c75ab5b-text/javascript"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13" type="41502f68d8c7dc238c75ab5b-text/javascript"></script>
<script type="41502f68d8c7dc238c75ab5b-text/javascript">
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="41502f68d8c7dc238c75ab5b-|49" defer=""></script></body>
</html>