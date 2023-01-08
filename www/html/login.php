<?php
session_start();

if (isset($_POST["submit"])) {
    include 'db_config.php';

    $email = $_POST["email"];
    $pass = $_POST["pass"];

    if (empty($email) || empty($pass)) {
        echo "Please fill all the fields";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email";
        exit;
    }

    $email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        header("Location: login_page.php?user=notfound");
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    $hash_pass = $row["password_hash"];

    if (password_verify($pass, $hash_pass)) {
        $sql = "SELECT id FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row["id"];

        $_SESSION["email"] = $email;
        $_SESSION["db_id"] = $id;

        header("Location: show_profile.php");
        exit;
    } else {
        header("Location: login_page.php?error=wrongpassword");
        exit;
    }
}
