<?php
if (isset($_POST["submit"])) {
    $servername = "database";
    $username = "root";
    $db_password = "root";
    $dbname = "demo";

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $confirm = $_POST["confirm"];

    if (empty($firstname) || empty($lastname) || empty($email) || empty($pass) || empty($confirm)) {
        echo "Please fill all the fields";
        exit;
    }

    if ($pass != $confirm) {
        echo "Passwords do not match";
        exit;
    }

    $hash_pass = password_hash($pass, PASSWORD_DEFAULT);

    $conn = new mysqli($servername, $username, $db_password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "Email already exists";
        exit;
    }

    $sql = "INSERT INTO users(firstname,lastname,email,password_hash) VALUES('$firstname','$lastname','$email','$hash_pass')";
    if (!mysqli_query($conn, $sql)) {
        echo "Error inserting data: " . mysqli_error($conn);
        exit;
    }
}
?>
