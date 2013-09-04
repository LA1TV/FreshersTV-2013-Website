<?php
$this->load->helper("form");
$this->load->helper("security");
?>
<h2>Login</h2>
<p>Please login below with the e-mail address and password you set up on the <a href="<?=base_url();?>apply">application form</a>.</p>
<p>If you have any problems please send an e-mail to "<a href="mailto:development@la1tv.co.uk" target="_blank">development@la1tv.co.uk</a>" <strong>from the same e-mail address you put on the application form</strong>.</p>
<?php if (strlen($login_required_msg) !== 0) : ?>
	<div class="alert alert-info"><?=htmlent($login_required_msg);?></div>
<?php endif; ?>
<?php if (strlen($login_error_msg) !== 0) : ?>
	<div class="alert alert-danger"><?=htmlent($login_error_msg);?></div>
<?php endif; ?>

<?=form_open('login/submit', array("class"=>"form-horizontal login-form", "role"=>"form", "novalidate"=>""));?>
	<input type="hidden" name="form_submitted" value="1">
<?php if ($form['next_uri'] !== FALSE): ?>
	<input type="hidden" name="next_uri" value="<?=htmlent($form['next_uri'])?>">
<?php endif; ?>
	<div class="form-group">
		<label for="form-email" class="col-lg-2 control-label">E-mail</label>
		<div class="col-lg-10">
			<input type="email" class="form-control" name="email" id="form-email" value="<?=htmlent($form['email'])?>">
		</div>
	</div>
		<div class="form-group">
		<label for="form-password" class="col-lg-2 control-label">Password</label>
		<div class="col-lg-10">
			<input type="password" class="form-control" name="password" id="form-password">
			<span class="help-block">Your password is case-sensitive.</span>
		</div>
	</div>
<?php if ($captcha_required): ?>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<label for="form-captcha" class="control-label">Please also enter the text in the captcha below to verify that you are a human.</label>
			<div id="form-captcha">
<?php
	echo($recaptcha_lib->get_html());
?>
			</div>
		</div>
	</div>
<?php endif; ?>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="submit" class="btn btn-default">Login</button>
		</div>
	</div>
</form>