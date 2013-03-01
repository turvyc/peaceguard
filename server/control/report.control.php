<?php

/** report.control.php

This control script does two tasks, depending on the agent making the request.

If the agent is the iPhone, a new incident report is written to the database
using the information provided in the POST variable, and a success or failure
message is sent to the iPhone.

If the agent is the Website, the script selects from the database all reports
conforming to the parameters set in the POST variable, then creates an array
of Report objects from this information and stores it in the SESSION variable.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/session.model.php');
require_once('../model/constants.model.php');
require_once('../model/report.model.php');
require_once('../model/datainterface.model.php');

$session = new Session();
$interface = new DataInterface($session);

try {
    // Ensure that the USERNAME variable is set
    if (! isset($_POST[_USERNAME])) {
        throw new Exception('_USERNAME is not set.');
    }

    // Ensure that there is report data
    if (! isset($_POST(_REPORT))) {
        throw new Exception('No report data is set in POST.');
    }
}



?>
