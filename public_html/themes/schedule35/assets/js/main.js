// Lazy load images using blur method
window.onload = function() {

	var placeholders = document.querySelectorAll('.placeholder'),
		i;

	for (i = 0; i < placeholders.length; i++) {
		blurryLoad(placeholders[i]);
	}
}

function blurryLoad(element) {
	var small = element.querySelector('.img-small');

	// 1: load small image and show it
	var img = new Image();
	img.src = small.src;
	img.onload = function() {
		small.classList.add('loaded');
	};

	// 2: load large image
	var imgLarge = new Image();
	imgLarge.src = element.dataset.large;
	imgLarge.onload = function() {
		imgLarge.classList.add('loaded');
		small.classList.add('hide');
	};
	element.appendChild(imgLarge);
}
// END Lazy load images using blur method






var h_avatar_tooltip;

$( document ).ready(function() {
	windowsize = $(window).width();
	if (windowsize > 768) {
		h_avatar_tooltip = new jBox('Tooltip', {
			attach: '#header_avatar',
			preventDefault: true,
			trigger: 'click',
			closeOnClick: 'body',
			content: $('#header_avatar .content-popover'),
			onOpen: function() {
				$(".user-avatar").addClass("active");
			},
			onClose: function() {
				$(".user-avatar").removeClass("active");
			}
		});
	}	
});


// Toggle About Dropdown
$('body').on('click', '.has-popover > a.closed', function(event) {
//	event.preventDefault();
});

// Mobile menu
$( "body" ).on( "click", "#navBtn", function() {
	$("body").toggleClass("menu-opened");
	
});
$(window).resize(function() {
	windowsize = $(window).width();
	if (windowsize > 768) {
		$("body").removeClass("menu-opened");
	}else {
		//h_avatar_tooltip.destroy();
	}
//	$('.has-popover .content-popover').fadeOut(150);
//	$('.has-popover > a').addClass("closed");
});

// When scrolling on window close box
$(window).scroll(function() {
	//h_avatar_tooltip.close();
});


$( "body" ).on( "click", ".btn-quantum", function() {
	$(this).addClass("loading");
});

$( "body" ).on( "click", ".payment-option", function() {
	$(".payment-option").removeClass("active");
	$(".payment-info").removeClass("active");

	var paymentType = "." + $(this).data('payment');
	$(paymentType).addClass("active");
	$(this).addClass("active");
});

$( ".subnav" ).on( "click", ".subnav-label", function() {
	$(".subnav").toggleClass("open");
});

$( ".subnav-faq" ).on( "click", ".subnav-link", function() {
	$(".subnav").removeClass("open");
});

$(".tab.view").hover(
	function() {
		$(this).closest('.masta').addClass('hover');
	}, function() {
		$(this).closest('.masta').removeClass('hover');
	}
);

$( ".masta" ).on( "click", ".tab.view", function() {
	$(this).closest('.masta').toggleClass('show').find('.form.view').slideToggle(150);
});

$('.form-validetta').validetta({
	//display : 'bubble',
	//bubblePosition: 'bottom'
	showErrorMessages : false,
	errorClass : '_error',
	onError : function(){
		$(".btn-quantum").removeClass("loading");
		$(".btn-quantum").removeClass("disabled");
		console.log("There was an error validating this form.");
	}
});

$("input, select").on( "click", function() {
	$(this).closest('._error').removeClass('_error');
});

$('.tabs a').click(function(){
	var tab_id = $(this).attr('data-tab');

	$('.tabs a').removeClass('active');
	$('.tab-content').removeClass('active');

	$(this).addClass('active');
	$("#"+tab_id).addClass('active');
});

/* Thumbnail switcher */
$(".product-page-gallery .thumbnail").click(function() {
	$(".product-page-gallery .thumbnail").removeClass("active");

	$(this).addClass("active");
	var url = $(this).find("img").data("src");
	$(".product-photo .large-image img").attr("src", url);
});

