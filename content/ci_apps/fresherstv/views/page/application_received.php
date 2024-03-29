<?php
$this->load->helper("security");
?>
<h2>Application Sent</h2>
<p>Your application has been sent and you should receive an e-mail at "<?=htmlent($email)?>" shortly containing a link which you will need to click to verify your e-mail address and complete the process.</p>
<p>If this e-mail doesn't arrive in the next few minutes please check your junk folder. It is being sent from an automated address "<?=htmlent($from_email)?>".</p>
<p><strong>Your application is not complete until you have verified your e-mail address.</strong></p>
<p>If you have any problems please send an e-mail to "<a href="mailto:development@la1tv.co.uk">development@la1tv.co.uk</a>" <strong>from the same e-mail address you put on the application form</strong>.</p>
<p>Thanks!</p>