/* Sidebar Menu*/
$(document).ready(function() {
	$('.nav > li.nested > a').click(function() {
		if ($(this).attr('class') != 'active') {
			$('.nav li ul').slideUp(100);
			$('.nav li.nested > a').removeClass('active');
			$(this).next().slideToggle(100);
			$(this).addClass('active');
		} else {
			$('.nav li ul').slideUp(100);
			$(this).removeClass('active');
		}
	});
});

/* Top Stats Show Hide */
$(document).ready(function() {
	$("#topstats").click(function() {
		$(".topstats").slideToggle(100);
	});
});


/* Sidepanel Show-Hide */
$(document).ready(function() {
	$(".sidepanel-open-button").click(function() {
		$(".sidepanel").toggle(100);
	});
});

/* Sidebar Show-Hide On Mobile */
$(document).ready(function() {
	$(".sidebar-open-button-mobile").click(function() {
		$(".sidebar").toggle(150);
	});
});


/* Sidebar Show-Hide */
$(document).ready(function() {

	$('.sidebar-open-button').on('click', function() {
		if ($('.sidebar').hasClass('hidden')) {
			$('.sidebar').removeClass('hidden');
			$('.content').css({
				'marginLeft': 250
			});
		} else {
			$('.sidebar').addClass('hidden');
			$('.content').css({
				'marginLeft': 0
			});
		}
	});

});




/* ===========================================================
PANEL TOOLS
===========================================================*/
/* Minimize */
$(document).ready(function() {
	$(".panel-tools .minimise-tool").click(function(event) {
		$(this).parents(".panel").find(".panel-body").slideToggle(100);
		return false;
	});
	$(".panel-compact .panel-title").click(function(event) {
		$(this).parents(".panel").find(".panel-body").slideToggle(100);
		return false;
	});
	
	/* Close */
	$(".panel-tools .closed-tool").click(function(event) {
		$(this).parents(".panel").fadeToggle(400);

		return false;
	});
	
	/* Search */
	$(".panel-tools .search-tool").click(function(event) {
		$(this).parents(".panel").find(".panel-search").toggle(100);

		return false;
	});

	/* expand */
	$('.panel-tools .expand-tool').on('click', function() {
		if ($(this).parents(".panel").hasClass('panel-fullsize')) {
			$(this).parents(".panel").removeClass('panel-fullsize');
		} else {
			$(this).parents(".panel").addClass('panel-fullsize');
		}
	});

});


/* ===========================================================
Widget Tools
===========================================================*/


/* Close */
$(document).ready(function() {
	$(".widget-tools .closed-tool").click(function(event) {
		$(this).parents(".widget").fadeToggle(400);

		return false;
	});

});


/* expand */
$(document).ready(function() {

	$('.widget-tools .expand-tool').on('click', function() {
		if ($(this).parents(".widget").hasClass('widget-fullsize')) {
			$(this).parents(".widget").removeClass('widget-fullsize');
		} else {
			$(this).parents(".widget").addClass('widget-fullsize');

		}
	});

});

/* Kode Alerts */
/* Default */
$(document).ready(function() {
	$(".kode-alert .closed").click(function(event) {
		$(this).parents(".kode-alert").fadeToggle(350);

		return false;
	});

});


/* Click to close */
$(document).ready(function() {
	$(".kode-alert-click").click(function(event) {
		$(this).fadeToggle(350);

		return false;
	});

});



/* Tooltips */
$(function() {
	$('[data-toggle="tooltip"]').tooltip()
})

/* Popover */
$(function() {
	$('[data-toggle="popover"]').popover()
})


/* Page Loading */
$(document).ready(function() {
	$(".loading").fadeOut(750);
})


/* Update Fixed */
/* Version 1.2 */
$('.profilebox').on('click', function() {
	$(".sidepanel").hide();
})


