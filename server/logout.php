<?php

/** logout.php

This page logs a user out of the session, and displays a nice goodbye message.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

include('header.php');

$session->logout();
checkLoggedIn($session);

?>

<h1>You have been successfully logged out. Goodbye!</h1>

<?php include('footer.php'); ?>
