<?php

/** getbadges.control.php

Outputs to the iPhone the list of badges earned by the specified Volunteer.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/constants.model.php');
require_once('../model/volunteer.model.php');
require_once('../model/datainterface.model.php');
require_once('../model/session.model.php');

try {
    $session = new Session();
    $interface = new DataInterface($session);
}

catch (LogicException $e) {
    echo (_DEBUG) ? $e : $e->getMessage();
    exit(1);
}

try {
    if (! isset($_POST[_EMAIL])) {
        throw new LogicException('EMAIL not set in POST.');
    }

    $volunteer = Volunteer::constructFromEmail($email);
    $badges = $volunteer->getBadges();

    $interface->addData(_SUCCESSFUL, _YES);
    $interface->addData(_BADGES, $badges);
}

catch (Exception $e) {
    $interface->addData(_SUCCESSFUL, _NO);
    $interface->addData(_MESSAGE, $e->getMessage());
}

$interface->output();
exit(0);

?>
