"use strict";

var _this2 = this;

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { _defineProperty(target, key, source[key]); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*-----------------------------------------------
|   Utilities
-----------------------------------------------*/
var utils = function ($) {
  var Utils = {
    $window: $(window),
    $document: $(document),
    $html: $('html'),
    $body: $('body'),
    $main: $('main'),
    isRTL: function isRTL() {
      return this.$html.attr('dir') === 'rtl';
    },
    location: window.location,
    nua: navigator.userAgent,
    breakpoints: {
      xs: 0,
      sm: 576,
      md: 768,
      lg: 992,
      xl: 1200,
      xxl: 1400
    },
    offset: function offset(element) {
      var rect = element.getBoundingClientRect();
      var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
      var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      return {
        top: rect.top + scrollTop,
        left: rect.left + scrollLeft
      };
    },
    isScrolledIntoViewJS: function isScrolledIntoViewJS(element) {
      var windowHeight = window.innerHeight;
      var elemTop = this.offset(element).top;
      var elemHeight = element.offsetHeight;
      var windowScrollTop = window.scrollY;
      return elemTop <= windowScrollTop + windowHeight && windowScrollTop <= elemTop + elemHeight;
    },
    isScrolledIntoView: function isScrolledIntoView(el) {
      var $el = $(el);
      var windowHeight = this.$window.height();
      var elemTop = $el.offset().top;
      var elemHeight = $el.height();
      var windowScrollTop = this.$window.scrollTop();
      return elemTop <= windowScrollTop + windowHeight && windowScrollTop <= elemTop + elemHeight;
    },
    getCurrentScreanBreakpoint: function getCurrentScreanBreakpoint() {
      var _this = this;

      var currentScrean = '';
      var windowWidth = this.$window.width();
      $.each(this.breakpoints, function (index, value) {
        if (windowWidth >= value) {
          currentScrean = index;
        } else if (windowWidth >= _this.breakpoints.xl) {
          currentScrean = 'xl';
        }
      });
      return {
        currentScrean: currentScrean,
        currentBreakpoint: this.breakpoints[currentScrean]
      };
    }
  };
  return Utils;
}(jQuery);
/*-----------------------------------------------
|   Top navigation opacity on scroll
-----------------------------------------------*/


utils.$document.ready(function () {
  var $navbar = $('.navbar-theme');

  if ($navbar.length) {
    var windowHeight = utils.$window.height();
    utils.$window.scroll(function () {
      var scrollTop = utils.$window.scrollTop();
      var alpha = scrollTop / windowHeight * 2;
      alpha >= 1 && (alpha = 1);
      $navbar.css({
        'background-color': "rgba(11, 23, 39, " + alpha + ")"
      });
    }); // Fix navbar background color [after and before expand]

    var classList = $navbar.attr('class').split(' ');
    var breakpoint = classList.filter(function (c) {
      return c.indexOf('navbar-expand-') >= 0;
    })[0].split('navbar-expand-')[1];
    utils.$window.resize(function () {
      if (utils.$window.width() > utils.breakpoints[breakpoint]) {
        return $navbar.removeClass('bg-dark');
      }

      if (!$navbar.find('.navbar-toggler').hasClass('collapsed')) {
        return $navbar.addClass('bg-dark');
      }

      return null;
    }); // Top navigation background toggle on mobile

    $navbar.on('show.bs.collapse hide.bs.collapse', function (e) {
      $(e.currentTarget).toggleClass('bg-dark');
    });
  }
});
/*-----------------------------------------------
|   Select menu [bootstrap 4]
-----------------------------------------------*/

utils.$document.ready(function () {
  // https://getbootstrap.com/docs/4.0/getting-started/browsers-devices/#select-menu
  // https://github.com/twbs/bootstrap/issues/26183
  window.is.android() && $('select.form-control').removeClass('form-control').css('width', '100%');
});
/*-----------------------------------------------
|   Bulk Actions
-----------------------------------------------*/

window.utils.$document.ready(function () {
  var checkboxBulkSelects = $('.checkbox-bulk-select');

  if (checkboxBulkSelects.length) {
    var Event = {
      CLICK: 'click'
    };
    var Selector = {
      CHECKBOX_BULK_SELECT_CHECKBOX: '.checkbox-bulk-select-target'
    };
    var ClassName = {
      D_NONE: 'd-none'
    };
    var DATA_KEY = {
      CHECKBOX_BODY: 'checkbox-body',
      CHECKBOX_ACTIONS: 'checkbox-actions',
      CHECKBOX_REPLACED_ELEMENT: 'checkbox-replaced-element'
    };
    var Attribute = {
      CHECKED: 'checked',
      INDETERMINATE: 'indeterminate'
    };
    checkboxBulkSelects.each(function (index, value) {
      var checkboxBulkAction = $(value);
      var bulkActions = $(checkboxBulkAction.data(DATA_KEY.CHECKBOX_ACTIONS));
      var replacedElement = $(checkboxBulkAction.data(DATA_KEY.CHECKBOX_REPLACED_ELEMENT));
      var rowCheckboxes = $(checkboxBulkAction.data(DATA_KEY.CHECKBOX_BODY)).find(Selector.CHECKBOX_BULK_SELECT_CHECKBOX);
      checkboxBulkAction.on(Event.CLICK, function () {
        if (checkboxBulkAction.attr(Attribute.INDETERMINATE) === Attribute.INDETERMINATE) {
          bulkActions.addClass(ClassName.D_NONE);
          replacedElement.removeClass(ClassName.D_NONE);
          checkboxBulkAction.prop(Attribute.INDETERMINATE, false).attr(Attribute.INDETERMINATE, false);
          checkboxBulkAction.prop(Attribute.CHECKED, false).attr(Attribute.CHECKED, false);
          rowCheckboxes.prop(Attribute.CHECKED, false).attr(Attribute.CHECKED, false);
        } else {
          bulkActions.toggleClass(ClassName.D_NONE);
          replacedElement.toggleClass(ClassName.D_NONE);

          if (checkboxBulkAction.attr(Attribute.CHECKED)) {
            checkboxBulkAction.prop(Attribute.CHECKED, false).attr(Attribute.CHECKED, false);
          } else {
            checkboxBulkAction.prop(Attribute.CHECKED, true).attr(Attribute.CHECKED, true);
          }

          rowCheckboxes.each(function (i, v) {
            var $this = $(v);

            if ($this.attr(Attribute.CHECKED)) {
              $this.prop(Attribute.CHECKED, false).attr(Attribute.CHECKED, false);
            } else {
              $this.prop(Attribute.CHECKED, true).attr(Attribute.CHECKED, true);
            }
          });
        }
      });
      rowCheckboxes.on(Event.CLICK, function (e) {
        var $this = $(e.target);

        if ($this.attr(Attribute.CHECKED)) {
          $this.prop(Attribute.CHECKED, false).attr(Attribute.CHECKED, false);
        } else {
          $this.prop(Attribute.CHECKED, true).attr(Attribute.CHECKED, true);
        }

        rowCheckboxes.each(function (i, v) {
          var $elem = $(v);

          if ($elem.attr(Attribute.CHECKED)) {
            checkboxBulkAction.prop(Attribute.INDETERMINATE, true).attr(Attribute.INDETERMINATE, Attribute.INDETERMINATE);
            bulkActions.removeClass(ClassName.D_NONE);
            replacedElement.addClass(ClassName.D_NONE);
            return false;
          }

          if (i === checkboxBulkAction.length) {
            checkboxBulkAction.prop(Attribute.INDETERMINATE, false).attr(Attribute.INDETERMINATE, false);
            checkboxBulkAction.prop(Attribute.CHECKED, false).attr(Attribute.CHECKED, false);
            bulkActions.addClass(ClassName.D_NONE);
            replacedElement.removeClass(ClassName.D_NONE);
          }

          return true;
        });
      });
    });
  }
});

/*-----------------------------------------------
|   Copy link
-----------------------------------------------*/

utils.$document.ready(function () {
  $('#copyLinkModal').on('shown.bs.modal', function () {
    $('.invitation-link').focus().select();
  });
});
/*-----------------------------------------------
|   Count Up
-----------------------------------------------*/

utils.$document.ready(function () {
  var $counters = $('[data-countup]');

  if ($counters.length) {
    $counters.each(function (index, value) {
      var $counter = $(value);
      var counter = $counter.data('countup');

      var toAlphanumeric = function toAlphanumeric(num) {
        var number = num;
        var abbreviations = {
          k: 1000,
          m: 1000000,
          b: 1000000000,
          t: 1000000000000
        };

        if (num < abbreviations.m) {
          number = (num / abbreviations.k).toFixed(2) + "k";
        } else if (num < abbreviations.b) {
          number = (num / abbreviations.m).toFixed(2) + "m";
        } else if (num < abbreviations.t) {
          number = (num / abbreviations.b).toFixed(2) + "b";
        } else {
          number = (num / abbreviations.t).toFixed(2) + "t";
        }

        return number;
      };

      var toComma = function toComma(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      };

      var toSpace = function toSpace(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
      };

      var playCountUpTriggered = false;

      var countUP = function countUP() {
        if (utils.isScrolledIntoView(value) && !playCountUpTriggered) {
          if (!playCountUpTriggered) {
            $({
              countNum: 0
            }).animate({
              countNum: counter.count
            }, {
              duration: counter.duration || 1000,
              easing: 'linear',
              step: function step() {
                $counter.text((counter.prefix ? counter.prefix : '') + Math.floor(this.countNum));
              },
              complete: function complete() {
                switch (counter.format) {
                  case 'comma':
                    $counter.text((counter.prefix ? counter.prefix : '') + toComma(this.countNum));
                    break;

                  case 'space':
                    $counter.text((counter.prefix ? counter.prefix : '') + toSpace(this.countNum));
                    break;

                  case 'alphanumeric':
                    $counter.text((counter.prefix ? counter.prefix : '') + toAlphanumeric(this.countNum));
                    break;

                  default:
                    $counter.text((counter.prefix ? counter.prefix : '') + this.countNum);
                }
              }
            });
            playCountUpTriggered = true;
          }
        }

        return playCountUpTriggered;
      };

      countUP();
      utils.$window.scroll(function () {
        countUP();
      });
    });
  }
});
/*-----------------------------------------------
|   Data table
-----------------------------------------------*/

window.utils.$document.ready(function () {
  var dataTables = $('.data-table');

  var customDataTable = function customDataTable(elem) {
    elem.find('table').find('tfoot').addClass('bg-200');
    elem.find('.pagination').addClass('pagination-sm').closest('[class*="col"]').removeClass('col-sm-12 col-md-7').addClass('col-auto mt-2').closest('.row').addClass('no-gutters justify-content-center justify-content-md-between');
  };

  dataTables.length && dataTables.each(function (index, value) {
    var $this = $(value);
    $this.DataTable({
      responsive: true
    });
    var $wrpper = $this.closest('.dataTables_wrapper');
    customDataTable($wrpper);
    $this.on('draw.dt', function () {
      return customDataTable($wrpper);
    });
  });
});
/*-----------------------------------------------
|   Countdown
-----------------------------------------------*/

utils.$document.ready(function () {
  var $dataCountdowns = $('[data-countdown]');
  var DATA_KEY = {
    FALLBACK: 'countdown-fallback',
    COUNTDOWN: 'countdown'
  };

  if ($dataCountdowns.length) {
    $dataCountdowns.each(function (index, value) {
      var $dateCountdown = $(value);
      var date = $dateCountdown.data(DATA_KEY.COUNTDOWN);
      var fallback;

      if (_typeof($dateCountdown.data(DATA_KEY.FALLBACK)) !== _typeof(undefined)) {
        fallback = $dateCountdown.data(DATA_KEY.FALLBACK);
      }

      $dateCountdown.countdown(date, function (event) {
        if (event.elapsed) {
          $dateCountdown.text(fallback);
        } else {
          $dateCountdown.text(event.strftime('%D days %H:%M:%S'));
        }
      });
    });
  }
});
/*-----------------------------------------------
|   Detector
-----------------------------------------------*/

utils.$document.ready(function () {
  if (window.is.opera()) utils.$html.addClass('opera');
  if (window.is.mobile()) utils.$html.addClass('mobile');
  if (window.is.firefox()) utils.$html.addClass('firefox');
  if (window.is.safari()) utils.$html.addClass('safari');
  if (window.is.ios()) utils.$html.addClass('ios');
  if (window.is.ie()) utils.$html.addClass('ie');
  if (window.is.edge()) utils.$html.addClass('edge');
  if (window.is.chrome()) utils.$html.addClass('chrome');
  if (utils.nua.match(/puppeteer/i)) utils.$html.addClass('puppeteer');
  if (window.is.mac()) utils.$html.addClass('osx');
});
/*-----------------------------------------------
|   Documentation and Component Navigation
-----------------------------------------------*/

utils.$document.ready(function () {
  var $componentNav = $('#components-nav');

  if ($componentNav.length) {
    var loc = window.location.href;

    var _loc$split = loc.split('#');

    loc = _loc$split[0];
    var location = loc.split('/');
    var url = location[location.length - 2] + "/" + location.pop();
    var urls = $componentNav.children('li').children('a');

    for (var i = 0, max = urls.length; i < max; i += 1) {
      var dom = urls[i].href.split('/');
      var domURL = dom[dom.length - 2] + "/" + dom.pop();

      if (domURL === url) {
        var $targetedElement = $(urls[i]);
        $targetedElement.removeClass('text-800');
        $targetedElement.addClass('font-weight-medium');
        break;
      }
    }
  }
});
/*-----------------------------------------------
|   On page scroll for #id targets
-----------------------------------------------*/

utils.$document.ready(function ($) {
  $('a[data-fancyscroll]').click(function scrollTo(e) {
    // const $this = $(e.currentTarget);
    var $this = $(this);

    if (utils.location.pathname === $this[0].pathname && utils.location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && utils.location.hostname === this.hostname) {
      e.preventDefault();
      var target = $(this.hash);
      target = target.length ? target : $("[name=" + this.hash.slice(1) + "]");

      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top - ($this.data('offset') || 0)
        }, 400, 'swing', function () {
          var hash = $this.attr('href');
          window.history.pushState ? window.history.pushState(null, null, hash) : window.location.hash = hash;
        });
        return false;
      }
    }

    return true;
  });
  var hash = window.location.hash;

  if (hash && document.getElementById(hash.slice(1))) {
    var $this = $(hash);
    $('html,body').animate({
      scrollTop: $this.offset().top - $("a[href='" + hash + "']").data('offset')
    }, 400, 'swing', function () {
      window.history.pushState ? window.history.pushState(null, null, hash) : window.location.hash = hash;
    });
  }
});
/*-----------------------------------------------
|   Flatpickr
-----------------------------------------------*/

