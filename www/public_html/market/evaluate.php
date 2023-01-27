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

    $sql = mysqli_prepare($conn, "SELECT * FROM bought_templates WHERE template_id = ? AND restaurant_id = ?");
    mysqli_stmt_bind_param($sql, "ii", $_POST["template_id"], $_SESSION["db_id"]);
    mysqli_stmt_execute($sql);
    $result = mysqli_stmt_get_result($sql);
    if (mysqli_num_rows($result) == 0) {
        header("location: ../market/market.php?error=notbought");
        exit;
    }

    $sql = mysqli_prepare($conn, "SELECT * FROM evaluations WHERE template_id = ? AND restaurant_id = ?");
    mysqli_stmt_bind_param($sql, "ii", $_POST["template_id"], $_SESSION["db_id"]);
    mysqli_stmt_execute($sql);
    $result = mysqli_stmt_get_result($sql);
    if (mysqli_num_rows($result) > 0) {
        header("location: ../market/market.php?error=alreadyrated");
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

    $sql = mysqli_prepare($conn, "INSERT INTO evaluations(restaurant_id,template_id,rating) VALUES(?,?,?)");
    mysqli_stmt_bind_param($sql, "iii", $user_id, $template_id, $rating);
    if (!mysqli_stmt_execute($sql)) {
        echo "Error inserting data: " . mysqli_error($conn);
        exit;
    }

    header("location: ../market/market.php");
}
