<?php include('header.html'); ?>
<?php include('model/constants.model.php'); ?>

<form name="login" action="control/login.control.php" method="POST">
    USERNAME: <input type="text" name="<?php echo _USERNAME; ?>" /> <br />
    PASSWORD: <input type="password" name="<?php echo _PASSWORD; ?>" /> <br />
    <input type="hidden" name="<?php echo _AGENT; ?>" value="<?php echo _WEBSITE; ?>" />
    <input type="submit" value="Login" />
</form>

<?php include('footer.html'); ?>
