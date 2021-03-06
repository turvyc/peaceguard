<?php

/** patrol.model.php

The Patrol class contains static methods for beginning and ending a patrol, and
retrieving patrol statistics.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('session.model.php');
require_once('constants.model.php');
require_once('volunteer.model.php');

class Patrol {

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
    public static function endPatrol($p_id, $duration, $route, $distance) {
        require('database.model.php');
        $query = 'UPDATE Patrols SET duration = ?, route = ?, distance = ? WHERE p_id = ?';
        $STH = $DBH->prepare($query);
        $STH->execute(array($duration, $route, $distance, $p_id));
        $DBH = NULL;
    }

    // Returns statistics for a specified Volunteer.
    public static function getVolunteerStatistics($email, $timePeriod) {
        require('database.model.php');

        $statistics = array();
        $since = decodeTimePeriod($timePeriod);

        $query1 = "SELECT COUNT(*) AS totalPatrols,
        SUM(distance) AS totalDistance,
        SUM(duration) AS totalTime,
        AVG(distance) AS averageDistance,
        AVG(duration) AS averageTime
        FROM Patrols NATURAL JOIN Patrolled NATURAL JOIN Users
        WHERE email = '$email' AND start_time > $since";

        $query2 = "SELECT COUNT(*) AS totalReports
        FROM Reports NATURAL JOIN Reported NATURAL JOIN Users
        WHERE email = '$email' AND time > $since";

        $STH = $DBH->prepare($query1);
        $STH->execute();
        $result = $STH->fetch();

        $totalPatrols = $result['totalPatrols'];
        $totalDistance = $result['totalDistance'];
        $totalTime = $result['totalTime'];
        $averageDistance = $result['averageDistance'];
        $averageTime = $result['averageTime'];

        $STH = $DBH->prepare($query2);
        $STH->execute();

        $result = $STH->fetch();
        $totalReports = $result['totalReports'];

        $statistics[_TOTAL] = array(_PATROL => $totalPatrols, _DISTANCE => $totalDistance,
        _TIME => $totalTime, _REPORT => $totalReports);

        $statistics[_AVERAGE] = array(_DISTANCE => $averageDistance, _TIME => $averageTime);

        return $statistics;
    }

    // Returns an associative array of the form (_TOTAL, _MEAN, _MEDIAN), 
    // where each of those three keys is another associative array of the
    // form (_PATROL, _DISTANCE, _TIME, _REPORT).
    public static function getGlobalStatistics($timePeriod) {
        $statistics = array();
        $totalVolunteers = Volunteer::getTotalNumber();
        $since = decodeTimePeriod($timePeriod);

        require('database.model.php');

        // Return the total number of patrols by all volunteers
        // Return the total distance travelled by all volunteers
        // Return the total time patrolled by all volunteers
        $query1 = "SELECT COUNT(*) AS totalPatrols, 
        SUM(distance) AS totalDistance, 
        SUM(duration) AS totalTime,
        AVG(distance) AS averageDistance,
        AVG(duration) AS averageTime
        FROM Patrols
        WHERE start_time > $since";
        
        $STH = $DBH->prepare($query1);
        $STH->execute();

        $result = $STH->fetch();

        $totalPatrols = $result['totalPatrols'];
        $totalDistance = $result['totalDistance'];
        $totalTime = $result['totalTime'];
        $averageDistance = (int)$result['averageDistance'];
        $averageTime = (int)$result['averageTime'];

        // Return the total number of reports made by all volunteers
        $query2 = "SELECT COUNT(*) AS totalReports FROM Reports WHERE time > $since";

        $STH = $DBH->prepare($query2);
        $STH->execute();

        $result = $STH->fetch();
        $totalReports = $result['totalReports'];

        // Return the average number of patrols per volunteer
        $averagePatrols = (int)floor($totalPatrols / $totalVolunteers);

        // Return the average number of incident reports made per volunteer
        $averageReports = round($totalReports / $totalVolunteers, 2);

        $statistics[_TOTAL] = array(_PATROL => $totalPatrols, _DISTANCE => $totalDistance, 
        _TIME => $totalTime, _REPORT => $totalReports);

        $statistics[_AVERAGE] = array(_PATROL => $averagePatrols, _DISTANCE => $averageDistance, 
        _TIME => $averageTime, _REPORT => $averageReports);

        return $statistics;
    }

}

?>
