<?php include('header.html'); ?>

<form action="control/login.control.php" method="POST">
    USERNAME: <input type="text" name="username" >
    <br />
    PASSWORD: <input type="password" name="password" >
    <br />
    <input type="button" value="Login" onClick="Login(this.form);" >
</form>

<?php

include('footer.html');

?>
