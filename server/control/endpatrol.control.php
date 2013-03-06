<?php

/** endpatrol.control.php

Handles a Volunteer ending a patrol. The patrol with the p_id supplied by the
Volunteer is updated with the end time, route, and location of the patrol.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/constants.model.php');
require_once('../model/patrol.model.php');
require_once('../model/datainterface.model.php');

try {
    $interface = new DataInterface($session);

    // Make sure we have the required info
    $required = array(_PATROL, _END_TIME, _ROUTE, _DISTANCE);
    foreach ($required as $key) {
        if (! isset($_POST[$key])) {
            throw new LogicException($key . ' not set in POST.');
        }
    }

    // Write the patrol to the database
    Patrol::endPatrol($_POST[_PATROL], $_POST[_END_TIME],
    $_POST[_ROUTE], $_POST[_DISTANCE]);
}

catch (LogicException $e) {
    echo $e->getMessage();
    exit(1);
}
