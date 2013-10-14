<h2>Map</h2>
<div class="map-container" data-markers="<?=htmlentities($map_data_json);?>">
	<p>Click on a pointer on the map to see information about that station.</p>
	<p>You can also select a station from the list below and it will automatically be chosen on the map.</p>
	<div class="station-selection-container">
		<span>Choose a station: <select class="choose-station-select"></select></span>
	</div>

	<div class="map-canvas"></div>
	<button class="btn btn-default btn-block reset-map-btn" type="button">Reset Map</button>
	<script type="text/template" class="info-window-template">
		<div class="info-window">
			<div>
				<img class="logo"></img>
			</div>
			<div class="live-row">
				Live At <span class="start-time"></span>
			</div>
			<div class="participation-row">
				&bull; <span class="participation-msg"></span> &bull;
			</div>
		</div>
	</script>
</div>