<?php
/**
 * User Class
 *
 * @package FBC Studio
 * @author fbcstudio.com
 * @copyright 2010
 * @version $Id: class_user.php, v2.00 2011-07-10 10:12:05 gewa Exp $
 */

if (!defined("_VALID_PHP")) die('Direct access to this location is not allowed.');
class SquareClient
{
	public $url = null;
	public $demo = null;
	public $currency = null;
  public $bearer = null;
  public $appId = null;
  public $locId = null;
	/**
	 * Users::__construct()
	 *
	 * @return
	 */
	function __construct() {
    $db = Registry::get("Database");
    $key = $db->first("SELECT * FROM gateways WHERE name = 'square'");
    $this->demo = $key->demo;
    if ($this->demo == 0)
      $this->url = 'https://connect.squareupsandbox.com/';
    else
      $this->url = 'https://connect.squareup.com/';
    $this->currency = $key->extra2;
    $this->bearer = $key->extra3;
    $kar = explode('/',$key->extra);
    $this->appId = $kar[0];
    $this->locId = $kar[1];
	}
  
  function call($url, $postFields, $returnArray = true)
  {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $this->url . $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($postFields),
      CURLOPT_HTTPHEADER => array(
        "authorization: Bearer $this->bearer",
        "cache-control: no-cache",
        "content-type: application/json",
        "square-version: 2021-08-18"
      ),
    ));
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    return $this->processSquareResponse($response, $returnArray);
  }
  
  function processSquareResponse($response, $returnArray = true)
  {
    return json_decode($response, $returnArray);
  }
  
  function createPayment($postFields)
  {
    return $this->call('v2/payments', $postFields, false);
  }
  
  function loadSquareCustomerIdByEmail($email)
  {
    $postFields = array(
      'query' => array(
        'filter' => array(
          'email_address' => array(
            'exact' => $email
          )
        )
      )
    );
    $result = $this->call('v2/customers/search', $postFields, true);
    
    return isset($result['customers'][0]['id']) ? $result['customers'][0]['id'] : null;
  }
  
  function createCustomer($email, $firstName, $lastName)
  {
    $postFields = array(
      'email_address' => $email,
      'family_name' => $firstName,
      'given_name' => $lastName,
    );
    $result = $this->call('v2/customers', $postFields, true);
    
    return $result['customer']['id'];
  }
  
}

?>
