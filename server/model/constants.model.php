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

define('_SOURCE_DIR', '/home/colin/src/school/cmpt275/2013-1-g13');
define('_SERVER_DIR', _SOURCE_DIR . '/server');

// True if we are in a development environment, false otherwise. It affects
// what happens to caught exceptions, usually causing the program to halt 
// and echo information.
define('_DEBUG', true);

// The following constants are for JSON keys. These must be in agreement
// with both the website and the iPhone app.
define('_SUCCESSFUL', 'successful');
define('_MESSAGE', 'message');

// The following constants are for JSON values. These must be in agreement
// with both the website and the iPhone app. 
define('_YES', 'yes'); // For use with _SUCCESSFUL key
define('_NO', 'no'); // For use with _SUCCESSFUL key

// The following constants are for $_POST array keys. 
define('_AGENT', 'agent');
define('_EMAIL', 'email');
define('_PASSWORD', 'password');

// The following constants are for $_POST array values.
define('_IPHONE', 'iphone');   // For use with _AGENT key
define('_WEBSITE', 'website');  // For use with _AGENT key

// Log file constants.
define('_LOG_DIR', _SERVER_DIR . '/log');
define('_POST_LOG', _LOG_DIR . '/post.log');

?>
