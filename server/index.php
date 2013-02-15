<?php

/* index.php

The home page of the Website.

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

<h2>System status: OFFLINE</h2>
<h2>Number of registered volunteers: <?php echo $volunteer->getTotalNumber(); ?></h2>
<h2>Number of currently patrolling volunteers: <?php echo $volunteer->getTotalNumber(true); ?></h2>


<?php include('footer.html'); ?>
