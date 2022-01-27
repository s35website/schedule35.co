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
?>
<style>
	.loading {
		display: block;
	}
	.statelock {
		/*border: none;
		box-shadow: none;*/
		background: none;
		opacity: 0.4;
	}
	.tracking-visible {
		display: none;
		white-space: nowrap;
	}
	.filter-form {
		margin: 15px 0;
	}
	.clearBtn {
		margin-top: 5px;
	}
	.dataTables_wrapper .dataTables_processing {
		position: absolute;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		z-index: 2;
		background: #fff;
		opacity: 0.9;
		margin: 0;
	
	}
	.dataTables_wrapper .dataTables_processing img {
		width: 40px;
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%);
	}
	#tproduct {
		width: 100%!important;
	}
	
	#change_status {
		position: fixed;
		bottom: 40px;
		right: 40px;
		z-index: 9999;
		height: 48px;
		background: #275efe;
		color: #fff;
		font-weight: bold;
		border: none!important;
		box-shadow: 0 2px 8px -1px rgba(39, 94, 254, 0.32)!important;
	}
	#change_status:disabled {
		display: none;
	}
  
</style>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Invoice Tracking</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
			<li class="active">Invoice Tracking</li>
		</ol>
		
		<!-- Start Page Header Right Div -->
		<div class="right" style="display: block!important;">
			
			<input id="action_mode" type="checkbox" checked data-toggle="toggle" data-on="Action Mode" data-off="Shipping Mode">
			
			<div class="btn-group">
				
				<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<span>Actions</span>
					<span class="caret"></span>
					<span class="sr-only">Toggle Dropdown</span>
				</button>
        		<ul class="dropdown-menu pull-right" role="menu">
        			<li><a id="packs_shipped">Packs Shipped</a></li>
					<li><a id="packs_packaged">Packs Packaged</a></li>
					<li><a id="export_all_new_orders">Export to Shipstation </a></li>
					<li class="divider"></li>
        			<li><a href="index.php?do=invoices&amp;action=add"><i class="fa fa-plus"></i> Add Record</a></li>
        			<li><a href="printtable.php?status=1.5" target="_blank"><i class="fa fa-file-excel-o"></i> View Table</a></li>
        			<li><a href="printinventory.php" target="_blank"><i class="fa fa-file-excel-o"></i> View Inventory</a></li>
        		</ul>
			</div>
			
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->


	<!-- START PRODUCT TABLE -->
	<div class="container-fluid">
		<div class="row">
			<form id="filter-form" class="filter-form form-horizontal">
				<div class="row">
					<div class="control-group col-sm-12 col-md-6">
						<label for="status">Search</label>
						<div class="controls">
							<input type="text" id="search" name="search" class="form-control" placeholder="Search here..." value="<?php print $search; ?>" autocomplete="off" />
						</div>
					</div>
					
					<div class="control-group col-sm-12 col-md-4">
						<div class="controls">
							<label for="date-range-picker">Date</label>
							<div class="input-prepend input-group"> <span class="add-on input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" id="date-range-picker" name="date" class="form-control" value="<?php print $dateRangeStr; ?>" autocomplete="off" />
							</div>
						</div>
					</div>
					<div class="col-sm-6- col-md-2">
						<label for="status">Status</label>
						<select class="selectpicker" name="status" style="width: 100%;">
							<option value="">All Invoices</option>
							<?php foreach ($invoiceStatuses as $key=>$value) { $activeClass = ''; if ($status === strval($key)) { $activeClass = 'selected'; } print '<option value="' . $key . '" ' . $activeClass . '>' . $value . '</option>'; } ?>
						</select>
					</div>
					
				</div>
			</form>
		</div>
	</div>
	
	<div class="container-widget">

		<!-- Start Row -->
		<div class="row">

			<!-- Start Panel -->
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body table-responsive">
						
						<select id="change_status" class="selectpicker" style="min-width: 184px;" disabled>
							<option disabled selected>Change Status</option>
							<option>Error</option>
							<option>Shipped</option>
							<option>Packaged</option>
							<option>Label Printed</option>
							<option>Exported</option>
							<option>Paid</option>
						</select>
						
						
						<table id="tproduct" class="table display">
							<thead>
								<tr>
									<th></th>
									<th>Invoices ID</th>
									<th>Status</th>
									<th>Name</th>
									<th class="hide-mobile">Date</th>
									<th>Actions</th>
								</tr>
							</thead>
						</table>
						
					</div>
				</div>
			</div>
			<!-- End Panel -->

		</div>
		<!-- End Row -->


	</div>
	<!-- END CONTAINER -->


	
	<div class="img-loading" style="position: fixed; bottom: 10%; right: 5%;">
		  <span class="css-loading" style="box-shadow: -3px 3px 8px rgba(0,0,0,0.2);"></span>
		</div>
	</div>
	
	
	<!-- Start Footer -->
	<?php include("_components/footer.php") ?>
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

