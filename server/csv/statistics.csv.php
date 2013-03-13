<?php

/* statistics.csv.php

Creates a CSV file of patrol statistics for download.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/session.model.php');
require_once('../model/constants.model.php');

$session = new Session();

$sessionData = $session->getData();

$filename = date('j-M-Y') . '_patrol_stats.csv';

header('Content-Description: File Transfer');
header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=$filename");

// Create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Output the column headings
fputcsv($output, array('Start Time', 'End Time', 'Total Patrols',
'Total Distance', 'Total Time', 'Total Reports', 'Average Patrols',
'Average Distance', 'Average Time', 'Average Reports'));

$startTime = decodeTimePeriod($sessionData[_TIME_PERIOD]);
$endTime = time();

$totals = $sessionData[_TOTAL];
$averages = $sessionData[_AVERAGE];

fputcsv($output, array($startTime, $endTime, $totals[_PATROL], 
$totals[_DISTANCE], $totals[_TIME], $totals[_REPORT], $averages[_PATROL], 
$averages[_DISTANCE], $averages[_TIME], $averages[_REPORT]));

exit(0);

?>
