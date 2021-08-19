<?php
	if (!defined("_VALID_PHP"))
		die('Direct access to this location is not allowed.');
?>
<?php $_SESSION["pageurl"] = "home"; ?>
<?php require('components/head.tpl.php'); ?>

<body class="header-active <?php echo (($notification == 1) ? 'has-notification' : ''); ?>">

	<?php require('components/navbar.tpl.php'); ?>

	<div class="main homepage">
		
		
		
		<!-- Hero -->
		<section id="homepage-hero" class="homepage-noflow" style="background-color: #bab3ba;">
			<div class="hero-wrapper contain max-width extended">
				<div class="container">

					<div class="hero-text left">
						<h1 class="t0">Tasty treats <br /> for adults</h1>
						<p>
							Cannabis-infused edibles <br /> delivered to your doorstep.
						</p>
						<a class="btn t18" href="<?php echo SITEURL;?>/shop">Shop for Goodies</a>
					</div>
					
					<div class="hero-img-wrapper">
						<div class="hero-img-bg" style="background-image:url(<?php echo UPLOADURL;?>page_home/hero_girls3.jpg);"></div>
						<!--<img class="hero-img" src="<?php echo UPLOADURL;?>page_home/hero_girls3.jpg">-->
					</div>
					
				</div>
			</div>
		</section>
		
		
		<!-- Hero -->
		<section id="homepage-videos" class="homepage-noflow" style="background-color: #222;">
			<div class="hero-wrapper video contain max-width extended">
				<div class="container">

					<div class="hero-text center text-white">
						<h1 class="t0">The Only Choice That&nbsp;Matters</h1>
						
						
						<div class="btn-group t24">
							<a class="btn white" target="_blank" href="<?php echo SITEURL;?>/article?blog=staying-in-with-buudabomb-100mg">White Label <span class="ico-play-button"></span></a>
							<a class="btn white" target="_blank" href="<?php echo SITEURL;?>/article?blog=going-out-with-buudabomb-250mg">Black Label  <span class="ico-play-button"></span></a>
						</div>
					</div>
					
					<div class="hero-video-wrapper">
						<video playsinline defaultMuted autoplay muted loop poster="<?php echo UPLOADURL;?>page_home/webvideo/bgvideo.jpg" id="bgvid">
							<source src="<?php echo UPLOADURL;?>page_home/webvideo/bb30.ogv" type="video/ogv">
							<source src="<?php echo UPLOADURL;?>page_home/webvideo/bb30.webm" type="video/webm">
							<source src="<?php echo UPLOADURL;?>page_home/webvideo/bb30.mp4" type="video/mp4">
						</video>
					</div>
					
				</div>
			</div>
		</section>
		
		<!-- Hero rewards -->
		<section id="homepage-rewards" style="background-color: #121212;">
			<div class="hero-wrapper cover" style="background-image: url('<?php echo THEMEURL;?>/assets/img/hero-bg-rewards.jpg');">
				<div class="container">

					<div class="hero-text text-white center text-center">
						<h1 class="t0">BuudaPoints</h1>
						<p>
							Get rewarded for the things you're already&nbsp;doing.
						</p>
						<div class="btn-group t24">
							<a class="btn white blurwhite" href="<?php echo SITEURL;?>/about?p=buudapoints">Learn More</a>
							<a class="btn white blurwhite" href="<?php echo SITEURL;?>/profile?p=buudapoints">BuudaPoints Wallet</a>
						</div>
						
					</div>
					
				</div>
			</div>
		</section>
		
		
		<!-- Hero -->
		<section id="homepage-journey" class="homepage-noflow bg-white" style="display: none;">
			<div class="hero-wrapper contain max-width extended">
				<div class="container">

					<div class="hero-text left">
						<h1 class="t0">Mouth&#8209;Watering <br /> Gummies</h1>
						<p>
							Gummies with a real fruit taste for a mouth&#8209;watering experience.
						</p>
					</div>
					
					<div class="hero-img-wrapper">
						<div class="hero-img-bg" style="background-image:url(<?php echo THEMEURL;?>/assets/img/hero5bwhite.jpg);"></div>
						
						<!--<img class="hero-img-mobile" alt=" " src="<?php echo THEMEURL;?>/assets/img/hero5bwhite.jpg">-->
					</div>
					
				</div>
			</div>
		</section>
		
		
		
		<!-- Black Label video -->
		<section id="homepage-blacklabel" class="hero-wrapper cover" style="background-image: url('<?php echo UPLOADURL;?>page_home/bg-blacklabel.jpg'); display: none;">
			
			<style>
				.bg-video {
					position: absolute;
					top: 0;
					left: 0;
					width: 100%;
					height: 100%;
					z-index: 99;
					z-index: -1;
				}
				.bg-video #video {
					width: 100%;
					height: 100%;
				}
				
			</style>
			
			<div class="hero-wrapper cover" style="background-color: rgba(18, 18, 18, .76);">
				<div class="container">
					<div class="hero-text text-white center text-center" style="max-width: 80%;">
						<h1 class="t0">
							More isn't always better. <br />
							But this time it is.
						</h1>
						<div class="btn-group t24">
							<a class="btn white" href="<?php echo SITEURL;?>/shop">Shop Black Label</a>
							<a class="btn white" id="playVideo">Watch Promo</a>
						</div>
						
					</div>
					
				</div>
			</div>
			
			<div class="bg-video">
				<iframe id="video" src="https://www.youtube.com/embed/gKGNyh2r08w" frameborder="0"></iframe>
			</div>
			
		</section>
		
		
		
		
		<!-- Delivered -->
		<section id="hand-delivered" class="wrapper text-center bg-white">
			<div class="container max-width extended2">

				<h1>A Delicious&nbsp;Awakening</h1>

				<div class="row home-icons">

					<div class="col-sm-12 col-md-4">

						<div class="card">
							<div id="ico-vegan" class="icon">
								<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 681.5 681.5" style="enable-background:new 0 0 681.5 681.5;" xml:space="preserve">
								<style type="text/css">
								.st5{fill:#80B966;}
								.st6{fill:none;stroke:#80B966;stroke-width:17;stroke-linecap:round;stroke-miterlimit:10;}
								.st7{display:none;fill:#80B966;}
								.st8{fill:none;stroke:#80B966;stroke-width:18;stroke-linecap:round;stroke-miterlimit:10;}
								</style>
								<title>ico-vegan</title>
								<path id="circle" class="st5" d="M340.7,0C152.8,0,0,152.9,0,340.7s152.8,340.7,340.7,340.7s340.7-152.8,340.7-340.7
								S528.6,0,340.7,0z M340.7,663.4c-177.9,0-322.6-144.7-322.6-322.6S162.8,18.1,340.7,18.1s322.6,144.7,322.6,322.6
								S518.6,663.4,340.7,663.4z"/>
								<g class="ico-vegan-leaf-1">
								<path id="st--2" class="st6 stroke" d="M363,509.7c0,0,6.6-37.3,32.3-72.3c15.9-21.5,45.7-37.7,67.3-49" />
								<path id="leaf-1" class="st7 stroke-2" d="M345.5,278c-62-70-154.3-77.5-191-77.5c-7.2-0.1-14.5,0.3-21.7,0.9c-3.7,0.4-6.8,3.1-7.7,6.8
								c-1.3,5.2-31.4,128.1,50.5,220.5c41.6,46.9,113.3,51.3,160.3,9.7c0.5-0.5,1-1,1.5-1.4l12.4-13.6C383,381,382.4,319.7,345.5,278z
								 M339.2,407.4l-11.7,13.9c-1.2,1.2-2.4,2.4-3.6,3.6c-39.5,35-99.8,31.3-134.8-8.1c-65.4-73.8-52.6-172.1-47.8-197.7
								c3.3-0.2,7.8-0.3,13.2-0.3c34.3,0,120.3,7,177.5,71.4C361,323,363.9,371.3,339.2,407.4z" />
								<path id="st--1" class="st6 stroke" d="M361.5,512.5c0,0,6.5-51-21-91s-72.7-67.7-85.5-70" />
								<path id="leaf-2" class="st7 stroke-2" d="M575.5,309.2c-1.3-0.5-30.9-12.6-70.3-12.6c-33.6,0-63.8,8.7-89.8,25.8
								c-35.9,23.6-47.5,71-26.5,108.5l10.9,15.6c19.5,23.3,41.2,28.6,56.8,28.6c22.9,0,42-10.9,49.2-15.6c71.8-47.2,75.2-137.8,75.3-141.6
								C581.1,314.1,578.9,310.6,575.5,309.2z M495.7,444.4c-5.8,3.8-21.2,12.6-39.2,12.6c-17,0-31.9-8.1-44.4-24l-9.8-15.9
								c-12.9-28.6-3.1-62.4,23.1-79.6c23-15.1,49.9-22.8,79.9-22.8c19.4,0.1,38.7,3.1,57.2,9.1C560.2,344.4,549.1,409.2,495.7,444.4z" />
								<path id="leaf-2-stroke" class="st6 stroke-2" d="M403.3,436.7c0,0,33.7,49.3,91.7,19.3s76.3-110.3,79-138c0,0-95-31.7-152,11
								c-61.8,46.3-22.7,102.7-22.7,102.7" />
								<path id="leaf-1-stroke" class="st8  stroke" d="M335,425c0,0-39,56-115,23c-122.5-53.2-87-239-87-239c88.3-6.3,211.9,46.4,229,119
								c16.5,70-19,90-19,90" />
								</g>
								</svg>
							</div>

							<h4>Organic Ingredients</h4>
							<p>Enjoy edibles created in a chemical-free process using only the best organic ingredients.</p>
						</div>

					</div>

					<div class="col-sm-12 col-md-4">

						<div class="card">

							<div id="ico-shipping" class="icon">
								<svg version="1.1" id="Layer_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 860 532.1" style="enable-background:new 0 0 860 532.1;" xml:space="preserve">
								<style type="text/css">
								.st2{fill:none;stroke:#80B966;stroke-width:17;stroke-linecap:round;stroke-linejoin:round;}
								.st3{fill:#80B966;}
								</style>
								<title>ico-shipping</title>
								<circle class="st2" cx="359.7" cy="462.1" r="61.5"/>
								<circle class="st2" cx="687.5" cy="462.1" r="61.5"/>
								<g class="ico-shipping-car">
								<g>
								<path class="st3" d="M462.3,470.7h-41c-4.7,0-8.5-3.8-8.5-8.5s3.8-8.5,8.5-8.5h32.1c-2-21.9-11.5-42.2-27.2-57.9
								c-17.7-17.7-41.3-27.5-66.3-27.5c-0.1,0-0.1,0-0.2,0c-48.9,0-89.2,37.6-93.5,85.4h32.1c4.7,0,8.5,3.8,8.5,8.5s-3.8,8.5-8.5,8.5h-41
								c-4.7,0-8.5-3.8-8.5-8.5c0-61.2,49.7-110.9,110.9-110.9c0.1,0,0.1,0,0.2,0c29.6,0,57.4,11.5,78.3,32.4c21,20.9,32.6,48.8,32.6,78.5
								c0,2.3-0.9,4.4-2.5,6C466.7,469.8,464.6,470.7,462.3,470.7z"/>
								</g>
								<g>
								<path class="st3" d="M790,470.6h-41c-4.7,0-8.5-3.8-8.5-8.5s3.8-8.5,8.5-8.5h32.1c-4.3-47.8-44.7-85.4-93.6-85.4
								c-48.9,0-89.2,37.6-93.5,85.4h32.1c4.7,0,8.5,3.8,8.5,8.5s-3.8,8.5-8.5,8.5h-41c-4.7,0-8.5-3.8-8.5-8.5
								c0-61.2,49.8-110.9,110.9-110.9c61.2,0,111,49.7,111,110.9C798.5,466.8,794.7,470.6,790,470.6z"/>
								</g>
								<polygon class="st2" points="564.6,70 564.6,192.9 728.5,192.9 728.5,192.9 701.2,70 "/>


								<circle class="st2" cx="149" cy="149" r="140.5"/>
								<path class="st2" d="M817.4,252.1l-88.9-59.2L696.4,48.5c-4.9-22-27.3-40-49.9-40H277.8c-20.2,0.1-39.7,7.7-54.6,21.4
								C289,70.7,309.3,157.2,268.4,223c-16.8,27.1-42.5,47.7-72.6,58.3v180.8h61.5c0.6-56.6,46.9-102,103.5-101.4
								c55.8,0.6,100.9,45.6,101.4,101.4h122.9c0.6-56.6,46.9-102,103.5-101.4c55.8,0.6,100.9,45.6,101.4,101.4h61.5V315.8
								C851.5,293.3,836.1,264.6,817.4,252.1z"/>

								<polyline class="st2 ico-shipping-clock-1" points="149,149 149,78.7 149,149 "/>
								<line class="st2 ico-shipping-clock-2" x1="149" y1="149" x2="198.6" y2="198.7"/>
								</g>
								</svg>
							</div>

							<h4>Dependable Shipping</h4>
							<p>Skip the line. Get your edibles delivered straight to your door discretely and hassle free.</p>
						</div>

					</div>

					<div class="col-sm-12 col-md-4">

						<div class="card">

							<div id="ico-scale" class="icon">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 525.5 611.8" style="enable-background:new 0 0 525.5 611.8;" xml:space="preserve" id="scales">
								<style type="text/css">
								.st0{fill:none;stroke:#80B966;stroke-width:17;stroke-linecap:round;stroke-linejoin:round;}
								.st1{fill:none;stroke:#80B966;stroke-width:17;stroke-miterlimit:10;}
								</style>
								<title>ico-scale</title>
								<line class="st0" x1="263.4" y1="272.2" x2="263.4" y2="308.6"/>
								<line class="st0" x1="399.1" y1="407.9" x2="357.3" y2="407.9"/>
								<line class="st0" x1="309.4" y1="326.2" x2="334.4" y2="292.2"/>
								<line class="st0" x1="341.2" y1="359.3" x2="380.4" y2="341.9"/>
								<g class="ico-scale-bowl"><path class="st1" d="M517,32.6c0,13.3-10.8,24.1-24.1,24.1c0,0,0,0,0,0H32.6c-13.3,0-24.1-10.8-24.1-24.1c0,0,0,0,0,0l0,0
								c0-13.3,10.8-24.1,24.1-24.1c0,0,0,0,0,0h460.3C506.2,8.5,517,19.3,517,32.6C517,32.6,517,32.6,517,32.6L517,32.6z"/>
								<path class="st1" d="M480,56.7H45.5c0,0-2.7,112.4,95,112.4H385C482.6,169.1,480,56.7,480,56.7z"/></g>
								<rect x="247.4" y="169.1" class="st1 ico-scale-base" width="30.8" height="40.1"/>
								<path class="st1" d="M460.1,459.4v90.3c0,29.6-24,53.5-53.5,53.5H118.9c-29.6,0-53.5-24-53.5-53.5V405.9
								c0-109,88.4-197.4,197.4-197.4s197.4,88.4,197.4,197.4L460.1,459.4z"/>
								<circle class="st1" cx="262.7" cy="405.9" r="136.5"/>
								<line class="st0 ico-scale-arrow" x1="258.6" y1="409.4" x2="297.6" y2="346.5"/>
								</svg>
							</div>

							<h4>Accurate Dosages</h4>
							<p>Take pleasure knowing your edibles are lab tested for an incredibly accurate dosage of THC.</p>
						</div>

					</div>

				</div>

			</div>

			<div class="bg-image-wrapper viewport">
				<div class="bg-image"> </div>
			</div>

		</section>
		
		
		
		<!-- Instagram -->
		<section id="instagram-content">
			<a href="https://www.instagram.com/<?php echo $core->social_instagram;?>" target="_blank" class="instagram-follow">
				<span class="ico-instagram"></span>
				<h5>Connect with <?php echo $core->company; ?></h5>
				<h3>@<?php echo $core->social_instagram;?></h3>
			</a>
			<a target="_blank" href="https://www.instagram.com/buudabomb_/" class="post">
				<div class="image" style="background-image:url(<?php echo UPLOADURL;?>igfeed/73256194_144814106797269_8159649933520823444_n.jpg);"></div>
				<div class="content">
					<span>
						<span class="ico-heart-o"></span> 187
					</span>
					<span>
						<span class="ico-comment-o"></span> 9
					</span>
					<div>Chillin like a villain ♂️</div>
				</div>
			</a>
			<a target="_blank" href="https://www.instagram.com/p/BzwKxf6Br_MDRSVrePJyQb8AE68P3xlmSFVv680/" class="post">
				<div class="image" style="background-image:url(<?php echo UPLOADURL;?>igfeed/71188568_1356528994508277_2333408530598372679_n.jpg);"></div>
				<div class="content">
					<span>
						<span class="ico-heart-o"></span> 306
					</span>
					<span>
						<span class="ico-comment-o"></span>8
					</span>
					<div>“A real friend is one who walks in when the rest of the world walks out.” - Walter W.</div>
				</div>
			</a>
			
			<a target="_blank" href="https://www.instagram.com/p/B3e4v2xBhpb-zbzS44NOwy9H14UEGuuPKZihJA0/" class="post">
				<div class="image" style="background-image:url(<?php echo UPLOADURL;?>igfeed/72252071_184266895946596_5523710853769087576_n.jpg);"></div>
				<div class="content">
					<span>
						<span class="ico-heart-o"></span> 649
					</span>
					<span>
						<span class="ico-comment-o"></span> 54
					</span>
					<div>EARTH! FIRE! WIND! WATER! HEART! GOO PLANET!</div>
				</div>
			</a>
			
			
			
			<a target="_blank" href="https://www.instagram.com/buudabomb_/" class="post">
				<div class="image" style="background-image:url(<?php echo UPLOADURL;?>igfeed/BwfATVlB5L1r92osmBUZxLOXIc2fPPdXfg58cs0.jpg);"></div>
				<div class="content">
					<span>
						<span class="ico-heart-o"></span> 276
					</span>
					<span>
						<span class="ico-comment-o"></span> 14
					</span>
					<div>Happy 420 </div>
				</div>
			</a>
			<a target="_blank" href="https://www.instagram.com/p/BrWiX_FB-q7ilEgzIYRxzTl9zN4fqeiKUIvLqk0/" class="post">
				<div class="image" style="background-image:url(<?php echo UPLOADURL;?>igfeed/BrWiX_FB-q7ilEgzIYRxzTl9zN4fqeiKUIvLqk0.jpg);"></div>
				<div class="content">
					<span>
						<span class="ico-heart-o"></span> 156
					</span>
					<span>
						<span class="ico-comment-o"></span> 22
					</span>
					<div>i told my homie lifes all about balance. he poured a whole bag of gummies into his mouth and gave me the middle finger 🤷‍♂️</div>
				</div>
			</a>
			
			<a target="_blank" href="https://www.instagram.com/p/BtEECepBz-OfwJSJ7cCbDpLvOEXWg_xp72vYWU0/" class="post">
				<div class="image" style="background-image:url(<?php echo UPLOADURL;?>igfeed/50254795_2129927880650730_270891754711197692_n.jpg);"></div>
				<div class="content">
					<span>
						<span class="ico-heart-o"></span> 720
					</span>
					<span>
						<span class="ico-comment-o"></span> 47
					</span>
					<div>Some people think cannabis makes you dumb, lazy and a problem...what YALL think 🤔</div>
				</div>
			</a>
			
			<a target="_blank" href="https://www.instagram.com/p/BrRKshghwDS2dxESkZJmEQ6y5lMT3NToKSE62s0/" class="post">
				<div class="image" style="background-image:url(<?php echo UPLOADURL;?>igfeed/Bqi40jChMUGbl961SWfKyQCOhDZPfnucmK2Aek0.jpg);"></div>
				<div class="content">
					<span>
						<span class="ico-heart-o"></span> 151
					</span>
					<span>
						<span class="ico-comment-o"></span> 14
					</span>
					<div>See the past in my scars and the future in my untouched skin.</div>
				</div>
			</a>
			
			<a target="_blank" href="https://www.instagram.com/p/ByidJXiBEm3hi50Rh6R6UuqpEkZLyWduS6gwhI0/" class="post">
				<div class="image" style="background-image:url(<?php echo UPLOADURL;?>igfeed/ByidJXiBEm3hi50Rh6R6UuqpEkZLyWduS6gwhI0.jpg);"></div>
				<div class="content">
					<span>
						<span class="ico-heart-o"></span> 155
					</span>
					<span>
						<span class="ico-comment-o"></span> 18
					</span>
					<div>Everytime we score tonight imma pop a BuudaBomb 😘</div>
				</div>
			</a>
			
			
			<a target="_blank" href="https://www.instagram.com/p/B2W2r-vh3w10aiLgeewEWmm4-ckAM4uv8zcQoY0/" class="post">
				<div class="image" style="background-image:url(<?php echo UPLOADURL;?>igfeed/69159167_2428220540832689_4649811705853948155_n.jpg);"></div>
				<div class="content">
					<span>
						<span class="ico-heart-o"></span> 176
					</span>
					<span>
						<span class="ico-comment-o"></span> 13
					</span>
					<div>100% vegan 2000% delicious</div>
				</div>
			</a>
			<a target="_blank" href="https://www.instagram.com/p/BxxSQTrBZ2bB4uifvmiPJQ24V86jywO6gHDLtw0/" class="post">
				<div class="image" style="background-image:url(<?php echo UPLOADURL;?>igfeed/60514355_360287684839221_814021120888746399_n.jpg);"></div>
				<div class="content">
					<span>
						<span class="ico-heart-o"></span> 243
					</span>
					<span>
						<span class="ico-comment-o"></span> 24
					</span>
					<div>A pack a day #buudabomb</div>
				</div>
			</a>
			
		</section>
		
		
		
		
		
		
		
		<!-- Testimonials -->
		<!--<section class="testimonial-container">
			<div class="cd-testimonials-wrapper cd-container">
				<h2>Testimonials</h2>
				<ul class="flexslider cd-testimonials">
					<li>
						<div class="testimonial-content">
							<p>These edibles are a great way to get cannabis into your life without taking up smoking. I currently add it to my daily routine and make sure to have a couple before I sleep. I find myself waking up with much more energy.</p>
							<div class="cd-author">
								<img src="https://placehold.it/350x350/222222/222222" alt="Emily Schromm">
								<ul class="cd-author-info">
									<li>Emily <strong>Schromm</strong><br><span>Crossfit Coach &amp; Athlete</span></li>
									<li></li>
								</ul>
							</div>
						</div>
					</li>
					<li>
						<div class="testimonial-content">
							<p>I was encouraged to try <?php echo $core->company; ?>'s because of the amount of stress I was putting my mind through my work schedule. After a week of having them every day, my girlfriend told me that it was the happiest, most calm I had ever been in years.</p>
							<div class="cd-author">
								<img src="https://placehold.it/350x350/222222/222222" alt="Ben btn primaryfield">
								<ul class="cd-author-info">
									<li>Ben <strong>Greenfield</strong><br><span>Speaker and Author</span></li>
									<li></li>
								</ul>
							</div>
						</div>
					</li>
					<li>
						<div class="testimonial-content">
							<p>My favorites are the cookies and cream chocolates and the strawberry gummy bears. All very delicious. I use them. I like them. I support the mission!</p>
							<div class="cd-author">
								<img src="https://placehold.it/350x350/222222/222222" alt="Andre W">
								<ul class="cd-author-info">
									<li>John <strong>Widjaja</strong><br><span>Photographer</span></li>
									<li></li>
								</ul>
							</div>
						</div>
					</li>

				</ul>
			</div>
			<!-- cd-testimonials --*>
		</section>-->
		
		
		
		<!-- Mailing list signup -->
		<section id="mail" class="wrapper text-center bg-green">

			<div class="container max-width">

				<!--<h2>Get the Latest Updates</h2>-->
				<h3>Deals, news and other stuff delivered to your inbox</h3>
				<h4 class="t0">(Sign up and receive 5% off forever)</h4>
				
				<div id="mc_embed_signup" class="t30">

					<form action="https://buudabomb.us16.list-manage.com/subscribe/post?u=8c61b824d167c4c31532f13db&amp;id=2003fe4c7d" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
						<div id="mc_embed_signup_scroll">
							<div class="mc-field-group">
								<input type="email" value="" placeholder="Enter your e-mail address to subscribe" name="EMAIL" class="required email" id="mce-EMAIL"><button type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button btn-mail"><span class="ico-email-send"></span></button>
							</div>
							<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
							<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_8c61b824d167c4c31532f13db_ad48cd6370" tabindex="-1" value=""></div>
						</div>
					</form>
				</div>

			</div>

		</section>
		
		
		
		
		<!-- Blog Feed -->
		<section id="blog-feed" class="wrapper text-center bg-white padded border-bottom" style="display: none;">
			<div class="container max-width extended2">
			
				<h2 class="p12"><a href="<?php echo SITEURL;?>/blog">Latest from the blog</a></h2>
				<p class="p48"><strong>Earn 5 BuudaPoints</strong> every time you comment on a post!</p>
				
				<div class="row">
					
					<?php foreach($blogrow as $brow):?>
					
					<?php $url = ($core->seo) ? SITEURL . '/article/' . $brow->slug . '/' : SITEURL . '/article?blog=' . $brow->slug;?>
					
					<a class="col-sm-6 col-md-4 blog" data-id="<?php echo $brow->id;?>" href="<?php echo $url;?>">
						
						<div class="blog-img">
							<div class="placeholder" data-large="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo UPLOADURL;?>news_images/<?php echo ($brow->image);?>&amp;w=1600&amp;h=900&amp;s=1&amp;a=t1">
							  <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo UPLOADURL;?>news_images/<?php echo ($brow->image);?>&amp;w=32&amp;h=18&amp;s=1&amp;a=t1" class="img-small" alt='<?php echo $brow->title;?>'>
							</div>
						</div>
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
		
		
		<!-- Ready -->
		<section id="ready" class="wrapper text-center" style="display: none;">
			<div class="container max-width">
				<h2 class="p12 t36">
					Get your taste buds ready.
				</h2>
				<div class="row">
					<div class="col-sm-12">
						<a href="<?php echo SITEURL;?>/shop" class="btn med btn primary t30">Shop <?php echo $core->company; ?>'s</a>
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
		
		
		// Instagram feed
//		$(function() {
//		  var accessToken = "8734587194.1677ed0.c1dbe56bd2ea4734aaab68a4c463f99c";
//		  $.getJSON(
//		    "https://api.instagram.com/v1/users/self/media/recent/?access_token=" +
//		      accessToken +
//		      "&callback=?",
//		    function(insta) {
//		      $.each(insta.data, function(photos, src) {
//		        if (photos === 10) {
//		          return false;
//		        }
//		        $(
//		          '<a target="_blank" href="' + src.link + '" class="post">' +
//		            '<div class="image" style="background-image:url(' + src.images.standard_resolution.url + ');"></div>' +
//		            "<div class='content'>" +
//		            '<span><span class="ico-heart-o"></span> ' +
//		            src.likes.count +
//		            "</span>" +
//		            '<span><span class="ico-comment-o"></span> ' +
//		            src.comments.count +
//		            "</span>" +
//		            '<div>' +
//		            src.caption.text +
//		            "</div>" +
//		            "</div></a>"
//		        ).appendTo("#instagram-content");
//		      });
//		    }
//		  );
//		});

  
		//Testimonials
//		$(document).ready(function($) {
//			//create the slider
//			$(".cd-testimonials-wrapper").flexslider({
//				selector: ".cd-testimonials > li",
//				animation: "slide",
//				controlNav: true,
//				slideshow: false,
//				smoothHeight: true,
//				start: function() {
//					$(".cd-testimonials").children("li").css({
//						opacity: 1,
//						position: "relative"
//					});
//				}
//			});
//			
//			$(".cd-home-wrapper").flexslider({
//				selector: ".cd-home > li",
//				animation: "slide",
//				controlNav: true,
//				slideshow: false,
//				smoothHeight: true,
//				start: function() {
//					$(".cd-home").children("li").css({
//						opacity: 1,
//						position: "relative"
//					});
//				}
//			});
//			
//		});
		
		
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
		
		
		
		// Autoplay video
		$(document).ready(function($) {
			$('body').click(function() {
				var promise = document.querySelector('video').play();
			});
		});
		
		$('body').on({
			'touchmove': function(e) { 
				var promise = document.querySelector('video').play();
			}
		});
		
		
		

	</script>
	<!-- Mailing Modal -->
	<?php include('components/modal-mailinglist.tpl.php'); ?>

</body>

</html>
