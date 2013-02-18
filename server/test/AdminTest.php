<?php

require_once('../model/admin.model.php');
require_once('../model/session.model.php');
require_once('../model/constants.model.php');

// These tests check pre-loaded rows in the database for the testing website, 
// located at http://peaceguard.dyndns.org:1728. Running these tests on any 
// other database will probably fail.
class AdminTest extends PHPUnit_Framework_TestCase {

    private $admin;
    private $session;

    public function setUp() {
        $this->session = new Session();
        $this->session->login('test2', 'hello');
    }

    public function testFullName() {
        $this->assertEquals($this->session->getFullName(), 'Darth Vader');
    }

    public function testEmail() {
        $this->assertEquals($this->session->getEmail(), 'test2');
    }
}
