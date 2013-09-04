<h2>You Are Logged Out</h2>
<?php if (!$already_logged_out): ?>
<p>You are logged out.</p>
<?php else: ?>
<p>You were already logged out.</p>
<?php endif; ?>
<p><a class="btn btn-default" href="<?=base_url();?>login">Click Here To Log In Again</a></p>