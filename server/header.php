<?php

/* header.php

The standard header boilerplate for every page of the PeaceGuard website.

Contributor(s): Kantar Lin, Colin Strong

For a detailed list of changes to this file, enter the command `git log <file>` 
or `git blame <file>`

(c) 2013 Number 13 Developer's Group

*/

require_once('model/session.model.php');
$session = new Session();

// This function ensures a visitor to any page in the website (except for the
// login page) is logged in. If they are not, they are automatically redirected
// to the login page.
function checkLoggedIn($session) {
    if (! $session->getName()) {
        if (_DEBUG) {
            echo 'NOT LOGGED IN!';
        }
    }
    else {
        header('location:login.php');
        exit(0);
    }
}
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>PeaceGuard Web Portal</title>
        <link rel="stylesheet" type="text/css" href="css/police.css">
    </head>

    <body>	
        <div id="main">
            <div id="header">
                <img src="img/Banner.png" /> 
            </div>

            <div id="body">
                <div id="navbar">
                    <ul>
                        <li> <a href="index.php">Home</a> </li>
                        <li> <a href="reports.php">Incident Reports</a> </li>
                        <li> <a href="statistics.php">Patrol Statistics</a> </li>
                        <li> <a href="admin.php">Administration</a> </li>
                        <li> <a href="logout.php">Logout</a> </li>
                    </ul>
                </div>
                <div id="content">