/* Product Quantity Increase */
$(".add-to-cart-wrap .custom-number-input .input-number-increment").on("click", function() {
	var oldValue = $(this).parent().find("input").val();
	var maxVal = $(this).parent().find("input").attr("data-max");
	var newVal = parseInt(oldValue) + 1;
	if (newVal <= 20 && newVal <= maxVal) {
		$(this).parent().find("input").val(newVal);
	}
});

/* Product Quantity Decrease */
$(".add-to-cart-wrap .custom-number-input .input-number-decrement").on("click", function() {
	var oldValue = $(this).parent().find("input").val();
	var newVal = parseInt(oldValue) - 1;
	if (newVal >= 1) {
		$(this).parent().find("input").val(newVal);
	}
});

/* Product Quantity Manual Input */
$(".custom-number-input .input-number").change(function() {
	if ($(this).val() > 20) {
		$(this).val(20);
	}
	if ($(this).val() < 1) {
		$(this).val(1);
	}
});

function getIndexToIns(arr, num) {
  // Find my place in this sorted array.
  return arr
    .concat(num)
    .sort((a, b) => a - b)
    .indexOf(num);
}
//var wholeSaleCart = [];
const tierPriceQuantityArray = {
  Gummies: [0, 60, 120, 140, 240, 280, 600, 680, 1200, 1400],
  "Black Label": [0, 60, 120, 140, 240, 280, 600, 680, 1200, 1400],
  Chocolates: [0, 20, 40, 60, 100, 160, 200]
};
const tierPriceArray = {
  Gummies: [13.5, 8.5, 8.5, 7.5, 7.5, 6.5, 6.5, 6, 6, 5.5],
  "Black Label": [26.4, 14.5, 14.5, 13.5, 13.5, 11.5, 11.5, 11, 11, 10.5],
  Chocolates: [29.8, 18, 18, 16.5, 16.5, 14.5, 14.5]
};
function getTierPricing(quantity, category, operation) {
  const length = tierPriceQuantityArray[category].length;
  const quantityIndex = getIndexToIns(
    tierPriceQuantityArray[category],
    quantity
  );
  var jumpQuantity = quantity;
  var price = 0;
  if (quantityIndex >= length) {
    price = tierPriceArray[category][length - 1];
    if (
      category === "Chocolates" &&
      quantity > tierPriceQuantityArray[category][length - 1]
    ) {
      jumpQuantity = tierPriceQuantityArray[category][length - 1];
    }
  } else {
    if (
      quantityIndex == 1 &&
      quantity != tierPriceQuantityArray[category][quantityIndex]
    ) {
      price = tierPriceArray[category][0];
    } else {
      if (
        quantityIndex != 1 &&
        quantityIndex % 2 != 0 &&
        quantity != tierPriceQuantityArray[category][quantityIndex]
      ) {
        if ("increment" === operation) {
          jumpQuantity = tierPriceQuantityArray[category][quantityIndex];
          price = tierPriceArray[category][quantityIndex];
        } else {
          jumpQuantity = tierPriceQuantityArray[category][quantityIndex - 1];
          price = tierPriceArray[category][quantityIndex - 1];
        }
      } else {
        price = tierPriceArray[category][quantityIndex];
      }
    }
  }
  var result = new Object();
  result[jumpQuantity] = price;
  return result;
}
function updateUnitAndTotal() {
  var itemsQuantity = 0;
  var subTotal = 0;
  var formatter = new Intl.NumberFormat('en-US', {
	style: 'currency',
	currency: 'USD',
	});
  wholeSaleCart.forEach(item => {
    itemsQuantity = itemsQuantity + item.qty;
    subTotal = subTotal + item.qty * item.price;
  });
  $(".total-units").text(itemsQuantity);
  $(".wholesale-subtotal").text(formatter.format(subTotal));
  $(".cart-subtotal").text(formatter.format(subTotal));

  if (window.location.href.includes("cart")) {
    if (itemsQuantity < 60) {
      $(".btn.wholesale-add-to-cart span").text(
        "N/A (minimum order not reached)"
      );
      $(".btn.wholesale-add-to-cart")
        .addClass("disabled")
        .removeClass("black")
        .removeClass("wholesale-add-to-cart");
    } else {
      $(".btn.disabled span").text("Choose Delivery Options");
      $(".btn.disabled")
        .addClass("wholesale-add-to-cart")
        .addClass("black")
        .removeClass("disabled");
    }
  } else {
    if (itemsQuantity < 60) {
      $(".btn.wholesale-add-to-cart span").text(
        "N/A (minimum order not reached)"
      );
      $(".btn.wholesale-add-to-cart")
        .addClass("disabled")
        .removeClass("black")
        .removeClass("wholesale-add-to-cart");
    } else {
      $(".btn.disabled span").text("Add Items");
      $(".btn.disabled")
        .addClass("wholesale-add-to-cart")
        .addClass("black")
        .removeClass("disabled");
    }
  }
}
function addItemtoWholeSaleCart(inputElem, operation) {
  var oldValue = inputElem.val();
  var maxVal = inputElem.attr("data-max");
  var stockval = inputElem.attr("data-stockval");
  var id = inputElem.attr("data-id");
  var description = inputElem.attr("data-name");
  var category = inputElem.attr("data-category");
  var newVal = parseInt(oldValue);

  if ("increment" === operation) {
    newVal = newVal + 20;
  } else {
    newVal = newVal - 20;
  }
  var cartItem = new Object();
  const result = getTierPricing(newVal, category, operation);
  cartItem["id"] = id;
  cartItem["qty"] = parseInt(Object.keys(result)[0]);
  cartItem["description"] = description;
  cartItem["price"] = Object.values(result)[0];
  var itemInCartIndex = wholeSaleCart.findIndex(item => item.id === id);
  if ("increment" === operation) {
    if (Object.keys(result)[0] <= parseInt(maxVal)) {
      inputElem.val(Object.keys(result)[0]);
      if (itemInCartIndex == -1) {
        wholeSaleCart.push(cartItem);
      } else {
        wholeSaleCart[itemInCartIndex] = cartItem;
      }
    }
  } else {
    if (Object.keys(result)[0] >= 0) {
      inputElem.val(Object.keys(result)[0]);
      if (Object.keys(result)[0] == 0) {
        wholeSaleCart.splice(itemInCartIndex, 1);
      } else {
        wholeSaleCart[itemInCartIndex] = cartItem;
      }
    }
  }
  updateUnitAndTotal();
  inputElem
    .closest(".product-row")
    .find(".unit-price")
    .text(Object.values(result)[0]);
}
/* == WholeSale Cart Functions == */
$(".footer-wholesale").on("click", ".wholesale-add-to-cart",function(event) {

	$.ajax({
    type: "post",
    dataType: "json",
    url: SITEURL + "/ajax/cart.php",
    data: {
      addtocartwholesale: 1,
      items: wholeSaleCart
    },
    beforeSend: function() {
      $(".wholesale-add-to-cart").addClass("loading");
    },
    success: function(json) {
      $(".wholesale-add-to-cart").removeClass("loading");
      if (json.type == "error") {
        var message =
          "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'Ahh shoot, we don’t have enough of this item in stock. Select another quantity and try again.', autoClose: 9400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";
        $("#javascript-box").append(message);
      } else {
        if (window.location.href.includes("cart")) {
          window.location.href = "/wholesale?p=checkout";
        } else {
          window.location.href = "/wholesale?p=cart";
        }
      }
    },
    error: function() {
      $(".wholesale-add-to-cart").removeClass("loading");
    }
  });
  
});

