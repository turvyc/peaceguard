<?php

/* admin.php

This page is the administrative panel for the PeaceGuard website. It allows 
Admins to change their password add or delete Volunteers.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

include('header.php');
require_once('model/volunteer.model.php');
require_once('model/session.model.php');
require_once('model/admin.model.php');

$session = new Session();
checkLoggedIn($session);

// Look for a message from a previous form action
try {
    $data = $session->getData();
    $message = $data[_MESSAGE];
    $session->clearData();
}
catch (Exception $e) {
    $message = '';
}

?>

<h1>Administration</h1>

<div id="errorMessage">
    <h3><?php echo $message; ?></h3>
</div>

<div id="adduser">
	<form name="admin" action="control/newvolunteer.control.php" method="POST">
		<fieldset>
				<legend>Add Users:</legend>
				<label for="<?php echo _FIRST_NAME; ?>">First Name:</label>
                <input type="text" tabindex="1" name="<?php echo _FIRST_NAME; ?>" /> <br /><br />
				<label for="<?php echo _LAST_NAME; ?>">Last Name:</label>
                <input type="text" tabindex="2" name="<?php echo _LAST_NAME; ?>" /> <br /><br />
				<label for="<?php echo _EMAIL; ?>">Email:</label>
				<input type="text" tabindex="3" name="<?php echo _EMAIL; ?>" /> <br /><br /><br /><br />
				<input type="hidden" name="<?php echo _AGENT; ?>" value="<?php echo _WEBSITE; ?>" />
				<input type="submit" value="Submit" tabindex="4" />	
		</fieldset>
	</form>
</div>
<div id="changepw">
	<form name="admin" action="control/changepassword.control.php" method="POST">
		<fieldset>
				<legend>Change User's Password:</legend>	
				<label for="<?php echo _EMAIL; ?>">Email:</label>
				<input type="text" tabindex="5" name="<?php echo _EMAIL; ?>" /> <br /><br />
				<label for="<?php echo _PASSWORD; ?>">Current Password:</label>
				<input type="password" tabindex="6" name="<?php echo _PASSWORD; ?>" /> <br /><br />
				<label for="<?php echo _NEW_PASSWORD; ?>">New Password:</label>
                <input type="password" tabindex="7" name="<?php echo _NEW_PASSWORD; ?>" /> <br /><br />
				<label for="<?php echo _REPEAT; ?>">Repeat Password:</label>
				<input type="password" tabindex="8" name="<?php echo _REPEAT; ?>" /> <br /><br />
				<input type="hidden" name="<?php echo _AGENT; ?>" value="<?php echo _WEBSITE; ?>" />
				<input type="submit" value="Submit" tabindex="9" />
		</fieldset>
	</form>
</div>



<?php include('footer.php'); ?>
