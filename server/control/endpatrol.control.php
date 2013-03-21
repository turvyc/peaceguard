<?php

/** endpatrol.control.php

Handles ending a patrol. The patrol ID, end time, route, and distance are sent
from the iPhone via POST, and are entered into the database.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/constants.model.php');
require_once('../model/patrol.model.php');
require_once('../model/datainterface.model.php');
require_once('../model/session.model.php');

try {
    $session = new Session;
    $interface = new DataInterface($session);

    // Make sure we have the required info
    $required = array(_PATROL, _DURATION, _ROUTE, _DISTANCE);
    foreach ($required as $key) {
        if (! isset($_POST[$key])) {
            throw new LogicException($key . ' not set in POST.');
        }
    }

    // Write the patrol to the database
    Patrol::endPatrol($_POST[_PATROL], $_POST[_DURATION],
    $_POST[_ROUTE], $_POST[_DISTANCE]);

    // Check if any new badges were earned
    
    $interface->addData(_SUCCESSFUL, _YES);
}

catch (Exception $e) {
    $interface->addData(_SUCCESSFUL, _NO);
    $interface->addData(_MESSAGE, $e->getMessage());
}

$interface->output();
exit(0);

?>
