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
<h2>Submit VT</h2>
<p>Please submit your VT even if you are streaming live to us so we have it as a backup. Here are the requirments:</p>
<ul>
	<li>Must use the h.264 codec.</li>
	<li>Must have a resolution of either 1920x1080, 1080x720 or 1024x576.</li>
	<li>Must have a frame rate of either 25fps or 50fps.</li>
	<li>Must be progressive, not interlaced.</li>
</ul>
<?php if (count($form_errors) !== 0) : ?>
<div class="alert alert-danger">There <?php if(count($form_errors) === 1):echo("is");else:echo("are");endif;?> <?=count($form_errors)?> <?php if(count($form_errors) === 1):echo("error");else:echo("errors");endif;?> that need to be fixed before you can submit this form. <?php if(count($form_errors) === 1):echo("It has");else:echo("They have");endif;?> been highlighted.</div>
<?php endif; ?>
<?=form_open('submitvt/submit', array("class"=>"form-horizontal submit-vt-form", "role"=>"form", "novalidate"=>""));?>
	<input type="hidden" name="form_submitted" value="1">
	<p>Please upload your VT to a file sharing service like "<a href="https://mega.co.nz/" target="_blank">https://mega.co.nz/</a>" or "<a href="https://www.dropbox.com/" target="_blank">https://www.dropbox.com/</a>" and provide the full url.</p>
	<div class="form-group <?=get_error_class($form_errors, "vt");?>">
		<label for="form-vt" class="col-lg-2 control-label">VT Url</label>
		<div class="col-lg-10">
			<input type="url" class="form-control" name="vt" id="form-vt" value="<?=htmlent($form['vt'])?>">
			<?=get_error_msg($form_errors, "vt");?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="submit" class="btn btn-primary">Submit VT</button>
		</div>
	</div>
</form>