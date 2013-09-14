(function() {

	var runAnimation;
	var runApplyAnimation;
	var startCountdown;
	var updateCountdownStartTime;

	var setUpPlayer = function() {
		
		var baseUrl = $("body").attr("data-baseurl");
		var jwPlayerId = "jwplayer-1";
		var startedPlaying = false;
		var pauseTimer = false;
		
		
		jwplayer(jwPlayerId).setup({
			controls: true,
			width: "100%",
			aspectratio: "16:9",
			autostart: true,
			fallback: true,
			mute: false,
			primary: "flash",
			repeat: false,
			flashplayer: baseUrl+"assets/flash/jwplayer/jwplayer.flash.swf",
			stretching: "uniform",
			playlist: [{
				image: baseUrl+"assets/videos/promo/poster.jpg",
				sources: [{
					file: baseUrl+"assets/videos/promo/video-720p.mp4",
					label: "720p HD",
					"default": true
				},
				{
					file: baseUrl+"assets/videos/promo/video-360p.mp4",
					label: "360p SD"
				},
				{
					file: baseUrl+"assets/videos/promo/video-180p.mp4",
					label: "180p SD"
				}]
			}]
		});
		
		jwplayer(jwPlayerId).onPlay(function(e) {
			if (e.oldstate == "BUFFERING") {
				startedPlaying = true;
			}
		});
		
		jwplayer(jwPlayerId).onBuffer(function() {
			startAnimation();
		});
		
		jwplayer(jwPlayerId).onTime(function(e) {
			if (e.position >= 3) {
				startAnimation();
			}
			if (e.position >= 98) {
				runApplyAnimation();
			}
		});
		
		jwplayer(jwPlayerId).onPause(function() {
			clearPauseTimeout();
			pauseTimer = setTimeout(function() {
				if (jwplayer(jwPlayerId).getState() == "PAUSED") {
					startAnimation();
				}
			}, 800);
		});
		
		jwplayer(jwPlayerId).onError(function() {
			startedPlaying = true;
			startAnimation();
		});
		
		jwplayer(jwPlayerId).onComplete(function() {
			startAnimation();
		});
		
		function startAnimation() {
			if (startedPlaying) {
				runAnimation();
			}
		}
		
		function clearPauseTimeout() {
			if (pauseTimer !== false) {
				clearTimeout(pauseTimer);
				pauseTimer = false;
			}
		}
	};
	
	// end of promo animation and also apply now animation
	var setUpAnimation = function() {
		
		var $applyContainer = $("#page-home .application-button-container").first();
		var $applyPadding = $("#page-home .application-button-animation-padding").first();
		var $container = $("#page-home .animation-height-container").first();
		var $countdown = $container.find(".countdown-timer-outer-container").first();
		var $video = $container.find(".promo-vid-container").first();
		
		if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			//disable animations if mobile
			runAnimation = function(){};
			runApplyAnimation = function(){};
			$countdown.show();
			startCountdown();
		}
		else {
			
			var animationRan = false;
			var applyAnimationRan = false;
			
			$applyContainer.css("display", "inline-block");
			var applicationButtonHeight = $applyContainer.height();
			$applyContainer.hide();
			
			$countdown.css("z-index", -1);
			
			runAnimation = function() {
				if (animationRan) {
					// only run once
					return;
				}
				animationRan = true;
			
				var countdownHeight = $countdown.outerHeight(true);
				var containerHeight = $container.height();
				 
				$container.height($container.height()); // lock the height

				// animate video position down and scale height at same time, also animate scroll position
				$container.animate({
					height: containerHeight + countdownHeight
				}, 1000);
				$("body").animate({
					scrollTop: $("body").scrollTop() + countdownHeight
				}, 1000);
				$video.animate({
					top: "+"+countdownHeight+"px"
				}, 1000, function() {
				
					//reset video css
					$video.css("top", "auto");
					
					// animate countdown
					updateCountdownStartTime(-1000); // set time 1 second less because animation takes 1 second
					$countdown.show("drop", {direction: "up"}, 1000, function() {
					
					$container.height("auto"); // unlock the height
						startCountdown();
						
					});
				});
			};
			
			runApplyAnimation = function() {
				if (applyAnimationRan) {
					// only run once
					return;
				}
				applyAnimationRan = true;
				$applyPadding.animate({
					height: applicationButtonHeight
				}, 1000, function() {
					$applyPadding.height(0);
					$applyContainer.show("drop", {direction: "down"}, 1000);
				});
			}
		}
	};


	// countdown timer
	$(document).ready(function() {
		// ZERO INDEXING!
		var startTime = new Date(2013, 09, 23, 18, 00);
		var $el = $("#page-home .countdown-timer").first();
		var countdown = $el.FlipClock(getSecondsToStart(), {
			countdown: true,
			autoStart: false,
			clockFace: "DailyCounter"
		});
		
		var $outerContainer = $el.closest(".countdown-timer-outer-container").first();
		var $container = $el.closest(".countdown-timer-container").first();
		var $scaleContainer = $el.closest(".scale-container").first();
		var $secondaryContainer = $el.closest(".secondary-container").first();
		$container.width("750px"); // briefly set the container width to the max width so that the actual countdown timer width can be calculated without it wrapping
		var elWidth = $el.outerWidth(true);
		var elHeight = $el.outerHeight(true);
		$container.width("auto"); // set container with back to default
		onResize(); // set correct size initially
		$outerContainer.hide(); // hide because animating in
		// set the width so that it is fixed at the width of the counter. when it is scaled the width of the element remains the same
		$scaleContainer.width(elWidth);	
		$scaleContainer.height(elHeight);
		// make the counter stay at top left corner when resized. the width and height of the element won't scale
		$scaleContainer.css('transform-origin', '0 0');
		$scaleContainer.css('-ms-transform-origin', '0 0');
		$scaleContainer.css('-webkit-transform-origin', '0 0');
		
		
		updateCountdownStartTime = function(offset) {
			countdown.setTime(getSecondsToStart()+offset);
		};
		startCountdown = function() {
			// kick off the resize handler
			$(window).resize(function() {onResize();});
			// start the countdown
			countdown.start();
			
			// make sure stays sync with clock
			setInterval(function() {
			var secondsToStart = getSecondsToStart();
				if (countdown.getTime().time !== secondsToStart) {
					countdown.setTime(secondsToStart);
				}
			}, 300000);
		};
		
		setUpAnimation();
		setUpPlayer();
		
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
		
		function getSecondsToStart() {
			var val = Math.ceil(startTime.getTime()/1000) - Math.ceil(Date.now()/1000);
			if (val < 0) {
				val = 0;
			}
			return val;
		}
	});
})();