$(document).ready(function() {

	// Disable / Enable submit button

	$("input").keyup(function() {
		$('button[name=dosubmit]').prop('disabled', false);
	});

	$("input").change(function() {
		$('button[name=dosubmit]').prop('disabled', false);
	});

	$("body").on("click", "textarea, .note-editor", function() {
		$('button[name=dosubmit]').prop('disabled', false);
	});

	$('#status').change(function() {
	    if (this.value == '3') {
	    	$('#notify').val("1");
	    	$(".kode-alert").hide();
	    	$("#alertShipped").fadeToggle(350);
	    }
	    else if (this.value == '1') {
	    	$('#notify').val("1");
	    	$(".kode-alert").hide();
	    	$("#alertBoxed").fadeToggle(350);
	    }
	    else {
	    	$('#notify').val("0");
	    	$(".kode-alert").hide();

	    }
	});

	$('input:radio[name=active]').change(function() {
	    if (this.value == '1') {
	        $('#notify').val("1");
	    }
	    else {
	    	$('#notify').val("0");
	    }
	});
	
	
	scrollPosition = $(document).height();

	/* == Master Form == */
	$('body').on('click', 'button[name=dosubmit]', function() {

		function showLoader() {
			$('.css-loading').show();
			$('#msgholder .kode-alert').hide();
			$('button[name=dosubmit]').prop('disabled', true);
		}

		function showResponse(json) {
			$("#msgholder").html(json.message);
			$('button[name=dosubmit]').prop('disabled', false);
			$('.css-loading').hide();
			$('#msgholder').show();
			var str = json.message;
		}

		var options = {
			target: "#msgholder",
			beforeSubmit: showLoader,
			success: showResponse,
			type: "post",
			url: "controller.php",
			dataType: 'json'
		};

		$('.form_submission').ajaxForm(options).submit();
	});


	// Form Validation
	function showResponse() {
		$("#msgholder").html('<div class="kode-alert kode-alert-icon alert6-light animated fast fadeIn"> <i class="fa fa-warning"></i> Make sure all required fields were entered correctly</div>');
		$("body").animate({
			scrollTop: scrollPosition
		}, '400');
	}
	// Javascript form validation
	$('.form_submission').validetta({
		realTime: true,
		display: 'inline',
		errorTemplateClass: 'validetta-inline',
		errorClose: false,
		onError: showResponse
	});

	//$('#search').hideseek();

	/* SUMMERNOTE*/
	$('#summernote').summernote({
		toolbar: [
			['style', ['style']],
			['style', ['bold', 'italic', 'underline', 'clear', 'link']],
			['font', ['strikethrough', 'superscript', 'subscript']],
			['fontsize', ['fontsize']],
			['para', ['ul', 'ol', 'paragraph']],
			['fullscreen', ['fullscreen', 'codeview']],
			['help', ['help']],
		]
	});

	/* SUMMERNOTE*/
	$('#summernote-second').summernote({
		toolbar: [
			['style', ['style']],
			['style', ['bold', 'italic', 'underline', 'clear', 'link']],
			['font', ['strikethrough', 'superscript', 'subscript']],
			['fontsize', ['fontsize']],
			['para', ['ul', 'ol', 'paragraph']],
			['fullscreen', ['fullscreen', 'codeview']],
			['help', ['help']],
		]
	});
	
	/* SUMMERNOTE*/
	$('#summernote-full').summernote({
		height: 600,
		toolbar: [
			['style', ['style']],
			['font', ['bold', 'italic', 'underline', 'clear']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['table', ['table']],
			['insert', ['link', 'picture', 'hr']],
			['view', ['fullscreen', 'codeview']],
			['help', ['help']]
		]
	});

	$('#validuntil').daterangepicker({
		singleDatePicker: true,
		locale: {
	        format: 'MM/DD/YYYY'
	    }
	}, function(start, end, label) {
		console.log(start.format('YYYY-MM-DD'));
	});

	$('#created').daterangepicker({
		singleDatePicker: true
	}, function(start, end, label) {
		console.log(start.toISOString(), end.toISOString(), label);
	});

  //Coupon applied button click
  $( document ).on( "change", "input[name = 'coupon_applied_on']", function () {
      if($(this).val() == '0'){
          $('.product_list_hs').hide();
      }else{
          $('.product_list_hs').show();
      }
  });

	//Multiselect click
	if($('#btnRight').length > 0){
	    $('#btnAllRight').click(function (e) {
	        $('select').moveAllToListAndDelete('#lstBox1', '#lstBox2');
	        get_selected_product_list();
	        e.preventDefault();
	    });
	    $('#btnRight').click(function (e) {
	        $('select').moveToListAndDelete('#lstBox1', '#lstBox2');
	        get_selected_product_list();
	        e.preventDefault();
	    });
	    $('#btnLeft').click(function (e) {
	        $('select').moveToListAndDelete('#lstBox2', '#lstBox1');
	        get_selected_product_list();
	        e.preventDefault();
	    });
	    $('#btnAllLeft').click(function (e) {
	        $('select').moveAllToListAndDelete('#lstBox2', '#lstBox1');
	        get_selected_product_list();
	        e.preventDefault();
	    });
	}
        get_selected_product_list();
});

function get_selected_product_list(){
    var option_all = $("#lstBox2 option").map(function () {
        return $(this).val();
    }).get().join(',');
    $('#hdnProductList').val(option_all);
}


$(".form-blind").click(function(event) {
	$(".form-blind").show();
	$(this).hide();
});



/* == Delete Modal == */
$('body').on('click', '.deleteBtn', function() {
	
	var id = $(this).data('id');
	var name = $(this).data('name');
	var title = $(this).data('title');
	var option = $(this).data('option');
	var extra = $(this).data('extra');
	var parent = $(this).parent().parent();
	
	swal({
		title: "Are you sure?",
		text: "You will not be able to recover from this!",
		buttons: {
		    cancel: "Cancel",
		    catch: {
		      text: "Yes, delete it!",
		      value: "catch",
		    }
		},
	})
	.then((value) => {
		switch (value) {
			case "catch":
				$.ajax({
					type: 'post',
					url: "controller.php",
					dataType: 'json',
					data: {
						id: id,
						delete: option,
						extra: extra ? extra : null,
						title: encodeURIComponent(name)
					},
					beforeSend: function() {
						parent.animate({
							'backgroundColor': '#FFBFBF'
						}, 400);
					},
					success: function(json) {
						parent.fadeOut(400, function() {
							parent.remove();
						});
					}

				});
				swal({
					text: "Deletion successfull.",
					icon: "success",
					buttons: {
					    catch: {
					      text: "Ok",
					      value: "catch",
					    }
					},
				})
			break;
		
			default:
			swal("Nothing's been changed.");
		}
	});
});