<?php
	/**
	* Login
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: login.php, v3.00 2014-06-05 10:12:05 gewa Exp $
	*/
	define( "_VALID_PHP", true);
	require_once( "init.php");
	
	if ($user->is_Ambassador()) {
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
<html lang="en-US" dir="ltr">

 <head>
 	<?php include( "components/header.php"); ?>
 	<style>
 		#error-box {
 		    width: 100%;
 		    display: block;
 		}
 		#error-box ul,
 		#error-box .message-wrapper.error {
 		    list-style: none;
 		    margin-bottom: 18px;
 		    padding: 18px 24px;
 		    background: #FED7D8;
 		    color: #e74c3c;
 		}
 		#error-box li,
 		#error-box p:last-of-type {
 		    margin: 0;
 		}
 		#error-box li i {
 		    margin-right: 8px;
 		    display: none;
 		}
 	</style>
 </head>


<body>

	<!-- ===============================================-->
	<!--    Main Content-->
	<!-- ===============================================-->
	<main class="main" id="top">
	

		<div class="container">
			<div class="row flex-center min-vh-100 py-6">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
					
					<a class="text-center mb-4 d-block" href="<?php echo AMBASSURL; ?>">
						<img src="<?php echo UPLOADURL; ?>logo-alt-black.svg" alt="<?php echo $core->site_name; ?>" class="logo" style="width: 60px;opacity: 0.7;">
						<!--<span class="font-weight-extra-bold fs-5 d-block">Ambassador Program</span>-->
					</a>
					
					<div id="error-box" class="error-box">
						<?php print Filter::$showMsg;?>
						<?php echo $_SESSION["isAdmin"]; ?>
						<?php session_unset(); ?>
					</div>
					
					<div class="card">
						<div class="card-body p-5">
							<div class="row text-left justify-content-between">
								<div class="col-auto">
									<h5 class="mb-3"> Log in</h5>
								</div>
							</div>
							<form id="admin_form" name="admin_form" method="post" class="xform">
								<div class="form-group">
									<input class="form-control" type="email" name="email" placeholder="Email address" />
								</div>
								<div class="form-group">
									<input class="form-control" type="password" name="password" placeholder="Password" />
								</div>
								<div class="row justify-content-between">
									<div class="col-auto">
										<div class="custom-control custom-checkbox">
											<input class="custom-control-input" id="customCheckRemember" type="checkbox" />
											<label class="custom-control-label" for="customCheckRemember">Remember me</label>
										</div>
									</div>
									<div class="col-auto"><a class="fs--1" href="<?php echo $core->site_url; ?>/forgot-password">Forget Password?</a></div>
								</div>
								<div class="form-group">
									<button class="btn btn-primary btn-block mt-4" type="submit" name="submit">Log in</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<!-- ===============================================-->
	<!--    End of Main Content-->
	<!-- ===============================================-->
	
	
	
	
	<!-- ===============================================-->
	<!--    JavaScripts-->
	<!-- ===============================================-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/lib/stickyfilljs/stickyfill.min.js"></script>
	<script src="assets/lib/sticky-kit/sticky-kit.min.js"></script>
	<script src="assets/lib/is_js/is.min.js"></script>
	<script src="assets/lib/@fortawesome/all.min.js"></script>
	<script src="assets/js/theme.js"></script>

</body>

</html>