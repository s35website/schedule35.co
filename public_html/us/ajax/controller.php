<?php
  /**
   * Controller
   *
   * @package FBC Studio
   * @author fbcstudio.com
   * @copyright 2010
   * @version $Id: controller.php, v2.00 2011-07-10 10:12:05 gewa Exp $
   */
  define("_VALID_PHP", true);
  require_once("../init.php");

  if (!$user->logged_in)
      exit;
?>
<?php
  
  
  
	if (isset($_POST['updateNotification'])):
		$udata['newsletter'] = 1;
		$result = $db->update(Users::uTable, $udata, "id='" . Registry::get("Users")->uid . "'");
		
		if ($result):
			$json['type'] = 'success';
			$json['title'] = Lang::$word->SUCCESS;
			$json['message'] = Lang::$word->CMT_UPDATED;
		else:
			$json['type'] = 'warning';
			$json['title'] = Lang::$word->ALERT;
			$json['message'] = Lang::$word->NOPROCCESS;
		endif;
		print json_encode($json);
	endif;

	/* Proccess Gateway */
	if (isset($_POST['loadgateway'])):
	  $row = Core::getRowById(Content::gTable, Filter::$id);
	
	  $form_url = BASEPATH . "gateways/" . $row->dir . "/form.tpl.php";
	  (file_exists($form_url)) ? include ($form_url) : Filter::msgSingleError('You have selected an invalid payment method. Please try again.');
	endif;
	
	/* Get Invoice */
	if (isset($_GET['doInvoice'])):
		$row = Registry::get("Core")->getRowById(Content::inTable, Filter::$id);
		if ($row):
		  $usr = Registry::get("Core")->getRowById(Users::uTable, Registry::get("Users")->uid);
		
		  $title = cleanOut(preg_replace("/[^a-zA-Z0-9\s]/", "", $row->created));
		  ob_start();
		  require_once (THEMEDIR . '/print_pdf.tpl.php');
		  $pdf_html = ob_get_contents();
		  ob_end_clean();
		
		  require_once (BASEPATH . 'lib/mPdf/mpdf.php');
		  $mpdf = new mPDF('utf-8', $core->psize);
		  $mpdf->SetTitle($title);
		  $mpdf->SetAutoFont();
		  $mpdf->WriteHTML($pdf_html);
		  $mpdf->Output($title . ".pdf", "D");
		  exit;
		else:
		  exit;
		endif;
	endif;



	/* Process Referral Email */
	if (isset($_POST['processReferrals'])):

		$invitecode = sanitize($_POST['invitecode']);
		$sender_email = sanitize($_POST['email']);
		$name = sanitize($_POST['name']);
		$mailsubject =  $name . " just invited you to " . $core->site_name . ".";
		$recipients = $_POST['recipients'];
		$recipients_array = explode(",", $recipients);

		if (empty($recipients_array)) {
			header('Location: ../profile?p=referrals');
		}

		foreach($recipients_array as $pemail) {
			if(!filter_var($pemail, FILTER_VALIDATE_EMAIL)){
				$_SESSION['referrals_error'] = 'Email address not valid.';
				header('Location: ../profile?p=referrals');
			}
		}

		require_once(BASEPATH . "lib/class_mailer.php");
		$mailer = Mailer::sendMail();

		$body = file_get_contents('../templates_email/email_invite.html');
		$body = str_replace(array('[SITEURL]', '[SITE_NAME]', '[COMPANY]', '[LOCATION]', '[NAME]', '[EMAIL]', '[INVITECODE]'), array(SITEURL, $core->site_name, $core->company, 'Vancouver, British Columbia', $name, $sender_email, $invitecode), $body);

		$msg = Swift_Message::newInstance()
			->setSubject($mailsubject)
			->setTo($recipients_array)
			->setBcc(array($core->site_email => $core->site_name))
			->setFrom(array($core->site_email => $name . ' via ' . $core->site_name))
			->setBody($body, 'text/html');

		if ($mailer->send($msg)) {
			$json['status'] = 'success';
			$json['message'] = Filter::msgOk(Lang::$word->PLG_CT_OK, false);
			$_SESSION['referrals_success'] = 'success';
			header('Location: ../profile?p=referrals');
			exit;
		} else {
			$json['message'] = Filter::msgAlert(Lang::$word->PLG_CT_ERR, false);
			print json_encode($json);
		}


	endif;




	/* Process Support Email */
	if (isset($_POST['processAskSupport'])):

		$sender_email = sanitize($_POST['email']);
		$name = sanitize($_POST['name']);
		$mailsubject = sanitize($_POST['support-reason']);


		if ($_POST['product-name'] != "") {
			$details = "<b>Product Name:</b> " . $_POST['product-name'] . "<br/>";
		}
		if ($_POST['product-issue'] != "") {
			$details .= "<b>Product Issue:</b> " . $_POST['product-issue'] . "<br/>";
		}

		if ($_POST['skill-level'] != "") {
			$details .= "<b>Skill Level:</b> " . $_POST['skill-level'] . "<br/>";
		}

		$message = $_POST['comment'];

		require_once(BASEPATH . "lib/class_mailer.php");
		$mailer = Mailer::sendMail();

		$body = file_get_contents('../templates_email/notify_support.html');
		$body = str_replace(array('[SITEURL]', '[LOCATION]', '[MAILSUBJECT]', '[EMAIL]', '[NAME]', '[ISSUE]', '[DETAILS]', '[MESSAGE]', '[IP]'), array(SITEURL, 'Vancouver, British Columbia', $mailsubject, $sender_email, $name, $mailsubject, $details, $message, $_SERVER['REMOTE_ADDR']), $body);


		$msg = Swift_Message::newInstance()
			->setSubject($mailsubject)
			->setTo(array ($core->support_email))
			->setFrom(array($core->support_email => $core->site_name . ' Support'))
			->setReplyTo(array($sender_email => $name))
			->setBody($body, 'text/html');


		if ($mailer->send($msg)) {
			$json['status'] = 'success';
			$json['message'] = Filter::msgOk(Lang::$word->PLG_CT_OK, false);
			$_SESSION['supportrequest'] = 'sent';
			header('Location: ../help');
			exit;
		} else {
			$json['message'] = Filter::msgAlert(Lang::$word->PLG_CT_ERR, false);
			print json_encode($json);
			header('Location: ../help');
		exit;
		}


	endif;
	
	
	/* Process Referral Email */
	if (isset($_POST['sendConfirmation'])):

		$sender_email = sanitize($_POST['email']);
		$name = sanitize($_POST['name']);
		$mailsubject =  "Please verify your email address";
		
		$key = Registry::get("Users")->generateKey($_POST['email']);
		$udata['hash'] = $key;
		$db->update(Users::uTable, $udata, "id='" . Registry::get("Users")->uid . "'");
		
		$link = Registry::get("Core")->site_url . "/verify?k=" . $key;
		
		require_once(BASEPATH . "lib/class_mailer.php");
		$mailer = Mailer::sendMail();

		$body = file_get_contents('../templates_email/email_welcome_withverification.html');
		$body = str_replace(array(
			'[SITEURL]',
			'[SITE_NAME]',
			'[COMPANY]',
			'[LOCATION]',
			'[NAME]',
			'[EMAIL]',
			'[LINK]'
		), array(
			SITEURL,
			$core->site_name,
			$core->company,
			'Vancouver, British Columbia',
			$name,
			$sender_email,
			$link
		),$body);

		$msg = Swift_Message::newInstance()
			->setSubject($mailsubject)
			->setTo(array ($sender_email))
			->setFrom(array($core->site_email => $core->site_name))
			->setBody($body, 'text/html');

		if ($mailer->send($msg)) {
			$json['status'] = 'success';
			$json['message'] = Filter::msgOk(Lang::$word->PLG_CT_OK, false);
			$_SESSION['confirmation_success'] = 'success';
			header('Location: ../profile?p=unverified');
			exit;
		} else {
		
			$_SESSION['confirmation_error'] = 'success';
			$json['message'] = Filter::msgAlert(Lang::$word->PLG_CT_ERR, false);
			print json_encode($json);
		}


	endif;


?>
