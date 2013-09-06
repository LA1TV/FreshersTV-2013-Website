// a jQuery plugin to manage google's recaptcha plugin and manage having more than one per page.
(function($) {

	var instances = [];

	$.widget("tjenkinson.recaptcha", {
		options: {
			publicKey: false,
			placeholderClasses: [],
			showWhenInitialized: false,
			recaptchaOpts: {
				theme: "clean"
			}
		},
		_create: function() {
			instances.push(this);
			this.$placeholder = $('<button type="button">Click To Show Captcha</button>');
			for (var i=0; i<this.options.placeholderClasses.length; i++) {
				this.$placeholder.addClass(this.options.placeholderClasses[i]);
			}
			this.showingCaptcha = null;
			this.isLoading = false;
			this.showCaptcha(this.options.showWhenInitialized);
			var that = this;
			this.$placeholder.click(function() {
				that.showCaptcha(true);
			});
		},
		showCaptcha: function(val) {
			if (this.getIsShowingCaptcha() === val) {
				return;
			}
			
			if (this.getIsLoading()) {
				this.element.on("loaded", jQuery.proxy(function() {
					this.showCaptcha(val);
				}, this));
			}
			
			if (!val) {
				// hide
				Recaptcha.destroy();
				this.element.empty().append(this.$placeholder);
				this.isShowingCaptcha = false;
			}
			else {
				// show
				if (this.options.publicKey === false) {
					console.log("You need to provide the public key.");
					return;
				}
				this.isLoading = true;
				// loop through other instances and remove captcha if visislbe
				for (var i=0; i<instances.length; i++) {
					if (instances[i] === this) {
						continue;
					}
					if (instances[i].getIsShowingCaptcha()) {
						instances[i].showCaptcha(false);
					}
				}
				this.isShowingCaptcha = true;
				var $captchaDiv = $("<div />");
				this.$placeholder.detach();
				this.element.append($captchaDiv);
				
				var that = this;
				var recaptchaOpts = jQuery.extend({}, this.options.recaptchaOpts, {
					callback: function() {
						that.isLoading = false;
						that._trigger("loaded");
						if ("callback" in that.options.recaptchaOpts) {
							that.options.recaptchaOpts.callback();
						}
					}
				});
				
				Recaptcha.create(this.options.publicKey, $captchaDiv[0], recaptchaOpts);
			}
		},
		getIsShowingCaptcha: function() {
			return this.isShowingCaptcha;
		},
		getIsLoading: function() {
			return this.isLoading;
		}
	});

})(jQuery);