<?php
session_start();

if (isset($_POST["submit"])) {
    include 'db_config.php';

    $email = $_POST["email"];
    $pass = $_POST["pass"];

    if (!isset($email) || !isset($pass)) {
        die("Please fill all the fields");
    }

    if (empty($email) || empty($pass)) {
        die("Please fill all the fields");
    }

    //funzione che controlla validita email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email");
    }


    $sql = mysqli_prepare($conn, "SELECT * FROM users WHERE email=?");
    mysqli_stmt_bind_param($sql, "s", $email);
    mysqli_stmt_execute($sql);
    $result = mysqli_stmt_get_result($sql);
    if (mysqli_num_rows($result) == 0) {
        header("Location: login_page.php?user=notfound");
        exit;
    }

    //prende una riga alla volta del risultato della query
    $row = mysqli_fetch_assoc($result);
    $hash_pass = $row["password_hash"];

    if (password_verify($pass, $hash_pass)) {
        $sql = mysqli_prepare($conn, "SELECT id FROM users WHERE email=?");
        mysqli_stmt_bind_param($sql, "s", $email);
        mysqli_stmt_execute($sql);
        $result = mysqli_stmt_get_result($sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row["id"];

        $_SESSION["email"] = $email;
        $_SESSION["db_id"] = $id;//email non univoca quindi prendo id utente univoco

        header("Location: show_profile.php");
        exit;
    } else {
        header("Location: login_page.php?error=wrongpassword");
        exit;
    }
}
