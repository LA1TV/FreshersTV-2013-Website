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


// check file extensions
$(document).ready(function() {
	$("#page-apply .application-form .logo-file-input").change(function() {
		var fname = $(this).val();
		var extensions = ["psd", "ai", "jpeg", "jpg", "tiff", "bmp", "png"];
		if (jQuery.inArray(getExtension(fname), extensions) === -1) {
			alert("That file format is not allowed.");
			$(this).val("");
		}
		
		function getExtension(name) {
			var a = name.split(".");
			if (a.length === 1 || (a[0] == "" && a.length == 2)) {
				return "";
			}
			return a.pop().toLowerCase();
		}
	});
});

// show/hide relevent parts of form
$(document).ready(function() {
	var $el = $("#page-apply .application-form input[name='participation-type']");
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