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

$data = $session->getData();

?>

<h1>Incident Reports</h1>

<form name="<?php echo _REPORT; ?>" action="control/report.control.php" method="POST">
    Time Period:
	<select name="<?php echo _TIME_PERIOD; ?>" id="<?php echo _TIME_PERIOD; ?>">
        <option <?php echo ($data[_TIME_PERIOD] == _LAST_DAY) ? 'selected' : ''; ?> value="<?php echo _LAST_DAY; ?>">Today</option>
        <option <?php echo ($data[_TIME_PERIOD] == _LAST_MONTH) ? 'selected' : ''; ?> value="<?php echo _LAST_MONTH; ?>">Last Thirty Days</option>
		<option <?php echo ($data[_TIME_PERIOD] == _LAST_YEAR) ? 'selected' : ''; ?> value="<?php echo _LAST_YEAR; ?>">Last Year</option>
        <option <?php echo ($data[_TIME_PERIOD] == _ALL_TIME) ? 'selected' : ''; ?> value="<?php echo _ALL_TIME; ?>">All Time</option>
	</select>	
	
    Sort By:
	<select name="<?php echo _ORDER_BY; ?>">
        <option <?php echo ($data[_ORDER_BY] == _TIME) ? 'selected' : ''; ?> value="<?php echo _TIME; ?>">Time</option>
        <option <?php echo ($data[_ORDER_BY] == _SEVERITY) ? 'selected' : ''; ?> value="<?php echo _SEVERITY; ?>">Severity</option>
        <option <?php echo ($data[_ORDER_BY] == _VOLUNTEER) ? 'selected' : ''; ?> value="<?php echo _VOLUNTEER; ?>">Volunteer</option>
        <option <?php echo ($data[_ORDER_BY] == _TYPE) ? 'selected' : ''; ?> value="<?php echo _TYPE; ?>">Type</option>
        <option <?php echo ($data[_ORDER_BY] == _LOCATION) ? 'selected' : ''; ?> value="<?php echo _LOCATION; ?>">Location</option>
	</select>
	<input type="hidden" name="<?php echo _AGENT; ?>" value="<?php echo _WEBSITE; ?>" />
    <input type="submit" value="Submit" />
</form>

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

if (count($data) > 2) {

    for ($i = 0; $i < count($data) - 2; $i++) {

        $report = new Report($data[$i]);

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
}
?>
</table>

<?php

include('footer.php');

?>
