<?php

/** datainterface.model.php

This class represents the interface between the server and the website/iPhone.
While data flows into the server via control scripts, data flows out via this
interface. 

The data will be stored as an associative array in PHP, but the form it takes
when it is transmitted depends on whether it is destined for the website or 
the iPhone. In the former case, it will be stored in the $_SESSION variable. In
the latter case, it will be output (echoed) as a JSON array.

Contributor(s): Colin Strong

*/

require_once('constants.model.php');

class DataInterface {

    // The agent is the destination of the data, either the website or the iPhone
    private $agent;

    // This associative array will be manipulated and eventually output as
    // either a $_SESSION or JSON array, depending on the agent.
    private $data;

    public function __construct() {
        // There must be a POST array to work with
        if (! isset($_POST)) {
            throw new exception('$_POST is not set!');
        }

        // Also, the only required key is _AGENT. Make sure it's there.
        if (! isset($_POST[_AGENT])) {
            throw new exception('$_AGENT is not set!');
        }

        // Set the agent
        $this->agent = ($_POST[_AGENT] == _IPHONE) ? _IPHONE : _WEBSITE;
    }

    // When we're done with the interface, we should destroy the $_POST variables
    public function __destruct() {
        unset($_POST);
    }

    // Appends the specified key/value pair to $data
    public function add($key, $value) {
        $this->data[$key] = $value;
    }

    // Outputs the contents of $data, depending on the agent
    public function output() {
        if ($this->agent == _IPHONE) {
            echo json_encode($this->data);
        }
        else {
            $_SESSION[Session::DATA] = $this->data;
        }
    }
}

?>
