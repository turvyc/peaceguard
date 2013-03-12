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
        // Ensure that the EMAIL variable is set
        if (! isset($_POST[_EMAIL])) {
            throw new DomainException('_EMAIL is not set.');
        }

        // Ensure that there is report data
        if (! isset($_POST[_TYPE]) || ! isset($_POST[_SEVERITY])
        || ! isset($_POST[_LOCATION]) || ! isset($_POST[_TIME]) 
        || ! isset($_POST[_DESC])) {
            throw new DomainException('Missing report data in POST.');
        }

        $report = array(_TYPE => $_POST[_TYPE], 
        _SEVERITY => $_POST[_SEVERITY],
        _LOCATION => $_POST[_LOCATION],
        _TIME => $_POST[_TIME],
        _DESC => $_POST[_DESC]);

        // Create a new Report object from the data
        Report::newReport($report, $_POST[_EMAIL]);

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
    // Ensure that _TIME_PERIOD and _ORDER_BY are set
    if (! isset($_POST[_TIME_PERIOD])) {
        throw new LogicException('_TIME_PERIOD is not set.');
    }

    if (! isset($_POST[_ORDER_BY])) {
        throw new LogicException('_ORDER_BY is not set.');
    }

    // Ensure that _TIME_PERIOD and _ORDER_BY have sane values
    $allowedTimePeriods = array(_LAST_DAY, _LAST_MONTH, _LAST_YEAR, _ALL_TIME);
    $allowedSorts = array(_TIME, _SEVERITY, _VOLUNTEER, _TYPE, _LOCATION);

    if (! in_array($_POST[_TIME_PERIOD], $allowedTimePeriods)) {
        throw new OutOfBoundsException('Illegal value for _TIME_PERIOD');
    }

    if (! in_array($_POST[_ORDER_BY], $allowedSorts)) {
        throw new OutOfBoundsException('Illegal value for _ORDER_BY');
    }
	
    // Defined in constants.model.php
    $since = decodeTimePeriod($_POST[_TIME_PERIOD]);

    // Query the database
    require('../model/database.model.php');
	
    $query = ("SELECT r_id, resolved, time, location, type, severity, description, u_id, firstName
    FROM Reports NATURAL JOIN Reported NATURAL JOIN Users WHERE time > $since ORDER BY {$_POST[_ORDER_BY]}");

    $STH = $DBH->prepare($query);
    $STH->execute();

    $allReportData = $STH->fetchAll();
    $allReportData[_TIME_PERIOD] = $_POST[_TIME_PERIOD];
    $allReportData[_ORDER_BY] = $_POST[_ORDER_BY];
    $session->setData($allReportData);

    header('location: ../reports.php');
    exit(0);

}

catch (Exception $e) {
    if (_DEBUG) {
		echo $e;
		exit(1);
	}
}

?>
