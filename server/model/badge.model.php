<?php

/** badge.model.php

Represents a Volunteer's collection of badges. Its main function is to check
whether a Voluteer has earned any new badges, updating the database accordingly.

Contributors(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('volunteer.model.php');
require_once('constants.model.php');

class Badge {

    // Badge IDs
    const DISTANCE_1 = 'dist_1';
    const DISTANCE_5 = 'dist_5';
    const DISTANCE_10 = 'dist_10';
    const TIME_1 = 'time_1';
    const TIME_5 = 'time_5';
    const TIME_10 = 'time_10';

    const KM_1 = 1000;
    const KM_5 = 5000;
    const KM_10 = 10000;

    const HR_1 = 60;
    const HR_5 = 300;
    const HR_10 = 600;

    // Checks to see if the Volunteer has earned any new badges, and if so, 
    // writes it to the database. The list of new badges is also returned.
    public static function checkForNewBadges($volunteer) {
        $current_badges = $volunteer->getBadges();
        $eligible_badges = Badge::getEligibleBadges($volunteer);

        $new_badges = [];

        // Keep only the eligible badges not already earned
        foreach ($eligible_badges as $badge) {
            if (! in_array($badge, $current_badges)) {
                $new_badges[] = $badge;
            }
        }

        return $new_badges;
    }

    // Returns the highest badges for which the Volunteer is eligible.
    public static function getEligibleBadges($volunteer) {
        $eligible_badges = [];

        // Determine the highest distance milestone badge for which the Volunteer
        // is eligible
        $distance = $volunteer->getTotalDistance();
        if ($distance >= Badge::KM_10) {
            $eligible_badges[] = Badge::DISTANCE_10;
        }
        else if ($distance >= Badge::KM_5) {
            $eligible_badges[] = Badge::DISTANCE_5;
        }
        else if ($distance >= Badge::KM_1) {
            $eligible_badges[] = Badge::DISTANCE_1;
        }

        // Determine the highest duration milestone badge for which the Volunteer
        // is eligible
        $distance = $volunteer->getTotalTime();
        if ($distance >= Badge::HR_10) {
            $eligible_badges[] = Badge::TIME_10;
        }
        else if ($distance >= Badge::HR_5) {
            $eligible_badges[] = Badge::TIME_5;
        }
        else if ($distance >= Badge::HR_1) {
            $eligible_badges[] = Badge::TIME_1;
        }

        return $eligible_badges;
    }
}

?>
