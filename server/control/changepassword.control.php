<?php

/** changepassword.control.php

Handles changing a user's password.

Contributors(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/constants.model.php');
require_once('../model/session.model.php');
require_once('../model/datainterface.model.php');

try {
    $session = new Session();
    $interface = new DataInterface($session);
}

catch (LogicException $e) {
    echo (_DEBUG) ? $e : $e->getMessage();
    exit(1);
}

if ($interface->getAgent() == _WEBSITE) {

    try {
        //Make sure the POST values are acceptable.
        if (! isset($_POST[_PASSWORD]) || ! isset($_POST[_NEW_PASSWORD])
        || ! isset($_POST[_REPEAT])) {
            throw new RuntimeException('Empty fields in form.');
        }

        if ($_POST[_NEW_PASSWORD] != $_POST[_REPEAT]) {
            throw new RuntimeException('Passwords do not match.');
        }

        $admin = $session->getAdmin();

        $admin->changePassword($_POST[_PASSWORD], $_POST[_NEW_PASSWORD]);

        $interface->addData(_SUCCESSFUL, _YES);
        $interface->addData(_MESSAGE, 'Password successfully updated.');
    }

    catch (RuntimeException $e) {
        $interface->addData(_SUCCESSFUL, _NO);
        $interface->addData(_MESSAGE, $e->getMessage());
    }

    header('location: ../admin.php');
}

$interface->output();
exit(0);

?>
