<?php
	/**
	 * User
	 *
	 * @package FBC Studio
	 * @author fbcstudio.com
	 * @copyright 2010
	 * @version $Id: user.php, v2.00 2011-04-20 10:12:05 gewa Exp $
	 */
	define("_VALID_PHP", true);
	require_once("../init.php");
?>
<?php

/* Registration */
if (isset($_POST['doRegisterSimple'])):
	$user->registerSimple();
endif;

/* Password Reset */
if (isset($_POST['passResetWithEmail'])):
	$user->passResetWithEmail();
endif;


/* If password reset is valid create new password */
if (isset($_POST['createNewPass'])):
    $user->createNewPass();
endif;


/* Account Activation */
if (isset($_POST['accActivate'])):
	$user->activateUser();
endif;


/* Update Name */
if (isset($_POST['updateName'])):
	$user->updateName();
endif;

/* Update Email */
if (isset($_POST['updateEmail'])):
	$user->updateEmail();
endif;

/* Update Password */
if (isset($_POST['updatePassword'])):
	$user->updatePassword();
endif;

/* Update Thumbnail */
if (isset($_FILES["thumb"]["type"])):
	$user->updateThumb();
endif;


/* Update Shipping */
if (isset($_POST['updateShipping'])):
	$user->updateShipping();
endif;

/* Update Notifications */
if (isset($_POST['updateNotifications'])):
	$user->updateNotifications();
endif;

/* Update Newsletter */
if (isset($_POST['updateNewsletterFlag'])):
	$user->updateNewsletterFlag();
endif;



/* Check Invite code */
if (isset($_POST['inviteCode']) and !empty($_POST['inviteCode'])) {

	$inviteCode = sanitize($_POST['inviteCode']);

	if ($inviteCode) {


		$row = $db->first("SELECT * FROM " . Users::uTable . " WHERE invite_code = '" . $inviteCode . "'");

		$userInviteCode = $row->invite_code;

		$row2 = $db->first("SELECT used, maxusage, code, validuntil FROM " . Content::invTable . " WHERE code = '" . $db->escape($inviteCode) . "' AND active = '1'");

		$today = date("Y-m-d=");

		// Check to see if using user coupon
		if ($row) {
			if ($row->invites > 0) {
				$json['type'] = "success";
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: '" . Lang::$word->INVITE_SUCC1 . "', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'success'}; new jBox('Notice', options); </script>";
			}else {
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: '" . Lang::$word->INVITE_ERROR4 . "', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
			}
		}
		// Check to see if code exists in database
		else {
			// Code doesn't exist in database
			if (!$row2) {
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: '" . Lang::$word->INVITE_ERROR1 . "', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
			}
			// Check to see if code has expired
			elseif ($row2->validuntil < $today) {
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: '" . Lang::$word->INVITE_ERROR2 . "', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
			}
			// Check to see if coupon has already been used
			elseif ($row2->used >= $row2->maxusage && $row2->maxusage != NULL && $row2->maxusage != 0) {
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: '" . Lang::$word->INVITE_ERROR3 . "', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
			}
			else {
				$json['type'] = "success";
				$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: '" . Lang::$word->INVITE_SUCC1 . "', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'success'}; new jBox('Notice', options); </script>";
			}
		}


	}
	else {
		$json['message'] = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'An error occurred while processing your discount code.', autoClose: 3400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
	}

	print json_encode($json);
}


/* Update Profile Settings (Ambassador Panel) */
if (isset($_POST['updateProfileSettings'])):
	$user->updateProfileSettings();
endif;
if (isset($_POST['updateShippingAddress'])):
	$user->updateShippingAddress();
endif;

if (isset($_POST['updateNotes'])):
	$user->updateNotes();
endif;

if (isset($_POST['updatePayout'])):
	$user->updatePayout();
endif;

?>
