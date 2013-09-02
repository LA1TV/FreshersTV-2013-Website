// prevent leaving page
var pageNavigationEnabled = false;
(function() {
	window.onbeforeunload = function() {
		if (!pageNavigationEnabled) {
			return "Are you sure you want to leave this page without submitting the application form?";
		}
		else {
			return;
		}
	}
})();

// show/hide relevent parts of form
$(document).ready(function() {
	var $el = $("#page-apply .application-form input[name='participation_type']");
	var $elements = $("#page-apply .application-form .show-if-live");
	$el.change(function() {
		update();
	});
	
	function update() {
		if ($el.filter(":checked").val() == "live") {
			$elements.show();
		}
		else {
			$elements.hide();
		}
	}
	
	update();
});

// handle form submission
$(document).ready(function() {
	$("#page-apply .application-form").submit(function() {
		if (confirm("Are you sure you are ready to submit your application?\n\nAfter this you will no longer be able to make any changes.")) {
			pageNavigationEnabled = true;
			return true;
		}
		return false;
	});
});