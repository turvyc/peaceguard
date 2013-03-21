<?php

/** user.model.php

The model for the User superclass. Subclasses include Admin and Volunteer.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

abstract class User {

    protected $id;            // The user's unique id number
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $pw_hash;      // The user's password hash (not plaintext)

    public function __construct($id) {
        if (! is_int($id)) {
            throw new InvalidArgumentException('Parameter must be an integer!');
        }

        // Get the information from the database, throwing an exception if
        // the user isn't found.
        require('database.model.php');
        $STH = $DBH->prepare('SELECT * FROM Users WHERE u_id = ?');
        $STH->execute(array($id));
        $row = $STH->fetch();

        if (! $row) {
            throw new DomainException('User not found in database.');
        }

        // Populate the object's attributes with the information from the row.
        $this->id = $id;
        $this->firstName = $row['firstName'];
        $this->lastName = $row['lastName'];
        $this->email = $row['email'];
        $this->pw_hash = $row['pw_hash'];
    }

    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return ucwords($this->firstName);
    }

    public function getLastName() {
        return ucwords($this->lastName);
    }

    public function getFullName() {
        return "{$this->getFirstName()} {$this->getLastName()}";
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getLoggedIn() {
        return $this->loggedIn;
    }
}

?>
