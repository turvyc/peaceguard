<?php

/* newvolunteer.admin.php

Adds a new volunteer to the database, using information from the HTML form
in admin.php. The volunteer is assigned a random password, and confirmation
of their registration is emailed to them.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

include('../model/constants.model.php');
include('../model/volunteer.model.php');

?>
