<?php 

/* login.php

The login page. Unless they are already logged in, users will be automatically
redirected to this page if they try to access any other page of the Website.

*/

include('header.html');
include('model/constants.model.php');
include('model/session.model.php');

$session = new Session();

// Look for an error message from a previous login attempt
try {
    $data = $session->getData();
    if (_DEBUG) { assert(! $data[_SUCCESSFUL]); } // We should never get here with _SUCCESSFUL == true
    $errorMessage = $data[_MESSAGE];
    $session->clearData();
}
catch (Exception $e) {
    $errorMessage = '';
}

?>

<div class="errorMessage">
    <p class="errorMessage"><?php echo $errorMessage; ?></p>
</div>

<form name="login" action="control/login.control.php" method="POST">
    Username: <input type="text" name="<?php echo _USERNAME; ?>" /> <br />
    Password: <input type="password" name="<?php echo _PASSWORD; ?>" /> <br />
    <input type="hidden" name="<?php echo _AGENT; ?>" value="<?php echo _WEBSITE; ?>" />
    <input type="submit" value="Login" />
</form>

<?php include('footer.html'); ?>
