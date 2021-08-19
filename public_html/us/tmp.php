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
        
        /* == User details == */
//	$user_id = $user->uid;
//	$sesid = $user->sesid;
//        $cartrow = $content->getCartContent($username);
//        print_r( $cartrow );
        $prd_var = $item->getProductVariants( 2, 31 );
        $var_name = $prd_var[0]->title;
        echo 'Price : ' . $var_name;
        print_r( $prd_var );
        
?>

<?php require_once ("shop.php");?>
