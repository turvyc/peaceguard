<?php

/** login.php

This script is the target of a HTTP POST request, and outputs a JSON array, 
or sets the $_SESSION variable, with the structure { _SUCCESSFUL: boolean, _MESSAGE: string }.

Contributor(s): Colin Strong

*/

require_once('../model/session.model.php');
require_once('../model/constants.model.php');
require_once('../model/datainterface.model.php');

$session = new Session();
$interface = new DataInterface();

try {
    $session->login($_POST[_USERNAME], $_POST[_PASSWORD]);
}

// If there is a database error . . .
catch (PDOException $e) {
    $interface->add(_SUCCESSFUL, false);
    $interface->add(_MESSAGE, 'Database error!');
    exit(0);
}

// If there was no match . . . 
catch (Exception $e) {
    $interface->add(_SUCCESSFUL, false);
    $interface->add(_MESSAGE, $e->getMessage());
    exit(0);
}

// If we made it this far, we should be logged in. This is getting tossed in 
// until I can write some unit tests.
if (_DEBUG) {
    assert($session->getUsername() != null);
}

$interface->add(_SUCCESSFUL, true);
$interface->add(_MESSAGE, "Thanks for logging in, $session->getUsername()!");

// Output the data and we're done!
$interface->output();
exit(0);

?>
