<?php

/** report.php

The Report class encapsulates an incident report, or a set of incident reports.

Contributor(s): Robert Sanchez

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/session.model.php');
require_once('../model/constants.model.php');
require_once('../model/datainterface.model.php');

class Report {
			
	private $resolved;			//bool
	private $r_id;				//maybe concatenate #ofReports.#ofPatrols.userId
	private $r_time;			//
	private $r_type;			//incident type
	private $r_severity;		//
	private $r_location;
	private $r_description;
	
	//picture

    function __construct() {
	
		$resolved=FALSE;
		$timeArray=$getdate();
		$r_time=timeArray[0];
		
		$r_type=$_GET["type"];
		$r_severity=$_GET["serverity"];
		$r_location=$_GET["location"];
		$r_description=$_GET["description"];
		
		//|resolved tick box|reportId|reportTime|reportType|severity|location|description| - webportal display
		$reportArray=array($resolved,$r_id,$r_time,$r_type,$r_severity,$r_location,$r_description);
		
		echo json_encode($reportArray);
		// do something
    }
	
	function reportResolved(){
		$this->resolved=true;
	}

    // blah

}

?>
