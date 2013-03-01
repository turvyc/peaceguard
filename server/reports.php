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
checkLoggedIn($session);

?>

<h1>Incident Reports</h1>

<div id="dropdownMenu">
	<select name="timeDropDown">
	<option value="day">Today's Reports</option>
	<option value="las30Days">Last Thirty Days' Reports</option>
	<option value="year">Year To Date' Reports</option>
	</select>
	<select name="sortDropDown">
	<option value="date">Sort By Date</option>
	<option value="time">Sort By Time</option>
	<option value="serverity">Sort By Severity</option>
	<option value="username">Sort By Username</option>
	</select>
</div>

<?php include('footer.php'); ?>
