<?php
$servername = "database";
$username = "root";
$db_password = "root";
$dbname = "demo";

$conn = new mysqli($servername, $username, $db_password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>
