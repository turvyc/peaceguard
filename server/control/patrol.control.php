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
    try {
        if (! isset($_POST[_EMAIL])) {
            throw new LogicException('Email is not set in POST.');
        }

        require('../model/database.model.php');

        // Handle adding a new patrol (whether just begun or completed)
        elseif (isset($_POST[_PATROL])) {
            Patrol::newPatrol($_POST[_PATROL], $_POST[_EMAIL]);
        }
    }
    exit(0);
}

// It must be the website. Query database and return array of Patrol objects
// according to POST data

exit(0);

?>
