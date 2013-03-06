<?php

/** generateRandomReports.php

Populates the database with N pseudo-randomly generated reports.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/constants.model.php');
require_once('../model/report.model.php');

define('N_REPORTS', 5);

// Define arrays of all the possibilies for each category
$types = array(Report::VANDALISM, Report::GRAFFITI, Report::BEHAVIOR, Report::PROPERTY, Report::OTHER);
$severities = array(Report::CRITICAL, Report::SERIOUS, Report::MINOR, Report::TIP);
$locations = array('Tatooine', 'Hoth', 'Dagobah', 'Bespin', 'Yavin', 'Kashyyyk', 'Alderaan');
$descs = array('Break it down nec turpis izzle leo bibendizzle fo shizzle.', 
'Vivamus ma nizzle tortor vel massa. Quisque malesuada magna.', 
'Morbi check it out, nisl rizzle for sure egestizzle, magna dolizzle vestibulum ligula, for sure auctizzle fo shizzle my nizzle dolor augue.',
'I saw beyonces tizzles and my pizzle went crizzle doggy check out this izzle, nizzle dawg eros nisl quizzle nisi.',
'Vivamizzle shiznit quizzle, shit sit sizzle, ornare check out this, pulvinizzle my shizz, felis.');

// Get an array of volunteer emails
echo 'Getting list of volunteers . . . ';
require('../model/database.model.php');
$STH = $DBH->prepare('SELECT email FROM Users NATURAL JOIN Volunteers');
$STH->execute();
$emails = $STH->fetchAll();
echo 'done.<br />';

for ($i = 0; $i < N_REPORTS; $i++) {
    echo 'Generating Report #' . ($i + 1) . ' . . . ';
    $data = array();

    // Randomly choose the data
    $data[_TIME] = rand(0, time());
    $data[_TYPE] = $types[array_rand($types)];
    $data[_SEVERITY] = $severities[array_rand($severities)];
    $data[_LOCATION] = $locations[array_rand($locations)];
    $data[_DESC] = $descs[array_rand($descs)];
    $email = $emails[array_rand($emails)][_EMAIL];

    Report::newReport($data, $email);
    echo 'done.<br />';
}

echo 'All done! Goodbye.';
$DBH = null;
exit(0);

?>
