<?php
if (isset($_POST["submit"])) {
    include 'db_config.php';

    $restaurantname = $_POST["restaurantname"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $confirm = $_POST["confirm"];

    if (empty($firstname) || empty($lastname) || empty($email) || empty($pass) || empty($confirm) || empty($restaurantname)) {
        echo "Please fill all the fields";
        exit;
    }

    $restaurantname = mysqli_real_escape_string($conn, $restaurantname);
    $firstname = mysqli_real_escape_string($conn, $firstname);
    $lastname = mysqli_real_escape_string($conn, $lastname);
    $email = mysqli_real_escape_string($conn, $email);


    // check if password respect the requirements at least 8 characters, 1 uppercase, 1 lowercase, 1 number
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $pass)) {
        if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $pass)){
            header("Location: registration_page.php?error=invalidpassword");
        exit;
        }
    }
    
    if ($pass != $confirm) {
        header("Location: registration_page.php?error=passwordcheck");
        exit;
    }

    $hash_pass = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        header("Location: login_page.php");
        exit;
    }

    $sql = "INSERT INTO users(firstname,lastname,email,password_hash,restaurant_name) VALUES('$firstname','$lastname','$email','$hash_pass', '$restaurantname')";
    if (!mysqli_query($conn, $sql)) {
        echo "Error inserting data: " . mysqli_error($conn);
        exit;
    }

    $sql = "SELECT id FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id = $row["id"];

    $sql = "INSERT INTO bought_templates (template_id, restaurant_id) VALUES (1, '$id');";
    if (!mysqli_query($conn, $sql)) {
        echo "Error binding default template to user: " . mysqli_error($conn);
        exit;
    }

    header("Location: login_page.php");
}
