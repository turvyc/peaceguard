<?php

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
require_once('model/report.model.php');
require_once('model/volunteer.model.php');
checkLoggedIn($session);

// Try to get data set by the control script
try {
    $sessionData = $session->getData();
    $globalStats = $sessionData[_TOTAL];
    $averageStats = $sessionData[_AVERAGE];
    $timePeriod = $sessionData[_TIME_PERIOD];
}

// Nothing set, go get some statistics
catch (Exception $e) {
    header('location: control/patrolstats.control.php');
    exit(0);
}

?>

<h1>Patrol Statistics</h1>

<form name="<?php echo _REPORT; ?>" action="control/patrolstats.control.php" method="POST">
	<select name="<?php echo _TIME_PERIOD; ?>">
        Time Period:
        <option <?php echo ($timePeriod == _LAST_DAY) ? 'selected' : ''; ?> value="<?php echo _LAST_DAY; ?>">Today</option>
        <option <?php echo ($timePeriod == _LAST_MONTH) ? 'selected' : ''; ?> value="<?php echo _LAST_MONTH; ?>">Last Thirty Days</option>
		<option <?php echo ($timePeriod == _LAST_YEAR) ? 'selected' : ''; ?> value="<?php echo _LAST_YEAR; ?>">Last Year</option>
		<option <?php echo ($timePeriod == _ALL_TIME) ? 'selected' : ''; ?> value="<?php echo _ALL_TIME; ?>">All Time</option>
	</select>
	
	<input type="hidden" name="<?php echo _AGENT; ?>" value="<?php echo _WEBSITE; ?>" />
    <input type="submit" value="Submit" />
</form>

<ul>
    <li>Number of registered volunteers: <?php echo Volunteer::getTotalNumber(); ?></li>
    <li>Total:
        <ul>
            <li>Number of patrols: <?php echo $globalStats[_PATROL] ?></li>
            <li>Distance patrolled: <?php echo round($globalStats[_DISTANCE] / 1000, 1) . ' kilometers' ?></li>
            <li>Time patrolled: <?php echo secondsToString($globalStats[_TIME]) ?></li>
            <li>Number of incident reports: <?php echo $globalStats[_REPORT] ?></li>
        </ul>
    </li>
    <li>Average (per volunteer):
        <ul>
            <li>Number of patrols: <?php echo $averageStats[_PATROL] ?></li>
            <li>Distance patrolled: <?php echo $averageStats[_DISTANCE] ?></li>
            <li>Time patrolled: <?php echo secondsToString($averageStats[_TIME]) ?></li>
            <li>Number of incident reports: <?php echo $averageStats[_REPORT] ?></li>
        </ul>
    </li>
</ul>

<?php

include('footer.php');

?>
