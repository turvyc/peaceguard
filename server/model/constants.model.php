<?php

/** constants.model.php -- DEVELOPMENT VERSION

This file is for defining global constants that are NOT class constants.
All constants defined here should be prefixed with an underscore and written
in all-caps (e.g. _FOOBAR). Only constants defined here should use that
convention.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

// True if we are in a development environment, false otherwise. It affects
// what happens to caught exceptions, usually causing the program to halt 
// and echo information.
define('_DEBUG', true);

// The salt is concatenated to a plain-text password before it is hashed
define('_SALT', 'kd83md723fgfic03mkg9sdy34nds7x5r2bnd78x');

// The following constants are for JSON keys. These must be in agreement
// with both the website and the iPhone app.
define('_SUCCESSFUL', 'successful');
define('_MESSAGE', 'message');

// The following constants are for JSON values. These must be in agreement
// with both the website and the iPhone app. 
define('_YES', TRUE); // For use with _SUCCESSFUL key
define('_NO', FALSE); // For use with _SUCCESSFUL key

// The following constants are for $_POST array keys. 
define('_AGENT', 'agent');
define('_EMAIL', 'email');
define('_PASSWORD', 'password');

// POST array keys for incident reports (values are in the Report class)
define('_REPORT', 'report');
define('_ID', 'id');
define('_RESOLVED', 'resolved');
define('_TYPE', 'type');
define('_SEVERITY', 'severity');
define('_LOCATION', 'location');
define('_TIME', 'time');
define('_DESC', 'description');
define('_VOLUNTEER', 'u_id');

// POST keys for website incident report request
define('_TIME_PERIOD', 'timePeriod');
define('_ORDER_BY', 'orderBy');

// Time period constants
define('_LAST_DAY', 'lastDay');
define('_LAST_MONTH', 'lastMonth');
define('_LAST_YEAR', 'yearToDate');
define('_ALL_TIME', 'allTime');

// Patrol POST keys
define('_PATROL', 'patrol');
define('_START_TIME', 'startTime');
define('_DURATION', 'duration');
define('_ROUTE', 'route');
define('_BADGES', 'badges');

// Patrol SESSION data keys
define('_TOTAL', 'total');
define('_AVERAGE', 'average');
define('_DISTANCE', 'distance');

// Agent constants
define('_IPHONE', 'iphone');
define('_WEBSITE', 'website');

// Website Admin constants
define('_FIRST_NAME', 'firstname');
define('_LAST_NAME', 'lastname');
define('_NEW_PASSWORD', 'newpassword');
define('_REPEAT', 'repeat');

// Log file constants.
define('_LOG_DIR', 'log/');
define('_POST_LOG', _LOG_DIR . 'post.log');
define('_OUTPUT_LOG', _LOG_DIR . 'output.log');

// Returns the UNIX timestamp of the beginning of a specified time period.
function decodeTimePeriod($timePeriod) {
    switch ($timePeriod) {
        case _LAST_DAY:
            return strtotime('-1 day');
        case _LAST_MONTH:
            return strtotime('-1 month');
        case _LAST_YEAR:
            return strtotime('-1 year');
        case _ALL_TIME:
            return 0;
    }
}

// Constructs a human-readable string of the form (X days, Y hours, Z minutes)
// from an integer representing a number of seconds.
function secondsToString($seconds) {
    $secondsInMinute = 60;
    $secondsInHour = 60 * $secondsInMinute;
    $secondsInDay = 24 * $secondsInHour;

    $days = floor($seconds / $secondsInDay);
    $seconds = $seconds % $secondsInDay;

    $hours = floor($seconds / $secondsInHour);
    $seconds = $seconds % $secondsInHour;

    $minutes = floor($seconds / $secondsInMinute);
    $seconds = $seconds % $secondsInHour;

    $format = '%d days, %d hours, %d minutes';
    return sprintf($format, $days, $hours, $minutes);
}

?>
