<?php

/** login.php

This script is the target of a HTTP POST request, and outputs a JSON array, 
or sets the $_SESSION variable, with the structure { _SUCCESSFUL: boolean, _MESSAGE: string }.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/session.model.php');
require_once('../model/constants.model.php');
require_once('../model/datainterface.model.php');

$session = new Session();
$interface = new DataInterface();

try {
    $session->login($_POST[_EMAIL], $_POST[_PASSWORD]);
}

// If there was no match . . . 
catch (Exception $e) {
    $interface->addData(_SUCCESSFUL, _NO);
    $interface->addData(_MESSAGE, $e->getMessage());
    $interface->setHeader('login.php');
    $interface->output();
}

// If we made it this far, we should be logged in. This is getting tossed in 
// until I can write some unit tests.
if (_DEBUG) {
    assert($session->getFullName() != null);
}

$interface->addData(_SUCCESSFUL, _YES);
$interface->setHeader('index.php');

// Output the data and we're done!
$interface->output();

?>
