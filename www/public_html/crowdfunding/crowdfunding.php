<?php

include '../db_config.php';

session_start();

if (!isset($_SESSION["email"])) {
    header("Location: ../login_page.php?error=notloggedin");
}

if (!isset($_SESSION["admin"])) {
    header("Location: ../login_page.php");
}

if (isset($_POST['submit'])) {

    if (empty($_POST['title']) || empty($_POST['description']) || empty($_POST['goal']) || empty($_POST['end_date']) || !isset($_POST['title']) || !isset($_POST['description']) || !isset($_POST['goal']) || !isset($_POST['end_date'])) {
        header("Location: create_crowdfunding.php?error=emptyfields");
        exit;
    }

    $title = $_POST['title'];
    $description = $_POST['description'];
    $goal = $_POST['goal'];
    $end_date = $_POST['end_date'];
    $current_amount = 0;
    $success = false;


    $sql = mysqli_prepare($conn, "INSERT INTO crowdfunding (title, description, goal, current_amount, end_date, success) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($sql, "ssiisi", $title, $description, $goal, $current_amount, $end_date, $success);
    if (!mysqli_stmt_execute($sql)) {
        header("Location: create_crowdfunding.php?error=sqlerror");
        exit;
    }

    header("Location: ../admin/admin_page.php?success=createCrowdFunding");
}
