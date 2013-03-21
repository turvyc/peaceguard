<?php

/* newvolunteer.admin.php

Adds a new volunteer to the database, using information from the HTML form
in admin.php. The volunteer is assigned a random password, and confirmation
of their registration is emailed to them.

Contributor(s): Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('../model/constants.model.php');
require_once('../model/session.model.php');
require_once('../model/datainterface.model.php');
require_once('../model/volunteer.model.php');
require_once('../model/phpmailer.model.php');

define('ASCII_a', 97);
define('ASCII_z', 122);
define('PASSWORD_LENGTH', 6);

try {
    $session = new Session();
    $interface = new DataInterface($session);
}

catch (LogicException $e) {
    echo (_DEBUG) ? $e : $e->getMessage();
    exit(1);
}

// This script is only accessed from the website, so no need to check for
// the agent. 
try {
    //Make sure the POST values are acceptable.
    if (! isset($_POST[_FIRST_NAME]) || ! isset($_POST[_LAST_NAME])
    || ! isset($_POST[_EMAIL])) {
        throw new RuntimeException('Empty fields in form.');
    }

    // Make sure the email address is sanely formed
    if (! filter_var($_POST[_EMAIL], FILTER_VALIDATE_EMAIL)) {
        throw new RuntimeException('Invalid email address.');
    }

    // Generate a random password
    $password = '';
    for ($i = 0; $i < PASSWORD_LENGTH; $i++) {
        $password .= chr(rand(ASCII_a, ASCII_z));
    }

    // Store the name as all lower-case, for uniform uppercasing later on
    $first_name = strtolower($_POST[_FIRST_NAME]);
    $last_name = strtolower($_POST[_LAST_NAME]);
    $email = $_POST[_EMAIL];

    // Add the volunteer to the database
    Volunteer::newVolunteer($first_name, $last_name, $email, $password);

    // Send them an email with their username and password
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = TRUE;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;

    $mail->Username  = 'number13.peaceguard';
    $mail->Password  = 'ice cream you scream';

    $mail->From = 'number13.peaceguard@gmail.com';
    $mail->FromName = 'Peaceguard Webmaster';
    $mail->AddReplyTo('cstrong@sfu.ca', 'T. Colin Strong');

    $mail->Subject = 'Peaceguard Volunteer Registration';
    $mail->MsgHTML("<p>You have been registered as a volunteer with PeaceGuard!</p>
    <p>Your login: $email </p>
    <p>Your password: $password </p>
    <p>Thanks for registering!</p>");

    $name = "{ucwords($first_name)} {ucwords($last_name)}";
    $mail->AddAddress($email, $name);
    $mail->IsHTML(TRUE);

    if(! $mail->Send()) {
        $interface->addData(_SUCCESSFUL, _NO);
        $interface->addData(_MESSAGE, "Mailer Error: " . $mail->ErrorInfo);
    } else {
        $interface->addData(_SUCCESSFUL, _YES);
    }
}

catch (RuntimeException $e) {
    if (_DEBUG) {
        echo $e;
        exit(1);
    }
    $interface->addData(_SUCCESSFUL, _NO);
    $interface->addData(_MESSAGE, $e->getMessage());
}

catch (PDOException $e) {
    if (_DEBUG) {
        echo $e;
        exit(1);
    }
    $interface->addData(_SUCCESSFUL, _NO);
    $interface->addData(_MESSAGE, 'Database error.');
}

$interface->output();
header('location: ../admin.php');
exit(0);

?>
