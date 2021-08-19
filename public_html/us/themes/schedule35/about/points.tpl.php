<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "about?p=points"; ?>
<?php include ("nav-about.tpl.php"); ?>
<div class="wrapper-add">
	
	
	
	<section id="story" class="wrapper padded text-center container max-width narrow t30">


		<h1 class="t0">Stick to it. We'll reward you for it.</h1>
		
		<div class="text-left">
			<p>Experiencing the long-term benefits of microdosing is a journey. We also understand your dollars are hard-earned. <?php echo $core->company; ?> Points keeps extra cash in your wallet while you continue your path to a better you.</p>
			
			<div class="row">
				
				<div class="col-sm-3">
					<img style="max-width: 142px;margin: 0 auto;display: block;" src="<?php echo THEMEURL;?>/assets/img/about/ico_wallet2.svg" alt="" />
				</div>
				<div class="col-sm-9">
					<p>There are <strong>many ways to earn points</strong> and many ways to use points too...</p>
				</div>
				
			</div>

		</div>
		
		
		
		
	</section>
		
	<section class="wrapper text-center container max-width">
		<!-- Place somewhere in the <body> of your page -->
		
		<h2 class="p48">How To Earn Points</h2>
		
		<div id="carousel" class="flexslider tablet-hide">
			<ul class="slides slides-nav container p18">
				<li>
					<img class="icon" src="<?php echo THEMEURL;?>/assets/img/icons/points_program/pp_purchase.svg" />
					<span style="font-size: 15px;">Make a Purchase</span>
				</li>
				<li>
					<img class="icon" src="<?php echo THEMEURL;?>/assets/img/icons/points_program/pp_invite.svg" />
					<span style="font-size: 15px;">Invite a friend</span>
				</li>
				<li>
					<img class="icon" src="<?php echo THEMEURL;?>/assets/img/icons/points_program/pp_post.svg" />
					<span style="font-size: 15px;">Write a Comment</span>
				</li>
			<!-- items mirrored twice, total of 12 -->
			</ul>
		</div>
		<div id="slider" class="flexslider">
			<ul class="slides">
				<li>
					<div class="slide-earn max-width narrow2">
						<h5 class="t6 p30">Make a Purchase</h5>
						<h3 class="t18 p18"> Earn 100 - 200 pts</h3>
						<span>for every item in your cart during checkout.</span>
					</div>
				</li>
				<li>
					<div class="slide-earn max-width narrow2">
						<h5 class="t6 p30">Invite a Friend</h5>
						<h3 class="t18 p18">Earn 25 pts</h3>
						<span>for every friend who signs up using your <a href="<?php echo SITEURL;?>/profile?p=referrals">invite code</a>.</span>
					</div>
				</li>
				<li>
					<div class="slide-earn max-width narrow2">
						<h5 class="t6 p30">Write a Comment</h5>
						<h3 class="t18 p18">Earn 5 pts</h3>
						<span>for every comment you write on <a href="<?php echo SITEURL;?>/blog">the blog</a>.</span>
					</div>
				</li>
				<!-- items mirrored twice, total of 12 -->
			</ul>
		</div>
		
		
	</section>
	
	
	<section class="wrapper text-center container max-width narrow">
		<h2 class="t60 p30">How To Redeem Points</h2>
		
		<div class="text-left p42">
			<p>Points are worth $0.01 each. You can select Points during checkout to complete a purchase.</p>
		</div>
		
		<div style="padding: 60px; border: 1px solid #ccc;">
			<h3 class="t0 p30">
				<span id="output">3000</span> pts = $<span id="output_packs">30.00</span>
			</h3>
			
			<input type="range" value="3000" step="1" min="100" max="15000">
			
			<h6 class="t24">*Approximate value. Tax and shipping not included in calculations.</h6>
		</div>
		
		
		
	</section>
		
	<section class="wrapper padded text-center container max-width narrow">
		
		<div class="text-center">
			
			<p class="t60"><strong>For more information on Points <a href="<?php echo SITEURL;?>/faqs#faq-points">visit&nbsp;the&nbsp;FAQs</a>.</strong></p>

		</div>

	</section>
	
</div>

<?php include ("ready.tpl.php"); ?>
