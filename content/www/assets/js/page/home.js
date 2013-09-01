$(document).ready(function() {
	// ZERO INDEXING!
	var startTime = new Date(2013, 09, 23, 00, 00);
	var $el = $(".countdown-timer").first();
	var countdown = $el.FlipClock(getSecondsToStart(), {
		countdown: true,
		clockFace: "DailyCounter"
	});
	
	var $container = $el.closest(".countdown-timer-container").first();
	var $scaleContainer = $el.closest(".scale-container").first();
	var $secondaryContainer = $el.closest(".secondary-container").first();
	$container.width("750px"); // briefly set the container width to the max width so that the actual countdown timer width can be calculated without it wrapping
	var elWidth = $el.outerWidth(true);
	var elHeight = $el.outerHeight(true);
	$container.width("auto"); // set container with back to default
	// set the width so that it is fixed at the width of the counter. when it is scaled the width of the element remains the same
	$scaleContainer.width(elWidth);	
	$scaleContainer.height(elHeight);
	// make the counter stay at top left corner when resized. the width and height of the element won't scale
	$scaleContainer.css('transform-origin', '0 0');
	$scaleContainer.css('-ms-transform-origin', '0 0');
	$scaleContainer.css('-webkit-transform-origin', '0 0');
	
	
	function onResize() {
		var scale = ($container.outerWidth()) / elWidth;
		if (scale > 1) {
			scale = 1;
		}
		// apply the scale to the scale container. container is used as it has no margin or padding
		$scaleContainer.css('transform', 'scale('+scale+','+scale+')');
		$scaleContainer.css('-ms-transform', 'scale('+scale+','+scale+')');
		$scaleContainer.css('-webkit-transform', 'scale('+scale+','+scale+')');
		// set the width and height of the secondary container to match what the scaleContainer should be. It won't actually be this because scale doesn't alter width and height.
		// the secondary container has an overflow property set to hidden so the scale container is effectively cropped and as it has scalled with anchor at top left this works
		$secondaryContainer.width(elWidth*scale);	
		$secondaryContainer.height(elHeight*scale);
	}
	onResize();
	$(window).resize(function() {onResize();});
	
	function getSecondsToStart() {
		var val = Math.ceil(startTime.getTime()/1000) - Math.ceil(Date.now()/1000);
		console.log(val);
		if (val < 0) {
			val = 0;
		}
		return val;
	}
});