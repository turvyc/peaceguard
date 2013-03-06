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

define('N_PATROLS', 12);
define('STILL_PATROLLING_RATIO', 4);

// Get an array of volunteer emails
echo 'Getting list of volunteers . . . ';
require('../model/database.model.php');
$STH = $DBH->prepare('SELECT email FROM Users NATURAL JOIN Volunteers');
$STH->execute();
$emails = $STH->fetchAll();
echo 'done.<br />';

$p_ids = array();
$end_times = array();
for ($i = 0; $i < N_PATROLS; $i++) {
    echo 'Starting Patrol #' . ($i + 1) . ' . . . ';

    $start_time = rand(0, time());
    $email = $emails[array_rand($emails)][_EMAIL];

    $end_times[] = rand($start_time, time());
    $p_ids[] = Patrol::beginPatrol($start_time, $email);

    echo 'done.<br />';
}

for ($i = 0; $i < N_PATROLS; $i++) {
    if ($i % STILL_PATROLLING_RATIO == 0) {
        echo 'Skipping Patrol #' . ($i + 1) . '<br />';
        continue;
    }

    echo 'Ending Patrol #' . ($i + 1) . ' . . . ';

    $distance = rand(100, 5000);
    $route = sha1(time() . rand());

    Patrol::endPatrol($p_ids[$i], $end_times[$i], $distance, $route);

    echo 'done.<br />';
}

echo 'All done! Goodbye.';
$DBH = null;
exit(0);

?>
