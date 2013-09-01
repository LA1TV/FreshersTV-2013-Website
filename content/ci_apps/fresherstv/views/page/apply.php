<?php
$this->load->helper("form");
?>
<h2 class="live-in-txt">Application Form</h2>
<?=form_open('apply/submit', array("class"=>"form-horizontal application-form", "role"=>"form", "novalidate"=>""));?>
	<p>FreshersTV is the largest Student TV broadcast in the UK, with stations throughout the UK taking part in a three hour collaborative live broadcast showing the very best of Freshers Week content. This year the broadcast will be on <strong>Thursday 24th October starting at 6pm</strong>. Each station will have a <strong>5 minute slot</strong> to showcase the best of their Freshers Week content and any other content they have produced.</p>
	<p>If you are taking part by submitting a VT please ensure it is <strong>between 4:30 and 5 minutes</strong> in length. Entries outside of these limits may be refused.</p>
	<p>Please answer all the questions below to help us make sure that this years broadcast can accommodate as many stations as possible and show off your content in the best possible way. If you require any further information please email Chris Osborn at <a href="mailto:c.osborn@la1tv.co.uk" target="_blank">c.osborn@la1tv.co.uk</a> or Rachel Hughes at <a href="mailto:r.hughes@la1tv.co.uk" target="_blank">r.hughes@la1tv.co.uk</a>.</p>
	<p>If you have any technical issues or enquiries please contact <a href="mailto:development@la1tv.co.uk" taget="_blank">development@la1tv.co.uk</a>.
	<p><strong>You can only submit this form once for your stations e-mail address.</strong></p>
	<h3>Station Details</h3>
	<div class="form-group">
		<label for="form-name" class="col-lg-2 control-label">Full Station Name</label>
		<div class="col-lg-10">
			<input type="text" class="form-control" name="name" id="form-name" value="<?=htmlent($form['name'])?>">
			<span class="help-block">Please enter your name <em>exactly</em> how you want it to appear on the broadcast.</span>
		</div>
	</div>
	<div class="form-group">
		<label for="form-email" class="col-lg-2 control-label">E-mail Address</label>
		<div class="col-lg-10">
			<input type="email" class="form-control" name="email" id="form-email" value="<?=htmlent($form['email'])?>">
			<span class="help-block">This will be used as your login to the control panel and our primary method of communication.</span>
		</div>
	</div>
	<div class="form-group">
		<label for="form-email-confirmation" class="col-lg-2 control-label">Re-enter E-mail Address</label>
		<div class="col-lg-10">
			<input type="email" class="form-control" name="email_confirmation" id="form-email-confirmation" value="<?=htmlent($form['name_confirmation'])?>">
		</div>
	</div>
	<h3>Logo</h3>
	<p>Please upload the highest quality version you have. If you have it as a photoshop (psd) or illustrator (ai) file this format is preferred.<br />
	Please try and send us a version with an alpha channel.<br />
	The file formats we accept are "psd", "ai", "jpeg", "jpg", "tiff", "bmp" and "png".</p>
	<p>The secondary logo is for another version of your logo which is of a different aspect ratio or design. This is optional.</p>
	<div class="form-group">
		<label for="form-main-logo" class="col-lg-2 control-label">Main Station Logo</label>
		<div class="col-lg-10">
			<input type="file" class="form-control logo-file-input" name="main_logo" class="logo-file-input" id="form-main-logo">
		</div>
	</div>
	<div class="form-group">
		<label for="form-secondary-logo" class="col-lg-2 control-label">Secondary Logo (optional)</label>
		<div class="col-lg-10">
			<input type="file" class="form-control logo-file-input" name="secondary_logo" id="form-secondary-logo">
		</div>
	</div>
	<h3>Your Participation</h3>
	<div class="form-group">
		<label class="col-lg-2 control-label">How will you be taking part?</label>
		<div class="col-lg-10">
			<label class="radio-inline">
				<input type="radio" name="participation-type" value="live"> Live
			</label>
			<label class="radio-inline">
				<input type="radio" name="participation-type" value="vt"> VT
			</label>
		</div>
	</div>
	<div class="show-if-live">
		<p>We will try our best to put every stations' slot within their preferred time however this may not be possible. The ending time of the broadcast will depend on the number of stations taking part.</p>
		<div class="form-group">
			<label class="col-lg-2 control-label">Your Preferred Time</label>
			<div class="col-lg-10">
				<select class="form-control smart-dropdown">
					<option value="">Choose...</option>
					<option value="1800">18:00 - 18:15</option>
					<option value="1815">18:15 - 18:30</option>
					<option value="1830">18:30 - 18:45</option>
					<option value="1845">18:45 - 19:00</option>
					<option value="1900">19:00 - 19:15</option>
					<option value="1915">19:15 - 19:30</option>
					<option value="1930">19:30 - 19:45</option>
					<option value="1945">19:45 - 20:00</option>
					<option value="2000">20:00 - 20:15</option>
					<option value="2015">20:15 - 20:30</option>
					<option value="2030">20:30 - 20:45</option>
					<option value="2045">20:45 - 21:00</option>
					<option value="2100">21:00 - 21:15</option>
					<option value="2115">21:15 - 21:30</option>
					<option value="2130">21:30 - 21:45</option>
					<option value="2145">21:45 - 22:00</option>
				</select>
			</div>
		</div>
	</div>
	<div class="show-if-live">
		<h3>Stream Details</h3>
		<p>Please tell us the details of your stream to us.</p>
		<p>Please note that the broadcast will be in 720p at around 2 mbps. Resolutions and bit rates that match this will produce the best viewing quality. Resolutions which are not 16:9 may appear distorted on the broadcast.</p>
		<div class="form-group">
			<label for="form-resolution" class="col-lg-2 control-label">Resolution</label>
			<div class="col-lg-10">
				<input type="text" class="form-control" id="form-resolution" name="resolution" value="<?=htmlent($form['resolution'])?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="form-bitrate" class="col-lg-2 control-label">Bit Rate</label>
			<div class="col-lg-10">
				<input type="text" class="form-control" id="form-bitrate" name="bitrate" value="<?=htmlent($form['bitrate'])?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="form-stream-extra" class="col-lg-2 control-label">Extra Information (optional)</label>
			<div class="col-lg-10">
				<textarea class="form-control" rows="3" id="form-stream-extra" name="stream_extra" style="resize: vertical;"><?=htmlent($form['stream_extra'])?></textarea>
			</div>
		</div>
	</div>
	<h3>Graphic Overlays</h3>
	<p>[Description here about our graphics and what is allowed and social media scroller.]
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<label for="form-overlay-details">Will you be overlaying any graphics on your stream/VT? If so please provide as much detail as possible below. We will get back to you if there are any issues.</label>
			<textarea class="form-control" rows="3" id="form-overlay-details" name="overlay_details" style="resize: vertical;" value="<?=htmlent($form['overlay_details'])?>"></textarea>
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
	<div class="form-group">
		<label for="form-password" class="col-lg-2 control-label">Create A Password</label>
		<div class="col-lg-10">
			<input type="password" class="form-control" name="password" id="form-password"/>
			<span class="help-block">Must be at least 8 characters long and contain at least one upper and lower case letter and a number.</span>
		</div>
	</div>
	<div class="form-group">
		<label for="form-password-confirmation" class="col-lg-2 control-label">Re-enter Password</label>
		<div class="col-lg-10">
			<input type="password" class="form-control" name="password_confirmation" id="form-password-confirmation"/>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<button type="submit" class="btn btn-default">Submit Application</button>
		</div>
	</div>
</form>