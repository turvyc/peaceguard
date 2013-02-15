<?php

/* index.php

The home page of the Website.

*/

include('header.html');
include('model/session.model.php');

$session = new Session();

if (! $session->getName()) {
    if (_DEBUG) {
        echo 'NOT LOGGED IN!';
    }
    else {
        header('location:login.php');
    }
}

?>

<h2>TODO: Add the following features:</h2>
<ul>
    <li>Feature 4.2.3.1: System status (online/offline)</li>
    <li>Feature 4.2.3.2: Number of registered volunteers</li>
    <li>Feature 4.2.3.3: Number of currently patrolling volunteers</li>
</ul>

<?php include('footer.html'); ?>
