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
<?php $inrow = $item->getPackagedInvoices();?>
<style>
	.loading {
		display: hide;
	}
</style>
<div class="content">

	<!-- Start Page Header -->
	<div class="page-header">
		<h1 class="title">Invoices</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li>
  		<li><a href="index.php?do=invoices<?php echo($invoiceSession) ?>">Invoices</a></li>
			<li class="active">Table</li>
		</ol>

		<!-- Start Page Header Right Div -->
		<div class="right" style="display: block!important;">
      <a id="btnExport" onclick="javascript:xport.toCSV('testTable');" class="btn btn-light">
        <i class="fa fa-file-excel-o"></i> Export to CSV
      </a>
		</div>
		<!-- End Page Header Right Div -->

	</div>
	<!-- End Page Header -->


	<!-- START PRODUCT TABLE -->
	<div class="container-widget">

		<!-- Start Row -->
		<div class="row">

			<!-- Start Panel -->
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body table-responsive">

						<table id="testTable" class="table display">
							<thead>
								<tr>
									<th>Name</th>
                  <th>Address</th>
									<th class="hide-mobile">Total Price</th>
									<th>Order</th>
								</tr>
							</thead>


							<tbody>
								<?php if(!$inrow):?>
								<tr>
								  <td colspan="5"><?php echo Filter::msgSingleAlert(Lang::$word->TXN_NOTRANS);?></td>
								</tr>
								<?php else:?>
								<?php foreach ($inrow as $row):?>



								<tr>

									<td>
										<a class="t-overflow" style="width: 150px;" href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->user_id;?>">
											<span><?php echo $row->name;?></span>
										</a>



										<div class="hide">
											<?php
												$userDetails = $user->getUserInfoWithID($row->user_id);
												echo $userDetails->username;
											?>
										</div>
									</td>

				                  <td>
				                    <?php if ($row->address2) { echo($row->address2 . '-'); } ?><?php echo($row->address); ?>, <?php echo($row->state); ?> <span style="text-transform:uppercase;"><?php echo($row->zip); ?></span>
									</td>

									<td class="hide-mobile">
										<?php echo(formatMonies($row->totalprice));?>
										<span style="display: none;">
											<?php echo($row->pp); ?>
										</span>
									</td>

									<td>
                    <?php
                      $receiptProducts = $item->getReceiptProducts($row->invid);
                      $weight = 30;

                      foreach ($receiptProducts as $row) {
                        echo($row->title . ' x ' . $row->item_qty . "<br/>");
                        $weight = ($row->item_qty * 26) + $weight;
                      }

                    ?>
										<?php unset($row);?>
                  </td>

								</tr>



								<?php endforeach;?>
								<?php unset($row);?>
								<?php endif;?>
							</tbody>
						</table>


					</div>

				</div>
			</div>
			<!-- End Panel -->

		</div>
		<!-- End Row -->


	</div>
	<!-- END CONTAINER -->

	<!-- Start Footer -->
	<?php include("components/footer.php") ?>
	<!-- End Footer -->


</div>



<!-- ================================================
jQuery Library
================================================ -->
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/datatables/datatables.min.js"></script>

<script type="text/javascript" src="assets/js/datatables/jquery.table2excel.min.js"></script>


<script>
var xport = {
  _fallbacktoCSV: true,
  toXLS: function(tableId, filename) {
    this._filename = typeof filename == "undefined" ? tableId : filename;

    //var ieVersion = this._getMsieVersion();
    //Fallback to CSV for IE & Edge
    if ((this._getMsieVersion() || this._isFirefox()) && this._fallbacktoCSV) {
      return this.toCSV(tableId);
    } else if (this._getMsieVersion() || this._isFirefox()) {
      alert("Not supported browser");
    }

    //Other Browser can download xls
    var htmltable = document.getElementById(tableId);
    var html = htmltable.outerHTML;

    this._downloadAnchor(
      "data:application/vnd.ms-excel" + encodeURIComponent(html),
      "xls"
    );
  },
  toCSV: function(tableId, filename) {
    this._filename = typeof filename === "undefined" ? tableId : filename;
    // Generate our CSV string from out HTML Table
    var csv = this._tableToCSV(document.getElementById(tableId));
    // Create a CSV Blob
    var blob = new Blob([csv], { type: "text/csv" });

    // Determine which approach to take for the download
    if (navigator.msSaveOrOpenBlob) {
      // Works for Internet Explorer and Microsoft Edge
      navigator.msSaveOrOpenBlob(blob, this._filename + ".csv");
    } else {
      this._downloadAnchor(URL.createObjectURL(blob), "csv");
    }
  },
  _getMsieVersion: function() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf("MSIE ");
    if (msie > 0) {
      // IE 10 or older => return version number
      return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
    }

    var trident = ua.indexOf("Trident/");
    if (trident > 0) {
      // IE 11 => return version number
      var rv = ua.indexOf("rv:");
      return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
    }

    var edge = ua.indexOf("Edge/");
    if (edge > 0) {
      // Edge (IE 12+) => return version number
      return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
    }

    // other browser
    return false;
  },
  _isFirefox: function() {
    if (navigator.userAgent.indexOf("Firefox") > 0) {
      return 1;
    }

    return 0;
  },
  _downloadAnchor: function(content, ext) {
    var anchor = document.createElement("a");
    anchor.style = "display:none !important";
    anchor.id = "downloadanchor";
    document.body.appendChild(anchor);

    // If the [download] attribute is supported, try to use it

    if ("download" in anchor) {
      anchor.download = this._filename + "." + ext;
    }
    anchor.href = content;
    anchor.click();
    anchor.remove();
  },
  _tableToCSV: function(table) {
    // We'll be co-opting `slice` to create arrays
    var slice = Array.prototype.slice;

    return slice
      .call(table.rows)
      .map(function(row) {
        return slice
          .call(row.cells)
          .map(function(cell) {
            return '"t"'.replace("t", cell.textContent);
          })
          .join(",");
      })
      .join("\r\n");
  }
};

</script>
