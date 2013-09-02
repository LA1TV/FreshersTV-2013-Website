<?php $this->load->helper('security'); ?>
<h2>To '<?=htmlent($name);?>',</h2>
<p>You requested a password reset for your FreshersTV account. Please follow the link below to change your password.</p>
<p><strong>Password reset link:</strong> <a href="<?=htmlent($link)?>"><?=htmlent($link)?></a></p>
<p>If you didn't make this request then please ignore this e-mail.</p>
<p>Thanks.</p>
<hr>
<small>This is an automated e-mail. Please do not reply to this address.</small>