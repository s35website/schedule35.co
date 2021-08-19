<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "blog"; ?>
<?php require('components/head.tpl.php'); ?>

<body id="page-blog" class="fixed-header <?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>
	
	
	<div class="main">
		<div class="wrapper-add" style="border-bottom: 1px solid #ececec;">
			<section class="wrapper padded text-center container max-width">
		
		
				<h1 class="t0">The Blog</h1>
				
				<!-- Shop content -->
				<?php if(!$row):?>
				<div class="text-left t72">
					
					<p><?php Filter::msgSingleError(Lang::$word->PAGE_ERROR);?></p>
					
				</div>
				<?php else:?>
				
				<div class="t60">
		
					<div class="row">
					
					
						<?php
						/* This is being used for infinite scroll and the ALL page initial load */
						$counter = 1;
						foreach($blogrow as $lrow):?>
						
					    <?php $url = ($core->seo) ? SITEURL . '/article/' . $lrow->slug . '/' : SITEURL . '/article?blog=' . $lrow->slug;?>
						
						<?php if($counter == 1):?>
						<div class="col-sm-12 blog" data-id="<?php echo $lrow->id;?>">
						<?php else:?>
						<div class="col-sm-12 col-md-6 blog" data-id="<?php echo $lrow->id;?>">
						<?php endif;?>
							
							<a class="blog-img" href="<?php echo $url;?>">
								<div class="placeholder" data-large="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo UPLOADURL;?>news_images/<?php echo ($lrow->image);?>&amp;w=1600&amp;h=900&amp;s=1&amp;a=t1">
								  <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo UPLOADURL;?>news_images/<?php echo ($lrow->image);?>&amp;w=32&amp;h=18&amp;s=1&amp;a=t1" class="img-small" alt='<?php echo $lrow->title;?>'>
								</div>
							</a>
							<div class="blog-info">
								<h3 class="p6 t12"><a href="<?php echo $url;?>"><?php echo $lrow->title;?></a></h3>
								<div class="blog-meta">
									<a class="author"><?php echo $lrow->author;?></a>
									<span class="date"><?php echo date("M d, Y", strtotime($lrow->created));?></span>
									<span class="reading-time"><?php echo(calcReadTime($lrow->body));?> read</span>
								</div>
							</div>
						</div>
						
						<?php $counter++; ?>
						<?php endforeach;?>
		
					</div>
		
				</div>
				
				<?php endif;?>
				
				
				<ul class="paging">
				    <?php
				    //Load pagination buttons
				    foreach ($buttons as $button) {
				        echo '<li><a href="' . $button['href'] . '" class="' . $button['class'] . '">' . $button['text'] . '</a></li>';
				    }
				    ?>
				</ul>
		
			</section>
		</div>
	</div>


	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>
	
</body>

</html>
