<?php

/** report.php

The Report class.

*/

class Report {

	private $rId;
	private $rTime;
	private $resolved;
	private $location;
	private $description;
	private $severity;
	//picture


    function __construct() {
		$timestamp=getdate();			//date array
		
		$this->resolved=false;
		$this->rTime=$timestamp[0];		//unix time of date array
		// do something
    }
	
	function reportResolved(){
		$this->resolved=true;
	}

    // blah

}

?>
