<?php

/** generateRandomVolunteers.php

Populates the database with N pseudo-randomly generated Volunteers.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/constants.model.php');
require_once('../model/volunteer.model.php');
require('../model/database.model.php');

define('N_VOLUNTEERS', 12);
define('ASCII_a', 97);
define('ASCII_z', 122);

$firstNames = array('Colin', 'Ashley', 'Robert', 'Jonas', 'Kantar');
$lastNames = array('Strong', 'Lesperance', 'Sanchez', 'Yao', 'Lin');

for ($i = 0; $i < N_VOLUNTEERS; $i++) {
    echo 'Generating Volunteer #';
    echo $i + 1 . ' . . . ';
    $firstName = $firstNames[array_rand($firstNames)];
    $lastName = $lastNames[array_rand($lastNames)];

    // For simplicity, the email and the password will be the same: a sequence
    // of random letters (though the password will still be hashed for storage).
    $length = 3;
    $email = '';
    for ($j = 0; $j < $length; $j++) {
        $email .= chr(rand(ASCII_a, ASCII_z));
    }

    $pw_hash = sha1($email . _SALT);

    $STH = $DBH->prepare('INSERT INTO Users (email, firstName, lastName, pw_hash) VALUES (?, ?, ?, ?)');
    $STH->execute(array($email, $firstName, $lastName, $pw_hash));

    $u_id = $DBH->lastInsertId();
    $joined = rand(0, time());

    $STH = $DBH->prepare('INSERT INTO Volunteers (u_id, joined) VALUES (?, ?)');
    $STH->execute(array($u_id, $joined));

    echo 'done.<br />';
}

$DBH = null;

echo 'All done! Bye!';
exit(0);

?>
