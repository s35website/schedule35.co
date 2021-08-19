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
	
	if (!$user->logged_in) {
		redirect_to("login");
	}elseif (!$user->is_Ambassador()) {
		$_SESSION["isAdmin"] = '<ul class="error list"><li><i class="fa fa-exclamation-triangle"></i>Oops! Looks like you do not have permission to access this part of the website.</li>
		</ul>';
		redirect_to("login");
	}
?>
<!DOCTYPE html>

<html lang="en-US" dir="ltr">

<head>
	<?php include( "components/header.php"); ?>
</head>

<body>
	
	<div id="notifyProfileSettings" class="toast hide position-fixed b-0 r-0">
		<div class="toast-header"><strong class="mr-auto">Your settings have been updated.</strong>
			<button class="ml-2 mb-1 close" type="button" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">×</span></button>
		</div>
	</div>
	
	
	<!-- ===============================================-->
	<!--    Main Content-->
	<!-- ===============================================-->
	
	
	
	<main class="main" id="top">
		
		
		<div class="container">
			
			<div class="content">
				
				<?php include( "components/topbar.php"); ?>
				
				
				
				<div class="row no-gutters">
					<div class="col-lg-4 pr-lg-2">
						<div class="card h-100 bg-gradient">
							<div class="card-header bg-transparent">
								<h5 class="text-white">Unique Code</h5>
								<div class="real-time-user display-4 font-weight-normal text-white"><?php echo $urow->invite_code;?></div>
							</div>
							<div class="card-footer text-right bg-transparent border-top" style="border-color: rgba(255, 255, 255, 0.15) !important">
								<!--<a class="text-white" href="#!">Change Code
									<span class="fa fa-chevron-right ml-1 fs--1"></span>
								</a>-->
							</div>
						</div>
					</div>
					<div class="col-lg-8 pl-lg-2">
						<div class="card h-100 mt-3 mt-lg-0">
							<div class="card-header bg-light d-flex justify-content-between">
								<h5 class="mb-0">Program Settings</h5>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<p class="mb-2 float-left">
											Payout: <span id="output"><?php echo $urow->payout;?></span>% 
										</p>
										<p class="mb-2 float-right">
											Discount: <span id="output_packs"><?php echo($core->payout - $urow->payout);?></span>% 
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<input id="payout" type="range" value="<?php echo $urow->payout;?>" step="1" min="0" max="<?php echo $core->payout;?>">
									</div>
								</div>
							</div>
							<div class="card-footer bg-light">
								<div class="row justify-content-between">
									<div class="col-12">
										<button id="btnSavePayout" class="btn btn-primary float-right">
											Save <span class="sync-loader"><span class="fas fa-spin fa-sync-alt ml-1"></span></span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
				
				<div class="card" style="display: none;">
				  <div class="card-header">
				    <h5 class="mb-0">Frequently asked questions</h5>
				  </div>
				  <div class="card-body bg-light">
				    <div class="row">
				      <div class="col-lg-6">
				        <h5 class="fs-0">How does Falcon's pricing work?</h5>
				        <p class="fs--1">The free version of Falcon is available for teams of up to 15 people. Our Falcon Premium plans of 15 or fewer qualify for a small team discount. As your team grows to 20 users or more and gets more value out of Falcon, you'll get closer to our standard monthly price per seat. The price of a paid Falcon plan is tiered, starting in groups of 5 and 10 users, based on the number of people you have in your Team or Organization.</p>
				        <h5 class="fs-0">What forms of payment do you accept?</h5>
				        <p class="fs--1">You can purchase Falcon with any major credit card. For annual subscriptions, we can issue an invoice payable by bank transfer or check. Please contact us to arrange an invoice purchase. Monthly purchases must be paid for by credit card.</p>
				        <h5 class="fs-0">We need to add more people to our team. How will that be billed?</h5>
				        <p class="fs--1">You can add as many new teammates as you need before changing your subscription. We will subsequently ask you to correct your subscription to cover current usage.</p>
				        <h5 class="fs-0">How secure is Falcon?</h5>
				        <p class="fs--1 mb-lg-0">Protecting the data you trust to Falcon is our first priority. Falcon uses physical, procedural, and technical safeguards to preserve the integrity and security of your information. We regularly back up your data to prevent data loss and aid in recovery. Additionally, we host data in secure SSAE 16 / SOC1 certified data centers, implement firewalls and access restrictions on our servers to better protect your information, and work with third-party security researchers to ensure our practices are secure.</p>
				      </div>
				      <div class="col-lg-6">
				        <h5 class="fs-0">Will I be charged sales tax?</h5>
				        <p class="fs--1">As of May 2016, state and local sales tax will be applied to fees charged to customers with a billing address in the State of New York.</p>
				        <h5 class="fs-0">Do you offer discounts?</h5>
				        <p class="fs--1">We've built in discounts at each tier for teams smaller than 15 members. We also offer two months for free in exchange for an annual subscription.</p>
				        <h5 class="fs-0">Do you offer academic pricing?</h5>
				        <p class="fs--1">We're happy to work with student groups using Falcon. Contact Us</p>
				        <h5 class="fs-0">Is there an on-premise version of Falcon?</h5>
				        <p class="fs--1">We are passionate about the web. We don't plan to offer an internally hosted version of Falcon. We hope you trust us to provide a robust and secure service so you can do the work only your team can do.</p>
				        <h5 class="fs-0">What is your refund policy?</h5>
				        <p class="fs--1 mb-0">We do not offer refunds apart from exceptions listed below. If you cancel your plan before the next renewal cycle, you will retain access to paid features until the end of your subscription period. When your subscription expires, you will lose access to paid features and all data associated with those features. Exceptions to our refund policy: canceling within 48 hours of initial charge will result in a full refund. If you cancel within this timeframe, you will lose access to paid features and associated data immediately upon canceling.</p>
				      </div>
				    </div>
				  </div>
				  <div class="card-footer">
				    <div class="col-12 text-center py-3">
				      <h6 class="fs-0 font-weight-normal">Have more questions?</h6><a class="btn btn-falcon-primary btn-sm" href="#" data-toggle="modal" data-target="#exampleModal">Ask us anything</a>
				    </div>
				    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				      <div class="modal-dialog" role="document">
				        <div class="modal-content">
				          <div class="modal-header bg-light">
				            <h5 class="modal-title" id="exampleModalLabel">Ask your question</h5>
				            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
				          </div>
				          <div class="modal-body">
				            <form>
				              <div class="form-group">
				                <label for="name">Name</label>
				                <input class="form-control" id="name" type="text">
				              </div>
				              <div class="form-group">
				                <label for="emailModal">Email</label>
				                <input class="form-control" id="emailModal" type="email">
				              </div>
				              <div class="form-group">
				                <label for="question">Question</label>
				                <textarea class="form-control" id="question" rows="4"></textarea>
				              </div>
				            </form>
				          </div>
				          <div class="modal-footer bg-light rounded">
				            <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
				            <button class="btn btn-primary btn-sm" type="submit">Send</button>
				          </div>
				        </div>
				      </div>
				    </div>
				  </div>
				</div>
				
				
				<footer>
					<div class="row no-gutters justify-content-between fs--1 mt-4 mb-3">
						<div class="col-12 col-sm-auto text-center">
							<p class="mb-0 text-600">
								</span> 2019 &copy; <a href="<?php echo $core->site_url;?>"><?php echo $core->site_name;?></a>
							</p>
						</div>
						<div class="col-12 col-sm-auto text-center">
							<p class="mb-0 text-600">v1.6.0</p>
						</div>
					</div>
				</footer>
			</div>
		</div>
		
	</main>
	<!-- ===============================================-->
	<!--    End of Main Content-->
	<!-- ===============================================-->
	<!-- ===============================================-->
	<!--    JavaScripts-->
	<!-- ===============================================-->
	<script src="<?php echo AMBASSURL; ?>/assets/js/jquery.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/js/popper.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/js/bootstrap.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/stickyfilljs/stickyfill.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/sticky-kit/sticky-kit.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/is_js/is.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/@fortawesome/all.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/chart.js/Chart.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/jqvmap/jquery.vmap.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/owl.carousel/owl.carousel.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/fancybox/jquery.fancybox.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/flatpickr/flatpickr.min.js"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/jqvmap/maps/jquery.vmap.world.js" charset="utf-8"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/lib/jqvmap/maps/jquery.vmap.usa.js" charset="utf-8"></script>
	<script src="<?php echo AMBASSURL; ?>/assets/js/theme.js"></script>
	
	
	
	<script type="text/javascript">
		//slider javascript
		/*! rangeslider.js - v2.0.2 | (c) 2015 @andreruffert | MIT license | https://github.com/andreruffert/rangeslider.js */
		! function(a) {
		  "use strict";
		  "function" == typeof define && define.amd ? define(["jquery"], a) : a("object" == typeof exports ? require("jquery") : jQuery)
		}(function(a) {
		  "use strict";
		
		  function b() {
		    var a = document.createElement("input");
		    return a.setAttribute("type", "range"), "text" !== a.type
		  }
		
		  function c(a, b) {
		    var c = Array.prototype.slice.call(arguments, 2);
		    return setTimeout(function() {
		      return a.apply(null, c)
		    }, b)
		  }
		
		  function d(a, b) {
		    return b = b || 100,
		      function() {
		        if (!a.debouncing) {
		          var c = Array.prototype.slice.apply(arguments);
		          a.lastReturnVal = a.apply(window, c), a.debouncing = !0
		        }
		        return clearTimeout(a.debounceTimeout), a.debounceTimeout = setTimeout(function() {
		          a.debouncing = !1
		        }, b), a.lastReturnVal
		      }
		  }
		
		  function e(a) {
		    return a && (0 === a.offsetWidth || 0 === a.offsetHeight || a.open === !1)
		  }
		
		  function f(a) {
		    for (var b = [], c = a.parentNode; e(c);) b.push(c), c = c.parentNode;
		    return b
		  }
		
		  function g(a, b) {
		    function c(a) {
		      "undefined" != typeof a.open && (a.open = a.open ? !1 : !0)
		    }
		    var d = f(a),
		      e = d.length,
		      g = [],
		      h = a[b];
		    if (e) {
		      for (var i = 0; e > i; i++) g[i] = d[i].style.cssText, d[i].style.display = "block", d[i].style.height = "0", d[i].style.overflow = "hidden", d[i].style.visibility = "hidden", c(d[i]);
		      h = a[b];
		      for (var j = 0; e > j; j++) d[j].style.cssText = g[j], c(d[j])
		    }
		    return h
		  }
		
		  function h(a, b) {
		    var c = parseFloat(a);
		    return Number.isNaN(c) ? b : c
		  }
		
		  function i(a) {
		    return a.charAt(0).toUpperCase() + a.substr(1)
		  }
		
		  function j(b, e) {
		    if (this.$window = a(window), this.$document = a(document), this.$element = a(b), this.options = a.extend({}, n, e), this.polyfill = this.options.polyfill, this.orientation = this.$element[0].getAttribute("data-orientation") || this.options.orientation, this.onInit = this.options.onInit, this.onSlide = this.options.onSlide, this.onSlideEnd = this.options.onSlideEnd, this.DIMENSION = o.orientation[this.orientation].dimension, this.DIRECTION = o.orientation[this.orientation].direction, this.DIRECTION_STYLE = o.orientation[this.orientation].directionStyle, this.COORDINATE = o.orientation[this.orientation].coordinate, this.polyfill && m) return !1;
		    this.identifier = "js-" + k + "-" + l++, this.startEvent = this.options.startEvent.join("." + this.identifier + " ") + "." + this.identifier, this.moveEvent = this.options.moveEvent.join("." + this.identifier + " ") + "." + this.identifier, this.endEvent = this.options.endEvent.join("." + this.identifier + " ") + "." + this.identifier, this.toFixed = (this.step + "").replace(".", "").length - 1, this.$fill = a('<div class="' + this.options.fillClass + '" />'), this.$handle = a('<div class="' + this.options.handleClass + '" />'), this.$range = a('<div class="' + this.options.rangeClass + " " + this.options[this.orientation + "Class"] + '" id="' + this.identifier + '" />').insertAfter(this.$element).prepend(this.$fill, this.$handle), this.$element.css({
		      position: "absolute",
		      width: "1px",
		      height: "1px",
		      overflow: "hidden",
		      opacity: "0"
		    }), this.handleDown = a.proxy(this.handleDown, this), this.handleMove = a.proxy(this.handleMove, this), this.handleEnd = a.proxy(this.handleEnd, this), this.init();
		    var f = this;
		    this.$window.on("resize." + this.identifier, d(function() {
		      c(function() {
		        f.update()
		      }, 300)
		    }, 20)), this.$document.on(this.startEvent, "#" + this.identifier + ":not(." + this.options.disabledClass + ")", this.handleDown), this.$element.on("change." + this.identifier, function(a, b) {
		      if (!b || b.origin !== f.identifier) {
		        var c = a.target.value,
		          d = f.getPositionFromValue(c);
		        f.setPosition(d)
		      }
		    })
		  }
		  Number.isNaN = Number.isNaN || function(a) {
		    return "number" == typeof a && a !== a
		  };
		  var k = "rangeslider",
		    l = 0,
		    m = b(),
		    n = {
		      polyfill: !0,
		      orientation: "horizontal",
		      rangeClass: "rangeslider",
		      disabledClass: "rangeslider--disabled",
		      horizontalClass: "rangeslider--horizontal",
		      verticalClass: "rangeslider--vertical",
		      fillClass: "rangeslider__fill",
		      handleClass: "rangeslider__handle",
		      startEvent: ["mousedown", "touchstart", "pointerdown"],
		      moveEvent: ["mousemove", "touchmove", "pointermove"],
		      endEvent: ["mouseup", "touchend", "pointerup"]
		    },
		    o = {
		      orientation: {
		        horizontal: {
		          dimension: "width",
		          direction: "left",
		          directionStyle: "left",
		          coordinate: "x"
		        },
		        vertical: {
		          dimension: "height",
		          direction: "top",
		          directionStyle: "bottom",
		          coordinate: "y"
		        }
		      }
		    };
		  j.prototype.init = function() {
		    this.update(!0, !1), this.$element[0].value = this.value, this.onInit && "function" == typeof this.onInit && this.onInit()
		  }, j.prototype.update = function(a, b) {
		    a = a || !1, a && (this.min = h(this.$element[0].getAttribute("min"), 0), this.max = h(this.$element[0].getAttribute("max"), 100), this.value = h(this.$element[0].value, this.min + (this.max - this.min) / 2), this.step = h(this.$element[0].getAttribute("step"), 1)), this.handleDimension = g(this.$handle[0], "offset" + i(this.DIMENSION)), this.rangeDimension = g(this.$range[0], "offset" + i(this.DIMENSION)), this.maxHandlePos = this.rangeDimension - this.handleDimension, this.grabPos = this.handleDimension / 2, this.position = this.getPositionFromValue(this.value), this.$element[0].disabled ? this.$range.addClass(this.options.disabledClass) : this.$range.removeClass(this.options.disabledClass), this.setPosition(this.position, b)
		  }, j.prototype.handleDown = function(a) {
		    if (a.preventDefault(), this.$document.on(this.moveEvent, this.handleMove), this.$document.on(this.endEvent, this.handleEnd), !((" " + a.target.className + " ").replace(/[\n\t]/g, " ").indexOf(this.options.handleClass) > -1)) {
		      var b = this.getRelativePosition(a),
		        c = this.$range[0].getBoundingClientRect()[this.DIRECTION],
		        d = this.getPositionFromNode(this.$handle[0]) - c,
		        e = "vertical" === this.orientation ? this.maxHandlePos - (b - this.grabPos) : b - this.grabPos;
		      this.setPosition(e), b >= d && b < d + this.handleDimension && (this.grabPos = b - d)
		    }
		  }, j.prototype.handleMove = function(a) {
		    a.preventDefault();
		    var b = this.getRelativePosition(a),
		      c = "vertical" === this.orientation ? this.maxHandlePos - (b - this.grabPos) : b - this.grabPos;
		    this.setPosition(c)
		  }, j.prototype.handleEnd = function(a) {
		    a.preventDefault(), this.$document.off(this.moveEvent, this.handleMove), this.$document.off(this.endEvent, this.handleEnd), this.$element.trigger("change", {
		      origin: this.identifier
		    }), this.onSlideEnd && "function" == typeof this.onSlideEnd && this.onSlideEnd(this.position, this.value)
		  }, j.prototype.cap = function(a, b, c) {
		    return b > a ? b : a > c ? c : a
		  }, j.prototype.setPosition = function(a, b) {
		    var c, d;
		    void 0 === b && (b = !0), c = this.getValueFromPosition(this.cap(a, 0, this.maxHandlePos)), d = this.getPositionFromValue(c), this.$fill[0].style[this.DIMENSION] = d + this.grabPos + "px", this.$handle[0].style[this.DIRECTION_STYLE] = d + "px", this.setValue(c), this.position = d, this.value = c, b && this.onSlide && "function" == typeof this.onSlide && this.onSlide(d, c)
		  }, j.prototype.getPositionFromNode = function(a) {
		    for (var b = 0; null !== a;) b += a.offsetLeft, a = a.offsetParent;
		    return b
		  }, j.prototype.getRelativePosition = function(a) {
		    var b = i(this.COORDINATE),
		      c = this.$range[0].getBoundingClientRect()[this.DIRECTION],
		      d = 0;
		    return "undefined" != typeof a["page" + b] ? d = a["client" + b] : "undefined" != typeof a.originalEvent["client" + b] ? d = a.originalEvent["client" + b] : a.originalEvent.touches && a.originalEvent.touches[0] && "undefined" != typeof a.originalEvent.touches[0]["client" + b] ? d = a.originalEvent.touches[0]["client" + b] : a.currentPoint && "undefined" != typeof a.currentPoint[this.COORDINATE] && (d = a.currentPoint[this.COORDINATE]), d - c
		  }, j.prototype.getPositionFromValue = function(a) {
		    var b, c;
		    return b = (a - this.min) / (this.max - this.min), c = Number.isNaN(b) ? 0 : b * this.maxHandlePos
		  }, j.prototype.getValueFromPosition = function(a) {
		    var b, c;
		    return b = a / (this.maxHandlePos || 1), c = this.step * Math.round(b * (this.max - this.min) / this.step) + this.min, Number(c.toFixed(this.toFixed))
		  }, j.prototype.setValue = function(a) {
		    a !== this.value && this.$element.val(a).trigger("input", {
		      origin: this.identifier
		    })
		  }, j.prototype.destroy = function() {
		    this.$document.off("." + this.identifier), this.$window.off("." + this.identifier), this.$element.off("." + this.identifier).removeAttr("style").removeData("plugin_" + k), this.$range && this.$range.length && this.$range[0].parentNode.removeChild(this.$range[0])
		  }, a.fn[k] = function(b) {
		    var c = Array.prototype.slice.call(arguments, 1);
		    return this.each(function() {
		      var d = a(this),
		        e = d.data("plugin_" + k);
		      e || d.data("plugin_" + k, e = new j(this, b)), "string" == typeof b && e[b].apply(e, c)
		    })
		  }
		});
		
		//custom slider javascript
		$(function() {
			var output = document.querySelectorAll('#output')[0];
			var output_packs = document.querySelectorAll('#output_packs')[0];
			
			$(document).on('input', 'input[type="range"]', function(e) {
				output.innerHTML = e.currentTarget.value;
				output_packs.innerHTML = <?php echo $core->payout;?> - e.currentTarget.value;
			});
			
			$('input[type=range]').rangeslider({
				polyfill: false
			});
		});
	</script>
	
	
	<script type="text/javascript">
		$('body').on('click', '#btnSavePayout', function() {
		
			$.ajax({
				type: "post",
				dataType: 'json',
				url: SITEURL + "/ajax/user.php",
				data: {
					'updatePayout': 1,
					'payout': $("#payout").val()
				},
				beforeSend: function() {
					$("#btnSavePayout").addClass("loading");
					$("#btnSavePayout").attr("disabled", true);
					
					$(".toast").addClass("hide");
					$(".toast").removeClass("show");
				},
				success: function(json) {
					
					$("#notifyProfileSettings").addClass("show");
					$("#notifyProfileSettings").removeClass("hide");
					
					$("#btnSavePayout").removeClass("loading");
					$("#btnSavePayout").attr("disabled", false);
				},
				error: function(json) {
					console.log('error');
				}
			});
		});
	</script>
	
	
</body>

</html>