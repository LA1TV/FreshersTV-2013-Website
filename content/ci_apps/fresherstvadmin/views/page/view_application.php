<?php
$this->load->helper("form");
// already htmlented
?>
<h1>View Application</h1>
<?php if ($info_txt != ""): ?>
<div class="alert alert-success"><?=htmlent($info_txt)?></div>
<?php endif; ?>
<table class="table table-bordered table-hover">
	<tbody>
<?php foreach($table_rows as $a): ?>
		<tr>
			<td><strong><?=$a[0]; ?>:</strong></td>
			<td><?=$a[1]; ?></td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php if ($show_send_verification_button): ?>
<p>
	<?=form_open($this->uri->uri_string()."?".$_SERVER['QUERY_STRING'], array("class"=>"form-horizontal accept-application-form", "role"=>"form", "novalidate"=>""));?>
		<input type="hidden" name="form_submitted" value="1">
		<input type="hidden" name="action" value="resend-verification">
		<input type="hidden" name="id" value="<?=$id?>">
		<button type="submit" class="btn btn-sm btn-default">Re-send Verification E-mail</button>
	</form>
</p>
<?php endif; ?>
<?php if ($show_accept_button): ?>
<p>
	<?=form_open($this->uri->uri_string()."?".$_SERVER['QUERY_STRING'], array("class"=>"form-horizontal accept-application-form", "role"=>"form", "novalidate"=>""));?>
		<input type="hidden" name="form_submitted" value="1">
		<input type="hidden" name="action" value="accept">
		<input type="hidden" name="id" value="<?=$id?>">
		<button type="submit" class="btn btn-sm btn-success">Accept Application</button>
	</form>
</p>
<?php endif; ?>
<p><a href="<?=base_url()?>viewapplications" class="btn btn-sm btn-default">Go Back</a></p>