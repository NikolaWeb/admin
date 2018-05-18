<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lsearch_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
