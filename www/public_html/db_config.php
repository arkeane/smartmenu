<?php
$servername = "localhost";
$username = "S4832423";
$db_password = "lungomare";
$dbname = "S4832423";

$conn = new mysqli($servername, $username, $db_password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