window.utils.$document.ready(function () {
  var select2 = $('.selectpicker');
  select2.length && select2.each(function (index, value) {
    var $this = $(value);
    var options = $.extend({}, $this.data('options'));
    $this.select2(options);
  });
});
window.utils.$document.ready(function () {
  var datetimepicker = $('.datetimepicker');
  datetimepicker.length && datetimepicker.each(function (index, value) {
    var $this = $(value);
    var options = $.extend({
      dateFormat: 'd/m/y'
    }, $this.data('options'));
    $this.attr('placeholder', options.dateFormat);
    $this.flatpickr(options);
  });
});
/*-----------------------------------------------
|  Flex slider
-----------------------------------------------*/

utils.$document.ready(function () {
  var flexslider = $('.flexslider');

  if (flexslider.length) {
    flexslider.each(function (item, value) {
      var $this = $(value);
      $this.flexslider($.extend({
        prevText: '<span class="indicator-arrow indicator-arrow-left"></span>',
        nextText: '<span class="indicator-arrow indicator-arrow-right"></span>'
      }, $this.data('options')));
    });
  }
});
/*-----------------------------------------------
|   Bootstrap validation
-----------------------------------------------*/

(function () {
  window.addEventListener('load', function () {
    // Fetch all the forms we want to apply theme Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation'); // Loop over them and prevent submission

    Array.prototype.filter.call(forms, function (form) {
      form.addEventListener('submit', function (event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
/*-----------------------------------------------
|   Gooogle Map
-----------------------------------------------*/

/*
  global google
*/


function initMap() {
  var $googlemaps = $('.googlemap');

  if ($googlemaps.length) {
    // Visit https://snazzymaps.com/ for more themes
    var mapStyles = {
      Default: [{
        featureType: 'water',
        elementType: 'geometry',
        stylers: [{
          color: '#e9e9e9'
        }, {
          lightness: 17
        }]
      }, {
        featureType: 'landscape',
        elementType: 'geometry',
        stylers: [{
          color: '#f5f5f5'
        }, {
          lightness: 20
        }]
      }, {
        featureType: 'road.highway',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#ffffff'
        }, {
          lightness: 17
        }]
      }, {
        featureType: 'road.highway',
        elementType: 'geometry.stroke',
        stylers: [{
          color: '#ffffff'
        }, {
          lightness: 29
        }, {
          weight: 0.2
        }]
      }, {
        featureType: 'road.arterial',
        elementType: 'geometry',
        stylers: [{
          color: '#ffffff'
        }, {
          lightness: 18
        }]
      }, {
        featureType: 'road.local',
        elementType: 'geometry',
        stylers: [{
          color: '#ffffff'
        }, {
          lightness: 16
        }]
      }, {
        featureType: 'poi',
        elementType: 'geometry',
        stylers: [{
          color: '#f5f5f5'
        }, {
          lightness: 21
        }]
      }, {
        featureType: 'poi.park',
        elementType: 'geometry',
        stylers: [{
          color: '#dedede'
        }, {
          lightness: 21
        }]
      }, {
        elementType: 'labels.text.stroke',
        stylers: [{
          visibility: 'on'
        }, {
          color: '#ffffff'
        }, {
          lightness: 16
        }]
      }, {
        elementType: 'labels.text.fill',
        stylers: [{
          saturation: 36
        }, {
          color: '#333333'
        }, {
          lightness: 40
        }]
      }, {
        elementType: 'labels.icon',
        stylers: [{
          visibility: 'off'
        }]
      }, {
        featureType: 'transit',
        elementType: 'geometry',
        stylers: [{
          color: '#f2f2f2'
        }, {
          lightness: 19
        }]
      }, {
        featureType: 'administrative',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#fefefe'
        }, {
          lightness: 20
        }]
      }, {
        featureType: 'administrative',
        elementType: 'geometry.stroke',
        stylers: [{
          color: '#fefefe'
        }, {
          lightness: 17
        }, {
          weight: 1.2
        }]
      }],
      Gray: [{
        featureType: 'all',
        elementType: 'labels.text.fill',
        stylers: [{
          saturation: 36
        }, {
          color: '#000000'
        }, {
          lightness: 40
        }]
      }, {
        featureType: 'all',
        elementType: 'labels.text.stroke',
        stylers: [{
          visibility: 'on'
        }, {
          color: '#000000'
        }, {
          lightness: 16
        }]
      }, {
        featureType: 'all',
        elementType: 'labels.icon',
        stylers: [{
          visibility: 'off'
        }]
      }, {
        featureType: 'administrative',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 20
        }]
      }, {
        featureType: 'administrative',
        elementType: 'geometry.stroke',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 17
        }, {
          weight: 1.2
        }]
      }, {
        featureType: 'landscape',
        elementType: 'geometry',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 20
        }]
      }, {
        featureType: 'poi',
        elementType: 'geometry',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 21
        }]
      }, {
        featureType: 'road.highway',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 17
        }]
      }, {
        featureType: 'road.highway',
        elementType: 'geometry.stroke',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 29
        }, {
          weight: 0.2
        }]
      }, {
        featureType: 'road.arterial',
        elementType: 'geometry',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 18
        }]
      }, {
        featureType: 'road.local',
        elementType: 'geometry',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 16
        }]
      }, {
        featureType: 'transit',
        elementType: 'geometry',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 19
        }]
      }, {
        featureType: 'water',
        elementType: 'geometry',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 17
        }]
      }],
      Midnight: [{
        featureType: 'all',
        elementType: 'labels.text.fill',
        stylers: [{
          color: '#ffffff'
        }]
      }, {
        featureType: 'all',
        elementType: 'labels.text.stroke',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 13
        }]
      }, {
        featureType: 'administrative',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#000000'
        }]
      }, {
        featureType: 'administrative',
        elementType: 'geometry.stroke',
        stylers: [{
          color: '#144b53'
        }, {
          lightness: 14
        }, {
          weight: 1.4
        }]
      }, {
        featureType: 'landscape',
        elementType: 'all',
        stylers: [{
          color: '#08304b'
        }]
      }, {
        featureType: 'poi',
        elementType: 'geometry',
        stylers: [{
          color: '#0c4152'
        }, {
          lightness: 5
        }]
      }, {
        featureType: 'road.highway',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#000000'
        }]
      }, {
        featureType: 'road.highway',
        elementType: 'geometry.stroke',
        stylers: [{
          color: '#0b434f'
        }, {
          lightness: 25
        }]
      }, {
        featureType: 'road.arterial',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#000000'
        }]
      }, {
        featureType: 'road.arterial',
        elementType: 'geometry.stroke',
        stylers: [{
          color: '#0b3d51'
        }, {
          lightness: 16
        }]
      }, {
        featureType: 'road.local',
        elementType: 'geometry',
        stylers: [{
          color: '#000000'
        }]
      }, {
        featureType: 'transit',
        elementType: 'all',
        stylers: [{
          color: '#146474'
        }]
      }, {
        featureType: 'water',
        elementType: 'all',
        stylers: [{
          color: '#021019'
        }]
      }],
      Hopper: [{
        featureType: 'water',
        elementType: 'geometry',
        stylers: [{
          hue: '#165c64'
        }, {
          saturation: 34
        }, {
          lightness: -69
        }, {
          visibility: 'on'
        }]
      }, {
        featureType: 'landscape',
        elementType: 'geometry',
        stylers: [{
          hue: '#b7caaa'
        }, {
          saturation: -14
        }, {
          lightness: -18
        }, {
          visibility: 'on'
        }]
      }, {
        featureType: 'landscape.man_made',
        elementType: 'all',
        stylers: [{
          hue: '#cbdac1'
        }, {
          saturation: -6
        }, {
          lightness: -9
        }, {
          visibility: 'on'
        }]
      }, {
        featureType: 'road',
        elementType: 'geometry',
        stylers: [{
          hue: '#8d9b83'
        }, {
          saturation: -89
        }, {
          lightness: -12
        }, {
          visibility: 'on'
        }]
      }, {
        featureType: 'road.highway',
        elementType: 'geometry',
        stylers: [{
          hue: '#d4dad0'
        }, {
          saturation: -88
        }, {
          lightness: 54
        }, {
          visibility: 'simplified'
        }]
      }, {
        featureType: 'road.arterial',
        elementType: 'geometry',
        stylers: [{
          hue: '#bdc5b6'
        }, {
          saturation: -89
        }, {
          lightness: -3
        }, {
          visibility: 'simplified'
        }]
      }, {
        featureType: 'road.local',
        elementType: 'geometry',
        stylers: [{
          hue: '#bdc5b6'
        }, {
          saturation: -89
        }, {
          lightness: -26
        }, {
          visibility: 'on'
        }]
      }, {
        featureType: 'poi',
        elementType: 'geometry',
        stylers: [{
          hue: '#c17118'
        }, {
          saturation: 61
        }, {
          lightness: -45
        }, {
          visibility: 'on'
        }]
      }, {
        featureType: 'poi.park',
        elementType: 'all',
        stylers: [{
          hue: '#8ba975'
        }, {
          saturation: -46
        }, {
          lightness: -28
        }, {
          visibility: 'on'
        }]
      }, {
        featureType: 'transit',
        elementType: 'geometry',
        stylers: [{
          hue: '#a43218'
        }, {
          saturation: 74
        }, {
          lightness: -51
        }, {
          visibility: 'simplified'
        }]
      }, {
        featureType: 'administrative.province',
        elementType: 'all',
        stylers: [{
          hue: '#ffffff'
        }, {
          saturation: 0
        }, {
          lightness: 100
        }, {
          visibility: 'simplified'
        }]
      }, {
        featureType: 'administrative.neighborhood',
        elementType: 'all',
        stylers: [{
          hue: '#ffffff'
        }, {
          saturation: 0
        }, {
          lightness: 100
        }, {
          visibility: 'off'
        }]
      }, {
        featureType: 'administrative.locality',
        elementType: 'labels',
        stylers: [{
          hue: '#ffffff'
        }, {
          saturation: 0
        }, {
          lightness: 100
        }, {
          visibility: 'off'
        }]
      }, {
        featureType: 'administrative.land_parcel',
        elementType: 'all',
        stylers: [{
          hue: '#ffffff'
        }, {
          saturation: 0
        }, {
          lightness: 100
        }, {
          visibility: 'off'
        }]
      }, {
        featureType: 'administrative',
        elementType: 'all',
        stylers: [{
          hue: '#3a3935'
        }, {
          saturation: 5
        }, {
          lightness: -57
        }, {
          visibility: 'off'
        }]
      }, {
        featureType: 'poi.medical',
        elementType: 'geometry',
        stylers: [{
          hue: '#cba923'
        }, {
          saturation: 50
        }, {
          lightness: -46
        }, {
          visibility: 'on'
        }]
      }],
      Beard: [{
        featureType: 'poi.business',
        elementType: 'labels.text',
        stylers: [{
          visibility: 'on'
        }, {
          color: '#333333'
        }]
      }],
      AssassianCreed: [{
        featureType: 'all',
        elementType: 'all',
        stylers: [{
          visibility: 'on'
        }]
      }, {
        featureType: 'all',
        elementType: 'labels',
        stylers: [{
          visibility: 'off'
        }, {
          saturation: '-100'
        }]
      }, {
        featureType: 'all',
        elementType: 'labels.text.fill',
        stylers: [{
          saturation: 36
        }, {
          color: '#000000'
        }, {
          lightness: 40
        }, {
          visibility: 'off'
        }]
      }, {
        featureType: 'all',
        elementType: 'labels.text.stroke',
        stylers: [{
          visibility: 'off'
        }, {
          color: '#000000'
        }, {
          lightness: 16
        }]
      }, {
        featureType: 'all',
        elementType: 'labels.icon',
        stylers: [{
          visibility: 'off'
        }]
      }, {
        featureType: 'administrative',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 20
        }]
      }, {
        featureType: 'administrative',
        elementType: 'geometry.stroke',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 17
        }, {
          weight: 1.2
        }]
      }, {
        featureType: 'landscape',
        elementType: 'geometry',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 20
        }]
      }, {
        featureType: 'landscape',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#4d6059'
        }]
      }, {
        featureType: 'landscape',
        elementType: 'geometry.stroke',
        stylers: [{
          color: '#4d6059'
        }]
      }, {
        featureType: 'landscape.natural',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#4d6059'
        }]
      }, {
        featureType: 'poi',
        elementType: 'geometry',
        stylers: [{
          lightness: 21
        }]
      }, {
        featureType: 'poi',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#4d6059'
        }]
      }, {
        featureType: 'poi',
        elementType: 'geometry.stroke',
        stylers: [{
          color: '#4d6059'
        }]
      }, {
        featureType: 'road',
        elementType: 'geometry',
        stylers: [{
          visibility: 'on'
        }, {
          color: '#7f8d89'
        }]
      }, {
        featureType: 'road',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#7f8d89'
        }]
      }, {
        featureType: 'road.highway',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#7f8d89'
        }, {
          lightness: 17
        }]
      }, {
        featureType: 'road.highway',
        elementType: 'geometry.stroke',
        stylers: [{
          color: '#7f8d89'
        }, {
          lightness: 29
        }, {
          weight: 0.2
        }]
      }, {
        featureType: 'road.arterial',
        elementType: 'geometry',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 18
        }]
      }, {
        featureType: 'road.arterial',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#7f8d89'
        }]
      }, {
        featureType: 'road.arterial',
        elementType: 'geometry.stroke',
        stylers: [{
          color: '#7f8d89'
        }]
      }, {
        featureType: 'road.local',
        elementType: 'geometry',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 16
        }]
      }, {
        featureType: 'road.local',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#7f8d89'
        }]
      }, {
        featureType: 'road.local',
        elementType: 'geometry.stroke',
        stylers: [{
          color: '#7f8d89'
        }]
      }, {
        featureType: 'transit',
        elementType: 'geometry',
        stylers: [{
          color: '#000000'
        }, {
          lightness: 19
        }]
      }, {
        featureType: 'water',
        elementType: 'all',
        stylers: [{
          color: '#2b3638'
        }, {
          visibility: 'on'
        }]
      }, {
        featureType: 'water',
        elementType: 'geometry',
        stylers: [{
          color: '#2b3638'
        }, {
          lightness: 17
        }]
      }, {
        featureType: 'water',
        elementType: 'geometry.fill',
        stylers: [{
          color: '#24282b'
        }]
      }, {
        featureType: 'water',
        elementType: 'geometry.stroke',
        stylers: [{
          color: '#24282b'
        }]
      }, {
        featureType: 'water',
        elementType: 'labels',
        stylers: [{
          visibility: 'off'
        }]
      }, {
        featureType: 'water',
        elementType: 'labels.text',
        stylers: [{
          visibility: 'off '
        }]
      }, {
        featureType: 'water',
        elementType: 'labels.text.fill',
        stylers: [{
          visibility: 'off'
        }]
      }, {
        featureType: 'water',
        elementType: 'labels.text.stroke',
        stylers: [{
          visibility: 'off'
        }]
      }, {
        featureType: 'water',
        elementType: 'labels.icon',
        stylers: [{
          visibility: 'off'
        }]
      }],
      SubtleGray: [{
        featureType: 'administrative',
        elementType: 'all',
        stylers: [{
          saturation: '-100'
        }]
      }, {
        featureType: 'administrative.province',
        elementType: 'all',
        stylers: [{
          visibility: 'off'
        }]
      }, {
        featureType: 'landscape',
        elementType: 'all',
        stylers: [{
          saturation: -100
        }, {
          lightness: 65
        }, {
          visibility: 'on'
        }]
      }, {
        featureType: 'poi',
        elementType: 'all',
        stylers: [{
          saturation: -100
        }, {
          lightness: '50'
        }, {
          visibility: 'simplified'
        }]
      }, {
        featureType: 'road',
        elementType: 'all',
        stylers: [{
          saturation: -100
        }]
      }, {
        featureType: 'road.highway',
        elementType: 'all',
        stylers: [{
          visibility: 'simplified'
        }]
      }, {
        featureType: 'road.arterial',
        elementType: 'all',
        stylers: [{
          lightness: '30'
        }]
      }, {
        featureType: 'road.local',
        elementType: 'all',
        stylers: [{
          lightness: '40'
        }]
      }, {
        featureType: 'transit',
        elementType: 'all',
        stylers: [{
          saturation: -100
        }, {
          visibility: 'simplified'
        }]
      }, {
        featureType: 'water',
        elementType: 'geometry',
        stylers: [{
          hue: '#ffff00'
        }, {
          lightness: -25
        }, {
          saturation: -97
        }]
      }, {
        featureType: 'water',
        elementType: 'labels',
        stylers: [{
          lightness: -25
        }, {
          saturation: -100
        }]
      }],
      Tripitty: [{
        featureType: 'all',
        elementType: 'labels',
        stylers: [{
          visibility: 'off'
        }]
      }, {
        featureType: 'administrative',
        elementType: 'all',
        stylers: [{
          visibility: 'off'
        }]
      }, {
        featureType: 'landscape',
        elementType: 'all',
        stylers: [{
          color: '#2c5ca5'
        }]
      }, {
        featureType: 'poi',
        elementType: 'all',
        stylers: [{
          color: '#2c5ca5'
        }]
      }, {
        featureType: 'road',
        elementType: 'all',
        stylers: [{
          visibility: 'off'
        }]
      }, {
        featureType: 'transit',
        elementType: 'all',
        stylers: [{
          visibility: 'off'
        }]
      }, {
        featureType: 'water',
        elementType: 'all',
        stylers: [{
          color: '#193a70'
        }, {
          visibility: 'on'
        }]
      }]
    };
    $googlemaps.each(function (index, value) {
      var $googlemap = $(value);
      var latLng = $googlemap.data('latlng').split(',');
      var markerPopup = $googlemap.html();
      var icon = $googlemap.data('icon') ? $googlemap.data('icon') : 'https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi.png';
      var zoom = $googlemap.data('zoom');
      var mapStyle = $googlemap.data('theme');
      var mapElement = value;

      if ($googlemap.data('theme') === 'streetview') {
        var pov = $googlemap.data('pov');
        var _mapOptions = {
          position: {
            lat: Number(latLng[0]),
            lng: Number(latLng[1])
          },
          pov: pov,
          zoom: zoom,
          gestureHandling: 'none',
          scrollwheel: false
        };
        return new google.maps.StreetViewPanorama(mapElement, _mapOptions);
      }

      var mapOptions = {
        zoom: zoom,
        scrollwheel: $googlemap.data('scrollwheel'),
        center: new google.maps.LatLng(latLng[0], latLng[1]),
        styles: mapStyles[mapStyle]
      };
      var map = new google.maps.Map(mapElement, mapOptions);
      var infowindow = new google.maps.InfoWindow({
        content: markerPopup
      });
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(latLng[0], latLng[1]),
        icon: icon,
        map: map
      });
      marker.addListener('click', function () {
        infowindow.open(map, marker);
      });
      return null;
    });
  }
}
/*-----------------------------------------------
|   Tabs
-----------------------------------------------*/


