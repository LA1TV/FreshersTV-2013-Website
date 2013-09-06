// handle form captcha
$(document).ready(function() {
	$("#page-login .actual-captcha-container").recaptcha({
		publicKey: "6Lfy8uYSAAAAAMbqcoZnriQEp2fpEyEZQrR16W1O",
		placeholderClasses: ["btn", "btn-default", "btn-xs"],
		showWhenInitialized: true
	});
});