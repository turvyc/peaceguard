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
include('model/admin.model.php');
checkLoggedIn($session);

?>

<h1>Administration</h1>

<!-- 
PUT HTML FORMS HERE.
Fields needed: FIRST_NAME, LAST_NAME, EMAIL
-->

<?php include('footer.php'); ?>