utils.$document.ready(function () {
  $(document).on('click', '[data-field]', function (e) {
    var $this = $(e.target);
    var inputField = $this.data('field');
    var $inputField = $this.parents('.input-group').children("." + inputField);
    var $btnType = $this.data('type');
    var value = parseInt($inputField.val(), 10);
    var min = $inputField.data('min');

    if (min) {
      min = parseInt(min, 10);
    } else {
      min = 0;
    }

    if ($btnType === 'plus') {
      value += 1;
    } else if (value > min) {
      value -= 1;
    }

    $inputField.val(value);
  });
});
/*-----------------------------------------------
|   jqvmap
-----------------------------------------------*/

/*-----------------------------------------------
|   Get color
-----------------------------------------------*/

var percentColors = [{
  pct: 0.0,
  color: {
    r: 0xde,
    g: 0xec,
    b: 0xfc
  }
}, {
  pct: 0.05,
  color: {
    r: 0x77,
    g: 0xb2,
    b: 0xf2
  }
}, {
  pct: 0.1,
  color: {
    r: 0x0c,
    g: 0x63,
    b: 0xbd
  }
}];

var getColorForPercentage = function getColorForPercentage(pct) {
  var i = 1;

  for (i; i < percentColors.length - 1; i += 1) {
    if (pct < percentColors[i].pct) {
      break;
    }
  }

  var lower = percentColors[i - 1];
  var upper = percentColors[i];
  var range = upper.pct - lower.pct;
  var rangePct = (pct - lower.pct) / range;
  var pctLower = 1 - rangePct;
  var pctUpper = rangePct;
  var color = {
    r: Math.floor(lower.color.r * pctLower + upper.color.r * pctUpper),
    g: Math.floor(lower.color.g * pctLower + upper.color.g * pctUpper),
    b: Math.floor(lower.color.b * pctLower + upper.color.b * pctUpper)
  };
  return "rgb(" + color.r + ", " + color.g + ", " + color.b + ")";
};

