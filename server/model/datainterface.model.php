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

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('constants.model.php');
require_once('session.model.php');

class DataInterface {

    // The agent is the destination of the data, either the website or the iPhone
    private $agent;

    // This associative array will be manipulated and eventually output as
    // either a $_SESSION or JSON array, depending on the agent.
    private $data;

    // The header stores the page the client should be redirected to after outputting
    // the data, should they be using the website.
    private $header;

    // The session is constructed in a control script, and then passed here.
    private $session;

    public function __construct($session) {
        $this->session = $session;

        // There must be a POST array to work with
        if (! isset($_POST)) {
            throw new LogicException('$_POST is not set!');
        }

        // Also, the only required key is _AGENT. Make sure it's there.
        if (! isset($_POST[_AGENT])) {
            throw new LogicException('$_AGENT is not set!');
        }

        // Initialize the data array
        $this->array = array();

        // Set the agent
        $this->agent = ($_POST[_AGENT] == _IPHONE) ? _IPHONE : _WEBSITE;

        // Output the POST data to a logfile, if debugging
        if (_DEBUG) {
            $logfile = fopen(_POST_LOG, 'a');
            $format = "%s -- Contents of POST:\n %s\n\n";
            $entry = sprintf($format, date('j M Y G:i:s'), print_r($_POST, TRUE));
            fwrite($logfile, $entry);
            fclose($logfile);
        }
    }

    // When we're done with the interface, we should destroy the $_POST variables
    public function __destruct() {
        unset($_POST);
    }

    // Returns either _IPHONE or _WEBSITE
    public function getAgent() {
        return $this->agent;
    }

    // Appends the specified key/value pair to $data
    public function addData($key, $value) {
        $this->data[$key] = $value;
    }

    // Outputs the data, depending on the agent
    public function output() {

        if ($this->agent == _IPHONE) {
            $json = json_encode($this->data);
            // Output the POST data to a logfile, if debugging
            if (_DEBUG) {
                $logfile = fopen(_OUTPUT_LOG, 'a');
                $format = "%s -- Output to iPhone:\n %s\n\n";
                $entry = sprintf($format, date('j M Y G:i:s'), $json);
                fwrite($logfile, $entry);
                fclose($logfile);
            }
            echo $json;
        }

        else {
            $this->session->setData($this->data);
        }
        exit(0);
    }
}

?>
