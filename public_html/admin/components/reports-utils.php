<?php

function LogInfoToFile($obj, $fileName = null)
{
  if (!$fileName)
    $fileName = 'log.txt';
  
  if (file_exists($fileName))
    $file = fopen($fileName, 'a+');
  else
    $file = fopen($fileName, 'x+');

  if (is_array($obj) || is_object($obj))
    $obj = var_export($obj, true);
  $str = "[" . date('d-M-Y H:i:s') . '] ' . $obj;
  $bytes = fwrite($file, $str."\n");
  fclose($file);
}

/**
 * 
 * @param Analyze $analytics
 * @param Array $options
 */
function GetChartJsSingleLineData($analytics, $options)
{
  $startDate = $options['startDate'];
  $endDate = $options['endDate'];
  $dateOption = $options['dateOption'];
  $flavours = $options['flavours'];
  
  if ($flavours == 'false')
  {
    if ($dateOption == 'month')
      $rows = $analytics->monthlyRevenue($options);
    else if ($dateOption == 'day')
      $rows = $analytics->dailyRevenue($options);
    else if ($dateOption == 'year')
      $rows = $analytics->annualRevenue($options);
    
    return GenerateChartJsSingleLineDataFromRows($rows, $options);
  }
}

/**
 * 
 * @param Analyze $analytics
 * @param Array $options
 */
function GetSignUpChartJsSingleLineData($analytics, $options)
{
  $startDate = $options['startDate'];
  $endDate = $options['endDate'];
  $dateOption = $options['dateOption'];
  
  if ($dateOption == 'month')
    $rows = $analytics->monthlySignup($options);
  else if ($dateOption == 'day')
    $rows = $analytics->dailySignup($options);
  else if ($dateOption == 'year')
    $rows = $analytics->annualSignup($options);

  return GenerateChartJsSingleLineDataFromRows($rows, $options);
}

function GetPeriodSettings($period)
{
  $perriodSetts = array(
  'day' => array(
      'effectiveDateFormat' => 'Y-m-d',
      'labelDateFormat' => 'Y-m-d',
      'chartLabelDateFormat' => "M d",
      'unit' => 'day',
    ),
    'month' => array(
      'effectiveDateFormat' => 'Y-m-01',
      'labelDateFormat' => 'Y-m',
      'chartLabelDateFormat' => "M Y",
      'unit' => 'months',
    ),
    'year' => array(
      'effectiveDateFormat' => 'Y-01-01',
      'labelDateFormat' => 'Y',
      'chartLabelDateFormat' => null,
      'unit' => 'year',
    ),
  );
  
  return $perriodSetts[$period];
}

function GenerateChartJsSingleLineDataFromRows($rows, $options)
{
  $rowsDict = array();
  foreach ($rows as $row)
  {
    $rowsDict[$row->aggOpt] = $row;
  }
  
  $periodSet = GetPeriodSettings($options['dateOption']);
  
  // generate all the period units in the range. Ex: if user selected "months", then we generate every month from startData till the endDate,
  // then we will fill that dates with values from database or with zero if on that date the database didnt return any value.
  $periodsUnit = array();
  $effectiveDate = date($periodSet['effectiveDateFormat'], strtotime($options['startDate']));
  while($effectiveDate <= $options['endDate'])
  {
    $periodsUnit[] = date($periodSet['labelDateFormat'], strtotime($effectiveDate));
    $effectiveDate = date($periodSet['effectiveDateFormat'], strtotime("+1 " . $periodSet['unit'], strtotime($effectiveDate)));
  }
  
  $eRows = array();
  foreach ($periodsUnit as $periodUnit)
  {
    if (isset($rowsDict[$periodUnit]))
      $eRows[$periodUnit] = $rowsDict[$periodUnit]->total;
    else
      $eRows[$periodUnit] = 0;
  }
  $labelsArray = array(); $dataRevArray = array();
  foreach ($eRows as $key => $value)
  {
    if ($options['dateOption'] == 'year')
      $labelsArray[] = '"' . $key . '"';
    else
      $labelsArray[] = '"' . date($periodSet['chartLabelDateFormat'], strtotime($key)) . '"';
    $dataRevArray[] = $value;
  }
  $labels = implode(", ", $labelsArray);
  $dataRev = implode(", ", $dataRevArray);
  return array(
    'labels' => $labels,
    'dataRevArray' => $dataRevArray,
    'labelsArray' => $labelsArray,
  );
}

/**
 * 
 * @param Analyze $analytics
 * @param Array $options
 */
function GetChartJsMultiLineData($analytics, $options)
{
  $startDate = $options['startDate'];
  $endDate = $options['endDate'];
  if ($options['dateOption'] == 'month')
    $rows = $analytics->inventoryTransactionsSpecificMonthly($options);
  if ($options['dateOption'] == 'day')
    $rows = $analytics->inventoryTransactionsSpecificDaily($options);
  if ($options['dateOption'] == 'year')
    $rows = $analytics->inventoryTransactionsSpecificAnnual($options);
  
  $rowsDict[] = array();
  foreach ($rows as $row)
  {
    $rowsDict[$row->pid][$row->aggOpt] = $row->total;
  }
  
  $periodSet = GetPeriodSettings($options['dateOption']);
  $periodsUnit = array();
  $effectiveDate = date($periodSet['effectiveDateFormat'], strtotime($startDate));
  while($effectiveDate <= $endDate)
  {
    $periodsUnit[] = date($periodSet['labelDateFormat'], strtotime($effectiveDate));
    $effectiveDate = date($periodSet['effectiveDateFormat'], strtotime("+1 " . $periodSet['unit'], strtotime($effectiveDate)));
  }
  
  $dataSetsRaw = array();
  foreach ($rowsDict as $key => $value)
  {
    if ($key <= 0)
      continue;
    foreach ($periodsUnit as $periodUnit)
    {
      $dataSetsRaw[$key][$periodUnit] = $value[$periodUnit] ? $value[$periodUnit] : 0;
    } 
  }
  
  foreach ($periodsUnit as $periodUnit)
  {
    if ($options['dateOption'] == 'year')
      $labelsArray[] = '"' . $periodUnit . '"';
    else
      $labelsArray[] = '"' . date($periodSet['chartLabelDateFormat'], strtotime($periodUnit)) . '"';
  }
  $labels = implode(", ", $labelsArray);
  
  $colorMap = array(
    '1' => '#76b90e',
    '4' => '#c84437',
    '5' => '#f8d67e',
    '6' => '#db7e55',
    '7' => '#a34f9a',
    '8' => '#227cca',
    '9' => '#f76f6d',
    '10' => '#fad8d7',
    '11' => '#3e2a10',
    '12' => '#f8d42d',
    '13' => '#c60931',
  );

  $dataSets = array();
  foreach ($dataSetsRaw as $key => $values)
  {
    $data = array();
    foreach ($values as $date => $value)
    {
      $data[] = $value;
    }
    $dataset = array(
      'data' => $data,
      'label' => getValueById("title", Products::pTable, $key),
      'backgroundColor' => $colorMap[$key],
      'borderColor' => $colorMap[$key],
      'fill' => 'false'
    );
    $dataSets[] = $dataset;
  }
  
  return array(
    'labels' => $labels,
    'dataSetsRaw' => $dataSetsRaw,
    'dataSets' => $dataSets,
    'labelsArray' => $labelsArray
  );
}
?>