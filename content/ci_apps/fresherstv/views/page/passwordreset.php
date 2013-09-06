<?php
$this->load->helper("form");
$this->load->helper("security");
?>
<h2>Password Reset</h2>
<p>Please enter the e-mail address that you set up on the <a href="<?=base_url();?>apply">application form</a> and we will send you a password reset link.</p>
<p>If you have any problems please send an e-mail to "<a href="mailto:development@la1tv.co.uk" target="_blank">development@la1tv.co.uk</a>" <strong>from the same e-mail address you put on the application form</strong>.</p>
<?php if (strlen($error_msg) !== 0) : ?>
	<div class="alert alert-danger"><?=htmlent($error_msg);?></div>
<?php endif; ?>

<?=form_open('passwordreset/submit', array("class"=>"form-horizontal login-form", "role"=>"form", "novalidate"=>""));?>
	<input type="hidden" name="form_submitted" value="1">
	<div class="form-group">
		<label for="form-email" class="col-lg-2 control-label">E-mail</label>
		<div class="col-lg-10">
			<input type="email" class="form-control" name="email" id="form-email" value="<?=htmlent($form['email'])?>">
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<label for="form-captcha" class="control-label">Please also enter the text in the captcha below to verify that you are a human.</label>
			<div id="form-captcha" class="captcha-container">
<?=$recaptcha_lib->get_noscript_html(); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="submit" class="btn btn-primary">Submit Request</button>
		</div>
	</div>
</form>