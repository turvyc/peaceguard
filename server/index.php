<?php

/* index.php

The home page of the Website.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('model/volunteer.model.php');
include('header.php');

checkLoggedIn($session);

?>

<h1>PeaceGuard Home Page</h1>

<p>System status: OFFLINE</p>
<p>Number of registered volunteers: <?php echo Volunteer::getTotalNumber(); ?></p>
<p>Number of currently patrolling volunteers: <?php echo Volunteer::getTotalNumber(true); ?></p>


<?php include('footer.php'); ?>
