<?php

/** patrol.control.php

This script retrieves patrol statistics according to the POST parameters
_ORDER_BY and _TIME_PERIOD, stores them in the session DATA variable, and
directs the user back to the patrol page.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/session.model.php');
require_once('../model/datainterface.model.php');
require_once('../model/constants.model.php');
require_once('../model/patrol.model.php');

try {
    $session = new Session();
    $interface = new DataInterface();
}

catch (LogicException $e) {
    echo $e->getMessage();
    exit(1);
}

if ($interface->getAgent() == _IPHONE) {
    // Ensure that the required POST keys are set
    if (! isset($_POST[_TIME_PERIOD]) || ! isset($_POST[_EMAIL])) {
        throw new LogicException('_TIME_PERIOD or _EMAIL not set.');
    }

    
}

// It's the website!
else {
    // Make sure the required POST keys are set
    if (! isset($_POST[_TIME_PERIOD]) || ! isset($_POST[_ORDER_BY])) {
        throw new LogicException('_TIME_PERIOD or _ORDER_BY not set.');
    }

    $stats = Patrol::getGlobalStatistics($_POST[_TIME_PERIOD], $_POST[_ORDER_BY]);
    $interface->addData($stats);

    header('location: ../patrol.php');
}

$interface->output();
exit(0);

?>
