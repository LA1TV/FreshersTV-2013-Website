// setup the login dialog.
$(document).ready(function() {

	// don't show on mobile devices
	if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
		return;
	}

	var baseUrl = $("body").attr("data-baseurl");
	var $dialog = $("#login-dialog").first();
	var $captchaContainer = $dialog.find(".captcha-container").first();
	var $actualCaptchaContainer = $dialog.find(".actual-captcha-container").first();
	var loading = false;
	
	// setup
	$dialog.modal({
		backdrop: true,
		keyboard: true,
		show: false,
		remote: false
	});
	
	$actualCaptchaContainer.recaptcha({
		publicKey: "6Lfy8uYSAAAAAMbqcoZnriQEp2fpEyEZQrR16W1O",
		placeholderClasses: ["btn", "btn-default", "btn-xs"]
	});
	
	$dialog.find(".cancel-button").click(function() {
		$dialog.modal("hide");
	});

	
	function showCaptcha(val) {
		if (val) {
			$captchaContainer.recaptcha("showCaptcha", true);
			$captchaContainer.show();
		}
		else {
			$captchaContainer.hide();
		}
	}
	
	// override links and show dialog. if js not available it will show default login page
	$('a.show-login-dialog').click(function(e) {
		e.preventDefault();
		
		if (loading) {
			return false;
		}
		loading = true;
		
		// determine if captcha needs to be shown
		jQuery.ajax(baseUrl+"ajax_request", {
			complete: function() {
				// show the dialog
				$dialog.modal("show");
				loading = false;
			},
			success: function(data) {
				showCaptcha(data.response);
			},
			error: function() {
				showCaptcha(true);
			},
			timeout: 3000,
			dataType: "json",
			data: {
				action: "get_show_login_captcha"
			},
			type: "GET"
		});
		return false;
	});
	
});