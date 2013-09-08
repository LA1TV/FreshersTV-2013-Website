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
<h2>Application Form</h2>
<p>FreshersTV is the largest Student TV broadcast in the UK, with stations throughout the UK taking part in a three hour collaborative live broadcast showing the very best of Freshers Week content. This year the broadcast will be on <strong>Thursday 24th October starting at 6pm</strong>. Each station will have a <strong>5 minute slot</strong> to showcase the best of their Freshers Week content and any other content they have produced.</p>
<p>Please answer all the questions below to help us make sure that this years broadcast can accommodate as many stations as possible and show off your content in the best possible way. If you require any further information please email Chris Osborn at <a href="mailto:c.osborn@la1tv.co.uk" target="_blank">c.osborn@la1tv.co.uk</a> or Rachel Hughes at <a href="mailto:r.hughes@la1tv.co.uk" target="_blank">r.hughes@la1tv.co.uk</a>.</p>
<p>If you have any technical issues or enquiries please contact <a href="mailto:development@la1tv.co.uk" target="_blank">development@la1tv.co.uk</a>.
<p><strong>You can only submit this form once for your stations e-mail address and your station must be affiliated with NaSTA.</strong></p>
<p>By providing this information you agree that NaSTA may contact you or your station regarding future NaSTA events and other services.</p>
<?php if (count($form_errors) !== 0) : ?>
<div class="alert alert-danger">There <?php if(count($form_errors) === 1):echo("is");else:echo("are");endif;?> <?=count($form_errors)?> <?php if(count($form_errors) === 1):echo("error");else:echo("errors");endif;?> that need to be fixed before you can submit this form. <?php if(count($form_errors) === 1):echo("It has");else:echo("They have");endif;?> been highlighted.</div>
<?php endif; ?>
<?=form_open('apply/submit', array("class"=>"form-horizontal application-form", "role"=>"form", "novalidate"=>""));?>
	<input type="hidden" name="form_submitted" value="1">
	<h3>Station Details</h3>
	<div class="form-group <?=get_error_class($form_errors, "name");?>">
		<label for="form-name" class="col-lg-2 control-label">Full Station Name</label>
		<div class="col-lg-10">
			<input type="text" class="form-control" name="name" id="form-name" value="<?=htmlent($form['name'])?>">
			<span class="help-block"><?=get_error_msg($form_errors, "name", TRUE);?>Please enter your name <em>exactly</em> how you want it to appear on the broadcast.</span>
		</div>
	</div>
	<div class="form-group <?=get_error_class($form_errors, "contact");?>">
		<label for="form-contact" class="col-lg-2 control-label">Lead Contact</label>
		<div class="col-lg-10">
			<input type="text" class="form-control" name="contact" id="form-contact" value="<?=htmlent($form['contact'])?>">
			<?=get_error_msg($form_errors, "contact");?>
		</div>
	</div>
	<div class="form-group <?=get_error_class($form_errors, "email");?>">
		<label for="form-email" class="col-lg-2 control-label">E-mail Address</label>
		<div class="col-lg-10">
			<input type="email" class="form-control" name="email" id="form-email" value="<?=htmlent($form['email'])?>">
			<span class="help-block"><?=get_error_msg($form_errors, "email", TRUE);?>This will be used as your login to the control panel and our primary method of communication.</span>
		</div>
	</div>
	<div class="form-group <?=get_error_class($form_errors, "email_confirmation");?>">
		<label for="form-email-confirmation" class="col-lg-2 control-label">Re-enter E-mail Address</label>
		<div class="col-lg-10">
			<input type="email" class="form-control" name="email_confirmation" id="form-email-confirmation" autocomplete="off" value="<?=htmlent($form['email_confirmation'])?>">
			<?=get_error_msg($form_errors, "email_confirmation");?>
		</div>
	</div>
	<div class="form-group <?=get_error_class($form_errors, "postcode");?>">
		<label for="form-postcode" class="col-lg-2 control-label">Station Postcode</label>
		<div class="col-lg-10">
			<input type="text" class="form-control" name="postcode" id="form-postcode" value="<?=htmlent($form['postcode'])?>">
			<span class="help-block"><?=get_error_msg($form_errors, "postcode", TRUE);?>This will be used to locate your station on a map of all participating stations.</span>
		</div>
	</div>
	<div class="form-group <?=get_error_class($form_errors, "phone");?>">
		<label for="form-phone" class="col-lg-2 control-label">Phone No</label>
		<div class="col-lg-10">
			<input type="text" class="form-control" name="phone" id="form-phone" value="<?=htmlent($form['phone'])?>">
			<?=get_error_msg($form_errors, "phone");?>
		</div>
	</div>
	<h3>Station Logo</h3>
	<p>Please upload the highest quality version(s) you have to a file sharing service like "<a href="https://mega.co.nz/" target="_blank">https://mega.co.nz/</a>" or "<a href="https://www.dropbox.com/" target="_blank">https://www.dropbox.com/</a>" and provide the full url. If you have it as a photoshop (psd) or illustrator (ai) file this format is preferred.<br />
	Please try and send us a version with an alpha channel.<br />
	The file formats we accept are "psd", "ai", "jpeg", "jpg", "tiff", "bmp" and "png".<br />
	The file must remain accessible for at least 10 days after submitting the application and should not require a login in order for us to access it.</p>
	<p>The secondary logo is for another version of your logo which is of a different aspect ratio or design. This is optional.</p>
	<div class="form-group <?=get_error_class($form_errors, "main_logo");?>">
		<label for="form-main-logo" class="col-lg-2 control-label">Main Logo Url</label>
		<div class="col-lg-10">
			<input type="url" class="form-control" name="main_logo" id="form-main-logo" value="<?=htmlent($form['main_logo'])?>">
			<?=get_error_msg($form_errors, "main_logo");?>
		</div>
	</div>
	<div class="form-group <?=get_error_class($form_errors, "secondary_logo");?>">
		<label for="form-secondary-logo" class="col-lg-2 control-label">Secondary Logo Url (optional)</label>
		<div class="col-lg-10">
			<input type="url" class="form-control" name="secondary_logo" id="form-secondary-logo" value="<?=htmlent($form['secondary_logo'])?>">
			<?=get_error_msg($form_errors, "secondary_logo");?>
		</div>
	</div>
	<h3>Your Participation</h3>
	<div class="form-group <?=get_error_class($form_errors, "participation_type");?>">
		<label class="col-lg-2 control-label">How will you be taking part?</label>
		<div class="col-lg-10">
			<label class="radio-inline">
				<input type="radio" name="participation_type" value="live" <?php if($form['participation_type'] == "live"):echo('checked="checked"');endif;?>> Live
			</label>
			<label class="radio-inline">
				<input type="radio" name="participation_type" value="vt" <?php if($form['participation_type'] == "vt"):echo('checked="checked"');endif;?>> VT
			</label>
			<?=get_error_msg($form_errors, "participation_type");?>
		</div>
	</div>
	<div class="show-if-vt">
		<p>Please ensure that your VT is <em>between 4:30 and 5 minutes</em> in length. Entries outside of these limits may be refused.</p>
	</div>
	<p>If you are not going to participate live, or you are participating live but would like to submit a VT as a backup, the VT must fit the following requirements:</p>
	<ul>
		<li>Must use the h.264 codec.</li>
		<li>Must have a resolution of either 1920x1080, 1080x720 or 1024x576.</li>
		<li>Must have a frame rate of either 25fps or 50fps.</li>
		<li>Must be progressive, not interlaced.</li>
	</ul>
	<div class="show-if-live">
		<p>We will try our best to put every stations' slot within their preferred time however this may not be possible. The ending time of the broadcast will depend on the number of stations taking part.</p>
		<div class="form-group <?=get_error_class($form_errors, "participation_time");?>">
			<label class="col-lg-2 control-label">Your Preferred Time</label>
			<div class="col-lg-10">
				<select class="form-control smart-dropdown" name="participation_time">
