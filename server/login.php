<?php include('header.html'); ?>

<form name="login" action="control/login.control.php" method="POST">
    USERNAME: <input type="text" name="username" > <br />
    PASSWORD: <input type="password" name="password" > <br />
    <input type="submit" value="Login">
</form>

<?php

include('footer.html');

?>
