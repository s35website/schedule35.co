<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
		
	$pagenameModifier = "Blog";
?>
<?php $_SESSION["pageurl"] = "article?blog=" . $row->slug;?>
<?php $commentrow = $content->getComments($row->id);?>
<?php require('components/head.tpl.php'); ?>

<body class="fixed-header <?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>
	
	<div class="main article" data-id="<?php echo($row->id); ?>">
		
		
		
		<?php if($row):?>

		<section class="wrapper padded text-center container max-width narrow" style="padding-bottom: 30px;">
			
			<h1 class="t0"><?php echo $row->title;?></h1>
			<div class="blog-meta">
				<a class="author"><?php echo $row->author;?></a>
				<span class="date"><?php echo date("M d, Y", strtotime($row->created));?></span>
				<span class="reading-time"><?php echo(calcReadTime($row->body));?> read</span>
			</div>
			<?php if($row->active == 0 && $user->hasAdminAccess()):?>
			<p class="active p0">
				<em>Post is in preview mode. Click <a target="_blank" href="<?php echo SITEURL;?>/admin/index.php?do=blog&action=edit&id=<?php echo($row->id); ?>">here to edit</a></em>
			</p>
			<?php elseif($user->hasAdminAccess()):?>
			<p class="active p0">
				<em>Post is live. Click <a target="_blank" href="<?php echo SITEURL;?>/admin/index.php?do=blog&action=edit&id=<?php echo($row->id); ?>">here to edit</a></em>
			</p>
			<?php endif;?>
			
		</section>
		
		<section class="wrapper container max-width blog-img">
			
			<?php if(sanitize($row->herovideo)):?>
			<a class="blog-video-button" id="playVideo">
				<i class="ico-youtube"></i>
			</a>
			<?php endif;?>
			
			<div class="placeholder" data-large="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo UPLOADURL;?>news_images/<?php echo ($row->image);?>&amp;w=1600&amp;h=900&amp;s=1&amp;c=t1">
			  <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo UPLOADURL;?>news_images/<?php echo ($row->image);?>&amp;w=32&amp;h=18&amp;s=1&amp;a=t1" class="img-small" alt='<?php echo $row->title;?>'>
			</div>
			
			<?php if(sanitize($row->herovideo)):?>
			<div class="bg-video">
				<iframe id="video" src="https://www.youtube.com/embed/<?php echo $row->herovideo;?>" frameborder="0" allowfullscreen></iframe>
			</div>
			<?php endif;?>
			
		</section>
		
		<section class="wrapper blog-body text-center container max-width narrow">
			<div class="text-left">
				<?php echo $body = cleanOut($row->body);?>
			</div>
		</section>
		
		<div class="sharethis-inline-share-buttons"></div>
		
		
		<!--- COMMENT SECTION --->
		<section class="wrapper padded text-left container max-width narrow2 border-top t60" style="padding-bottom: 60px;">
			<?php if($user->logged_in):?>
			<form class="form-validetta auth-form comment-box" accept-charset="UTF-8" method="post" autocomplete="off">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="t0">Comment <span>(earn 5 points)</span></h3>
					</div>
					<div class="col-sm-12 t12">
						
						<div class="row">
							<div class="col-sm-12">
								<textarea class="comment-box-body required" id="body" name="body" rows="18" data-validetta="required,minLength[3]"></textarea>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12">
								<input type="checkbox" id="private" name="private" value="1"><label for="private"><span>Keep identity private.</span></label>
							</div>
						</div>
						<div class="row t30">
							<div class="col-sm-12">
								<input type="text" id="captcha" name="captcha" class="required" data-validetta="required,minLength[2]" placeholder="Captcha">
								<img id="captcha-append" class="captcha-append" src="<?php echo SITEURL;?>/lib/captcha.php" alt="captcha" />
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12">
								
								<input name="addComment" type="hidden" value="1">
								
								<button data-nid="<?php echo($row->id); ?>" data-uid="<?php echo $urow->id;?>" id="btnAddComment" class="btn-quantum btn-loader btn full-width primary t18 p18" type="submit">
									<span>Submit</span>
									<div class="circle-loader"></div>
								</button>
								
							</div>
						</div>
					</div>
				</div>
			</form>
			<?php else:?>
			<div class="comment-box">
				<p class="t0 text-center">To comment please <a href="<?php echo SITEURL;?>/login">sign in</a>.</p>
			</div>
			<?php endif;?>
			<div class="comment-section">
				<div class="loading-overlay">
					<div class="circle-loader"></div>
				</div>
				<?php if(!$commentrow):?>
				<p id="comment-section-empty" class="text-center t42">There are currently no comments.</p>
				<?php else:?>
				<?php foreach ($commentrow as $cmrow):?>
				<div class="comment border-bottom" data-id="<?php echo($cmrow->id); ?>">
					<div class="row p6">
						<div class="col-sm-12">
							<span class="comment-user">
								<span class="comment-user-name">
									<?php
										if (isset($urow->id)) {
											if ($user->logged_in && $cmrow->uid == $urow->id) {
												echo('(YOU)');
											}
										}
									?>
									<?php if($cmrow->private):?>
									 anonymous says
									<?php else:?>
									<?php echo($cmrow->fullname); ?> says
									<?php endif;?>
								</span>
								<span class="comment-date"><?php echo date("F j, Y, g:i a", strtotime($cmrow->created));?></span>
							</span>
							<?php if(isset($urow->id)):?>
							<?php if($cmrow->uid == $urow->id):?>
							<a class="comment-remove ico-times" data-id="<?php echo($cmrow->id); ?>"></a>
							<?php endif;?>
							<?php endif;?>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12">
							<p class="comment-body">
								<?php echo($cmrow->body); ?>
							</p>
						</div>
					</div>
					
					
					
				</div>
				<?php endforeach;?>
				<?php unset($cmrow);?>
				<?php endif;?>
			</div>
			
		</section>
		
		
		<?php else:?>
		
		<section class="wrapper padded text-center container max-width narrow" style="padding-bottom: 30px;">
			
			<h1 class="t0">Oops...something went wrong with this article</h1>
			<p>Please contact us at <a href="mailto:<?php echo $core->support_email; ?>"><?php echo $core->support_email; ?></a> for help.</p>
			
		</section>
		
		<?php endif;?>
		
		<section id="ready" class="wrapper text-center">
			<div class="container max-width">
				<h3 class="p12 t0">
					Ready for another article?
				</h3>
				<div class="row">
					<div class="col-sm-12">
						<a href="<?php echo SITEURL;?>/blog" class="btn med primary t30">Back to Blog</a>
						<!--<a href="#" class="btn med primary t30">Contact Us</a>-->
					</div>
				</div>
			</div>
		</section>
		

	</div>


	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>
	
	<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5c79a6b8d11c6a0011c48191&product=inline-share-buttons' async='async'></script>
	
	<script type="text/javascript">
		$('body').on('click', '#btnAddComment', function() {
			
			event.preventDefault();
			
			var private = $("#private").is(":checked");
			private = +private;
			var user_name = "";
			var dis_msg ="";
			
			if (!$.trim($("#body").val()).length) {
				$("#body").parent().addClass("_error");
			}else {
				$("#body").parent().removeClass("_error");
			}
			
			if (!$.trim($("#captcha").val()).length) {
				$("#captcha").parent().addClass("_error");
			}else {
				$("#captcha").parent().removeClass("_error");
			}
			
			$.ajax({
				type: "post",
				dataType: 'json',
				url: SITEURL + "/ajax/comment.php",
				data: {
					'addComment': 1,
					'nid': $(this).attr("data-nid"),
					'uid': $(this).attr("data-uid"),
					'private': private,
					'body': $("#body").val(),
					'captcha': $("#captcha").val()
				},
				beforeSend: function() {
					$(".comment-box").addClass("disabled");
					$(".loading-overlay").show();
				},
				success: function(json) {
					$("#captcha-append").attr("src", SITEURL + "/lib/captcha.php?"+(new Date()).getTime());
					$(".loading-overlay").hide();
					$(".comment-box").removeClass("disabled");
					$(".btn-quantum").removeClass("loading");
					$(".btn-quantum").removeClass("disabled");
					
					if (json.captchastatus == 0) {
						$("#captcha").parent().addClass("_error");
					}
					if (json.affected) {
						$("#javascript-box").append(json.message);
						
						if (private == 1) {
							user_name = "(YOU) anonymous says";
						}else {
							user_name = "(YOU) " + json.user_name + " says";
						}
						dis_msg = '<div class="comment highlight border-bottom" data-id="' + json.lastid + '"><div class="row p6"><div class="col-sm-12"><span class="comment-user"><span class="comment-user-name">';
						dis_msg += user_name;
						dis_msg += '</span><span class="comment-date">';
						dis_msg += json.user_date;
						dis_msg += '</span></span><a class="comment-remove ico-times" data-id="' + json.lastid + '"></a> </div></div><div class="row"><div class="col-sm-12"><p class="comment-body">';
						dis_msg += $("#body").val();
						dis_msg += '</p></div></div></div>';
						
						$(".comment-section").prepend(dis_msg);
						$("#comment-section-empty").remove();
						
						$("#header_points a").html(json.points_current + " pts");
						
						
						$("#header_points a").removeClass("pop").addClass("pop").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
							$(this).removeClass("pop");
						});
						
					}else {
						console.log("Error happened");
					}
					
					$("#captcha-append").attr("src", SITEURL + "/lib/captcha.php?"+(new Date()).getTime());
					
				},
				error: function(json) {
					$(".comment-box").removeClass("disabled");
					$("#captcha-append").attr("src", SITEURL + "/lib/captcha.php?"+(new Date()).getTime());
				}
			});
		});
		
		
		
		/* Comment Remove */
		$('.comment-section').on('click', '.comment-remove', function(){
			var item = $(this).closest(".comment");
			comment_id = item.attr("data-id");
			
			console.log(comment_id);
			
			$.ajax({
				type: "post",
				dataType: 'json',
				url: SITEURL + "/ajax/comment.php",
				data: {
					'removeComment': 1,
					'comment_id': comment_id
				},
				beforeSend: function() {
					$(".loading-overlay").show();
				},
				success: function(json) {
					$(".loading-overlay").hide();
					item.remove();
					console.log('Success: ' + json.message);
				},
				error: function(json) {
					console.log('Error: ' + json.message);
					$(".loading-overlay").hide();
				}
			});
		});
		
		<?php if(sanitize($row->herovideo)):?>
		/*Hero video play*/
		$('#playVideo').on('click', function() {
			$('.bg-video').css('z-index', '1000');
			$("#video")[0].src += "?autoplay=1";
			$("#video")[0].src += "&autoplay=1";
		});
		<?php endif;?>
	</script>

</body>

</html>
