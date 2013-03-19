<?php

/** admin.model.php

The model for the Admin class, which is a superclass of User.

Contributors(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('user.model.php');
require_once('constants.model.php');

class Admin extends User {

    // Constructs a new Admin object using the database ID
    public function __construct($id) {
        parent::__construct($id);
    }

    // Changes the admin's password
    public function changePassword($new) {
        $pw_hash = sha1($new . _SALT);

        try {
            require('database.model.php');
            $query = 'UPDATE Users SET pw_hash = ? WHERE u_id = ?';
            $STH = $DBH->prepare($query);
            $STH->execute(array($pw_hash, $this->id));
        }

        catch (PDOException $e) {
            if (_DEBUG) {
                echo $e;
                exit(1);
            }
            throw $e;
        }

        if (! $STH->rowCount()) {
            throw new RuntimeException('Database error.');
        }

        $DBH = NULL;
    }
}

?>
