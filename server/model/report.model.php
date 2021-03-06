<?php

/** report.model.php

The Report class encapsulates an incident report, or a set of incident reports.

Contributor(s): Robert Sanchez, Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('session.model.php');
require_once('constants.model.php');
require_once('volunteer.model.php');

class Report {
			
    private $id;            // A positive integer, matching r_id in the database
    private $resolved;      // Boolean
    private $time;          // A Unix timestamp
    private $type;          // Must be one of the defined type constants
	private $severity;      // Must be one of the defined severity constants
    private $location;      // Latitude and longitude
    private $desc;          // 512 bytes (characters) max
    private $volunteer;     // A Volunteer object of the reporter
	
    // Type constants:
    const VANDALISM = 'vandalism';
    const GRAFFITI = 'graffiti';
    const BEHAVIOR = 'behavior';
    const PROPERTY = 'property';
    const OTHER = 'other';

    // Severity constants:
    const CRITICAL = 3;
    const SERIOUS = 2;
    const MINOR = 1;
    const TIP = 0;

    // Constructs a new Report object. Because the data is coming from the
    // database, it needs no processing.
    function __construct($data) {
        $this->id = $data['r_id'];
        $this->resolved = $data[_RESOLVED];
        $this->time = $data[_TIME];
        $this->type = $data[_TYPE];
        $this->severity = $data[_SEVERITY];
        $this->location = $data[_LOCATION];
        $this->desc = $data[_DESC];
        $this->volunteer = new Volunteer((int)$data['u_id']);
    }
	
    // This static function checks a new report's data for errors, then 
    // writes it to the database.
    public static function newReport($data, $email) {
        // Ensure all keys are set (though they may have null values)
        if ((! isset($data[_TIME])) || (! isset($data[_TYPE]))  || 
        (! isset($data[_SEVERITY]))  || (! isset($data[_LOCATION]))  || 
        (! isset($data[_DESC]))) {
            throw new DomainException('Key(s) missing from Report data array');
        }

        // Ensure that the type and severity are allowable values

        $allowedTypes = array(Report::VANDALISM, Report::GRAFFITI, 
        Report::BEHAVIOR, Report::PROPERTY, Report::OTHER);
        $allowedSeverities = array(Report::CRITICAL, Report::SERIOUS,
        Report::MINOR, Report::TIP);

        if (! in_array($data[_TYPE], $allowedTypes)) {
            throw new DomainException('Illegal report type: ' . $data[_TYPE]);
        }

        if (! in_array($data[_SEVERITY], $allowedSeverities)) {
            throw new DomainException('Illegal report severity: ' . $data[_SEVERITY]);
        }

        // Everything should be good to go now. Write the report to the database
        require('database.model.php');
        $sql = "INSERT INTO Reports (description, time, location, type, severity) VALUES (?, ?, ?, ?, ?)";
        $STH = $DBH->prepare($sql);
        $STH->execute(array($data[_DESC], $data[_TIME], $data[_LOCATION], $data[_TYPE], $data[_SEVERITY]));

        // Get the ids of the just-inserted report and the Volunteer who made it
        $r_id = $DBH->lastInsertId();

        $STH = $DBH->prepare('SELECT u_id FROM Volunteers NATURAL JOIN Users WHERE email = ?');
        $STH->execute(array($email));
        $result = $STH->fetch();
        $u_id = $result['u_id'];

        // Create the relation and we're done
        $STH = $DBH->prepare('INSERT INTO Reported (r_id, u_id) VALUES (?, ?)');
        $STH->execute(array($r_id, $u_id));
    }

    public function setResolved() {
        require('database.model.php');
        $STH = $DBH->prepare('UPDATE Reports SET resolved = 1 WHERE r_id = ?');
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
        switch ($this->severity) {
            case 0:
                return 'Tip';
            case 1:
                return 'Minor';
            case 2:
                return 'Serious';
            case 3:
                return 'Critical';
        }
    }

    public function getLocation() {
        return $this->location;
    }

    public function getTime() {
        return date('G:i', $this->time);
    }

    public function getDate() {
        return date('M j, Y', $this->time);
    }

    public function getDesc() {
        return $this->desc;
    }

    public function getVolunteer() {
        return $this->volunteer->getFullName();
    }

}

?>