window.utils.$document.ready(function () {
  var getA = function getA(n, interval, initial) {
    if (interval === void 0) {
      interval = 1;
    }

    if (initial === void 0) {
      initial = 1;
    }

    return initial + (n - 1) * interval;
  };

  var getCommonDifference = function getCommonDifference(S, a, n) {
    return 2 * (S - a * n) / (n * (n - 1));
  };

  var interval = getCommonDifference(100, 1, 20);
  var countries = {
    us: Math.floor(getA(20, interval) * 1618),
    cn: Math.floor(getA(19, interval) * 1618),
    jp: Math.floor(getA(18, interval) * 1618),
    de: Math.floor(getA(17, interval) * 1618),
    gb: Math.floor(getA(16, interval) * 1618),
    fr: Math.floor(getA(15, interval) * 1618),
    in: Math.floor(getA(14, interval) * 1618),
    it: Math.floor(getA(13, interval) * 1618),
    br: Math.floor(getA(12, interval) * 1618),
    ca: Math.floor(getA(11, interval) * 1618),
    ru: Math.floor(getA(10, interval) * 1618),
    kr: Math.floor(getA(9, interval) * 1618),
    es: Math.floor(getA(8, interval) * 1618),
    au: Math.floor(getA(7, interval) * 1618),
    mx: Math.floor(getA(6, interval) * 1618),
    id: Math.floor(getA(5, interval) * 1618),
    nl: Math.floor(getA(4, interval) * 1618),
    tr: Math.floor(getA(3, interval) * 1618),
    sa: Math.floor(getA(2, interval) * 1618),
    ch: Math.floor(getA(1, interval) * 1618),
    za: Math.floor(getA(14, interval) * 1618)
  };

  var getSum = function getSum(array) {
    return array.reduce(function (a, b) {
      return a + b;
    }, 0);
  };

  var getColors = function getColors() {
    var colors = {};
    var countriesValues = Object.keys(countries).map(function (country) {
      return countries[country];
    });
    Object.keys(countries).map(function (country) {
      var ratio = countries[country] / getSum(countriesValues);
      colors[country] = getColorForPercentage(ratio);
      return false;
    });
    return colors;
  };
  /*-----------------------------------------------
  |   Map size
  -----------------------------------------------*/


  var setMapSize = function setMapSize(map) {
    var containerWidth = map.parent().width();
    var containerHeight = containerWidth / 1.618;
    map.css({
      width: containerWidth,
      height: containerHeight
    });
  };

  var vmaps = $('.vmap');
  vmaps.length && vmaps.each(function (index, value) {
    var $this = $(value);
    var options = $.extend({
      map: 'world_en',
      backgroundColor: '#ffffff',
      borderColor: '#d8e2ef',
      borderOpacity: 1,
      borderWidth: 1,
      color: '#d8e2ef',
      colors: getColors(),
      onLabelShow: function onLabelShow(event, label, code) {
        /* eslint-disable */
        if (Object.keys(countries).indexOf(code) >= 0) {
          label[0].innerHTML = "<strong>" + label[0].innerHTML + "</strong><br />Active user: " + countries[code];
        } else {
          label[0].innerHTML = "<strong>" + label[0].innerHTML + "</strong><br />Active user: 0";
        }
        /* eslint-enable */

      },
      enableZoom: false,
      hoverColor: '#39afd1',
      hoverOpacity: 0.5,
      normalizeFunction: 'linear',
      selectedColor: '#e63757',
      selectedRegions: null,
      showTooltip: true,
      onResize: function onResize() {
        setMapSize($this);
      }
    }, $this.data('options'));
    setMapSize($this);
    $this.vectorMap(options);
  });
});
/*-----------------------------------------------
|   Lightbox
-----------------------------------------------*/

