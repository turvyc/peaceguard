<?php

/** session.model.php

The Session class handles everything to do with user sessions, including logging
in, logging out, and cookies. This class will be used instead of directly
manipulating the $_SESSION variable: the key/value pairs of $_SESSION will be
used as the class's private attributes.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('constants.model.php');
require_once('admin.model.php');

class Session {

    // These constants are for $_SESSION array keys
    const ADMIN = 'admin';
    const DATA = 'data';

    // The Admin object represents the currently logged-in administrator.
    private $admin;

    // Constructor. Starts a new session, if one hasn't been started already
    public function __construct() {

        if (session_id() == '') {
            session_start();
        }

        // Make sure the session's name is set
        if (! isset($_SESSION[Session::ADMIN])) {
            $_SESSION[Session::ADMIN] = NULL;
        }

        // Load the administrator, if one exists
        $this->admin = (isset($_SESSION[Session::ADMIN])) ? $_SESSION[Session::ADMIN] : NULL;
    }

    // Destructor. Calls logout().
    public function __destroy() {
        $this->logout();
    }

    // Returns the Admin object of the currently logged in admin, or null
    // if nobody is logged in.
    public function getAdmin() {
        return $this->admin;
    }

    // Returns the name of the logged-in admin, or null if nobody is logged in.
    public function getFullName() {
        return $this->admin->getFullName();
    }

    // Returns the email of the logged-in admin, or null if nobody is logged in.
    public function getEmail() {
        return $this->admin->getEmail();
    }

    // Sets the DATA key in the SESSION array to the associative array $data.
    public function setData($data) {
        $_SESSION[Session::DATA] = $data;
    }

    // Returns the associative array stored in the DATA key of the SESSION variable, 
    // or throws an exception if either _SESSION or the data are empty or unset.
    public function getData() {
        if (! isset($_SESSION[Session::DATA]) || empty($_SESSION[Session::DATA])) {
            throw new RuntimeException('No data found.');
        }

        $data = $_SESSION[Session::DATA];
        unset($_SESSION[Session::DATA]);
        return $data;
    }

    // Deletes the encoded JSON string stored in _SESSION[DATA]
    public function clearData() {
        if (isset($_SESSION[Session::DATA])) {
            unset($_SESSION[Session::DATA]);
        }
    }

    // Attempts to authenticate a username/password pair. 
    public function login($email, $password, $agent) {

        if (isset($_SESSION[Session::ADMIN])) {
            throw new RuntimeException('Already logged in as ' . $this->admin->getFullName());
        }

        $hash = $this->getPasswordHash($password);
        $table = ($agent == _IPHONE) ? 'Volunteers' : 'Admins';

        // Look for a match in the database
        try {
            require('database.model.php');
            $STH = $DBH->prepare("SELECT u_id FROM $table NATURAL JOIN Users 
            WHERE email = ? AND pw_hash = ?");
            $STH->execute(array($email, $hash));
        }
        // If there is a database error . . .
        catch (PDOException $e) {
            if (_DEBUG) {
                echo $e;
                exit(1);
            }
            // . . . send it upstairs
            throw new PDOException($e->getMessage);
        }


        // If there is a match, log the user in
        if ($row = $STH->fetch()) {
            if ($agent == _IPHONE) { return; }
            session_regenerate_id();
            $this->admin = new Admin((int)$row['u_id']);
            $_SESSION[Session::ADMIN] = $this->admin;
            $DBH = NULL;
        }

        // If there is no match, throw an exception for the controller to take care of
        else {
            $DBH = NULL;
            throw new DomainException('The email/password pair was not found!');
        }
    }

    // Logs a user out, and destroys all session data.
    public function logout() {
        $_SESSION = array();    // Clear out the session . . .
        $this->admin = NULL;
        session_destroy();      // . . . then destroy it entirely.
    }

    // Boolean. True if a user is logged in, false otherwise.
    public function loggedIn() {
        return (isset($this->admin)) ? TRUE : FALSE;
    }

    // Concatenates the password with a salt, then returns the resulting SHA1 hash.
    public function getPasswordHash($password) {
        return sha1($password . _SALT);
    }

}

?>
