<?php
$this->load->helper("form");
$this->load->helper("security");

function get_error_class($form_errors, $element) {
	return array_key_exists($element, $form_errors) ? "has-error" : "";
}
function get_error_msg($form_errors, $element, $in_help_block=FALSE) {

	if (!array_key_exists($element, $form_errors)) {
		return "";
	}
	
	$msg = $form_errors[$element];
	
	if (!$in_help_block) {
		return ('<span class="help-block"><strong>'.htmlent($msg).'</strong></span>');
	}
	else {
		return ('<strong>'.htmlent($msg).'</strong><br />');
	}
}
?>
<?php if ($state === 0): ?>
<h2>Set A New Password</h2>
<?php if (count($form_errors) !== 0) : ?>
<div class="alert alert-danger">There <?php if(count($form_errors) === 1):echo("is");else:echo("are");endif;?> <?=count($form_errors)?> <?php if(count($form_errors) === 1):echo("error");else:echo("errors");endif;?> that need to be fixed before you can submit this form. <?php if(count($form_errors) === 1):echo("It has");else:echo("They have");endif;?> been highlighted.</div>
<?php endif; ?>
<?=form_open('passwordreset/changesubmit', array("class"=>"form-horizontal password-reset-change-form", "role"=>"form", "novalidate"=>""));?>
	<input type="hidden" name="form_submitted" value="1">
	<div class="form-group <?=get_error_class($form_errors, "password");?>">
		<label for="form-password" class="col-lg-2 control-label">New Password</label>
		<div class="col-lg-10">
			<input type="password" class="form-control" name="password" id="form-password">
			<span class="help-block"><?=get_error_msg($form_errors, "password", TRUE);?>Must be at least 8 characters long and contain at least one upper and lower case letter and a number.</span>
		</div>
	</div>
	<div class="form-group <?=get_error_class($form_errors, "password_confirmation");?>">
		<label for="form-password-confirmation" class="col-lg-2 control-label">Re-enter Password</label>
		<div class="col-lg-10">
			<input type="password" class="form-control" name="password_confirmation" id="form-password-confirmation"/>
			<?=get_error_msg($form_errors, "password_confirmation");?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="submit" class="btn btn-primary">Change Password</button>
		</div>
	</div>
</form>


<?php elseif ($state === 1): ?>
<h2>Link Expired</h2>
<p>That password reset link has expired. Please submit another password reset request by <a href="<?=base_url();?>passwordreset">clicking here</a>.</p>
<p>If you have any problems please send an e-mail to "<a href="mailto:development@la1tv.co.uk" target="_blank">development@la1tv.co.uk</a>" <strong>from the same e-mail address you put on the application form</strong>.</p>
<?php else: ?>
<h2>Link Invalid</h2>
<p>That password reset link was invalid.</p>
<p>If you have any problems please send an e-mail to "<a href="mailto:development@la1tv.co.uk" target="_blank">development@la1tv.co.uk</a>" <strong>from the same e-mail address you put on the application form</strong>.</p>
<?php endif; ?>