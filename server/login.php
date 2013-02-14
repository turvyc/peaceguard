<?php include('header.html'); ?>

<form name="login" action="control/login.control.php" method="POST">
    USERNAME: <input type="text" name="<?php echo _USERNAME; ?>" > <br />
    PASSWORD: <input type="password" name="<?php echo _PASSWORD; ?>" > <br />
    <input type="hidden" name="<?php echo _AGENT; ?>"
    <input type="submit" value="Login">
</form>

<?php

include('footer.html');

?>
