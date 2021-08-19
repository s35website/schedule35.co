<?php
	/**
	* Main
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	*/
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
  
	if (!$user->is_Admin()) {
		$_SESSION["isAdmin"] = '<ul class="error list"><li><i class="fa fa-exclamation-triangle"></i>Oops! Looks like you do not have permission to access this part of the website.</li>
		</ul>';
		redirect_to("index");
	}
  
  /*------------------- SIGNUP DATA START --------------------*/
  $signUpDateRangeStr = date("m/d/Y", strtotime("-6 months")) . ' - ' . date("m/d/Y", time());
  $signUpStartDate = date("Y-m-d", strtotime("-6 months"));
  $signUpEndDate = date("Y-m-d", time());
  if ($_GET['signUpDate'])
  {
    $signUpDateRangeStr = explode('-', $_GET['signUpDate']);
    $dateRangeStr = implode(" - ", $signUpDates);
    $signUpStartDate = date("Y-m-d", strtotime($signUpDates[0]));
    $signUpEndDate = date("Y-m-d", strtotime($signUpDates[1]));
  }
  
  $signUpDateOption = 'month';
  if ($_GET['signUpDateOptions'])
    $signUpDateOption = $_GET['signUpDateOptions'];
  
  $signUpProvince = null;
  if ($_GET['signUpProvinces'])
    $signUpProvince = $_GET['signUpProvinces'];
  $provinces = array_merge(array('na' => 'N/A'), getProvinces());
  /*------------------- SIGNUP DATA END --------------------*/
  
	require_once('components/stats.php');
	require_once('components/reports-utils.php');
?>

<style>
.loading {
	display: block;
}
#sign-up-date-range-picker{
  cursor: pointer;
}
</style>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">User Reports</h1>
	</div>
	<!-- End Page Header -->
	
	
	<!-- START PRODUCT TABLE -->
	<div class="container-widget">
    
    <!-- Daily sign up -->
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-title">Users</div>
					<div class="panel-body">
						
						<div id="filter-form-sign-up" class="row">
							
							<div class="col-sm-12 col-md-4">
								<form class="form-horizontal">
									<fieldset>
										<div class="control-group">
											<div class="controls">
												<div class="input-prepend input-group"> <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
													<input type="text" id="sign-up-date-range-picker" name="signUpDate" class="form-control" value="<?php print $signUpDateRangeStr; ?>" readonly />
												</div>
											</div>
										</div>
									</fieldset>
								</form>
							</div>							
							
							<div class="col-sm-6- col-md-2" style="text-align: center;">
								<div class="form-group">
				                  <select class="selectpicker" name="signUpProvinces" style="width: 100%;">
			                        <option value="">All Provinces</option>
			                        <?php
                              foreach ($provinces as $key => $value)
                              {
                                $activeClass = '';
                                if ($signUpProvince == $key)
                                {
                                  $activeClass = 'selected';
                                }
                                print '<option value="' . $key . '" ' . $activeClass . '>' . $value . '</option>';
                              }
                              ?>
			                      </select>  
				                </div>
							</div>
							
							
							
							
							<div class="col-sm-12 col-md-4">
								<div class="btn-group pull-right" data-toggle="buttons">
								<?php
								$dateOptions = array(
                  'day' => 'Day',
                  'month' => 'Month',
                  'year' => 'Year'
								);
								foreach ($dateOptions as $key => $value)
								{
								$activeClass = ''; $checked = '';
								if ($signUpDateOption == $key)
								{
								  $activeClass = 'active';
								  $checked = 'checked';
								}
								print '<label class="btn ' . $activeClass . '">'
								      . '<input type="radio" name="signUpDateOptions" value="' . $key . '" id="btn' . $value . '" ' . $checked . '> ' . $value 
								    . '</label>';
								}
								?>
								</div>
							</div>
							
						</div>
						
						
						<div class="row">
							<div class="col-12">
								<canvas id="signUpChart"></canvas>
							</div>
						</div>
						
						
						
					</div>
				</div>
			</div>
		</div>
		<!-- End Row -->
		
		
		

	</div>
	<!-- END CONTAINER -->
	
	<div class="bottom-spinner">
		<i class="fa fa-circle-o-notch fa-spin"></i>
	</div>

	<!-- Start Footer -->
	<?php include("components/footer.php") ?>
	<!-- End Footer -->


</div>



<!-- ================================================
jQuery Library
================================================ -->
<script type="text/javascript" src="assets/js/jquery.min.js"></script>