/*
  global lightbox
*/

utils.$document.ready(function () {
  if ($('[data-lightbox]').length) {
    lightbox.option({
      resizeDuration: 400,
      wrapAround: true,
      fadeDuration: 300,
      imageFadeDuration: 300
    });
  }
});
/*-----------------------------------------------
|  Flex slider
-----------------------------------------------*/

utils.$document.ready(function () {
  var masks = $('[data-masking]');

  if (masks.length) {
    masks.each(function (item, value) {
      var $this = $(value);
      var options = $this.data('masking');
      $this.mask(options.mask, options.config ? options.config : '');
    });
  }
});
window.utils.$document.ready(function () {
  var _window = window,
      utils = _window.utils;
  var $window = utils.$window,
      breakpoints = utils.breakpoints;
  var navDropShadowFlag = true;
  var CLASS_NAME = {
    navbarGlassShadow: 'navbar-glass-shadow',
    collapsed: 'collapsed'
  };
  var SELECTOR = {
    navbar: '.navbar:not(.navbar-vertical)',
    navbarVertical: '.navbar-vertical',
    navbarToggler: '.navbar-toggler',
    navbarVerticalCollapse: '#navbarVerticalCollapse'
  };
  var $navbar = $(SELECTOR.navbar);
  var $navbarVerticalCollapse = $(SELECTOR.navbarVerticalCollapse);

  var setDropShadow = function setDropShadow($elem) {
    if ($elem.scrollTop() > 0 && navDropShadowFlag) {
      $navbar.addClass(CLASS_NAME.navbarGlassShadow);
    } else {
      $navbar.removeClass(CLASS_NAME.navbarGlassShadow);
    }
  };

  var breakPoint;
  var navbarVerticalClass = $(SELECTOR.navbarVertical).attr('class');

  if (navbarVerticalClass) {
    breakPoint = breakpoints[navbarVerticalClass.split(' ').filter(function (cls) {
      return cls.indexOf('navbar-expand-') === 0;
    }).pop().split('-').pop()];
  }

  $window.on('load scroll', function () {
    return setDropShadow($window);
  });
  $navbarVerticalCollapse.on('scroll', function () {
    navDropShadowFlag = true;
    setDropShadow($navbarVerticalCollapse);
  });
  $navbarVerticalCollapse.on('show.bs.collapse', function () {
    if ($window.width() < breakPoint) {
      navDropShadowFlag = false;
      setDropShadow($window);
    }
  });
  $navbarVerticalCollapse.on('hide.bs.collapse', function () {
    if ($navbarVerticalCollapse.hasClass('show') && $window.width() < breakPoint) {
      navDropShadowFlag = false;
    } else {
      navDropShadowFlag = true;
    }

    setDropShadow($window);
  });
});
/*-----------------------------------------------
|   Owl Carousel
-----------------------------------------------*/

