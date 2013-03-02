<?php

/** report.model.php

The Report class encapsulates an incident report, or a set of incident reports.

Contributor(s): Robert Sanchez, Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/session.model.php');
require_once('../model/constants.model.php');

class Report {
			
    private $id;            // A positive integer, matching r_id in the database
    private $resolved;      // Boolean
    private $time;          // A Unix timestamp
    private $type;          // Must be one of the defined type constants
	private $severity;      // Must be one of the defined severity constants
    private $location;      // Latitude and longitude
    private $desc;          // 512 bytes (characters) max
	
    // Type constants:
    const VANDALISM = 'vandalism';
    const GRAFFITI = 'graffiti';
    const BEHAVIOR = 'behavior';
    const PROPERTY = 'property';
    const OTHER = 'other';

    // Severity constants:
    const CRITICAL = 'critical';
    const SERIOUS = 'serious';
    const MINOR = 'minor';
    const TIP = 'tip';

    // Constructs a new Report object. Because the data is coming from the
    // database, it needs no processing.
    function __construct($data) {
        $this->id = $data[_ID];
        $this->resolved = $data[_RESOLVED];
        $this->time = $data[_TIME];
        $this->type = $data[_TYPE];
        $this->severity = $data[_SEVERITY];
        $this->location = $data[_LOCATION];
        $this->desc = $data[_DESC];
    }
	
    // This static function checks a new report's data for errors, then 
    // writes it to the database.
    public static function newReport($data, $username) {
        // Ensure all keys are set (though they may have null values)
        if ((! isset($data[_TIME])) || (! isset($data[_TYPE]))  || 
        (! isset($data[_SEVERITY]))  || (! isset($data[_LOCATION]))  || 
        (! isset($data[_DESC]))) {
            throw new Exception('Key(s) missing from Report data array');
        }

        // Ensure that the type and severity are allowable values
        $allowedTypes = array(Report::VANDALISM, Report::GRAFFITI, 
        Report::BEHAVIOR, Report::PROPERTY, Report::OTHER);
        $allowedSeverities = array(Report::CRITICAL, Report::SERIOUS,
        Report::MINOR, Report::TIP);

        if (! in_array($data[_TYPE], $allowedTypes)) {
            throw new Exception('Illegal report type: ' . $data[_TYPE]);
        }

        if (! in_array($data[_SEVERITY], $allowedSeverities)) {
            throw new Exception('Illegal report severity: ' . $data[_SEVERITY]);
        }

        // Everything should be good to go now. Write the report to the database
        require('database.model.php');
        $STH = $DBH->prepare('INSERT INTO Reports (resolved, time, type, severity, location, desc)
        VALUES (?, ?, ?, ?, ?, ?)');
        $STH->execute(array(FALSE, $data[_TIME], $data[_TYPE], $data[_SEVERITY], $data[_LOCATION], $data[_DESC]));

        // Get the ids of the just-inserted report and the Volunteer who made it
        $r_id = $DBH->lastInsertId();

        $STH = $DBH->prepare('SELECT V.v_id FROM Volunteers V, Users U WHERE V.v_id = U.u_id AND U.email = ?');
        $STH->execute(array($username));
        $v_id = $STH->fetch();

        // Create the relation and we're done
        $STH = $DBH->prepare('INSERT INTO MakesReport (r_id, v_id) VALUES (?, ?)');
        $STH->execute(array($r_id, $u_id));
    }

    public function setResolved() {
        require('database.model.php');
        $STH = $DBH->prepare('UPDATE Reports SET resolved = TRUE WHERE r_id = ?');
        $STH->execute(array($this->id));

        $this->resolved = TRUE;
    }

    public function getResolved() {
        return $this->resolved;
    }

    public function getType() {
        return $this->type;
    }

    public function getSeverity() {
        return $this->severity;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getTime() {
        return $this->time;
    }

    public function getDesc() {
        return $this->desc;
    }

}

?>
