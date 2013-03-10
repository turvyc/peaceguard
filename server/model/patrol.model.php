<?php

/** patrol.model.php

The Patrol class encapsulates the data from a single patrol.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('session.model.php');
require_once('constants.model.php');

class Patrol {

    private $id;        // A positive integer, matching p_id in the database
    private $startTime; // A UNIX timestamp
    private $endTime;   // A UNIX timestamp
    private $distance; 
    private $route;
    private $volunteer; // A Volunteer object of the patroller

    // Writes a new patrol to the database (entering only the start time), and
    // returns the p_id of the just-created patrol.
    public static function beginPatrol($startTime, $email) {
        require('database.model.php');
        $query = 'INSERT INTO Patrols (start_time) VALUES (?)';
        $STH = $DBH->prepare($query);
        $STH->execute(array($startTime)); 

        // Get the p_id
        $p_id = $DBH->lastInsertId();

        // Get the Volunteer's u_id
        $STH = $DBH->prepare('SELECT u_id FROM Volunteers NATURAL JOIN Users WHERE email = ?');
        $STH->execute(array($email));
        $result = $STH->fetch();
        $u_id = $result['u_id'];

        // Create the relation and we're done
        $STH = $DBH->prepare('INSERT INTO Patrolled (p_id, u_id) VALUES (?, ?)');
        $STH->execute(array($p_id, $u_id));

        $DBH = NULL;
        return $p_id;
    }

    // Writes the end time, route, and distance to a started patrol
    public static function endPatrol($p_id, $duration, $distance, $route) {
        require('database.model.php');
        $query = 'UPDATE Patrols SET duration = ?, route = ?, distance = ? WHERE p_id = ?';
        $STH = $DBH->prepare($query);
        $STH->execute(array($duration, $route, $distance, $p_id));
        $DBH = NULL;
    }

    // Returns an associative array of the form (_TOTAL, _MEAN, _MEDIAN), 
    // where each of those three keys is another associative array of the
    // form (_N_PATROLS, _DISTANCE, _TIME, _N_REPORTS).
    public static function getStatistics($timePeriod, $orderBy) {
        $statistics = array();

        require('database.model.php');

        // Return the total number of patrols by all volunteers
        // Return the total distance travelled by all volunteers
        // Return the total time patrolled by all volunteers
        $query = 'SELECT COUNT( P.p_id ) AS totalPatrols, 
        SUM( P.distance ) AS totalDistance, 
        SUM( P.duration ) AS totalTime,
        FROM Patrols P';


        // Return the total number of reports made by all volunteers

        // Return the mean number of patrols per volunteer

        // Return the mean distance travelled per patrol per volunteer

        // Return the mean time spent per patrol per volunteer

        // Return the mean number of incident reports made per volunteer

        // Return the median number of patrols per volunteer

        // Return the median distance travelled per patrol per volunteer

        // Return the median time spent per patrol per volunteer

        // Return the median number of incident reports made per volunteer
    }

}

?>
