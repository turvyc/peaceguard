<?php

/** constants.model.php -- DEVELOPMENT VERSION

This file is for defining global constants that are NOT class constants.
All constants defined here should be prefixed with an underscore and written
in all-caps (e.g. _FOOBAR). Only constants defined here should use that
convention.

Contributor(s): Colin Strong

*/

// True if we are in a development environment, false otherwise. It affects
// what happens to caught exceptions, usually causing the program to halt 
// and echo information.
define('_DEBUG', true);

// The following constants are for JSON keys. These must be in agreement
// with both the website and the iPhone app. Integers are used for simplicity.
define('_SUCCESSFUL', 0);
define('_MESSAGE', 1);

?>
