<?php
session_start();
//insert blog comment into database
if (isset($_POST['submit']) || !empty($_POST['submit'])) {
    
    include '../db_config.php';
    
    if (!isset($_SESSION["email"])) {
        header("Location: ../login_page.php?error=notloggedin");
    }


    if(empty($_POST['comment']) || !isset($_POST['comment'])) {
        header("Location: show_blog.php?error=emptyfields");
        exit;
    }

    $comment = $_POST['comment'];
    $date= date("Y-m-d H:i:s");
    $post_id = $_POST['submit'];

    if(isset($_SESSION["admin"])) {
        $id=0;
        $sql = mysqli_prepare($conn, "INSERT INTO blog_comments ( blog_id, restaurant_id, comment, comment_date) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($sql, "iiss", $post_id, $id, $comment, $date);
        if(!mysqli_stmt_execute($sql)) {
            header("Location: show_blog.php?error=sqlerror");
            exit;
        }

    }else {
        $sql = mysqli_prepare($conn, "SELECT id FROM users WHERE email=?");
        mysqli_stmt_bind_param($sql, "s", $_SESSION["email"]);
        mysqli_stmt_execute($sql);
        $result = mysqli_stmt_get_result($sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row["id"];

        $sql = mysqli_prepare($conn, "INSERT INTO blog_comments ( blog_id, restaurant_id, comment, comment_date) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($sql, "iiss", $post_id, $id, $comment, $date);
        if(!mysqli_stmt_execute($sql)) {
            header("Location: show_blog.php?error=sqlerror");
            exit;
        }
    }

    header("Location: show_blog.php");
}
