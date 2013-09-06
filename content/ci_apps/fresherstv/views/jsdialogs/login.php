<?php
$this->load->helper("form");
?>
<!-- =======[Login Dialog]======= --> 
<div>
<div class="modal fade" id="login-dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<?=form_open('login/submit', array("role"=>"form", "novalidate"=>""));?>
				<input type="hidden" name="form_submitted" value="1">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Station Login</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label" for="email">Email</label>
						<input type="email" name="email" class="form-control input-xlarge">
					</div>
					<div class="form-group">
						<label class="control-label" for="password">Password</label>
						<input type="password" name="password" class="form-control input-xlarge">
					</div>
					<div class="form-group captcha-container">
						<label for="form-captcha" class="control-label">Please also enter the text in the captcha below to verify that you are a human.</label>
						<div id="form-captcha" class="actual-captcha-container">
<?=$recaptcha_lib->get_noscript_html(); ?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default cancel-button">Cancel</button>
				  <input class="btn btn-primary" type="submit" value="Login">
				</div>
			</form>
		</div>
	</div>
</div>
</div>