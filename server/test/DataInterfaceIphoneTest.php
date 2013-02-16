<?php

require_once('../model/datainterface.model.php');
require_once('../model/constants.model.php');

class DataInterfaceIphoneTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $_POST = array();
        $_POST[_AGENT] = _IPHONE;
    }

    public function testEmpty() {
        $interface = new DataInterface();
        $this->expectOutputString(null);
        echo $interface->output();
        return $interface;
    }
}
