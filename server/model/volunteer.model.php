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

        $result = $STH->fetch();
        $DBH = NULL;
        return $result['count'];
    }

    // Returns the number of currently patrolling volunteers
    public static function getTotalNumberPatrolling() {
        require('database.model.php');

        $query = "SELECT COUNT(*) AS count FROM Patrols WHERE duration IS NULL";

        $STH = $DBH->prepare($query);
        $STH->execute();

        $result = $STH->fetch();
        $DBH = NULL;

        return $result['count'];
    }

    // Records newly-earned badges to the database
    public function addBadges($badges) {
        if (! count($badges)) {
            return;
        }

        require('database.model.php');

        $time = time();

        // Generate the MySQL VALUES string for the query below
        $values = '';
        foreach ($badges as $badge) {
            $values .= "($badge, $this->id, $time),"
        }

        $query = "INSERT INTO Earns (b_id, u_id, date)
        VALUES $values;";
        $STH =$DBH->prepare($query);
        $STH->execute()
        $DBH = NULL;
    }

    // Returns a list of the badges the Volunteer has earned
    public function getBadges() {
        require('database.model.php');
        $query = "SELECT b_id, name
        FROM Volunteers NATURAL JOIN Earns NATURAL JOIN Badges
        WHERE u_id = $this->id";
        $STH = $DBH->prepare($query);
        $STH->execute();
        $badges = [];
        while ($badge = $STH->fetch()) {
            $badges[] = $badge;
        }
        return $badges;
    }

    public function getJoinDate() {
        require('database.model.php');
        $query = "SELECT joined FROM Volunteers WHERE id = $id";
        $STH = $DBH->prepare($query);
        $STH->execute();
        $result = $STH->fetch();
        $DBH = NULL;
        return $result['joined'];
    }

    public function getNumberOfReports() {
        require('database.model.php');
        $query = "SELECT COUNT(*) AS count
        FROM Reported WHERE u_id = $this->id"
        $STH = $DBH->prepare($query);
        $STH->execute();
        $result = $STH->fetch();
        $DBH = NULL;
        return $result['count'];
    }

    public function getNumberOfPatrols() {
        require('database.model.php');
        $query = "SELECT COUNT(*) AS count
        FROM Patrolled WHERE u_id = $this->id"
        $STH = $DBH->prepare($query);
        $STH->execute();
        $result = $STH->fetch();
        $DBH = NULL;
        return $result['count'];
    }

    public function getTotalTime() {
        require('database.model.php');
        $query = "SELECT SUM(duration) AS totalTime
        FROM Patrols NATURAL JOIN Patrolled 
        WHERE u_id = $this->id"
        $STH = $DBH->prepare($query);
        $STH->execute();
        $result = $STH->fetch();
        $DBH = NULL;
        return $result['totalTime'];
    }

    public function getTotalDistance() {
        require('database.model.php');
        $query = "SELECT SUM(distance) AS totalDistance
        FROM Patrols NATURAL JOIN Patrolled 
        WHERE u_id = $this->id"
        $STH = $DBH->prepare($query);
        $STH->execute();
        $result = $STH->fetch();
        $DBH = NULL;
        return $result['totalDistance'];
    }

    public function getAverageTime() {
        require('database.model.php');
        $query = "SELECT AVG(duration) AS avgTime
        FROM Patrols NATURAL JOIN Patrolled 
        WHERE u_id = $this->id"
        $STH = $DBH->prepare($query);
        $STH->execute();
        $result = $STH->fetch();
        $DBH = NULL;
        return $result['avgTime'];
    }

    public function getAverageDistance() {
        require('database.model.php');
        $query = "SELECT AVG(distance) AS avgDistance
        FROM Patrols NATURAL JOIN Patrolled 
        WHERE u_id = $this->id"
        $STH = $DBH->prepare($query);
        $STH->execute();
        $result = $STH->fetch();
        $DBH = NULL;
        return $result['avgDistance'];
    }
}

?>
