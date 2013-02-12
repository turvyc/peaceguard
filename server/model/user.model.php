<?php

/** user.model.php

The model for the User superclass. Subclasses include Admin and Volunteer.

Contributor(s): Colin Strong

*/

class UserModel {

    private $id;            // The user's unique id number
    private $firstName;
    private $lastName;
    private $email;
    private $password;      // The user's password hash (not plaintext)
    private $loggedIn;      // Boolean. Whether the user is currently logged in

    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
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
