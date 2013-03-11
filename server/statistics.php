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
include('model/report.model.php');
checkLoggedIn($session);

?>

<h1>Patrol Statistics</h1>

<form name="<?php echo _REPORT; ?>" action="control/patrolstats.control.php" method="POST">
	<select name="<?php echo _TIME_PERIOD; ?>">
        Time Period:
		<option value="<?php echo _LAST_DAY; ?>">Today</option>
        <option value="<?php echo _LAST_MONTH; ?>">Last Thirty Days</option>
		<option value="<?php echo _LAST_YEAR; ?>">Last Year</option>
		<option value="<?php echo _ALL_TIME; ?>">All Time</option>
	</select>
	
	<input type="hidden" name="<?php echo _AGENT; ?>" value="<?php echo _WEBSITE; ?>" />
    <input type="submit" value="Submit" />
</form>

<ul>
    <li>Number of registered volunteers: <?php /* TODO */ ?></li>
    <li>Total:
        <ul>
            <li>Number of patrols: <?php /* TODO */ ?></li>
            <li>Distance patrolled: <?php /* TODO */ ?></li>
            <li>Time patrolled: <?php /* TODO */ ?></li>
            <li>Number of incident reports: <?php /* TODO */ ?></li>
        </ul>
    </li>
    <li>Average (per volunteer):
        <ul>
            <li>Number of patrols: <?php /* TODO */ ?></li>
            <li>Distance patrolled: <?php /* TODO */ ?></li>
            <li>Time patrolled: <?php /* TODO */ ?></li>
            <li>Number of incident reports: <?php /* TODO */ ?></li>
        </ul>
    </li>
</ul>

<?php include('footer.php'); ?>
