<?php 

/* login.php

The login page. Unless they are already logged in, users will be automatically
redirected to this page if they try to access any other page of the Website.

*/

include('header.html');
include('model/constants.model.php');

?>

<form name="login" action="control/login.control.php" method="POST">
    Username: <input type="text" name="<?php echo _USERNAME; ?>" /> <br />
    Password: <input type="password" name="<?php echo _PASSWORD; ?>" /> <br />
    <input type="hidden" name="<?php echo _AGENT; ?>" value="<?php echo _WEBSITE; ?>" />
    <input type="submit" value="Login" />
</form>

<?php include('footer.html'); ?>
