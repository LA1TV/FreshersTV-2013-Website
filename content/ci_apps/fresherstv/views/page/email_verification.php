<?php if ($state === 0): ?>
<h2>E-mail Address Verified</h2>
<?php elseif ($state === 1): ?>
<h2>E-mail Address Already Verified</h2>
<?php else: ?>
<h2 class="text-danger">E-mail Address Could Not Be Verified</h2>
<?php endif; ?>
<?php if ($state === 0 || $state === 1): ?>
<p>Your e-mail address has been verified and your application is now complete.</p>
<p>Your application will now be reviewed and you will receive a further e-mail notifying you when your account has been activiated.</p>
<p>After your account has been activated you will then be able to submit your VT.</p>
<p>Thanks!</p>
<?php else: ?>
<p>The e-mail address could not be verified. Either the link is invalid or you have already submitted an application form.</p>
<p>If you have any problems please send an e-mail to "<a href="mailto:development@la1tv.co.uk" target="_blank">development@la1tv.co.uk</a>" <strong>from the same e-mail address you put on the application form</strong>.</p>
<?php endif; ?>