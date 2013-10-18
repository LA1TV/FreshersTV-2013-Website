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
<h2>Chat</h2>
<p>To access the chat you will need to authenticate using the nickname and password below.</p>
<table class="table table-striped table-bordered table-hover">
	<tr>
		<td><strong>Nickname:</strong></td>
		<td><?=htmlent($chat_settings['username']);?></td>
	</tr>
	<tr>
		<td><strong>Password:</strong></td>
		<td><?=htmlent($chat_settings['password']);?></td>
	</tr>
	<tr>
		<td><strong>Channel:</strong></td>
		<td><?=htmlent($chat_settings['channel']);?></td>
	</tr>
</table>
<a href="https://kiwiirc.com/client/148.88.67.138:3456/chat" class="btn btn-default btn-sm" target="_blank">Click Here To Launch Chat</a>