<!-- ================================================
Bootstrap Core JavaScript File
================================================ -->
<script src="assets/js/bootstrap/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/js/Chart.min.js?v=2"></script>
<script type="text/javascript" src="assets/js/moment/moment.min.js"></script>
<script type="text/javascript" src="assets/js/validetta/validetta.js"></script>
<script type="text/javascript" src="assets/js/hide-seek/jquery.hideseek.min.js"></script>
<script type="text/javascript" src="assets/js/date-range-picker/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/datatables/datatables.min.js"></script>

<script type="text/javascript" src="assets/js/datatables/jquery.table2excel.min.js"></script>

<script type="text/javascript" src="assets/js/sweet-alert/sweet-alert.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>





<!-- Basic Date Range Picker -->
<script>
  function UpdateQueryStringParameter(uri, key, value) 
  {
    value = value.replace('+', '%2B');
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
      return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
      return uri + separator + key + "=" + value;
    }
  }
  function RemoveURLParameter(url, parameter) 
  {
    //prefer to use l.search if you have a location/link object
    var urlparts = url.split('?');   
    if (urlparts.length >= 2) {

        var prefix = encodeURIComponent(parameter) + '=';
        var pars = urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i = pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }

        return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
    }
    return url;
  }
$(document).ready(function() {
  let signUpDateRangePicker = $('#sign-up-date-range-picker').daterangepicker({
    maxDate: new Date()
  }, function(start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
  });
  $("#filter-form-sign-up input, #filter-form-sign-up select").on("change", function() {
    CollectFormDataAndSubmit("#filter-form-sign-up", this);
  });
  
  function CollectFormDataAndSubmit(id, actionEl) {
    let inputs = $(id + " input, " + id + " select");
    let pars = {};
    
    $.each(inputs, function (index, value) {
      let $el = $(value);
      let type = $el.attr("type") || 'select';
      let name = $el.attr("name");
      if (type == 'text' || type == 'select')
      {
        pars[name] = $el.val().replaceAll(/\s/g,'');
      }
      else if (type == 'checkbox')
      {
        if ($el.prop("checked"))
          pars[name] = 'true';
        else
          pars[name] = 'false';
      }
      else if (type == 'radio')
      {
        pars[name] = $('input[name="' + name + '"]:checked').val();
      }
      if ($(actionEl).attr('name') == name)
      {
        if (pars[name].length <= 0)
          window.history.pushState("object or string", "Title", encodeURI(RemoveURLParameter(window.location.href, name)));
        else
          window.history.pushState("object or string", "Title", encodeURI(UpdateQueryStringParameter(window.location.href, name, pars[name])));
      }

    });
    pars['filterFormId'] = id;
    
    $.ajax({
      type: "post",
      dataType: 'json',
      url: "/admin/ajax/chart.php",
      data: pars,
      beforeSend: function() {
        $(".loading").show(0);
      },
      success: function(json) {
        $(".loading").hide(0);
        let chart, canvasId;
        if (id == '#filter-form-sign-up')
        {
          chart = window.signUpChart;
          canvasId = 'signUpChart';
        }
        else if (id == '#filter-form-sales')
        {
          chart = window.monthlyRevenueChart;
          canvasId = 'monthlyRevenueChart';
        }
        chart.destroy();
        var ctx = document.getElementById(canvasId).getContext('2d');
        
        chart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: JSON.parse(json.labels),
            datasets: JSON.parse(json.dataSets)
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:false
                }
              }]
            }
          }
        });
        chart.update();
        if (id == '#filter-form-sign-up')
        {
          window.signUpChart = chart;
        }
        else if (id == '#filter-form-sales')
        {
          window.monthlyRevenueChart = chart;
        }
      },
      error: function(json) {
        //error
        $(".loading").hide(0);
      }
    });
  }
});
</script>

<!-- for sign up live -->
<?php 
  
	$options = array(
    'startDate' => $signUpStartDate,
    'endDate' => $signUpEndDate,
    'dateOption' => $signUpDateOption,
    'province' => $signUpProvince
  );
  
  $labelsArray = array(); $dataRevArray = array();
  $revenueData = GetSignUpChartJsSingleLineData($analytics, $options);

  $labels = $revenueData['labels'];
  $dataRevArray = $revenueData['dataRevArray'];

  $dataSet = array(
    'label' => 'Sign up',
    'data' => $dataRevArray,
    'backgroundColor' => array('rgba(255, 99, 132, 0.2)', 'rgba(255, 159, 64, 0.2)'),
    'borderColor' => array('rgba(255,99,132,1)', 'rgba(255, 159, 64, 1)'),
    'borderWidth' => '1'
  );
  $dataSets = array($dataSet);
  
?>

<script>
	var ctx = document.getElementById("signUpChart").getContext('2d');
	window.signUpChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: [<?php echo($labels); ?>],
			datasets: JSON.parse(JSON.stringify(<?php print json_encode($dataSets); ?>))
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:false
					}
				}]
			}
		}
	});
</script>
