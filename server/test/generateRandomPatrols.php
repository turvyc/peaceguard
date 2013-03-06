<?php

/** generateRandomPatrols.php

Populates the database with N pseudo-randomly generated patrols.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/constants.model.php');
require_once('../model/patrol.model.php');

define('N_PATROLS', 1);

// Get an array of volunteer emails
echo 'Getting list of volunteers . . . ';
require('../model/database.model.php');
$STH = $DBH->prepare('SELECT email FROM Users NATURAL JOIN Volunteers');
$STH->execute();
$emails = $STH->fetchAll();
echo 'done.<br />';

$p_ids = array();
for ($i = 0; $i < N_PATROLS; $i++) {
    echo 'Starting Patrol #';
    echo $i + 1 . ' . . . ';

    $email = $emails[array_rand($emails)][_EMAIL];
    $time = rand(0, time());

    $p_ids[] = Patrol::beginPatrol($time, $email);

    echo 'done.<br />';
}

print_r($p_ids);

echo 'All done! Goodbye.';
$DBH = null;
exit(0);

?>
