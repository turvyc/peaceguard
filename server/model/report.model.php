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

    // The default constructor constructs a new report using data
    // stored in an associative array.
    function __construct($data) {
        // Ensure that the type and severity are allowable values
        $allowedTypes = array(Report::VANDALISM, Report::GRAFFITI, 
        Report::BEHAVIOR, Report::PROPERTY, Report::OTHER);
        $allowedSeverities = array(Report::CRITICAL, Report::SERIOUS,
        Report::MINOR, Report::TIP);

        if (! in_array($data[_TYPE], $allowedTypes)) {
            throw new Exception('Illegal report type: ' $data[_TYPE]);
        }

        if (! in_array($data[_REPORT][_SEVERITY], $allowedSeverities)) {
            throw new Exception('Illegal report severity: ' $data[_SEVERITY]);
        }

        // Populate the attributes
        $this->time = $data[_TIME];
        $this->type = $data[_TYPE];
        $this->severity = $data[_SEVERITY];
        $this->location = $data[_LOCATION];
        $this->desc = $data[_DESC];
    }
	
	function reportResolved(){
        $this->resolved = TRUE;
	}

    // blah

}

?>
