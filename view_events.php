<?php

# Set page page title
$page_title = "Events";

# Include header
include 'includes/header.html';

# Include credentials
include 'conf.php';

# Database connection
$dbc = @mysqli_connect('localhost', "$un", "$pw", 'attendance_app');

# Check connection
if (!$dbc) {
  die("Connection failed: " . mysqli_error());
}

$q = "SELECT * FROM users";
$r = @mysqli_query($dbc, $q);

if (mysqli_num_rows($r) > 0) {


} //end mysqlinumrows if
?>


<h1 class="my-3">This is a VIEW EVENTS page</h1>
<p>Here you will see a list of sessions. You can add, edit or delete a session.</p>


<?php
include 'includes/footer.html';
 ?>
