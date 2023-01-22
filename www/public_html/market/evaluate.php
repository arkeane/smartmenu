<?php

session_start();
include '../db_config.php';

if (!isset($_SESSION["email"])) {
    header("location: ../login_page.php?error=notloggedin");
    exit;
}

if (isset($_POST["submitrating"])) {
    if (!isset($_POST["template_id"]) || !isset($_POST["rating"])) {
        header("location: ../market/market.php?error=invalidrating");
        exit;
    }

    $template_id = $_POST["template_id"];
    $rating = $_POST["rating"];
    $user_id = $_SESSION["db_id"];

    // check if rating is number
    if (!is_numeric($rating)) {
        header("location: ../market/market.php?error=invalidrating");
        exit;
    }

    // if rating is bigger than 5 or smaller than 1
    if ($rating > 5) {
        $rating = 5;
    } else if ($rating < 1) {
        $rating = 1;
    }

    $template_id = mysqli_real_escape_string($conn, $template_id);
    $rating = mysqli_real_escape_string($conn, $rating);

    $sql = mysqli_prepare($conn, "INSERT INTO evaluations(restaurant_id,template_id,rating) VALUES(?,?,?)");
    mysqli_stmt_bind_param($sql, "iii", $user_id, $template_id, $rating);
    if (!mysqli_stmt_execute($sql)) {
        echo "Error inserting data: " . mysqli_error($conn);
        exit;
    }

    header("location: ../market/market.php");
}
