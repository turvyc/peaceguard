<?php

/** patrol.control.php

Returns patrol statistics depending on the user agent.

For the iPhone, the Volunteer's email will be supplied in the POST data, and
that Volunteer's statistics will be returned as a JSON array.

For the Websited, the time period and sorting column will be supplied in the
POST data, and the corresponding table will be returned in the form of a 
two-dimensional associative array.

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

        // TODO: SQL query getting appropriate stats

        $interface->addData(_SUCCESSFUL, _YES);

        // TODO: Create appropriate JSON array for output
    }

    catch (Exception $e) {
        $interface->addData(_SUCCESSFUL, _NO);
        $interface->addData(_MESSAGE, $e->getMessage());
    }
}

// It's the website . . .
else {

    // TODO: All the things
}

$interface->output();
exit(0);

?>
