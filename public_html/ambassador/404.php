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
?>

<!DOCTYPE html>

<html lang="en-US" dir="ltr">

<head>
	<?php include( "components/header.php"); ?>
</head>


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">


      <div class="container">
        <div class="row flex-center text-center min-vh-100">
		  
          <div class="col-sm-11 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
		  	<a class="text-center mb-4 d-block" href="<?php echo AMBASSURL; ?>">
		  		<img src="<?php echo UPLOADURL; ?>logo-alt-black.svg" alt="<?php echo $core->site_name; ?>" class="logo" style="width: 60px;opacity: 0.7;">
		  		<!--<span class="font-weight-extra-bold fs-5 d-block">Ambassador Program</span>-->
		  	</a>
		  	
		  	
            <div class="card">
              <div class="card-body p-5">
                <div class="display-1 text-200 fs-error">404</div>
                <p class="lead mt-4 text-800 text-sans-serif font-weight-semi-bold">The page you're looking for is not found.</p>
                <hr />
                <p>Make sure the address is correct and that the page hasn't moved. If you think this is a mistake, <a href="mailto:<?php echo $core->support_email;?>">contact us</a>.</p><a class="btn btn-primary btn-sm mt-3" href="<?php echo AMBASSURL; ?>"><span class="fas fa-home mr-2"></span>Take me home</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->



  </body>

</html>