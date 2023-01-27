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

    if(empty($_POST['title']) || empty($_POST['content']) || !isset($_POST['title']) || !isset($_POST['content'])) {
        header("Location: edit_post.php?error=emptyfields");
        exit;
    }

    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = date("Y-m-d H:i:s");

    $sql = mysqli_prepare($conn, "INSERT INTO blog (title, content, post_date) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($sql, "sss", $title, $content, $date);
    if(!mysqli_stmt_execute($sql)) {
        header("Location: edit_post.php?error=sqlerror");
        exit;
    }

    header("Location: ../admin/admin_page.php?success=addedpost");
}