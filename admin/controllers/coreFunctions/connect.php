<?php
//error_reporting(0);

//local server
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "morningreads";

//live server
// $servername = "localhost";
// $username = "mornvqfq_mreads_admin";
// $password = "mReads2019_@#23";
// $dbname = "mornvqfq_morningreads";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
?>
