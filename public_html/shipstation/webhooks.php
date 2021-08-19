<?php
/**
 * ShipStation webhooks
 *
 * 
 * @author Pengyi Wang
 * @copyright 2019
 */
define("_VALID_PHP", true);

require_once ("../init.php");

ini_set('log_errors', true);
ini_set('error_log', dirname(__file__) . '/webhooks_errors.log');

$json = file_get_contents( 'php://input' );
$resource = json_decode( $json );

    $ch = curl_init($resource->resource_url);
   
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic '. Registry::get("Core")->shipstation_api
        )
    ));
    
    
    // Send the request
    $response = curl_exec($ch);

    // Check for errors
    if($response === FALSE){
        die(curl_error($ch));  
    }else{
    	 $responseData = json_decode($response);
    	 $shipments = $responseData->shipments;
    	 foreach($shipments as $shipment) { 
    			$orderKey = $shipment->orderKey; 
    			$trackingNumber = $shipment->trackingNumber;
                $data['trackingnum'] = $trackingNumber;
                $data['status'] = 1.5;
				$db->update(Content::inTable, $data, "invid='" . $orderKey ."'");
    			file_put_contents('./log_'.date("j.n.Y").'.log', $orderKey . ' - ' . $trackingNumber.' - '.date("F j, Y, g:i a").PHP_EOL, FILE_APPEND);
		 }
    
     }
    curl_close($ch);
    http_response_code(200);
?>
