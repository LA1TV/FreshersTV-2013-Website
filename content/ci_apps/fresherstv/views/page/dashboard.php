<?php
	$this->load->helper("security");
?>
<h2>Your Station Dashboard</h2>
<h3>Live Schedule</h3>
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
<h3>Synchronised Clock</h3>
<p>This clock should be synchronised with the clocks in our studio.</p>
<div class="clock-container">
	<span class="txt"></span>
</div>
<p><a class="btn btn-info btn-sm" target="_blank" href="<?=base_url()?>clock">Click Here To View The Clock On A Seperate Page</a></p>
<h3>Low Latency Stream</h3>
<p>This is a low quality low latency version of the stream. Please use <a href="<?=base_url()?>live" target="_blank"><?=base_url()?>live</a> to watch the normal stream.</p>
<?php if (!$show_stream): ?>
<p><em>This will become available when we are live.</em></p>
<?php else: ?>
<?php if ($device == "pc"): ?>
<div class="row">
	<div class="col-md-5">
		<div class="scaled-el-container">
			<img class="ratio" src="<?=base_url();?>assets/img/16x9.gif" alt=""/>
			<object class="stream-player-container el">
				<param name="movie" value="<?=base_url();?>assets/flash/StrobeMediaPlayback.swf"></param>
				<param name="flashvars" value="src=<?=urlencode($stream_url)?>&amp;streamType=live&amp;liveBufferTime=0&amp;autoPlay=true"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="allowscriptaccess" value="always"></param>
				<param name="wmode" value="direct"></param>
				<embed src="<?=base_url();?>assets/flash/StrobeMediaPlayback.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="direct" flashvars="src=<?=urlencode($stream_url)?>&amp;streamType=live&amp;liveBufferTime=0&amp;autoPlay=true"></embed>
			</object>
		</div>
	</div>
</div>
<?php elseif ($device == "mobile"): ?>
<p><em>The low latency stream is not available on mobile devices.</em></p>
<?php endif; ?>
<?php endif; ?>
<h3>Chat</h3>
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