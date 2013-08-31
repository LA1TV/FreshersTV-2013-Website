$(document).ready(function() {
	var startTime = new Date(2013, 10, 00, 00, 00);
	var countdown = $(".countdown-timer").FlipClock(getSecondsToStart(), {
		countdown: true,
		clockFace: "DailyCounter"
		});
	
	// make sure stays sync with clock
	setInterval(function() {
		var secondsToStart = getSecondsToStart();
		if (countdown.getTime().time !== secondsToStart) {
			countdown.setTime(secondsToStart);
			}
		}, 5000);
	
	function getSecondsToStart() {
		var val = Math.ceil(startTime.getTime()/1000) - Math.ceil(Date.now()/1000);
		if (val < 0) {
			val = 0;
		}
		return val;
	}
});