/* Product wholesale Quantity Increase */
$(".wholesale-input.custom-number-input .input-number-increment").on(
  "click",
  function() {
    addItemtoWholeSaleCart(
      $(this)
        .parent()
        .find("input"),
      "increment"
    );
  }
);

/* Product wholesale Quantity Decrease */
$(".wholesale-input.custom-number-input .input-number-decrement").on(
  "click",
  function() {
    addItemtoWholeSaleCart(
      $(this)
        .parent()
        .find("input"),
      "decrement"
    );
  }
);

/* Product wholesale Quantity Manual Input */
$(".wholesale-input.custom-number-input .input-number").change(function() {
	if ($(this).val() > 500) {
		$(this).val(500);
	}
	if ($(this).val() < 20) {
		$(this).val(0);
	}
});

/* Product Remove */
$("#page-wholesale .cart-remove").on("click", function() {
	var item = $(this).closest(".product-row");
	id = item.attr("data-id");
	$.ajax({
		type: "post",
		dataType: 'json',
		url: SITEURL + "/ajax/cart.php",
		data: {
			'removecartwholesale': 1,
			'id': id
		},
		beforeSend: function() {
		},
		success: function(json) {
			var itemInCartIndex = wholeSaleCart.findIndex(item => item.id === id);
			wholeSaleCart.splice(itemInCartIndex, 1);
			updateUnitAndTotal();
			item.remove();
		},
		error: function() {
			console.log("error adding to cart");
		}

	});
	
});

