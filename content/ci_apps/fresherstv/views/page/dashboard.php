<?php
	$this->load->helper("security");
?>
<h2>Your Station Dashboard</h2>
<h3>Live Time</h3>
<? if ($live_time === FALSE): ?>
	<p><em>You do not have a time at the moment. Please send an e-mail to "<a href="mailto:development@la1tv.co.uk">development@la1tv.co.uk</a>" <strong>from the same e-mail address you put on the application form</strong> to get this fixed.</em></p> 
<?php else: ?>
	<p>You are scheduled to go live at <?=htmlent($live_time);?>.</p>
<?php endif; ?>