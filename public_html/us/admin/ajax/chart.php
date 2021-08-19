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
  error_reporting(0);
	require_once("../init.php");
  if (!$user->is_Admin()) {
    $response = array("type" => "error", "html" => '<ul class="error list"><li><i class="fa fa-exclamation-triangle"></i>Oops! Looks like you do not have permission to access this part of the website.</li></ul>');
    print json_encode($response);
  }
  require_once('../components/reports-utils.php');
  $requestData = $_POST;
  $id = $requestData['filterFormId'];
  if ($id == '#filter-form-sales')
  {
    $dates = explode('-', $requestData['date']);
    $dateRangeStr = implode(" - ", $dates);
    $startDate = date("Y-m-d", strtotime($dates[0]));
    $endDate = date("Y-m-d", strtotime($dates[1]));
    $dateOption = isset($requestData['dateOptions']) ? $requestData['dateOptions'] : 'month';
    $province = isset($requestData['provinces']) && strlen($requestData['provinces']) > 0 ? $requestData['provinces'] : null;
    $flavours = 'false';
    if (isset($_GET['flavours']))
    {
      $flavours = $_GET['flavours'];
    }

    $options = array(
      'startDate' => $startDate,
      'endDate' => $endDate,
      'dateOption' => $dateOption,
      'flavours' => $flavours,
      'province' => $province,
    );

    $labelsArray = array(); $dataRevArray = array();

    if ($requestData['flavours'] == 'true')
    {
      $quantityData = GetChartJsMultiLineData($analytics, $options);
      $labelsArray = $quantityData['labelsArray'];
      $dataSetsRaw = $quantityData['dataSetsRaw'];
      $dataSets = $quantityData['dataSets'];
    }
    else
    {
      $revenueData = GetChartJsSingleLineData($analytics, $options);

      $labels = $revenueData['labels'];
      $dataRevArray = $revenueData['dataRevArray'];
      $labelsArray = $revenueData['labelsArray'];

      $dataSet = array(
        'label' => 'Sales',
        'data' => $dataRevArray,
        'backgroundColor' => array('rgba(255, 99, 132, 0.2)', 'rgba(255, 159, 64, 0.2)'),
        'borderColor' => array('rgba(255,99,132,1)', 'rgba(255, 159, 64, 1)'),
        'borderWidth' => '1'
      );
      $dataSets = array($dataSet);
    }
  }
  else if ($id == '#filter-form-sign-up')
  {
    $dates = explode('-', $requestData['signUpDate']);
    $startDate = date("Y-m-d", strtotime($dates[0]));
    $endDate = date("Y-m-d", strtotime($dates[1]));
    $dateOption = isset($requestData['signUpDateOptions']) ? $requestData['signUpDateOptions'] : 'month';
    $province = isset($requestData['signUpProvinces']) && strlen($requestData['signUpProvinces']) > 0 ? $requestData['signUpProvinces'] : null;

    $options = array(
      'startDate' => $startDate,
      'endDate' => $endDate,
      'dateOption' => $dateOption,
      'province' => $province,
    );
    
    $revenueData = GetSignUpChartJsSingleLineData($analytics, $options);
    $labels = $revenueData['labels'];
    $dataRevArray = $revenueData['dataRevArray'];
    $labelsArray = $revenueData['labelsArray'];

    $dataSet = array(
      'label' => 'Sign Up',
      'data' => $dataRevArray,
      'backgroundColor' => array('rgba(255, 99, 132, 0.2)', 'rgba(255, 159, 64, 0.2)'),
      'borderColor' => array('rgba(255,99,132,1)', 'rgba(255, 159, 64, 1)'),
      'borderWidth' => '1'
    );
    $dataSets = array($dataSet);
  }
  start_content();
  content_collect($ajaxContent);
  $response = array(
    "type" => "success", 
    'labels' => json_encode($labelsArray), 
    'dataRev' => json_encode($dataRevArray), 
    'dataSets' => json_encode($dataSets),
    'debug' => $labels
  );
  print json_encode($response);
  function start_content() 
  {
    global $GET_CONTENT;
    $GET_CONTENT .= ob_get_contents();
    ob_end_clean();
    ob_start();
  }

  function content_collect(&$out) 
  {
    $out .= ob_get_contents();
    ob_end_clean();
    ob_start();
  }
?>

