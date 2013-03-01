<?php

/** ReportClassTest.php

Unit tests for the Report class.

To run these unit tests, run `phpunit --bootstrap .bootstrap.php LoginTest.php`
You need PEAR and PHPUnit installed on your system.

Contributor(s): Robert Sanchez, Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/constants.model.php');
require_once('../model/report.model.php');

class ReportClassTest extends PHPUnit_Framework_TestCase {

    private $report;

    public function setUp() {
        $data = array(_TYPE => Report::GRAFFITI, _SEVERITY => Report::CRITICAL,
        _LOCATION => 'some location', _TIME => 111000111, _DESC => 'some description');
        
        $this->report = new Report($data);
    }

    public function testGetType() {
        $this->assertEquals($this->report->getType(), Report::GRAFFITI);
    }

    public function testGetSeverity() {
        $this->assertEquals($this->report->getSeverity(), Report::CRITICAL);
    }

    public function testGetLocation() {
        $this->assertEquals($this->report->getLocation(), 'some location');
    }

    public function testGetTime() {
        $this->assertEquals($this->report->getTime(), 111000111);
    }

    public function testGetDesc() {
        $this->assertEquals($this->report->getDesc(), 'some description');
    }

}

?>
