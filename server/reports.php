<?php

/* reports.php

This page displays incident reports in tabular form according to the Admin's 
input. It also allows the Admin to download the retrieved reports as a CSV file.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

include('header.php');
include('model/report.model.php');
checkLoggedIn($session);

// Try to get the reports retrieved in reports.control.php
try {
    $sessionData = $session->getData();
    $reports = $sessionData[_REPORT];
    $timePeriod = $sessionData[_TIME_PERIOD];
    $orderBy = $sessionData[_ORDER_BY];
    $sessionData = array();
}

// No reports are set. Go get some.
catch (Exception $e) {
    header('location: control/report.control.php');
    exit(0);
}

?>

<h1>Incident Reports</h1>

<form name="<?php echo _REPORT; ?>" action="control/report.control.php" method="POST">
    Time Period:
	<select name="<?php echo _TIME_PERIOD; ?>" id="<?php echo _TIME_PERIOD; ?>">
        <option <?php echo ($timePeriod == _LAST_DAY) ? 'selected' : ''; ?> value="<?php echo _LAST_DAY; ?>">Today</option>
        <option <?php echo ($timePeriod == _LAST_MONTH) ? 'selected' : ''; ?> value="<?php echo _LAST_MONTH; ?>">Last Thirty Days</option>
		<option <?php echo ($timePeriod == _LAST_YEAR) ? 'selected' : ''; ?> value="<?php echo _LAST_YEAR; ?>">Last Year</option> 
        <option <?php echo ($timePeriod == _ALL_TIME) ? 'selected' : ''; ?> value="<?php echo _ALL_TIME; ?>">All Time</option>
	</select>	
	
    Sort By:
	<select name="<?php echo _ORDER_BY; ?>">
        <option <?php echo ($orderBy == _TIME) ? 'selected' : ''; ?> value="<?php echo _TIME; ?>">Time</option>
        <option <?php echo ($orderBy == _SEVERITY) ? 'selected' : ''; ?> value="<?php echo _SEVERITY; ?>">Severity</option>
        <option <?php echo ($orderBy == _VOLUNTEER) ? 'selected' : ''; ?> value="<?php echo _VOLUNTEER; ?>">Volunteer</option>
        <option <?php echo ($orderBy == _TYPE) ? 'selected' : ''; ?> value="<?php echo _TYPE; ?>">Type</option>
        <option <?php echo ($orderBy == _LOCATION) ? 'selected' : ''; ?> value="<?php echo _LOCATION; ?>">Location</option>
	</select>
	<input type="hidden" name="<?php echo _AGENT; ?>" value="<?php echo _WEBSITE; ?>" />
    <input type="submit" value="Submit" />
</form>

<a href='csv/reports.csv.php'>Download as CSV</a>

<table class="reportTable">
	<tr>
		<th>Date</th>
		<th>Time</th>
		<th>Location</th>
		<th>Type</th>
		<th>Severity</th>
		<th>Description</th>
		<th>Volunteer</th>
		<th>Resolved</th>
	</tr>

    <?php
    for ($i = 0; $i < count($reports); $i++) {

        $report = new Report($reports[$i]);

        // Add the report to the session to simplify CSV download
        $sessionData[] = $report;

        echo '<tr>';
            echo '<td>' . $report->getDate() . '</td>';
            echo '<td>' . $report->getTime() . '</td>';
            echo '<td>' . $report->getLocation() . '</td>';
            echo '<td>' . $report->getType() . '</td>';
            echo '<td>' . $report->getSeverity() . '</td>';
            echo '<td>' . $report->getDesc() . '</td>';
            echo '<td>' . $report->getVolunteer() . '</td>';
            echo '<td>' . $report->getResolved() . '</td>';
            echo '</tr>';
    }		 
    ?>

</table>

<?php

$session->setData($sessionData);
include('footer.php');

?>
