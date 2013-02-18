<?php

/** database.model.php

Running this script connects to a MySQL server using PDO. The database object,
$DBH, can then be used to make SQL queries.

Important!! Because of the plain-text nature of this file, it should only be 
read/writable by the owner, but executable by anyone.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

// Database constants. 
$HOST = 'localhost';
$DB_NAME = 'peaceguard';
$USERNAME = 'peaceguard';
$PASSWORD = 'ice cream you scream';

try {
    // Create a PDO connection
    $DBH = new PDO("mysql:host=$HOST; dbname=$DB_NAME", $USERNAME, $PASSWORD);

    // Set some attributes
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $DBH->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} 

// If an exception is caught here, there is something wrong with the server :(
catch(PDOException $e) {
    if (_DEBUG) {
        echo $e->getMessage();
        exit(1);
    }

    // TODO: If not _DEBUG, the user should be sent to some reassuring landing
    // page, where they can conveniently let the developers about the problem.
}

?>