var $carousel = $('.owl-carousel');
utils.$document.ready(function () {
  if ($carousel.length) {
    var Selector = {
      ALL_TIMELINE: '*[data-zanim-timeline]',
      ACTIVE_ITEM: '.owl-item.active'
    };
    var owlZanim = {
      zanimTimeline: function zanimTimeline($el) {
        return $el.find(Selector.ALL_TIMELINE);
      },
      play: function play($el) {
        if (this.zanimTimeline($el).length === 0) return;
        $el.find(Selector.ACTIVE_ITEM + " > " + Selector.ALL_TIMELINE).zanimation(function (animation) {
          animation.play();
        });
      },
      kill: function kill($el) {
        if (this.zanimTimeline($el).length === 0) return;
        this.zanimTimeline($el).zanimation(function (animation) {
          animation.kill();
        });
      }
    };
    $carousel.each(function (index, value) {
      var $this = $(value);
      var options = $this.data('options') || {};
      utils.isRTL() && (options.rtl = true);
      options.navText || (options.navText = ['<span class="fas fa-angle-left"></span>', '<span class="fas fa-angle-right"></span>']);
      options.touchDrag = true;
      $this.owlCarousel($.extend(options || {}, {
        onInitialized: function onInitialized(event) {
          owlZanim.play($(event.target));
        },
        onTranslate: function onTranslate(event) {
          owlZanim.kill($(event.target));
        },
        onTranslated: function onTranslated(event) {
          owlZanim.play($(event.target));
        }
      }));
    });
  }

  var $controllers = $('[data-owl-carousel-controller]');

  if ($controllers.length) {
    $controllers.each(function (index, value) {
      var $this = $(value);
      var $thumbs = $($this.data('owl-carousel-controller'));
      $thumbs.find('.owl-item:first-child').addClass('current');
      $thumbs.on('click', '.item', function (e) {
        var thumbIndex = $(e.target).parents('.owl-item').index();
        $('.owl-item').removeClass('current');
        $(e.target).parents('.owl-item').addClass('current');
        $this.trigger('to.owl.carousel', thumbIndex, 500);
      });
      $this.on('changed.owl.carousel', function (e) {
        var itemIndex = e.item.index;
        var item = itemIndex + 1;
        $('.owl-item').removeClass('current');
        $thumbs.find(".owl-item:nth-child(" + item + ")").addClass('current');
        $thumbs.trigger('to.owl.carousel', itemIndex, 500);
      });
    });
  }
});
/*-----------------------------------------------
|   Inline Player [plyr]
-----------------------------------------------*/

