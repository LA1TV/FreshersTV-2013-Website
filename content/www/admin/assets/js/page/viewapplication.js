// handle form captcha
$(document).ready(function() {
	$("#page-viewapplication .accept-application-form").submit(function() {
		return confirm("Are you sure you want to accept this application?");
	});
});