<?php
	$values = array(
		array("", "Choose..."),
		array("1800", "18:00 - 18:15"),
		array("1815", "18:15 - 18:30"),
		array("1830", "18:30 - 18:45"),
		array("1845", "18:45 - 19:00"),
		array("1900", "19:00 - 19:15"),
		array("1915", "19:15 - 19:30"),
		array("1930", "19:30 - 19:45"),
		array("1945", "19:45 - 20:00"),
		array("2000", "20:00 - 20:15"),
		array("2015", "20:15 - 20:30"),
		array("2030", "20:30 - 20:45"),
		array("2045", "20:45 - 21:00"),
		array("2100", "21:00 - 21:15"),
		array("2115", "21:15 - 21:30"),
		array("2130", "21:30 - 21:45"),
		array("2145", "21:45 - 22:00")
	);
	
	foreach($values as $a):
?>
					<option value="<?=htmlent($a[0])?>" <?php if($form['participation_time'] == $a[0]):echo('selected="selected"');endif;?>><?=htmlent($a[1])?></option>
<?php endforeach; ?>
				</select>
				<?=get_error_msg($form_errors, "participation_time");?>
			</div>
		</div>
	</div>
	<div class="show-if-live">
		<h3>Stream Details</h3>
		<p>Please tell us the details of your stream to us.</p>
		<p>Please note that the broadcast will be in 720p at around 2 mbps. Resolutions and bit rates that match this will produce the best viewing quality. Resolutions which are not 16:9 may appear distorted on the broadcast.</p>
		<p>We are not responsible for any cropping or distortion if your stream does not follow these guidelines.</p>
		<p>If you are unable to stream in 16:9 please provide as much information as possible in the "Extra Information" box and we will get back to you.</p>
		<div class="form-group <?=get_error_class($form_errors, "resolution");?>">
			<label for="form-resolution" class="col-lg-2 control-label">Resolution</label>
			<div class="col-lg-10">
				<input type="text" class="form-control" id="form-resolution" name="resolution" value="<?=htmlent($form['resolution'])?>"/>
				<?=get_error_msg($form_errors, "resolution");?>
			</div>
		</div>
		<div class="form-group <?=get_error_class($form_errors, "bitrate");?>">
			<label for="form-bitrate" class="col-lg-2 control-label">Bit Rate</label>
			<div class="col-lg-10">
				<input type="text" class="form-control" id="form-bitrate" name="bitrate" value="<?=htmlent($form['bitrate'])?>"/>
				<?=get_error_msg($form_errors, "bitrate");?>
			</div>
		</div>
		<div class="form-group <?=get_error_class($form_errors, "stream_url");?>">
			<label for="form-stream-url" class="col-lg-2 control-label">RMTP Stream Url</label>
			<div class="col-lg-10">
				<input type="text" class="form-control" id="form-stream-url" name="stream_url" value="<?=htmlent($form['stream_url'])?>"/>
				<span class="help-block"><?=get_error_msg($form_errors, "stream_url", TRUE);?>This is what we will connect to to access your stream. E.g. "rtmp://dtu-fmis.lancs.ac.uk/la1tv_live/_definst_" is ours. You can leave this blank if you do not have this information at this time.</span>
			</div>
		</div>
		<div class="form-group <?=get_error_class($form_errors, "stream_extra");?>">
			<label for="form-stream-extra" class="col-lg-2 control-label">Extra Information (optional)</label>
			<div class="col-lg-10">
				<textarea class="form-control" rows="3" id="form-stream-extra" name="stream_extra" style="resize: vertical;"><?=htmlent($form['stream_extra'])?></textarea>
			</div>
		</div>
	</div>
	<h3>Graphic Overlays</h3>
	<p>We will have a FreshersTV bug overlaid on the top left corner of the screen throughout the entire show and also lower thirds for each station which we will show during the first 30 seconds of each broadcast.</p>
	<p>At several times during the show we will be showing facebook posts and tweets on a ticker at the bottom of the screen. We will not overlay this over your stations broadcast by default but if you would like this over your feed please tell us when you want it starting/stopping via the comms system during your section. Please note that it could take up to 30 seconds for the ticker to have completely animated out and we may choose not to show the ticker at all. If you are not streaming live then please let us know in the box below if you would like this over your VT.</p>
	<p>If you will be adding <em>any</em> graphic overlays during your broadcast please let us know. If any of this changes in the future please e-mail us.</p>
	<div class="form-group <?=get_error_class($form_errors, "overlay_details");?>">
		<div class="col-lg-offset-2 col-lg-10">
			<label for="form-overlay-details" class="control-label">Will you be overlaying any graphics on your stream/VT (including any graphics in the VT render) and/or would like the ticker?</label>
			<textarea class="form-control" rows="3" id="form-overlay-details" name="overlay_details" style="resize: vertical;"><?=htmlent($form['overlay_details'])?></textarea>
			<span class="help-block"><?=get_error_msg($form_errors, "overlay_details", TRUE);?>Please provide as much detail as possible. We will get back to you if there are any issues.</span>
		</div>
	</div>
	<h3>CineBeat Video</h3>
	<p>We are creating an interactive map of all of the participating stations to show viewers where they are and what time they are on. There will be a pin for each station which will show the following information when clicked:</p>
	<ul>
		<li>Station name.</li>
		<li>Station logo.</li>
		<li>Broadcast time slot.</li>
		<li>Station CineBeat video.</li>
	</ul>
	<p>We would like to make these a little more individual to each station and more fun for the viewers. To do this we would like each station to create and send us a CineBeat video. These are short music videos create from clips recorded on an iPhone or iPad using a free app. We would like you to include the name of your station and the word FreshersTV in your video but everything else is up to you. This map will be launched a couple of days ahead of the broadcast to help publicise the event and let viewers know what time each station is on.</p>
	<p>The CineBeat app can be found at "<a href="https://itunes.apple.com/gb/app/cinebeat-by-smule/id562793878" target="_blank">https://itunes.apple.com/gb/app/cinebeat-by-smule/id562793878</a>".</p>
	<p>The easiest way to get the link after creating the video is by using the option to send it as an e-mail.</p>
	<div class="form-group <?=get_error_class($form_errors, "cinebeat");?>">
		<label for="form-cinebeat" class="col-lg-2 control-label">CineBeat Video Url</label>
		<div class="col-lg-10">
			<input type="url" class="form-control" name="cinebeat" id="form-cinebeat" value="<?=htmlent($form['cinebeat'])?>">
			<?=get_error_msg($form_errors, "cinebeat");?>
		</div>
	</div>
	<h3>Login Details</h3>
	<p>Please create a password. This will be used to log into the control panel for the event and access our comms system. Don't forget it!</p>
	<p>It will be encrypted with a one way hash meaning we will not be able to tell you what it is.</p>
	<p>We are not using SSL so it is important that you don't use a password here that you use on any other website(s).</p>
	<div class="form-group">
		<label for="form-username" class="col-lg-2 control-label">User Name</label>
		<div class="col-lg-10">
			<input type="text" class="form-control" id="form-username" readonly="readonly" value="[This will be the e-mail address you have entered above.]"/>
		</div>
	</div>
	<div class="form-group <?=get_error_class($form_errors, "password");?>">
		<label for="form-password" class="col-lg-2 control-label">Create A Password</label>
		<div class="col-lg-10">
			<input type="password" class="form-control" name="password" id="form-password"/>
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
	<h3>Security Check</h3>
	<div class="form-group <?=get_error_class($form_errors, "captcha");?>">
		<div class="col-lg-offset-2 col-lg-10">
			<label for="form-captcha" class="control-label">Please enter the text in the captcha below to verify that you are a human.</label>
			<div id="form-captcha" class="captcha-container">
			<?=$recaptcha_lib->get_noscript_html(); ?>
			</div>
			<?=get_error_msg($form_errors, "captcha");?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="submit" class="btn btn-primary">Submit Application</button>
		</div>
	</div>
</form>