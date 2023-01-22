<?php
session_start();

include '../db_config.php';

if (!isset($_SESSION["email"])) {
    header("Location: ../login_page.php?error=notloggedin");
}

if(isset($_GET['product_id'])){
    // delete product
    $product_id = $_GET['product_id'];
    $sql = mysqli_prepare($conn, "DELETE FROM products WHERE id=?");
    mysqli_stmt_bind_param($sql, "i", $product_id);
    mysqli_stmt_execute($sql);
    if (mysqli_stmt_errno($sql) != 0) {
        echo "Error deleting data: " . mysqli_stmt_error($sql);
        exit;
    }

    header("Location: edit_menu.php?menu_id=$_SESSION[menu_id]");
}
