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
include('model/volunteer.model.php');
require_once('model/admin.model.php');
checkLoggedIn($session);

?>

<h1>Administration</h1>

<!-- 
PUT HTML FORMS HERE.
Fields needed: FIRST_NAME, LAST_NAME, EMAIL
-->
<div id="adduser">
	<form>
	 <fieldset>
			<legend>Add Users:</legend>
			Last Name: <input type="text"><br>
			First Name: <input type="text"><br>
			Email: <input type="text"><br>
			<input type="submit" value="Submit">
	 </fieldset>
	</form>
</div>

<div id="adduser">
	<form name="login" action="control/login.control.php" method="POST">
	 <fieldset>
			<legend>Change User's Password:</legend>
			Email: <input type="text"><br>
			Current Password: <input type="text"><br>
			New Password: <input type="text"><br>
			Retype Password: <input type="text"><br>
			<input type="submit" value="Submit">
	 </fieldset>
	</form>
</div>

<?php include('footer.php'); ?>