// ANIMATE
;(function($, win) {
  $.fn.inViewport = function(cb) {
     return this.each(function(i,el){
       function visPx(){
         var H = $(this).height(),
             r = el.getBoundingClientRect(), t=r.top, b=r.bottom;
         return cb.call(el, Math.max(0, t>0? H-t : (b<H?b:H)));
       } visPx();
       $(win).on("resize scroll", visPx);
     });
  };
}(jQuery, window));

$(".viewport").inViewport(function(px){
    if(px) $(this).addClass("animated") ;
});

/* Close Invite Overlay */
$("#btnShowReceipt").on("click", function() {
	$(".card-breakdown-overlay").fadeOut();
});


/**Global Variable**/

function redirect (url) {
	var ua        = navigator.userAgent.toLowerCase(),
	isIE      = ua.indexOf('msie') !== -1,
	version   = parseInt(ua.substr(4, 2), 10);

	// Internet Explorer 8 and lower
	if (isIE && version < 9) {
		var link = document.createElement('a');
		link.href = url;
		document.body.appendChild(link);
		link.click();
	}

	// All other browsers can use the standard window.location.href (they don't lose HTTP_REFERER like IE8 & lower does)
	else {
		window.location.href = url;
	}
}

/* == Cart Functions == */
$('body').on('click', '#btnAddtoCart', function(event) {
//	$(event.target).closest('a').preventDefault();
	id = $(this).attr("data-id");
	stockval = $("#stockval").attr("data-stockval");

  if($(".ddl_variants").length === 0){
      var_id = 0;
  }else{
      var_id = $(".ddl_variants").val();
  }
	$.ajax({
		type: "post",
		dataType: 'json',
		url: SITEURL + "/ajax/cart.php",
		data: {
			'addtocart': 1,
			'id': id,
			'stockval': stockval,
			'ambcode': ambcode,
			'qty': $(".quantity-selector input").val(),
			'var_id':var_id,
			'description': $(this).attr("data-name")
		},
		beforeSend: function() {
			$("#btnAddtoCart").addClass("loading");
		},
		success: function(json) {

			$("#btnAddtoCart").removeClass("loading");
			$("#mini_cart .empty-text").hide();
			
			if (json.type == "error") {
				console.log(json.errovalue);
				var message = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'Ahh shoot, we don’t have enough of this item in stock. Select another quantity and try again.', autoClose: 9400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";

				$("#javascript-box").append(message);
			}
			else {
				$(".mini-cart .footer").show();
				
				$(".badge").addClass("active").addClass("pop");
				$(".header_cart_count").html(json.cartquantity);
				$("#mini_cart .count").html(json.cartquantity);
				$("#mini_cart .subtotal").html(json.cartcost);
				
				var $current = $("#mini_cart").find("[data-id='" + json.pid + "'][data-pvid='"+json.pvid+"']");
				
				
				$ambprice = json.price - (json.price * ambdiscount);
				$ambprice = $ambprice.toFixed(2);
				
				if (ambdiscount > 0) {
					if ($current.length) {
						$current.find(".quantity").html(json.productquantity);
						$current.remove();
						$("#mini_cart .items").prepend('<div class="item clear" data-id="' + json.pid + '" data-pvid="'+json.pvid+'"><div class="item-img"><img class="inline-block" src="' + json.thumb + '"></div><div class="item-text"><p class="name"><span>' + json.name + '</span><span data-id="' + json.pid + '" data-pvid="'+json.pvid+'" class="close x-grey"><span class="icon-x block"></span></span></p><p><span>'+json.var_title+'</span></p> <p><span class="quantity">' + json.productquantity + '</span> x <span class="discounted">$' + json.price + '</span> $' + $ambprice + '</p></div> </div>');
					}else {
						$("#mini_cart .items").prepend('<div class="item clear" data-id="' + json.pid + '" data-pvid="'+json.pvid+'"><div class="item-img"><img class="inline-block" src="' + json.thumb + '"></div><div class="item-text"><p class="name"><span>' + json.name + '</span><span data-id="' + json.pid + '" data-pvid="'+json.pvid+'" class="close x-grey"><span class="icon-x block"></span></span></p><p><span>'+json.var_title+'</span></p> <p><span class="quantity">' + json.productquantity + '</span> x <span class="discounted">' + json.price + '</span> $' + $ambprice + '</p></div> </div>');
					}
				}else {
					if ($current.length) {
						$current.find(".quantity").html(json.productquantity);
						$current.remove();
						$("#mini_cart .items").prepend('<div class="item clear" data-id="' + json.pid + '" data-pvid="'+json.pvid+'"><div class="item-img"><img class="inline-block" src="' + json.thumb + '"></div><div class="item-text"><p class="name"><span>' + json.name + '</span><span data-id="' + json.pid + '" data-pvid="'+json.pvid+'" class="close x-grey"><span class="icon-x block"></span></span></p><p><span>'+json.var_title+'</span></p> <p><span class="quantity">' + json.productquantity + '</span> x $' + json.price + '</p></div> </div>');
					}else {
						$("#mini_cart .items").prepend('<div class="item clear" data-id="' + json.pid + '" data-pvid="'+json.pvid+'"><div class="item-img"><img class="inline-block" src="' + json.thumb + '"></div><div class="item-text"><p class="name"><span>' + json.name + '</span><span data-id="' + json.pid + '" data-pvid="'+json.pvid+'" class="close x-grey"><span class="icon-x block"></span></span></p><p><span>'+json.var_title+'</span></p> <p><span class="quantity">' + json.productquantity + '</span> x $' + json.price + '</p></div> </div>');
					}
				}

				$(".badge.active").removeClass("pop").addClass("pop").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
					$(this).removeClass("pop");
				});
				
				event.preventDefault();
				$("body").addClass("cart--is--open");
				$(".mini-cart-overlay").fadeIn(240);

			}

		},
		error: function(json) {
			$("#btnAddtoCart").removeClass("loading");
			console.log("error adding to cart");
			console.dir(json);
		}

	});
});

