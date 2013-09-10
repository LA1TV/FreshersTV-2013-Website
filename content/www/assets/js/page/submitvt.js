// prevent leaving page
var pageNavigationEnabled = false;
(function() {
	window.onbeforeunload = function() {
		if (!pageNavigationEnabled) {
			return "Are you sure you want to leave this page without submitting your VT?";
		}
		else {
			return;
		}
	}
})();

// handle form submission
$(document).ready(function() {
	$("#page-submitvt .submit-vt-form").submit(function() {
		if (confirm("Are you sure you are ready to submit your VT?\n\nAfter this you will no longer be able to make any changes.")) {
			pageNavigationEnabled = true;
			return true;
		}
		return false;
	});
});