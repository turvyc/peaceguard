<?php

/* reports.csv.php

Creates a CSV file of incident reports for download.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/session.model.php');
require_once('../model/constants.model.php');
require_once('../model/report.model.php');

$session = new Session();

$sessionData = $session->getData();

$filename = date('j-M-Y') . '_incident-reports.csv';


header('Content-Description: File Transfer');
header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=$filename");

// Create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Output the column headings
fputcsv($output, array('Date', 'Time', 'Location', 'Type', 'Severity', 'Description', 'Volunteer', 'Resolved'));

foreach ($sessionData as $report) {
    $data = array($report->getDate(), $report->getTime(), $report->getLocation(), 
    $report->getType(), $report->getSeverity(), $report->getDesc(), 
    $report->getVolunteer(), $report->getResolved());
    fputcsv($output, $data);
}

exit(0);

?>