// Toggle Mini Cart
$('.header-active').on('click', '#header_cart_button', function(event) {
	event.preventDefault();
	$("body").addClass("cart--is--open");
	$(".mini-cart-overlay").fadeIn(240);
});
$('body').on('click', '.mini-cart-overlay, .close-cart', function() {
	$("body").removeClass("cart--is--open");
	$(".mini-cart-overlay").fadeOut(240);
});

// Delete Item from Cart via minicart
$('#mini_cart').on('click', '.close', function() {
	var item = $(this).closest(".item");
	id = item.attr("data-id");
	pvid = item.attr('data-pvid');
	$.ajax({
		type: "post",
		dataType: 'json',
		url: SITEURL + "/ajax/cart.php",
		data: {
			'removecart': 1,
			'id': id,
			'var_id' : pvid,
			'qty': 1
		},
		beforeSend: function() {
			$(".mini-cart .loading-overlay").show();
		},
		success: function(json) {
//			var oldValue = $("#stockval").val();
//			var newVal = parseInt(oldValue) - 1;
//			$("#stockval").val(newVal);
			updateCartInfo(json);
			$(".mini-cart .loading-overlay").hide();
		},
		error: function() {
			console.log("error adding to cart");
		}

	});

});

// Close mini cart when clicked outside
// $(document).mouseup(function (e) {
// 	var container = $("#mini_cart, .add-to-cart, #header_cart_button");
// 	if (!container.is(e.target) && container.has(e.target).length === 0) {
// 		$("#mini_cart").hide();
// 	}
// });




