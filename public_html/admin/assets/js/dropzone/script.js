$('body').on('click', 'a.imgdelete', $.proxy(function (e) {
    this.$item = e.currentTarget;

    var id = $(this.$item).data('id');
    var name = $(this.$item).data('name');
    var parent = $(this.$item).closest('.item');
    
    $.ajax({
        type: 'post',
        url: "controller.php",
        dataType: 'json',
        data: {
            id: id,
            delete: 'deleteGalleryImage',
            title: encodeURIComponent(name)
        },
        beforeSend: function () {
            parent.animate({
                'backgroundColor': '#FFBFBF'
            }, 400);
        },
        success: $.proxy(function (json) {
            parent.fadeOut(400, function () {
                parent.remove();
            });
        }, this)

    });

}, this));




/* == Inline Edit == */
$('body').on('focus', 'div[contenteditable=true]', function() {
	$(this).data("initialText", $(this).text());
	$('div[contenteditable=true]').not(this).removeClass('active');
	$(this).toggleClass("active");
}).on('blur', 'div[contenteditable=true]', function() {
	if ($(this).data("initialText") !== $(this).text()) {
		title = $(this).text();
		type = $(this).data("edit-type");
		id = $(this).data("id")
		key = $(this).data("key")
		path = $(this).data("path")
		$this = $(this);
		$.ajax({
			type: "POST",
			url: "controller.php",
			data: ({
				'title': title,
				'type': type,
				'key': key,
				'path': path,
				'id': id,
				'quickedit': 1
			}),
			beforeSend: function() {
				$this.animate({
					opacity: 0.5
				}, 100);
			},
			success: function(res) {
				$this.animate({
					opacity: 1
				}, 800);
				setTimeout(function() {
					$this.html(res).fadeIn(200);
				}, 100);
			}
		})
	}
});

$(function(){

    var ul = $('#upload ul');
    $('#drop a').click(function () {
        $(this).parent().find('input').click();
    });

    $('#upload').fileupload({
        dropZone: $('#drop'),
        limitMultiFileUploads: 5,
        sequentialUploads: true,
        add: $.proxy(function (e, data) {
            var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48" data-fgColor="#15a5fb" data-readOnly="1" data-bgColor="#eff2f8" /><p><small></small></p><span></span></li>');

            tpl.find('p').text(data.files[0].name)
                .append('<small></small>')
                .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

            data.context = tpl.appendTo(ul);
            tpl.find('input').knob();
            tpl.find('span').click(function () {

                if (tpl.hasClass('working')) {
                    jqXHR.abort();
                }

                tpl.fadeOut(function () {
                    tpl.remove();
                });

            });
            var jqXHR = data.submit().success($.proxy(function (result) {
                var json = JSON.parse(result);
                var status = json['status'];

                if (status == 'error') {
                    data.context.addClass('error');
                    data.context.find('span').addClass('ferror');
                    data.context.find('small').append(json['msg']);
                } else {
                	$("#msgholder").html(json['msg']);
                }
                //console.log(json)
            }, this));
        }, this),

        progress: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            data.context.find('input').val(progress).change();
            if (progress == 100) {
                data.context.removeClass('working');
            }
        },

        fail: function (e, data) {
            data.context.addClass('error');
        },

    });


    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function (e) {
    	var dropZone = $('#drop'),
    		timeout = window.dropZoneTimeout;
    	if (!timeout) {
    		dropZone.addClass('in');
    	} else {
    		clearTimeout(timeout);
    	}
    	var found = false,
    		node = e.target;
    	do {
    		if (node === dropZone[0]) {
    			found = true;
    			break;
    		}
    		node = node.parentNode;
    	} while (node != null);
    	if (found) {
    		dropZone.addClass('hover');
    	} else {
    		dropZone.removeClass('hover');
    	}
    	window.dropZoneTimeout = setTimeout(function() {
    		window.dropZoneTimeout = null;
    		dropZone.removeClass('in hover');
    	}, 100);
    });

    // Helper function that formats the file sizes
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }

});