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
    $interface = new DataInterface($session);
}

catch (LogicException $e) {
    echo $e->getMessage();
    exit(1);
}

if ($interface->getAgent() == _IPHONE) {
    try {
        // Ensure that the required POST keys are set
        if (! isset($_POST[_EMAIL]) || ! isset($_POST[_TIME_PERIOD])) {
            throw new LogicException('_TIME_PERIOD or _EMAIL not set.');
        }

        $stats = Patrol::getVolunteerStatistics($_POST[_EMAIL], $_POST[_TIME_PERIOD]);

        $interface->addData(_SUCCESSFUL, _YES);
        $interface->addData(_TOTAL, $stats[_TOTAL]);
        $interface->addData(_AVERAGE, $stats[_AVERAGE]);
    }

    catch (LogicException $e) {
        $interface->addData(_SUCCESSFUL, _NO);
        $interface->addData(_MESSAGE, $e->getMessage());
    }
}

// It's the website!
else {
    // Make sure the required POST keys are set, and set it to the default if not
    if (! isset($_POST[_TIME_PERIOD])) {
        $_POST[_TIME_PERIOD] = _ALL_TIME;
    }

    $stats = Patrol::getGlobalStatistics($_POST[_TIME_PERIOD]);
    $interface->addData(_TOTAL, $stats[_TOTAL]);
    $interface->addData(_AVERAGE, $stats[_AVERAGE]);
    $interface->addData(_TIME_PERIOD, $_POST[_TIME_PERIOD]);

    header('location: ../statistics.php');
}

$interface->output();
exit(0);

?>
