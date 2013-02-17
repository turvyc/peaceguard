<?php

/* index.php

The home page of the Website.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

include('header.html');
include('model/session.model.php');
include('model/volunteer.model.php');

$session = new Session();
$volunteer = new Volunteer();

if (! $session->getName()) {
    if (_DEBUG) {
        echo 'NOT LOGGED IN!';
    }
    else {
        header('location:login.php');
    }
}

?>

<p>System status: OFFLINE</p>
<p>Number of registered volunteers: <?php echo $volunteer->getTotalNumber(); ?></p>
<p>Number of currently patrolling volunteers: <?php echo $volunteer->getTotalNumber(true); ?></p>


<?php include('footer.html'); ?>
