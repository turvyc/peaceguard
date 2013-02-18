<?php

/** DataInterfaceTest.php

To run these unit tests, run `phpunit --bootstrap .bootstrap.php DataInterface.php`
You need PEAR and PHPUnit installed on your system.

These tests check pre-loaded rows in the database for the testing website, 
located at http://peaceguard.dyndns.org:1728. Running these tests on any 
other database will probably fail.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/datainterface.model.php');
require_once('../model/constants.model.php');

class DataInterfaceTest extends PHPUnit_Framework_TestCase {

    private $data;

    public function setUp() {
        $_POST = array();
        $this->data['key'] = 'value';
        $this->data['key2'] = 'value2';
        $this->data[3] = 3;
    }

    public function testAddDataWebsite() {
        $_POST[_AGENT] = _WEBSITE;
        $interface = new DataInterface();

        $interface->addData('key', 'value');
        $interface->addData('key2', 'value2');
        $interface->addData(3, 3);

        $interface->output();
        $this->assertJsonStringEqualsJsonString(json_encode($this->data), $_SESSION['data']);
        $interface = null;
    }

    public function testAddDataIphone() {
        $_POST[_AGENT] = _IPHONE;
        $interface = new DataInterface();

        $interface->addData('key', 'value');
        $interface->addData('key2', 'value2');
        $interface->addData(3, 3);

        $this->expectOutputString(json_encode($this->data));
        echo $interface->output();
        $interface = null;
    }
}
