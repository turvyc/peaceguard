<?php 

/* login.php

The login page. Unless they are already logged in, users will be automatically
redirected to this page if they try to access any other page of the Website.

*/

include('header.php');
require_once('model/constants.model.php');

// Look for an error message from a previous login attempt
try {
    $data = $session->getData();
    $errorMessage = $data[_MESSAGE];
    $session->clearData();
}
catch (Exception $e) {
    $errorMessage = '';
}

?>

<h1>PeaceGuard Login</h1>

<div id="errorMessage">
    <h3><?php echo $errorMessage; ?></h3>
</div>

<div id="login">
	<form name="login" action="control/login.control.php" method="POST">
		<label for="<?php echo _EMAIL; ?>">E-mail:</label><br />
		<input type="text" tabindex="1" name="<?php echo _EMAIL; ?>" /> <br /><br />
		<label for="<?php echo _PASSWORD; ?>">Password:</label><br />
		<input type="password" tabindex="2" name="<?php echo _PASSWORD; ?>" /> <br /><br />
		<input type="hidden" name="<?php echo _AGENT; ?>" value="<?php echo _WEBSITE; ?>" />
		<input type="submit" value="Login" tabindex="3" />
	</form>
	
</div>

<?php include('footer.php'); ?>
