<?php
	/**
	* Index
	*
	* @package FBC Studio
	* @author fbcstudio.com
	* @copyright 2014
	* @version $Id: index.php, v3.00 2014-07-10 10:12:05 gewa Exp $
	*/
	define("_VALID_PHP", true);
	require_once("init.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Wholesale Label Maker</title>
  <link href="https://fonts.googleapis.com/css?family=Oswald:400,500,600|Roboto+Mono:400,400i" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <style>
  	/* http://meyerweb.com/eric/tools/css/reset/ 
  	   v2.0 | 20110126
  	   License: none (public domain)
  	*/
  	
  	html, body, div, span, applet, object, iframe,
  	h1, h2, h3, h4, h5, h6, p, blockquote, pre,
  	a, abbr, acronym, address, big, cite, code,
  	del, dfn, em, img, ins, kbd, q, s, samp,
  	small, strike, strong, sub, sup, tt, var,
  	b, u, i, center,
  	dl, dt, dd, ol, ul, li,
  	fieldset, form, label, legend,
  	table, caption, tbody, tfoot, thead, tr, th, td,
  	article, aside, canvas, details, embed, 
  	figure, figcaption, footer, header, hgroup, 
  	menu, nav, output, ruby, section, summary,
  	time, mark, audio, video {
  		margin: 0;
  		padding: 0;
  		border: 0;
  		font-size: 100%;
  		font: inherit;
  		vertical-align: baseline;
  	}
  	/* HTML5 display-role reset for older browsers */
  	article, aside, details, figcaption, figure, 
  	footer, header, hgroup, menu, nav, section {
  		display: block;
  	}
  	body {
  		line-height: 1;
  	}
  	ol, ul {
  		list-style: none;
  	}
  	blockquote, q {
  		quotes: none;
  	}
  	blockquote:before, blockquote:after,
  	q:before, q:after {
  		content: '';
  		content: none;
  	}
  	table {
  		border-collapse: collapse;
  		border-spacing: 0;
  	}
  	
  	
  	* {
  		text-transform: uppercase;
  		box-sizing: border-box;
  		margin: 0;
  		font-family: Oswald, Arial, sans-serif;
  		box-sizing: border-box;
  	}
  	
  	body {
  		padding: 0;
  		margin: 0;
  		position: relative;
  		font-family: Oswald, Arial, sans-serif;
		background: #efefef;
  	}
  	.container {
  		width: 610px;
  		height: 960px;
		position: absolute;
		top: 20px;
		left: 460px;
		border: 1px solid #ccc;
		background: #fff;
		margin-bottom: 30px;
  	}
  	  	
  	.wrapper {
  		margin: 48px 25px 0;
  		padding: 12px 20px 18px;
  		border: 2px solid #333;
  		position: absolute;
  		top: 0;
  		left: 0;
  		z-index: 999;
  	}
  	table {
  		width: 100%;
  		border-collapse: collapse;
  		vertical-align: middle;
  	}
  	.product-table {
  		min-width: 514px;
  	}
  	.product-table td {
  		border-bottom: 1px solid #333;
  		padding: 12px 0;
  		vertical-align: middle;
  	}
  	td.flavour {
  		width: 500px; 
  	}
  	td.mid {
  		width: 50px;
  	}
  	td.amount {
  		width: 60px;
  	}
  	
  	.flavour, input.amount {
  		font-size: 27px;
  		font-weight: 500;
  		width: 100%;
  		border: none;
  	}
  	
  	.product-row {
  		display: none;
  	}
  	.product-row.active {
  		display: table-row;
  	}
	
	input:hover,
	input:focus,
	select:hover,
	select:focus {
		outline: none;
		background-color: #eee;
	}
	input.amount {
		text-align: right;
	}
	
	.info {
		position: absolute;
		bottom: 4px;
		left: 25px;
		width: 545px;
		font-size: 17px;
	}
	.info td {
		white-space: nowrap;
		padding-bottom: 12px;
		vertical-align: middle;
	}
	.input-info {
		font-size: 17px;
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		border: none;
	}
	.input-info.border {
		border-bottom: 1px solid #333;
	}
	
	.product-table tr:last-of-type td {
		padding-bottom: 0;
		border-bottom: none;
	}
	
	button {
		cursor: pointer;
		display:inline-block;
		padding:12px 20px;
		margin:12px 6px 6px 0;
		border-radius:0.15em;
		box-sizing: border-box;
		text-decoration:none;
		font-family:'Roboto',sans-serif;
		text-transform:uppercase;
		font-weight:400;
		color:#FFFFFF;
		background-color:#444;
		box-shadow:inset 0 -0.6em 0 -0.35em rgba(0,0,0,0.17);
		text-align:center;
		position:relative;
		font-size: 18px;
	}
	
	button.xbtn {
		display: inline-block;
		border-radius: 6px;
		padding: 6px;
		margin: 6px 0 0 0;
		box-shadow: none;
		font-size: 16px;
		text-transform: none;
		background: transparent;
		border: 1px solid #333;
		color: #121212;
	}
	button.xbtn:hover,
	button.xbtn.active {
		color: #fff;
		background: #000;
	}
	
	button.flavBtn {
		display: block;
		border-radius: 6px;
		padding: 6px;
		margin: 6px 0 0 0;
		box-shadow: none;
		font-size: 12px;
		text-transform: none;
		background: transparent;
		border: 1px solid #333;
		color: #121212;
	}
	button.flavBtn:hover,
	button.flavBtn.active {
		color: #fff;
		background: #000;
	}
	
	table.tactions {
		position: fixed;
		top: 20px;
		left: 20px;
		text-align: left;
		width: 400px;
	}
	table.tactions, .tactions th, .tactions td {
	  border: 1px solid #777;
	}
	table.tactions th,
	table.tactions td {
		padding: 5px;
	}
	
	@media print {
		body {
			overflow: hidden;
			padding: 0;
		}
		.hide-print {
			display: none;
		}
		
		.container {
			border: none;
			top: 0;
			left: 0;
			width: 610px;
			height: 900px;
			margin-bottom: 0;
		}
		input, select {
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			border: none!important;
			padding: 0;
		}
		.input-info.border {
			border-bottom: 1px solid #333!important;
		}
	}
	
  </style>
</head>
<body>
	
	<div id="outprint" class="container">
		<?php 
			$productrow = $item->getAllProducts();
		 ?>
		 <div class="wrapper">
		 	<table class="product-table">
		 		<tbody>
		 			<?php $count = 1; ?>
		 			<?php foreach($productrow as $lrow):?>
		 			<tr id="pid-<?php echo $lrow->id?>" data-pid="<?php echo $lrow->id?>" data-cat="<?php echo $lrow->cid?>" class="product-row cat-<?php echo $lrow->cid?>">
		 				<td class="flavour">
		 					<?php echo $lrow->title?>
		 				</td>
		 				<td class="mid" style="font-size: 22px;text-align: center;">
		 					<i class="fa fa-times" aria-hidden="true"></i>
		 				</td>
		 				<td class="amount" style="text-align: right;">
		 					<input class="amount" type="text" value="0" maxlength="3"/>
		 				</td>
		 			</tr>
		 			<?php $count++; ?>
					<?php endforeach;?>
					<?php unset($lrow);?>
		 			
		 			
		 		</tbody>
		 	</table>
		 </div>
		 
		 
		 <table class="info">
		 	<tbody>
		 		<tr style="text-align: center;">
		 			<td colspan="2">
		 				<input class="input-info outof" type="text" style="text-align: center; margin-bottom: 12px; font-weight: 500; letter-spacing: 1px;font-size: 20px;" />
		 			</td>
		 		</tr>
		 		<tr>
		 			<td style="width: 50%;">
		 				Receiver: <input class="input-info" type="text" />
		 			</td>
		 			<td>
		 				Package Weight: <input class="input-info border" style="width: 133px;" type="text" />
		 			</td>
		 		</tr>
		 		<tr>
					<td style="width: 50%;">
						Total Units: <input id="totalSum" class="input-info" type="text" />
					</td>
					<td>
						Verified By: <input class="input-info border" style="width: 167px;" type="text" />
					</td>
				</tr>
		 	</tbody>
		 </table>
		
	</div>
	
	
	
	
	<table class="tactions hide-print">
		<thead>
			<tr>
				<th>Templates</th>
				<th>Volumes</th>
			</tr>
		</thead>
		
		
		<tbody>
			<tr>
				<td width="50%">
					
					<div>
						100mg
						<button id="btn100on" class="xbtn hide-print">On</button>
						<button id="btn100off" class="xbtn hide-print">Off</button>
					</div>
					<div>
						250mg
						<button id="btn250on" class="xbtn hide-print">On</button>
						<button id="btn250off" class="xbtn hide-print">Off</button>
					</div>
					<div>
						All
						<button id="btnAllon" class="xbtn hide-print">On</button>
						<button id="btnAlloff" class="xbtn hide-print">Off</button>
					</div>
				</td>
				<td>
					<button id="btnX10" class="xbtn hide-print">10's</button> <br />
					<button id="btnX20" class="xbtn hide-print">20's</button><br />
					<button id="btnX40" class="xbtn hide-print">40's</button><br />
					<button id="btnX60" class="xbtn hide-print">60's</button><br />
					<button id="btnX80" class="xbtn hide-print">80's</button><br />
					<button id="btnX100" class="xbtn hide-print">100's</button>
				</td>
			</tr>
			<tr class="trFlavs">
				<td colspan="2">
					<?php $innerCount = 1; ?>
					<?php foreach($productrow as $lrow2):?>
						<button data-pid="<?php echo $lrow2->id?>" data-cat="<?php echo $lrow2->cid?>" value="<?php echo $lrow2->id?>" class="flavBtn hide-print"><?php echo $lrow2->title?></button>
						<?php $innerCount++; ?>
					<?php endforeach;?>
					<?php unset($lrow2);?>
					
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<button id="btnPrint" class="hide-print">Print</button>
				</td>
			</tr>
		</tbody>
	</table>
	
	
	<!-- ================================================
	jQuery Library
	================================================ -->
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
	<script type="text/javascript">
		
		
		function calculateSum() {
			
//			var allWhitesChecked = 1;
//			var allBlacksChecked = 1;
//			var allFlavs = 1;
//			
//			
//			// Check All
//			$(".product-row").each(function() {
//				//add only if the value is number
//				if(!$(this).hasClass('active')) {
//					allFlavs = 0;
//				}
//			});
//			if (allFlavs) {
//				$('#btnAllon').addClass("active");
//				$('#btnAlloff').removeClass("active");
//			}else {
//				
//				$('#btnAlloff').addClass("active");
//				$('#btnAllon').removeClass("active");
//			}
//			
//			
//			// Check Whites
//			$(".product-row.cat-1").each(function() {
//				//add only if the value is number
//				if(!$(this).hasClass('active')) {
//					allWhitesChecked = 0;
//				}
//				
//			});
//			if (allWhitesChecked) {
//				$('#btn100on').addClass("active");
//				$('#btn100off').removeClass("active");
//			}else {
//				$('#btn100on').removeClass("active");
//				$('#btn100off').addClass("active");
//			}
//			
//			
//			// Check blacks
//			$(".product-row.cat-2").each(function() {
//				//add only if the value is number
//				if(!$(this).hasClass('active')) {
//					allBlacksChecked = 0;
//				}
//			});
//			if (allBlacksChecked) {
//				$('#btn250on').addClass("active");
//				$('#btn250off').removeClass("active");
//			}else {
//				$('#btn250on').removeClass("active");
//				$('#btn250off').addClass("active");
//			}
			
			
			

			var wSum = 0;
			//iterate through each textboxes and add the values
			$(".active.cat-1 .amount").each(function() {
				//add only if the value is number
				if(!isNaN(this.value) && this.value.length!=0) {
					wSum += parseFloat(this.value);
				}
	
			});
			
			var bSum = 0;
			//iterate through each textboxes and add the values
			$(".active.cat-2 .amount").each(function() {
				//add only if the value is number
				if(!isNaN(this.value) && this.value.length!=0) {
					bSum += parseFloat(this.value);
				}
	
			});
			
			
			var cSum = 0;
			//iterate through each textboxes and add the values
			$(".active.cat-3 .amount").each(function() {
				//add only if the value is number
				if(!isNaN(this.value) && this.value.length!=0) {
					cSum += parseFloat(this.value);
				}
	
			});
			
			if ((wSum > 0 || bSum > 0) && cSum > 0) {
				cSum = "+" + cSum;
			}else if (cSum > 0) {
				cSum = cSum;
			}else {
				cSum = "";
			}
			
			if (wSum > 0 && bSum > 0) {
				bSum = "+" + bSum;
			}else if (bSum > 0) {
				bSum = bSum;
			}
			else {
				bSum = "";
			}
			
			
			//.toFixed() method will roundoff the final sum to 2 decimal places
			$("#totalSum").val(wSum + bSum + cSum);
			
			
			
			var input = document.querySelector('input'); // get the input element
			input.addEventListener('input', resizeInput); // bind the "resizeInput" callback on "input" event
			resizeInput.call(input); // immediately call the function
			
			function resizeInput() {
				this.style.width = this.value.length + "ch";
			}
		}
		
		
		$('.amount').on('input', function() { 
			calculateSum();
		});
		
		
		

		// Toggle each flavour
		$('.flavBtn').click(function(){
			var currFlav = $(this).data('pid');
			$(".product-table").find('[data-pid="'+ currFlav +'"]').toggleClass('active');
			$(this).toggleClass("active");
			
			calculateSum();
		});
		
		
		
		
		
		// Add all product labels
		$('#btnAllon').click(function(){
			$(".flavBtn").addClass('active');
			$(".product-row").addClass("active");
			
			
			calculateSum();

		});
		$('#btnAlloff').click(function(){
			$(".flavBtn").removeClass('active');
			$(".product-row").removeClass("active");
			calculateSum();

		});
		
		// 100
		$('#btn100on').click(function(){
			$(".product-table").find('[data-cat="1"]').addClass('active');
			$(".trFlavs").find('[data-cat="1"]').addClass('active');
			calculateSum();

		});
		$('#btn100off').click(function(){
			$(".product-table").find('[data-cat="1"]').removeClass('active');
			$(".trFlavs").find('[data-cat="1"]').removeClass('active');
			
			calculateSum();

		});
		
		// 250
		$('#btn250on').click(function(){
			$(".product-table").find('[data-cat="2"]').addClass('active');
			$(".trFlavs").find('[data-cat="2"]').addClass('active');
			
			calculateSum();

		});
		$('#btn250off').click(function(){
			$(".product-table").find('[data-cat="2"]').removeClass('active');
			$(".trFlavs").find('[data-cat="2"]').removeClass('active');
			
			calculateSum();

		});
		
		
		// change values to 10
		$('#btnX10').click(function(){
			$(".product-row input").val('10');
			
			calculateSum();
		});
		
		// change values to 20
		$('#btnX20').click(function(){
			$(".product-row input").val('20');
			
			calculateSum();
		});
		
		// change values to 40
		$('#btnX40').click(function(){
			$(".product-row input").val('40');
			
			calculateSum();
		});
		
		// change values to 60
		$('#btnX60').click(function(){
			$(".product-row input").val('60');
			
			calculateSum();
		});
		
		// change values to 80
		$('#btnX80').click(function(){
			$(".product-row input").val('80');
			
			calculateSum();
		});
		
		// change values to 40
		$('#btnX100').click(function(){
			$(".product-row input").val('100');
			
			calculateSum();
		});
		
		// Print label
		$('#btnPrint').click(function(){
		    window.print();
		});
		
		
	</script>

</body>

</html>
