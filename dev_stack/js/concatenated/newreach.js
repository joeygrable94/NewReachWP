/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
} )( jQuery );





/** ================================================== **/
/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
( function() {
	var isIe = /(trident|msie)/i.test( navigator.userAgent );

	if ( isIe && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
} )();





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
(function($) {
	// when document ready
	$(document).ready(function() {
		// DOM global
		let self = $(this);
		// EVENTER — pass custom event handlers
		let eventBinder = new EventBinder({
			// toggles elements active state
			toggler: function() {
				// trigger element
				$(this).toggleClass('active');
				// toggled element
				let toggledElement = $(this).data('toggle');
				$(toggledElement).toggleClass('active');
			},
			// redirects to a data-link page url
			linkTo: function(event) {
				let linkTarget = event.target.getAttribute('data-link');
				if (linkTarget) { window.location.href = linkTarget; }
				return;
			},
			// creates a model/lightbox to display the data-view content
			fullscreen: function(event) {
				// do stuff with view content
				let viewContent = event.target.getAttribute('data-view');
				let box = $('#fullscreen-lightbox');
				// light box exists
				if (box.length) {
					// update view box content src
					let viewBox = box.find('.view-content')[0];
					$(viewBox).attr('src', viewContent);
					box.toggleClass('active');
				// light box does NOT exist
				} else {
					// add lightbox to DOM
					let FS_lightbox = '<div id="fullscreen-lightbox" class="fs-lightbox active">';
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
	class EventBinder {
		// construct event handler obj
		constructor(handlers={}, start=true) {
			// elements to bind
			this.toBind = document.querySelectorAll('[data-bind]');
			// obj containing all the event actions
			this.handlers = handlers;
			// updater
			this.updateEvents = () => {
				this.toBind = document.querySelectorAll('[data-bind]');
				this.init();
			};
			// if initated
			if (start) { this.init(); }
			return this;
		}
		// bind event actions to DOM elements
		bindEvents() {
			// for each element
			this.toBind.forEach((element, index) => {
				// get variables
				let listener = element.getAttribute('data-bind') || 'click',
					handler = element.getAttribute('data-event'),
					binded = element.getAttribute('data-binded');
				// chech for the event listener in the handlers obj
				if (typeof this.handlers[listener] !== undefined) {
					// if not already bound
					if (!binded) {
						// bind each event to element
						element.setAttribute('data-binded', 'true');
						element.addEventListener(listener, this.handlers[handler]);
					}
				}
			});
		}
		// initiate event binding
		init() { return this.bindEvents(); }
	}
} (jQuery));




/** ================================================== **/
// SCROLLER
(function($) {
	// when document ready
	$(document).ready(function() {
		// vars
		let self = $(this);
		let $scrollers = $('.scroller');
		// check scrollers exists
		if ($scrollers.length) {
			// create new scroller for each one
			$scrollers.each((index, elm) => new scroller(elm));
		}
	});
	// SCROLLER
	class scroller {
		// BUILD
		constructor(container) {
			// VARS
			let self = this;
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
			self.container.mouseover(function() {
				self.slideshowStop = false;
				$(this).mousewheel(function(e, delta) {
					self.scrollerJack(this, e, delta);
				});
			
			// on MOUSELEAVE
			}).mouseleave(function() {
				self.slideshowStop = true;
				$(this).unbind('mousewheel');
			});
			// on MOUSEMOVE
			self.container.mousemove(function() {
				// check mouse positioned in scroller window
				if (self.deck[0] == event.target.parentNode) {
					self.slideshowStop = false;
					$(this).mousewheel(function(e, delta) {
						self.scrollerJack(this, e, delta);
					});
				} else {
					self.slideshowStop = true;
					$(this).unbind('mousewheel');
				}
			});
		}
		// GETTERS & SETTERS
		getTotalWidth() { return this.totalWidth; }
		setTotalWidth(val) {
			if (val) {
				this.totalWidth = val;	
			}
			return this.totalWidth;
		}
		// POSITIONER
		positionScrollerImages() {
			for (let i = 0; this.numSlides && i < this.numSlides; i++) {
				// vars
				let $slide = $(this.slides[i]),
					$slideWidth = $slide.outerWidth(),
					$scrollerWidth = this.getTotalWidth();
				// position image
				$slide.css('left', $scrollerWidth);
				// update scroller total width
				if (i < this.numSlides - 1) {
					let newWidth = $scrollerWidth+$slideWidth;
					this.setTotalWidth(newWidth);
				}
			}
		}
		// SCROLLING FUNCTION
		scrollerJack(context, e, delta) {
			// map vertical scrolling horizontally
			context.scrollLeft -= (delta);
			e.preventDefault();
			// hide scroller arrows
			this.hideScrollerArrows(context);
			// vars
			let scrollPos = $(context).scrollLeft();
			let scrollerWidth = Math.round(scrollPos + $(context).innerWidth());
			let maxWidth = $(context)[0].scrollWidth;
			// STOP SCROLLER and continue scrolling the WINDOW when:
			// 1) if reaches start of scroller
			if (0 >= scrollPos) {
				$(context).unbind('mousewheel');
			}
			// 2) if reaches end of scroller
			if(this.slideshowStop === false && scrollerWidth >= maxWidth) {
				this.slideshowStop = true;
				$(context).unbind('mousewheel');
			}
			// 3) back-up, if the mouse leaves scroller div
			if (this.deck[0] != e.target.parentNode) {
				$(context).unbind('mousewheel');
			}
		}
		// HIDE SCROLLER ARROWS
		hideScrollerArrows(element) {
			$(element).children('.scroller-arrows').fadeOut('250');
		}
	}
} (jQuery));