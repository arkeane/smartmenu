<?php
session_start();

include '../db_config.php';

if (!isset($_SESSION["email"])) {
    header("Location: ../login_page.php?error=notloggedin");
}

$sql = mysqli_prepare($conn, "DELETE FROM menus WHERE id=?");
mysqli_stmt_bind_param($sql, "i", $_SESSION['menu_id']);
mysqli_stmt_execute($sql);
if (mysqli_stmt_errno($sql) != 0) {
    echo "Error deleting data: " . mysqli_stmt_error($sql);
    exit;
}

unset($_SESSION['menu_id']);
header("Location: ../show_profile.php");