$(".country_error").on("click", function() {
	var message = "<script class='jbox-popuptemp' type='text/javascript'> var options = {content: 'Currently we only ship within Canada. Follow us on Instagram for updates.', autoClose: 9400, attributes: {x: 'right', y: 'bottom'}, addClass:'error'}; new jBox('Notice', options); </script>";

	$("#javascript-box").append(message);
});



function updateCartInfo(json) {
	$(".badge").addClass("active");
	$(".header_cart_count").html(json.cartquantity);
	$("#mini_cart .count").html(json.cartquantity);
	$("#mini_cart .subtotal").html(json.cartcost);

	$("#subtotal").html(json.cartcost);
	
	
	var $current = $("#mini_cart").find("[data-id='" + json.pid + "'][data-pvid='"+json.pvid+"']");

	$(".cart-table").find("[data-id='" + json.pid + "'][data-pvid='"+json.pvid+"']").find(".productTotal").html(json.producttotal);
	
	
	if (json.cartquantity == 0) {
		$("#mini_cart .items .item").hide();
		$("#mini_cart .items").prepend('<p class="empty-text appear-animation">You have no items in your cart.</p>');
	}
	else {
		
		if ($current.length) {
			$current.find(".quantity").html(json.productquantity);
			
			if (json.productquantity == 0) {
				$current.remove();
			}
		}else {
			$("#mini_cart .items .empty-text").hide();
			$("#mini_cart .items").prepend('<div class="item clear" data-id="' + json.pid + '"><img class="inline" src="' + json.thumb + '"><div class="text inline"><p class="name"><span>' + json.name + '</span><span data-id="' + json.pid + '" class="close sprite x-grey"></span></p> <p><span class="quantity">' + json.productquantity + '</span> x $' + json.price + '</p> <p>' + json.description + '</p> </div> </div>');
		}
		
	}


	

	$(".badge.active").removeClass("pop").addClass("pop").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
		$(this).removeClass("pop");
	});
}


/* Product Quantity Increase */
$("#page-cart .input-number-increment").on("click", function() {

	var oldValue = $(this).parent().find("input").val();
	var newVal = parseInt(oldValue) + 1;
	var maxVal = $(this).parent().find("input").attr("data-max");

	if (newVal <= 20 && newVal <= maxVal) {
		$(this).parent().find("input").val(newVal);

		var item = $(this).closest(".product-row");
		id = item.attr("data-id");
		var_id = item.attr('data-pvid');
		
		$.ajax({
			type: "post",
			dataType: 'json',
			url: SITEURL + "/ajax/cart.php",
			data: {
				'addtocart': 1,
				'id': id,
				'qty': 1,
				'var_id':var_id
			},
			beforeSend: function() {
				$(".loading-overlay").show();
			},
			success: function(json) {
				updateCartInfo(json);
				$(".loading-overlay").hide();
			},
			error: function() {
				$(".loading-overlay").hide();
				console.log("error adding to cart");
			}

		});
	}

});

/* Product Quantity Decrease */
$("#page-cart .input-number-decrement").on("click", function() {
	
	var oldValue = $(this).parent().find("input").val();
	var newVal = parseInt(oldValue) - 1;

	if (newVal >= 1) {
		$(this).parent().find("input").val(newVal);


		var item = $(this).closest(".product-row");
		id = item.attr("data-id");
		var_id = item.attr('data-pvid');

		$.ajax({
			type: "post",
			dataType: 'json',
			url: SITEURL + "/ajax/cart.php",
			data: {
				'removecart': 1,
				'id': id,
				'qty': 1,
				'var_id':var_id
			},
			beforeSend: function() {
				$(".loading-overlay").show();
			},
			success: function(json) {
				updateCartInfo(json);
				$(".loading-overlay").hide();
			},
			error: function() {
				$(".loading-overlay").hide();
				console.log("error adding to cart");
			}

		});

	}

});


