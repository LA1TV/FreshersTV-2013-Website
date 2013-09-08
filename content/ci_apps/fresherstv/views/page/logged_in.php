<h2>You Are Logged In</h2>
<?php if (!$already_logged_in): ?>
<p>You are now logged in.</p>
<?php else: ?>
<p>You were already logged in.</p>
<?php endif; ?>
<?php if ($next_uri !== FALSE): ?>
<p><a class="btn btn-primary btn-sm" href="<?=base_url().$next_uri?>">Click Here To Continue To The Page You Requested</a></p>
<?php endif; ?>