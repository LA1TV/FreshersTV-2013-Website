<?php
$this->load->helper("form");
$this->load->helper("security");
?>
<h2>Scheduling</h2>
<?=form_open("scheduling/submit", array("class"=>"form-horizontal scheduling-form", "role"=>"form", "novalidate"=>""));?>
		<input type="hidden" name="form_submitted" value="1">
		<?php foreach($stations as $a): ?>
		<input type="hidden" name="station-<?=$a['index']?>-id" value="<?=$a['id']?>">
		<?php endforeach; ?>
		<table class="table table-bordered table-hover scheduling-table">
<?php foreach($stations as $a): ?>
			<tr>
				<td><?= htmlent($a['index']+1) ?>)</td>
				<td><?= htmlent($a['name']) ?></td>
				<td><input type="datetime-local" name="station-<?= htmlent($a['index']) ?>-time" value="<?= htmlent($a['live_time_html']) ?>"></td>
			</tr>
<?php endforeach; ?>
		</table>
		<button type="submit" class="btn btn-default">Update!</button>
</form>