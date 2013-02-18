<?php

/** logout.control.php

This page logs a user out of the session, and outputs a nice goodbye message.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/session.model.php');
require_once('../model/datainterface.model.php');

$session = new Session();
$interface = new DataInterface();

$session->logout();

$interface->addData(_SUCCESSFUL, _YES);
$interface->addData(_MESSAGE, 'You have been successfully logged out. Goodbye!');
$interface->output();

exit(0);

?>
