<?php
include 'conf.php';

mysqli_report(MYSQLI_ERROR | MYSQLI_REPORT_STRICT);
$dbc = new mysqli ("localhost", "$un", "$pw", "attendance_app");

?>
