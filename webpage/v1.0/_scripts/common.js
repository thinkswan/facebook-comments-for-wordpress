/*****************************/
/* All content, code and images written and created by Graham Swan (thinkswan@gmail.com), 2010.
/*****************************/

$(document).ready(function() {
	// Tooltips
	$("img.tooltip").tipsy({
		fade:		true,
		gravity:	's'
	});

	// Smooth scrolling for internal links
	$("a[href*=#]").click(function() {
		if ((location.pathname.replace(/^\//, "") == this.pathname.replace(/^\//, "")) && (location.hostname == this.hostname)) { // Ensure it's not a link to an anchor on another site
			var target = $(this.hash);
			target = target.length && target || $("[name=" + this.hash.slice(1) +"]"); // Find target on page
			
            if (target.length) {
				var targetOffset = target.offset().top;
				
				$("html, body").animate({scrollTop: targetOffset}, 1000);
				
				return false;
			}
		}
	});
});
