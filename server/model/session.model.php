<?php

/** session.model.php

The Session class handles everything to do with user sessions, including logging
in, logging out, and cookies. This class will be used instead of directly
manipulating the $_SESSION variable: the key/value pairs of $_SESSION will be
used as the class's private attributes.

Contributor(s): Colin Strong

*/

require_once('constants.model.php');

class Session {

    // The salt is concatenated to a plain-text password before it is hashed
    const SALT = 'k39zkd(jk12@#2mdk*_)_kdjs [3o212==k~~kd';

    // These constants are for $_SESSION array keys
    const USERNAME = 'username';
    const DATA = 'data';

    // Starts a new session, if one hasn't been started already
    public function __construct() {

        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION[Session::USERNAME])) {
            $_SESSION[Session::USERNAME] = null;
        }
    }

    // Returns the username of the logged-in user, or null if nobody is logged in.
    public function getUsername() {
        return $_SESSION[Session::USERNAME];
    }

    // Attempts to authenticate a username/password pair. Note that this function
    // is ONLY for the police administrator login, not for iPhone login!
    public function login($username, $password) {

        $hash = $this->getPasswordHash($password);

        // Look for a match in the database
        try {
            require('database.model.php');
            $STH = $DBH->prepare('SELECT a_id FROM Admins WHERE a_id=? AND pw_hash=?');
            $STH->execute(array($username, $hash));
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
        if ($STH->fetch()) {
            session_regenerate_id();
            $this->setUsername($username);
            $DBH = null;
        }

        // If there is no match, throw an exception for the controller to take care of
        else {
            $this->setUsername(null);
            $DBH = null;
            throw new Exception('The username/password pair was not found!');
        }
    }

    // Logs a user out, and destroys all session data.
    public function logout() {
        $_SESSION = array();    // Clear out $_SESSION . . .
        session_destroy();      // . . . then destroy it entirely.
    }

    // Concatenates the password with a salt, then returns the resulting SHA1 hash.
    private function getPasswordHash($password) {
        return sha1($password . Session::SALT);
    }

    // Sets the username of the session
    private function setUsername($username) {
        $_SESSION[Session::USERNAME] = $username;
    }

}

?>
