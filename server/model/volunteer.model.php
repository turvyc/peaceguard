<?php

/** volunteer.model.php

The model for the Volunteer class, which is a superclass of User.

Contributors(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('user.model.php');
require_once('constants.model.php');

class Volunteer extends User {

    private $joinDate;
    private $totalTime;
    private $totalDistance;
    // private $score;  Commented because we have no score algorithm as of yet
	// private $badges; should we have an array to store badges that the volunteer has collected.

    // Constructs a new Volunteer object using the database ID
    public function __construct($id) {
        parent::__construct($id);
    }

    // Inserts a new Volunteer into the database
    public static function newVolunteer($first_name, $last_name, $email, $password) {
        try {
            require('database.model.php');

            $pw_hash = sha1($password . _SALT);

            $STH = $DBH->prepare('INSERT INTO Users 
            (email, firstName, lastName, pw_hash) VALUES (?, ?, ?, ?)');
            $STH->execute(array($email, $first_name, $last_name, $pw_hash));

            $STH = $DBH->prepare('INSERT INTO Volunteers (u_id, joined) VALUES (?, ?)');
            $STH->execute(array($DBH->lastInsertId(), time()));

            $DBH = NULL;
        }

        catch (PDOException $e) {
            if (_DEBUG) {
                echo $e;
                exit(1);
            }
            throw $e;
        }
    }

    // Returns the total number of registered volunteers.
    public static function getTotalNumber() {
        require('database.model.php');

        $query = "SELECT COUNT(*) AS count FROM Volunteers";

        $STH = $DBH->prepare($query);
        $STH->execute();

        $count = $STH->fetch();
        $DBH = NULL;
        return $count['count'];
    }

    // Returns the number of currently patrolling volunteers
    public static function getTotalNumberPatrolling() {
        require('database.model.php');

        $query = "SELECT COUNT(*) AS count FROM Patrols WHERE duration IS NULL";

        $STH = $DBH->prepare($query);
        $STH->execute();

        $count = $STH->fetch();
        $DBH = NULL;

        return $count['count'];
    }

    public function getJoinDate() {
        return $this->joinDate;
    }

    public function getNumberOfReports() {
        return $this->numberOfReports;
    }

    public function getNumberOfPatrols() {
        return $this->numberOfPatrols;
    }

    public function getTotalTime() {
        return $this->totalTime;
    }

    public function getTotalDistance() {
        return $this->totalDistance;
    }

    public function getAverageTime() {
        return $this->totalTime / $this->numberOfPatrols;
    }

    public function getAverageDistance() {
        return $this->totalDistance / $this->numberOfPatrols;
    }

    public function madeReport() {
        $this->numberofReports+=1;
    }

}

?>
