<?php

/* login.php

This script is the target of a HTTP POST request, and returns a JSON array, 
with the structure { _SUCCESSFUL: boolean, _MESSAGE: string }.

Contributor(s): Colin Strong

*/

require_once('../model/session.model.php');
require_once('../model/constants.model.php');

// Initialize the associative array which will become the JSON array
$json = array();

// Start a session and attempt to log in
$session = new Session();
try {
    $session->login($_POST[_USERNAME], $_POST[_PASSWORD]);
}

// If there is a database error . . .
catch (PDOException $e) {
    $json[_SUCCESSFUL] = false;
    $json[_MESSAGE] = 'Database error!';
}

// If there was no match . . . 
catch (Exception $e) {
    $json[_SUCCESSFUL] = false;
    $json[_MESSAGE] = $e->getMessage();
}

// If we made it this far, we should be logged in. This is getting tossed in 
// until I can write some unit tests.
if (_DEBUG) {
    assert($session->getUsername() != null);
}

$json[_SUCCESSFUL] = true;
$json[_MESSAGE] = "Thanks for logging in, $session->getUsername()!";

echo json_encode($json);


exit(0);

?>
