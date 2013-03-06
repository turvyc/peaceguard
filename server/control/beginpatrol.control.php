<?php

/** startpatrol.control.php

Handles a Volunteer starting a patrol. The patrol start time and the Volunteer's
email is sent from the iPhone via POST, 

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
    if (! isset($_POST[_START_TIME])) {
        throw new LogicException('_START_TIME not set in POST.');
    }

    if (! isset($_POST[_EMAIL])) {
        throw new LogicException('_EMAIL not set in POST.');
    }

    // Write the new report, returning the p_id
    $p_id = Patrol::beginPatrol($_POST[_START_TIME], $_POST[_EMAIL]);

    // Output the p_id and we're done!
    $interface->addData(_SUCCESSFUL, _YES);
    $interface->addData(_PATROL, $p_id);
}

catch (Exception $e) {
    $interface->addData(_SUCCESSFUL, _NO);
    $interface->addData(_MESSAGE, $e->getMessage());
}


$interface->output();
exit(0);

?>
