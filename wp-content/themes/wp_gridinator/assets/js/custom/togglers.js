// togglers
(function($) {
	// when document ready
	$(document).ready(function() {
		var self = $(this);
		var togglers = $('.toggle');
		togglers.each(handleToggle);
	});
	function handleToggle(index, elm) {
		var trigger = $(elm),
			toggleTo;
		// click
		trigger.click(function(e) {
			toggleTo = trigger.data('toggle');
			element = $(toggleTo),
			previousActive = trigger.parents('.active');

			// toggle active class
			$(this).toggleClass('active');
			element.toggleClass('active');
		});
	}
} (jQuery));