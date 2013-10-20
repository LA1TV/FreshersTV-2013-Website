<?php
$this->load->helper("security");
?>
<?php if (!$live): ?>
<h2>Live</h2>
<?php if ($time_txt !== FALSE): ?>
<p>We will be live from <strong><?=htmlent($time_txt)?></strong>.</p>
<?php else: ?>
<p>We are not live at the moment. Please check back later!</p>
<?php endif; ?>
<?php else: ?>
<div class="row">
	<div class="col-md-8">
		<div class="scaled-el-container">
			<img class="ratio" src="<?=base_url();?>assets/img/16x9.gif" alt=""/>
			<!-- Using stream url: <?=htmlent($stream_url);?> -->
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
			<video controls="" autoplay="" class="el" src="<?=base_url();?>assets/videos/promo/video-720p.mp4">
			<?php endif; ?>
		</div>
		<?php if ($map_enabled): ?>
		<p class="view-map-button-container"><a href="<?=base_url();?>map" class="btn btn-info btn-block" target="_blank">Click Here To View The Stations Map</a></p>
	<?php endif; ?>
	</div>
	<div class="col-md-4">
		<h2>We are live!</h2>
		<h3>Participate Online</h3>
		<dl>
		  <dt>Twitter</dt>
		  <dd>Tweet with <strong>#FreshersTV</strong>.<br />
		  <a href="https://twitter.com/share" class="twitter-share-button" data-via="FreshersTV" data-hashtags="FreshersTV" data-url="<?=base_url();?>live" data-lang="en">Tweet</a></dd>
		</dl>
		<dl>
		  <dt>Facebook</dt>
		  <dd>Post on our page at <a href="https://facebook.com/fresherstv/" target="_blank">https://facebook.com/fresherstv/</a>.</dd>
		</dl>
		<p>Your comment may be featured on the live broadcast!</p>
	</div>
</div>
<?php endif; ?>