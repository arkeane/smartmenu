<?php
if (isset($_POST["submit"])) {
    include '../db_config.php';
    include '../password.php';

    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $confirm = $_POST["confirm"];


    if ( empty($email) || empty($pass) || empty($confirm)) {
        echo "Please fill all the fields";
        exit;
    }

    // check if password respect the requirements at least 8 characters, 1 uppercase, 1 lowercase, 1 number
    if(isValidPassword($pass) == false) {
        header("Location: add_admin.php?error=invalidpassword");
        exit;
    }

    if ($pass != $confirm) {
        header("Location: add_admin.php?error=passwordcheck");
        exit;
    }

    $hash_pass = password_hash($pass, PASSWORD_DEFAULT);

    $sql = mysqli_prepare($conn, "SELECT * FROM admin WHERE email=?");
    mysqli_stmt_bind_param($sql, "s", $email);
    mysqli_stmt_execute($sql);
    $result = mysqli_stmt_get_result($sql);
    if (mysqli_num_rows($result) > 0) {
        header("Location: add_admin.php?error=emailtaken");
        exit;
    }

    $sql = mysqli_prepare($conn, "INSERT INTO admin(email,password_hash) VALUES(?,?)");
    mysqli_stmt_bind_param($sql, "ss",$email, $hash_pass);
    if (!mysqli_stmt_execute($sql)) {
        echo "Error inserting data: " . mysqli_error($conn);
        exit;
    }

    header("Location: admin_page.php?success=addedadmin");
}