<!-- ================================================
Bootstrap Toggle
================================================ -->
<script type="text/javascript" src="assets/js/bootstrap-toggle/bootstrap-toggle.min.js"></script>

<script type="text/javascript" src="assets/js/validetta/validetta.js"></script>
<script type="text/javascript" src="assets/js/hide-seek/jquery.hideseek.min.js"></script>
<script type="text/javascript" src="assets/js/moment/moment.min.js"></script>
<script type="text/javascript" src="assets/js/date-range-picker/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/summernote/summernote.min.js"></script>
<script type="text/javascript" src="assets/js/datatables/datatables.min.js"></script>

<script type="text/javascript" src="assets/js/datatables/jquery.table2excel.min.js"></script>

<script type="text/javascript" src="assets/js/sweet-alert/sweet-alert.min.js?v2.1.2"></script>
<script type="text/javascript" src="assets/js/spin/spin.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>


<script>
  function UpdateQueryStringParameter(uri, key, value)
  {
    uri = decodeURI(uri);
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
  function CollectFormData(id, actionEl) {
    let inputs = $(id + " input, " + id + " select");
    let pars = {};
    
    $.each(inputs, function (index, value) {
      let $el = $(value);
      let type = $el.attr("type") || 'select';
      let name = $el.attr("name");
      if (type == 'text' || type == 'select')
      {
        if (name == 'search')
          pars[name] = $el.val();
        else
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
    });
    
    return pars;
  }

	$(document).ready(function() {
    let dateRangePicker = $('#date-range-picker').daterangepicker({
      maxDate: new Date()
    }, function(start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
    });

    dateRangePicker.on("apply.daterangepicker", function(ev, picker){
      let name = $(this).attr('name');
      let value = $(this).val();
      if (name == 'date')
        value = value.split(' ').join('');
      if (value.length <= 0)
        window.history.pushState("object or string", "Title", encodeURI(RemoveURLParameter(window.location.href, name)));
      else
        window.history.pushState("object or string", "Title", encodeURI(UpdateQueryStringParameter(window.location.href, name, value)));
      
      window.shippingTable.ajax.reload();
    });
    
    $("#filter-form input, #filter-form select").on("change keyup", function() {
      let name = $(this).attr('name');
      let value = $(this).val();
      if (name == 'date')
        value = value.split(' ').join('');
      if (value.length <= 0)
        window.history.pushState("object or string", "Title", encodeURI(RemoveURLParameter(window.location.href, name)));
      else
        window.history.pushState("object or string", "Title", encodeURI(UpdateQueryStringParameter(window.location.href, name, value)));
      
      window.shippingTable.ajax.reload();
    });
    
    
		<?php if(true):?>
	    var shippingTable = $('#tproduct').DataTable({
        "ajax": {
          "url": "ajax/invoices.php",
          //"data": CollectFormData("#filter-form", null),
          data: function(d){
            $.extend(true, d, CollectFormData("#filter-form", null));
          },
          "error": function(jqXHR, ajaxOptions, thrownError) {
                  alert(thrownError + "\r\n" + jqXHR.statusText + "\r\n" + jqXHR.responseText + "\r\n" + ajaxOptions.responseText);
                }
        },
        "processing": true,
        "serverSide": true,
        "serverMethod": 'post',
        searching: false,
	    	//"lengthMenu": [[100, 500, 10000, -1], [100, 500, 10000, "All"]],
	    	"order": [[ 4, "desc" ]],
        stateSave: true,
        language: {
          processing: '<img src="assets/img/loading.gif" alt="loading-img" />'
        },
        'columns': [
		   { data: 'chek' },
          { data: 'invoiceId' },
          { data: 'status' },
          { data: 'name' },
          { data: 'date' },
          { data: 'actions', orderable: false }
       ]
		});
		window.shippingTable = shippingTable;
		/* spin for exporting */
		var mySpinner = null;

		function setupLoading() {    

		    $('<div id="divSpin" style="position:fixed;top:50%;left:50%"></div>').appendTo(document.body);
		 
		    var opts = {
		    		  lines: 13 // The number of lines to draw
		    		, length: 28 // The length of each line
		    		, width: 14 // The line thickness
		    		, radius: 42 // The radius of the inner circle
		    		, scale: 1 // Scales overall size of the spinner
		    		, corners: 1 // Corner roundness (0..1)
		    		, color: '#000' // #rgb or #rrggbb or array of colors
		    		, opacity: 0.5 // Opacity of the lines
		    		, rotate: 0 // The rotation offset
		    		, direction: 1 // 1: clockwise, -1: counterclockwise
		    		, speed: 1 // Rounds per second
		    		, trail: 60 // Afterglow percentage
		    		, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
		    		, zIndex: 2e9 // The z-index (defaults to 2000000000)
		    		, className: 'spinner' // The CSS class to assign to the spinner
		    		, top: '50%' // Top position relative to parent
		    		, left: '50%' // Left position relative to parent
		    		, shadow: false // Whether to render a shadow
		    		, hwaccel: false // Whether to use hardware acceleration
		    		, position: 'absolute' // Element positioning
		    		}
		     mySpinner = new Spinner(opts);
		}

		function removeLoading(){
			
			mySpinner.stop();
		}

		function showLoading() {
			 var target = document.getElementById('divSpin')
			 mySpinner.spin(target);
		}

		//Setup spinner
		setupLoading();
    
      $('body').on('change', '.invid-checkbox', function() {
        let checkedInputs = $('.invid-checkbox:checkbox:checked')
        if (checkedInputs.length > 0)
        {
          $("#change_status").removeAttr('disabled');
        }
        else
          $("#change_status").attr('disabled', 'disabled');
      });

      $('body').on('change', '#change_status', function() {
        let checkedInputs = $('.invid-checkbox:checkbox:checked')
        if (checkedInputs.length > 0)
        {
          $("#change_status").removeAttr('disabled');
          let invids = [];
          $.each(checkedInputs, function( i, e ) {
            invids.push($(e).data('invid'));
          });
          $.ajax({
            type: "post",
            dataType: 'json',
            url: "controller.php",
            data: {
              'action': 'invoice-bulk-update',
              'invids': invids,
              'status': $(this).val()
            },
            beforeSend: function() {
              showLoading();
            },
            success: function(json) {
              removeLoading();
              location.reload();
            },
            error: function() {
              removeLoading();
              console.log("error bulk update");
            }
          });
        }
        else
        {}
      });

		/* == Export shipping to ShipStatoin == */
	$('body').on('click', '#export_to_shipstation', function() {
		var txIDs = [];
		shippingTable.rows().iterator('row', function(context, index){
			var node = $(this.row(index).node()); 
			txIDs.push({'id':node.attr('txID'), 'tx':node.attr('tx')});
		});
		
		swal({
			title: "Are you sure?",
			text: "You are about to export all invoices to ShipStation.",
			buttons: {
			    cancel: "Cancel",
			    catch: {
			      text: "Yes, everything's ready",
			      value: "catch",
			    }
			},
		})
		.then((value) => {
			switch (value) {
				case "catch":
					$.ajax({
						type: "post",
						dataType: 'json',
						url: "controller.php",
						data: {
							'txIDs':txIDs,
							'exportOrdersToShipStation': 1
						},
						beforeSend: function() {
							showLoading();
						},
						success: function(json) {
							//console.log(json.message)
							removeLoading();
							var resultTable = '<table class="table table-bordered">';

                            $.each(json.message, function(index, item) {
                                $.each(item, function(key, value){
                                    resultTable = resultTable + '<tr><td>'+value.id+'</td><td>'+key+'</td><td>'+value.result+'</td></tr>';
                                });
                            });

							var div = document.createElement("div");
							div.innerHTML = resultTable;
                            resultTable = resultTable + '</table>';
									swal({
								text: "Your shipment have been exported.",
								icon: "success",
								content: div,
								buttons: {
									catch: {
									text: "Ok",
									value: "catch",
									}
								},
							})
							.then((value) => {
								location.reload();
							});
						},
						error: function() {
							removeLoading();
							console.log("error exporting shipping");
						}
					});
					
					
				break;
			
				default:
				swal("Nothing's been changed.");
			}
		});
		
	});

		/* == Export all paid orders to ShipStatoin == */
		$('body').on('click', '#export_all_new_orders', function() {

		swal({
			title: "Are you sure?",
			text: "You are about to export all paid orders to ShipStation.",
			buttons: {
			    cancel: "Cancel",
			    catch: {
			      text: "Yes, everything's ready",
			      value: "catch",
			    }
			},
		})
		.then((value) => {
			switch (value) {
				case "catch":
					$.ajax({
						type: "post",
						dataType: 'json',
						url: "controller.php",
						data: {
							'exportOrdersToShipStationA': 1
						},
						beforeSend: function() {
							showLoading();
						},
						success: function(json) {
							//console.log(json.message)
							removeLoading();
							var resultTable = '<table class="table table-bordered">';
                            $.each(json.message, function(index, item) {
                                $.each(item, function(key, value){
                                    resultTable = resultTable + '<tr><td>'+value.id+'</td><td>'+key+'</td><td>'+value.result+'</td></tr>';
                                });
                            });

							var div = document.createElement("div");
							div.innerHTML = resultTable;
                            resultTable = resultTable + '</table>';
									swal({
								text: "Your shipment have been exported.",
								icon: "success",
								content: div,
								buttons: {
									catch: {
									text: "Ok",
									value: "catch",
									}
								},
							})
							.then((value) => {
								location.reload();
							});
						},
						error: function() {
							removeLoading();
							console.log("error exporting shipping");
						}
					});
					
					
				break;
			
				default:
				swal("Nothing's been changed.");
			}
		});
		
	});

	    <?php endif;?>

	} );
  
  /* == Change invoice to shipped == */
	$('body').on('click', '#packs_shipped', function() {
		swal({
			title: "Are you sure?",
			text: "You are about to change all status to shipped.",
			buttons: {
			    cancel: "Cancel",
			    catch: {
			      text: "Yes, everything's been shipped",
			      value: "catch",
			    }
			},
		})
		.then((value) => {
			switch (value) {
				case "catch":
					$.ajax({
						type: "post",
						dataType: 'json',
						url: "controller.php",
						data: {
							'updateInvoiceShipped': 1
						},
						beforeSend: function() {
						},
						success: function(json) {
							console.log("success");
						},
						error: function() {
							console.log("error updating shipping");
						}
					});
					swal({
						text: "Your shipment statuses have been updated.",
						icon: "success",
						buttons: {
						    catch: {
						      text: "Ok",
						      value: "catch",
						    }
						},
					})
					.then((value) => {
						location.reload();
					});
				break;
			
				default:
				swal("Nothing's been changed.");
			}
		});
	});
	
	
	/* == Change invoice to shipped == */
	$('body').on('click', '#packs_packaged', function() {
		
		
		swal({
			title: "Are you sure?",
			text: "You are about to change all status to packaged.",
			buttons: {
			    cancel: "Cancel",
			    catch: {
			      text: "Yes, everything's been packaged",
			      value: "catch",
			    }
			},
		})
		.then((value) => {
			switch (value) {
				case "catch":
					$.ajax({
						type: "post",
						dataType: 'json',
						url: "controller.php",
						data: {
							'updateInvoiceLabeled': 1
						},
						beforeSend: function() {
						},
						success: function(json) {
							console.log("success");
						},
						error: function() {
							console.log("error updating shipping");
						}
					});
					
					swal({
						text: "Your shipment statuses have been updated.",
						icon: "success",
						buttons: {
						    catch: {
						      text: "Ok",
						      value: "catch",
						    }
						},
					})
					.then((value) => {
						location.reload();
					});
					
					
				break;
			
				default:
				swal("Nothing's been changed.");
			}
		});
		
	});
	
	
	
	/* == Tracking Number Save == */
	$('body').on('click', '.trackingSaveBtn', function() {
		
		var id = $(this).data('id');
		var trackingnum = $(this).parent().parent().find("input[name=trackingnum]").val();
		var trackinginput = $(this).parent().parent().find("input[name=trackingnum]");
		
		console.log(trackingnum);
		
		$.ajax({
			type: "post",
			dataType: 'json',
			url: "controller.php",
			data: {
				id: id,
				trackingnum: trackingnum,
				'processInvoiceTracking': 1
			},
			beforeSend: function() {
				$('.css-loading').show();
			},
			success: function(json) {
				console.log("success");
				$('.css-loading').hide();
				
				$(trackinginput).addClass("statelock");
				
			},
			error: function() {
				console.log("error updating shipping");
				$('.css-loading').hide();
			}
		});
		
		
	});
	
	/* == Tracking Number Save == */
	$('body').on('click', '.statelock', function() {
		$(this).removeClass("statelock");
	});
	
	$('#action_mode').change(function() {
        if(this.checked) {
			$(".tracking-invisible").show();
			$(".tracking-visible").hide();
        }else {
			$(".tracking-invisible").hide();
			$(".tracking-visible").show();
		}     
	});
	
	



</script>
