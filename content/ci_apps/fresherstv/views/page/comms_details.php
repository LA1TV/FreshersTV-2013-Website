<?php
	$this->load->helper("security");
?>
<h2>Your Comms Details</h2>
<p>These details are specific to your station.</p>
<p><strong>Please do not share them with anyone else. If more than one device tries to call in with the same settings it will not work and cause problems for you.</strong>
<h3>Your Settings</h3>
<?php if ($settings === FALSE): ?>
<p><em>These settings haven't been set for you yet. Please send an e-mail to "<a href="mailto:development@la1tv.co.uk">development@la1tv.co.uk</a>" <strong>from the same e-mail address you put on the application form</strong> to get this fixed.</em></p> 
<?php else: ?>
	<p><small>Everything not listed should be left at the defaults.</small></p>
	<table class="table table-striped table-bordered table-hover">
		<tr>
			<td><strong>Domain:</strong></td>
			<td><?=htmlent($settings['domain']);?></td>
		</tr>
		<tr>
			<td><strong>User name:</strong></td>
			<td><?=htmlent($settings['username']);?></td>
		</tr>
		<tr>
			<td><strong>SIP address:</strong></td>
			<td><?=htmlent($settings['sip_address']);?></td>
		</tr>
		<tr>
			<td><strong>Password (case sensitive):</strong></td>
			<td><?=htmlent($settings['password']);?></td>
		</tr>
		<tr>
			<td><strong>Caller ID:</strong></td>
			<td><?=htmlent($settings['caller_id']);?></td>
		</tr>
	</table>
	<p>If you have any problems please send an e-mail to "<a href="mailto:development@la1tv.co.uk">development@la1tv.co.uk</a>" <strong>from the same e-mail address you put on the application form</strong>.</p> 

	<h3>Setting Up</h3>
	<h4>Recommended VOIP Applications</h4>
	<ul>
		<li><strong>Windows:</strong> Blink at <a target="_blank" href="http://icanblink.com/download.phtml#windows">http://icanblink.com/download.phtml#windows</a>.</li>
		<li><strong>Mac:</strong> Telephone at <a target="_blank" href="https://itunes.apple.com/gb/app/telephone/id406825478">https://itunes.apple.com/gb/app/telephone/id406825478</a>.</li>
		<li><strong>iOS:</strong> Zoiper at <a target="_blank" href="https://itunes.apple.com/gb/app/zoiper-sip-softphone-for-voip/id438949960">https://itunes.apple.com/gb/app/zoiper-sip-softphone-for-voip/id438949960</a>.</li>
	</ul>
	<p>Install the relevant application above and enter the settings above.</p>
	<p>Please make sure that only one device has these settings at one time.</p>
	<p><strong>The VOIP system was never designed for one account to be used on multiple devices and doing this will cause problems for you and might prevent you connecting.</strong></p>
	<h3>Calling In!</h3>
	<p>To call in simply <strong>dial 100</strong> on the voip phone. You should then hear a fanfare and an "access granted" message. If you don't hear this please send an e-mail to "<a href="mailto:development@la1tv.co.uk">development@la1tv.co.uk</a>" with as much information as possible as soon as possible.</p>
	<h2>How It Will Work?</h2>
	<p>On the day please call in as early as possible. You will be left on hold and should keep hearing occasional beeps. If you don't hear these something has gone wrong.</p>
	<p>20 minutes before your slot if you are participating live, and at any other relevant times, you will be connected through to the comms ops in our studio.</p>
	<p><strong>Please do not hang up until the end of your broadcast.</strong></p>
<?php endif; ?>
