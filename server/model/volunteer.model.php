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

    // Returns the total number of registered volunteers, or the total number
    // patrolling if the parameter is true.
    public static function getTotalNumber($patrolling = false) {
        require('database.model.php');
        $table = ($patrolling) ? 'IsPatrolling' : 'Volunteers';
        $query = "SELECT v_id FROM $table";
        $STH = $DBH->prepare($query);
        $STH->execute();
        $rows = $STH->fetchAll();
        $DBH = null;
        return count($rows);
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
