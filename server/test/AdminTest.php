<?php

/** AdminTest.php

To run these unit tests, run `phpunit --bootstrap .bootstrap.php AdminTest.php`
You need PEAR and PHPUnit installed on your system.

These tests check pre-loaded rows in the database for the testing website, 
located at http://peaceguard.dyndns.org:1728. Running these tests on any 
other database will probably fail.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/admin.model.php');
require_once('../model/session.model.php');
require_once('../model/constants.model.php');

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
