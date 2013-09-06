<?php
$this->load->helper("security");
?>
<h2>Password Reset Link Sent</h2>
<p>A link to reset your password has been sent to "<?=htmlent($email)?>" and should arrive shortly containing a link which you will need to click to set a new password.</p>
<p>If this e-mail doesn't arrive in the next few minutes please check your junk folder. It is being sent from an automated address "<?=htmlent($from_email)?>".</p>
<p>If you have any problems please send an e-mail to "<a href="mailto:development@la1tv.co.uk" target="_blank">development@la1tv.co.uk</a>" <strong>from the same e-mail address you put on the application form</strong>.</p>