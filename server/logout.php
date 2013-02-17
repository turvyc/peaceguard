<?php

/** logout.php

This page logs a user out of the session, and displays a nice goodbye message.

Contributor(s): Colin Strong

*/

require_once('model/session.model.php');

$session = new Session();

if (! $session->getName()) {
    if (_DEBUG) {
        echo 'NOT LOGGED IN!';
    }
    else {
        header('location:login.php');
    }
}

$session->logout();

include ('header.html');
?>

<p>You have been successfully logged out. Goodbye!</p>

<?php include('footer.html'); ?>
