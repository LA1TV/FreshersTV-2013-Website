<?php
$this->load->helper("security");
?>
<h1>Applications</h1>
<p>Here are all of the current applications.</p>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Station Name</th>
			<th>E-mail</th>
			<th>Contact</th>
			<th>Phone</th>
			<th>Participation Type</th>
			<th>E-mail Verified</th>
			<th>Application Accepted</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach($table_rows as $a): ?>
		<tr>
			<td><?=htmlent($a['name'])?></td>
			<td><a href="mailto:<?=htmlent($a['email'])?>" target="_blank"><?=htmlent($a['email'])?></a></td>
			<td><?=htmlent($a['contact'])?></td>
			<td><?=htmlent($a['phone'])?></td>
			<td><?=htmlent($a['participation_type'])?></td>
			<td><?=$a['verified']?></td>
			<td><?=$a['accepted']?></td>
			<td><a href="<?=base_url()?>viewapplications/view?id=<?=$a['id']?>" class="btn btn-info btn-xs">View</a></td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>