<?php $this->load->helper('security'); ?>
<h2>To '<?=htmlent($name);?>',</h2>
<p>We have received your station application form for FreshersTV.</p>
<p>Please click on the verification link below to verify youe e-mail address and complete the process.</p>
<p><strong>Verification link:</strong> <a href="<?=htmlent($link)?>"><?=htmlent($link)?></a></p>
<p>If you didn't sign up for for FreshersTV please ignore this e-mail and don't click on the link.</p>
<p>Thanks.</p>