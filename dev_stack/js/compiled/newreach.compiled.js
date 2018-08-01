'use strict';

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {

	// Site title and description.
	wp.customize('blogname', function (value) {
		value.bind(function (to) {
			$('.site-title a').text(to);
		});
	});
	wp.customize('blogdescription', function (value) {
		value.bind(function (to) {
			$('.site-description').text(to);
		});
	});

	// Header text color.
	wp.customize('header_textcolor', function (value) {
		value.bind(function (to) {
			if ('blank' === to) {
				$('.site-title, .site-description').css({
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				});
			} else {
				$('.site-title, .site-description').css({
					'clip': 'auto',
					'position': 'relative'
				});
				$('.site-title a, .site-description').css({
					'color': to
				});
			}
		});
	});
})(jQuery);

/** ================================================== **/
/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
(function () {
	var isIe = /(trident|msie)/i.test(navigator.userAgent);

	if (isIe && document.getElementById && window.addEventListener) {
		window.addEventListener('hashchange', function () {
			var id = location.hash.substring(1),
			    element;

			if (!/^[A-z0-9_-]+$/.test(id)) {
				return;
			}

			element = document.getElementById(id);

			if (element) {
				if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false);
	}
})();

/** ================================================== **/
/*
EVENTER: simple data binding
- data-bind's a data-event to an element, then executes its handler below

IN THEORY:
<element
	data-bind='action'				// DOM event to bind
	data-event='handler'			// handle the event action
	data-more-attrs='more data'		// additional data to be handled
</element>

EXAMPLE:
- this image if bound by a click event
- when the image is clicked on it is handled by the linkTo event
- the linkTo event handler takes an additiional data-link attribute
- the link data is a url passed to redirect the window.location.href to
<img data-bind='click'					// binds image to click event
	data-event='linkTo'					// executes the linkTo handler
	data-link='http://www.url.com'		// takes a link arguement to redirect the URL to
/>
*/
(function ($) {
	// when document ready
	$(document).ready(function () {
		// DOM global
		var self = $(this);
		// EVENTER — pass custom event handlers
		var eventBinder = new EventBinder({
			// toggles elements active state
			toggler: function toggler() {
				// trigger element
				$(this).toggleClass('active');
				// toggled element
				var toggledElement = $(this).data('toggle');
				$(toggledElement).toggleClass('active');
			},
			// redirects to a data-link page url
			linkTo: function linkTo(event) {
				var linkTarget = event.target.getAttribute('data-link');
				if (linkTarget) {
					window.location.href = linkTarget;
				}
				return;
			},
			// creates a model/lightbox to display the data-view content
			fullscreen: function fullscreen(event) {
				// do stuff with view content
				var viewContent = event.target.getAttribute('data-view');
				var box = $('#fullscreen-lightbox');
				// light box exists
				if (box.length) {
					// update view box content src
					var viewBox = box.find('.view-content')[0];
					$(viewBox).attr('src', viewContent);
					box.toggleClass('active');
					// light box does NOT exist
				} else {
					// add lightbox to DOM
					var FS_lightbox = '<div id="fullscreen-lightbox" class="fs-lightbox active">';
					FS_lightbox += '<a class="inner-toggle fs-lb-close" data-bind="click" data-event="toggler" data-toggle="#fullscreen-lightbox"><i class="fa fa-plus"></i> exit fullscreen</a>';
					FS_lightbox += '<div class="inner-content">';
					FS_lightbox += '<img class="view-content" src="' + viewContent + '"/>';
					FS_lightbox += '</div></div>';
					$('body').append(FS_lightbox);
					eventBinder.updateEvents();
				}
			}
		});
	});
	// EventBinder CLASS

	var EventBinder = function () {
		// construct event handler obj
		function EventBinder() {
			var _this = this;

			var handlers = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
			var start = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;

			_classCallCheck(this, EventBinder);

			// elements to bind
			this.toBind = document.querySelectorAll('[data-bind]');
			// obj containing all the event actions
			this.handlers = handlers;
			// updater
			this.updateEvents = function () {
				_this.toBind = document.querySelectorAll('[data-bind]');
				_this.init();
			};
			// if initated
			if (start) {
				this.init();
			}
			return this;
		}
		// bind event actions to DOM elements


		_createClass(EventBinder, [{
			key: 'bindEvents',
			value: function bindEvents() {
				var _this2 = this;

				// for each element
				this.toBind.forEach(function (element, index) {
					// get variables
					var listener = element.getAttribute('data-bind') || 'click',
					    handler = element.getAttribute('data-event'),
					    binded = element.getAttribute('data-binded');
					// chech for the event listener in the handlers obj
					if (_typeof(_this2.handlers[listener]) !== undefined) {
						// if not already bound
						if (!binded) {
							// bind each event to element
							element.setAttribute('data-binded', 'true');
							element.addEventListener(listener, _this2.handlers[handler]);
						}
					}
				});
			}
			// initiate event binding

		}, {
			key: 'init',
			value: function init() {
				return this.bindEvents();
			}
		}]);

		return EventBinder;
	}();
})(jQuery);

/** ================================================== **/
// SCROLLER
(function ($) {
	// when document ready
	$(document).ready(function () {
		// vars
		var self = $(this);
		var $scrollers = $('.scroller');
		// check scrollers exists
		if ($scrollers.length) {
			// create new scroller for each one
			$scrollers.each(function (index, elm) {
				return new scroller(elm);
			});
		}
	});
	// SCROLLER

	var scroller = function () {
		// BUILD
		function scroller(container) {
			_classCallCheck(this, scroller);

			// VARS
			var self = this;
			self.container = $(container);
			self.deck = self.container.children('.deck');
			self.slides = self.deck.children('img');
			self.numSlides = self.slides.length;
			self.totalWidth = 0;
			self.inSlideshow = false;
			self.slideshowStop = false;
			// POSITION SLIDES
			self.positionScrollerImages();
			// HANDLE SCROLL
			// on MOUSEOVER
			self.container.mouseover(function () {
				self.slideshowStop = false;
				$(this).mousewheel(function (e, delta) {
					self.scrollerJack(this, e, delta);
				});

				// on MOUSELEAVE
			}).mouseleave(function () {
				self.slideshowStop = true;
				$(this).unbind('mousewheel');
			});
			// on MOUSEMOVE
			self.container.mousemove(function () {
				// check mouse positioned in scroller window
				if (self.deck[0] == event.target.parentNode) {
					self.slideshowStop = false;
					$(this).mousewheel(function (e, delta) {
						self.scrollerJack(this, e, delta);
					});
				} else {
					self.slideshowStop = true;
					$(this).unbind('mousewheel');
				}
			});
		}
		// GETTERS & SETTERS


		_createClass(scroller, [{
			key: 'getTotalWidth',
			value: function getTotalWidth() {
				return this.totalWidth;
			}
		}, {
			key: 'setTotalWidth',
			value: function setTotalWidth(val) {
				if (val) {
					this.totalWidth = val;
				}
				return this.totalWidth;
			}
			// POSITIONER

		}, {
			key: 'positionScrollerImages',
			value: function positionScrollerImages() {
				for (var i = 0; this.numSlides && i < this.numSlides; i++) {
					// vars
					var $slide = $(this.slides[i]),
					    $slideWidth = $slide.outerWidth(),
					    $scrollerWidth = this.getTotalWidth();
					// position image
					$slide.css('left', $scrollerWidth);
					// update scroller total width
					if (i < this.numSlides - 1) {
						var newWidth = $scrollerWidth + $slideWidth;
						this.setTotalWidth(newWidth);
					}
				}
			}
			// SCROLLING FUNCTION

		}, {
			key: 'scrollerJack',
			value: function scrollerJack(context, e, delta) {
				// map vertical scrolling horizontally
				context.scrollLeft -= delta;
				e.preventDefault();
				// hide scroller arrows
				this.hideScrollerArrows(context);
				// vars
				var scrollPos = $(context).scrollLeft();
				var scrollerWidth = Math.round(scrollPos + $(context).innerWidth());
				var maxWidth = $(context)[0].scrollWidth;
				// STOP SCROLLER and continue scrolling the WINDOW when:
				// 1) if reaches start of scroller
				if (0 >= scrollPos) {
					$(context).unbind('mousewheel');
				}
				// 2) if reaches end of scroller
				if (this.slideshowStop === false && scrollerWidth >= maxWidth) {
					this.slideshowStop = true;
					$(context).unbind('mousewheel');
				}
				// 3) back-up, if the mouse leaves scroller div
				if (this.deck[0] != e.target.parentNode) {
					$(context).unbind('mousewheel');
				}
			}
			// HIDE SCROLLER ARROWS

		}, {
			key: 'hideScrollerArrows',
			value: function hideScrollerArrows(element) {
				$(element).children('.scroller-arrows').fadeOut('250');
			}
		}]);

		return scroller;
	}();
})(jQuery);
//# sourceMappingURL=newreach.compiled.js.map
