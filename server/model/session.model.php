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
    const SALT = 'kd83md723fgfic03mkg9sdy34nds7x5r2bnd78x';

    // These constants are for $_SESSION array keys
    const NAME = 'name';
    const DATA = 'data';

    // Constructor. Starts a new session, if one hasn't been started already
    public function __construct() {

        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION[Session::NAME])) {
            $_SESSION[Session::NAME] = null;
        }
    }

    // Destructor. Calls logout().
    public function __destroy() {
        $this->logout();
    }

    // Returns the name of the logged-in user, or null if nobody is logged in.
    public function getName() {
        return $_SESSION[Session::NAME];
    }

    // Sets the DATA key in the SESSION array to the associative array $data.
    public function setData($data) {
        $_SESSION[Session::DATA] = $data;
    }

    // Returns the associative array stored in the DATA key of the SESSION variable, 
    // or throws an exception if either _SESSION or the data are empty or unset.
    public function getData() {
        if (! isset($_SESSION[Session::DATA]) || empty($_SESSION[Session::DATA])) {
            throw new Exception('No data found.');
        }

        return $_SESSION[Session::DATA];
    }

    // Deletes the encoded JSON string stored in _SESSION[DATA]
    public function clearData() {
        if (isset($_SESSION[Session::DATA])) {
            unset($_SESSION[Session::DATA]);
        }
    }

    // Attempts to authenticate a username/password pair. Note that this function
    // is ONLY for the police administrator login, not for iPhone login!
    public function login($email, $password) {

        $hash = $this->getPasswordHash($password);

        // Look for a match in the database
        try {
            require('database.model.php');
            $STH = $DBH->prepare('SELECT U.firstName FROM Admins A, Users U 
            WHERE U.email = ? AND U.pw_hash = ? AND A.a_id = U.u_id');
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
            session_regenerate_id();
            $this->setName($row['firstName']);
            $DBH = null;
        }

        // If there is no match, throw an exception for the controller to take care of
        else {
            $this->setName(null);
            $DBH = null;
            throw new Exception('The email/password pair was not found!');
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
    private function setName($name) {
        $_SESSION[Session::NAME] = $name;
    }

}

?>