/* Product Remove */
$("#page-cart .cart-remove").on("click", function() {
	var item = $(this).closest(".product-row");
	id = item.attr("data-id");
	pvid = item.attr('data-pvid');
	$.ajax({
		type: "post",
		dataType: 'json',
		url: SITEURL + "/ajax/cart.php",
		data: {
			'delcart': 1,
			'id': id,
			'pvid':pvid,
			'qty': 1
		},
		beforeSend: function() {
			$(".loading-overlay").show();
		},
		success: function(json) {
			updateCartInfo(json);
			$(".loading-overlay").hide();
			$(".cart-table").find("[data-id='" + json.pid + "'][data-pvid='"+ json.pvid +"']").fadeOut(0, function() {
				$(this).remove();
				$("#mini_cart").find("[data-id='" + id + "'][data-pvid='"+json.pvid+"']").remove();
				if (json.cartquantity == 0) {
					$("#mini_cart .empty-text").show();
					$(".badge").removeClass("active");
					$(".cart-table tbody").html('<tr><td class="empty-cart" colspan="5">Your cart is empty, find some cool stuff in the <a href="' + SITEURL +'/products">shop</a>.</td></tr>');
				}
			});
		},
		error: function() {
			console.log("error adding to cart");
			$(".loading-overlay").hide();
		}
	});
});





/** Profile page **/

/* == Update Profile Info == */
function fieldValid(x) {
     if (x.val().length > 0) {
     	x.removeClass("error");
     	return true;
     }else {
     	x.addClass("error");
     	return false;
     }
}
$('body').on('click', '.updateName', function() {

	fieldValid($("#fname"));

	$.ajax({
		type: "post",
		dataType: 'json',
		url: SITEURL + "/ajax/user.php",
		data: {
			'updateName': 1,
			'id': $(this).attr("data-id"),
			'section': $(this).attr("data-name"),
			'fname': $("#fname").val(),
			'lname': $("#lname").val()
		},
		beforeSend: function() {
			$(".updateName").addClass("disabled");
			$(".updateName").html("Loading");
		},
		success: function(json) {
			$(".updateName").removeClass("disabled");
			$(".updateName").html("Save Changes");

			$("#"+json.section).removeClass('show').find('.form.view').slideUp(450);
			$("#dis_fullname").html(json.fullname);
			$("#dis_fullname2").html(json.fullname);
			$("#javascript-box").append(json.message);
		},
		error: function(json) {
			$(".updateName").removeClass("disabled");
			$(".updateName").html("Save Changes");

			console.log('error');
		}
	});
});

$('body').on('click', '.updateEmail', function() {

	fieldValid($("#email"));

	$.ajax({
		type: "post",
		dataType: 'json',
		url: SITEURL + "/ajax/user.php",
		data: {
			'updateEmail': 1,
			'id': $(this).attr("data-id"),
			'section': $(this).attr("data-name"),
			'email': $("#email").val()
		},
		beforeSend: function() {
			$(".updateEmail").addClass("disabled");
			$(".updateEmail").html("Loading");
		},
		success: function(json) {
			$(".updateEmail").removeClass("disabled");
			$(".updateEmail").html("Save Changes");

			$("#"+json.section).removeClass('show').find('.form.view').slideUp(450);
			$("#dis_email").html(json.email);
			$("#javascript-box").append(json.message);
			console.log(json.message);

		},
		error: function(json) {
			$(".updateEmail").removeClass("disabled");
			$(".updateEmail").html("Save Changes");
			console.log(json.message);
		}
	});
});

