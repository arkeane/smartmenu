<?php
session_start();

if (isset($_POST["submit"])) {
    include 'db.php';

    $email = $_POST["email"];
    $pass = $_POST["pass"];

    if (empty($email) || empty($pass)) {
        echo "Please fill all the fields";
        exit;
    }

    $conn = new mysqli($servername, $username, $db_password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        echo "Email does not exist";
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    $hash_pass = $row["password_hash"];

    if (!password_verify($pass, $hash_pass)) {
        echo "Incorrect password";
        exit;
    }

    $sql = "SELECT id FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id = $row["id"];

    $_SESSION["email"] = $email;
    $_SESSION["bd_id"] = $id;

    header("Location: show_profile.php");
}
