<?php

include('header.html');
include('model/session.model.php');

// This should be in header.html, which would be changed to header.php
$session = new Session();

if (! $session->getUsername()) {
    header('location:login.php');
}

?>

<h2>Main page stuff goes here</h2>

<?php

include('footer.html);

?>
