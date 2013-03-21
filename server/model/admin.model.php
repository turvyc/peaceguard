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
    public function changePassword($old, $new) {
        $old_hash = sha1($old . _SALT);
        $new_hash = sha1($new . _SALT);

        try {
            require('database.model.php');

            $query = 'UPDATE Users NATURAL JOIN Admins 
            SET pw_hash = ? 
            WHERE u_id = ? AND pw_hash = ?';

            $STH = $DBH->prepare($query);
            $STH->execute(array($new_hash, $this->id, $old_hash));

            // If no rows were affected, they must have entered an incorrect
            // password.
            if (! $STH->rowCount()) {
                throw new RuntimeException('Nothing updated. Wrong password?');
            }
        }

        catch (PDOException $e) {
            if (_DEBUG) {
                echo $e;
                exit(1);
            }
            throw $e;
        }

        $DBH = NULL;
    }
}

?>
