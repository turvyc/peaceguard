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
        // Ensure that the USERNAME variable is set
        if (! isset($_POST[_USERNAME])) {
            throw new DomainException('_USERNAME is not set.');
        }

        // Ensure that there is report data
        if (! isset($_POST[_REPORT])) {
            throw new DomainException('No report data is set in POST.');
        }

        // Create a new Report object from the data
        Report::newReport($_POST[_REPORT], $_POST[_USERNAME]);

        $interface->addData(_SUCCESSFUL, _YES);
    }

    catch (Exception $e) {
        $interface->addData(_SUCCESSFUL, _NO);
        $interface->addData(_MESSAGE, $e->getMessage());
    }

    $interface->output();
    exit(0);
}

// Handle website requests -- query the database and create Report
// objects for the retrieved rows, and store them in an array
try {
    // Ensure that _TIME_PERIOD and _SORT_BY are set
    if (! isset($_POST[_TIME_PERIOD])) {
        throw new LogicException('_TIME_PERIOD is not set.');
    }

    if (! isset($_POST[_SORT_BY])) {
        throw new LogicException('_SORT_BY is not set.');
    }

    // Ensure that _TIME_PERIOD and _SORT_BY have sane values
    $allowedTimePeriods = array(_LAST_DAY, _LAST_MONTH, _LAST_YEAR, _ALL_TIME);
    $allowedSorts = array(_DATE, _TIME, _SEVERITY, _VOLUNTEER);

    if (! in_array($_POST[_TIME_PERIOD], $allowedTimePeriods)) {
        throw new OutOfBoundsException('Illegal value for _TIME_PERIOD');
    }

    if (! in_array($_POST[_SORT_BY], $allowedSorts)) {
        throw new OutOfBoundsException('Illegal value for _SORT_BY');
    }

    // Find the minimum timestamp of reports within the specified time
    switch ($_POST[_TIME_PERIOD]) {
        case _LAST_DAY:
            $since = strtotime('-1 day');
            break;
        case _LAST_MONTH:
            $since = strtotime('-1 month');
            break;
        case _LAST_YEAR:
            $since = strtotime('-1 year');
            break;
        case _ALL_TIME:
            $since = 0;
            break;
    }

    // Get the SQL SORT BY string
    $sortby = 'R.' . $_POST[_SORT_BY];
    if ($_POST[_SORT_BY] == _VOLUNTEER) {
        $sortby = 'R.' . _VOLUNTEER;
    }

    // Query the database
    require('../model/database.model.php');

    $query = ('SELECT R.time, R.location, R.type, R.severity, R.desc, V.v_id, V.firstName
    FROM Reports R, Volunteers V WHERE R.time > ? SORT BY ?');

    $STH = $DBH->prepare($query);
    $STH->execute(array($since, $sortby));

    $allReportData = $STH->fetchAll();
    print_r($allReportData);
}

catch (Exception $e) {
    // TODO
}
?>
