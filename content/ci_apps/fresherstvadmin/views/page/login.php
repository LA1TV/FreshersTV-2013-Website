<?php
$this->load->helper("form");
$this->load->helper("security");
?>
<h2>Login</h2>
<div class="alert alert-info">You are required to log in in order to access the admin control panel.</div>
<?php if (strlen($login_error_msg) !== 0) : ?>
	<div class="alert alert-danger"><?=htmlent($login_error_msg);?></div>
<?php endif; ?>

<?=form_open('login/submit', array("class"=>"form-horizontal login-form", "role"=>"form", "novalidate"=>""));?>
	<input type="hidden" name="form_submitted" value="1">
	<div class="form-group">
		<label for="form-password" class="col-lg-2 control-label">Password</label>
		<div class="col-lg-10">
			<input type="password" class="form-control" name="password" id="form-password">
			<span class="help-block">Your password is case-sensitive.</span>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<label class="control-label">Please also enter the text in the captcha below to verify that you are a human.</label>
			<div class="captcha-container">
<?=$recaptcha_lib->get_noscript_html(); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="submit" class="btn btn-primary">Login</button>
		</div>
	</div>
</form>