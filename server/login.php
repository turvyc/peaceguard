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
    $data = $session->getJsonData();
    $errorMessage = $data[_MESSAGE];
    $session->clearData();
}
catch (Exception $e) {
    $errorMessage = '';
}

?>

<div id="errorMessage">
    <p id="errorMessage"><?php echo $errorMessage; ?></p>
</div>

<form class="defaultForm" name="login" action="control/login.control.php" method="POST">
    E-mail: <input class="defaultForm" type="text" tabindex="1" name="<?php echo _EMAIL; ?>" /> <br />
    Password: <input class="defaultForm" type="password" tabindex="2" name="<?php echo _PASSWORD; ?>" /> <br />
    <input class="defaultForm" type="hidden" name="<?php echo _AGENT; ?>" value="<?php echo _WEBSITE; ?>" />
    <input class="defaultForm" type="submit" value="Login" tabindex="3" />
</form>

<?php include('footer.html'); ?>
