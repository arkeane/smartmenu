<?php
session_start();

if (isset($_POST["submit"])) {
    include '../db_config.php';

    $email = $_POST["email"];
    $pass = $_POST["pass"];

    if (!isset($email) || !isset($pass) || empty($email) || empty($pass)) {
        die("Please fill all the fields");
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email");
    }

    $sql = mysqli_prepare($conn, "SELECT * FROM admin WHERE email=?");
    mysqli_stmt_bind_param($sql, "s", $email);
    mysqli_stmt_execute($sql);
    $result = mysqli_stmt_get_result($sql);
    if (mysqli_num_rows($result) == 0) {
        header("Location: admin_login_page.php?admin=notadmin");
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    $hash_pass = $row["password_hash"];

    if (password_verify($pass, $hash_pass)) {
        $id = $row["id"];

        $_SESSION["email"] = $email;
        $_SESSION["db_id"] = $id;
        $_SESSION["admin"] = true;

        header("Location: admin_page.php");
        exit;
    } else {
        header("Location: admin_login_page.php?error=wrongadminpassword");
        exit;
    }
}
