git<?php

/* statistics.php

This page displays patroll statistics in tabular form, according to the 
Admin's input. It also allows the Admin to download the retrieved statistics 
as a CSV file.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

include('header.php');
include('control/patrolstats.control.php');
checkLoggedIn($session);

?>

<h1>Patrol Statistics</h1>

<form name="<?php echo _REPORT; ?>" action="control/patrolstats.control.php" method="POST">
	<select name="<?php echo _TIME_PERIOD; ?>">
		<option value="<?php echo _LAST_DAY; ?>">Today's Reports</option>
		<option value="<?php echo _LAST_MONTH; ?>">Last Thirty Days' Reports</option>
		<option value="<?php echo _LAST_YEAR; ?>">Last Year's Reports</option>
		<option value="<?php echo _ALL_TIME; ?>">Year To Date' Reports</option>
	</select>
	
	<select name="<?php echo _ORDER_BY; ?>">
		<option value="<?php echo _NUMBER_VOLUNTEERS; ?>">Number of Registered Volunteers</option>
		<option value="<?php echo _GLOBAL_STATISTICS; ?>">GLOBAL STATISTICS</option>
		<option value="<?php echo _AVG; ?>">MEAN and MEDIAN</option>
	</select>
	<input type="hidden" name="<?php echo _AGENT; ?>" value="<?php echo _WEBSITE; ?>" />
    <input type="submit" value="Submit" />
</form>

<?php include('footer.php'); ?>
