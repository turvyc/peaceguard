<?php

/** patrol.control.php


Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/session.model.php');
require_once('../model/constants.model.php');
require_once('../model/patrol.model.php');
require_once('../model/datainterface.model.php');

// If these fail, there is a serious programming error. 
try {
    $session = new Session();
    $interface = new DataInterface($session);
}

catch (LogicException $e) {
    echo $e->getMessage();
    exit(1);
}

if ($interface->getAgent() == _IPHONE) {

    // Check if its (a) starting a patrol, (b) submitting a new, finished
    // patrol, or (c) requesting patrol stats

    exit(0);
}

// It must be the website. Query database and return array of Patrol objects
// according to POST data

exit(0);

?>
