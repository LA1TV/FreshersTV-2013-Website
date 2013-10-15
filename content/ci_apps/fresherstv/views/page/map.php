<?php
$this->load->helper("security");
?>
<h2>Map</h2>
<div class="map-container" data-markers="<?=htmlent($map_data_json);?>">
	<p>Click on a pointer on the map to see information about that station.</p>
	<p>You can also select a station from the list below and it will automatically be chosen on the map.</p>
	<div class="station-selection-container">
		<span>Choose a station: <select class="choose-station-select"></select></span>
	</div>

	<div class="map-canvas"></div>
	<div class="logo-row"><!--
		<?php foreach($map_data as $a): ?>
		--><div class="logo" data-stationid="<?=htmlent($a['id']);?>">
			<img class="logo-img" src="<?=htmlent(base_url() . "assets/img/station_logos/50x50/" . $a['logo_name'])?>" alt="<?=htmlent($a['name']."'s Logo");?>">
		</div><!--
		<?php endforeach; ?>
	--></div>
	<button class="btn btn-default btn-block reset-map-btn" type="button">Reset Map</button>
	<script type="text/template" class="info-window-template">
		<div class="info-window">
			<div>
				<img class="logo" src="">
			</div>
			<div class="hide-if-host">
				<div class="live-row">
					Live At <span class="start-time"></span>
				</div>
				<div class="participation-row">
					<span class="participation-msg"></span>
				</div>
			</div>
			<div class="show-if-host">
				<span>Your Host!</span>
			</div>
		</div>
	</script>
</div>