/*
  global Plyr
*/

utils.$document.ready(function () {
  var $players = $('.player');

  if ($players.length) {
    $players.each(function (index, value) {
      return new Plyr($(value), {
        captions: {
          active: true
        }
      });
    });
  }

  return false;
});
/*
 global ProgressBar
*/

utils.$document.ready(function () {
  // progressbar.js@1.0.0 version is used
  // Docs: http://progressbarjs.readthedocs.org/en/1.0.0/

  /*-----------------------------------------------
  |   Progress Circle
  -----------------------------------------------*/
  var progresCircle = $('.progress-circle');

  if (progresCircle.length) {
    progresCircle.each(function (index, value) {
      var $this = $(value);
      var options = $this.data('options');
      var bar = new ProgressBar.Circle(value, {
        color: '#aaa',
        // This has to be the same size as the maximum width to
        // prevent clipping
        strokeWidth: 2,
        trailWidth: 2,
        easing: 'easeInOut',
        duration: 3000,
        svgStyle: {
          'stroke-linecap': 'round',
          display: 'block',
          width: '100%'
        },
        text: {
          autoStyleContainer: false
        },
        from: {
          color: '#aaa',
          width: 2
        },
        to: {
          color: '#333',
          width: 2
        },
        // Set default step function for all animate calls
        step: function step(state, circle) {
          circle.path.setAttribute('stroke', state.color);
          circle.path.setAttribute('stroke-width', state.width);
          var percentage = Math.round(circle.value() * 100);
          circle.setText("<span class='value'>" + percentage + "<b>%</b></span> <span>" + options.text + "</span>");
        }
      });
      var playProgressTriggered = false;

      var progressCircleAnimation = function progressCircleAnimation() {
        if (!playProgressTriggered) {
          if (utils.isScrolledIntoView(value) || utils.nua.match(/puppeteer/i)) {
            bar.animate(options.progress / 100);
            playProgressTriggered = true;
          }
        }

        return playProgressTriggered;
      };

      progressCircleAnimation();
      utils.$window.scroll(function () {
        progressCircleAnimation();
      });
    });
  }
  /*-----------------------------------------------
  |   Progress Line
  -----------------------------------------------*/


  var progressLine = $('.progress-line');

  if (progressLine.length) {
    progressLine.each(function (index, value) {
      var $this = $(value);
      var options = $this.data('options');
      var bar = new ProgressBar.Line(value, {
        strokeWidth: 1,
        easing: 'easeInOut',
        duration: 3000,
        color: '#333',
        trailColor: '#eee',
        trailWidth: 1,
        svgStyle: {
          width: '100%',
          height: '0.25rem',
          'stroke-linecap': 'round',
          'border-radius': '0.125rem'
        },
        text: {
          style: {
            transform: null
          },
          autoStyleContainer: false
        },
        from: {
          color: '#aaa'
        },
        to: {
          color: '#111'
        },
        step: function step(state, line) {
          line.setText("<span class='value'>" + Math.round(line.value() * 100) + "<b>%</b></span> <span>" + options.text + "</span>");
        }
      });
      var playProgressTriggered = false;

      var progressLineAnimation = function progressLineAnimation() {
        if (!playProgressTriggered) {
          if (utils.isScrolledIntoView(value) || utils.nua.match(/puppeteer/i)) {
            bar.animate(options.progress / 100);
            playProgressTriggered = true;
          }
        }

        return playProgressTriggered;
      };

      progressLineAnimation();
      utils.$window.scroll(function () {
        progressLineAnimation();
      });
    });
  }
});
/*-----------------------------------------------
|   Toastr
-----------------------------------------------*/

window.utils.$document.ready(function () {
  var ratings = $('.raty');

  if (ratings.length) {
    ratings.each(function (index, value) {
      var $this = $(value);
      var options = $.extend({
        starHalf: 'star-half-png text-warning',
        starOff: 'star-off-png text-300',
        starOn: 'star-on-png text-warning',
        starType: 'span',
        size: 30
      }, $this.data('options'));
      $(value).raty(options);
    });
  }
});
/*-----------------------------------------------
|   Remodal [video lightbox]
-----------------------------------------------*/

utils.$document.ready(function () {
  var $videoModals = $('.video-modal');

  if ($videoModals.length) {
    utils.$body.after("\n      <div id='videoModal' class='remodal remodal-video'>\n        <button data-remodal-action='close' class='remodal-close'></button>\n        <div class='embed-responsive embed-responsive-16by9'>\n          <div id='videoModalIframeWrapper'></div>\n        </div>\n      </div>\n    ");
    var $videoModal = $('#videoModal').remodal();
    var $videoModalIframeWrapper = $('#videoModalIframeWrapper');
    $videoModals.each(function (index, value) {
      $(value).on('click', function (e) {
        e.preventDefault();
        var $this = $(e.currentTarget);
        var ytId = $this.attr('href').split('/');
        var start = $this.data('start');
        var end = $this.data('end');

        if (ytId[2] === 'www.youtube.com') {
          $videoModalIframeWrapper.html("<iframe id='videoModalIframe' src='//www.youtube.com/embed/" + ytId[3].split('?v=')[1] + "?rel=0&amp;autoplay=1&amp;enablejsapi=0&amp;start=" + start + "&ampend=" + end + "' allowfullscreen' frameborder='0' class='embed-responsive-item hide'></iframe>");
        } else if (ytId[2] === 'vimeo.com') {
          $videoModalIframeWrapper.html("<iframe id='videoModalIframe' src='https://player.vimeo.com/video/" + ytId[3] + "?autoplay=1&title=0&byline=0&portrait=0 ?autoplay=1&title=0&byline=0&portrait=0 hide'></iframe>");
        }

        $videoModal.open();
      });
    });
    utils.$document.on('closed', '.remodal', function (e) {
      var $this = $(e.currentTarget);

      if ($this.attr('id') === 'videoModal') {
        $videoModalIframeWrapper.html('');
      }
    });
  }
});
/*-----------------------------------------------
|   Sementic UI
-----------------------------------------------*/

utils.$document.ready(function () {
  var uiDropdown = $('.ui.dropdown');
  var uiAccordion = $('.ui.accordion');
  /*-----------------------------------------------
  |   Dropdown
  -----------------------------------------------*/

  if (uiDropdown.length) {
    uiDropdown.dropdown();
  }
  /*-----------------------------------------------
  |   Accordion
  -----------------------------------------------*/


  if (uiAccordion.length) {
    uiAccordion.each(function (index, value) {
      var $this = $(value);
      $this.accordion($.extend({
        exclusive: false
      }, $this.data('options') || {}));
    });
  }
});
/*
  global Stickyfill
*/

