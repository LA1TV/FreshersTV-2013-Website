// prevent leaving page
var pageNavigationEnabled = false;

$(document).ready(function() {
	if ($("#page-apply .data-placeholder").attr("data-applicationvisible") == "1") {

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

		(function() {

			// show/hide relevent parts of form
			(function() {
				var $el = $("#page-apply .application-form input[name='participation_type']");
				var $liveElements = $("#page-apply .application-form .show-if-live");
				var $vtElements = $("#page-apply .application-form .show-if-vt");
				$el.change(function() {
					update();
				});
				
				function update() {
					if ($el.filter(":checked").val() == "live") {
						$vtElements.hide();
						$liveElements.show();
					}
					else if ($el.filter(":checked").val() == "vt") {
						$liveElements.hide();
						$vtElements.show();
					}
					else {
						$liveElements.hide();
						$vtElements.hide();
					}
				}
				
				update();
			})();

			// handle form submission
			(function() {
				$("#page-apply .application-form").submit(function() {
					if (confirm("Are you sure you are ready to submit your application?\n\nAfter this you will no longer be able to make any changes.")) {
						pageNavigationEnabled = true;
						return true;
					}
					return false;
				});
			})();

			// handle form captcha
			(function() {
				$("#page-apply .captcha-container").recaptcha({
					publicKey: "6Lfy8uYSAAAAAMbqcoZnriQEp2fpEyEZQrR16W1O",
					placeholderClasses: ["btn", "btn-default", "btn-xs"],
					showWhenInitialized: true
				});
			})();
		})();
	};
});