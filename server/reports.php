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

?>

<h1>Incident Reports</h1>


<form name="<?php echo _REPORT; ?>" action="control/report.control.php" method="POST">
	<select name="<?php echo _TIME_PERIOD; ?>">
		<option value="<?php echo _LAST_DAY; ?>">Today's Reports</option>
		<option value="<?php echo _LAST_MONTH; ?>">Last Thirty Days' Reports</option>
		<option value="<?php echo _LAST_YEAR; ?>">Last Year's Reports</option>
		<option value="<?php echo _ALL_TIME; ?>">Year To Date' Reports</option>
	</select>
	
	<select name="<?php echo _ORDER_BY; ?>">
		<option value="<?php echo _TIME; ?>">Sort By Time</option>
		<option value="<?php echo _SEVERITY; ?>">Sort By Severity</option>
		<option value="<?php echo _VOLUNTEER; ?>">Sort By Volunteer</option>
		<option value="<?php echo _TYPE; ?>">Sort By TYPE</option>
	</select>
	<input type="hidden" name="<?php echo _AGENT; ?>" value="<?php echo _WEBSITE; ?>" />
    <input type="submit" value="Submit" />
</form>

<table class="reportTable">
	<tr>
		<th>Time</th>
		<th>Location</th>
		<th>Type</th>
		<th>Severity</th>
		<th>Description</th>
		<th>Volunteer</th>
		<th>Resolved</th>
	</tr>
<?php
	$data = $session->getData();
	for ($i = 0; $i < count($data); $i++) {
		
		$report = $data;
		echo "error starts here";
		
		$time = $report->getTime();
		$location = $report->getLocation();
		$type = $report->getType();
		$severity = $report->getSeverity();
		$description = $report->getDesc();
		$volunteer = $report->getVolunteer();
		$resolved = $report->getResolved();
	
		echo '<tr>';
		echo '<td>' . $time . '</td>';
		echo '<td>' . $location . '</td>';
		echo '<td>' . $type . '</td>';
		echo '<td>' . $severity . '</td>';
		echo '<td>' . $description . '</td>';
		echo '<td>' . $volunteer . '</td>';
		echo '<td>' . $resolved . '</td>';
		echo '</tr>';
	}		 
?>
</table>
