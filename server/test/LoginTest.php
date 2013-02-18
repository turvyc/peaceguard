<?php

require_once('../model/session.model.php');
require_once('../model/constants.model.php');

// These tests check pre-loaded rows in the database for the testing website, 
// located at http://peaceguard.dyndns.org:1728. Running these tests on any 
// other database will probably fail.
class LoginTest extends PHPUnit_Framework_TestCase {

    private $session;

    public function setUp() {
        $this->session = new Session();
    }

    public function testPasswordHash() {
        $password1 = 'bob';
        $password2 = 'the';
        $password3 = 'hello';

        $actual1 = 'c4bf1c30b0b9522777c40dca2c38a52fda9b6c79';
        $actual2 = '240c0d985208ba3feea1bbd5ac89461b42c2384c';
        $actual3 = 'ca494cc18e7173acc00455cb8539a4d181efd3d6';

        $this->assertEquals($this->session->getPasswordHash($password1), $actual1);
        $this->assertEquals($this->session->getPasswordHash($password2), $actual2);
        $this->assertEquals($this->session->getPasswordHash($password3), $actual3);
    }

    public function testLogin() {
        $this->session->login('test1', 'the');
        $this->assertEquals($this->session->getFullName(), 'Boba Fett');
    }

    public function testBadLogin() {
        $this->setExpectedException('Exception');
        $this->session->login('test1', 'bogus!!!');
    }

    public function testLogout() {
        $this->session->logout();
        $this->assertEquals(session_id(), '');
    }
}
