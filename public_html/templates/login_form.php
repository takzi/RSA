<link href="<?php echo $path_to_root; ?>css/login.css" rel="stylesheet">
<div class="form_header clearfix">
		<h1>RSA Login</h1>
	</div>
<form id="login_form" method="POST">
	<input type="text" placeholder="email" name="email" required>
	<br><br>
	<input type="password" placeholder="password" name="password" required>
	<br><br>
	<button type="submit">Login</button>
	<a id="request_href" href="request_account.php">Request Account</a>
</form>