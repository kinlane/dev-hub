<?php
include "/var/www/html/system/common.php";

$dbserver = "laneworks.cjgvjastiugl.us-east-1.rds.amazonaws.com";
$dbname = "va";
$dbuser = "kinlane";
$dbpassword = "ap1stack!";

// Make a database connection
mysql_connect($dbserver,$dbuser,$dbpassword) or die('Could not connect: ' . mysql_error());
mysql_select_db($dbname);
?>