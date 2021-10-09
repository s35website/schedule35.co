<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "home"; ?>
<?php require('components/head.tpl.php'); ?>

<body class="header-active header-home header-light <?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>

	<div class="main homepage">
		
		<!-- Hero -->
		<section id="homepage-hero" style="background-color: #c7d2e4;">
			<div class="hero-wrapper contain max-width extended">
				<div class="container">

					<div class="hero-text left">
						<h5 class="accent-text">Experience</h5>
						<h1 class="t0">Microdose Shrooms</h1>
						<p>
							The next dimension in mind-body growth.
						</p>
						<a class="btn primary t18" href="<?php echo SITEURL;?>/shop">Explore Products</a>
					</div>
					
					<div class="hero-img-wrapper">
						<div class="hero-img-bg" style="background-image:url(<?php echo UPLOADURL;?>page_home/hero-handhold.jpg);"></div>
						<!--<img class="hero-img" src="<?php echo UPLOADURL;?>page_home/hero_girls3.jpg">-->
					</div>
					
				</div>
			</div>
		</section>
		
		
		<!-- Testimonials -->
		<section class="testimonial-container">
			<div class="cd-testimonials-wrapper cd-container">
				
				<ul class="flexslider cd-testimonials">
					<li>
						<div class="testimonial-content">
							
							<div class="cd-author">
								<img src="<?php echo UPLOADURL;?>page_home/companies/logo-forbes.png?v=1" alt="" />
							</div>
							
							<p>
								"promising potential in treating patients with mental health conditions."
							</p>
							
						</div>
					</li>
					
					
					<li>
						<div class="testimonial-content">
							
							<div class="cd-author">
								<img src="<?php echo UPLOADURL;?>page_home/companies/logo-rollingstone.png?v=1" alt="" />
							</div>
							
							<p>
								“It’s an extremely healthy alternative to Adderall,”
							</p>
							
						</div>
					</li>
					
					<li>
						<div class="testimonial-content">
							
							<div class="cd-author">
								<img src="<?php echo UPLOADURL;?>page_home/companies/logo-vogue.svg?v=1" alt="" />
							</div>
							
							<p>
								“What the microdosing allowed me to do is open up and have space between these components.”
							</p>
							
						</div>
					</li>
					
					
					<li>
						<div class="testimonial-content">
							
							<div class="cd-author">
								<img src="<?php echo UPLOADURL;?>page_home/companies/logo-time.png?v=1" alt="" />
							</div>
							
							<p>
								“you’re not going on a full-fledged trip down the rabbit hole; you’re just trying to harness your inner creativity more clearly.”
							</p>
							
						</div>
					</li>
					
					
					<li>
						<div class="testimonial-content">
							
							<div class="cd-author">
								<img src="<?php echo UPLOADURL;?>page_home/companies/logo-vox.png?v=1" alt="" />
							</div>
							
							<p>
								“With microdosing, people are getting the maximum benefit from the minimum amount, without becoming stoned, paranoid or lethargic”
							</p>
							
						</div>
					</li>
					
					<li>
						<div class="testimonial-content">
							
							<div class="cd-author">
								<img src="<?php echo UPLOADURL;?>page_home/companies/logo-complex.svg?v=1" alt="" />
							</div>
							
							<p>
								“microdosing can relieve depression, migraines and chronic-fatigue syndrome, and encourage out-of-the-box thinking.”
							</p>
							
						</div>
					</li>
					
					
				</ul>
			</div>
			<!-- cd-testimonials -->
		</section>
		
		
		
		
		
		
		<!-- Hero rewards -->
		<section id="homepage-superdose" style="background-color: #121212;">
			<div class="hero-wrapper cover" style="background-image: url('<?php echo UPLOADURL;?>/page_home/s35_dvsn-7.jpg');">
				
				<div class="overlay-shade" style="background: #121212; position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0.74;"></div>
				
				<div class="container">

					<div class="hero-text text-white center text-center" style="top: 48%;">
						<h1 class="t0">Superdocious</h1>
						<p>
							Experience the next level of freedom with 500mg's of shrooms.
						</p>
						
						<a href="<?php echo SITEURL;?>/item?itemname=superdose-500mg" class="btn white med primary t30">Purchase Now</a>
						
					</div>
					
				</div>
			</div>
		</section>
		
		<section class="flat-slides">
			
			<div class="row" style="font-size:1px;font-size:0;text-align:center;">
				
				<div class="col-sm-6 col-slide">
					<img src="<?php echo UPLOADURL;?>page_home/slide-loverdose2.jpg" alt="" />
				</div>
				<div class="col-sm-6 col-slide text-left">
					<div class="text-container">
						<h3>Love on demand.</h3>
						<p>The Loverdose delivers research-backed and all-natural ingredients to maintain your sexual health. Always be ready, any time.</p>
						
						<a href="<?php echo SITEURL;?>/item?itemname=loverdose-100mg" class="btn white primary t18">Purchase Now</a>
						
					</div>
				</div>
				
			</div>
			
			<div class="row mobile-reverse" style="font-size:1px;font-size:0;text-align:center;">
				
				<div class="col-sm-6 col-slide text-left">
					<div class="text-container">
						<h3>For life's tough battles.</h3>
						<p>This is for fighting for what you believe in, so make sure you keep your mind and body right to slay the dragons in your life.</p>
						<a href="<?php echo SITEURL;?>/item?itemname=superior-tonic-50mg" class="btn white primary t18">Purchase Now</a>
					</div>
				</div>
				<div class="col-sm-6 col-slide">
					<img src="<?php echo UPLOADURL;?>page_home/slide-superior.jpg" alt="" />
				</div>
				
				
			</div>
			
		</section>
		
		
		
		
		
		<!-- Instagram -->
		<section id="instagram-content" style="display: none;">
			<a href="https://www.instagram.com/<?php echo $core->social_instagram;?>" target="_blank" class="instagram-follow">
				<span class="ico-instagram"></span>
				<h5>Connect with <?php echo $core->company; ?></h5>
				<h3>@<?php echo $core->social_instagram;?></h3>
			</a>
			
		</section>
		
		
		<!-- Delivered -->
		<section id="hand-delivered" class="wrapper text-center bg-white">
			<div class="container max-width extended2">

				<h1>Your Schedule is Here</h1>

				<div class="row home-icons">

					<div class="col-sm-12 col-md-4">

						<div class="card">
							<div id="ico-local" class="icon">
								
								<img src="<?php echo UPLOADURL;?>page_home/ico/local.svg" alt="" />

							</div>

							<h4>Locally Sourced</h4>
							<p>Enjoy peace of mind knowing all products are made with locally sourced organic ingredients. </p>
						</div>

					</div>

					<div class="col-sm-12 col-md-4">

						<div class="card">

							<div id="ico-shipping" class="icon">
								<img src="<?php echo UPLOADURL;?>page_home/ico/delivery.svg" alt="" />

							</div>

							<h4>Easy Shipping</h4>
							<p>We’ll bring it to you. All of our products are shipped safely and discreetly right to your doorstep. </p>
						</div>

					</div>

					<div class="col-sm-12 col-md-4">

						<div class="card">

							<div id="ico-scale" class="icon">
								<img src="<?php echo UPLOADURL;?>page_home/ico/scales.svg" alt="" />
							</div>

							<h4>Accurate Dosages</h4>
							<p>In order to reap the benefits, it’s crucial that each one of our products contains the precise amount of psilocybin cubensis.</p>
						</div>

					</div>

				</div>

			</div>
		</section>
		
		
		
		
		
		
		
		
		<style>
			.bg-matrix {
				background: #0f173c;
				overflow: hidden;
				position: relative;
				height: 720px!important;
			}
			.bg-matrix * {
				color: #fff;
			}
				
				
			/* canvas style */
			.canvas-wrap {
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate3d(-50%, -50%, 0);
				width: 100%;
				height: 100%;
				-webkit-filter: url("#goo");
				filter: url("#goo");
				overflow: hidden;
			}
			
			canvas {
				display: block;
				width: 100%;
				height: 100%;
			}
			
			.bg-matrix-text {
				position: relative;
				top: 46%;
				transform: translateY(-50%);
				max-width: 50%;
				text-align: center;
				margin: 0 auto;
				z-index: 9;
			}
			
			.bg-matrix-text p {
				font-size: 21px;
				line-height: 36px;
			}
			
			@media (max-width: 767px) {
				.canvas-wrap {
					height: 800px;
				}
			}

		</style>
		
		<section class="bg-matrix" style="height: 1020px;">
			
			<div class="bg-matrix-text">
				<h1>Increase Your Brain Activity</h1>
				<p>Create new neuropaths in your brain by freeing it from its normal framework.</p>
				<a href="<?php echo SITEURL;?>/article?blog=creating-new-neuropaths-in-the-brain" class="btn white med primary t30">Read More</a>
			</div>
			
			<div class="canvas-wrap">
			    <canvas id="canvas">
			        canvas not support
			    </canvas>
			</div>
			<!-- filters -->
			<svg xmlns="http://www.w3.org/2000/svg" version="1.1">
			    <defs>
			    <filter id="goo">
			        <feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="12" />
			        <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="joint" />
			    </filter>
			    </defs>
			</svg>
			
		</section>
		
		
		<!-- Blog Feed -->
		<section id="blog-feed" class="wrapper text-center bg-white padded border-bottom">
			<div class="container max-width extended2">
			
				<h2 class="p12"><a href="<?php echo SITEURL;?>/blog">Latest from the blog</a></h2>
				<p class="p48"><strong>Earn 5 Points</strong> every time you comment on a post!</p>
				
				<div class="row">
					
					<?php foreach($blogrow as $brow):?>
					
					<?php $url = ($core->seo) ? SITEURL . '/article/' . $brow->slug . '/' : SITEURL . '/article?blog=' . $brow->slug;?>
					
					<a class="col-sm-6 col-md-4 blog" data-id="<?php echo $brow->id;?>" href="<?php echo $url;?>">
						
						<div class="blog-img" style="background-image: url('<?php echo UPLOADURL;?>news_images/<?php echo ($brow->image);?>');"> </div>
						
						
							<div class="blog-info">
								<h3 class="p6 t30"><?php echo $brow->title;?></h3>
								<div class="blog-meta">
									<span class="author"><?php echo $brow->author;?></span>
									<span class="date"><?php echo date("M d, Y", strtotime($brow->created));?></span>
									<span class="reading-time"><?php echo(calcReadTime($brow->body));?> read</span>
								</div>
							</div>
							
						
					</a>
					<?php endforeach;?>
					
				</div>
				
			</div>
			
		</section>
		
		
		
		
		<!-- Mailing list signup -->
		<section id="mail" class="wrapper text-center bg-blue">

			<div class="container max-width">

				<!--<h2>Get the Latest Updates</h2>-->
				<h3>Deals, news and other stuff delivered to your inbox</h3>
				<h4 class="t0">(Sign up and receive 5% off forever)</h4>
				
				<div id="mc_embed_signup" class="t30">

					<form action="https://schedule35.us19.list-manage.com/subscribe/post?u=db202d6a7b357e6f3fe124fec&amp;id=1a5ba00035" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
						<div id="mc_embed_signup_scroll">
							<div class="mc-field-group">
								<input type="email" value="" placeholder="Enter your e-mail address to subscribe" name="EMAIL" class="required email" id="mce-EMAIL"><button type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button btn-mail"><span class="ico-email-send"></span></button>
							</div>
							<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
							<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_db202d6a7b357e6f3fe124fec_1a5ba00035" tabindex="-1" value=""></div>
						</div>
					</form>
				</div>

			</div>

		</section>
		
		
		<!-- Ready -->
		<section id="ready" class="wrapper text-center" style="display: none;">
			<div class="container max-width">
				<h2 class="p12 t36">
					Get your taste buds ready.
				</h2>
				<div class="row">
					<div class="col-sm-12">
						<a href="<?php echo SITEURL;?>/shop" class="btn med primary t30">Shop <?php echo $core->company; ?>'s</a>
						<!--<a href="#" class="btn med btn primary t30">Contact Us</a>-->
					</div>
				</div>
			</div>
		</section>
		
	</div>


	<?php require('components/footer.tpl.php'); ?>
	<?php require('components/scripts.tpl.php'); ?>
	

	<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>

	<script type="text/javascript">

  
		//Testimonials
		$(document).ready(function($) {
			//create the slider
			$(".cd-testimonials-wrapper").flexslider({
				selector: ".cd-testimonials > li",
				animation: "slide",
				controlNav: true,
				slideshow: false,
				smoothHeight: true,
				start: function() {
					$(".cd-testimonials").children("li").css({
						opacity: 1,
						position: "relative"
					});
				}
			});
			
		});
		
		
		// YouTube BG Video
		// Loads the YouTube IFrame API JavaScript code.
		var tag = document.createElement('script');
		tag.src = "https://www.youtube.com/iframe_api";
		// Inserts YouTube JS code into the page.
		var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
		
		var player;
		
		// onYouTubeIframeAPIReady() is called when the IFrame API is ready to go.
		function onYouTubeIframeAPIReady() {
		  player = new YT.Player('player', {
		    videoId: 'gKGNyh2r08w', // the ID of the video (mentioned above)
		    playerVars: {
		      autoplay: 0, // start automatically
		      controls: 0, // don't show the controls (we can't click them anyways)
		      modestbranding: 0, // show smaller logo
		      loop: 0 // loop when complete
		    }
		  });
		}
		
		
		$('#playVideo').on('click', function() {
			$('.bg-video').css('z-index', '1000');
		    $("#video")[0].src += "?autoplay=1";
		});
		
		
		
		
		
		
		
		class Particle {
	  /**
	   * コンストラクター
	   * @param {Number} x
	   * @param {Number} y
	   * @param {Number} radius
	   * @param {Number} angle
	   * @param {Number} distance
	   */
	  constructor(canvas, radius, angle, distance, color) {
	    this.canvas = canvas;
	    this.radius = radius;
	    this.angle = angle;
	    this.distance = distance;
	    this.color = color;
	    this.x = 0;
	    this.y = 0;
	    this.speed = 1;
	  }
	  update() {
	    this.distance += -this.speed;
	    this.angle += 0.01;
	    this.x = this.canvas.width / 2 + Math.cos(this.angle) * this.distance;
	    this.y = this.canvas.height / 2 + Math.sin(this.angle) * this.distance;
	    if (this.x > this.canvas.width) {
	      this.distance *= -1;
	    }
	    if (this.x < 0) {
	      this.distance *= -1;
	    }
	    if (this.y > this.canvas.height) {
	      this.distance *= -1;
	    }
	    if (this.y < 0) {
	      this.distance *= -1;
	    }
	  }
	}
	
	window.onload = function () {
	  var canvas = document.querySelector("canvas"),
	    ctx = canvas.getContext("2d"),
	    width = (canvas.width = window.innerWidth),
	    height = (canvas.height = window.innerHeight),
	    centerX = width / 2,
	    centerY = height / 2,
	    particles = [],
	    numObjects = 40,
	    slice = (Math.PI * 2) / numObjects,
	    colors = ["#CFDBD7", "#F1ADAE", "#09BEAF"];
	
	  window.onresize = () => {
	    width = canvas.width = window.innerWidth;
	    height = canvas.height = window.innerHeight;
	  };
	
	  // RequestAnimationFrame
	  (function () {
	    var requestAnimationFrame =
	      window.requestAnimationFrame ||
	      window.mozRequestAnimationFrame ||
	      window.webkitRequestAnimationFrame ||
	      window.msRequestAnimationFrame;
	    window.requestAnimationFrame = requestAnimationFrame;
	  })();
	
	  //Utility Function
	  function randomIntFromRange(min, max) {
	    return Math.floor(Math.random() * (max - min + 1) + min);
	  }
	  function randomColor(colors) {
	    return colors[Math.floor(Math.random() * colors.length)];
	  }
	
	  //Center Ball
	  function centerBall() {
	    ctx.beginPath();
	    ctx.arc(centerX, centerY, 90, 0, Math.PI * 2);
	    var grd = ctx.createRadialGradient(
	      centerX,
	      centerY,
	      0,
	      centerX,
	      centerY,
	      120
	    );
	    grd.addColorStop(0.004, "rgba(255, 239, 239, 1.000)");
	    grd.addColorStop(0.324, "rgba(244, 168, 168, 1.000)");
	    grd.addColorStop(0.692, "rgba(255, 127, 80, 1.000)");
	    grd.addColorStop(1.0, "rgba(51, 51, 51, 1.000)");
	    ctx.fillStyle = grd;
	    ctx.fill();
	  }
	
	  for (let i = 0; i < numObjects; i++) {
	    particles.push(
	      new Particle(
	        canvas,
	        Math.random() * 10 + 16,
	        i * slice,
	        width * Math.random(),
	        randomColor(colors)
	      )
	    );
	  }
	
	  render();
	  function render() {
	    ctx.clearRect(0, 0, width, height);
	    centerBall();
	    for (let i = 0; i < numObjects; i++) {
	      var p = particles[i];
	      p.update();
	      ctx.save();
	      ctx.beginPath();
	      ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2, false);
	      ctx.fillStyle = p.color;
	      ctx.fill();
	      ctx.restore();
	    }
	    requestAnimationFrame(render);
	  }
	};

	</script>
	
	
	<!-- Mailing Modal -->
	<?php include('components/modal-mailinglist.tpl.php'); ?>

</body>

</html>
