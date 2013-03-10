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
define('_VOLUNTEER', 'v_id');

// POST keys for website incident report request
define('_TIME_PERIOD', 'timePeriod');
define('_ORDER_BY', 'sortBy');

// Time period constants
define('_LAST_DAY', 'lastDay');
define('_LAST_MONTH', 'lastMonth');
define('_LAST_YEAR', 'yearToDate');
define('_ALL_TIME', 'allTime');

// Patrol POST keys
define('_PATROL', 'patrol');
define('_START_TIME', 'startTime');
define('_END_TIME', 'endTime');

// Patrol SESSION data keys
define('_TOTAL', 'total');
define('_AVERAGE', 'average');
define('_DISTANCE', 'distance');
define('_TIME', 'time');

// The following constants are for $_POST array values.
define('_IPHONE', 'iphone');   // For use with _AGENT key
define('_WEBSITE', 'website');  // For use with _AGENT key

// Log file constants.
define('_LOG_DIR', 'log/');
define('_POST_LOG', _LOG_DIR . 'post.log');
define('_OUTPUT_LOG', _LOG_DIR . 'output.log');

?>
