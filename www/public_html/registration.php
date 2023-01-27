<?php
if (isset($_POST["submit"])) {
    include 'db_config.php';
    include 'password.php';
    

    if (!isset($_POST["restaurantname"])) {
        $restaurantname = "default";
    } else {
        $restaurantname = $_POST["restaurantname"];
    }

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $confirm = $_POST["confirm"];


    if (empty($firstname) || empty($lastname) || empty($email) || empty($pass) || empty($confirm) || empty($restaurantname)) {
        echo "Please fill all the fields";
        exit;
    }

    // check if password respect the requirements at least 8 characters, 1 uppercase, 1 lowercase, 1 number
    if(isValidPassword($pass) == false) {
        header("Location: registration_page.php?error=invalidpassword");
        exit;
    }

    if ($pass != $confirm) {
        header("Location: registration_page.php?error=passwordcheck");
        exit;
    }

    $hash_pass = password_hash($pass, PASSWORD_DEFAULT);

    $sql = mysqli_prepare($conn, "SELECT * FROM users WHERE email=?");
    mysqli_stmt_bind_param($sql, "s", $email);
    mysqli_stmt_execute($sql);
    $result = mysqli_stmt_get_result($sql);
    if (mysqli_num_rows($result) > 0) {
        header("Location: login_page.php");
        exit;
    }

    $sql = mysqli_prepare($conn, "INSERT INTO users(firstname,lastname,email,password_hash,restaurant_name) VALUES(?,?,?,?,?)");
    mysqli_stmt_bind_param($sql, "sssss", $firstname, $lastname, $email, $hash_pass, $restaurantname);
    if (!mysqli_stmt_execute($sql)) {
        echo "Error inserting data: " . mysqli_error($conn);
        exit;
    }

    $id = mysqli_insert_id($conn);

    $sql = mysqli_prepare($conn, "INSERT INTO bought_templates (template_id, restaurant_id) VALUES (1, ?)");
    mysqli_stmt_bind_param($sql, "i", $id);
    if (!mysqli_stmt_execute($sql)) {
        echo "Error binding default template to user: " . mysqli_error($conn);
        exit;
    }

    header("Location: login_page.php");
}
