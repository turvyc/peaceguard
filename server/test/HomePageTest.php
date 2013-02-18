<?php

/** HomePage.php

To run these unit tests, run `phpunit --bootstrap .bootstrap.php HomePageTest.php`
You need PEAR and PHPUnit installed on your system.

These tests check pre-loaded rows in the database for the testing website, 
located at http://peaceguard.dyndns.org:1728. Running these tests on any 
other database will probably fail.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/volunteer.model.php');
require_once('../model/constants.model.php');

class HomePageTest extends PHPUnit_Framework_TestCase {

    private $volunteer;

    public function setUp() {
        $this->volunteer = new Volunteer();
    }

    public function testTotalNumbers() {
        $this->assertEquals($this->volunteer->getTotalNumber(), 3);
        $this->assertEquals($this->volunteer->getTotalNumber(true), 0);
    }
}
