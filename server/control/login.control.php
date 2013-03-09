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

// If these fail, there is a serious programming error. 
try {
    $session = new Session();
    $interface = new DataInterface($session);
}

catch (Exception $e) {
    echo $e;
    exit(1);
}

// Try to login
try {
    $session->login($_POST[_EMAIL], $_POST[_PASSWORD], $interface->getAgent());
}

// If there was an error or if there was no match, output 'not successful' and
// the error message.
catch (Exception $e) {
    $interface->addData(_SUCCESSFUL, _NO);
    $interface->addData(_MESSAGE, $e->getMessage());
    $interface->output();

    if ($interface->getAgent() == _WEBSITE) {
        header('location: ../login.php');
    }

    exit(0);
}

// If we made it this far, we should be logged in. This is getting tossed in 
// until I can write some unit tests.
if (_DEBUG) {
    assert($session->getFullName() != null);
}

$interface->addData(_SUCCESSFUL, _YES);
$interface->output();

// Hack alert: the iPhone will never actually be logged in to the website in
// a session; we simply want to verify their credentials
if ($interface->getAgent() == _IPHONE) {
    $session->logout();
}

else {
    header('location: ../index.php');
}

exit(0)

?>
