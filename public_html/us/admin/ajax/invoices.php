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
  if (!$user->is_Admin() && !$user->is_Manager()) {
    $response = array("type" => "error", "html" => '<ul class="error list"><li><i class="fa fa-exclamation-triangle"></i>Oops! Looks like you do not have permission to access this part of the website.</li></ul>');
    print json_encode($response);
  }
  
  $requestData = $_POST;
  $columns = $requestData['columns'];
  $order = $requestData['order'];
  require_once('../components/reports-utils.php');

  $defaultInvoicesLoadSize = 100;
  $dateRangeStr = date("m/d/Y", strtotime("-6 months")) . ' - ' . date("m/d/Y", time());
  $startDate = '';
  $endDate = '';
//  $startDate = date("Y-m-d", strtotime("-6 months"));
//  $endDate = date("Y-m-d", time());
  if ($requestData['date'])
  {
    $dates = explode('-', $requestData['date']);
    $dateRangeStr = implode(" - ", $dates);
    $startDate = date("Y-m-d", strtotime($dates[0]));
    $endDate = date("Y-m-d", strtotime($dates[1]));
  }
  
  $db = Registry::get("Database");
  $startDateTime = '"' . sanitize($db->escape($startDate . ' 00:00:00')). '"';
  $endDateTime = '"' . sanitize($db->escape($endDate . ' 23:59:59')). '"';
  if (!$startDate || !$endDate)
    $where = " 1 ";
  else
    $where = "i.created>=$startDateTime AND i.created<=$endDateTime";
  
  $search = '';
  if ($requestData['search'])
  {
    $search = $requestData['search'];
    $search = sanitize($db->escape($search));
    $sr = "'%" . sanitize($db->escape($requestData['search'])). "%'";
    $search = PrepareFtsPhrase($search);
    if (strlen($search < 3))
      $where .= " AND (i.invid LIKE $sr OR i.name LIKE $sr OR i.totalprice LIKE $sr OR u.username LIKE $sr)";
    else
      $where .= " AND (MATCH(i.invid, i.name) AGAINST(\"" . $search . "\" IN BOOLEAN MODE) OR i.totalprice LIKE $sr OR u.username LIKE $sr)";
  }
  
  $status = '';
  if (isset($requestData['status']))
  {
    if (in_array($requestData['status'], array('0', '1', '1.2', '1.5', '2', '3', '4')))
    {
      $status = $requestData['status'];
      $status = '"' . sanitize($db->escape($status)). '"';
      $where .= " AND i.status=$status";
    }
  }
  
  $paginationData = array(
    'from' => $requestData['start'],
    'length' => $requestData['length']
  );
  
  // map dataTableProperty => database_column
  $map = array(
    'invoiceId' => 'invid',
    'status' => 'status',
    'name' => 'name',
    'date' => 'created'
  );
  
  $orderBy = 'i.' . $map[$columns[$order[0]['column']]['data']] . " " . strtoupper($order[0]['dir']);
  $inrow = $item->getInvoicesA($where, $orderBy, $paginationData);
  
  $rows = array();
  foreach ($inrow as $row):
    $invoiceId = '';
    start_content();
  ?>
  
    
  
	<a class="t-block" href="index.php?do=invoices&amp;action=edit&amp;tx=<?php echo $row->invid;?>">
	  <span class="t-overflow" style="width: 150px;"><?php echo $row->invid;?></span>
	  <span class="t-block-absolute"><?php echo $row->invid;?></span>
	
	  <?php 
	    if ($row->pp == "Points") {
	      echo(intval($row->totalprice) . " pts");
	    }
	    else {
				echo(formatMonies($row->totalprice));
			}
	   ?>
	</a>
	
	<div class="hide">
	  <?php
	    $userDetails = $user->getUserInfoWithID($row->user_id);
	    echo $userDetails->username;
	  ?>
	</div>
	<div class="hide">
	  <?php echo $row->trackingnum;?>
	
	  <span style="display: none;">
	    <?php echo($row->pp); ?>
	  </span>
	</div>
    <?php content_collect($invoiceId); ?>
    <?php $status = ''; start_content(); ?>
        <a href="index.php?do=invoices&amp;action=edit&amp;tx=<?php echo $row->invid;?>">
        <?php
          if ($row->status == 4) {
            echo('<span class="color-error">error</span>');
          }elseif ($row->status == 3) {
            echo('<span class="color-shipped">shipped</span>');
          }elseif ($row->status == 2) {
            echo('<span class="color-packaged">packaged</span>');
          }elseif ($row->status == 1.5) {
            echo('<span class="color-labelled">label printed</span>');
          }elseif ($row->status == 1.2) {
            echo('<span class="color-exported">Exported</span>');
          }elseif ($row->status == 1) {
            echo('<span class="color-paid">paid</span>');
          }
          else {
            echo('<span class="color-unpaid">unpaid</span>');
          }
        ?>
        </a>
        <div style="font-size: 9px; text-transform: uppercase;">
          <?php
          if ($row->shipping >= $core->shipping_express) {
            echo("<span style='font-weight:bold;opacity: 0.5;'>Express</span>");
          }else {
            echo("<span style='font-weight:bold;opacity: 0.5;'>Standard</span>");
          }
          ?>

          <?php
          if ($row->heatflag) {
            echo("/ <span style='font-weight:bold;color:red;'>Heat</span>");
          }
          ?>
        </div>
		
      <?php content_collect($status); ?>
      
      
      
      
		<?php  $chek= ''; start_content(); ?>
			<div class="checkbox">
                <input id="<?php echo $row->invid;?>" type="checkbox" data-invid="<?php echo $row->invid;?>" class="invid-checkbox">
                <label for="<?php echo $row->invid;?>"></label>
            </div>
		<?php content_collect($chek); ?>
      
      
      
      <?php $name = ''; start_content(); ?>
        <a class="t-overflow" style="width: 130px;" href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->user_id;?>">
          <span><?php echo $row->name;?></span>
        </a>
        <div>
          <?php echo($row->zip); ?>
        </div>

      <?php content_collect($name); ?>
      
      
      <?php $date = ''; start_content(); ?>
        <a class="t-block">
          <span class="t-overflow" style="width: 150px;"><?php echo date("Y-m-d H:i", strtotime($row->created));?></span>
          <span class="t-block-absolute"><?php echo date("Y-m-d H:i", strtotime($row->created));?></span>
        </a>
      <?php content_collect($date); ?>
      
      <?php $actions = ''; start_content(); ?>
        <div class="tracking-visible">
          <?php if($row->trackingnum):?>
          <input class="statelock" type="text" name="trackingnum" value="<?php echo $row->trackingnum;?>" />
          <?php else:?>
          <input type="text" name="trackingnum" value="<?php echo $row->trackingnum;?>" />
          <?php endif;?>
          <a class="btn btn-rounded btn-option5 btn-icon trackingSaveBtn" data-id="<?php echo $row->id;?>" style="margin-left: 10px;margin-right: 10px;">
            <i class="fa fa-save"></i>
          </a>
        </div>


        <a class="btn btn-rounded btn-success btn-icon tracking-invisible" href="index.php?do=invoices&amp;action=edit&amp;tx=<?php echo $row->invid;?>" target="_blank">
          <i class="fa fa-pencil"></i>
        </a>
        <a class="btn btn-rounded btn-danger btn-icon deleteBtn tracking-invisible" data-title="<?php echo Lang::$word->TXN_DELETE;?>" data-option="deleteInvoice" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->invid;?>">
          <i class="fa fa-remove"></i>
        </a>
        <?php content_collect($actions); ?>
	<?php
	$rows[] = array(
		'chek' => $chek,
		'invoiceId' => $invoiceId,
		'status' => $status,
		'name' => $name,
		'date' => $date,
		'actions' => $actions,
	);
    endforeach;
    
  $response = array(
		"draw" => $requestData['draw'],
		"iTotalRecords" => $paginationData['total'],
		"iTotalDisplayRecords" => $paginationData['total'],
		"aaData" => array_values($rows),
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
  
  function PrepareFtsPhrase($search)
{
  $stopchars = array('\\', '\n', '\r');
  $search = str_replace($stopchars, ' ', ' ' . $search . ' ');
  $search = str_replace('  ', ' ', $search);
  $search = trim($search);
  $stopwords = array(" a "," an "," and "," or "," the "," it "," i ");

  $search = str_replace($stopwords, " ", $search);
  $indexArray = explode(" ", $search);
  // Strip double words
  $indexArray = array_unique($indexArray);
  $full_text_search = array();
  foreach ($indexArray as $word)
  {
    $word = trim($word);
    if (strlen($word) > 0)
    {
      $strlen = mb_strlen($word, 'utf-8');
      if ($strlen > 2)
      {
        $full_text_search[] = $word . '*';
      }
    }
  }
  return implode(' ', $full_text_search);
}
?>

