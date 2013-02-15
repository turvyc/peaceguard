<?php

/** volunteer.model.php

The model for the Volunteer class, which is a superclass of User.

Contributors(s): Colin Strong

*/

require_once('user.model.php');
require_once('constants.model.php');

class Volunteer extends User {

    private $joinDate;
    private $numberOfReports;
    private $numberOfPatrols;
    private $totalTime;
    private $totalDistance;
    // private $score;  Commented because we have no score algorithm as of yet
	// private $badges; should we have an array to store badges that the volunteer has collected.

    // Returns the total number of registered volunteers, or the total number
    // patrolling if the parameter is true.
    public function getTotalNumber($patrolling = false) {
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
