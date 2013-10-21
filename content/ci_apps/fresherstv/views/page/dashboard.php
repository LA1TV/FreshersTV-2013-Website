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
<h2>Live Schedule</h2>
<p>This schedule will <strong>update automatically</strong> as any changes are made so please keep an eye on it during the broadcast!</p>
<p>Your time has been highlighted.</p>
<table class="table table-striped table-bordered table-hover schedule-table" data-stationid="<?=htmlent($station_id);?>">
	<thead>
		<th>Station</th>
		<th>Live Time</th>
	</thead>
	<tbody>
		<tr>
			<td colspan="2"><em>Loading...</em></td>
		</tr>
	</tbody>
</table>
<h2>Low Latency Stream</h2>
<p>This is a low quality low latency version of the stream. Please use <a href="<?=base_url()?>live" target="_blank"><?=base_url()?>live</a> to watch the normal stream.</p>
<?php if (!$show_stream): ?>
<p><em>This will become available when we are live.</em></p>
<?php else: ?>
<div class="row">
	<div class="col-md-5">
		<div class="scaled-el-container">
			<img class="ratio" src="<?=base_url();?>assets/img/16x9.gif" alt=""/>
			<?php if ($device == "pc"): ?>
			<object class="stream-player-container el">
				<param name="movie" value="<?=base_url();?>assets/flash/StrobeMediaPlayback.swf"></param>
				<param name="flashvars" value="src=<?=urlencode($stream_url)?>&amp;streamType=live&amp;autoPlay=true"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="allowscriptaccess" value="always"></param>
				<param name="wmode" value="direct"></param>
				<embed src="<?=base_url();?>assets/flash/StrobeMediaPlayback.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="direct" flashvars="src=<?=urlencode($stream_url)?>&amp;streamType=live&amp;autoPlay=true"></embed>
			</object>
			<?php elseif ($device == "mobile"): ?>
			<video controls="" autoplay="" class="el" src="<?=htmlent($stream_url)?>">
			<?php endif; ?>
		</div>
	</div>
</div>
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