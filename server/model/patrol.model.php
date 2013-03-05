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

    public static function newPatrol($data, $email) {
        // Ensure all keys are set (though they may have null values)
        if ((! isset($data[_START])) || (! isset($data[_END]))  || 
        (! isset($data[_ROUTE]))  || (! isset($data[_DISTANCE]))) {
            throw new DomainException('Key(s) missing from Patrol data array');
        }

        // Write the new patrol to the database
        require('database.model.php');
        $query = 'INSERT INTO Patrols (start_time, end_time, route, distance) VALUES (?, ?, ?, ?)';
        $STH = $DBH->prepare($query);
        $STH->execute(array($data[_START], $data[_END], $data[_ROUTE], $data[_DISTANCE])); 

        // Get the IDs of the just-inserted patrol and the Volunteer who made it
        $p_id = $DBH->lastInsertId();

        $STH = $DBH->prepare('SELECT u_id FROM Volunteers NATURAL JOIN Users WHERE email = ?');
        $STH->execute(array($email));
        $result = $STH->fetch();
        $u_id = $result['u_id'];

        // Remove the user from the IsPatrolling relation
        $STH = $DBH->prepare('DELETE FROM IsPatrolling WHERE u_id = ?');
        $STH->execute(array($u_id));

        // Create the relation and we're done
        $STH = $DBH->prepare('INSERT INTO HasPatrolled(p_id, u_id) VALUES (?, ?)');
        $STH->execute(array($r_id, $u_id));
    }
}

?>