$('body').on('click', '.updatePassword', function() {

	if (fieldValid($("#verifyPW"))) {
		$.ajax({
			type: "post",
			dataType: 'json',
			url: SITEURL + "/ajax/user.php",
			data: {
				'updatePassword': 1,
				'id': $(this).attr("data-id"),
				'section': $(this).attr("data-name"),
				'verifyPW': $("#verifyPW").val(),
				'newPW': $("#newPW").val(),
				'confirmPW': $("#confirmPW").val()
			},
			beforeSend: function() {
				$(".updatePassword").addClass("disabled");
				$(".updatePassword").html("Loading");
			},
			success: function(json) {
				$(".updatePassword").removeClass("disabled");
				$(".updatePassword").html("Save Changes");

				$("#"+json.section).removeClass('show').find('.form.view').slideUp(450);
				$("#javascript-box").append(json.message);
				$(".password-field").val("");
			},
			error: function() {
				$(".updatePassword").removeClass("disabled");
				$(".updatePassword").html("Save Changes");
			}
		});
	}

});


$('#form-validetta-shipping').validetta({
	showErrorMessages : false,
	errorClass : '_error',
	onValid : function( event ) {
		event.preventDefault(); // Will prevent the submission of the form

		$.ajax({
			type: "post",
			dataType: 'json',
			url: SITEURL + "/ajax/user.php",
			data: {
				'updateShipping': 1,
				'id': $('#form-validetta-shipping').attr("data-id"),
				'section': $('#form-validetta-shipping').attr("data-name"),
				'fullname': $("#fullname").val(),
				'address': $("#address_line_1").val(),
				'address2': $("#address_line_2").val(),
				'city': $("#city").val(),
				'state': $("#state").val(),
				'zip': $("#zip").val(),
				'telephone': $("#telephone").val()
			},
			beforeSend: function() {
				$(".updateShipping").addClass("disabled");
				$(".updateShipping").html("Loading");
			},
			success: function(json) {
				$(".updateShipping").removeClass("disabled");
				$(".updateShipping").html("Save Changes");

				$("#dis_address").html(json.address);
				$("#dis_address2").html("#" + json.address2 + " - ");
				$("#dis_city").html(json.city);
				$("#dis_state").html(json.state);
				$("#dis_zip").html(json.zip);

				$("#display_shippinginfo").show();

				$("#"+json.section).removeClass('show').find('.form.view').slideUp(450);
				$("#javascript-box").append(json.message);

			},
			error: function(json) {
				$(".updateShipping").removeClass("disabled");
				$(".updateShipping").html("Save Changes");
			}
		});

	},
	onError : function( event ){
		event.preventDefault(); // Will prevent the submission of the form
	}
});

$('#form-validetta-shipping input.required').blur(function() {
	if (!$(this).val()) {
		$(this).closest('div').addClass('_error');
	}else {
		$(this).closest('div').removeClass('_error');
	}
});


/* == Check Invite Code == */
$("#btnInvite").on("click", function() {
	$("#btnInvite").addClass("disabled");
	$("#btnInvite").removeClass("btn-loader-override");

	if($('#inviteCode').val() != ''){
		$.ajax({
			type: "post",
			url: SITEURL + "/ajax/user.php",
			dataType: 'json',
			data: {
				'inviteCode': $('#inviteCode').val()
			},
			beforeSend: function() {
				$("#btnInvite").addClass("disabled");
			},
			success: function(json) {
				$("#btnInvite").removeClass("disabled");
				$("#btnInvite").removeClass("loading");

				if (json.type == "success") {
					$("#javascript-box").append(json.message);
					$("#form-invite").hide();
					$("#form-registration").addClass("not-invisible");
				}
				else {
					$("#javascript-box").append(json.message);
				}

			},
			error: function(json) {
				$("#btnInvite").removeClass("disabled");
				$("#btnInvite").removeClass("loading");
				$("#javascript-box").append(json.message);
			}
		});
	}
	else {
		$("#inviteCode").addClass('_error _empty');
		setTimeout(function(){///workaround
            $("#btnInvite").removeClass("disabled");
            $("#btnInvite").removeClass("loading");
        }, 100);
	}
});

var tooltips;
tooltips = new jBox('Tooltip', {
  attach: '.tooltip'
});


/* == Switchery == */
var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

elems.forEach(function(html) {
  var switchery = new Switchery(html, { color: '#88c76c', secondaryColor: '#e74c3c' });
});