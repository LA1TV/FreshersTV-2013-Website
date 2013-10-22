$(document).ready(function() {
	
	String.prototype.pad = function(padString, length) {
		var str = this;
		while (str.length < length)
			str = padString + str;
		return str;
	}
	
	var baseUrl = $("body").attr("data-baseurl");
	
	var offsetTime = 0; // no of milliseconds out compared with local time
	var currentTime = false; // current time in milliseconds that is shown
	var $el = $("#page-clock .txt").first();
	var updateCount = 0;
	
	if ($el.length === 0) {
		$el = $("#page-dashboard .txt").first();
	}
	
	function update() {
		var time = getCalculatedTime();
		if (currentTime === false || time.getTime() !== currentTime.getTime()) {
			currentTime = new Date(time.getTime());
			$el.html(currentTime.getHours().toString().pad("0", 2)+":"+currentTime.getMinutes().toString().pad("0", 2)+":"+currentTime.getSeconds().toString().pad("0", 2));
		}
	}
	update();
	setInterval(update, 100);
	
	function getCalculatedTime() {
		return new Date(Math.floor((getDateToSecond().getTime() + offsetTime) / 1000)*1000);
	}
	
	function getDateToSecond() {
		return new Date(Math.floor((new Date().getTime()) / 1000)*1000)
	}

	
	function updateTimeOffset() {
		$.ajax({
			url: baseUrl+"ajax_request",
			timeout: 3000,
			dataType: "json",
			data: {
				action: "get_time"
			},
			cache: false,
			success: function(data) {
				offsetTime = new Date(data.response).getTime() - new Date().getTime();
				setTimeout(updateTimeOffset, updateCount++ < 5 ? 3000 : 55000);
			}
		});
	}
	updateTimeOffset();
	
});