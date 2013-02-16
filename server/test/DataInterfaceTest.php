<?php

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
