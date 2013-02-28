<?php

/** report.php

The Report class encapsulates an incident report, or a set of incident reports.

Contributor(s): Robert Sanchez, Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/session.model.php');
require_once('../model/constants.model.php');
require_once('../model/datainterface.model.php');

class Report {
			
    private $resolved;      // Boolean
    private $time;          // A Unix timestamp
    private $type;          // Must be one of the defined type constants
	private $severity;      // Must be one of the defined severity constants
    private $location;      // Latitude and longitude
    private $description;   // 512 bytes (characters) max
	
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

    // The default constructor constructs a new report using POST data.
    function __construct() {
        // Ensure that the POST variable is set
        if (! isset($_POST)) {
            throw new Exception('POST is not set.');
        }

    }
	
	function reportResolved(){
		$this->resolved = true;
	}

    // blah

}

?>
