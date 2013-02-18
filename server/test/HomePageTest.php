<?php

require_once('../model/session.model.php');
require_once('../model/volunteer.model.php');
require_once('../model/constants.model.php');

// These tests check pre-loaded rows in the database for the testing website, 
// located at http://peaceguard.dyndns.org:1728. Running these tests on any 
// other database will probably fail.
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