/*-----------------------------------------------
|   Sticky fill
-----------------------------------------------*/

utils.$document.ready(function () {
  Stickyfill.add($('.sticky-top'));
  Stickyfill.add($('.sticky-bottom'));
});
/*-----------------------------------------------
|   Sticky Kit
-----------------------------------------------*/

utils.$document.ready(function () {
  var stickyKits = $('.sticky-kit');

  if (stickyKits.length) {
    stickyKits.each(function (index, value) {
      var $this = $(value);

      var options = _objectSpread({}, $this.data('options'));

      $this.stick_in_parent(options);
    });
  }
});
/*-----------------------------------------------
|   Tabs
-----------------------------------------------*/

utils.$document.ready(function () {
  var $fancyTabs = $('.fancy-tab');

  if ($fancyTabs.length) {
    var Selector = {
      TAB_BAR: '.nav-bar',
      TAB_BAR_ITEM: '.nav-bar-item',
      TAB_CONTENTS: '.tab-contents'
    };
    var ClassName = {
      ACTIVE: 'active',
      TRANSITION_REVERSE: 'transition-reverse',
      TAB_INDICATOR: 'tab-indicator'
    };
    /*-----------------------------------------------
    |   Function for active tab indicator change
    -----------------------------------------------*/

    var updateIncicator = function updateIncicator($indicator, $tabs, $tabnavCurrentItem) {
      var _$tabnavCurrentItem$p = $tabnavCurrentItem.position(),
          left = _$tabnavCurrentItem$p.left;

      var right = $tabs.children(Selector.TAB_BAR).outerWidth() - (left + $tabnavCurrentItem.outerWidth());
      $indicator.css({
        left: left,
        right: right
      });
    };

    $fancyTabs.each(function (index, value) {
      var $tabs = $(value);
      var $navBar = $tabs.children(Selector.TAB_BAR);
      var $tabnavCurrentItem = $navBar.children(Selector.TAB_BAR_ITEM + "." + ClassName.ACTIVE);
      $navBar.append("\n        <div class=" + ClassName.TAB_INDICATOR + "></div>\n      ");
      var $indicator = $navBar.children("." + ClassName.TAB_INDICATOR);
      var $preIndex = $tabnavCurrentItem.index();
      updateIncicator($indicator, $tabs, $tabnavCurrentItem);
      $navBar.children(Selector.TAB_BAR_ITEM).click(function (e) {
        $tabnavCurrentItem = $(e.currentTarget);
        var $currentIndex = $tabnavCurrentItem.index();
        var $tabContent = $tabs.children(Selector.TAB_CONTENTS).children().eq($currentIndex);
        $tabnavCurrentItem.siblings().removeClass(ClassName.ACTIVE);
        $tabnavCurrentItem.addClass(ClassName.ACTIVE);
        $tabContent.siblings().removeClass(ClassName.ACTIVE);
        $tabContent.addClass(ClassName.ACTIVE);
        /*-----------------------------------------------
        |   Indicator Transition
        -----------------------------------------------*/

        updateIncicator($indicator, $tabs, $tabnavCurrentItem);

        if ($currentIndex - $preIndex <= 0) {
          $indicator.addClass(ClassName.TRANSITION_REVERSE);
        } else {
          $indicator.removeClass(ClassName.TRANSITION_REVERSE);
        }

        $preIndex = $currentIndex;
      });
      utils.$window.on('resize', function () {
        updateIncicator($indicator, $tabs, $tabnavCurrentItem);
      });
    });
  }
  /*-----------------------------------------------
  |   Product Review Tab
  -----------------------------------------------*/


  var $review = $('[data-tab-target]');
  $review.click(function () {
    var $this = $(this);
    var $reviewTab = $($this.data('tab-target'));
    $reviewTab.trigger('click');
  });
});
/*-----------------------------------------------
|   CKEditor | WYSIWYG
-----------------------------------------------*/

window.utils.$document.ready(function () {
  var tinymces = $('.tinymce');

  if (tinymces.length) {
    window.tinymce.init({
      selector: '.tinymce',
      height: '50vh',
      menubar: false,
      mobile: {
        theme: 'mobile',
        toolbar: ['undo', 'bold']
      },
      statusbar: false,
      plugins: 'link,image,lists,table,media',
      toolbar: 'styleselect | bold italic link bullist numlist image blockquote table media undo redo'
    });
  }

  var toggle = $('#progress-toggle-animation');
  toggle.on('click', function () {
    return $('#progress-toggle').toggleClass('progress-bar-animated');
  });
});
/*-----------------------------------------------
|   Tabs
-----------------------------------------------*/

utils.$document.ready(function () {
  $('.toast').toast();
});
/*-----------------------------------------------
|   Toastr
-----------------------------------------------*/

window.utils.$document.ready(function () {
  var $notifications = $('[data-notification]');
  $notifications.each(function (index, value) {
    var _window2 = window,
        toastr = _window2.toastr;
    var $this = $(value);
    var config = $this.data('notification');
    var defaultOptions = {
      closeButton: true,
      newestOnTop: false,
      positionClass: 'toast-bottom-right'
    };
    $this.on('click', function () {
      var type = config.type,
          title = config.title,
          message = config.message;
      var mergedOptions = $.extend(defaultOptions, config);
      toastr.options.positionClass !== mergedOptions.positionClass && toastr.remove();
      toastr.options = mergedOptions;

      switch (type) {
        case 'success':
          toastr.success(message, title);
          break;

        case 'warning':
          toastr.warning(message, title);
          break;

        case 'error':
          toastr.error(message, title);
          break;

        default:
          toastr.info(message, title);
          break;
      }
    });
  });
});
/*-----------------------------------------------
|   Tootltip [bootstrap 4]
-----------------------------------------------*/

utils.$document.ready(function () {
  // https://getbootstrap.com/docs/4.0/components/tooltips/#example-enable-tooltips-everywhere
  $('[data-toggle="tooltip"]').tooltip({
    container: '.content'
  });
  $('[data-toggle="popover"]').popover({
    container: '.content'
  });
});
/*-----------------------------------------------
|   Typed Text
-----------------------------------------------*/

/*
  global Typed
 */

utils.$document.ready(function () {
  var typedText = $('.typed-text');

  if (typedText.length) {
    typedText.each(function (index, value) {
      return new Typed(value, {
        strings: $(value).data('typed-text'),
        typeSpeed: 100,
        loop: true,
        backDelay: 1500
      });
    });
  }
});
/*-----------------------------------------------
|   YTPlayer
-----------------------------------------------*/

utils.$document.ready(function () {
  var Selector = {
    BG_YOUTUBE: '.bg-youtube',
    BG_HOLDER: '.bg-holder'
  };
  var DATA_KEY = {
    PROPERTY: 'property'
  };
  var $youtubeBackground = $(Selector.BG_YOUTUBE);

  if ($youtubeBackground.length) {
    $youtubeBackground.each(function (index, value) {
      var $this = $(value);
      console.log($this.data(DATA_KEY.PROPERTY));
      $this.data(DATA_KEY.PROPERTY, $.extend($this.data(DATA_KEY.PROPERTY), {
        showControls: false,
        loop: true,
        autoPlay: true,
        mute: true,
        containment: $this.parent(Selector.BG_HOLDER)
      }));
      $this.YTPlayer();
    });
  }
});